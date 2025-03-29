</div>
<!-- ============================================================== -->
<!-- footer -->

<!-- ============================================================== -->

<!-- end footer -->
</div>
<!-- end wrapper  -->
<div class="footer w-100" style="position: fixed; bottom: 0;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                Copyright © 2024. All rights reserved.
            </div>
        </div>
    </div>
</div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

<!-- bootstap bundle js -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.js') ?>"></script>
<script src="<?= base_url('assets/vendor/slimscroll/jquery.slimscroll.js') ?>"></script>
<!-- main js -->

<!-- including datatable js -->

<script src="<?= base_url('assets/js/dataTables/dataTables.min.js') ?>"></script>

<script src="<?= base_url('assets/js/sweetalert/sweetalert.js') ?>"></script>

<script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js') ?>"></script>
<script>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] != '') { ?>
        Swal.fire({
            title: '<?= $_SESSION['message'] ?>',

            icon: '<?= $_SESSION['status'] ?>',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        });
        <?php
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    } ?>
</script>



</body>

</html>