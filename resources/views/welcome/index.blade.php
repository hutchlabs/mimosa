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
    <link href="{{ asset('dist/assets/css/theme-aquatica.css') }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
@include('welcome.nav') 

<div class="main-container">

  <header class="signup">
    <div class="background-image-holder parallax-background">
      <img class="background-image" width="100%" alt="Background Image" src="{{ asset('dist/assets/img/hero17.jpg') }}">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
          <h2 class="text-white">Kick-start your career on Gradlead, the preferred career network for students and graduates.
            Jobs, internships, and graduate programmes, it’s all there.</h2>
        </div>
      </div>

      <div class="row text-center">

        <div class="col-sm-12 text-center">
          <div class="photo-form-wrapper clearfix">
            <form class="mail-list-signup">
              <div class="row">
                <div class="col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2">
                  <input class="signup-name-field validate-required" type="text" placeholder="Enter Search Query">
                </div>

                <div class="col-md-4 col-sm-4">
                  <input class="signup-email-field validate-required validate-email" type="text" placeholder="Add Location">
                </div>

                <div class="col-md-12 col-md-offset-0 col-sm-4 col-sm-offset-4 text-center">
                  <input type="submit" class="btn btn-primary btn-filled" value="Search">
                </div>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
  </header>

  <section class="primary-features duplicatable-content">
    <div class="container">
      <div class="row">

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="icon icon-document"></i>
            <h6 class="text-white">Fully Documented</h6>
            <p class="text-white">
              Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labor.
            </p>
          </div><!--end of feature-->
        </div>

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="icon icon-linegraph"></i>
            <h6 class="text-white">Flexible &amp; Modular</h6>
            <p class="text-white">
              Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labor.
            </p>
          </div><!--end of feature-->
        </div>

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="icon icon-target"></i>
            <h6 class="text-white">Super Sleek Icons</h6>
            <p class="text-white">
              Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labor.
            </p>
          </div><!--end of feature-->
        </div>

      </div><!--end of row-->

    </div><!--end of container-->
  </section>

  <section class="duplicatable-content" style="background:#d4d4d4">
    <div class="container">    
      <div class="row">
            <div class="col-md-12 text-center">
              <h1>Jobs In Ghana</h1>
            </div>
      </div>
      
      <div class="row">
        <spark-featured-jobs></spark-featured-jobs>
      </div>

    </div>
  </section>
  
  <section class="clients-2">
    <div class="container">
     <div class="row">
        <div class="col-md-12 text-center">
          <h1>Featured Companies</h1>
        </div>
      </div>
      <div class="row">
        <spark-featured-employers></spark-featured-employers>
      </div>
    </div>
  </section>

</div>


<div class="footer-container">
  <footer class="short bg-secondary-1">
    <div class="container">
      <div class="row">
        <div class="col-sm-10">
          <span class="sub">© Copright 2014 Medium Rare</span>
          <ul>
            <li><a href="#">Terms Of Use</a></li>
            <li><a href="#">Privacy &amp; Security Statement</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
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

<script src="{{ asset('dist/assets/js/jquery.min.js') }}"></script>
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


</body>

</html>
