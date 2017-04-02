var _moment = require('moment');

Vue.component('gradlead-inbox-compose', {
    props: ['user'],

    template: '<div>\
    			<!-- header -->\
                  <div class="wrapper bg-light lter b-b">\
                    <div class="btn-group m-r-sm">\
                      <a @click.prevent="goback()" class="btn btn-sm btn-default w-xxs w-auto-xs"\
                        tooltip="go back"><i class="fa fa-long-arrow-left"></i></a>\
                    </div>\
                  </div>\
                  <!-- / header -->\
                 <div class="wrapper b-b">\
                    <gl-error-alert :form="forms.msgForm"></gl-error-alert>\
                    <form class="form-horizontal m-t-lg" role="form">\
                        <div class="col-lg-8">\
                            <gl-multiselect :display="\'To:\'" :form="forms.msgForm" :name="\'to\'" :input="forms.msgForm.to" :multiple="true" :items="contacts" :placetext="\'\'" :val="\'id\'"></gl-multiselect>\
                        </div>\
                        <div class="col-lg-8">\
                                              <gl-text :display="\'Subject:\'" \
                                                        :required="true"\
                                                          :form="forms.msgForm" \
                                                          :name="\'subject\'" \
                                                          :placeholder="\'Purpose of your message\'" \
                                                          :input="forms.msgForm.subject">\
                                              </gl-text>\
                        </div>\
                        <div class="col-sm-6">\
                                <gl-textarea :required="true" :id="\'msg-container\'" :display="\'Message:\'" :form="forms.msgForm" :name="\'message\'" :placeholder="\'Your message\'" :input.sync="forms.msgForm.message"></gl-textarea>\
                        </div>\
                        <div class="col-sm-2">\
                                 <gl-select :display="\'Templates:\'" \
                                            :form="forms.msgForm" \
                                            :name="\'tpl\'" \
                                            :items="templates" \
                                            :input="forms.msgForm.tpl">\
                                 </gl-select>\
                        </div>\
                        <div class="form-group">\
                            <div class="col-lg-8" style="margin-left: 25px">\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="sendMessage()" :disabled="forms.msgForm.busy">\
                                      <span v-if="forms.msgForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Sending </span>\
                                      <span v-else> <i class="fa fa-btn fa-paper-plane"></i> Send </span>\
                                  </button>\
                            </div>\
                        </div>\
                    </form>\
                  </div>\
			</div>',

    notifications: {
      showError: {
          title: 'Email Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Email success',
          message: 'Successfully sent message',
          type: 'success'
      },
    },


    mounted: function () {
        this.setupListeners();
        this.forms.msgForm.from = this.user.id;
    },

    computed: {
    },

    watch: { 
        'forms.msgForm.tpl': function(v) { this.forms.msgForm.message = v; },
    },

    events: {},

    data: function () {
        return {
            baseUrl: '/',
            contacts: [],
            templates: [],

            forms: {
                msgForm: new SparkForm ({
                    from:'',
                    to: '',
                    subject:'',
                    message:'',
                    tpl: '',
                }),
            },
        }
    },

    methods: {
		setContacts: function(cs) {
            var self = this;
			self.contacts = [];		
            $.each(cs, function(i, c) {
               self.contacts.push({'name':c.text, 'id':c.value}); 
            });
		},

		setTemplates: function(ts) {
            var self = this;
            self.templates = [];
            self.template = '';
            $.each(ts, function(i, t) { self.templates.push(t); });
        },

        goback: function() { 
            this.forms.msgForm.to = '';
            this.forms.msgForm.subject = '';
            this.forms.msgForm.message = '';
            this.forms.msgForm.template = '';
            this.forms.msgForm.errors.forget();
            this.$emit('goback');  
        },

        sendMessage: function () {
            var self = this;

            Spark.post(self.baseUrl+'users/inbox', this.forms.msgForm)
                .then(function () {
                    self.showSuccess({message:'New message sent'});
                    bus.$emit('updateAuthUser');
                    self.goback();
                }, function(resp) {
                    self.forms.msgForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('allLoaded', function () {});
            bus.$on('usersSet', function (users) {
                var u = self.user;
                for (var i = 0; i < users.length; i++) {
                    if (u.id == users[i].id) { u = users[i]; }
                }
                self.setContacts(u.contacts);
                self.setTemplates(u.templates);
            });
        },
    },

    filters: { 
        fromNow: function(v) { return _moment(v).fromNow() },
    },

});
