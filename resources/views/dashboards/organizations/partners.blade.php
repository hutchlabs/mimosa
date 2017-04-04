<gradlead-orgs-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Partners</h1>
          <small class="text-muted">Registered Partners</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <button class="btn btn-info btn-addon" @click.prevent="addOrganization('school')">
                <i class="fa fa-plus"></i> Add Partner
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
                        <th># of Users</th>
                        <th>Employer Affiliations</th>
                        <th>Profile</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="o in schools">

                        <td class="spark-table-pad"> @{{ o.name }} </td>
                        <td class="spark-table-pad"> @{{ o.numusers }} </td>
                        <td class="spark-table-pad"> @{{ o | affiliations }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-default btn-addon btn-sm btn-circle" @click.prevent="viewProfile(o)">
                                <i class="fa fa-institution"></i> Profile</button>
                        </td>
                        
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
                No Partners found.
            </div>

        </div>


      </div>
        <!-- / Schools -->

    </div>
  
  </div>
  <!-- / main -->
          
        @include('dashboards.organizations.partners-add') @include('dashboards.organizations.partners-edit')
        @include('dashboards.organizations.partners-profile-view')
</div>

</gradlead-orgs-screen>
