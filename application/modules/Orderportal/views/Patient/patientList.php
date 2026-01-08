<!-- Start right Content here -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-content-inner">
                        <div class="card" id="userList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0 text-black">Person List</h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <a class="btn btn-success btn" href="<?php echo base_url('Orderportal/Patient/onboardingForm') ?>">
                                            <i class="ri-add-line align-bottom me-1"></i> Add Person
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#activeTab" role="tab">Active</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#dischargedTab" role="tab">Discharged</a>
                                </li>
                            </ul>


                            <!-- Table Content -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="activeTab" role="tabpanel">
                                          <table class="table table-striped align-middle" id="customerTable">
    <thead class="table-dark text-white">
        <tr>
            <th class="sort" data-sort="name">Name</th>
            <th class="sort" data-sort="floor">Floor Name</th>
            <th class="sort" data-sort="suite">Suite No</th>
            <th class="sort" data-sort="allergens">Dietary Restrictions</th>
            <th class="sort" data-sort="instructions">Special Instructions</th>
            <th class="no-sort">Date Onboarded</th>
            <th class="no-sort">Date of Discharge</th>
            <th class="no-sort">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($customerLists as $customer): ?>
            <?php if($customer['status'] == '1'): ?>
                <tr id="row_<?php echo $customer['id']; ?>">
                    <?php 
                        // Floor name
                        $floorname = array_filter($floors, function ($floor) use ($customer) {
                            return $customer['floor_number'] == $floor['id'];
                        });
                        $floorNameDisplay = !empty($floorname) ? reset($floorname)['name'] : 'Unknown Floor';

                        // Suite
                        $suite_number = array_filter($suites, function($suite) use ($customer) {
                            return $customer['suite_number'] == $suite['id'];
                        });
                        $suite = array_values($suite_number);

                        // Decode allergies (support JSON or CSV)
                        $selected_allergies = [];
                        if (!empty($customer['allergies'])) {
                            $selected_allergies = is_array(json_decode($customer['allergies'], true)) 
                                ? json_decode($customer['allergies'], true) 
                                : explode(',', $customer['allergies']);
                        }

                        // Get allergen names
                        $allergyNames = [];
                        foreach ($allergies as $allergy) {
                            if (in_array($allergy['id'], $selected_allergies)) {
                                $allergyNames[] = $allergy['name'];
                            }
                        }
                    ?>
                    <td data-sort="<?php echo strtolower($customer['name']); ?>"><?php echo $customer['name']; ?></td>
                    <td data-sort="<?php echo strtolower($floorNameDisplay); ?>"><?php echo $floorNameDisplay; ?></td>
                    <td data-sort="<?php echo strtolower($suite[0]['bed_no'] ?? ''); ?>"><?php echo $suite[0]['bed_no'] ?? ''; ?></td>
                    <td data-sort="<?php echo strtolower(implode(', ', $allergyNames)); ?>">
                        <?php if (!empty($allergyNames)): ?>
                            <span class="badge bg-secondary">
                                <?= implode('</span> <span class="badge bg-secondary">', $allergyNames); ?>
                            </span>
                        <?php else: ?>
                            <span class="text-muted">None</span>
                        <?php endif; ?>
                    </td>
                    <td data-sort="<?php echo strtolower($customer['special_instructions']); ?>"><?php echo $customer['special_instructions']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($customer['date_onboarded'])); ?></td>
                    <td>
                        <?php if (!empty($customer['date_of_discharge'])): ?>
                            <?php echo date('d/m/Y', strtotime($customer['date_of_discharge'])); ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="edit">
                                <a href="<?php echo base_url('Orderportal/Patient/onboardingForm/' . $customer['id']); ?>" class="btn btn btn-secondary edit-item-btn">
                                    <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>View/Edit
                                </a>
                            </div>
                            <?php if($this->session->userdata('role_id') != 3) { 
                                // Hide Remove button for nurses
                            ?>
                            <div class="remove">
                                <button class="btn btn btn-danger remove-item-btn" data-rel-id="<?php echo $customer['id']; ?>">
                                    <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Remove
                                </button>
                            </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

                                        </div>

                                        <!-- Discharged Tab -->
                                        <div class="tab-pane fade" id="dischargedTab" role="tabpanel">
                                            <table class="table table-striped align-middle" id="dischargedTable">
                                                <thead class="table-dark text-white">
                                                    <tr>
                                                        <th class="sort" data-sort="name">Name</th>
                                                        <th class="sort" data-sort="floor">Floor Name</th>
                                                        <th class="sort" data-sort="suite">Suite No</th>
                                                        <th class="sort" data-sort="allergens">Allergens</th>
                                                        <th class="sort" data-sort="instructions">Special Instructions</th>
                                                        <th class="no-sort">Date Onboarded</th>
                                                        <th class="no-sort">Date Discharged</th>
                                                        <th class="no-sort">Actions</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php foreach($customerLists as $customer): ?>
                                                        <?php if($customer['status'] == '2'): ?>
                                                            <tr id="row_<?php echo $customer['id']; ?>">
                                                                <?php 
                                                                    // Floor name lookup for discharged patients
                                                                    $floorname = array_filter($floors, function ($floor) use ($customer) {
                                                                        return $customer['floor_number'] == $floor['id'];
                                                                    });
                                                                    $floorNameDisplay = !empty($floorname) ? reset($floorname)['name'] : 'Unknown Floor';

                                                                    // Suite lookup for discharged patients
                                                                    $suite_number = array_filter($suites, function($suite) use ($customer) {
                                                                        return $customer['suite_number'] == $suite['id'];
                                                                    });
                                                                    $suite = array_values($suite_number);

                                                                    // Decode allergies for discharged patients
                                                                    $selected_allergies = [];
                                                                    if (!empty($customer['allergies'])) {
                                                                        $selected_allergies = is_array(json_decode($customer['allergies'], true)) 
                                                                            ? json_decode($customer['allergies'], true) 
                                                                            : explode(',', $customer['allergies']);
                                                                    }

                                                                    // Get allergen names for discharged patients
                                                                    $allergyNames = [];
                                                                    foreach ($allergies as $allergy) {
                                                                        if (in_array($allergy['id'], $selected_allergies)) {
                                                                            $allergyNames[] = $allergy['name'];
                                                                        }
                                                                    }
                                                                ?>
                                                                <td data-sort="<?php echo strtolower($customer['name']); ?>"><?php echo $customer['name']; ?></td>
                                                                <td data-sort="<?php echo strtolower($floorNameDisplay); ?>"><?php echo $floorNameDisplay; ?></td>
                                                                <td data-sort="<?php echo strtolower($suite[0]['bed_no'] ?? ''); ?>"><?php echo $suite[0]['bed_no'] ?? ''; ?></td>
                                                                <td data-sort="<?php echo strtolower(implode(', ', $allergyNames)); ?>">
                                                                    <?php if (!empty($allergyNames)): ?>
                                                                        <span class="badge bg-secondary">
                                                                            <?= implode('</span> <span class="badge bg-secondary">', $allergyNames); ?>
                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">None</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td data-sort="<?php echo strtolower($customer['special_instructions']); ?>"><?php echo $customer['special_instructions']; ?></td>
                                                                <td data-order="<?php echo strtotime($customer['date_onboarded']); ?>"><?php echo date('d/m/Y', strtotime($customer['date_onboarded'])); ?></td>
                                                                <td data-order="<?php echo !empty($customer['date_of_discharge']) ? strtotime($customer['date_of_discharge']) : 0; ?>"><?php echo !empty($customer['date_of_discharge']) ? date('d/m/Y', strtotime($customer['date_of_discharge'])) : '-'; ?></td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <div class="edit">
                                                                            <a href="<?php echo base_url('Orderportal/Patient/onboardingForm/' . $customer['id']); ?>" class="btn btn btn-secondary edit-item-btn">
                                                                                <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>View/Edit
                                                                            </a>
                                                                        </div>
                                                                        <?php if($this->session->userdata('role_id') != 3) { 
                                                                            // Hide Remove button for nurses
                                                                        ?>
                                                                        <div class="remove">
                                                                            <button class="btn btn btn-danger remove-item-btn" data-rel-id="<?php echo $customer['id']; ?>">
                                                                                <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Remove
                                                                            </button>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- tab-content -->
                                </div>
                            </div> <!-- card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    </div> <!-- container-fluid -->
</div> <!-- main-content -->

<style>
/* Fix DataTables UI Issues */

/* Fix show entries dropdown overlap */
.dataTables_length select {
    width: auto !important;
    min-width: 60px !important;
    padding-right: 30px !important;
    background-position: calc(100% - 8px) center !important;
    background-size: 12px !important;
}

/* Fix pagination colors with higher specificity */
.dataTables_wrapper .dataTables_paginate .paginate_button,
.dataTables_wrapper .dataTables_paginate .paginate_button a {
    color: #495057 !important;
    background: #fff !important;
    border: 1px solid #dee2e6 !important;
    padding: 0.5rem 0.75rem !important;
    margin: 0 2px !important;
    border-radius: 0.375rem !important;
    text-decoration: none !important;
    display: inline-block !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button:hover a {
    color: #fff !important;
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    text-decoration: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current a {
    color: #fff !important;
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    text-decoration: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled a {
    color: #6c757d !important;
    background: #fff !important;
    border-color: #dee2e6 !important;
    cursor: not-allowed !important;
    text-decoration: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover a {
    color: #6c757d !important;
    background: #fff !important;
    border-color: #dee2e6 !important;
}

/* Improve overall DataTables layout */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 1rem;
}

.dataTables_wrapper .dataTables_info {
    padding-top: 0.75rem;
    color: #6c757d;
}

.dataTables_wrapper .dataTables_paginate {
    padding-top: 0.75rem;
}

/* Ensure proper spacing */
.dataTables_wrapper .row {
    margin: 0;
}

.dataTables_wrapper .row > div {
    padding: 0 0.75rem;
}
</style>

<script>
$(document).ready(function () {
    // Common DataTable configuration
    const dataTableConfig = {
        pageLength: 25,
        bPaginate: true,
        bInfo: true,
        lengthMenu: [10, 25, 50, 100],
        "columnDefs": [
            {
                "targets": 'no-sort',
                "orderable": false
            }
        ],
        "order": [[ 2, "asc" ]], // Default sort by Suite No (column index 2)
        "initComplete": function() {
            $('.dataTables_filter input').attr('placeholder', 'Search clients...');
        }
    };

    // Initialize DataTable for the active customer table
    $('#customerTable').DataTable(dataTableConfig);
    
    // Initialize DataTable for the discharged customer table with custom sorting
    $('#dischargedTable').DataTable({
        pageLength: 25,
        bPaginate: true,
        bInfo: true,
        lengthMenu: [10, 25, 50, 100],
        "columnDefs": [
            {
                "targets": 'no-sort',
                "orderable": false
            }
        ],
        "order": [[ 6, "desc" ]], // Sort by Date Discharged (column index 6) descending - latest first
        "initComplete": function() {
            $('.dataTables_filter input').attr('placeholder', 'Search clients...');
        }
    });


    // Discharge Toggle
    $('.discharge-toggle').on('change', function () {
        let patientID = $(this).attr('id');
        let status = $(this).is(':checked') ? 'discharged' : 'active';

        $.ajax({
            type: "POST",
            url: "<?= base_url('Orderportal/Patient/updateStatus'); ?>",
            data: { id: patientID, status: status },
            success: function (response) {
                location.reload(); // Reload to reflect in correct tab
            }
        });
    });

    // Delete
    $('.remove-item-btn').on('click', function () {
        let id = $(this).data('rel-id');

        Swal.fire({
            title: "Are you sure?",
            text: "This client will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Orderportal/Patient/deletePatient'); ?>",
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() {
                                // Refresh the page to update both tables
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to delete client. Please try again.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
});
</script>

<script>

</script>

