<div class="modal fade" id="modal-add-event" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Event</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addEvent"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-date :display="'Start Date*'" :form="forms.addEvent" :name="'start_date'" 
                                        :input="forms.addEvent.start_date">
                            </spark-date>

                            <spark-date :display="'End Date*'" :form="forms.addEvent" :name="'end_date'" 
                                        :input="forms.addEvent.end_date">
                            </spark-date>

                            <spark-text :display="'Name*'" :form="forms.addEvent" :name="'name'" :input="forms.addEvent.name">
                            </spark-text>

                            <spark-text :display="'Description*'" :form="forms.addEvent" :name="'description'" :input="forms.addEvent.description">
                            </spark-text>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewEvent" :disabled="forms.addEvent.busy">
                    <span v-if="forms.addEvent.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                </button>
            </div>
        </div>
    </div>
</div>
