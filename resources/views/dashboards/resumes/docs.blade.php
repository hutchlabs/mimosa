<gradlead-resumes-screen v-bind:auth-user="authUser" v-bind:usertype="usertype" v-bind:permissions="permissions" inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
       
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <button class="btn btn-info btn-addon" @click.prevent="addDoc()">
                <i class="fa fa-plus"></i> Add 
            </button>
      </div>
  
        <!-- Documents -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="docs.length> 0">
            <table id="docstable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>View</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in docs">

                        <td class="spark-table-pad"> @{{ u.name }} </td>
                        <td class="spark-table-pad"> @{{ u.description }} </td>
                        <td class="spark-table-pad">
                           <span v-if="u!=null"> 
                                <a :href="getDocUrl(u.id)"><i class="fa fa-download icon"></i> Download</a>
                            </span>
                            <span v-else>
                                No file attached.
                            </span>
                        </td>
                        <td class="spark-table-pad">
                            <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeDoc(u)">
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
                No documents found.
            </div>

        </div>
        
        @include('dashboards.resumes.adddoc') 
      </div>
        <!-- / Resumes -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-resumes-screen>
