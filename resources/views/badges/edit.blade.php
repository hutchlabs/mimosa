<div class="modal fade" id="modal-edit-badge" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Update Badge</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.updateBadge"></spark-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-text :display="'Name*'" :form="forms.updateBadge" :name="'name'" :input.sync="forms.updateBadge.name">
                            </spark-text>

                            <spark-text :display="'Name*'" :form="forms.updateBadge" :name="'description'" :input.sync="forms.updateBadge.description">
                            </spark-text>
                            
                            <spark-file :display="'Upload file'"
                                :form="forms.updateBadge"
                                :name="'uploaded_file'"
                                :warning="'File must be less than 20MB. Must be jpeg, png, bmp, gif, or svg'"
                                :input.sync="forms.updateBadge.uploaded_file">
                            </spark-file>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary" @click.prevent="updateBadge" :disabled="forms.updateBadge.busy">
                    <span v-if="forms.updateBadge.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Updating
                        </span>

                    <span v-else>
                            <i class="fa fa-btn fa-save"></i> Update
                        </span>
                </button>
            </div>
        </div>
    </div>
</div>
