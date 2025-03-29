<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');
?>

<div class="row">
    <div class="col-lg-8">
        <div class="card p-4 shadow-sm">
            <h4 class="mb-3">Package Details</h4>

            <!-- Image Gallery replace with the image -->
            <div class="row mb-3">
                <?php foreach($package['images'] as $images):?> 
                <div class="col-md-4">
                    <img src="<?= $images['image']? url().$images['image']:'https://picsum.photos/200/300'?>" class="d-block mb-2 rounded" alt="Package Image 1">
                </div>
                <?php endforeach; ?>
               
            </div>

            <h5 class="mb-1"><?= htmlspecialchars($package['name']) ?></h5>
            <p class="text-muted mb-2"><?= htmlspecialchars($package['description']) ?></p>
            <div class="d-flex gap-3">
                <span class="p-1 badge bg-<?= $package['status'] == 'pending' ? 'warning' : ($package['status'] == 'accepted' ? 'primary' : ($package['status'] == 'pickup' ? 'info' : 'success')) ?>">
                    <i class="fa <?= $package['status'] == 'pending' ? 'fa-clock' : ($package['status'] == 'accepted' ? 'fa-check' : ($package['status'] == 'pickup' ? 'fa-truck' : 'fa-box')) ?>"></i>
                    <?= ucfirst($package['status']) ?>
                </span>
                <span class="p-1 badge bg-<?= $package['payment_status'] == 2 ? 'success' : 'danger' ?>">
                    <i class="fa <?= $package['payment_status'] == 2 ? 'fa-dollar-sign' : 'fa-times' ?>"></i>
                    <?= $package['payment_status'] == 2 ? 'Paid' : 'Unpaid' ?>
                </span>
            </div>
            <hr>
            <p><strong>Customer Name :</strong> <a href="<?=base_url('user/show?customer_id=').$package['customer_id'] ?>"><?= htmlspecialchars($package['customer_name']) ?></a></p>
            
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4 shadow-sm">
            <h4 class="mb-3">Delivery Status</h4>
            <p><strong>Accepted At:</strong>
            <?= $package['accepted_at'] ? date('d M Y, h:i A', strtotime($package['accepted_at'])) : '-' ?></p>
            <p><strong>Picked At:</strong>
            <?= $package['picked_at'] ? date('d M Y, h:i A', strtotime($package['picked_at'])) : '-' ?></p>
            <p><strong>Delivered At:</strong>
            <?= $package['delivered_at'] ? date('d M Y, h:i A', strtotime($package['delivered_at'])) : '-' ?></p>
            <p><strong>Delivery By:</strong>
            <span class="badge bg-<?= $package['driver_name'] ? 'success' : 'secondary' ?>">
                <?= $package['driver_name'] ? htmlspecialchars($package['driver_name']) : 'Not Assigned' ?>
            </span>
            </p>
        </div>

        <div class="card p-4 shadow-sm">
            <h4 class="mb-3">Delivery Details</h4>
            <p><strong>Platform:</strong> <?= htmlspecialchars($package['platform_name']) ?></p>
            <p><strong>Pickup Date:</strong> <?= date('d M Y', strtotime($package['pickup_date'])) ?></p>
            <p><strong>Pickup Time:</strong> <?= date('h:i A', strtotime($package['pickup_start_time'])) ?> -
                <?= date('h:i A', strtotime($package['pickup_end_time'])) ?>
            </p>
            <p><strong>Location:</strong> <?= htmlspecialchars($package['location']) ?></p>
            <p><strong>Tracking ID:</strong>
                <?= $package['tracking_id'] ? htmlspecialchars($package['tracking_id']) : 'N/A' ?></p>
        </div>
    </div>
</div>




<!-- partial:partials/_footer.html -->
<!-- partial -->
<?php include_once base_path('app/Views/layouts/footer.php'); ?>