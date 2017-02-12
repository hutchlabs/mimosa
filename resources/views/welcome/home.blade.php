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

