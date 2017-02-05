<gradlead-plans-screen inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Pricing Plans</h1>
          <small class="text-muted">{{$name}} Pricing plans</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <button class="btn btn-info btn-addon" @click.prevent="addPlan()">
                <i class="fa fa-plus"></i> Add Plan
            </button>
      </div>
  
        <!-- Pricing -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="plans.length> 0">

            <table class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>Posts</th>
                        <th>Notifications</th>
                        <th>Feature Job?</th>
                        <th>Feature Employer?</th>
                        <th>Duration (Days)</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in plans">

                        <td class="spark-table-pad"> @{{ p.name }} </td>
                        <td class="spark-table-pad"> GHC @{{ p.cost }} </td>
                        <td class="spark-table-pad"> @{{ p.num_posts | infinite_check }} </td>
                        <td class="spark-table-pad"> @{{ p.num_notifications | infinite_check }} </td>
                        <td class="spark-table-pad"> @{{ p.feature_job | feature_check }} </td>
                        <td class="spark-table-pad"> @{{ p.feature_company | feature_check }} </td>
                        <td class="spark-table-pad"> @{{ p.duration | duration_text }} </td>
                        <td class="spark-table-pad"> @{{ p.start_date }} </td>
                        <td class="spark-table-pad"> @{{ p.end_date }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editPlan(p)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removePlan(p)" :disabled="removingPlan(p.id)">
                                <span v-if="removingPlan(p.id)">
                                    <i class="fa fafa-spinner fa-spin"></i> Removing
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i> Delete
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        
            <div v-else class="panel-body">
                No plans found.
            </div>

        </div>
        
        @include('dashboards.plans.add') @include('dashboards.plans.edit') 
      </div>
        <!-- / Pricing -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-plans-screen>
