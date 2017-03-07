Vue.component('gl-profile-account', {
    props: ['authUser','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
        <div class="col wrapper">\
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                        <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{ title }}</h4>\
                        <br/>\
                        <spark-error-alert :form="forms.updateAccount"></spark-error-alert>\
                        <form class="form-horizontal " role="form">\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-text :required="true" :display="\'Name*\'"\
                                    :form="forms.updateAccount" :name="\'name\'"\
                                    :placeholder="\'Enter your name e.g. First Last\'":input.sync="forms.updateAccount.name">\
                                    </gl-text>\
                                 </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-text :required="true" :display="\'UUID*\'" :placeholder="\'Enter a unique identifier (e.g. firstname_lastname)\'" :form="forms.updateAccount" :name="\'uuid\'" :minlength="4" :input.sync="forms.updateAccount.uuid">\
                                    </gl-text>\
                                 </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-password :display="\'Password*\'" :form="forms.updateAccount"\ :name="\'password\'"\
                                    :minlength="6"\
                                    :placeholder="\'Enter a password. It must be more than 6 characters\'"\
                                    :input.sync="forms.updateAccount.password">\
                                    </gl-password>\
                                 </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-password :display="\'Confirm*\'" :form="forms.updateAccount" :name="\'confirm\'" :similar.sync="forms.updateAccount.password" \
                                    :placeholder="\'Re-enter  password. It must match the one above\'"\
                                    :input.sync="forms.updateAccount.confirm">\
                                    </gl-password>\
                                 </div>\
                            </div>\
                        </form>\
                        <div class="panel-footer">\
                            <button type="button" class="btn btn-primary pull-right" @click.prevent="updateUserAccount" :disabled="forms.updateAccount.busy || forms.updateAccount.inValid()">\
                                <span v-if="forms.updateAccount.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Updating</span>\
                                <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                            </button>\
                        </div>\
                    </div>\
                </div>',

    mounted: function () {
        this.setAccount(this.authUser);
        this.setupListeners();
    },

    watch: {},

    events: {},

    notifications: {
      showError: {
          title: 'Account Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Account success',
          message: 'Successfully modified account',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',
			
            account: {},
            
 			forms: {
                updateAccount: new SparkForm({
                    id: '',
                    uuid: '',
                    email: '',
                    name: '',
                    role_id: '',
                    organization_id:'',
                    type:'',
                    password: '',
                    confirm: '',
                }),
            },
        }
    },

    methods: {
        setAccount: function(a) {
            this.account = a;
            if (a != null) {
                this.forms.updateAccount.id = a.id;
                this.forms.updateAccount.email = a.email;
                this.forms.updateAccount.organization_id = a.organization_id; 
                this.forms.updateAccount.role_id = a.role_id;                
                this.forms.updateAccount.type = a.type;                
                this.forms.updateAccount.uuid = a.uuid;
                this.forms.updateAccount.name = a.name;
                this.forms.updateAccount.errors.forget();
            }
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSet', function (user) { self.setAccount(user); });
        },

        updateUserAccount: function() {
            var self = this;
            Spark.put(self.baseUrl+'users/' + this.account.id, this.forms.updateAccount)
                .then(function () { 
                    self.showSuccess({message: 'Account updated'});
                    bus.$emit('updateAuthUser'); 
                },function(resp) {
                    self.forms.updateAccount.busy = false;
                    self.showError({'message': resp[0]});
                });
        },
    }
});
