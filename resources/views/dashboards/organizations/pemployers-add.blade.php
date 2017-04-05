<div class="modal fade" id="modal-add-pemployer-org" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Employer</h4>
            </div>

            <div class="modal-body">

                <gl-error-alert :form="forms.addAffiliate"></gl-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">

                            <gl-select :display="'Employer*'" :form="forms.addAffiliate" :name="'affiliate_id'" :items="empOptions" :input="forms.addAffiliate.affiliate_id">
                            </gl-select>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" @click.prevent="addAffiliate('employer')" :disabled="forms.addAffiliate.busy">
                    <span v-if="forms.addAffiliate.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                </button>
            </div>
        </div>
    </div>
</div>
