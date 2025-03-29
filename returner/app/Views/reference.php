<?php
// require_once '../admin/core/functions.php';
include_once base_path('app/Views/layouts/header.view.php');
include_once base_path('app/Views/layouts/navbar.view.php');
?>

<div class="container-fluid page-body-wrapper">
    <?php
    include_once base_path('app/Views/layouts/sidebar.view.php');
    ?>
    <div class="main-panel ">
        <div class="content-wrapper bg-secondary-1">
          <h3>dashboard</h3>
            <!-- partial:partials/_footer.html -->
            <!-- partial -->
            <?php
            include_once base_path('app/Views/layouts/footer.view.php');
            ?>