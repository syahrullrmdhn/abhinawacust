<div class="container-fluid">
    <h2>Add New Customer</h2>
    <form action="<?= base_url('index.php/customer/store_customer'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="group_id" value="<?= $group_id; ?>">

        <!-- Customer Name Field -->
        <div class="mb-3">
            <label for="customer" class="form-label">Customer Name</label>
            <input type="text" class="form-control" name="customer" required>
        </div>

        <!-- Supplier Selection with kdsupplier -->
        <div class="mb-3">
            <label for="kdsupplier" class="form-label">Supplier</label>
            <select class="form-control" name="kdsupplier" required>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?= $supplier->kdsupplier; ?>"><?= $supplier->nama_supplier; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- CID Supplier Field -->
        <div class="mb-3">
            <label for="cid_supp" class="form-label">SID Supplier</label>
            <select class="form-control" name="cid_supp" required>
                <?php foreach ($suppliers as $supplier): ?>
                    <?php if (!empty($supplier_cid[$supplier->kdsupplier])): ?>
                        <?php foreach ($supplier_cid[$supplier->kdsupplier] as $cid): ?>
                            <option value="<?= $cid->cid_supplier; ?>"><?= $cid->cid_supplier; ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No available SID suppliers</option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- CID Abh Field -->
        <div class="mb-3">
            <label for="cid_abh" class="form-label">SID Customer</label>
            <input type="text" class="form-control" name="cid_abh" required>
        </div>

        <!-- SLA Customer -->
        <div class="mb-3">
            <label for="sla" class="form-label">SLA Customer (%)</label>
            <input type="number" class="form-control" name="sla" min="0" max="100" required>
        </div>

        <!-- Service Type Selection -->
        <div class="mb-3">
            <label for="service_type_id" class="form-label">Service Type</label>
            <select class="form-control" name="service_type_id" required>
                <?php foreach ($service_types as $service_type): ?>
                    <option value="<?= $service_type->id; ?>"><?= $service_type->service_name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="2"></textarea>
        </div>

        <!-- Contact -->
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" name="contact">
        </div>

        <!-- VLAN -->
        <div class="mb-3">
            <label for="vlan" class="form-label">VLAN</label>
            <input type="number" class="form-control" name="vlan">
        </div>

        <!-- IP Address -->
        <div class="mb-3">
            <label for="ip_address" class="form-label">IP Address</label>
            <input type="text" class="form-control" name="ip_address">
        </div>

        <!-- Prefix -->
        <div class="mb-3">
            <label for="prefix" class="form-label">Prefix</label>
            <input type="text" class="form-control" name="prefix">
        </div>

        <!-- Cross Connect ID -->
        <div class="mb-3">
            <label for="xconnect_id" class="form-label">Cross Connect ID</label>
            <input type="text" class="form-control" name="xconnect_id">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" name="status" required>
                <option value="1">Active</option>
                <option value="2">Suspend</option>
                <option value="3">Inactive</option>
                <option value="4">Terminated</option>
            </select>
        </div>

        <!-- Start Date Field -->
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" required>
        </div>

        <!-- End Date Field -->
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" required>
        </div>

        <!-- File Upload for No SO -->
        <div class="mb-3">
            <label for="no_so" class="form-label">No SO (PDF) (Optional)</label>
            <input type="file" class="form-control" name="no_so" accept="application/pdf">
        </div>

        <!-- File Upload for SDN -->
        <div class="mb-3">
            <label for="no_sdn" class="form-label">SDN (PDF)</label>
            <input type="file" class="form-control" name="no_sdn" accept="application/pdf">
        </div>

        <!-- File Upload for Topology -->
        <div class="mb-3">
            <label for="topology" class="form-label">Topology (PDF)</label>
            <input type="file" class="form-control" name="topology" accept="application/pdf">
        </div>
        
        <!-- Form Submit and Cancel Buttons -->
        <button type="submit" class="btn btn-primary">Add Customer</button>
        <a href="<?= base_url('index.php/customer/group_details/' . $group_id); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
