<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#{{$item}}_mlist" aria-controls="{{$item}}_mlist" role="tab" data-toggle="tab" ref="{{$item}}_closeEditItem">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">Edit {{$item}}</h4>
    </div>

    <!-- Edit Item -->
    <div class="hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <spark-error-alert :form="forms.updateForm"></spark-error-alert>

                <!-- Edit Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <spark-select v-show="isMajor" :display="'Category'" :form="forms.updateForm" :name="'category'" :items="categoryOptions" :input="forms.updateForm.category">
                                    </spark-select>

                                    <spark-text :display="'Name*'" :form="forms.updateForm" :name="'name'" :input="forms.updateForm.name"></spark-text>

                                    <spark-text v-show="isUniversity" :display="'Country*'" :form="forms.updateForm" :name="'country'" :input="forms.updateForm.country"></spark-text>
                                    <spark-text v-show="isUniversity" :display="'Website*'" :form="forms.updateForm" :name="'website'" :input="forms.updateForm.website"></spark-text>
                                </div> 
                                <div class="m-t m-b panel-footer">
                                    <a class="btn btn-default" href="#{{$item}}_mlist" aria-controls="{{$item}}_mlist" role="tab" data-toggle="tab"> Cancel </a>
                                    <button type="button" class="btn btn-primary btn-addon pull-right" @click.prevent="updateListItem" :disabled="forms.updateForm.busy">
                                        <span v-if="forms.updateForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Editing </span>
                                        <span v-else> <i class="fa fa-btn fa-save"></i> Edit </span>
                                    </button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Edit item -->
</div>
