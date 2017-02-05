<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-updateon" href="#questions" aria-controls="questions" role="tab" data-toggle="tab">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">@{{ currentQn.name }} >> Questions >> @{{ currentQ.caption }}</h4>
    </div>

    <!-- Update question -->
    <div class="panel hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <div class="col-md-12">

                    <form id="updateQuestionForm" name="updateQuestionForm" method="post" v-on:submit.prevent="updateQuestion(currentQ)" class="form-validation" enctype="multipart/form-data">
                        
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="id" :value="currentQ.id" />
                        <input type="hidden" name="questionnaire_id" value="questionnaire_id" :value="currentQn.id" />
                       
                        <div class="form-group">
                            <label class="control-label"><b>Question</b></label>
                            <input type="text" id="caption" name="caption" class="form-control" placeholder="Enter Question" @blur="validateField('qUpdateForm','caption')" :value="currentQ.caption">
                            <span class="help-block" v-show="fieldHasErrors('qUpdateForm','caption')">
            	                   <span style="color:red">Question is required</span>
                            </span>
                        </div>

                        <div class="form-group">
                            <div class="col-lg">
                                <div class="checkbox">
                                    <label class="i-checks">
                                        <input type="checkbox" id="is_required" name="is_required" class="form-control" :checked="currentQ.is_required"><i></i> <b>Required</b>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Answer Type</b></label>
                                   <span class="help-block" v-show="fieldHasErrors('qUpdateForm','type')">
            	                       <span style="color:red">Question type is required</span>
                                    </span>
                                    
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="type" value="string" @click="showHideField('qUpdateForm','type',
                                                                'yesnoblock','listblock','string')" :checked="currentQ.type=='string'">
                                            <i></i> Text
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="type" value="boolean" @click="showHideField('qUpdateForm','type',
                                                                'yesnoblock','listblock','boolean')" :checked="currentQ.type=='boolean'">
                                            <i></i> Yes/No
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="type" value="multilist" @click="showHideField('qUpdateForm','type',
                                                                'listblock','yesnoblock','multilist')" :checked="currentQ.type=='multilist'">
                                            <i></i> List of answers with multiple choice
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="type" value="list" @click="showHideField('qUpdateForm','type',
                                                                'listblock','yesnoblock','list')" :checked="currentQ.type=='list'">
                                            <i></i> List of answers with single choice
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6" style="background-color:#fff; padding: 10px">
                                <div class="form-group">
                                    <div id="yesnoblock" v-show="currentQ.type=='boolean'" class="startclosed">
                                        <label class="control-label">Yes</label>
                                        <select id="yes_score" name="yes_score" class="form-control">
                                            <option v-for="p in passingScoreOptions" :value="p.value" :selected="currentQ.yes_score==p.value">
                                                @{{ p.text }}
                                            </option>
                                        </select>
                                        <br/>
                                        <br/>
                                        <label class="control-label">No</label>
                                        <select id="no_score" name="no_score" class="form-control">
                                            <option v-for="p in passingScoreOptions" :value="p.value"  :selected="currentQ.no_score==p.value">
                                                @{{ p.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div id="listblock" style="display:none;" class="startclosed">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="la_one" class="form-control" placeholder="Enter choice 1" :value="currentQ.list.lone.value">
                                            </div>
                                            <div class="col-md-5">
                                                <select name="ls_one" class="form-control">
                                                    <option v-for="p in passingScoreOptions" :value="p.value" :selected="currentQ.list.lone.score==p.value">
                                                        @{{ p.text }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="la_two" class="form-control" placeholder="Enter choice 2" :value="currentQ.list.ltwo.value">
                                            </div>
                                            <div class="col-md-5">
                                                <select name="ls_two" class="form-control">
                                                    <option v-for="p in passingScoreOptions" :value="p.value" :selected="currentQ.list.ltwo.score==p.value">
                                                        @{{ p.text }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="la_three" class="form-control" placeholder="Enter choice 3" :value="currentQ.list.lthree.value">
                                            </div>
                                            <div class="col-md-5">
                                                <select name="ls_three" class="form-control">
                                                    <option v-for="p in passingScoreOptions" :value="p.value" :selected="currentQ.list.lthree.score==p.value">
                                                        @{{ p.text }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                     </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="m-t m-b modal-footer">
                            <a class="btn btn-default pull-left" href="#questions" aria-controls="questions" role="tab" data-toggle="tab">Cancel</a>
                            <button v-if="qUpdateForm.valid" type="submit" class="btn btn-success btn-updateon">
                                <i class="fa fa-btn fa-save"></i> Update Question
                            </button>

                            <button v-else :disabled="true" type="submit" class="btn btn-success btn-updateon">
                                <i class="fa fa-btn fa-save"></i> Update Question
                            </button>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- / Update question -->
</div>
