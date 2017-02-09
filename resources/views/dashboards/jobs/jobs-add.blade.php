<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab" ref="backtoJobs">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">Add Job</h4>
    </div>

    <!-- Add job -->
    <div class="panel hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default nav-tabs-alt no-border">
                        <ul class="nav nav-tabs nav-justified no-border">
                            <li role="presentation" :class="step1Class">
                                <a href="#jinfo" aria-controls="jinfo" role="tab" data-toggle="tab">
                                    <b class="badge bg-info">1</b>&nbsp; Job Details
                                </a>
                            </li>

                            <li v-if="steps.step2" role="presentation" :class="step2Class">
                                <a href="#jcriteria" aria-controls="jcriteria" role="tab" data-toggle="tab">
                                    <b class="badge bg-info">2</b>&nbsp;Job Criteria
                                </a>
                            </li>
                            <li v-else role="presentation" class="disabled">
                                <b class="badge bg-default">2</b>&nbsp;Job Criteria
                            </li>

                            <li v-if="steps.step3" role="presentation" :class="step3Class">
                                <a href="#jwhoplan" aria-controls="jwhoplan" role="tab" data-toggle="tab">
                                    <b class="badge bg-info">3</b>&nbsp;Choose Plan
                                </a>
                            </li>
                            <li v-else role="presentation" class="disabled">
                                <b class="badge bg-default">3</b>&nbsp;Choose Plan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form id="addJobForm" name="addJobForm" method="post" v-on:submit.prevent="addJob()" class="form-validation" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <!-- Job detals -->
                            <div role="tabpanel" :class="getTabPaneClass('step1')" id="jinfo">
                                <p class="m-b">Provide Job Details </p>

                                <spark-progressbar :percent="steps.percent" value="10" max="100" clss="progress-xs" type="success"></spark-progressbar>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Basic details (Required)</div>
                                            <div class="panel-body">

                                                <div v-if="isGradlead" class="form-group">
                                                    <label class="control-label">Organization</label>
                                                    <select id="organization_id" name="organization_id" class="form-control">
                                                        <option v-for="o in organizations" :value="o.id" :selected="o.id==1">
                                                            @{{ o.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div v-else>
                                                    <input type="hidden" name="organization_id" :value="user.organization_id" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Title</label>
                                                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter Job title" @blur="validateField('jobAddForm','title')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobAddForm','title')">
                                                        <span style="color:red">Job title is required</span>
                                                    </span>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Teaser</label>
                                                    <input type="text" id="teaser" name="teaser" class="form-control" placeholder="Teaser..." data-minlength="5" @blur="validateField('jobAddForm','teaser')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobAddForm','teaser')">
            	                                        <span style="color:red">Teaser is required</span>
                                                    </span>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Description</label>
                                                    <textarea id="description_text" name="description_text" class="form-control" placeholder="Job Description" @blur="validateField('jobAddForm','description_text')"></textarea>
                                                    <span class="help-block " v-show="fieldHasErrors('jobAddForm','description_text')">
            	                                        <span style="color:red">Job description is required.</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Additional info</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="control-label">Job Type</label>
                                                    <multiselect
                                                            :options="jobTypes"
                                                            :multiple="true"
                                                            :close-on-select="true"
                                                            :hide-selected="true"
                                                            @update="updateAddJT"
                                                            placeholder="Select Job types"
                                                            v-model="addJT"
                                                            label="name"
                                                            key="id" >
                                                        </multiselect>
                                                    <input type="hidden" name="jobtypes" id="jobtypes" :value="addJT"/>
                                                </div>

                                               <div class="form-group">
                                                    <label class="control-label">Positions</label>
                                                    <multiselect
                                                            :options="skills"
                                                            :multiple="true"
                                                            :hide-selected="true"
                                                            :selected="sel"
                                                            :close-on-select="true"
                                                            @update="updateAddSkills"
                                                            placeholder="Required skills.."
                                                            v-model="addSkills"
                                                            label="name"
                                                            key="id" >
                                                        </multiselect>
                                                    <input type="hidden" name="positions" id="positions" :value="myskills"/>    
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label">Country</label>
                                                    <input type="text" id="country" name="country" class="form-control" placeholder="Country"  @blur="validateField('jobAddForm','country')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobAddForm','country')">
            	                                        <span style="color:red">Country is required</span>
                                                    </span>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label">City</label>
                                                    <input type="text" id="city" name="city" class="form-control" placeholder="City"  @blur="validateField('jobAddForm','city')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobAddForm','city')">
            	                                        <span style="color:red">City is required</span>
                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="m-t m-b modal-footer">
                                    <a class="btn btn-default pull-left" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab">Cancel</a>

                                    <a href="#jcriteria" aria-controls="jcriteria" role="tab" data-toggle="tab" :disabled="!validStep('jobAddForm','step1')" class="btn btn-info btn-rounded pull-right" @click="steps.step2=true;setStepClass('step2');">Next</a>

                                </div>
                            </div>

                            <!-- Criteria -->
                            <div role="tabpanel" :class="getTabPaneClass('step2')" id="jcriteria">
                                <p class="m-b">What kind of candidate do you want?</p>

                                <spark-progressbar :percent="steps.percent" value="10" max="100" clss="progress-xs" type="success"></spark-progressbar>

                                <h4>Pre-Selection Criteria</h4>


                                <div class="m-t m-b modal-footer">
                                    <a class="btn btn-default pull-left" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab">Cancel</a>
                                    <div class="pull-right">
                                        <a href="#jinfo" aria-controls="jinfo" role="tab" data-toggle="tab" class="btn btn-default btn-rounded" @click="setStepClass('step1');">Prev</a>

                                        <a href="#jwhoplan" aria-controls="jwhoplan" role="tab" data-toggle="tab" :disabled="!validStep('jobAddForm','step2')" class="btn btn-default btn-rounded" @click="steps.step3=true;setStepClass('step3');">Next</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Plan -->
                            <div role="tabpanel" :class="getTabPaneClass('step3')" id="jwhoplan">
                                <p class="m-b">Who do you want to send this posting to?</p>

                                <spark-progressbar :percent="steps.percent" value="10" max="100" clss="progress-xs" type="success"></spark-progressbar>

                                <h4>Plan</h4>

                                <div class="m-t m-b modal-footer">
                                    <a class="btn btn-default pull-left" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab">Cancel</a>

                                    <div class="pull-right">
                                        <button v-if="jobAddForm.valid" type="submit" class="btn btn-success btn-addon">
                                            <i class="fa fa-btn fa-save"></i> Add Job
                                        </button>

                                        <button v-else :disabled="true" type="submit" class="btn btn-success btn-addon">
                                            <i class="fa fa-btn fa-save"></i> Add Job
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- / Add job -->
</div>
