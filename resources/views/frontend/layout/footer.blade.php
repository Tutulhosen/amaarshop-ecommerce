<?php 
    $facebook= DB::table('social_link')->where('title', 'Facebook')->where('status', 1)->first();
    $twitter= DB::table('social_link')->where('title', 'twitter')->where('status', 1)->first();
    $youtube= DB::table('social_link')->where('title', 'Youtube')->where('status', 1)->first();
    $instagram= DB::table('social_link')->where('title', 'Instagram')->where('status', 1)->first();
    $admin= DB::table('users')->where('role_id', 1)->first();
?>
<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-menu">
                        <ul>
                            <li>
                                <a href="about-us.html">আমাদের সম্পর্কে</a>
                            </li>
                            <li>
                                <a href="delivery-policy.html">ডেলিভারি পলিসি</a>
                            </li>
                            <li>
                                <a href="return-policy.html">রিটার্ন পলিসি</a>
                            </li>
                        </ul>
                    </div>

                    <div class="social_links">
                        <ul>
                            <li>
                                <a class="facebook" target="_blank" href="{{($facebook) ? $facebook->link : ''}}"><i class="fa fa-facebook"></i> </a>
                            </li>
                            <li>
                                <a class="twitter" target="_blank" href="{{$twitter ? $twitter->link : ''}}"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a class="instagram" target="_blank" href="{{$instagram ? $instagram->link : ''}}"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a class="youtube" target="_blank" href="{{$youtube ? $youtube->link : ''}}"><i class="fa fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="copyright_text">
                        <p><i class="fa fa-copyright"></i> 2024 <a href="{{route('home')}}" target="_blank">{{$admin->company_name}}</a> All Right Reserved. Developed By <a href="https://www.facebook.com/Munna5106" target="_blank">Procoader</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>