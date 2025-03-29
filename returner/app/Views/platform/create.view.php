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
                        <li class="breadcrumb-item active" aria-current="page">Platforms</li>
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
                <h4 class="">Create Platform</h4>
                <a href='<?= base_url('platforms') ?>' class="btn btn-secondary">Back to Platforms</a>
            </div>
            <div class="card-body">
                <form action="<?= base_url('platform/store') ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Platform Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Platform Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Platform</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#normal_table1').DataTable();
        });
    </script>


    <?php include_once base_path('app/Views/layouts/footer.php'); ?>