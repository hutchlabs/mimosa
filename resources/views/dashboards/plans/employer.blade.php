<gradlead-plans-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype" inline-template>

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
             <spark-error-alert :form="forms.addContract"></spark-error-alert>
              <form class="form-horizontal panel" role="form" style="padding-top:10px;">
                    <div class="row">
                        <div class="col-md-9">
                            <spark-select :display="'Plans*'" :form="forms.addContract" :name="'plan_id'" 
                                          :items="availablePlans" :input="forms.addContract.plan_id">
                            </spark-select>
                        </div>
                        <div class="col-md-3 pull-right">
                            <button class="btn btn-info btn-md btn-addon" @click.prevent="addContract()">
                                <i class="fa fa-plus"></i> Buy Plan
                            </button>
                        </div>
                    </div>
              </form>
      </div>
  
      <div class="panel hbox hbox-auto-xs no-border">
        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="contracts.length> 0">

            <table class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Cost</th>
                        <th>Remaing Posts</th>
                        <th>Features Job?</th>
                        <th>Features Employer?</th>
                        <th>Started</th>
                        <th>Ends</th>
                        <th>Expired?</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="c in contracts">
                        <td class="spark-table-pad"> @{{ c.plan.name }} </td>
                        <td class="spark-table-pad"> GHC @{{ c.plan.cost }} </td>
                        <td class="spark-table-pad" v-if="c.plan.num_posts==0"> Unlimited </td>
                        <td class="spark-table-pad" v-else> @{{ c.remaining_posts | infinte_check }} of @{{ c.plan.num_posts | infinite_check }} </td>
                        <td class="spark-table-pad"> @{{ c.plan.feature_job | feature_check }} </td>
                        <td class="spark-table-pad"> @{{ c.plan.feature_company | feature_check }} </td>
                        <td class="spark-table-pad"> @{{ c.start_date }} </td>
                        <td class="spark-table-pad"> @{{ c.end_date }} </td>
                        <td class="spark-table-pad"> @{{ c.expired | expiry_check }} </td>

                        <td class="spark-table-pad">
                            <button v-show="!c.expired" class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeContract(c)">
                                <span> <i class="fa fa-trash-o"></i> Terminate </span>
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
      </div>
        <!-- / Pricing -->

        <!-- Pricing -->
    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-plans-screen>
