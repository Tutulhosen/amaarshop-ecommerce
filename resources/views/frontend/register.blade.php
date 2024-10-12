@extends('frontend.layout.app')

@section('main-content')
<section>
    <div class="login-section">
        <div class="login-container">
            <h2>Register</h2>
            <form action="{{route('frontend.customer.register')}}" method="POST">
                @csrf
                <div>
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div>
                    <label for="name">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div>
                    <label for="name"> Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your Phone" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
            
                {{-- <div style="display: flex; align-items: center;">

                    <input type="checkbox" id="remember" name="remember" style="margin-right: 10px;margin-top: 7px;">
                    <label for="remember">Remember Me</label>
                </div> --}}
                
                <div style="text-align: center;">
                    <button type="submit">Submit</button>
                </div>
            </form>
            <p>
                Already have an account?  <a href="{{route('frontend.login')}}">Login</a>
            </p>
        </div>
    </div>
</section>
@endsection