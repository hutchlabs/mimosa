<div class="modal fade" id="modal-edit-employer-org" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i> Update Employer</h4>
            </div>

            <div class="modal-body">

                <gl-error-alert :form="forms.updateOrganization"></gl-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <gl-text :display="'Name*'" :form="forms.updateOrganization" :name="'name'" :input.sync="forms.updateOrganization.name">
                            </gl-text>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary" @click.prevent="updateOrganization('employer')" :disabled="forms.updateOrganization.busy">
                    <span v-if="forms.updateOrganization.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                </button>
            </div>
        </div>
    </div>
</div>
