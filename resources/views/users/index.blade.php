<gradlead-users-screen inline-template>

    <!-- Users -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Users
            <button class="btn btn-default btn-sm pull-right" @click.prevent="addUser()">
                <i class="fa fa-btn fa-plus"></i>Add User
            </button>
        </div>

        <div class="panel-body" v-if="users.length> 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Can Editor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in users">

                        <td class="spark-table-pad"> @{{ u.name }} </td>
                        <td class="spark-table-pad"> @{{ u.email }} </td>
                        <td class="spark-table-pad"> @{{ u.role.name }} </td>
                        <td class="spark-table-pad"> @{{ u.role.name | role_is_editor }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-warning btn-xs btn-circle" @click.prevent="editUser(u)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-xs btn-cirlce" @click.prevent="removeUser(u)" :disabled="removingUser(u.id)">
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

        @include('users.add') @include('users.edit')
    </div>

</gradlead-users-screen>
