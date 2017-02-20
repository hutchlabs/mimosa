<gradlead-jobs-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>

    <div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
        <!-- main -->
        <div class="col">

            <!-- main header -->
            <div class="bg-light lter b-b wrapper-md">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1 class="m-n font-thin h3 text-black">Jobs</h1>
                        <small class="text-muted">{{$name}} jobs</small>
                    </div>
                </div>
            </div>
            <!-- / main header -->

            <div class="col wrapper-md">

                <div class="app-content-body fade-in-up tab-content">
                    <div role="tabpanel" class="tab-pane active" id="vjobs">
                        @include('dashboards.jobs.jobs')    
                    </div>

                    <div role="tabpanel" class="tab-pane" id="apps">
                        @include('dashboards.jobs.applications')    
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="addjob">
                        @include('dashboards.jobs.jobs-add')    
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="editjob">
                        @include('dashboards.jobs.jobs-edit')    
                    </div>
                </div>

            </div>
        </div>
        <!-- / main -->
    </div>

</gradlead-jobs-screen>
