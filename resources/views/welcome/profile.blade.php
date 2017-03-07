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
                            <div class="col-md-1">
                                <img src="{{ $profile->profile->avatar}}" class="img-circle emp-logo">
                            </div>
                            <div class="col-md-11 pull-left">
                                <h5 class="real-h5"> {{ $profile->name }}</h5>
                                <h3>{{$profile->organization->name}}</h3>
                            </div>
                        </div>
                        <div class="row" style="padding-top:20px">
                            <div class="col-md-11">
                                <div class="form-horizontal">
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">About</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">{{$profile->profile->summary}}</div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Phone</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">{{$profile->profile->phone}}</div>
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
                                    
                                    @if($profile->type=='student' || $profile->type=='graduate')
                                    
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Education</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            @if (sizeof($profile->education))
                                                @foreach($profile->education as $ed)
                                                    <small style="display:block; margin-bottom:10px">
                                                        <b>{{ $ed->degree_level}} in {{ $ed->degree_major }}</b><br>  {{ $ed->university}},{{$ed->country}}, {{$ed->graduation}}
                                                        </small>
                                                @endforeach
                                            @else 
                                                No education listed.
                                            @endif
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Experience</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            @if (sizeof($profile->work))
                                                @foreach($profile->work as $i)
                                            <small><b>{{ $i->title}} at {{ $i->company }}</b>&nbsp; 
                                                    {{ date('F, Y', strtotime($i->start_date)) }} to {{ date('F, Y',strtotime($i->end_date)) }}</small><br/>
                                                @endforeach
                                            @else 
                                                No work experience listed.
                                            @endif
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Skills</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            @if (sizeof($profile->skills))
                                                @foreach($profile->skills as $i)
                                            <small>{{ preg_replace('/,/',', ',$i->skills)}}</small><br/>
                                                @endforeach
                                            @else 
                                                No skills listed
                                            @endif
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group m-b-sm">
                                      <label class="col-sm-3 control-label">Languages</label>
                                      <div class="col-sm-9">
                                        <div class="form-control-static">
                                            @if (sizeof($profile->languages))
                                                @foreach($profile->languages as $i)
                                            <small><b>{{ $i->language}}</b>, {{ $i->level }}</small><br/>
                                                @endforeach
                                            @else 
                                                No languages listed
                                            @endif
                                        </div>
                                      </div>
                                    </div>
                                    
                                    @endif
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
