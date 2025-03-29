<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');

?>

<div class="container-xxl flex-grow-1 container-p-y">
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Dashboard</h2>

            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"
                                class="breadcrumb-link">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admin</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-title">
                            <h5 class="mt-3 ms-3">Admin Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/update') ?>" method="POST" class="row g-3"
                                enctype="multipart/form-data">
                                <input type="hidden" name="admin_id" value="<?= $admin['id']??'' ?>">
                                <div class="col-md-6">
                                    <label for="adminName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="adminName" name="name" value="<?=$admin['name']??''?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="adminEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="adminEmail" name="email" value="<?=$admin['email']??''?>" required>
                                </div>
                               
                                <div class="col-md-6">
                                    <label for="adminRole" class="form-label">Role</label>
                                    <select class="form-select" id="adminRole" name="role" required
                                        onchange="toggleModules()">
                                        <option value="admin" <?=$admin['role']=='admin'?'selected':''?>>Admin</option>
                                        <option value="super_admin" <?= $admin['role'] == 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                                    </select>

                                </div>
                                <div class="col-md-6" id="modulesSection">
                                    <label for="adminModules" class="form-label">Accessible Modules</label>
                                    <?php $module_ids = explode(',', $admin['module_ids'] ?? ''); ?>
                                    <?php foreach($permissions as $permission):?>
                                    <div class="form-check ms-5">
                                        <input class="form-check-input" type="checkbox" id="module<?=$permission['id']??''?>"
                                            name="accessible_modules[]" value="<?=$permission['id']??''?>" <?= in_array($permission['id'],$module_ids)?'checked':''?>>
                                        <label class="form-check-label text-capitalize" for="module<?=$permission['id']??''?>"><?=$permission['module_name']??''?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="adminStatus" class="form-label">Status</label>
                                    <select class="form-select" id="adminStatus" name="status" required>
                                        <option value="1" <?= $admin['status'] == '1' ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $admin['status'] == '0' ? 'selected' : '' ?>>Deactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="adminImage" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="adminImage" name="profile_pic" onchange="previewImage(event)">
                                    <?php if (!empty($admin['profile_pic'])): ?>
                                        <img id="imagePreview" src="<?= base_url('app/Views/admin/uploads/profile_pictures/' . $admin['profile_pic']) ?>" alt="Profile Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    <?php else: ?>
                                        <img id="imagePreview" src="#" alt="Profile Image" class="img-thumbnail mt-2" style="max-width: 150px; display: none;">
                                    <?php endif; ?>
                                </div>
                                <script>
                                    function previewImage(event) {
                                        var reader = new FileReader();
                                        reader.onload = function(){
                                            var output = document.getElementById('imagePreview');
                                            output.src = reader.result;
                                            output.style.display = 'block';
                                        };
                                        reader.readAsDataURL(event.target.files[0]);
                                    }
                                </script>

                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Update Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
            <script>
                function toggleModules() {
                    var role = document.getElementById('adminRole').value;
                    var modulesSection = document.getElementById('modulesSection');
                    if (role === 'admin') {
                        modulesSection.style.display = 'block';
                        modulesSection.style.enabled = true;
                    } else {
                        modulesSection.style.display = 'none';
                        modulesSection.style.enabled = false;
                    }
                }
                window.onload = toggleModules;
            </script>
            <!-- partial:partials/_footer.html -->
            <!-- partial -->
          <?php include_once base_path('app/Views/layouts/footer.php'); ?>