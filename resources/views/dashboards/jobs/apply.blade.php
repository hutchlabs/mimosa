<div class="modal fade" id="modal-apply" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Apply for @{{ currentJob.title}}</h4>
            </div>

            <div v-if="hasNotApplied && hasResumes" class="modal-body">

                <spark-error-alert :form="forms.applyForm"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                          <gl-select :display="'Resume'"
                                     :form="forms.applyForm"
                                     :name="'resume_id'"
                                     :items="resumes" 
                                     :input.sync="forms.applyForm.resume_id">\
                          </gl-select>
                        </div>
                    </div>
                    <div class="row" v-show="currentJob.questionnaire_id!=null && currentJob.questionnaire_id>0">
                        <div class="col-md-12">
                        </div>
                    </div>
                </form>
            </div>
            
            <div v-else class="modal-body">
                <p v-if="!hasNotApplied">
                    You have already applied for this job.
                </p>
                <p v-else>
                    You have not uploaded any resumes. Please upload a resume from the resume section
                    before applying for a job.
                </p>    
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button v-show="hasNotApplied && hasResumes" type="button" class="btn btn-primary btn-addon" @click.prevent="submitApp" :disabled="forms.applyForm.busy">
                    <span v-if="forms.applyForm.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Applying
                        </span>

                    <span v-else>
                            <i class="fa fa-btn fa-save"></i> Apply
                        </span>
                </button>
            </div>
        </div>
    </div>
</div>
