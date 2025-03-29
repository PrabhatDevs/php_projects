<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');
// include_once base_path('admin/app/controller/admin/index.php');
?>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Dashboard</h2>
            <hr>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Customers</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1"><?= $customer_count ?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-user fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Drivers</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1"><?= $driver_count ?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-id-card fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Success Delivery</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1"><?= $delivery_count ?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-check-circle fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Platforms</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1"><?= $platform_count ?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-globe fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Pending Packages</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1"><?= $pending_package ?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-shopping-cart fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Revenue</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1">$<?= number_format($revenue, 2) ?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-dollar-sign fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
            <div class="card-body">
                <h5 class="text-muted">Paid Subscribers</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-1"><?=$paid_count?></h1>
                    <div class="p-3 bg-primary rounded-2 text-white">
                        <i class="fa fa-dollar-sign fs-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Customers</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td><?=$user['full_name']?></td>
                                <td><?=$user['email']?></td>
                                <td><?=$user['phone_number']?></td>
                                <td><?=date('d M Y',strtotime($user['created_at']))?></td>
                            </tr>
                            <?php endforeach; ?>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--/ Card Border Shadow -->

<!-- Footer -->
<?php include_once base_path('app/Views/layouts/footer.php'); ?>