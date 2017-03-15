Vue.component('gl-view-profile-org', {

    props: ['organization', 'authUser', 'usertype', 'permissions','jobtypes','industries'],

    template: '<div class="hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <spark-error-alert :form="forms.updateProfile"></spark-error-alert>\
                    <form class="form-horizontal " role="form">\
                        <div class="row">\
                            <div class="col-md-12">\
                                <gl-textarea :required="true" :id="idSum" :display="\'Summary\'" :form="forms.updateProfile" :name="\'summary\'" :placeholder="\'Something interesting about you...\'" :input.sync="forms.updateProfile.summary">\
                                </gl-textarea>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <gl-text v-show="isCompany" :display="\'Description*\'" :form="forms.updateProfile" :name="\'description\'" :input.sync="forms.updateProfile.description"></gl-text>\
                            </div>\
                            <div class="col-md-6">\
                                <gl-text v-show="isCompany" :display="\'Number of Employees\'" :form="forms.updateProfile" :name="\'num_employees\'" :input.sync="forms.updateProfile.num_employees" :placeholder="\'Number of employees e.g. 300\'"></gl-text>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <gl-multiselect v-show="isCompany" :display="\'Job Types*\'" :form="forms.updateProfile" :name="\'jobtypes\'" :input.sync="forms.updateProfile.jobtypes" :multiple="true" :items="jtList" :placetext="\'Choose preferred job types...\'"></gl-multiselect>\
\
                            </div>\
                            <div class="col-md-6">\
                                <gl-multiselect v-show="isCompany" :display="\'Industries*\'" :form="forms.updateProfile" :name="\'industries\'" :input.sync="forms.updateProfile.industries" :multiple="true" :items="jpList" :placetext="\'Choose area of work...\'"></gl-multiselect>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <gl-text :display="\'Street\'" :form="forms.updateProfile" :name="\'street\'" :input.sync="forms.updateProfile.street" :minlength="3" :placeholder="\'e.g. 5 mango ln\'"></gl-text>\
                            </div>\
                            <div class="col-md-6">\
                                <gl-location :id="idLoc"\
                                  :display="\'Address (Area, City, Country)\'"\
                                  :form="forms.updateProfile"\
                                  :name="\'location\'"\
                                  :input.sync="location"\
                                  :placeholder="\'e.g. North legon, Accra, Ghana\'">\
                                  </gl-location>\
                                </gl-file>\
                            </div>\
                        </div>\
                        <div class="row">\
                            <div class="col-md-6">\
                                <gl-file :display="\'Logo\'" :form="forms.updateProfile" v-on:updated="setFileName" :name="\'icon_file\'" :warning="\'File must be less than 20MB. Must be an image file\'" :filename.sync="forms.updateProfile.file_name" :input.sync="forms.updateProfile.icon_file">\
                            </div>\
                            <div class="col-md-6">\
                                <gl-text v-show="isCompany" :display="\'Website\'" :form="forms.updateProfile" :name="\'website\'" :input.sync="forms.updateProfile.website" :placeholder="\'http://\'"></gl-text>\
                            </div>\
                        </div>\
                    </form>\
                    <div class="footer">\
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
    
    mounted: function () {
        this.idSum = this.makeid();
        this.idLoc = this.makeid(); 
        this.jtList = this.jobtypes;
        this.jpList = this.industries;
        this.boot();
    },

    data: function () {
        return {
            baseUrl: '/',

			profile: {},
            avatar: 'img/a0.jpg',
            location: '',
            idSum: this.makeid(),
            idLoc: this.makeid(), 

            jtList: [], jpList: [],

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

    watch: {
        'organization': function(v) { this.boot(); },
        'jobtypes': function(v) { this.jtList = v; },
        'industries': function(v) { this.jpList = v; },
    },

    events: {},

    computed: {
        isSchool: function() { return (this.organization.type=='school'||this.organization.type=='gradlead'); },
        isCompany: function() { return (this.organization.type=='employer'); },
    },

    methods: {
        boot: function() {
           this.setProfile(this.organization.profile);
        },

		makeid: function() {
    		var text = "";
    		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

    		for( var i=0; i < 5; i++ )
        		text += possible.charAt(Math.floor(Math.random() * possible.length));
    		return text;
        },
 
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
                    this.forms.updateProfile.jobtypes  = this.profile.job_types;
                    this.forms.updateProfile.industries  = this.profile.industries;
                }
            }
        },

        updateSchoolProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/schools/' + this.profile.id, this.forms.updateProfile)
                .then(function () {
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
                },function(resp) {
                    self.forms.updateProfile.busy = false;
                });
        },

        updateCompanyProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/employees/' + this.profile.id, this.forms.updateProfile)
                .then(function () {
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
