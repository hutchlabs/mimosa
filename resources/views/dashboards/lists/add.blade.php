<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#{{$item}}_mlist" aria-controls="{{$item}}_mlist" role="tab" data-toggle="tab" ref="{{$item}}_closeAddItem">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">Add {{$item}}</h4>
    </div>

    <!-- Add Item -->
    <div class="hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <spark-error-alert :form="forms.addForm"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <spark-select v-show="isMajor" :display="'Category'" :form="forms.addForm" :name="'category'" :items="categoryOptions" :input="forms.addForm.category">
                                    </spark-select>

                                    <spark-text :display="'Name*'" :form="forms.addForm" :name="'name'" :input="forms.addForm.name"></spark-text>

                                    <spark-text v-show="isUniversity" :display="'Country*'" :form="forms.addForm" :name="'country'" :input="forms.addForm.country"></spark-text>
                                    <spark-text v-show="isUniversity" :display="'Website*'" :form="forms.addForm" :name="'website'" :input="forms.addForm.website"></spark-text>
                                </div> 
                                <div class="m-t m-b panel-footer">
                                    <a class="btn btn-default" href="#{{$item}}_mlist" aria-controls="{{$item}}_mlist" role="tab" data-toggle="tab"> Cancel </a>
                                    <button type="button" class="btn btn-primary btn-addon pull-right" @click.prevent="addNewListItem" :disabled="forms.addForm.busy">
                                        <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>
                                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                                    </button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Add item -->
</div>
