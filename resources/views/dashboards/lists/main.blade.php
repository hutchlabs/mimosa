<div class="col wrapper-md">
    <div class="clearfix m-b">
        <a class="btn btn-info btn-addon" href="#{{$item}}_addItem" aria-controls="{{$item}}_addItem" role="tab" data-toggle="tab" ref="{{$item}}_addItem" @mouseover="addList()">
            <i class="fa fa-plus"></i> Add {{$item}}
        </a>
    </div>
    
    <!-- List -->
    <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
            <!-- table -->
            <div class="table-responsive" v-if="(getList()).length> 0">

                <table class="table table-striped m-b-none">
                    <thead>
                        <tr>
                            <th v-show="isMajor">Category</th>
                            <th>Name</th>
                            <th v-show="isUniversity">Country</th>
                            <th v-show="isUniversity">Website</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in getList()">
                            <td v-show="isMajor" class="spark-table-pad"> @{{ i.category }} </td>
                            <td class="spark-table-pad"> @{{ i.name }} </td>
                            <td v-show="isUniversity" class="spark-table-pad"> @{{ i.country }} </td>
                            <td v-show="isUniversity" class="spark-table-pad"> @{{ i.website }} </td>
                            <td class="spark-table-pad">
                                <a class="btn btn-info btn-sm"  href="#{{$item}}_editItem" aria-controls="{{$item}}_editItem" role="tab" data-toggle="tab"
                                        @mouseover="editList(i);"><i class="fa fa-pencil"></i> 
                                </a>

                                <button class="btn btn-danger btn-sm" @click.prevent="removeListItem(i)"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="panel-body">
                No {{$item}} found.
            </div>

        </div>

    </div>
    <!-- / List -->

</div>
