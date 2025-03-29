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
                <h4 class="">All Platforms</h4><a href='<?= base_url('platform/create') ?>' class="btn btn-primary">New
                    Platform</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="normal_table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Created On</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        foreach ($platforms as $platform): ?>
                            <tr>
                                <td><?= $index++ ?></td>
                                <td><?= $platform['name'] ?></td>
                                <td><img src="<?= base_url($platform['image']) ?>" alt="" width="100"></td>
                                <td><?= date('d M Y', strtotime($platform['created_at'] ?? '')) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('platform/edit?platform_id=' . $platform['id']) ?>"
                                        class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                        
                                    <form action="<?= base_url('platform/delete') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="platform_id" value="<?= $platform['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this platform?');">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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