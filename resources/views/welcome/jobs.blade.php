  <header class="signup">

    <div class="background-image-holder parallax-background">
      <img class="background-image" width="100%" alt="Background Image" src="{!! asset('dist/assets/img/hero18.jpg') !!}">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
            <h2 class="text-white">
                Get your career started! Explore our listing of great job opportunities from our extensive network of employers
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
            <form method="post" action="/vjobs" class="mail-list-signup">
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
          <h1>{{ sizeof($jobs) }} Jobs</h1>
        </div>
      </div>
      <div class="row">
		@if (sizeof($jobs))
		@foreach($jobs as $job)
 		<div class="col-md-4 col-sm-6 blog-masonry-item development card" style="height: 200px; cursor:pointer">
            @if ($job->featured==0)
                <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
            @endif
          <div @click.prevent="showJob({{$job->id}})" class="item-inner quote-post">
            <div class="post-title" style="height:200px">
              <div class="row">
                <div class="col-md-1">
                    <img src="{{ $job->orglogo}}" style="width:68px" class="img-circle emp-logo">
                </div>
                <div class="col-md-8 col-md-offset-2" style="padding-left: 10px; text-align:left">
                  <h5 class="real-h5"> {{ $job->title }}</h5>
                  <p> {{ $job->teaser }}</p>
                  <div class="post-meta">
                    <div class="sub alt-font">
                        <small>
                           Location: {{ $job->city }}, {{ $job->country }}<br/>
                            Posted: {{ (isset($job->post_date)) ? date('d F, Y',strtotime($job->post_date->date)):date('d F, Y',strtotime($job->created_at))}}</small>
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
            No jobs found.
          </div>
        @endif
      </div>
    </div>
  </section>
