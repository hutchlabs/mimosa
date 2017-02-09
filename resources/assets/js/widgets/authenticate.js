Vue.component('spark-authenticate', {
    props: [],

    // TODO: Finish logo load and onclick 
    template: '<div><div v-if="loggedIn">\
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
				    <div class="modal-dialog">\
				        <div class="modal-content">\
				            <div class="modal-header">\
				                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
				                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Login</h4>\
				            </div>\
				            <div class="modal-body">\
				                <spark-error-alert :form="forms.login"></spark-error-alert>\
				                <form class="form-horizontal" role="form">\
									 <div class="row">\
				                        <div class="col-md-12">\
				                            <spark-email :display="\'Email*\'" :form="forms.login" :name="\'email\'"\
														 :input="forms.login.email"></spark-email>\
				                            <spark-password :display="\'Password*\'" :form="forms.login" :name="\'password\'"\
															:input="forms.login.password" v-on:keyup.enter="doLogin"></spark-password>\
				                        </div>\
				                    </div>\
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
				    <div class="modal-dialog">\
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
 											<spark-select :display="\'Type*\'" :form="forms.signup" :name="\'type\'"\
														  :items="typeOptions" :input="forms.signup.type">\
                            				</spark-select>\
				                            <spark-text :display="\'Name*\'" :form="forms.signup" :name="\'name\'"\
														:input="forms.signup.name"></spark-text>\
				                            <spark-email :display="\'Email*\'" :form="forms.signup" :name="\'email\'"\
														 :input="forms.signup.email"></spark-email>\
				                            <spark-password :display="\'Password*\'" :form="forms.signup" :name="\'password\'"\
															:input="forms.signup.password"></spark-password>\
				                        </div>\
				                    </div>\
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
        this.getAuthUser();
    },

    data: function () {
        return {
            user: null,
            loggedIn: false,
            baseUrl: '/mimosa/',

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
                    name: '',
                    email: '',
                    password: '',
                }),
            }
        }
    },

    methods: {
        showLogin: function () {
			this.forms.login.email = '';
			this.forms.login.password = '';
            this.forms.login.errors.forget();
			$('#modal-signup').modal('hide');
			$('#modal-login').modal('show');
			$('.modal-backdrop').css('z-index', '0');
        },
        showSignup: function () {
			this.forms.signup.type = '';
			this.forms.signup.email = '';
			this.forms.signup.password = '';
			this.forms.signup.name = '';
            this.forms.signup.errors.forget();
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
					self.gotoDashboard();
					$('#modal-signup').modal('hide');
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
            window.location.href= this.baseUrl+'home/';
		},
        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) {
                    self.user = user.data; 
                    self.loggedIn = (self.user.name) ? true : false;
                });
        },
    }    
});
