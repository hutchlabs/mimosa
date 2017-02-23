<div class="modal fade" id="modal-add-resume" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Resume</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addResume"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-text :display="'Name*'" :form="forms.addResume" :name="'name'" :input="forms.addResume.name">
                            </spark-text>

                            <spark-text :display="'Description*'" :form="forms.addResume" :name="'description'" :input="forms.addResume.description">
                            </spark-text>

                            <spark-checkbox :display="'Default?'" :form="forms.addResume" :name="'default'" :input="forms.addResume.default">
                            </spark-checkbox>
                            
                            <spark-file :display="'Resume'" :form="forms.addResume" v-on:updated="setFileName"
                                        :name="'pdf_file'" 
                                        :warning="'File must be less than 20MB. Must be an pdf file'"     
                                        :filename.sync="forms.addResume.file_name" 
                                        :input.sync="forms.addResume.pdf_file">
                            </spark-file>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewResume" :disabled="forms.addResume.busy">
                    <span v-if="forms.addResume.busy">
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
