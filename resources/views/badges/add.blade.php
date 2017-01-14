<div class="modal fade" id="modal-add-badge" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Badge</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addBadge"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-text :display="'Name*'" :form="forms.addBadge" :name="'name'" :input="forms.addBadge.name">
                            </spark-text>

                            <spark-text :display="'Description*'" :form="forms.addBadge" :name="'description'" :input="forms.addBadge.description">
                            </spark-text>

                            <spark-file :display="'Upload file'"
                                :form="forms.addBadge"
                                :name="'uploaded_file'"
                                :warning="'File must be less than 20MB. Must be jpeg, png, bmp, gif, or svg'"
                                :input.sync="forms.addBadge.uploaded_file">
                            </spark-file>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary" @click.prevent="addNewBadge" :disabled="forms.addBadge.busy">
                    <span v-if="forms.addBadge.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Adding
                        </span>

                    <span v-else>
                            <i class="fa fa-btn fa-save"></i> Add
                        </span>
                </button>
            </div>
        </div>
    </div>
</div>
