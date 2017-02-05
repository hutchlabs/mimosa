<gradlead-orgs-screen inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Schools</h1>
          <small class="text-muted">Registered Schools</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <button class="btn btn-info btn-addon" @click.prevent="addOrganization('school')">
                <i class="fa fa-plus"></i> Add School
            </button>
      </div>
  
        <!-- Schools -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="schools.length> 0">
            <table id="orgstable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subdomain</th>
                        <th># of Users</th>
                        <th>Employer Affiliations</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="o in schools">

                        <td class="spark-table-pad"> @{{ o.name }} </td>
                        <td class="spark-table-pad"> @{{ o.subdomain }} </td>
                        <td class="spark-table-pad"> @{{ o.numusers }} </td>
                        <td class="spark-table-pad"> @{{ o | affiliations }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editOrganization(o)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeOrganization(o)" :disabled="removingOrganization(o.id)">
                                <span v-if="removingOrganization(o.id)"> <i class="fa fafa-spinner fa-spin"></i> Removing </span>
                                <span v-else> <i class="fa fa-trash-o"></i> Delete </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        
            <div v-else class="panel-body">
                No schools found.
            </div>

        </div>
        
        @include('dashboards.organizations.schools-add') @include('dashboards.organizations.schools-edit')
      </div>
        <!-- / Schools -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-orgs-screen>
