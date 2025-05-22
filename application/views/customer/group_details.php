<div class="container-fluid mt-4">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <h2 class="mb-4 text-center">Customers in Group</h2>

    <?php if ($role_id == 1): ?>
    <div class="mb-3">
        <a href="<?= base_url('index.php/customer/add_customer/' . $group_id) ?>" class="btn btn-success">
            <i class="fa fa-plus"></i> Add New Customer
        </a>
        <!-- <a href="<?= base_url('index.php/customer/check_service_end_dates') ?>"
           class="btn btn-primary"
           onclick="return confirm('Send end-of-service notifications for all due customers?');">
           <i class="fa fa-envelope"></i> Send All End Notifications
        </a>
        < Tombol Manual Test Email -->
        <!-- <!-- <a href="<?= base_url('index.php/customer/test_email') ?>"
           class="btn btn-info"
           onclick="return confirm('Send test email?');">
           <i class="fa fa-paper-plane"></i> Test Email
        </a> -->
    </div>
<?php endif; ?>


    <?php if (!empty($customers)): ?>
        <?php
        // Group by customer|supplier to avoid duplicate cid_supp
        $grouped = [];
        foreach ($customers as $c) {
            $key = $c->customer . '|' . $c->nama_supplier;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [];
            }
            if (!in_array($c->cid_supp, array_column($grouped[$key], 'cid_supp'))) {
                $grouped[$key][] = $c;
            }
        }
        ?>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Customer</th>
                            <th>Supplier</th>
                            <th>SID Supplier</th>
                            <th>SID Customer</th>
                            <th>SLA Customer</th>
                            <th>Service Type</th>
                            <th>Deskripsi</th>
                            <th>Contact</th>
                            <th>Network</th>
                            <th>SO</th>
                            <th>SDN</th>
                            <th>Topology</th>
                            <th>Status</th>
                            <?php if ($role_id == 1 || $role_id == 2): ?>
                                <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                    <?php foreach ($grouped as $key => $items):
                        list($custName, $suppName) = explode('|', $key);
                        $first = true;
                        $rowCount = count($items);
                    ?>
                        <?php foreach ($items as $cust):
                            // Determine status
                            $today = new DateTime();
                            $status_label = 'Unknown';
                            $status_class = 'btn-secondary';
                            switch ($cust->status) {
                                case 1:
                                    $status_label = 'Active';
                                    $status_class = 'btn-success';
                                    break;
                                case 2:
                                    $status_label = 'Suspend';
                                    $status_class = 'btn-warning';
                                    break;
                                case 3:
                                    $end = (new DateTime($cust->end_date))->modify('+1 day');
                                    if ($today > $end) {
                                        $status_label = 'Terminated';
                                        $status_class = 'btn-dark';
                                    } else {
                                        $status_label = 'Inactive';
                                        $status_class = 'btn-danger';
                                    }
                                    break;
                                case 4:
                                    $status_label = 'Terminated';
                                    $status_class = 'btn-dark';
                                    break;
                            }
                        ?>
                        <tr>
                            <?php if ($first): ?>
                                <td rowspan="<?= $rowCount ?>"><?= htmlspecialchars($custName) ?></td>
                                <td rowspan="<?= $rowCount ?>"><?= htmlspecialchars($suppName) ?></td>
                                <?php $first = false; ?>
                            <?php endif; ?>

                            <td><?= htmlspecialchars($cust->cid_supp) ?></td>
                            <td><?= htmlspecialchars($cust->cid_abh) ?></td>
                             <!-- SLA Customer -->
                            <td><?= htmlspecialchars($cust->sla) ?>%</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#fileModal"
                                        onclick="loadServiceTypeDescription('<?= $cust->service_type_id ?>', '<?= htmlspecialchars($cust->service_type_name) ?>')">
                                    <?= htmlspecialchars($cust->service_type_name) ?>
                                </button>
                            </td>
                            <td><?= htmlspecialchars($cust->deskripsi) ?></td>
                            <td><?= htmlspecialchars($cust->contact) ?></td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#networkModal<?= $cust->id ?>">
                                    Network
                                    </button>
                                </td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#fileModal"
                                        onclick="loadFile('<?= base_url('uploads/' . $cust->no_so) ?>', 'Sales Order (SO)')">
                                    View SO
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#fileModal"
                                        onclick="loadFile('<?= base_url('uploads/' . $cust->no_sdn) ?>', 'Service Delivery Note (SDN)')">
                                    View SDN
                                </button>
                            </td>
                            <td>
                                <!-- Topology column re-added -->
                                <button class="btn btn-outline-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#fileModal"
                                        onclick="loadFile('<?= base_url('uploads/' . $cust->topology) ?>', 'Topology Document')">
                                    View Topology
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-sm <?= $status_class ?>">
                                    <?= $status_label ?>
                                </button>
                            </td>

                            <?php if ($role_id == 1 || $role_id == 2): ?>
                                <td>
                                <button type="button"
                                                    class="btn btn-warning btn-sm btn-notify-termination"
                                                    data-id="<?= $cust->id ?>"
                                                    data-customer="<?= htmlspecialchars($cust->customer) ?>"
                                                    title="Notify Termination">
                                            <i class="fa fa-envelope"></i>
                                 </button>
                                    <a href="<?= base_url('index.php/customer/edit_customer/' . $cust->id) ?>"
                                       class="btn btn-secondary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('index.php/customer/delete_customer/' . $cust->id) ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete <?= htmlspecialchars($cust->customer) ?>?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                    <div class="modal fade" id="networkModal<?= $cust->id ?>" tabindex="-1" ...>
                            <div class="modal-dialog"><div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Network Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-start">
                                <p><strong>VLAN:</strong> <?= htmlspecialchars($cust->vlan) ?></p>
                                <p><strong>IP Address:</strong> <?= htmlspecialchars($cust->ip_address) ?></p>
                                <p><strong>Prefix:</strong> <?= htmlspecialchars($cust->prefix) ?></p>
                                <p><strong>Cross Connect ID:</strong> <?= htmlspecialchars($cust->xconnect_id) ?></p>
                                </div>
                                <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div></div>
                            </div>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <p class="text-muted">No customers found in this group.</p>
    <?php endif; ?>
