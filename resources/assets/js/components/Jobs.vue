Vue.component('gradlead-jobs-screen', {

    components: {
        Datepicker,
        Multiselect
    },

    mounted: function() {
        var self = this;       
        this.getJobs();
        this.getQuestionnaires();
        this.getContracts(); 
        this.getPlans();
        
        this.getJobTypes();
        this.getLanguages();
        this.getDegrees();
        this.getMajors();
        this.getIndustries();
        this.getSkills();
        
        this.today = new Date();
        this.startDate_val =  this.today.getFullYear()+'-'+(this.today.getMonth()+1)+'-'+this.today.getDate();
        this.endDate_val = this.today.getFullYear()+'-'+(this.today.getMonth()+1)+'-'+this.today.getDate();
                
        var cy = this.today.getFullYear();
        for(var i=cy; i < (cy+30); i++) { this.years.push(i); }
        
        this.steps.percent = (this.isGradlead) ? 0 : this.stepVal;
                
        bus.$on('authUserSet', function(user) {
            self.user = user;
            self.canDoScreening = self.user.organization.permissions.screening;
            self.canDoPreselect = self.user.organization.permissions.preselect;
        });
        
        bus.$on('organizationsSet', function(orgs) {
            self.organizations = orgs[0];
            self.employers = orgs[1];
            self.schools = orgs[2];
            
            // create distribution list
            self.distributionList.push({'id':1, 'name':'Gradlead Network'});
                        
            for(var i=0; i < self.schools.length; i++) {
                if (self.isGradlead || 
                   (self.user.organization.type=='school' && self.user.organization.id==self.schools[i].id) ||
                   (self.user.organization.type=='employer' && self.isInArray(this.schools[i].id, self.user.organization.schools))
                ) {
                    self.distributionList.push({'id':self.schools[i].id, 'name':self.schools[i].name});
                }
            } 
            
        });        
    },

    data: function() {
        return {
            baseUrl: '/mimosa/',
            
            user: null,
            canDoScreening: false,
            canDoPreselect: false,
            
            apps: [],
            availablePlans:[],
            contracts: [],
            degrees: [],
            distributionList: [],
            employers: [],
            industries: [],
            jobs: [],
            jobTypes: [],
            languages: [],
            majors: [],
            organizations: [],
            plans: [],
            questionnaires: [],
            schools: [],
            skills: [],
            years: [],
            
            today: '',
            startDate_val:  '',
            endDate_val: '',
            startDate: '',
            endDate: '',
     
            multiJT:'',
            multiSK:'',
            multiSCH:'',
            multiCSK: '',
            multiCIndustry: '',
            multiCLang:'',
            multiCDeg: '',
            multiCMajor: '',

            multiJT_val:'',
            multiSK_val:'',
            multiSCH_val:'',
            multiCSK_val:'',
            multiCIndustry_val: '',
            multiCLang_val:'',
            multiCMajor_val:'',
            multiCDeg_val:'',
 
            stepVal: 12.5,
            steps: { percent:0, step1:true, step2:false },
            step1Class: 'active',
            step2Class: '',

            currentJob: {'name':'none'},
            removingJobId: null,
            settingStatusId: null,

            // forms
            currentForm: 'jobAddForm',
            
            jobAddForm: {
                'name': 'addJobForm',
                'valid': false,
                'fields': {
                    'organization_id': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'title': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'teaser': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'description_text': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'textarea',
                        validate: true
                    },
                    'start_date': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'end_date': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'remote': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'featured': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'send_via_url': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'jobtypes': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'select',
                        validate: false
                    },
                    'positions': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'select',
                        validate: false
                    },
                    'country': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'city': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'questionnaire_id': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'school_ids': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'plan_id': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'select',
                        validate: true
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
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'title': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'teaser': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'description_text': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'textarea',
                        validate: true
                    },
                    'start_date': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'end_date': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'remote': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'featured': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'send_via_url': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'jobtypes': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'select',
                        validate: false
                    },
                    'positions': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'select',
                        validate: false
                    },
                    'country': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'city': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'questionnaire_id': {
                        errors: false,
                        step:'step1',
                        val:0,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'school_ids': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'plan_id': {
                        errors: false,
                        step:'step1',
                        val:this.stepVal,
                        vtype: null,
                        type: 'select',
                        validate: true
                    },
                }
            },        
        };
    },
    
    watch: {
        'startDate': function(nw) { 
            this.setValue(this.currentForm,'start_date',nw);
            this.validateField(this.currentForm,'start_date',true);
        },
        'endDate': function(nw) {   
            this.setValue(this.currentForm,'end_date',nw);
            this.validateField(this.currentForm,'end_date',true);
        },
        'multiJT': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'jobtypes',vals);
        },
        'multiSK': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'positions',vals);
        },
        'multiSCH': function(nw) {            
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].id + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'school_ids',vals);
            this.validateField(this.currentForm,'school_ids',true);
        },
        'multiCSK': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'skills',vals);
        },
        'multiCLang': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'languages',vals);
        },
        'multiCIndustry': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'industries',vals);
        },
        'multiCMajor': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'majors',vals);
        },
        'multiCDeg': function(nw) {
            var vals = '';
            for(var i=0; i < nw.length; i++) {
                vals += nw[i].name + ((i<nw.length-1) ? ',':'');
            }
            this.setValue(this.currentForm,'degrees',vals);
        },
    },
    
    events: {},

    computed: {
        everythingLoaded: function () {
            return this.user != null && this.plans.length >0 && this.jobTypes.length>0 && this.skills.length>0;
        },
        isGradlead: function() {
            return (this.user==null) ? false : (this.user.organization_id==1);
        },
        isCompany: function() {
            return (this.user==null) ? false : (this.user.organization.type=='employer');
        }
    },

    methods: {
        // List and applications
        setJob: function (job) {
            this.currentJob = job;
            this.apps = job.applications;

            this.currentForm = 'jobUpdateForm';
            this.jobUpdateForm.valid = true;
            this.setFormValues(job);
         
            this.steps.percent = 100;
            this.steps.step1 = true;
            this.steps.step2 = false;
            this.setStepClass('step1');
        },
        
        setApps: function(job) {
            this.apps = job.applications;
        },
                
        getJobName: function() {
            return (this.apps.length>0) ? this.apps[0].jobname : '';
        },
            
        removingJob: function(id) { return (this.removingJobId == id); },
        settingStatus: function(id) { return (this.settingStatusId == id); },

        
        // Add/Edit Job Progress functionality
        setStepClass: function(step) {
            if (step=='step1') { this.step1Class='active'; this.step2Class='';  }  
            if (step=='step2') { this.step1Class=''; this.step2Class='active'; }  
        },

        getTabPaneClass: function(step) {
            var c = 'tab-pane '; 
            if (step=='step1') { c += (this.steps.step1) ? ' active':'' };
            if (step=='step2') { c += (this.steps.step2) ? ' active':'' };
            return c;
        },
    
        
        // Form and Validation functions       
        clearFields: function (form) {
            this.currentForm = form;

            $('#' + this[form]['name'])[0].reset();
            $('.startclosed').hide();
            for (f in this[form]['fields']) { this[form]['fields'][f]['errors'] = false; }
            
            this.steps.percent = (this.isGradlead) ? 0 : this.stepVal;
            this.steps.step1 = true;
            this.steps.step2 = false;
            
            this.startDate_val =  this.today.getFullYear()+'-'+(this.today.getMonth()+1)+'-'+this.today.getDate();
            this.endDate_val = this.today.getFullYear()+'-'+(this.today.getMonth()+1)+'-'+this.today.getDate();
            this.multiJT_val     = [];
            this.multiSK_val     = [];
            this.multiSCH_val    = [];
            this.multiCDeg_val   = [];
            this.multiCMajor_val = [];
            this.multiCSK_val    = [];
            this.multiCLang_val  = [];
            this.multiCIndustry_val = [];
            
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

        setValue: function(form, field, val) {
            $('#' + this[form]['name']).find('input[name="' + field + '"]').val(val);
        },
        
        setSelectValue: function(form, field, val) {
            $('#' + this[form]['name']).find('select[name="' + field + '"]').val(val);
        },

        setTextareaValue: function(form, field, val) {
            $('#' + this[form]['name']).find('textarea[name="' + field + '"]').val(val);
        },

        setRadioCbxValue: function(form, field, val) {
            val = (val=="true") ? true : val;
            $('#' + this[form]['name']).find('input[name="' + field + '"]').prop('checked',val);
        },
     
        setPreselectValue: function(form) {
            var self = this;
            var preselectFields = ['student','gradyear','degrees','majors','skills','languages','industries'];
            var val = '{';
            $.each(preselectFields, function(index, v) {
                    var type = (v=='student') ? 'checkbox' : 'text';
                    type = (v=='gradyear') ? 'select' : v;
                    val += '"'+v+'": "'+self.getFieldValue(form, v, type) + '"'
                    val += (v=='industries') ? '' : ', ';
            });
            val += '}';
            this.setValue(form, 'preselect', val);
        },
              
        setFormValues: function(job) {
            this.setValue(this.currentForm, 'organization_id', job.organization_id);    
            this.setValue(this.currentForm, 'title', job.title);    
            this.setValue(this.currentForm, 'teaser', job.teaser);    
            this.setValue(this.currentForm, 'country', job.country);    
            this.setValue(this.currentForm, 'city', job.city);    
            this.setValue(this.currentForm, 'send_via_url', job.send_via_url);    
            
            this.setSelectValue(this.currentForm, 'questionnaire_id', job.questionnaire_id);    
            this.setSelectValue(this.currentForm, 'plan_id', job.contract.plan.id);    
            
            this.setTextareaValue(this.currentForm, 'description_text', job.description_text);    
            this.setRadioCbxValue(this.currentForm, 'remote', job.remote);    
            this.setRadioCbxValue(this.currentForm, 'featured', job.featured);    

            this.startDate_val = job.start_date;
            this.endDate_val = job.end_date;
            this.startDate = this.startDate_val; this.endDate = this.endDate_val;

            this.multiJT_val = this.getMultiValues('jobtypes',job.job_types); this.multiJT  = this.multiJT_val;
            this.multiSK_val = this.getMultiValues('skills',job.positions); this.multiSK = this.multiSK_val;
            this.multiSCH_val = this.getMultiValues('schools', job.school_ids, true); this.multiSCH = this.multiSCH_val;

            if (job.preselect!='') {
                var obj = $.parseJSON(job.preselect.replace(/'/g,'"'));
                this.setValue(this.currentForm, 'preselect', job.preselect);  
                this.setSelectValue(this.currentForm, 'gradyear',obj['gradyear']);    
                this.setRadioCbxValue(this.currentForm, 'student', obj['student']);    
                
                this.multiCSK_val = this.getMultiValues('skills',obj['skills']); this.multiCSK  = this.multiCSK_val;
                this.multiCDeg_val = this.getMultiValues('degrees',obj['degrees']);this.multiCDeg  = this.multiCDeg_val;
                this.multiCMajor_val = this.getMultiValues('majors',obj['majors']);this.multiCMajor  = this.multiCMajor_val;
                this.multiCLang_val = this.getMultiValues('languages',obj['languages']);this.multiCLang  = this.multiCLang_val;
                this.multiCIndustry_val = this.getMultiValues('industries',obj['industries']);this.multiCIndustry  = this.multiCIndustry_val;
            }
        },
        
        getMultiValues: function (type, value, useId) {
            var self = this;
            var items = null;
            var vals = [];
            useId = (typeof useId == 'undefined') ? false : useId;

            if (type=='jobtypes') { items = this.jobTypes; }
            if (type=='skills')   { items = this.skills; }
            if (type=='schools')   { items = this.distributionList; }
            if (type=='degrees')   { items = this.degrees; }
            if (type=='majors')   { items = this.majors; }
            if (type=='languages')   { items = this.languages; }
            if (type=='industries')   { items = this.industries; }

            var values = (typeof value=='undefined') ? [] : value.split(',');
            
            if (items!=null) {
                $.each(items, function(idx, item) {
                        var v = (useId) ? ""+item.id : item.name;
                        if (self.isInArray(v,values)) {
                            vals.push(item);
                        }
                });    
            }
            return vals;
        },

        getFieldValue: function (form, field, type) {
            if (type == 'checkbox' || type == 'radio') {
                return $('#' + this[form]['name']).find('input[name="' + field + '"]').is(':checked');
            } else if (type=='textarea') {
                return $('#' + this[form]['name']).find('textarea[name="' + field + '"]').val();
            } else if (type=='select') {
                return $('#'+field).val();
            } else {
                return $('#' + this[form]['name']).find('input[name="' + field + '"]').val();
            }
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
                    
                    if (doCheck) {
                        return (this.hasValue(form, field, true)) ? false : true;
                    }
                }
            }

            return true;
        },

        validateField: function (form, field, errors=null) {
            this[form]['fields'][field]['errors'] = !this.isValidField(form, field);
            this.validForm(form, errors);
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
            if (self.canDoPreselect) { self.setPreselectValue('jobAddForm'); }
            
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
        updateJob: function () {
            var self = this;            
            if (self.canDoPreselect) { self.setPreselectValue('jobUpdateForm'); }

            var formData = new FormData($('#updateJobForm')[0]);

           // if (this.validForm('jobUpdateForm', true)) {
                self.$http.post(self.baseUrl + 'jobs/'+this.currentJob.id,formData).then(function (resp) {
                    self.getJobs();
                    var back = self.$refs.backtoJobs;
                    back.click();
                }, function (resp) {
                    self.highlightErrors('jobUpdateForm', resp.data);
                });
        //   }
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
        
        getQuestionnaires: function () {
            var self = this;
            this.$http.get(self.baseUrl+'questionnaires').then(function (resp) {
                    self.questionnaires = resp.data.data;
            });
		},
        
        getMajors: function () {
            var self = this;
            this.$http.get(self.baseUrl+'majors').then(function (resp) {
                    self.majors = resp.data.data;
            });
		},
        
        getDegrees: function () {
            var self = this;
            this.$http.get(self.baseUrl+'degrees').then(function (resp) {
                    self.degrees = resp.data.data;
            });
		},
        
        getIndustries: function () {
            var self = this;
            this.$http.get(self.baseUrl+'industries').then(function (resp) {
                    self.industries = resp.data.data;
            });
		},
        
        getLanguages: function () {
            var self = this;
            this.$http.get(self.baseUrl+'languages').then(function (resp) {
                    self.languages = resp.data.data;
            });
		},
       
        getPlans: function () {
            var self = this;
            this.$http.get(self.baseUrl+'plans')
                .then(function (resp) {
                    self.plans = resp.data.data;
                    if (self.plans.length>0) {
                        $.each(self.plans, function(idx, plan) {
                            if (!plan.expired && plan.id!=1 && this.noContract(plan.id)) {
                                var posts = (plan.num_posts==0) ? 'Unlimited' : plan.num_posts;
                                var name = 'New Plan: '+plan.name+' | Posts: '+posts+' | Price: GHC '+plan.cost;
                                self.availablePlans.push({'id':plan.id, 'name':name});
                            }
                        });
                    }
                });
		},
        
        getContracts: function () {
            var self = this;
            this.$http.get(self.baseUrl+'contracts')
                .then(function (resp) {
                    self.contracts = resp.data.data;             
                    if (self.contracts.length>0) {
                        $.each(self.contracts, function(idx, contract) {
                            if (!contract.expired) {
                                var name = 'Existing Plan: '+contract.plan.name+' ('+contract.remaining_posts+' posts left)';
                                self.availablePlans.push({'id':contract.plan.id, 'name':name});
                            }
                        });
                    }
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
        
        
        // Helpers
        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },
        
        isInArray: function(item, array) { 
            return !! ~$.inArray(item, array); 
        },

        noContract: function(planid) {
            var cin = true;
            $.each(this.contracts, function(i, c) {
                    if (planid==c.plan.id) {
                        cin = false;
                    }
            });
            return cin;
        },
        
        ucwords: function(str) {
            return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
        },
    },

    filters: {
        status_text: function (value) {
             return (value) ? 'Active' : 'Not Active';
        },
    },
});
