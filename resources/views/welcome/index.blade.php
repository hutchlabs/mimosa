<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Gradlead</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="{{ asset('dist/assets/css/flexslider.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('dist/assets/css/line-icons.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('dist/assets/css/elegant-icons.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('dist/assets/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('dist/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('dist/assets/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" media="all"/>

    <link href="{{ asset('dist/assets/css/theme-aquatica.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" />

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]); ?>;
        window.Spark = { csrfToken: '{{  csrf_token() }}' };
    </script>

    <!--[if gte IE 9]>
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/assets/css/ie9.css') }}" />
    <![endif]-->
    <script src="{{ asset('dist/assets/js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<body>
<div id="app">

<gradlead-welcome-screen inline-template> 
<div>

<!-- CONTENT -->
@include('welcome.nav', array('link'=>$link)) 

<div class="main-container">

 @if($link=='profile')
    @include('welcome.profile', array('tid'=>$tid,'theme'=>$theme))

 @elseif($link=='jobs')
    @include('welcome.jobs', array('tid'=>$tid,'theme'=>$theme))
 @elseif($link=='jobs-profile')
    @include('welcome.jobs-profile', array('tid'=>$tid,'theme'=>$theme))

 @elseif($link=='employers')
    @include('welcome.employers', array('tid'=>$tid,'theme'=>$theme))
 @elseif($link=='employers-profile')
    @include('welcome.employers-profile', array('tid'=>$tid,'theme'=>$theme))

 @elseif($link=='partners')
    @include('welcome.partners', array('tid'=>$tid,'theme'=>$theme))

 @elseif($link=='contact')
    @include('welcome.contact', array('tid'=>$tid,'theme'=>$theme))

 @else
    @include('welcome.home', array('tid'=>$tid,'theme'=>$theme))
 @endif

</div>


<div class="footer-container">
  <footer class="short bg-secondary-1">
    <div class="container">
      <div class="row">
        <div class="col-sm-10">
          <span class="sub">&copy; 2017 Gradlead </span>
         <!--
          <ul>
            <li><a href="#">Terms Of Use</a></li>
            <li><a href="#">Privacy &amp; Security Statement</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
-->
        </div>

        <div class="col-sm-2 text-right">
          <ul class="social-icons">
            <li>
              <a href="#">
                <i class="icon social_twitter"></i>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="icon social_facebook"></i>
              </a>
            </li>
          </ul>
        </div>
      </div><!--end of row-->
    </div><!--end of container-->
  </footer>

</div>

</div>
</gradlead-welcome-screen>

</div>


<!-- / CONTENT -->

<script src="{{ asset('js/vendors/jquery.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/jquery.plugin.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/jquery.flexslider-min.js') }}"></script>
<script src="{{ asset('dist/assets/js/smooth-scroll.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/skrollr.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/spectragram.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/scrollReveal.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/isotope.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/twitterFetcher_v10_min.js') }}"></script>
<script src="{{ asset('dist/assets/js/lightbox.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/vendors/bootstrap-editable.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7T2ffkCZ8eou8ylORC8C5SkMmWmSxyiM&libraries=places"></script>


 @yield('script')

</body>
</html>
