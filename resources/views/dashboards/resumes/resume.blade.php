<gradlead-resumes-screen v-bind:auth-user="authUser" v-bind:usertype="usertype" v-bind:permissions="permissions" inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
       
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <button class="btn btn-info btn-addon" @click.prevent="addResume()">
                <i class="fa fa-plus"></i> Add 
            </button>
      </div>
  
        <!-- Resumes -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="resumes.length> 0">
            <table id="resumestable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Default</th>
                        <th>View</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in resumes">

                        <td class="spark-table-pad"> @{{ u.name }} </td>
                        <td class="spark-table-pad"> 
                            <label class="i-switch m-t-xs m-r">
                                <input v-model="defaults[u.id]" type="checkbox" @click="updateDefault(u)"><i></i>
                            </label>
                        </td>
                        <td class="spark-table-pad">
                           <span v-if="u!=null"> 
                                <a :href="getFileUrl(u.id)">
                                    <i class="fa fa-download icon"></i> Download
                                </a>
                            </span>
                            <span v-else>
                                No file attached.
                            </span>
                        </td>
                        <td class="spark-table-pad">
                            <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeResume(u)">
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
                No resumes found.
            </div>

        </div>
        
        @include('dashboards.resumes.add') 
      </div>
        <!-- / Resumes -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-resumes-screen>
