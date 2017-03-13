<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3"><i class="icon-text i-sm m-r-sm"></i> Job > @{{ currentJob.title }}</h1>
</div>

<div class="panel hbox hbox-auto-xs no-border">

    <div class="col wrapper">
        <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>

        <div class="clearfix m-b">
            <a class="btn btn-default btn-addon" href="#searchpage" aria-controls="searchpage" role="tab" data-toggle="tab">
                <i class="fa fa-long-arrow-left"></i> Back
            </a>&nbsp;&nbsp;
        </div>

        <section class="duplicatable-content">
            <div class="container">
                <div class="row">

                    <div class="col-md-8 col-sm-12 blog-masonry-item development card">
                        <div class="item-inner quote-post">
                            <div style="background:#fff; padding:28px 32px 32px 32px; position:relative">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img :src="currentJob.orglogo" class="img-circle emp-logo" style="height: 48px">
                                    </div>
                                    <div class="col-md-9 pull-left">
                                        <h3>
                                            <a :href="getOrgUrl(currentJob)" target="_blank">@{{currentJob.orgname}}</a>
                                        </h3>

                                        <div class="post-meta">
                                            <div class="sub alt-font">Posted: @{{currentJob.created_at|nice_date}}</div>
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
                                                        <b>@{{currentJob.teaser}}</b>
                                                        <p>
                                                            @{{currentJob.description_text}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m-b-sm">
                                                <label class="col-sm-3 control-label">Location</label>
                                                <div class="col-sm-9">
                                                    <div class="form-control-static">
                                                        @{{ currentJob.address }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m-b-sm">
                                                <label class="col-sm-3 control-label">Remote?</label>
                                                <div class="col-sm-9">
                                                    <div class="form-control-static">
                                                        @{{ (currentJob.remote) ? 'Yes' : 'No' }}
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Expires</label>
                                                <div class="col-sm-9">
                                                    <div class="form-control-static">@{{ currentJob.end_date | nice_date}}</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">&nbsp;</label>
                                                <div class="col-sm-9">
                                                    <div class="form-control-static">
                                                       <p v-if="!hasApplied(currentJob)">
                                                        <a @click.prevent="apply(currentJob)">
                                                           <span class="label bg-primary pos-rlt m-r inline wrapper-sm"><i class="glyphicon glyphicon-open"></i> Apply
                                                           </span> 
                                                        </a>
                                                    </p>
                                                    <p v-else>
                                                        <b>Applied. Status: @{{ appStatus(currentJob.id) }}</b>
                                                    </p>
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
    </div>
</div>
