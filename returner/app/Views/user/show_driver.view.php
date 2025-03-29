<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');
?>

<div class="row">
    <div class="col-lg-5 col-md-12 mb-4 ">
        <div class="card p-4 ">
            <div class="row align-items-center ">
                <div class="col-md-4 col-12 d-flex justify-content-center mb-3 mb-md-0">
                    <img src="<?= $driver['profile_image']?? no_image() ?>" class="rounded-circle border border-3 border-danger"
                        width="120" height="120">
                </div>

                <div class="col-md-1 col-12 d-flex justify-content-center mb-3 mb-md-0">
                    <div class="vr h-100 d-none d-md-block"></div>
                </div>

                <div class="col-md-7 col-12 text-center text-md-start">
                    <h4 class="mb-1"><?= $driver['full_name'] ?></h4>
                    <p class="text-muted mb-2"><?= $driver['email'] ?? '' ?></p>
                    <p><i class="fa fa-phone"></i> <?= $driver['phone'] ?? 'N/A' ?></p>


                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
      <div class="card p-4">
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card p-3 text-center">
                <h6>Insurance</h6>
                <img src="<?= !empty($driver['insurance']) ? $driver['insurance'] : broken_img()?>"
                        class="img-fluid rounded" alt="Insurance">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card p-3 text-center">
                    <h6>License Front</h6>
                    <img src="<?= !empty($driver['license_front']) ? $driver['license_front'] : broken_img() ?>"
                        class="img-fluid rounded" alt="License Front">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card p-3 text-center">
                    <h6>License Back</h6>
                    <img src="<?= !empty($driver['license_back']) ? $driver['license_back'] : broken_img() ?>"
                        class="img-fluid rounded" alt="License Back">
                </div>
            </div>
        </div>
    </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <div class="card-title">
                <h5 class="mb-0">All Packages</h5>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Platform</th>
                        <th>Package Name</th>
                        <th>Dates</th>
                        <th>Created On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($packages as $package) { ?>
                        <tr>
                            <td>
                                <?php if ($package['customer_name']): ?>
                                    <a href="<?= base_url('user/show?customer_id=') . $package['customer_id'] ?>">
                                        <?= $package['customer_name'] ?>
                                    </a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?= $package['platform_name'] ?></td>
                            <td><?= $package['name'] ?></td>
                            <td><?= date('d M Y', strtotime($package['pickup_date'])) . '<br>' . date('h:i A', strtotime($package['pickup_start_time'])) . ' - ' . date('h:i A', strtotime($package['pickup_end_time'])) ?>
                            </td>
                            <td><?= date('d M Y h:i A', strtotime($package['created_at'])) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('package/show?package_id=') . $package['id'] ?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var table = new DataTable('.table', {
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: false // Disable page length change
        });
    });
</script>


<!-- partial:partials/_footer.html -->
<!-- partial -->
<?php include_once base_path('app/Views/layouts/footer.php'); ?>