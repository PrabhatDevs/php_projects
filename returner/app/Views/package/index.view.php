<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');
?>


<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Dashboard</h2>

            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"
                                class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Packages</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    
        <div class="card">
            <div class="m-3 card-title d-flex justify-content-between align-items-center">
                <h4 class="">All Packages</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="normal_table1">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Driver</th>
                            <th>Platform</th>
                            <th>Package Name</th>
                            <th>Dates</th>
                            <th>Created On</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $row): ?>
                            <tr>
                                <td class="text-capitalize"><?= $row['customer_name'] ?></td>
                                <td>
                                    <?php if ($row['driver_id']): ?>
                                        <a href="<?= base_url('user/show?driver_id=' . $row['driver_id']) ?>"><?= $row['driver_name'] ?></a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['platform_name'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td>
                                    <strong>Pickup:</strong> <?= date('d M Y', strtotime($row['pickup_date'])) ?><br>
                                    <strong>Start:</strong> <?= $row['pickup_start_time'] ?><br>
                                    <strong>End:</strong> <?= $row['pickup_end_time'] ?>
                                </td>
                                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                <td class="text-center">
                                    <a class="btn-sm btn btn-primary" href="<?= base_url('package/show?package_id=' . $row['id']) ?>"><i class="fa fa-eye"></i></a></td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#normal_table1').DataTable();
        });
    </script>


    <?php include_once base_path('app/Views/layouts/footer.php'); ?>