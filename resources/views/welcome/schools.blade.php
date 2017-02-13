
  <header class="signup">

    <div class="background-image-holder parallax-background">
      <img class="background-image" width="100%" alt="Background Image" src="{{ asset('dist/assets/img/hero18.jpg') }}">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
            <h2 class="text-white">
                {{ $theme->schools_header }}
            </h2>
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
            <h6 class="text-white">{{ $theme->schools_first_title }}</h6>
            <p class="text-white">
                {{ $theme->schools_first }}
            </p>
          </div><!--end of feature-->
        </div>

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="icon icon-linegraph"></i>
            <h6 class="text-white">{{ $theme->schools_second_title }}</h6>
            <p class="text-white">
                {{ $theme->schools_second }}
            </p>
          </div><!--end of feature-->
        </div>

        <div class="col-md-4 col-sm-6 clearfix">
          <div class="feature feature-icon-small">
            <i class="icon icon-target"></i>
            <h6 class="text-white">{{ $theme->schools_third_title }}</h6>
            <p class="text-white">
                  {{ $theme->schools_third }}
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
