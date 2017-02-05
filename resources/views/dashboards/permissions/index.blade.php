<gradlead-permissions-screen inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Permissions</h1>
          <small class="text-muted">{{$name}} Organization Permissions</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
  
        <!-- Permisions -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="organizations.length> 0">
            <table id="permstable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Pre-Select</th>
                        <th>Screening</th>
                        <th>Application Tracking</th>
                        <th>Events</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="o in organizations">

                        <td class="spark-table-pad"> @{{ o.name }} </td>
                        <td class="spark-table-pad"> 
                            <label class="i-switch m-t-xs m-r">
                                <input v-model="preselect[o.id]" type="checkbox" @click="updatePermission(o,'preselect')"><i></i>
                            </label>
                        </td>
                        <td class="spark-table-pad"> 
                            <label class="i-switch m-t-xs m-r">
                                <input v-model="screening[o.id]" type="checkbox" @click="updatePermission(o,'screening')"><i></i>
                            </label>
                        </td>
                        <td class="spark-table-pad"> 
                            <label class="i-switch m-t-xs m-r">
                                <input v-model="tracking[o.id]" type="checkbox" @click="updatePermission(o, 'tracking')"><i></i>
                            </label>
                        </td>
                        <td class="spark-table-pad"> 
                            <label class="i-switch m-t-xs m-r">
                                <input v-model="events[o.id]" type="checkbox" @click="updatePermission(o, 'events')"><i></i>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        
            <div v-else class="panel-body">
                No permissions found.
            </div>

        </div>
        
      </div>
        <!-- / Permissions -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-permissions-screen>
