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
                        <li class="breadcrumb-item active" aria-current="page">subscriptions</li>
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
                <h4 class="">All Subscriptions</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="normal_table1">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Customer Name</th>
                            <th>Start Date</th>
                            <th>Duration</th>
                            <th>Expiry Time</th>
                            <th>Transaction ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscriptions as $row): ?>
                            <tr>
                                <td><?= $row['name'] ?></td>
                                <td><a
                                        href="<?= base_url('user/show?customer_id=' . $row['customer_id']) ?>"><?= $row['full_name'] ?></a>
                                </td>
                                <td><?= date('d M Y', strtotime($row['start_date'])) ?></td>
                                <td><?= $row['duration'] ?></td>
                                <td><?= date('d M Y H:i:s', strtotime($row['expiry'])) ?></td>
                                <td><?= $row['transaction_id'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="m-3 card-title d-flex justify-content-between align-items-center">
                <h4 class="">All Plans</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="plans_table">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plans as $plan): ?>
                            <tr>
                                <td><?= $plan['name'] ?></td>
                                <td><?= $plan['price'] ?></td>
                                <td><?= $plan['status'] == 1 ? 'Active' : 'Inactive' ?></td>
                                <td><?= date('d M Y', strtotime($plan['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#normal_table1').DataTable();
    });
</script>


<?php include_once base_path('app/Views/layouts/footer.php'); ?>