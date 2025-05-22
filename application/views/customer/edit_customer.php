<div class="container-fluid">
    <h2>Edit Customer</h2>
    <form action="<?= base_url('index.php/customer/update_customer/' . $customer->id); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="group_id" value="<?= $customer->customer_group_id; ?>">

        <!-- Customer Name -->
        <div class="mb-3">
            <label for="customer" class="form-label">Customer Name</label>
            <input type="text" class="form-control" name="customer" value="<?= $customer->customer; ?>" required>
        </div>

        <!-- Supplier -->
        <div class="mb-3">
            <label for="kdsupplier" class="form-label">Supplier</label>
            <select class="form-control" name="kdsupplier" required>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?= $supplier->kdsupplier; ?>" <?= $supplier->kdsupplier == $customer->kdsupplier ? 'selected' : ''; ?>>
                        <?= $supplier->nama_supplier; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- SID Supplier -->
        <div class="mb-3">
            <label for="cid_supp" class="form-label">SID Supplier</label>
            <select class="form-control" name="cid_supp" required>
                <!-- show current -->
                <option value="<?= $customer->cid_supp; ?>" selected><?= $customer->cid_supp; ?></option>
                <?php if (!empty($unused_cid_suppliers)): ?>
                    <?php foreach ($unused_cid_suppliers as $cid_supplier): ?>
                        <option value="<?= $cid_supplier->cid_supplier; ?>"><?= $cid_supplier->cid_supplier; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- SID Customer -->
        <div class="mb-3">
            <label for="cid_abh" class="form-label">SID Customer</label>
            <input type="text" class="form-control" name="cid_abh" value="<?= $customer->cid_abh; ?>" required>
        </div>

        <!-- SLA Customer -->
        <div class="mb-3">
            <label for="sla" class="form-label">SLA Customer (%)</label>
            <input type="number" class="form-control" name="sla" min="0" max="100" value="<?= $customer->sla; ?>" required>
        </div>

        <!-- Service Type -->
        <div class="mb-3">
            <label for="service_type_id" class="form-label">Service Type</label>
            <select class="form-control" name="service_type_id" required>
                <?php foreach ($service_types as $service_type): ?>
                    <option value="<?= $service_type->id; ?>" <?= $service_type->id == $customer->service_type_id ? 'selected' : ''; ?>>
                        <?= $service_type->service_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="2"><?= htmlspecialchars($customer->deskripsi); ?></textarea>
        </div>

        <!-- Contact -->
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" name="contact" value="<?= htmlspecialchars($customer->contact); ?>">
        </div>

        <!-- VLAN -->
        <div class="mb-3">
            <label for="vlan" class="form-label">VLAN</label>
            <input type="text" class="form-control" name="vlan" value="<?= htmlspecialchars($customer->vlan); ?>">
        </div>

        <!-- IP Address -->
        <div class="mb-3">
            <label for="ip_address" class="form-label">IP Address</label>
            <input type="text" class="form-control" name="ip_address" value="<?= htmlspecialchars($customer->ip_address); ?>">
        </div>

        <!-- Prefix -->
        <div class="mb-3">
            <label for="prefix" class="form-label">Prefix</label>
            <input type="text" class="form-control" name="prefix" value="<?= htmlspecialchars($customer->prefix); ?>">
        </div>

        <!-- Cross Connect ID -->
        <div class="mb-3">
            <label for="xconnect_id" class="form-label">Cross Connect ID</label>
            <input type="text" class="form-control" name="xconnect_id" value="<?= htmlspecialchars($customer->xconnect_id); ?>">
        </div>

        <!-- Start Date -->
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" value="<?= $customer->start_date; ?>" required>
        </div>

        <!-- End Date -->
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" value="<?= $customer->end_date; ?>" required>
        </div>

        <!-- Sales Order (SO) -->
        <div class="mb-3">
            <label for="no_so" class="form-label">Sales Order (SO)</label>
            <input type="file" class="form-control" name="no_so">
            <?php if (!empty($customer->no_so)): ?>
                <small>Current file: <?= $customer->no_so; ?></small>
            <?php endif; ?>
        </div>

        <!-- Service Delivery Note (SDN) -->
        <div class="mb-3">
            <label for="no_sdn" class="form-label">Service Delivery Note (SDN)</label>
            <input type="file" class="form-control" name="no_sdn">
            <?php if (!empty($customer->no_sdn)): ?>
                <small>Current file: <?= $customer->no_sdn; ?></small>
            <?php endif; ?>
        </div>

        <!-- Topology Document -->
        <div class="mb-3">
            <label for="topology" class="form-label">Topology Document</label>
            <input type="file" class="form-control" name="topology">
            <?php if (!empty($customer->topology)): ?>
                <small>Current file: <?= $customer->topology; ?></small>
            <?php endif; ?>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" name="status" required>
                <option value="1" <?= $customer->status == 1 ? 'selected' : ''; ?>>Active</option>
                <option value="2" <?= $customer->status == 2 ? 'selected' : ''; ?>>Suspend</option>
                <option value="3" <?= $customer->status == 3 ? 'selected' : ''; ?>>Inactive</option>
                <option value="4" <?= $customer->status == 4 ? 'selected' : ''; ?>>Terminated</option>
            </select>
        </div>

        <!-- Submit / Cancel -->
        <button type="submit" class="btn btn-primary">Update Customer</button>
        <a href="<?= base_url('index.php/customer/group_details/' . $customer->customer_group_id); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
