@extends('layouts.main')
@section('css', '/css/history.css')

@section('content')
    <tbody>

        <section class="history">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 datatable" id="orderHeadersTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Invoice No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Recipients Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone  Number
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
                    </tr>
                </thead>

            </table>
        </section>

        <!-- Modal for showing ORDER_DETAILS -->
        <div class="modal" id="orderDetailsModal" tabindex="-1" role="dialog">
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
                            id="orderDetailsTable">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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


        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var dataTable;
                fill_datatable();

                function fill_datatable() {
                    dataTable = $('#orderHeadersTable').DataTable({
                        autoWidth: true,
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('getOrderHeaders') }}",
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
                                name: 'status_pembayaran'
                            },
                            {
                                data: 'buktipembayaran',
                                name: 'buktipembayaran',
                                render: function(data, type, row) {
                                    return '<a href="buktipembayaran/' + data +
                                        '" target="_blank"><img src="buktipembayaran/' + data +
                                        '" width="100px"></a>';
                                }
                            }
                        ]
                    });
                }

                $('#orderHeadersTable tbody').on('click', 'tr', function() {
                    const data = dataTable.row(this).data();
                    const orderId = data.id;
                    getOrderDetails(orderId);
                });


                function getOrderDetails(orderId) {
                    const orderDetailsTable = $('#orderDetailsTable').DataTable();
                    orderDetailsTable.clear().draw();

                    $.ajax({
                        url: `/api/order_details/${orderId}`,
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

                    $('#orderDetailsModal').modal('show');
                }

                $('#orderDetailsModal').on('click', '[data-dismiss="modal"]', function() {
                    $('#orderDetailsModal').modal('hide');
                });
            });
        </script>

    </tbody>
@endsection
