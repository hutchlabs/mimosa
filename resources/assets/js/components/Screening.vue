Vue.component('gradlead-screening-screen', {

    mounted: function () {
        var self = this;
        this.getAuthUser();
        this.getQuestionnaires();
    },

    data: function () {
        return {
            baseUrl: '/mimosa/',

            user: null,
            questionnaires: [],
            questions: [],

            currentQn: {},
            currentQ: { list:{ lone:[], ltwo:[], lthree:[] } },

            passingScoreOptions: [
                {
                    'text': 'Not acceptable',
                    'value': '0'
                },
                {
                    'text': 'Acceptable',
                    'value': '1'
                },
                {
                    'text': 'Good',
                    'value': '2'
                },
                {
                    'text': 'Very Good',
                    'value': '3'
                },
                {
                    'text': 'Excellent',
                    'value': '4'
                },
            ],

            qnAddForm: {
                'name': 'addQuestionnaireForm',
                'valid': false,
                'fields': {
                    'name': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'passing_score': {
                        errors: false,
                        vtype: null,
                        type: 'select',
                        validate: true
                    },
                    'send_auto_reply_more': {
                        errors: false,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'send_auto_reply_less': {
                        errors: false,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'email_more': {
                        errors: false,
                        vtype: 'notnullif',
                        type: 'textarea',
                        vcheckf: 'send_auto_reply_more',
                        validate: true
                    },
                    'email_less': {
                        errors: false,
                        vtype: 'notnullif',
                        type: 'textarea',
                        vcheckf: 'send_auto_reply_less',
                        validate: true
                    },
                }
            },

            qnUpdateForm: {
                'name': 'updateQuestionnaireForm',
                'valid': true,
                'fields': {
                    'id': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'name': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'passing_score': {
                        errors: false,
                        vtype: null,
                        type: 'select',
                        validate: true
                    },
                    'send_auto_reply_more': {
                        errors: false,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'send_auto_reply_less': {
                        errors: false,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'email_more': {
                        errors: false,
                        vtype: 'notnullif',
                        type: 'textarea',
                        vcheckf: 'send_auto_reply_more',
                        validate: true
                    },
                    'email_less': {
                        errors: false,
                        vtype: 'notnullif',
                        type: 'textarea',
                        vcheckf: 'send_auto_reply_less',
                        validate: true
                    },
                }
            },
       
            qAddForm: {
                'name': 'addQuestionForm',
                'valid': false,
                'fields': {
                    'questionnaire_id': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'caption': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'is_required': {
                        errors: false,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'type': {
                        errors: false,
                        vtype: null,
                        type: 'radio',
                        validate: false
                    },
                    'yes_score': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'no_score': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'la_one': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'la_two': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'la_three': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'ls_one': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'ls_two': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'ls_three': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                }
            },
            
            qUpdateForm: {
                'name': 'updateQuestionForm',
                'valid': true,
                'fields': {
                    'id': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'questionnaire_id': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'caption': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: true
                    },
                    'is_required': {
                        errors: false,
                        vtype: null,
                        type: 'checkbox',
                        validate: false
                    },
                    'type': {
                        errors: false,
                        vtype: null,
                        type: 'radio',
                        validate: false
                    },
                    'yes_score': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'no_score': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                   'la_one': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'la_two': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'la_three': {
                        errors: false,
                        vtype: null,
                        type: 'text',
                        validate: false
                    },
                    'ls_one': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'ls_two': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                    'ls_three': {
                        errors: false,
                        vtype: null,
                        vcheckf: 'type',
                        type: 'select',
                        validate: false
                    },
                }
            },
        };
    },

    events: {

    },

    computed: {
        everythingLoaded: function () {
            return this.user != null;
        },
    },

    methods: {
        // Helper methods
        setQuestionnaire: function (questionnaire) {
            this.currentQn = questionnaire;
            this.qnUpdateForm.valid = true;
            this.questions = questionnaire.questions;
        },
        
        setQuestion: function (question) {
            this.currentQ = question;
            this.qUpdateForm.valid = true;
        },
   
        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        
        // Form & Validation functionality
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
                // console.log("Form: "+form+" Field:"+field);
                
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

        validForm: function (form, showErrors) {
            var valid = true;
            var se = (showErrors === true || showErrors === false) ? showErrors : false;

            for (f in this[form]['fields']) {
                if (!this.isValidField(form, f)) {
                    valid = false;
                    if (se) {
                        this[form]['fields'][f]['errors'] = true;
                    }
                }
            }

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
        addQuestionnaire: function () {
            var self = this;
            var formData = new FormData($('#addQuestionnaireForm')[0]);

            if (this.validForm('qnAddForm', true)) {
                self.$http.post(self.baseUrl + 'questionnaires', formData).then(function (resp) {
                    self.getQuestionnaires();
                    var back = self.$refs.backtoQuestionnaire;
                    back.click();
                }, function (resp) {
                    self.highlightErrors('qnAddForm', resp.data);
                });
            }
        },
        
        addQuestion: function () {
            var self = this;
            var formData = new FormData($('#addQuestionForm')[0]);

            if (this.validForm('qAddForm', true)) {
                self.$http.post(self.baseUrl + 'questionnaires/questions', formData).then(function (resp) {
                    var data = resp.data.data;
                    self.getQuestionnaires(true, data);   
                    var back = self.$refs.backtoQuestions;
                    back.click();
                }, function (resp) {
                    self.highlightErrors('qAddForm', resp.data);
                });
            }
        },

        
        // Update functionality 
        updateQuestionnaire: function (questionnaire) {
            var self = this;
            var formData = new FormData($('#updateQuestionnaireForm')[0]);

            if (this.validForm('qnUpdateForm', true)) {
                self.$http.post(self.baseUrl + 'questionnaires/'+questionnaire.id,formData).then(function (resp) {
                    self.getQuestionnaires();
                    var back = self.$refs.backtoQuestionnaire;
                    back.click();
                }, function (resp) {
                    self.highlightErrors('qnUpdateForm', resp.data);
                });
            }
        },
        
        updateQuestion: function (question) {
            var self = this;
            var formData = new FormData($('#updateQuestionForm')[0]);

            if (this.validForm('qUpdateForm', true)) {
                self.$http.post(self.baseUrl+'questionnaires/questions/'+question.id,formData).then(function (resp) {
                    self.getQuestionnaires(true,resp.data.data);
                    var back = self.$refs.backtoQuestions;
                    back.click();
                }, function (resp) {
                    self.highlightErrors('qUpdateForm', resp.data);
                });
            }
        },


        // Remove functionality
        removeQuestionnaire: function (questionnaire) {
            var self = this;
            self.$http.delete(self.baseUrl + 'questionnaires/' + questionnaire.id)
                .then(function () {
                    self.questionnaires = self.removeFromList(this.questionnaires, questionnaire);
                }, function (resp) {
                    console.log(resp);
                });
        },
        
        removeQuestion: function (question) {
            var self = this;
            self.$http.delete(self.baseUrl + 'questionnaires/questions/' + question.id)
                .then(function () {
                    self.questions = self.removeFromList(this.questions, question);
                }, function (resp) {
                    console.log(resp);
                });
        },


        // Start up calls
        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl + 'fauthuser')
                .then(function (user) {
                    self.user = user.data;
                });
        },

        getQuestionnaires: function (loadq,nd) {
            var self = this;
            var loadq = (typeof loadq !== 'undefined') ? true: false;
            this.$http.get(self.baseUrl + 'questionnaires')
                .then(function (resp) {
                    self.questionnaires = resp.data.data;
                    if (loadq) {
                        for(x in self.questionnaires) {
                            if (self.questionnaires[x]['id']==nd.questionnaire_id) {
                                self.setQuestionnaire(self.questionnaires[x]);
                            }
                        }
                    }
                });
        },
    },

    filters: {
        auto_reply_text: function (value) {
            return (value) ? 'Yes' : 'No';
        },
        type_text: function (value) {
            var t = '';
            var o = {string:'Text', boolean:'Yes/No', list:'Single Choice list', multilist:'Multiple Choice list'};
            return o[value];
        },
        passing_score_text: function (value) {
            var t = '';
            var passingScoreOptions = ['Not acceptable', 'Acceptable', 'Good', 'Very Good', 'Excellent'];
            return (value <= 4) ? passingScoreOptions[value] : value;
        }
    },
});
