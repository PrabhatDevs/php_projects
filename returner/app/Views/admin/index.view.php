<?php
include_once base_path('app/Views/layouts/header.php');
include_once base_path('app/Views/layouts/navbar.php');
include_once base_path('app/Views/layouts/sidebar.php');
// include_once base_path('admin/app/controller/admin/index.php');
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
                        <li class="breadcrumb-item active" aria-current="page">Admin</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Accordion with Icon -->
    <div class="col-md mb-6 mb-md-2">
        <div class="accordion mt-4" id="accordionWithIcon">
            <div class="accordion-item active">
                <h2 class="accordion-header d-flex align-items-center">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionWithIcon-1" aria-expanded="true">
                        <i class="ri-filter-line ri-20px me-2"></i>
                        Filter
                    </button>
                </h2>

                <div id="accordionWithIcon-1" class="accordion-collapse collapse ">
                    <div class="accordion-body">
                        <form id="filter-form">
                            <div class="row g-4">

                                <div class="col-md-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" placeholder="Enter Email"
                                        class="form-control">
                                    </input>
                                </div>
                                <div class="col-md-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="">All</option>
                                        <option value="admin">Admin</option>
                                        <option value="super_admin">Super Admin</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" id="filterButton">Apply
                                        Filter</button>
                                    <button type="reset" class="btn btn-secondary" id="clearFilterButton">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="m-3 card-title d-flex justify-content-between align-items-center">
                <h4 class="">All Admins</h4><a href='<?= base_url('admin/create') ?>'
                    class="btn bg-gradient text-white">New Admin</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="normal_table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email & Role</th>
                            <th>Accessible Modules</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this admin?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="<?= base_url('admin/delete') ?>" method="post" style="display:inline;">
                    <input type="hidden" name="admin_id" value="">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/change_status') ?>" method="post">
                    <input type="hidden" name="admin_id" id="modalAdminId">
                    <div class="mb-3">
                        <label for="modalStatus" class="form-label">Status</label>
                        <select class="form-select" id="modalStatus" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary border-0 text-white"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn border-0 bg-gradient text-white">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showEditModal(button, adminId, status) {
        const modal = document.getElementById("statusModal");
        if (modal) {
            modal.querySelector("input[name='admin_id']").value = adminId;
            modal.querySelector("select[name='status']").value = status;
            $('.modal-backdrop').remove(); // Remove any existing backdrops
            $('#statusModal').modal('show'); // Open modal properly
        }
    }
    function deleteModal(button, adminId) {
        const modal = document.getElementById("deleteModal");
        if (modal) {
            modal.querySelector("input[name='admin_id']").value = adminId;
            $('.modal-backdrop').remove();
            $('#deleteModal').modal('show');
        }
    }

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function () {
            let table = $('#normal_table1').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: false,
                ordering: false,
                ajax: {
                    url: '<?= base_url('admin/fetch_data') ?>',
                    type: 'POST',
                    data: function (d) {
                        d.role = $('#role').val();
                        d.email = $('#email').val();
                        d.status = $('#status').val();
                    },
                 
                },
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'name' },
                    {
                        data: 'email',
                        render: function (data, type, row) {
                            return `<p class="m-0">${data}</p> 
                            <p class="text-muted m-0">${row.role == 'super_admin' ? '(Super Admin)' : '(' + capitalizeFirst(row.role) + ')'}</p>`;
                        }
                    },
                    { data: 'module_names' },
                    {
                        data: 'created_at',
                        render: function (data) {
                            return data ? formatDate(data) : '';
                        }
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            return `<span class="badge bg-${data == 1 ? 'success' : 'danger'}">${data == 1 ? 'Active' : 'Inactive'}</span>
                            <input type="hidden" class="user_status" value="${data}">`;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<div class="d-flex gap-2 align-items-center">
                        <a href="admin/edit?id=${data}" class="border-0 bg-info text-white p-2 rounded-2">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button type="button" class="border-0 bg-secondary text-white p-2 rounded-2" 
                            data-bs-toggle="modal" data-bs-target="#statusModal" onclick="showEditModal(this,${data},${row.status})">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button type="button" class="border-0 bg-danger text-white p-2 rounded-2" 
                            data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteModal(this,${data})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    `;
                        }
                    }
                ]
            });

            $('#filter-form').on('submit', function (event) {
                event.preventDefault();
                table.ajax.reload();
            });

            $('#clearFilterButton').on('click', function () {
                $('#filter-form')[0].reset();
                table.ajax.reload();
            });

            function capitalizeFirst(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            }
        });
    });
</script>
<?php include_once base_path('app/Views/layouts/footer.php'); ?>