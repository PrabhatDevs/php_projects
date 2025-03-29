<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <!-- <a class="d-xl-none d-lg-none" href="#">Dashboard</a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <!-- <li class="nav-divider">
                        Menu
                    </li> -->

                    <li class="nav-item mt-5 mb-2">
                        <a class="nav-link <?= match_url('dashboard')?>" href="<?= base_url('dashboard') ?>"> <i class="fas fa-fw fa-th"></i>
                            Dashboard</a>
                    </li>
                    <?php if(can(2)):?>
                    <li class="nav-item">
                        <a class="nav-link <?= (match_url('admin') || match_url('admin/create')) == 'active' ? 'active open' : '' ?>"
                            href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-admins"
                            aria-controls="submenu-admins"><i class="fa-solid fa-user"></i> Admins </a>
                        <div id="submenu-admins" class="collapse submenu">
                            <ul class="nav flex-column pb-2">
                                <li class="nav-item ms-3">
                                    <a class="nav-link" href="<?= base_url('admin/create') ?>">Add Admin</a>
                                </li>
                                <li class="nav-item ms-3">
                                    <a class="nav-link" href="<?= base_url('admins') ?>">Admin List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <?php endif ?>
                   
                    <li class="nav-item">
                        <a class="nav-link <?= (match_url('customer') || match_url('driver')) == 'active' ? 'active open' : '' ?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-users"
                            aria-controls="submenu-users"><i class="fas fa-users"></i> Users </a>
                        <div id="submenu-users" class="collapse submenu">
                            <ul class="nav flex-column pb-2">
                                <?php if(can(1)):?>
                                <li class="nav-item ms-3">
                                    <a class="nav-link" href="<?=base_url('customers')?>"><i class="fas fa-user"></i> Customers</a>
                                </li>
                                <?php endif ?>
                                <?php if (can(3)): ?>
                                <li class="nav-item ms-3">
                                    <a class="nav-link" href="<?= base_url('drivers') ?>"><i class="fas fa-car"></i> Drivers</a>
                                </li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </li> 
                   
                    <?php if(can(4)):?>
                     <li class="nav-item">
                        <a class="nav-link <?= match_url('platform')?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#platform-menu"
                            aria-controls="platform-menu"><i class="fas fa-cogs"></i> Platforms </a>
                        <div id="platform-menu" class="collapse submenu">
                            <ul class="nav flex-column pb-2">
                                <li class="nav-item ms-3">
                                    <a class="nav-link" href="<?=base_url('platforms')?>"><i class="fa-solid fa-caret-right"></i> All Platforms</a>
                                </li>
                                <li class="nav-item ms-3">
                                    <a class="nav-link" href="<?= base_url('platform/create') ?>"><i class="fa-solid fa-caret-right"></i> New Platform</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                  <?php endif; ?>
                  <?php if(can(5)):?>
                    <li class="nav-item">
                        <a class="nav-link <?= match_url('package') ?>" href="<?=base_url('packages')?>"><i class="fas fa-box"></i>Packages</a>
                    </li>
                    <?php endif ?>
                    <?php if(can(6)):?>
                    <li class="nav-item">
                        <a class="nav-link <?= match_url('subscription') ?>" href="<?= base_url('subscriptions') ?>"><i class="fas fa-sync-alt"></i> Subscription</a>
                    </li>
                    <?php endif ?>
                    


                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">