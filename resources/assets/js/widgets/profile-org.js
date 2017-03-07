Vue.component('gl-profile-org', {

    props: ['authUser', 'usertype', 'permissions', 'title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{ title }}</h4>\
                    <br/>\
                    <spark-error-alert :form="forms.updateProfile"></spark-error-alert>\
                    <form class="form-horizontal " role="form">\
                        <div class="row">\
                            <div class="col-md-6">\
                                <gl-textarea :required="true" :id="\'poeSummary\'" :display="\'Summary\'" :form="forms.updateProfile" :name="\'summary\'" :placeholder="\'Something interesting about you...\'" :input.sync="forms.updateProfile.summary">\
                                </gl-textarea>\
\
                                <gl-text :display="\'Street\'" :form="forms.updateProfile" :name="\'street\'" :input.sync="forms.updateProfile.street" :minlength="3" :placeholder="\'e.g. 5 mango ln\'"></gl-text>\
\
                                <gl-location :id="\'poeLoc\'"\
                                  :display="\'Address (Area, City, Country)\'"\
                                  :form="forms.updateProfile"\
                                  :name="\'location\'"\
                                  :input.sync="location"\
                                  :placeholder="\'e.g. North legon, Accra, Ghana\'">\
                                  </gl-location>\
\
                                <gl-file :display="\'Logo\'" :form="forms.updateProfile" v-on:updated="setFileName" :name="\'icon_file\'" :warning="\'File must be less than 20MB. Must be an image file\'" :filename.sync="forms.updateProfile.file_name" :input.sync="forms.updateProfile.icon_file">\
                                </gl-file>\
\
                            </div>\
                            <div class="col-md-6">\
                                <gl-text v-show="isCompany" :display="\'Description*\'" :form="forms.updateProfile" :name="\'description\'" :input.sync="forms.updateProfile.description"></gl-text>\
\
                                <gl-text v-show="isCompany" :display="\'Number of Employees\'" :form="forms.updateProfile" :name="\'num_employees\'" :input.sync="forms.updateProfile.num_employees" :placeholder="\'Number of employees e.g. 300\'"></gl-text>\
\
                                <gl-text v-show="isCompany" :display="\'Website\'" :form="forms.updateProfile" :name="\'website\'" :input.sync="forms.updateProfile.website" :placeholder="\'http://\'"></gl-text>\
\
                                <gl-text v-show="isCompany" :display="\'Job Types*\'" :form="forms.updateProfile" :name="\'jobtypes\'" :input.sync="forms.updateProfile.jobtypes"></gl-text>\
\
                                <gl-text v-show="isCompany" :display="\'Industries*\'" :form="forms.updateProfile" :name="\'industries\'" :input.sync="forms.updateProfile.industries"></gl-text>\
                            </div>\
                        </div>\
                    </form>\
                    <div class="panel-footer">\
                        <button v-if="isSchool" type="button" class="btn btn-primary pull-right" @click.prevent="updateSchoolProfile" :disabled="forms.updateProfile.busy">\
                            <span v-if="forms.updateProfile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Updating</span>\
                            <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                        </button>\
                        <button v-else type="button" class="btn btn-primary pull-right" @click.prevent="updateCompanyProfile" :disabled="forms.updateProfile.busy">\
                            <span v-if="forms.updateProfile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Updating</span>\
                            <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                        </button>\
                    </div>\
                </div>\
            </div>',
    
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
    
    mounted: function () {
        this.setProfile(this.authUser.organization.profile);
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Org Profile',

			profile: {},
            avatar: 'img/a0.jpg',
            location: '',


 			forms: {
                updateProfile: new SparkForm({
                    id: '',
                    organization_id: '',
                    summary: '',
                    description: '',
                    country: '',
                    city: '',
                    street: '',
                    jobtypes: '',
                    industries: '',
                    website: '',
                    num_employees:'',
                    icon_file: '',
                    file_name: '',
                }),
            },
        };
    },

    watch: { },

    events: {},

    computed: {
        everythingLoaded: function () { return this.authUser != null },
        isSchool: function() { return (this.usertype.isSchool || this.usertype.isGradlead); },
        isCompany: function() { return (!this.usertype.isSchool && !this.usertype.isGradlead); },
    },

    methods: {
        setFileName: function(name) {
            this.forms.updateProfile.file_name = name;
        },

		getImageUrl: function() {
            if (this.profile != null) {
                var p = (this.isSchool) ? 'crest' : 'logo';
                return '/profiles/'+p+'/'+this.profile.id+'?'+new Date();
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
           

        setProfile: function(p) {
            this.profile = p;
            if (this.profile != null) {
                this.location = this.getLocation(this.profile);
                this.avatar = this.getImageUrl();
                this.forms.updateProfile.id = this.profile.id;
                this.forms.updateProfile.organization_id = this.profile.organization_id;
                this.forms.updateProfile.summary = this.profile.summary;
                this.forms.updateProfile.country = this.profile.country;
                this.forms.updateProfile.city = this.profile.city;
                this.forms.updateProfile.neighborhood  = this.profile.neighborhood;
                this.forms.updateProfile.street  = this.profile.street;
                
                if (this.isCompany) {
                    this.forms.updateProfile.description  = this.profile.description;
                    this.forms.updateProfile.website  = this.profile.website;
                    this.forms.updateProfile.num_employees  = this.profile.num_employees;
                    this.forms.updateProfile.jobtypes  = this.profile.jobtypes;                   this.forms.updateProfile.industries  = this.profile.industries;
                }
            }
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSet', function (user) { self.setProfile(user.organization.profile); });
            bus.$emit('screenLoaded',self.modname);
        },

        updateSchoolProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/schools/' + this.profile.id, this.forms.updateProfile)
                .then(function () {
                    self.showSuccess({message: 'Profile updated'});
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
                },function(resp) {
                    self.forms.updateProfile.busy = false;
                    self.showError({'message': resp[0]});
                });
        },

        updateCompanyProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/employees/' + this.profile.id, this.forms.updateProfile)
                .then(function () {
                    self.showSuccess({message: 'Profile updated'});
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
                },function(resp) {
                    self.forms.updateProfile.busy = false;
                    self.showError({'message': resp[0]});
                });
        },
    },

    filters: { },
});
