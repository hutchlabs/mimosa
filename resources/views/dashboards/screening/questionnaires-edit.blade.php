<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#questionnaires" aria-controls="questionnaires" role="tab" data-toggle="tab">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">Edit Questionnaire</h4>
    </div>

    <!-- Edit questionnaire -->
    <div class="panel hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <div class="col-md-12">

                    <form id="updateQuestionnaireForm" name="updateQuestionnaireForm" method="post" v-on:submit.prevent="updateQuestionnaire(currentQn)" class="form-validation" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="id" :value="currentQn.id" />

                        <!-- Questionnaire detals -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Questionnaire details (Required)</div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Questionnaire title" @blur="validateField('qnUpdateForm','name')" :value="currentQn.name">
                                    <span class="help-block" v-show="fieldHasErrors('qnUpdateForm','name')">
            	                           <span style="color:red">Questionnaire name is required</span>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Passing Score</label>
                                    <select id="passing_score" name="passing_score" class="form-control">
                                        <option v-for="p in passingScoreOptions" :value="p.value" :selected="currentQn.passing_score==p.value">
                                            @{{ p.text }}
                                        </option>
                                    </select>
                                </div>

                                <p><strong>Send Auto-Reply email to candidates whose score is:</strong></p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-lg col-lg-10">
                                                <div class="checkbox">
                                                    <label class="i-checks">
                                                        <input type="checkbox" id="send_auto_reply_more" name="send_auto_reply_more" class="form-control" @click="showHideField('qnUpdateForm','send_auto_reply_more','qnUpdateFormEmailMore')" :checked="currentQn.send_auto_reply_more"><i></i> Equal or more than passing score
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="qnUpdateFormEmailMore" v-show="currentQn.send_auto_reply_more" class="startclosed">
                                                <label class="control-label">Email text to candidates whose score is equal or more than passing score </label>
                                                <textarea id="email_more" name="email_more" class="col-lg-12" @blur="validateField('qnUpdateForm','email_more')">@{{ currentQn.email_more}}
                                                </textarea>
                                                <span class="help-block" v-show="fieldHasErrors('qnUpdateForm','email_more')">
            	                                   <span style="color:red">Email text is required</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-lg col-lg-10">
                                                <div class="checkbox">
                                                    <label class="i-checks">
                                                        <input type="checkbox" id="send_auto_reply_less" name="send_auto_reply_less" class="form-control" @click="showHideField('qnUpdateForm','send_auto_reply_less','qnUpdateFormEmailLess')"><i></i> Less than passing score
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="qnUpdateFormEmailLess" v-show="currentQn.send_auto_reply_less" class="startclosed">
                                                <label class="control-label">Email text to candidates whose score is lower than passing score </label>
                                                <textarea id="email_less" name="email_less" class="col-lg-12" @blur="validateField('qnUpdateForm','email_less')">@{{ currentQn.email_less }}
                                                </textarea>
                                                <span class="help-block" v-show="fieldHasErrors('qnUpdateForm','email_less')">
            	                                   <span style="color:red">Email text is required</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="m-t m-b modal-footer">
                            <a class="btn btn-default pull-left" href="#questionnaires" aria-controls="questionnaires" role="tab" data-toggle="tab">Cancel</a>               
                             <button v-if="qnUpdateForm.valid" type="submit" class="btn btn-success btn-addon">
                                <i class="fa fa-btn fa-save"></i> Update Questionnaire
                            </button>
                            
                             <button v-else :disabled="true" type="submit" class="btn btn-success btn-addon">
                                <i class="fa fa-btn fa-save"></i> Update Questionnaire
                            </button>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- / Update questionnaire -->
</div>
