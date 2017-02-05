<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>
        <h2>Applications for @{{ getJobName() }}</h2>
    </div>
    
    
    <!-- Apps -->
    <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
            <!-- table -->
            <div class="table-responsive" v-if="apps.length> 0">

                <table class="table table-striped m-b-none">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Date Applied</th>
                            <th>Resume</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="a in apps">
                            <td class="spark-table-pad"> @{{ a.applicant }} </td>
                            <td class="spark-table-pad"> @{{ a.created_at }} </td>
                            <td class="spark-table-pad"> 
                               <span v-if="a.resume">
                                    <i class="fa fa-text-o"></i> <a href="">Resume link</a> 
                               </span>
                               <span v-else>No resume attached</span>
                            </td>
                            <td class="spark-table-pad"> @{{ a.status }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="panel-body">
                No apps found.
            </div>

        </div>

    </div>
    <!-- / Apps -->

</div>
