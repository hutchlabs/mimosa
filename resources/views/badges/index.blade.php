<gradlead-badges-screen inline-template>

    <div class="panel panel-default">
        <div class="panel-heading">
            Badges
            <button class="btn btn-info btn-sm pull-right" @click.prevent="addBadge()">
                <i class="fa fa-btn fa-plus"></i>Add Badge
            </button>
        </div>

        <div class="panel-body" v-if="badges.length> 0">
            <table class="table table-responsive">
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

                        <td class="spark-table-pad"> <img src="/mimosa/badges/image/" /></td>
                        <td class="spark-table-pad"> @{{ b.name }} </td>
                        <td class="spark-table-pad"> @{{ b.description }} </td>
                        <td class="spark-table-pad"> @{{ b.numachievements }} </td>

                        <td class="spark-table-pad">
                            <button class="btn btn-warning btn-xs btn-circle" @click.prevent="editBadge(b)">
                                <i class="fa fa-pencil"></i> Edit</button>

                            <button class="btn btn-danger btn-xs btn-cirlce" @click.prevent="removeBadge(b)" :disabled="removingBadge(b.id)">
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

        @include('badges.add') @include('badges.edit')
    </div>

</gradlead-badges-screen>
