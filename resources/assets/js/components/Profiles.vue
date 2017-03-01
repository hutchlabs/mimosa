Vue.component('gradlead-profiles-org-screen', {

    props: ['authUser', 'usertype', 'permissions'],

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

 			forms: {
                updateProfile: new SparkForm({
                    id: '',
                    organization_id: '',
                    summary: '',
                    description: '',
                    country: '',
                    city: '',
                    address: '',
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

        setProfile: function(p) {
            this.profile = p;
            if (this.profile != null) {
                this.avatar = this.getImageUrl();
                this.forms.updateProfile.id = this.profile.id;
                this.forms.updateProfile.organization_id = this.profile.organization_id;
                this.forms.updateProfile.summary = this.profile.summary;
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
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
                });
        },

        updateCompanyProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/employees/' + this.profile.id, this.forms.updateProfile)
                .then(function () {
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
                });
        },
    },

    filters: { },
});

Vue.component('gradlead-profiles-user-screen', {

    props: ['authUser', 'usertype', 'permissions'],

    mounted: function () {
        this.setProfile(this.authUser.profile);
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'User Profile',

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
                    uuid: '',
                    icon_file: '',
                    file_name: '',
                }),
            },
        };
    },

    watch: {
    },

    events: {
        'showNotification': function(notification) {
            console.log("Sending up");
            bus.$emit('showNotification',notification);
        },
    },

    computed: {
        everythingLoaded: function () { return this.authUser != null },
        isStudent: function() { return (this.authUser.type=='student' ||
                                        this.authUser.type=='graduate'); },
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
            return [e.neighborhood, e.city, e.country].join(', ');
        },
        
        setProfile: function(p) {
            this.profile = p;
            if (this.profile != null) {
                this.location = this.getLocation(this.profile);
                this.avatar = this.getImageUrl();
                this.forms.updateProfile.id = this.profile.id;
                this.forms.updateProfile.user_id = this.profile.user_id;
                this.forms.updateProfile.uuid = this.profile.uuid;
                this.forms.updateProfile.summary = this.profile.summary;
                this.forms.updateProfile.country = this.profile.country;
                this.forms.updateProfile.city = this.profile.city;
                this.forms.updateProfile.neighborhood  = this.profile.neighborhood;
            }
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSet', function (user) { self.setProfile(user.profile); });
            bus.$emit('screenLoaded',self.modname);
        },

        updateUserProfile: function() {
            var self = this;
            Spark.put(self.baseUrl+'profiles/users/' + this.profile.id, this.forms.updateProfile)
                .then(function () { bus.$emit('updateAuthUser'); });
        },
    },

    filters: { },
});
