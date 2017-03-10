<header class="signup">
    <div class="background-image-holder parallax-background">
        <img class="background-image" width="100%" alt="Background Image" src="{!! asset('dist/assets/img/hero10.jpg') !!}">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
                <h2 class="text-white"> {{ $profile->name }} Profile</h2>
            </div>
        </div>
    </div>
</header>

<section class="duplicatable-content" style="background:#d4d4d4">
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-sm-12 blog-masonry-item development card">
                <div class="item-inner quote-post">
                    <div style="background:#fff; padding:28px 32px 32px 32px; position:relative">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ (substr($profile->logo_url,0,1)!=='/') ? '/'.$profile->logo_url : $profile->logo_url}}" class="img-circle emp-logo">
                            </div>
                            <div class="col-md-6 pull-left">
                                <h5 class="real-h5"> {{ $profile->name }}</h5>
                                <h3>{{$profile->profile->summary}}</h3>
                                 <div class="sub alt-font">
                                    <small>Jobs Posted: {{ sizeof($profile->jobs) }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:20px">
                            <div class="col-md-11">
                                <div class="form-horizontal">
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">About</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            {{ $profile->profile->description}}
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Number of employees</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            {{ $profile->profile->num_employees }}
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Job Types</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">{{$profile->profile->job_types}}</div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Industry</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">{{$profile->profile->industries}}</div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Address</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            {!! $profile->profile->address !!}
                                        </div>
                                      </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!--end of row-->

    </div>
    <!--end of container-->
</section>
