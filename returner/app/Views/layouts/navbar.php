<!-- navbar -->

<!-- ============================================================== -->
<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>"><img
                src="<?= base_url('assets/images/icons/favicon.png') ?>" alt="" width="80px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <!-- <li class="nav-item">
                    <div id="custom-search" class="top-search-bar">
                        <input class="form-control" type="text" placeholder="Search..">
                    </div>
                </li> -->


                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= !empty($_SESSION['user_details']['profile_pic']) ? base_url('app/Views/admin/uploads/profile_pictures/') . $_SESSION['user_details']['profile_pic'] : base_url('assets/images/icons/user2.png') ?>"
                            alt="Profile Picture" class="user-avatar-md rounded-circle"
                            style="height:50px; width:50px;">
                    </a>


                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                        aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info">
                            <h5 class="mb-0 text-white nav-user-name text-capitalize">
                                <?= $_SESSION['user_details']['name'] ?></h5>
                            <span class="status"></span><span class="ml-2">Active</span>
                        </div>
                        <a href="<?= base_url('reset-password') ?>" class="dropdown-item mt-1">Reset Password</a>
                        <form action="<?= base_url('logout') ?>" method="POST">
                            <a href="javascript:void(0);" onclick="this.closest('form').submit()" class="dropdown-item">
                                <i class="fas fa-power-off me-2"></i> Logout
                            </a>
                        </form>


                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- ============================================================== -->
<!-- end navbar -->