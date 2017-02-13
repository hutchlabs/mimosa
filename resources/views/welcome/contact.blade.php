
  <header class="signup">
    <div class="background-image-holder parallax-background">
      <img class="background-image" width="100%" alt="Background Image" src="{!! asset('dist/assets/img/hero10.jpg') !!}">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
          <h2 class="text-white"> {!! $theme->contact_header !!}</h2>
        </div>
      </div>
    </div>
  </header>

  <section class="primary-features duplicatable-content">
    <div class="container">
      <div class="row">

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="glyphicon glyphicon-phone-alt" class="text-align:center"></i>
            <h6 class="text-white">{!! $theme->contact_first_title !!}</h6>
            <p class="text-white">
                {!! $theme->contact_first !!}

            </p>
          </div><!--end of feature-->
        </div>

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="glyphicon glyphicon-envelope" class="text-align:center"></i>
            <h6 class="text-white">{!! $theme->contact_second_title !!}</h6>
            <p class="text-white">
                {!! $theme->contact_second !!}
            </p>
          </div><!--end of feature-->
        </div>

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="glyphicon glyphicon-map-marker" class="text-align:center"></i>
            <h6 class="text-white">{!! $theme->contact_third_title !!}</h6>
            <p class="text-white">
                {!! $theme->contact_third !!}
            </p>
          </div><!--end of feature-->
        </div>

      </div><!--end of row-->

    </div><!--end of container-->
  </section>

