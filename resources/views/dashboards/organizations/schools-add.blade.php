<div class="modal fade" id="modal-add-school-org" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add School</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addOrganization"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-hidden :display="'Type*'" :form="forms.addOrganization" :name="'type'" :input="'school'">
                            </spark-hidden>

                            <spark-text :display="'Name*'" :form="forms.addOrganization" :name="'name'" :input="forms.addOrganization.name">
                            </spark-text>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" @click.prevent="addNewOrganization('school')" :disabled="forms.addOrganization.busy">
                    <span v-if="forms.addOrganization.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                </button>
            </div>
        </div>
    </div>
</div>
