@extends('admin.layout.app')


@section('main-content')
    <style>
        .form-inline {
            display: flex;
            align-items: center;
        }
        .form-group {
            margin-right: 10px;
            
        }
        
        .form-control {
            width: 200px;
        }
    </style>
    <div class="container p-3">
        <div class="card" style="padding: 10px; background-color:#e4e6e8">
            <div class="row">
                <div class="col-12">
                    <form id="search-form">
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="order_code">Order Code:</label>
                                <input type="text" id="order_code" name="order_code" placeholder="Order Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="text" id="phone" name="phone" placeholder="Phone Number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Order Status:</label>
                                <select name="order_status" id="order_status" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="0">Pending</option>
                                    <option value="2">Accepted</option>
                                    <option value="3">On Delivery</option>
                                    <option value="4">Delivery Done</option>
                                    <option value="5">Return Back</option>
                                    <option value="1">Canceled</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="date">Start Date:</label>
                                <input type="date" id="date_from" name="date_from" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="date">End Date:</label>
                                <input type="date" id="date_to" name="date_to" class="form-control">
                            </div>
                            
                            

                            <div class="form-group pt-3">
                                <button type="button" id="search_btn" class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                                    
                </div>
            </div>
        </div>
        
        <div class="row">
        
            <div class="col-12">
                <div class="card" style="margin-bottom: 50px">
                    <h3 class="card-header text-center bg-success text-white">Order List</h3>
                    <div class="table-responsive text-nowrap">
                        <table class="table ">
                            <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Order Code</th>
                                <th>Customer Name</th>
                                <th>Total Price</th>
                                <th>Phone Number</th>
                                <th>invoice</th>
                                <th>Status</th>
                                <th>Actions</th>
                                
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            
                                    @foreach ($order_list as $order)
                                    <?php 
                                        $is_order_placed=DB::table('place_order')->where('order_code', $order->order_code)->first();
                                    ?>
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$order->order_code}}</td>
                                            <td>{{$order->full_name}}</td>
                                            <td>{{$order->total_price}}</td>
                                            <td>{{$order->phone_number}}</td>
                                            <td style="text-align:center"><a href="{{route('product.invoice', $order->id)}}" target="_blank"><i id="invoice" class="fa-solid fa-file-lines" style="font-size: 30px; text-align:center; cursor:pointer; color:green"></i></a></td>
                                            <?php 
                                                $color=' ';
                                                $bg_color=' ';
                                                if ($order->order_status==0) {
                                                    $bg_color='beige';
                                                }
                                                if ($order->order_status==2) {
                                                    $bg_color='#c4edd5';
                                                }
                                                if ($order->order_status==1) {
                                                    $bg_color='red';
                                                }
                                                if ($order->order_status==3) {
                                                    $bg_color='darkkhaki';
                                                }
                                                if ($order->order_status==4) {
                                                    $bg_color='green';
                                                }
                                                if ($order->order_status==5) {
                                                    $bg_color='red';
                                                }
                                                if ($order->order_status==1 || $order->order_status==4 || $order->order_status==5) {
                                                    $color='white';
                                                } else {
                                                    $color='black';
                                                }
                                                
                                            ?>
                                            <td><button style="border-radius: 5px; color:{{$color}}; background-color:{{$bg_color}}; border:2px solid {{$bg_color}}">{{order_status($order->order_status)}}</button></td>
                                            
                                            <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item" href=""><i class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                                                    @if ($order->order_status==0)
                                                        <a class="dropdown-item" href="javascript:void(0);" id="accept_btn" data-id="{{$order->order_code}}" data-type="accept">Accept</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" id="cancel_btn" data-id="{{$order->order_code}}" data-type="cancel">Cancel</a>
                                                    @endif
                                                    @if ($order->order_status==1)
                                                    <p style="color: red">Cancel</p>
                                                    @endif
                                                    @if ($order->order_status==2)
                                                        <a class="dropdown-item" href="javascript:void(0);" id="on_delivery_btn" data-id="{{$order->order_code}}" data-type="on_delivery">On Delivery</a>
                                                        @if (empty($is_order_placed))
                                                        <a class="dropdown-item" href="" id="place_order_btn" data-id="{{$order->id}}" data-type="on_delivery">Place Order</a>
                                                        @else
                                                        <a class="dropdown-item" href="" id="show_status_btn" data-id="{{$is_order_placed->id}}" data-type="on_delivery">Show delivery Status</a>
                                                        @endif
                                                        
                                                        <a class="dropdown-item" href="javascript:void(0);" id="cancel_btn" data-id="{{$order->order_code}}" data-type="cancel">Cancel</a>
                                                    @endif
                                                    @if ($order->order_status==3)
                                                        <a class="dropdown-item" href="javascript:void(0);" id="delivery_done_btn" data-id="{{$order->order_code}}" data-type="delivery_done">Delivery Done</a>
                                                        <a class="dropdown-item" href="" id="show_status_btn" data-id="{{$is_order_placed->id}}" data-type="on_delivery">Show delivery Status</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" id="return_back_btn" data-id="{{$order->order_code}}" data-type="return_back">Return Back</a>
                                                    @endif
                                                    @if ($order->order_status==4)
                                                        <p style="color: green">Delivery Done</p>
                                                    @endif
                                                    @if ($order->order_status==5)
                                                        <p style="color: red">Return Back</p>
                                                    @endif
                                                    
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                            
                        </table>
                    
                    </div>
                    <div class="row mt-md-4 mt-2 pagination" style="width: 100%; margin:auto">
                        <div class="col-5"></div>
                        <div class="col-4" >
                            
                            {!! $order_list->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    

<script>
    
    $(document).ready(function(){
        
        //delete sub category
        $(document).on('click', '#product_dlt_btn', function(){
            Swal.fire({
                title: "<div style='color: black;'>Are you sure?</div>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                customClass: {
                    popup: 'swal-small', 
                    title: 'swal-title-small',
                    cancelButton: 'swal-cancel-button-small', 
                    confirmButton: 'swal-confirm-button-small' 
                }
                }).then((result) => {
                if (result.isConfirmed) {
                    let id= $(this).data('id');
                   

                    $.ajax({
                       
                        url:"delete/" +id,
                        method: 'GET',
                        
                        
                        success: function(response) {
                            if (response.status==true) {
                                
                                Swal.fire({
                                    title: "<div style='color: black;'>Deleted</div>",
                                    text: "Successfully Delete A Product",
                                    icon: "success"
                                });
                                $(".table").load(" .table");
                                
                            }
                            if (response.status==false) {
                                
                                Swal.fire({
                                    title: "Warning!",
                                    text: "Product is not deleted",
                                    icon: "warning"
                                });
                                
                            }
                            
                        },
                        
                    });
                    
                }
            });
           
        });

        
        $(document).on('click', '#accept_btn, #cancel_btn, #on_delivery_btn, #delivery_done_btn, #return_back_btn', function(){
           
            Swal.fire({
                title: "<div style='color: black;'>Are you sure ?</div>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm !"
            }).then((result) => {
                if (result.isConfirmed) {
                    let id= $(this).data('id');
                    let type= $(this).data('type');
                
                    $.ajax({
                        url: '{{ route('admin.order.status.update') }}', 
                        method: 'GET',
                        data: {
                            'id' : id,
                            'type' : type,
                        },
                        
                        success: function(response) {
                            if (response.status==true) {
                                Swal.fire({
                                    title: "<div style='color: black;'>Successfully Update</div>",
                                    icon: "success"
                                });
                                $(".table").load(" .table");
                            }
                            if (response.status==false) {
                                Swal.fire({
                                    title: "<div style='color: black;'>Something went wrong</div>",
                                    icon: "warning"
                                });
                            }
                        },
                    });
                }
            });
        });
        
       // Define order status mapping
       const orderStatusMap = {
            0: "Pending",
            1: "Canceled",
            2: "Accepted",
            3: "On Delivery",
            4: "Delivery Done",
            5: "Return Back"
       };


        //search
        
        $('#search_btn').on('click', function() {
            let orderCode = $('#order_code').val();
            let phone = $('#phone').val();
            let order_status = $('#order_status').val();
            let date_to = $('#date_to').val();
            let date_from = $('#date_from').val();
                
            $.ajax({
                url: "{{ route('admin.order.search') }}", 
                method: 'GET',
                data: {
                    order_code: orderCode,
                    phone: phone,
                    order_status: order_status,
                    date_to: date_to,
                    date_from: date_from
                },
                success: function(response) {
                    // Clear existing rows
                    $('.table tbody').empty();
                    $('.pagination').hide();

                    // Check if there are results
                    if (response.table_rows.length > 0) {
                        response.table_rows.forEach(function(order, index) {
                            let bg_color = ' ';
                            let color = ' ';

                            // Determine background and text color based on order status
                            switch (order.order_status) {
                                case 0: bg_color = 'beige'; color = 'black'; break;
                                case 1: bg_color = 'red'; color = 'white'; break;
                                case 2: bg_color = '#c4edd5'; color = 'black'; break;
                                case 3: bg_color = 'darkkhaki'; color = 'white'; break;
                                case 4: bg_color = 'green'; color = 'white'; break;
                                case 5: bg_color = 'red'; color = 'white'; break;
                            }

                            // Append the row to the table
                            $('.table tbody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${order.order_code}</td>
                                    <td>${order.full_name}</td>
                                    <td>${order.total_price}</td>
                                    <td>${order.phone_number}</td>
                                    <td>
                                        <button style="border-radius: 5px; color:${color}; background-color:${bg_color}; border:2px solid ${bg_color}">
                                            ${orderStatusMap[order.order_status]} <!-- Use the orderStatusMap here -->
                                        </button>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                ${order.order_status == 0 ? `
                                                    <a class="dropdown-item" href="javascript:void(0);" id="accept_btn" data-id="${order.order_code}" data-type="accept">Accept</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="cancel_btn" data-id="${order.order_code}" data-type="cancel">Cancel</a>` : ''}
                                                
                                                ${order.order_status == 2 ? `
                                                    <a class="dropdown-item" href="javascript:void(0);" id="on_delivery_btn" data-id="${order.order_code}" data-type="on_delivery">On Delivery</a>
                                                    ${order.is_order_placed ? 
                                                    `<a class="dropdown-item" href="javascript:void(0);" id="show_status_btn" data-id="${order.is_order_placed}" data-type="show_status">Show Delivery Status</a>` :
                                                    `<a class="dropdown-item" href="javascript:void(0);" id="place_order_btn" data-id="${order.id}" data-type="place_order">Place Order</a>`}
                                                    <a class="dropdown-item" href="javascript:void(0);" id="cancel_btn" data-id="${order.order_code}" data-type="cancel">Cancel</a>` : ''}
                                                
                                                ${order.order_status == 3 ? `
                                                    <a class="dropdown-item" href="javascript:void(0);" id="delivery_done_btn" data-id="${order.order_code}" data-type="delivery_done">Delivery Done</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="show_status_btn" data-id="${order.is_order_placed}" data-type="show_status">Show Delivery Status</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" id="return_back_btn" data-id="${order.order_code}" data-type="return_back">Return Back</a>` : ''}
                                                
                                                ${order.order_status == 4 ? '<p style="color: green">Delivery Done</p>' : ''}
                                                ${order.order_status == 5 ? '<p style="color: red">Return Back</p>' : ''}
                                                ${order.order_status == 1 ? '<p style="color: red">Cancel</p>' : ''}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('.table tbody').append('<tr><td colspan="7">No orders found.</td></tr>');
                    }
                },


                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });

         //place order
         $(document).on('click', '#place_order_btn', function(e) {
                e.preventDefault();
                
                var orderId = $(this).data('id'); 
                Swal.fire({
                    title: "<div style='color: black;'>Are you sure?</div>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes",
                    customClass: {
                        popup: 'swal-small', 
                        title: 'swal-title-small',
                        cancelButton: 'swal-cancel-button-small', 
                        confirmButton: 'swal-confirm-button-small' 
                    }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/place-order', 
                                type: 'POST',
                                data: {
                                    data_id: orderId,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if(response.status === 'success') {
                                        // alert('Order placed successfully!');
                                        Swal.fire({
                                                    title: "success!",
                                                    text: "Order placed successfully!",
                                                    icon: "success"
                                                });
                                                location.reload();
                                    } else {
                                        Swal.fire({
                                                    title: "Warning!",
                                                    text: "order not placed",
                                                    icon: "warning"
                                                });
                                    }
                                },
                                error: function(response) {
                                    Swal.fire({
                                                title: "Warning!",
                                                text: 'order not placed',
                                                icon: "warning"
                                            });
                                }
                            });
                            
                        }
                    });
                    
                    
        });


        //SHOW DEVIVERY STATUS 
        $(document).on('click', '#show_status_btn', function(e) {
            e.preventDefault();
            
            var orderId = $(this).data('id'); 
           
            $.ajax({
                url: '/order/status', 
                type: 'POST',
                data: {
                    data_id: orderId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.status === 'success') {
                        
                        Swal.fire({
                                    title: "Checking Order From Stead fast!",
                                    text: response.message,
                                  
                                });
                    } else {
                        Swal.fire({
                                    title: "Warning!",
                                    text: "not found",
                                    icon: "warning"
                                });
                    }
                },
                error: function(response) {
                    Swal.fire({
                                    title: "Warning!",
                                    text: ' not placed',
                                    icon: "warning"
                                });
                }
                
            });
        });

    });

        

</script>

@endsection