</div>
</div>
<!-- File View Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="fileModalLabel">Document Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="fileContent">
                <p class="text-muted">Loading content…</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- 1) Modal Confirm Notify -->
<div class="modal fade" id="terminationModal" tabindex="-1" aria-labelledby="terminationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="terminationModalLabel">Confirm Termination</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="terminationModalBody">Are you sure want to send termination notification?</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirmTerminateBtn" class="btn btn-warning">
          Kirim Notifikasi
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- 2) Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="emailToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="emailToastBody"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<script>
  const BASE_URL = '<?= rtrim(base_url(), '/') ?>/';
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // 1) Document Viewer (SO/SDN/Topology)
  window.loadFile = function(filename, title) {
    const url     = BASE_URL + 'uploads/' + filename;
    const label   = document.getElementById('fileModalLabel');
    const content = document.getElementById('fileContent');
    label.textContent   = title;
    content.innerHTML   = `
      <iframe src="${url}" style="width:100%;height:500px;border:0;"></iframe>
      <p class="mt-3 text-center">
        <a href="${url}" target="_blank" class="btn btn-outline-secondary">
          Download ${title}
        </a>
      </p>`;
  };

  // 2) Service-Type Description (gunakan modal yang sama)
  window.loadServiceTypeDescription = function(id, name) {
    const url     = BASE_URL + 'index.php/customer/get_service_type_description/' + id;
    const label   = document.getElementById('fileModalLabel');
    const content = document.getElementById('fileContent');
    label.textContent = 'Service Type: ' + name;
    fetch(url)
      .then(res => res.text())
      .then(html => content.innerHTML = html)
      .catch(() => content.innerHTML = '<p class="text-danger">Failed to load description.</p>');
  };

  // 3) Termination-Notification
  const terminationModalEl = document.getElementById('terminationModal');
  if (terminationModalEl) {
    const terminationModal = new bootstrap.Modal(terminationModalEl);
    const toastEl          = document.getElementById('emailToast');
    const toastBody        = document.getElementById('emailToastBody');
    const toast            = new bootstrap.Toast(toastEl);
    let currentCustomerId  = null;

    document.querySelectorAll('.btn-notify-termination').forEach(btn => {
      btn.addEventListener('click', () => {
        currentCustomerId = btn.dataset.id;
        const custName    = btn.dataset.customer;
        document.getElementById('terminationModalLabel').textContent = 'Notify Termination: ' + custName;
        document.getElementById('terminationModalBody').textContent  = `Kirim email notifikasi terminasi untuk "${custName}"?`;
        terminationModal.show();
      });
    });

    const confirmBtn = document.getElementById('confirmTerminateBtn');
    if (confirmBtn) {
      confirmBtn.addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

        fetch(BASE_URL + 'index.php/customer/notify_termination/' + currentCustomerId, {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
          terminationModal.hide();
          this.disabled = false;
          this.innerHTML = 'Kirim Notifikasi';
          toastEl.classList.replace('bg-danger', 'bg-success');
          toastBody.textContent = data.message;
          toast.show();
        })
        .catch(() => {
          terminationModal.hide();
          this.disabled = false;
          this.innerHTML = 'Kirim Notifikasi';
          toastEl.classList.replace('bg-success', 'bg-danger');
          toastBody.textContent = 'Error mengirim notifikasi';
          toast.show();
        });
      });
    }
  }
});
</script>
