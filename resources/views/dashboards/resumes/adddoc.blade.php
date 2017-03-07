<div class="modal fade" id="modal-add-doc" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Document</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addDoc"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12 offset-2">
                            <gl-text :display="'Name*'" :form="forms.addDoc" :name="'name'" :input="forms.addDoc.name">
                            </gl-text>

                            <gl-text :display="'Description*'" :form="forms.addDoc" :name="'description'" :input="forms.addResume.description">
                            </gl-text>

                            <gl-file :display="'Document'" :form="forms.addDoc" v-on:updated="setDocFileName"
                                        :name="'pdf_file'" 
                                        :warning="'File must be less than 20MB. Must be an pdf file'"     
                                        :filename.sync="forms.addDoc.file_name" 
                                        :input.sync="forms.addDoc.pdf_file">
                            </gl-file>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewDoc" :disabled="forms.addDoc.busy">
                    <span v-if="forms.addDoc.busy">
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
