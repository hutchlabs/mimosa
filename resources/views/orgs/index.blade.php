<gradlead-orgs-screen inline-template>

    <div class="panel panel-default">
        <div class="panel-heading">
            Organizations
            <button class="btn btn-info btn-sm pull-right" @click.prevent="addOrganization()">
                <i class="fa fa-btn fa-plus"></i>Add Organization
            </button>
        </div>

        <div class="panel-body" v-if="organizations.length> 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Subdomain</th>
                        <th># of Users</th>
                        <th>Affiliations</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="o in organizations">

                        <td class="spark-table-pad"> @{{ o.name }} </td>
                        <td class="spark-table-pad"> @{{ o.type | capitalize}} </td>
                        <td class="spark-table-pad"> @{{ o.subdomain }} </td>
                        <td class="spark-table-pad"> @{{ o.numusers }} </td>
                        <td class="spark-table-pad"> @{{ o | affiliations }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-warning btn-xs btn-circle" @click.prevent="editOrganization(o)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-xs btn-cirlce" @click.prevent="removeOrganization(o)" :disabled="removingOrganization(o.id)">
                                <span v-if="removingOrganization(o.id)">
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
            No organizations found.
        </div>

        @include('orgs.add') @include('orgs.edit')
    </div>

</gradlead-orgs-screen>
