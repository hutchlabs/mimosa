Vue.component('gradlead-jobs-screen', {

    components: {
        Datepicker,
        Multiselect
    },

    mounted: function() {
        var self = this;
        this.getPlans();
        this.getJobTypes();
        this.getSkills();
        this.getJobs();
        this.steps.percent = (this.isGradlead) ? 0:5;
        
        bus.$on('authUserSet', function(user) {
            self.user = user;
        });
        
        bus.$on('organizationsSet', function(orgs) {
            self.organizations = orgs[0];
            self.employers = orgs[1];
            self.schools = orgs[2];
        });        
    },

    data: function() {
        return {
            baseUrl: '/mimosa/api/',
            
            user: null,
            
            jobs: [],
            apps: [],
            plans: [],
            schools: [],
            employers: [],
            organizations: [],
            jobTypes: [],
            skills: [],

            addSkills:'',
            myskills:'',
            addJT:'',
            sel:'',
            
            steps: { percent:0, step1:true, step2:false, step3:false },
            
            step1Class: 'active',
            step2Class: '',
            step3Class: '',

            currentJob: {'name':'none'},
            removingJobId: null,
            settingStatusId: null,

            yesNoOptions: [
                            {'text': 'Yes', 'value':'1'},
                            {'text': 'No', 'value':'0'},
                         ],
            
            
            jobAddForm: {
                'name': 'addJobForm',
                'valid': false,
                'fields': {
                    'organization_id': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'title': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'teaser': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'description_text': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'textarea',
                        validate: true
                    },
                    'start_date': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'end_date': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'jobtypes': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'select',
                        validate: false
                    },
                    'positions': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'select',
                        validate: false
                    },
                    'country': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'city': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                }
            },
            
            jobUpdateForm: {
                'name': 'updateJobForm',
                'valid': true,
                'fields': {
                    'id': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'organization_id': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'title': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'teaser': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'description_text': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'textarea',
                        validate: true
                    },
                    'start_date': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'end_date': {
                        errors: false,
                        step:'step1',
                        val:5,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                }
            },
            
        };
    },
    
    watch: {
        'addSkills': function(nw) {
            console.log(nw);
            this.myskills += nw.name;
        },
    },
    events: {
  
    },

    computed: {
        everythingLoaded: function () {
            return this.user != null && this.plans.length >0 && this.jobTypes.length>0 && this.skills.length>0;
        },
        isGradlead: function() {
            return (this.user==null) ? false : (this.user.organization_id==1);
        }
    },

    methods: {
        // List and applications
        setJob: function (job) {
            this.currentJob = job;
            this.jobUpdateForm.valid = true;
            this.apps = job.applications;
        },
        
        setApps: function(job) {
            this.apps = job.applications;
        },
        
        updateAddSkills: function (newSelected) { this.addSkills = newSelected; console.log(this.addSkills); },
        updateAddJT (newSelected) { this.addJT = newSelected; },

        
        getJobName: function() {
            return (this.apps.length>0) ? this.apps[0].jobname : '';
        },
            
        removingJob: function(id) { return (this.removingJobId == id); },
        settingStatus: function(id) { return (this.settingStatusId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        
        // Progress functionality
        setStepClass: function(step) {
            console.log("Seing step to "+step);
            if (step=='step1') { this.step1Class='active'; this.step2Class=''; this.step3Class=''; }  
            if (step=='step2') { this.step1Class=''; this.step2Class='active'; this.step3Class=''; }  
            if (step=='step3') { this.step1Class=''; this.step2Class=''; this.step3Class='active'; }  
        },

        getTabPaneClass: function(step) {
            var c = 'tab-pane '; 
            if (step=='step1') { c += (this.steps.step1) ? ' active':'' };
            if (step=='step2') { c += (this.steps.step2) ? ' active':'' };
            if (step=='step3') { c += (this.steps.step3) ? ' active':'' };
            return c;
        },
    
        
        // Form and Validation functions       
        clearFields: function (form) {
            $('#' + this[form]['name'])[0].reset();
            $('.startclosed').hide();
            for (f in this[form]['fields']) {
                this[form]['fields'][f]['errors'] = false;
            }
            this[form]['valid'] = false;
            return true;
        },

        isFieldEmpty: function (form, field, arr) {
            isEmpty = false;
            
            var val = (this[form]['fields'][field]['type'] == 'textarea') 
                ? $('#' + this[form]['name']).find('textarea[name="' + field + '"]').val()
                : $('#' + this[form]['name']).find('input[name="' + field + '"]').val();
            
            if (arr) {
                var f=0;
                for(x in val) { if (val[x]!='') { f++; }}
                isEmpty = (f==0);
            } else {
                isEmpty = (val=='');
            }
            
            return isEmpty;
        },

        isFieldChecked: function (form, field, arr) {
            return $('#' + this[form]['name']).find('input[name="' + field + '"]').is(':checked');
        },

        hasValue: function (form, field, arr) {
            var a = (typeof arr !== 'undefined' && arr===true) ? 'true' : false;
            if (this[form]['fields'][field]['type'] == 'checkbox' ||
                this[form]['fields'][field]['type'] == 'radio') {
                return this.isFieldChecked(form, field, a);
            } else {
                return this.isFieldEmpty(form, field, a);
            }
        },

        showHideField: function (form, field, div, odiv, val) {
           if (form == 'qAddForm' || form == 'qUpdateForm') {
                if (val == 'string') {
                    $('#'+odiv).hide();
                    $('#'+div).hide();
                } else {
                    $('#'+odiv).hide();
                    $('#'+div).show(); 
                }
           } else {
               if (this.hasValue(form, field)) {
                   $('#' + div).show();
                   this.validForm(form, false);
               } else {
                   $('#' + div).hide();
               }
           }
       },

        isValidField: function (form, field) {
            if (this[form]['fields'][field]['validate']) {
                //console.log("Form: "+form+" Field:"+field);
                
                if (this[form]['fields'][field]['vtype'] == null) {
                    return (this.hasValue(form, field)) ? false : true;
                }

                // only check if other field is set
                if (this[form]['fields'][field]['vtype'] == 'notnullif') {
                    // check value of dependent field
                    var f = this[form]['fields'][field]['vcheckf'];
                    var fv = this[form]['fields'][field]['vcheckf'];
                    var cbx = (this[form]['fields'][f]['type'] == 'checkbox');
                    
                    var v = (cbx) ? $('#' + this[form]['name']).find('input[name="' + f + '"]').is(':checked') : 
                    
                    $('#' + this[form]['name']).find('input[name="' + f + '"]').val();
                    
                    var doCheck = (cbx) ? (v == true) : (v != '');
                    
                    if (doCheck) {
                        return (this.hasValue(form, field)) ? false : true;
                    }
                }
                
                // only check if other field is set to a specific value and field is array type
                if (this[form]['fields'][field]['vtype'] == 'atleastoneif') {
                    // check value of dependent field
                    var f = this[form]['fields'][field]['vcheckf'];
                    var v = this[form]['fields'][field]['vcheckv'];
                    var cbx = ($.inArray(this[form]['fields'][f]['type'], ['checkbox','radio']) > -1);
                    
                    var val = $('#' + this[form]['name']).find('input[name="' + f + '"]').val();
                    
                    var isC = (cbx) ? $('#'+this[form]['name']).find('input[name="'+f+ '"]').is(':checked')
                                    : true;
                    var doCheck = (cbx) ? (isC==true && val==v) : (val != '');
                    
                    console.log("f: "+f+ " v:"+v+" cbx:"+cbx+" val:"+val+" isC:"+isC+" docheck:"+doCheck);
                    
                    if (doCheck) {
                        return (this.hasValue(form, field, true)) ? false : true;
                    }
                }
            }

            return true;
        },

        validateField: function (form, field) {
            this[form]['fields'][field]['errors'] = !this.isValidField(form, field);
            this.validForm(form);
        },

        validStep: function(form, step) {
            var proceed= true;
            for (f in this[form]['fields']) {
                if (this[form]['fields'][f]['step']==step) {

                    if(!this.isValidField(form, f)) {
                        proceed = false;
                    }
                }
            }
            
            return proceed;
        },
        
        validForm: function (form, showErrors) {
            var valid = true;
            var se = (showErrors === true || showErrors === false) ? showErrors : false;
            var p = 0;

            for (f in this[form]['fields']) {
                if (!this.isValidField(form, f)) {
                    valid = false;
                    if (se) {
                        this[form]['fields'][f]['errors'] = true;
                    }
                } else {
                    p += this[form]['fields'][f]['val'];
                }
            }

            this.steps.percent = p;        
            this[form]['valid'] = valid;
        
            return valid;
        },
        
        fieldHasErrors: function (form, field) {
            return this[form]['fields'][field]['errors'];
        },
             
        highlightErrors: function (form, d) {
            for (f in d) {
                this[form]['fields'][f]['errors'] = true;
            }
        },
        
       
        // Add functionality
        addJob: function () {
            var self = this;
            var formData = new FormData($('#addJobForm')[0]);

            if (this.validForm('jobAddForm', true)) {
                self.$http.post(self.baseUrl + 'jobs', formData).then(function (resp) {
                    self.getJobs();
                    var back = self.$refs.backtoJobs;
                    back.click();
                }, function (resp) {
                    self.highlightErrors('jobAddForm', resp.data);
                });
            }
        },
        
        // Update functionality 
        updateJob: function (job) {
             var self = this;
                var formData = new FormData($('#updateJobForm')[0]);

                if (this.validForm('jobUpdateForm', true)) {
                    self.$http.post(self.baseUrl + 'jobs/'+job.id,formData).then(function (resp) {
                        self.getJobs();
                        var back = self.$refs.backtoJobs;
                        back.click();
                    }, function (resp) {
                        self.highlightErrors('jobUpdateForm', resp.data);
                    });
                }
        },
        
        // Remove functionality
        removeJob: function (job) {
            var self = this;
            self.removingJobId = job.id;

            this.$http.delete(self.baseUrl+'jobs/' + job.id)
                .then(function () {
                    self.removingJobId = 0;
                    self.jobs = self.removeFromList(this.jobs, job);
                }, function(resp) {
                    self.removingJobId = 0;
                    console.log(resp);
                });
        },


        // Ajax calls
        setStatus: function (job) {
            var self = this;
            job.status = !job.status;
            this.$http.put(self.baseUrl+'jobs/' + job.id + '/changestatus').then(function () {  self.getJobs(); });
        },

        getJobs: function () {
            var self = this;
            this.$http.get(self.baseUrl+'jobs')
                .then(function (resp) {
                    self.jobs = resp.data.data;
                });
		},
       
        getPlans: function () {
            var self = this;
            this.$http.get(self.baseUrl+'plans')
                .then(function (resp) {
                    self.plans = resp.data.data;
                });
		},
       
        getJobTypes: function () {
            var self = this;
            this.$http.get(self.baseUrl+'jobtypes').then(function (resp) {
                    self.jobTypes = resp.data.data;
            });
		},
        
        getSkills: function () {
            var self = this;
            this.$http.get(self.baseUrl+'skills').then(function (resp) {
                    self.skills = resp.data.data;
            });
		},
    },

    filters: {
        status_text: function (value) {
             return (value) ? 'Active' : 'Not Active';
        },
    },
});
