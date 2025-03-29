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
                            <li class="breadcrumb-item active" aria-current="page">Drivers</li>
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
                            <i class="fa-solid fa-filter me-2"></i>
                            Filter
                        </button>
                    </h2>

                    <div id="accordionWithIcon-1" class="accordion-collapse collapse ">
                        <div class="accordion-body">
                            <form id="filter-form">
                                <div class="row g-4">

                                    <div class="col-md-3">
                                        <label for="role">Name</label>
                                        <input type="text" id="name" placeholder="Enter Name" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" placeholder="Enter Email"
                                            class="form-control">
                                        </input>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status">Created At</label>
                                       <select name="status" id="status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                       </select>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="filterButton">Apply
                                            Filter</button>
                                        <button type="reset" class="btn btn-secondary"
                                            id="clearFilterButton">Reset</button>
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
                    <h5 class="mb-0">All drivers</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="normal_table1">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
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
                <form action="<?= base_url('change_driver_status') ?>" method="post">
                    <input type="hidden" name="driver_id" id="modaldriverId">
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
                        <button type="submit" class="btn border-0 btn-primary text-white">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function showEditModal(button, driverId, status) {
        const modal = document.getElementById("statusModal");
        if (modal) {
            modal.querySelector("input[name='driver_id']").value = driverId;
            modal.querySelector("select[name='status']").value = status;
            $('.modal-backdrop').remove(); // Remove any existing backdrops
            $('#statusModal').modal('show'); // Open modal properly
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
                    url: '<?= base_url('fetch_driver_list') ?>',
                    type: 'POST',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'profile_image',
                        render: function (data) {
                            return `<img src="https://alliedtechnologies.cloud/clients/food4less/api/v1/app/assets/${data}" alt="">`;
                        }
                    },
                    { data: 'full_name' },
                    {
                        data: 'email',
                        render: function (data, type, row) {
                            return `<p class="m-0">${data}</p> `;
                        }
                    },

                    {
                        data: 'created_at',
                        render: function (data) {
                            return data ? formatDate(data) : '';
                        }
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            return `<span class="badge bg-${data == 1 ? 'success' : 'danger'}"> ${data == 1 ? 'Active' : 'Inactive'}</span >`;

                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            return `
            <div class="d-flex gap-2">
                <a href="user/show?driver_id=${data}" class="border-0 bg-info text-white p-2 rounded-2">
                    <i class="fa fa-eye"></i>
                </a>
                <button type="button" class="border-0 bg-secondary text-white p-2 rounded-2"
                    data-bs-toggle="modal" data-bs-target="#statusModal" 
                    onclick="showEditModal(this, ${data}, ${row.status})">
                     <i class="fa fa-edit"></i>
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