Vue.component('gradlead-authenticate', {
    props: [],

    // TODO: Finish logo load and onclick 
    template: '<div><div v-if="loggedIn" class="col wrapper">\
                   <a style="cursor: pointer" @click.prevent="gotoDashboard" class="btn btn-primary btn-xs">\
                      Welcome {{user.name}}\
                    </a>\
					<a style="cursor: pointer" @click.prevent="doLogout" class="btn btn-primary btn-filled btn-xs">Logout</a>\
				</div>\
				<div v-else>\
                  <a style="cursor: pointer" @click.prevent="showLogin" class="btn btn-primary login-button btn-xs">Login</a>\
                  <a style="cursor: pointer" @click.prvevent="showSignup" class="btn btn-primary btn-filled btn-xs">Signup</a>\
            	</div>\
				<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" style="margin:auto; width: 760px;">\
				    <div class="modal-dialog" style="width:50%">\
				        <div class="modal-content">\
				            <div class="modal-header">\
				                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
				                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Login</h4>\
				            </div>\
				            <div class="modal-body">\
				                <spark-error-alert v-show="1==0" :form="forms.login"></spark-error-alert>\
				                <form class="form-horizontal" role="form">\
                                <div class="row">\
                                <div class="col-md-12">\
				                        <gl-email :required="true" :display="\'Email*\'" :form="forms.login" :name="\'email\'"\
												  :input="forms.login.email" :placeholder="\'e.g. name@server.com\'"></gl-email>\
				                        <gl-password :required="true" :display="\'Password*\'" :form="forms.login" :name="\'password\'"\
													 :minlength="4" :input="forms.login.password" v-on:keyup.enter="doLogin"></gl-password>\
                                </div></div>\
				                </form>\
							</div>\
							<div class="modal-footer">\
				                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>\
  								<button type="button" class="btn btn-primary btn-filled" @click.prevent="doLogin">Login</button>\
							</div>\
						</div>\
					</div>\
				</div>\
				<div class="modal fade" id="modal-signup" tabindex="-1" role="dialog" style="margin:auto; width: 760px;">\
				    <div class="modal-dialog" style="width:50%">\
				        <div class="modal-content">\
				            <div class="modal-header">\
				                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
				                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Sign Up!</h4>\
				            </div>\
				            <div class="modal-body">\
				                <spark-error-alert :form="forms.signup"></spark-error-alert>\
				                <form class="form-horizontal" role="form">\
                                <div class="row">\
                                <div class="col-md-12">\
 										<gl-select :display="\'Type*\'" :form="forms.signup" :name="\'type\'"\
												   :items="typeOptions" :input="forms.signup.type">\
                            			</gl-select>\
				                         <gl-text :required="true" :display="\'First name*\'" :form="forms.signup" :name="\'first\'"\
												  :input="forms.signup.first" :placeholder="\'Your first name\'"></gl-text>\
				                         <gl-text :required="true" :display="\'Last name*\'" :form="forms.signup" :name="\'last\'"\
												  :input="forms.signup.last" :placeholder="\'Your last name\'"></gl-text>\
				                          <gl-email :required="true" :display="\'Email*\'" :form="forms.signup" :name="\'email\'"\
												    :input="forms.signup.email" :placeholder="\'e.g. name@server.com\'"></gl-email>\
				                            <gl-password :required="true" :minlength="6" :display="\'Password*\'" :form="forms.signup" :name="\'password\'"\
														 :input="forms.signup.password"></gl-password>\
                                </div></div>\
				                </form>\
							</div>\
							<div class="modal-footer">\
				                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>\
  								<button type="button" class="btn btn-primary btn-filled" @click.prevent="doSignup">Sign Up</button>\
							</div>\
						</div>\
					</div>\
			</div>',
 
    mounted: function () {
        this.setupListeners();
        this.getAuthUser();
    },

    data: function () {
        return {
            user: null,
            loggedIn: false,
            baseUrl: '/',
            redirect: '/home/',

			typeOptions: [
                            {'text': 'Current Student', 'value':'student'},
                            {'text': 'Graduate', 'value':'graduate'},
                         ],

            forms: {
                login: new SparkForm ({
                    email: '',
                    password: '',
                }),

                signup: new SparkForm ({
                    type: '',
                    last: '',
                    first: '',
                    email: '',
                    password: '',
                }),
            }
        }
    },

    methods: {
        showLogin: function (redirect) {
            if (typeof redirect != 'undefined' && typeof redirect!='object') { this.redirect = redirect; }
			this.forms.login.email = '';
			this.forms.login.password = '';
            this.forms.login.errors.forget();
			$('#modal-signup').modal('hide');
			$('#modal-login').modal('show');
			$('.modal-backdrop').css('z-index', '0');
        },
        showSignup: function (redirect) {
            this.forms.signup.errors.forget();
			this.forms.signup.type = '';
			this.forms.signup.email = '';
			this.forms.signup.password = '';
			this.forms.signup.first = '';
			this.forms.signup.last = '';
            if (typeof redirect != 'undefined' && typeof redirect!='object') { this.redirect = redirect; }
			$('#modal-login').modal('hide');
			$('#modal-signup').modal('show');
			$('.modal-backdrop').css('z-index', '0');
        },
		doLogin: function() {
			var self = this;
            this.$http.post(self.baseUrl+'flogin', this.forms.login)
                .then(function (resp) {
					self.gotoDashboard();
					$('#modal-login').modal('hide');
                }, function(resp) {
                    self.forms.login.errors.set(resp.data.errors);
                    self.forms.login.busy = false;
				});
		},
		doSignup: function() {
			var self = this;
            this.$http.post(self.baseUrl+'fregister', this.forms.signup)
                .then(function (resp) {
					$('#modal-signup').modal('hide');
					self.gotoDashboard();
                }, function(resp) {
                    self.forms.signup.errors.set(resp.data.errors);
                    self.forms.signup.busy = false;
				});
		},
        doLogout: function () {
            var self = this;
            this.$http.get(self.baseUrl+'flogout')
                .then(function (resp) {
                    self.loggedIn = false;
					self.user = {};
                    window.location.href= self.baseUrl;
                });
        },
		gotoDashboard: function() {
			this.getAuthUser();
            window.location.href=this.redirect; 
		},
        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) {
                    self.user = user.data; 
                    self.loggedIn = (self.user.name) ? true : false;
                });
        },

        setupListeners: function () {
            var self = this;
            bus.$on('showRegistration', function (redirect) { self.showSignup(redirect); });
            bus.$on('showLogin', function (redirect) { self.showLogin(redirect); });
        },
    }    
});
