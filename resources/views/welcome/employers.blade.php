  <header class="signup">

    <div class="background-image-holder parallax-background">
      <img class="background-image" width="100%" alt="Background Image" src="{!! asset('dist/assets/img/hero18.jpg') !!}">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
            <h2 class="text-white">
                Get your career started! Explore our extensive network of local and foreign employers.
            </h2>
        </div>
      </div>

    </div>
  </header>

  <section class="primary-features duplicatable-content" style="height:100px; min-height: 100px; padding-top:30px">
    <div class="container">
      <div class="row">

        <div class="col-sm-12 text-center">
          <div class="photo-form-wrapper clearfix">
            <form method="post" action="/employers" class="mail-list-signup">
              <div class="row">    
                <div class="col-md-3 col-sm-3 col-md-offset-2 col-sm-offset-2">
                  <input class="signup-name-field validate-required" name="q" id="q" type="text" placeholder="Company name" value="{{$q}}">
                </div>
                <div class="col-md-4 col-sm-4">
                    <input class="signup-email-field validate-required validate-email" name="loc" id="loc" type="text" placeholder="Location" value="{{$loc}}">
                </div>
                <div class="col-md-3 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="Search" style="margin-top:5px;">
                </div>
              </div>
            </form>
          </div>

        </div>

      </div><!--end of row-->

    </div><!--end of container-->
  </section>
  
  <section class="clients-2" style="background:#d4d4d4">
    <div class="container">
     <div class="row">
        <div class="col-md-12 text-center">
          <h1>{{ sizeof($orgs) }} Employers</h1>
        </div>
      </div>
      <div class="row">
		@if (sizeof($orgs))
		@foreach($orgs as $org)
 		<div class="col-md-4 col-sm-6 blog-masonry-item development card" style="height: 162px; cursor:pointer">
          <div @click.prevent="showEmployer({{$org->id}})" class="item-inner quote-post">
            <div class="post-title" style="height:162px">
              <div class="row">
                <div class="col-md-1">
                    <img src="{{ $org->logo_url}}" class="img-circle emp-logo">
                </div>
                <div class="col-md-8 col-md-offset-2" style="padding-left: 10px; text-align:left">
                  <h5 class="real-h5"> {{ $org->name }}</h5>
                  <div class="post-meta">
                    <div class="sub alt-font">
                        <small>
                            Jobs Posted: {{ sizeof($org->jobs) }}<br>
                            {{ str_limit((($org->profile->job_types=='') ? '' : $org->profile->job_types.' jobs'),25,'...')}}<br>
                        </small>
                        {{ str_limit($org->profile->industries, 15 ,'...') }}<br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        
        @else
          <div class="col-md-12 col-sm-12 blog-masonry-item development card" >
            No employers found.
          </div>
        @endif
      </div>
    </div>
  </section>
