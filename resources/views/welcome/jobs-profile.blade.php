<header class="signup">
    <div class="background-image-holder parallax-background">
        <img class="background-image" width="100%" alt="Background Image" src="{!! asset('dist/assets/img/hero10.jpg') !!}">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center">
                <h2 class="text-white"> Job: {{ $job->title }} </h2>
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
                                <img src="{{ (substr($job->orglogo,0,1)!=='/') ? '/'.$job->orglogo : $job->orglogo}}" class="img-circle emp-logo">
                            </div>
                            <div class="col-md-9 pull-left">
                                <h5 class="real-h5"> {{ $job->title }}</h5>
                                @if (isset($job->organization->profile->website))
                                <h3><a href="{{$job->organization->profile->website}}">{{$job->organization->name}}</a></h3>
                                @else
                                    <h3>{{$job->organization->name}}</h3>
                                @endif
                                
                                 <div class="post-meta">
                                    <div class="sub alt-font">Posted: {{ date('d F, Y',strtotime($job->created_at))}}</div>
                                 </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:20px">
                           <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <div class="form-horizontal">
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Description</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            <b>{{$job->teaser}}</b>
                                            <p>
                                                {{$job->description_text}}
                                            </p>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Location</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            {!! $job->address !!}
                                        </div>
                                      </div>
                                    </div>
                                            
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Remote?</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            {{ ($job->remote) ? 'Yes' : 'No' }}
                                        </div>
                                      </div>
                                    </div>
                                    
                                                                        
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Expires</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">{{ date('d F, Y',strtotime($job->end_date))}}</div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">&nbsp;</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            <input type="submit" class="btn btn-warning btn-filled" value="Apply">
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
