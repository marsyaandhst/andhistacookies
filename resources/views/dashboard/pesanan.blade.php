<!DOCTYPE html>
<html>
@include('dashboard.head')

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="../../index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Andhista Cookies</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <!-- Control Sidebar Toggle Button -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- =============================================== -->
        @include('dashboard.sidebar')
        <!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('title')
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                @yield('content')

                <section class="history">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 datatable"
                        id="adminOrderHeadersTable">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Invoice No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Recipients Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone Number
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total 
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Address
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Payment Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Proof Payment
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>

                    </table>
                </section>
                <div class="modal" id="adminOrderDetailsModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Order Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 datatable"
                                    id="adminOrderDetailsTable">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Product Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Price
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Quantity
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                    style="color: black">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->

                <!-- /.control-sidebar-menu -->


                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <!-- /.tab-pane -->
            <!-- Settings tab content -->

            <!-- /.form-group -->
            </form>
    </div>
    <!-- /.tab-pane -->
    </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            var dataTable;
            fill_datatable();

            function fill_datatable() {
                dataTable = $('#adminOrderHeadersTable').DataTable({
                    autoWidth: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('adminGetOrderHeaders') }}",
                    },
                    columns: [{
                            data: 'invoice_no',
                            name: 'invoice_no'
                        },
                        {
                            data: 'namapenerima',
                            name: 'namapenerima'
                        },
                        {
                            data: 'nohp',
                            name: 'nohp'
                        },
                        {
                            data: 'totalharga',
                            name: 'totalharga'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'status_pembayaran',
                            name: 'status_pembayaran',
                            render: function(data, type, row) {
                                var statusColor = '';
                                var statusText = '';
                                if (data === 'Menunggu Pembayaran') {
                                    statusColor = 'btn-warning';
                                    statusText = 'Pending';
                                } else if (data === 'Pembayaran Diterima') {
                                    statusColor = 'btn-success';
                                    statusText = 'Payment Received';
                                } else if (data === 'Pembayaran Ditolak') {
                                    statusColor = 'btn-danger';
                                    statusText = 'Payment Declined';
                                }
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn ' + statusColor +
                                    ' btn-sm dropdown-toggle py-0 px-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                    statusText + '</button>' +
                                    '<div class="dropdown-menu">' +
                                    '<form action="{{ url('api/update_status') }}/' + row.id +
                                    '" method="POST" enctype="multipart/form-data">' +
                                    '@method('PATCH')' +
                                    '@csrf' +
                                    '<input type="hidden" name="order_id" value="' + row.id + '">' +
                                    '<button type="submit" name="status_pembayaran" value="Menunggu Pembayaran" class="dropdown-item btn btn-warning">Pending</button>' +
                                    '<button type="submit" name="status_pembayaran" value="Pembayaran Diterima" class="dropdown-item btn btn-success">Payment Received</button>' +
                                    '<button type="submit" name="status_pembayaran" value="Pembayaran Ditolak" class="dropdown-item btn btn-danger">Payment Declined</button>' +
                                    '</form>' +
                                    '</div>' +
                                    '</div>';
                            }
                        },
                        {
                            data: 'buktipembayaran',
                            name: 'buktipembayaran',
                            render: function(data, type, row) {
                                return '<a href="buktipembayaran/' + data +
                                    '" target="_blank"><img src="buktipembayaran/' + data +
                                    '" width="100px"></a>';
                            }
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return '<button type="button" class="btn btn-primary btn-sm btn-details" data-order-id="' +
                                    row.id + '">Details</button>' +
                                    '<button type="button" class="btn btn-danger btn-sm btn-delete" data-order-id="' +
                                    row.id + '">Delete</button>' +
                                    '</div>';;
                            }
                        },
                    ]
                });
            }

            $('#adminOrderHeadersTable').on('click', '.btn-details', function() {
                const orderId = $(this).data('order-id');
                getOrderDetails(orderId);
            });

            $('#adminOrderHeadersTable').on('change', '.status-select', function() {
                const cell = $(this).closest('td');
                const dropdown = cell.find('.status-dropdown');
                dropdown.hide();

                const orderId = dataTable.row($(this).closest('tr')).data().id;
                const newStatus = $(this).val();

                updateStatus(orderId, newStatus);
            });

            $('#adminOrderHeadersTable').on('click', '.btn-delete', function() {
                const orderId = $(this).data('order-id');
                deleteOrder(orderId);
            });




            function getOrderDetails(orderId) {
                const orderDetailsTable = $('#adminOrderDetailsTable').DataTable();
                orderDetailsTable.clear().draw();

                $.ajax({
                    url: `/api/adminOrder_details/${orderId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        data.forEach(function(orderDetail) {
                            orderDetailsTable.row.add([
                                orderDetail.namakue,
                                orderDetail.harga,
                                orderDetail.qty
                            ]).draw(false);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("Error fetching data: ", error);
                        console.log(xhr);
                    }
                });

                $('#adminOrderDetailsModal').modal('show');
            }

            $('#adminOrderDetailsModal').on('click', '[data-dismiss="modal"]', function() {
                $('#adminOrderDetailsModal').modal('hide');
            });

            function getCsrfToken() {
                return $('meta[name="csrf-token"]').attr('content');
            }

            function updateStatus(orderId, newStatus) {
                $.ajax({
                    url: '/api/update_status/' + orderId,
                    type: 'PUT',
                    data: {
                        status_pembayaran: newStatus,
                    },
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    success: function(response) {
                        if (response.success) {
                            dataTable.ajax.reload(null, false);
                        } else {
                            console.log('Error updating status.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error updating status: ', error);
                        console.log(xhr);
                    }
                });
            }

            function deleteOrder(orderId) {
                Swal.fire({
                    icon: 'question',
                    title: 'Delete Order',
                    text: 'Are You Sure You Want to Delete this Order?',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/daftarpesanan/delete/' + orderId,
                            type: 'GET',
                            success: function(response) {
                                dataTable.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted',
                                    text: 'Order has Been Deleted Successfully!',
                                });
                            },
                            error: function(xhr, status, error) {
                                console.log('Error deleting order: ', error);
                                console.log(xhr);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while deleting the order.',
                                });
                            }
                        });
                    }
                });
            }

        });
    </script>

    @include('dashboard.script')
</body>

</html>
