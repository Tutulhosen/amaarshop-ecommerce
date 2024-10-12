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
    <div class="container pt-2">
        <div class="card" style="padding: 10px; background-color:#e4e6e8">
            <div class="row">
                <div class="col-12">
                    <form id="search-form">
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Order name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="text" id="phone" name="phone" placeholder="Phone Number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" placeholder="email" class="form-control">
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
                    <h3 class="card-header text-center bg-success text-white">Member List</h3>
                    <div class="table-responsive text-nowrap">
                        <table class="table ">
                            <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Total Order</th>
                                <th>Pending</th>
                                <th>delivered</th>
                                <th>Return</th>
                                
                                
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$member['name']}}</td>
                                            <td>{{$member['email']}}</td>
                                            <td>{{$member['phone']}}</td>
                                            <td>{{$member['total_order']}}</td>
                                            <td>{{$member['pending_order']}}</td>
                                            <td>{{$member['delivered_order']}}</td>
                                            <td>{{$member['reject_order']}}</td>
                                            
                                        </tr>
                                    @endforeach
                            </tbody>
                            
                        </table>
                    
                    </div>
                    <div class="row mt-md-4 mt-2 pagination" style="width: 100%; margin:auto">
                        <div class="col-5"></div>
                        <div class="col-4" >
                            
                            {!! $paginate->links('pagination::bootstrap-4') !!}
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
        
        $('#search_btn').on('click', function() {
            let name = $('#name').val();
            let phone = $('#phone').val();
            let email = $('#email').val();
            let date_to = $('#date_to').val();
            let date_from = $('#date_from').val();

            $.ajax({
                url: "{{ route('admin.member.search') }}", 
                method: 'GET',
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    date_to: date_to,
                    date_from: date_from
                },
                success: function(response) {
                    
                    $('.table tbody').empty();
                    $('.pagination').hide();

                
                    
                    if (response.table_rows.length > 0) {
                        response.table_rows.forEach(function(member, index) {
                            $('.table tbody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${member.name}</td>
                                    <td>${member.email}</td>
                                    <td>${member.phone}</td>
                                    <td>${member.total_order}</td>
                                    <td>${member.pending_order}</td>
                                    <td>${member.delivered_order}</td>
                                    <td>${member.reject_order}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('.table tbody').append('<tr><td colspan="8">No members found.</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });
    });
</script>


@endsection



