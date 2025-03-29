<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
           
            <!-- Change Password -->
            <div class="card mb-5">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body pt-5">
                    <form id="formAccountSettings" action="<?=base_url('reset-password')?>" method="POST">
                        <div class="row">
                            <div class="mb-5 col-md-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" name="currentPassword"
                                            id="currentPassword"
                                            placeholder="" />
                                        <label for="currentPassword">Current Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-5 mb-5">
                            <div class="col-md-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" id="newPassword" name="newPassword"
                                            />
                                        <label for="newPassword">New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" name="confirmPassword"
                                            id="confirmPassword"
                                              />
                                        <label for="confirmPassword">Confirm New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-body">Password Requirements:</h6>
                        <ul class="ps-4 mb-0">
                            <li class="mb-4">Minimum 8 characters long - the more, the better</li>
                            <li class="mb-4">At least one lowercase character</li>
                            <li>At least one number, symbol, or whitespace character</li>
                        </ul>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->

        </div>
    </div>
    <script>
         document.getElementById('formAccountSettings').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Basic validation
        if (!currentPassword || !newPassword || !confirmPassword) {
            Swal.fire({
                title: 'Error!',
                text: 'All fields are required',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
            return;
        }
        
        if (newPassword !== confirmPassword) {
            Swal.fire({
                title: 'Error!',
                text: 'New passwords do not match',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
            return;
        }
this.submit();
    });
    </script>
    <!-- partial:partials/_footer.html -->
    <!-- partial -->
    <?php

    include_once base_path('app/Views/layouts/footer.php');
    ?>