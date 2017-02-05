<div class="modal fade" id="modal-edit-event" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i> Update Event</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.updateEvent"></spark-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <spark-hidden :form="forms.updateEvent" :name="'id'" 
                                  :input.sync="forms.updateEvent.id"></spark-hidden>

                            <spark-date :display="'Start Date*'" :form="forms.updateEvent" :name="'start_date'" 
                                        :input.sync="forms.updateEvent.start_date">
                            </spark-date>

                            <spark-date :display="'End Date*'" :form="forms.updateEvent" :name="'end_date'" 
                                        :input.sync="forms.updateEvent.end_date">
                            </spark-date>

                            <spark-text :display="'Name*'" :form="forms.updateEvent" :name="'name'" :input.sync="forms.updateEvent.name">
                            </spark-text>

                            <spark-text :display="'Description*'" :form="forms.updateEvent" :name="'description'" :input.sync="forms.updateEvent.description">
                            </spark-text>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateEvent" :disabled="forms.updateEvent.busy">
                    <span v-if="forms.updateEvent.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                </button>
            </div>
        </div>
    </div>
</div>
