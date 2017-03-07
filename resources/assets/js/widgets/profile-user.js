Vue.component('gl-profile-user', {
    props: ['authUser','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
        <div class="col wrapper">\
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                        <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{ title }}</h4>\
                        <br/>\
                        <spark-error-alert :form="forms.updateProfile"></spark-error-alert>\
                        <form class="form-horizontal " role="form">\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-textarea :required="true" :id="\'pueSummary\'" :display="\'Summary\'" :form="forms.updateProfile" :name="\'summary\'" :placeholder="\'Something interesting about you...\'" :input.sync="forms.updateProfile.summary">\
                                    </gl-textarea>\
                                 </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-text :display="\'Phone*\'" :form="forms.updateProfile" :name="\'phone\'"\ :input.sync="forms.updateProfile.phone" :required="true" :minlength="10"></gl-text>\
                                </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-text :display="\'Street\'" :form="forms.updateProfile" :name="\'street\'"\ :input.sync="forms.updateProfile.street" :minlength="3" :placeholder="\'e.g. 5 mango ln\'"></gl-text>\
                                </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-location :id="\'pueLoc\'"\
                                                  :display="\'Address (Area, City, Country)\'"\
                                                  :form="forms.updateProfile"\
                                                  :name="\'location\'"\
                                                  :input.sync="location"\
                                                  :placeholder="\'e.g. North legon, Accra, Ghana\'">\
                                      </gl-location>\
                                 </div>\
                            </div>\
                            <div class="row">\
                                <div class="col-md-6">\
                                    <gl-file :display="\'Avatar\'"\
                                             :form="forms.updateProfile" v-on:updated="setFileName"\ :name="\'icon_file\'"\
                                             :warning="\'File must be less than 20MB. Must be an image file\'"\ :filename.sync="forms.updateProfile.file_name"\ :input.sync="forms.updateProfile.icon_file">\
                                    </gl-file>\
                                 </div>\
                            </div>\
                        </form>\
                        <div class="panel-footer">\
                            <button type="button" class="btn btn-primary pull-right" @click.prevent="updateUserProfile" :disabled="forms.updateProfile.busy || forms.updateProfile.inValid()">\
                                <span v-if="forms.updateProfile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Updating</span>\
                                <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                            </button>\
                        </div>\
                    </div>\
                </div>',

    mounted: function () {
        this.setProfile(this.authUser.profile);
        this.setupListeners();
    },

    watch: {},

    events: {},

    notifications: {
      showError: {
          title: 'Profile Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Profile success',
          message: 'Successfully modified profile',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',
			
            profile: {},
            avatar: 'img/a0.jpg',
            location: '',
            
            
 			forms: {
                updateProfile: new SparkForm({
                    id: '',
                    user_id: '',
                    summary: '',
                    country: '',
                    city: '',
                    neighborhood:'',
                    street:'',
                    phone: '',
                    icon_file: '',
                    file_name: '',
                }),
            },
        }
    },

    methods: {
        setFileName: function(name) {
            this.forms.updateProfile.file_name = name;
        },

		getImageUrl: function() {
            if (this.profile != null) {
                return '/profiles/avatar/'+this.profile.id+'?'+new Date();
            }
        },
        
        getLocation: function(e) {
            var add = [];
            //if (e.street!='') { add.push(e.street); }
            if (e.neighborhood!='') { add.push(e.neighborhood); }
            if (e.city!='') { add.push(e.city); }
            if (e.country!='') { add.push(e.country); }
            return (add.length>0) ? add.join(', ') : '';
        },
            
        setProfile: function(a) {
            this.profile = a;
            if (a != null) {
                this.location = this.getLocation(this.profile);
                this.avatar = this.getImageUrl();
                this.forms.updateProfile.id = this.profile.id;
                this.forms.updateProfile.user_id = this.profile.user_id;
                this.forms.updateProfile.phone = this.profile.phone;
                this.forms.updateProfile.summary = this.profile.summary;
                this.forms.updateProfile.country = this.profile.country;
                this.forms.updateProfile.city = this.profile.city;
                this.forms.updateProfile.neighborhood  = this.profile.neighborhood;
                this.forms.updateProfile.street  = this.profile.street;
            }
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSet', function (user) { self.setProfile(user.profile); });
        },

        updateUserProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/users/' + this.profile.id, this.forms.updateProfile)
                .then(function () { 
                    self.showSuccess({message: 'Profile updated'});
                    bus.$emit('updateAuthUser'); 
                },function(resp) {
                    self.forms.updateProfile.busy = false;
                    self.showError({'message': resp[0]});
                });
        },
    }
});
