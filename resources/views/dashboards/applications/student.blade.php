<gradlead-applications-user-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Applications</h1>
          <small class="text-muted">@{{authUser.name}}'s Applications</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
  
        <!-- Applications -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="apps.length> 0">
            <table id="resumestable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                       <th>Company</th>
                        <th>Job</th>
                        <th>Resume</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in apps">

                        <td class="spark-table-pad"> @{{ u.orgname }} </td>
                        <td class="spark-table-pad"> @{{ u.jobname }} </td>
                        <td class="spark-table-pad">
                           <span v-if="u.resume!=null"> 
                                <a :href="getFileUrl(u.resume.id)">
                                    <i class="fa fa-download icon"></i> Download
                                </a>
                            </span>
                            <span v-else>
                                No resume attached.
                            </span>
                        </td>
                        <td class="spark-table-pad">@{{ u.created_at }}</td>
                        <td class="spark-table-pad">@{{ u.status }}</td>
                        <td class="spark-table-pad">
                            <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeApp(u)">
                                <span>
                                    <i class="fa fa-trash-o"></i> Delete
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        
            <div v-else class="panel-body">
                No applications found.
            </div>

        </div>
        
      </div>
        <!-- / Resumes -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-applications-user-screen>
