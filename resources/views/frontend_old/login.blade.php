@extends('frontend.layout.app')

@section('main-content')
<section>
    <div class="login-section">
        <div class="login-container">

            <h2>Login</h2>
            <form action="{{route('frontend.customer.login')}}" method="POST">
                @csrf
                <div>
                    <label for="username">Phone or Email</label>
                    <input type="text" id="username" name="username" placeholder="Enter your Phone or Email" required>
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
                    <button type="submit">Login</button>
                </div>
            </form>
            <p>
                Don't have an account yet? <a href="{{route('frontend.register')}}">Sign Up</a>
            </p>
        </div>
    </div>
</section>
@endsection