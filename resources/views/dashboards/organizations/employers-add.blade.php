<div class="modal fade" id="modal-add-employer-org" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Employer</h4>
            </div>

            <div class="modal-body">

                <gl-error-alert :form="forms.addOrganization"></gl-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">

                            <gl-text :display="'Company Name*'" :form="forms.addOrganization" :name="'name'" :input="forms.addOrganization.name">
                            </gl-text>

                            <h3>Administrator Details</h3>

                            <gl-text :required="true" :display="'First Name*'" :form="forms.addOrganization" :name="'first'" :input="forms.addOrganization.first">
                            </gl-text>

                            <gl-text :required="true" :display="'Last Name*'" :form="forms.addOrganization" :name="'last'" :input="forms.addOrganization.last">
                            </gl-text>

                            <gl-email :required="true" :display="'Email*'" :form="forms.addOrganization" :name="'email'" :input="forms.addOrganization.email">
                            </gl-email>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" @click.prevent="addNewOrganization('employer')" :disabled="forms.addOrganization.busy">
                    <span v-if="forms.addOrganization.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                </button>
            </div>
        </div>
    </div>
</div>
