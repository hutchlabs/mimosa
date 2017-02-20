<gradlead-applications-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>
    <div>

        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
                <!-- main header -->
                <div class="bg-light lter b-b wrapper-md">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <h1 class="m-n font-thin h3 text-black">Applications</h1>
                            <small class="text-muted">{{$name}} jobs</small>
                        </div>
                    </div>
                </div>
                <!-- / main header -->
            </div>
        </div>

        <div class="hbox hbox-auto-xs hbox-auto-sm bg-light fade-up-in" style="height:780px" v-if="everythingLoaded">
            
            <!-- Jobs & Bins -->
            <div class="col w b-r">
                <div class="vbox">
                    <div class="wrapper-sm b-b bg-white-only">
                        <div class="input-group m-b-xxs">
                            <select class="form-control input-sm no-border no-bg text-md" style="width:170px;" 
                                   v-model="currentJob" placeholder="Select Job">
                                <option :value="defaultJob">All Jobs</option>
                                <option v-for="j in jobs" :value="j">
                                    @{{ j.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row-row">
                        <div class="cell scrollable hover">
                            <div class="cell-inner">
                                <div class="list-group no-radius no-border no-bg m-b-none">
                                    <a class="list-group-item b-b" :class="(filter=='') ? 'focus':''" @click.prevent="selectBin({name:''})">All Applications                                 <b :class="binCountClass('')">@{{ binCount('') }}</b>
</a>
                                    <a v-for="item in bins" v-show="permissions.canDoTracking" class="list-group-item m-l hover-anchor b-a no-select" :class="((filter==item.name) ? 'focus m-l-none': '')" @click.prevent="selectBin(item)">
                                        <span class="block m-l-n" :class="(filter==item.name ? 'm-n': '')">@{{item.name}}
                                            <b :class="binCountClass(item.name)">@{{ binCount(item.name) }}</b>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper b-t">&nbsp;</div>
                </div>
            </div>
            <!-- / Jobs & bins -->

            <!-- Applicants -->
            <div class="col w-lg lter b-r">
                <div class="vbox">
                    <div class="wrapper-sm b-b bg-white-only">
                        <div class="input-group m-b-xxs">
                            <span class="input-group-addon input-sm no-border no-bg"><i class="icon-magnifier text-md m-t-xxs"></i></span>
                            <input type="text" class="form-control input-sm no-border no-bg text-md" placeholder="Search Applicants" v-model="query">
                        </div>
                    </div>
                    <div class="row-row">
                        <div class="cell scrollable hover">
                            <div class="cell-inner">
                                <div v-if="hasApps" class="m-t-n-xxs">
                                    <div class="list-group list-group-lg no-radius no-border no-bg m-b-none">
                                        <a v-for="item in availableApps" class="list-group-item m-l" :class="(currentApp.id==item.id) ? 'select m-l-none': ''" @click.prevent="selectApp(item)">
                                            <span class="block text-ellipsis m-l-n text-md" :class="(currentApp.id==item.id) ? 'm-l-none':''">
                                                      <strong v-if="item.applicant!=''">@{{ item.applicant }}</strong>
                                                      <strong v-else>No Name</strong>
                                                </span>
                                        </a>
                                    </div>
                                </div>
                                <div v-else class="text-center pos-abt w-full" style="top:50%;">No Applicants</div>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper b-t">&nbsp;</div>
                </div>
            </div>
            <!-- /Applicants -->

            <!-- Applicant -->
            <div class="col bg-white-only">
                <div class="vbox">
                    <div class="wrapper-sm b-b" style="padding:11.5px">
                        <div v-if="permissions.canDoTracking" class="m-t-n-xxs m-b-n-xxs m-l-xs">
                                <a class="btn btn-sm btn-danger  btn-addon pull-right" v-show="canRejectApp" @click.prevent="setStatus('Rejected')"><i class="fa fa-trash-o"></i> Reject</a>

                            <div v-show="isPending">
                                <a class="btn btn-sm btn-success btn-addon" @click.prevent="setStatus('Approved')"><i class="fa fa-thumbs-up"></i>Approve</a>
                            </div> 
                            <div v-show='isApproved'>
                                <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Pending')"><i class="fa fa-mail-reply"></i> Back to Pending</a>  
                                <a class="btn btn-sm btn-success btn-addon" @click.prevent="setStatus('Interviewed')"><i class="fa fa-microphone"></i> Interview</a>
                            </div>
                            <div v-show='isInterviewed'>
                                <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Pending')"><i class="fa fa-mail-reply"></i> Back to Pending</a>   
                                 <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Approved')"><i class="fa fa-mail-reply"></i> Back to Approved</a>  
                                <a class="btn btn-sm btn-success btn-addon" @click.prevent="setStatus('Hired')"><i class="fa fa-gavel"></i> Hire</a>                  
                            </div>
                            <div v-show='isHired'>
                                <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Pending')"><i class="fa fa-mail-reply"></i> Back to Pending</a>   
                                 <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Approved')"><i class="fa fa-mail-reply"></i> Back to Approved</a>    
                                <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Interviewed')"><i class="fa fa-mail-reply"></i> Back to Interviewed</a>              
                            </div>
                            <div v-show='isRejected'>
                                <a class="btn btn-sm btn-addon btn-default" @click.prevent="setStatus('Pending')"><i class="fa fa-undo"></i> Unreject</a>
                            </div>
                            <div v-show='isFailed'>
                                <a class="btn btn-sm btn-default btn-addon" @click.prevent="setStatus('Pending')"><i class="fa fa-refresh"></i> Re-evaluate</a> 
                            </div>
                        </div>
                        <div v-else class="m-t-n-xxs m-b-n-xxs m-l-xs">
                            <span style="font-size:21px">Details</span>
                        </div>
                    </div>
                    <div class="row-row">
                        <div class="cell">
                            <div class="cell-inner">
                                <div class="wrapper-lg">
                                    <div class="hbox h-auto m-b-lg">
                                        <div class="col text-center w-sm">
                                            <div class="thumb-lg avatar inline">
                                                <img :src="(currentApp.avatar)?currentApp.avatar:'img/a0.jpg'" />
                                            </div>
                                        </div>
                                        <div class="col v-middle h1 font-thin">
                                            <div>@{{currentApp.applicant}}</div>
                                        </div>
                                    </div>
                                    <!-- fields -->
                                        <div class="form-horizontal">
                                            <div class="form-group m-b-sm" v-show="currentApp.created_at">
                                                <label class="col-sm-3 control-label">Date Applied</label>
                                                <div class="col-sm-9">
                                                    <p class="form-control-static">@{{currentApp.created_at}}</p>
                                                </div>
                                            </div>
                                            <div class="form-group m-b-sm" v-show="currentApp.resume">
                                                <label class="col-sm-3 control-label">Resume</label>
                                                <div class="col-sm-9">
                                                    <p class="form-control-static">@{{currentApp.resumee}}</p>
                                                </div>
                                            </div>
                                      
                                             <div class="form-group m-b-sm" v-show="currentApp.screening_score">
                                                <label class="col-sm-3 control-label">Screening Score</label>
                                                <div class="col-sm-9">
                                                    <p class="form-control-static">@{{currentApp.screening_score}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- / fields -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /column -->
        </div>

    </div>
</gradlead-applications-screen>
