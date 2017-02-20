<gradlead-badges-screen inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Badges</h1>
          <small class="text-muted">{{$name}} Badges</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <button class="btn btn-info btn-addon" @click.prevent="addBadge()">
                <i class="fa fa-plus"></i> Add Badge
            </button>
      </div>
  
        <!-- Badges -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="badges.length> 0">
            <table id="userstable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th># Times Assigned</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="b in badges">

                        <td class="spark-table-pad"> <img :src="getImage(b)"/></td>
                        <td class="spark-table-pad"> @{{ b.name }} </td>
                        <td class="spark-table-pad"> @{{ b.description }} </td>
                        <td class="spark-table-pad"> @{{ b.numachievements }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-warning btn-sm btn-addon" @click.prevent="editBadge(b)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-sm btn-addon" @click.prevent="removeBadge(b)" :disabled="removingBadge(b.id)">
                                <span v-if="removingBadge(b.id)">
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
                No badges found.
            </div>

        </div>
        
        @include('dashboards.badges.add') @include('dashboards.badges.edit')
      </div>
        <!-- / Badges -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-badges-screen>
