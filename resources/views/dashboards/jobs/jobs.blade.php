<div class="col wrapper-md">
    <div class="clearfix m-b">
        <a class="btn btn-info btn-addon" href="#addjob" aria-controls="addjob" role="tab" data-toggle="tab"  @mouseover="clearFields('jobAddForm')">
            <i class="fa fa-plus"></i> Add Job
        </a>
    </div>
    
    <!-- Jobs -->
    <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
            <!-- table -->
            <div class="table-responsive" v-if="jobs.length> 0">

                <table class="table table-striped m-b-none">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Posted By</th>
                            <th>Plan</th>
                            <th>Applications</th>
                            <th>Posting Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="j in jobs">
                            <td class="spark-table-pad"> @{{ j.title }} </td>
                            <td class="spark-table-pad"> @{{ j.orgname }} </td>
                            <td class="spark-table-pad"> @{{ j.contract.plan.name }} </td>
                            <td class="spark-table-pad"> 
                                <span v-if="j.numapplications > 0">
                                <b class="badge bg-info">  @{{ j.numapplications }}</b>
                                <a class="btn btn-default btn-sm" href="#apps" aria-controls="apps" role="tab" data-toggle="tab" @click="setApps(j)">View</a>    
                                </span>
                                <span v-else>
                                     @{{ j.numapplications }}
                                </span>
                            </td>
                            <td class="spark-table-pad"> @{{ j.created_at }} </td>
                            
                            <td class="spark-table-pad">
                                @{{ j.status | status_text }}
                                <br/>
                                <button v-if="j.status" class="btn btn-warning btn-xs" @click.prevent="setStatus(j)" :disabled="settingStatus(j.id)">
                                    <span v-if="settingStatus(j.id)">
                                    <i class="fa fa-spinner fa-spin"></i> Deactivating..
                                </span>
                                    <span v-else>Deactivate</span>
                                </button>

                                <button v-else class="btn btn-default btn-xs" @click.prevent="setStatus(j)" :disabled="settingStatus(j.id)">
                                    <span v-if="settingStatus(j.id)">
                                    <i class="fa fa-spinner fa-spin"></i> Activating..
                                </span>
                                    <span v-else>Activate</span>
                                </button>
                            </td>

                            <td class="spark-table-pad">

                                <button class="btn btn-info btn-sm" @click="setJob(j)" @mouseover="clearFields('jobUpdateForm')">
                                    <i class="fa fa-pencil"></i> </button>

                                <button class="btn btn-danger  btn-sm" @click.prevent="removeJob(j)" :disabled="removingJob(j.id)">
                                    <span v-if="removingJob(j.id)"><i class="fa fa-spinner fa-spin"></i> 
                                </span>
                                    <span v-else><i class="fa fa-trash-o"></i></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="panel-body">
                No jobs found.
            </div>

        </div>

    </div>
    <!-- / Jobs -->

</div>
