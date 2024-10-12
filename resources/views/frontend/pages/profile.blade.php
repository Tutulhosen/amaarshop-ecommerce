@extends('frontend.layout.app')

@section('main-content')
    <section>
        <div class="dashboard-container">
        
            <!-- Dashboard Header -->
            <h1>Welcome to Your Dashboard</h1>
            <p>Manage your profile, view recent orders and more.</p>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                
                <!-- Left Column - Profile Info -->
                <div class="profile-info">
                    <h2>Profile Information</h2>
                    <p><strong>Name:</strong> {{Auth::guard('customer')->user()->name}}</p>
                    <p><strong>Email:</strong> {{Auth::guard('customer')->user()->email}}</p>
                    <p><strong>Phone:</strong> {{Auth::guard('customer')->user()->phone}}</p>
                    <a href="{{route('user.profile.update.page')}}" class="btn w-100">Edit Profile</a>
                </div>
                
                <!-- Middle Column - Recent Orders -->
                <div class="recent-orders">
                    <h2>Recent Orders</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($recent_order))
                                @foreach ($recent_order as $item)
                                <tr>
                                    <td>{{$item->order_code}}</td>
                                    <td>{{formatDate($item->order_date)}}</td>
                                    <td class="status shipped">{{order_status($item->order_status)}}</td>
                                    <td>{{$item->total_price}}</td>
                                    <td style="text-align:center"><a href="{{route('product.invoice', $item->max_id)}}" target="_blank"><i id="invoice" class="fa-solid fa-file-lines" style="font-size: 30px; text-align:center; cursor:pointer; color:green"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <h3 style="color: red, text-align:center">no order Found</h3>
                            @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
    
            <!-- Second Row - Wishlist and Saved Addresses -->
            <div class="dashboard-content">
                
                <!-- Left Column - Wishlist -->
                <div class="saved-addresses">
                    <h2>Saved Addresses</h2>
                    @if (!empty($customer_address))
                    <div class="row">
                        <div class="col-md-6">
                            <h2 style="font-size: 24px;">Permanent Addresses</h2><br>
                            <p><strong>Division:</strong> {{convert_div_id_to_name($customer_address->per_div)}}</p>
                            <p><strong>district:</strong> {{convert_dis_id_to_name($customer_address->per_dis)}}</p>
                            <p><strong>Upazila:</strong> {{convert_upa_id_to_name($customer_address->per_upa)}}</p>
                            <p><strong>Details:</strong> {{$customer_address->per_details}}</p>
                           
                        </div>
                        <div class="col-md-6">
                            <h2 style="font-size: 24px;">Present Addresses</h2><br>
                            <p><strong>Division:</strong> {{convert_div_id_to_name($customer_address->pre_div)}}</p>
                            <p><strong>district:</strong> {{convert_dis_id_to_name($customer_address->pre_dis)}}</p>
                            <p><strong>Upazila:</strong> {{convert_upa_id_to_name($customer_address->pre_upa)}}</p>
                            <p><strong>Details:</strong> {{$customer_address->pre_details}}</p>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    @else
                        
                    @endif
                    
                    <a href="{{route('user.address.update.page')}}" class="btn w-100">Manage Addresses</a>
                    
                </div>

                <!-- Right Column - Saved Addresses -->
                {{-- <div class="account-settings">
                    <h2>Account Settings</h2>
                    <p>Manage your account settings such as password, payment methods, and more.</p>
                    <button class="btn">Update Password</button>
                   
                </div> --}}
                
                
            </div>
    
            <!-- Account Settings Section -->
            {{-- <div class="account-settings">
                <h2>Account Settings</h2>
                <p>Manage your account settings such as password, payment methods, and more.</p>
                <button class="btn">Update Password</button>
                <button class="btn">Payment Methods</button>
            </div> --}}
        </div>
    </section>
@endsection