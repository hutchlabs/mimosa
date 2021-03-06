<gradlead-seekers-screen v-bind:auth-user="authUser" v-bind:usertype="usertype" v-bind:permissions="permissions" inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div v-if="usertype.isGradlead" class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Job Seekers</h1>
          <small class="text-muted">{{$name}} Job Seekers</small>
        </div>
        <div v-else class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Students</h1>
          <small class="text-muted">{{$name}} Students</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
      <div class="clearfix m-b">
            <h2 style="display:inline;" class="m-n font-thin h3">@{{ seekerNum }} Job Seekers</h2>

            <!--
            <button class="btn btn-info btn-addon pull-right" disabled @click.prevent="addUserBulk()">
                <i class="fa fa-plus"></i> Bulk Upload 
            </button>
            -->

            <button class="btn btn-info btn-addon pull-right" @click.prevent="addUser()">
                <i class="fa fa-plus"></i> Add 
            </button>

      </div>
  
        <!-- Users -->
      <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <!-- table -->
            <div class="table-responsive" v-if="users.length> 0">
            <table id="userstable" class="table table-striped m-b-none">
                <thead>
                    <tr>
                        <td style="width: 140px">
							<input type="checkbox" v-model="masterChbx" style="display:inline; margin-left:9px"/>
                            <select v-model="selAction" style="display: inline; width:90px;">
                                <option disabled value="">Select One</option>
                                <option value="resumebook">Download Resume book</option>
                                <option value="email">Email</option>
                            </select>
						</td>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Num Resumes</th>
                        <th>Badges</th>
                        <th>Profile</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in filteredUsers()">
                        <td class="spark-table-pad">
                             <input type="checkbox" :value="u" v-model="checkedboxes" class="form-control" />
                        </td>
                        <td class="spark-table-pad"> @{{ u.name }} </td>
                        <td class="spark-table-pad"> @{{ u.email }} </td>
                        <td class="spark-table-pad"> @{{ u.resumes.length }} </td>
                        <td class="spark-table-pad"> <gl-achievement-display :user="u" :tiny="true"></gl-achievement-display></td>
                        <td class="spark-table-pad">
                            <button class="btn btn-default btn-addon btn-sm btn-circle" @click.prevent="viewProfile(u)"><i class="fa fa-user"></i> Profile</button>
                        </td>

                        <td class="spark-table-pad"> @{{ u.type | ucwords }} </td>

                        <td class="spark-table-pad">
                            <button v-if="usertype.isGradlead" class="btn btn-info btn-addon btn-sm btn-circle" @click.prevent="manageBadges(u)">
                                <i class="fa fa-certificate"></i>Manage  Badge</button>

                            <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editUser(u)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeUser(u)" :disabled="removingUser(u.id)">
                                <span v-if="removingUser(u.id)">
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
                No users found.
            </div>

        </div>
        
        @include('dashboards.seekers.add') @include('dashboards.seekers.edit') 
        @include('dashboards.seekers.badges') @include('dashboards.seekers.profile') 
        @include('dashboards.seekers.email')
      </div>
        <!-- / Users -->

    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-seekers-screen>
