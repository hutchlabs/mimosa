<div class="col wrapper-md">

    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab" ref="backtoJobs">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">Update Job</h4>
    </div>

    <!-- Update job -->
    <div class="panel hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default nav-tabs-alt no-border">
                        <ul class="nav nav-tabs nav-justified no-border">
                            <li role="presentation" :class="step1Class">
                                <a href="#jeinfo" aria-controls="jeinfo" role="tab" data-toggle="tab">
                                    <b class="badge bg-info">1</b>&nbsp; Job Details
                                </a>
                            </li>

                            <li v-show="canDoPreselect" role="presentation" :class="(steps.step2)? step2Class :'disabled'">
                                <div v-if="steps.step2">
                                    <a href="#jecriteria" aria-controls="jecriteria" role="tab" data-toggle="tab">
                                        <b class="badge bg-info">2</b>&nbsp;Job Criteria
                                    </a>
                                </div>
                                <div v-else>
                                    <b class="badge bg-default">2</b>&nbsp;Job Criteria
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form id="updateJobForm" name="updateJobForm" method="post" v-on:submit.prevent="updateJob()" 
                  class="form-validation" 
                  enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT" />

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">

                            <!-- Job detals -->
                            <div role="tabpanel" :class="getTabPaneClass('step1')" id="jeinfo">
                                <p class="m-b">Provide Eidit Job Details </p>

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
                                                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter Job title" @blur="validateField('jobUpdateForm','title')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobUpdateForm','title')">
                                                        <span style="color:red">Job title is required</span>
                                                    </span>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Teaser</label>
                                                    <input type="text" id="teaser" name="teaser" class="form-control" placeholder="Teaser..." @blur="validateField('jobUpdateForm','teaser')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobUpdateForm','teaser')">
            	                                        <span style="color:red">Teaser is required</span>
                                                    </span>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Description</label>
                                                    <textarea id="description_text" name="description_text" class="form-control" placeholder="Job Description" @blur="validateField('jobUpdateForm','description_text')"></textarea>
                                                    <span class="help-block " v-show="fieldHasErrors('jobUpdateForm','description_text')">
            	                                        <span style="color:red">Job description is required.</span>
                                                    </span>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Start Date</label>
                                                            <datepicker :value="startDate_val" v-model="startDate" :format="'dd-M-yyyy'" :input-class="'form-control'"></datepicker>
                                                            <input type="hidden" id="start_date" name="start_date" />
                                                            <span class="help-block " v-show="fieldHasErrors('jobUpdateForm','start_date')">
                                                            <span style="color:red">Start date is required.</span>
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">End Date</label>
                                                            <datepicker :value="endDate_val" v-model="endDate" :format="'dd-M-yyyy'" :input-class="'form-control'"></datepicker>
                                                            <input type="hidden" id="end_date" name="end_date" />
                                                            <span class="help-block " v-show="fieldHasErrors('jobUpdateForm','end_date')">
                                                            <span style="color:red">End date is required.</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="checkbox">
                                                                <label class="i-checks">
                                                                    <input type="checkbox" id="remote" name="remote" class="form-control"><i></i> Remote work?
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" v-show="isGradlead">
                                                            <div class="checkbox">
                                                                <label class="i-checks">
                                                                    <input type="checkbox" id="featured" name="featured" class="form-control"><i></i> Featured?
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Additional info</div>
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="control-label">Send to URl?</label>
                                                    <input type="text" id="send_via_url" name="send_via_url" class="form-control" placeholder="Job post URL" @blur="validateField('jobUpdateForm','send_via_url')">
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Job Type</label>
                                                    <multiselect :options="jobTypes" :multiple="true" :value="multiJT_val" :close-on-select="true" :hide-selected="true" placeholder="Select Job types" v-model="multiJT" label="name" key="id">
                                                    </multiselect>
                                                    <input type="hidden" name="jobtypes" id="jobtypes" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Positions</label>
                                                    <multiselect :options="skills" :multiple="true" :hide-selected="true" :value="multiSK_val" :close-on-select="true" placeholder="Required skills..." v-model="multiSK" label="name" key="id">
                                                    </multiselect>
                                                    <input type="hidden" name="positions" id="positions" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Country</label>
                                                    <input type="text" id="country" name="country" class="form-control" placeholder="Country" @blur="validateField('jobUpdateForm','country')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobUpdateForm','country')">
            	                                        <span style="color:red">Country is required</span>
                                                    </span>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">City</label>
                                                    <input type="text" id="city" name="city" class="form-control" placeholder="City" @blur="validateField('jobUpdateForm','city')">
                                                    <span class="help-block" v-show="fieldHasErrors('jobUpdateForm','city')">
            	                                        <span style="color:red">City is required</span>
                                                    </span>
                                                </div>

                                                <div v-show="canDoScreening" class="form-group">
                                                    <label class="control-label">Questionnaire</label>
                                                    <select id="questionnaire_id" name="questionnaire_id" class="form-control" placeholder="Select Questionnaire">
                                                        <option value=''>None</option>
                                                        <option v-for="q in questionnaires" :value="q.id">
                                                            @{{ q.name }}
                                                        </option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Distribution List</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="control-label">Post Jobs to:</label>
                                                    <multiselect :options="distributionList" :multiple="true" :value="multiSCH_val" :searchable="true" :allow-empty="false" :close-on-select="true" :hide-selected="true" placeholder="Choose where to post job..." v-model="multiSCH" label="name" key="id">
                                                    </multiselect>
                                                    <span class="help-block" v-show="fieldHasErrors('jobUpdateForm','school_ids')">
                                                        <span style="color:red">This is required</span>
                                                    </span>
                                                    <input type="hidden" name="school_ids" id="school_ids" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" v-if="isCompany">
                                    <div class="col-sm-12">

                                        <div class="panel panel-default">
                                            <div class="panel-heading">Choose Plan</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="control-label">Pricing Plan:</label>
                                                    <select id="plan_id" name="plan_id" class="form-control" placeholder="Select Plan">
                                                        <option v-for="p in availablePlans" :value="p.id">
                                                            @{{ p.name }}
                                                        </option>
                                                    </select>
                                                    <span class="help-block" v-show="fieldHasErrors('jobUpdateForm','plan_id')">
                                                        <span style="color:red">This is required</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <input type="hidden" name="plan_id" id="plan_id" value="1" />
                                </div>

                                <div class="m-t m-b modal-footer">
                                    <a class="btn btn-default pull-left" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab">Cancel</a>

                                    <a v-show="canDoPreselect" href="#jecriteria" aria-controls="jecriteria" role="tab" data-toggle="tab"  class="btn btn-info btn-rounded pull-right" @click="steps.step2=true;setStepClass('step2');">Next</a>

                                    <div v-show="!canDoPreselect" class="pull-right">
                                        <button v-if="jobUpdateForm.valid" type="submit" class="btn btn-success btn-addon">
                                            <i class="fa fa-btn fa-save"></i> Update Job
                                        </button>

                                        <button v-else :disabled="true" type="submit" class="btn btn-success btn-addon">
                                            <i class="fa fa-btn fa-save"></i> Update Job
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Criteria -->
                            <div role="tabpanel" :class="getTabPaneClass('step2')" id="jecriteria">
                                <p class="m-b">What kind of candidate do you want?</p>

                                <spark-progressbar :percent="steps.percent" value="10" max="100" clss="progress-xs" type="success"></spark-progressbar>

                                <input type="hidden" name="preselect" id="preselect" />
                                <input type="hidden" name="degrees" id="degrees" />
                                <input type="hidden" name="majors" id="majors" />
                                <input type="hidden" name="skills" id="skills" />
                                <input type="hidden" name="languages" id="languages" />
                                <input type="hidden" name="industries" id="industries" />

                                <div class="row">
                                    
                                  <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Education Criteria</div>
                                            <div class="panel-body">
                                                
                                                <div class="form-group">
                                                    <label class="control-label">Degrees</label>
                                                    <multiselect :options="degrees" :multiple="true" :hide-selected="true" :value="multiCDeg_val" :close-on-select="true" placeholder="Choose required degrees..." v-model="multiCDeg" label="name" key="name">
                                                    </multiselect>
                                                </div>
                                                

                                                <div class="form-group">
                                                  <label class="control-label">General Major/Area</label>
                                                    <multiselect :options="majors" :multiple="true" :hide-selected="true" :value="multiCMajor_val" :close-on-select="true" placeholder="Choose required majors..." v-model="multiCMajor" label="name" key="name">
                                                    </multiselect>
                                                </div>
                                      
                                                
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="i-checks">
                                                                    <input type="checkbox" name="student" id="student" class="form-control"><i></i> Still In School?
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Graduation Year</label>
                                                            <select id="gradyear" name="gradyear" class="form-control">
                                                                <option v-for="y in years" :value="y">@{{ y }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Abilities &amp; Experience</div>
                                            <div class="panel-body">
                                               
                                                <div class="form-group">
                                                    <label class="control-label">Skills</label>
                                                    <multiselect :options="skills" :multiple="true" :hide-selected="true" :value="multiCSK_val" :close-on-select="true" placeholder="Choose required skills..." v-model="multiCSK" label="name" key="id">
                                                    </multiselect>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label">Industry Experience</label>
                                                    <multiselect :options="industries" :multiple="true" :hide-selected="true" :value="multiCIndustry_val" :close-on-select="true" placeholder="Choose required  industry..." v-model="multiCIndustry" label="name" key="name">
                                                    </multiselect>
                                                </div>
                                                
                                                             
                                                <div class="form-group">
                                                    <label class="control-label">Languages</label>
                                                    <multiselect :options="languages" :multiple="true" :hide-selected="true" :value="multiCLang_val" :close-on-select="true" placeholder="Choose required languages..." v-model="multiCLang" label="name" key="name">
                                                    </multiselect>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="m-t m-b modal-footer">
                                    <a class="btn btn-default pull-left" href="#vjobs" aria-controls="vjobs" role="tab" data-toggle="tab">Cancel</a>

                                    <div class="pull-right">
                                        <a href="#jeinfo" aria-controls="jeinfo" role="tab" data-toggle="tab" class="btn btn-default btn-rounded" @click="setStepClass('step1');">Prev</a>

                                        <button v-if="jobUpdateForm.valid" type="submit" class="btn btn-success btn-addon">
                                            <i class="fa fa-btn fa-save"></i> Update Job
                                        </button>

                                        <button v-else :disabled="true" type="submit" class="btn btn-success btn-addon">
                                            <i class="fa fa-btn fa-save"></i> Update Job
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
    <!-- / Update job -->
</div>
