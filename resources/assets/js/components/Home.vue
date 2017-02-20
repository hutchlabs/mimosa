Vue.component('gradlead-home-screen', {

    mounted: function() {
        this.setupListeners();
        this.getAuthUser();
        bus.$emit('screenLoaded', 'Home');
    },

    data: function() {
        return {
            baseUrl: '/mimosa/',
            modname: 'Home',
            
            authUser: null,
            usertype: {'isGradlead': false, 'isCompany':false, 'isSchool':false, 'isAdmin':false, 'canEdit': false},
            permissions: {'canDoEvents': false, 'canDoScreening':false, 'canDoPreselect': false, 'canDoTracking':false},
            
            loadedScreens: 0,
            expectedScreens: 12,
        };
    },
    
    events: {},

    computed: {
        userLoaded: function() { return (this.authUser==null) ? false : true; },
    },

    methods: {      
        doLogout: function () {
            var self = this;
            this.$http.get(self.baseUrl+'flogout')
                .then(function (resp) {
					self.authUser = {};
                    window.location.href= self.baseUrl;
                });
        },
        
        getAuthUser: function () {
            var self = this;

            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) {
                    self.authUser = user.data; 
                    self.usertype.canEdit = (self.authUser.role.name=='Member') ? false : true;
                    self.usertype.isAdmin = (self.authUser.role.name=='Super Administrator' || self.authUser.role.name=='Administrator');
                    self.usertype.isGradlead = (self.authUser.organization.id==1) ? true : false;
                    self.usertype.isCompany = (self.authUser.organization.type=='employer') ? true : false;
                    self.usertype.isSchool = (self.authUser.organization.type=='school') ? true : false;
                    self.permissions.canDoEvents = self.authUser.organization.permissions.events;
                    self.permissions.canDoScreening = self.authUser.organization.permissions.screening;
                    self.permissions.canDoPreselect = self.authUser.organization.permissions.preselect;
                    self.permissions.canDoTracking = self.authUser.organization.permissions.tracking;
                    self.expectedScreens = (self.usertype.isGradlead) ? 12 : ((self.usertype.isCompany) ? 12 : 7); 
                });
        },
    
        callOthers: function() {
            this.getUsers();
            this.getRoles();
            this.getOrganizations();

            this.getJobs();
            this.getPlans();
            this.getContracts();

            this.getQuestionnaires([null,null]);
            this.getJobTypes();
            this.getLanguages();
            this.getDegrees();
            this.getMajors();
            this.getIndustries();
            this.getSkills();

            this.getBadges();
        },
        
        getOrganizations: function () {
            var self = this;
            this.$http.get(self.baseUrl+'organizations')
                .then(function (resp) {
                   var schools = [];
                   var employers=[];
                   var organizations = resp.data.data;
                   for(var i=0; i < organizations.length; i++) {
                        if (organizations[i].type=='school') { schools.push(organizations[i]); }
                        if (organizations[i].type=='employer') { employers.push(organizations[i]); }
                   }
                   bus.$emit('organizationsSet', [organizations, employers, schools]);
                });
        },
        
        getPlans: function () {
            this.$http.get(this.baseUrl + 'plans')
                .then(function(resp) { bus.$emit('plansSet', resp.data.data); });
        },
        
        getContracts: function () {
            this.$http.get(this.baseUrl + 'contracts')
                .then(function (resp) { bus.$emit('contractsSet', resp.data.data); });
        },
        
        getJobs: function () {
            this.$http.get(this.baseUrl+'jobs')
                .then(function (resp) { bus.$emit('jobsSet', resp.data.data); });
		},
             
        getJobTypes: function () {
            this.$http.get(this.baseUrl+'jobtypes').then(function (resp) { bus.$emit('jobTypesSet', resp.data.data); });
		},
        
        getQuestionnaires: function (info) {
            this.$http.get(this.baseUrl+'questionnaires').then(function (resp) {
                    bus.$emit('questionnairesSet', [resp.data.data, info[0], info[1]]); });
		},
        
        getMajors: function () {
            this.$http.get(this.baseUrl+'majors').then(function (resp) { bus.$emit('majorsSet', resp.data.data); });
		},
        
        getDegrees: function () {
            this.$http.get(this.baseUrl+'degrees').then(function (resp) { bus.$emit('degreesSet', resp.data.data); });
		},
        
        getIndustries: function () {
            this.$http.get(this.baseUrl+'industries').then(function (resp) { bus.$emit('industriesSet', resp.data.data); });
		},
        
        getLanguages: function () {
            this.$http.get(this.baseUrl+'languages').then(function (resp) { bus.$emit('languagesSet', resp.data.data); });
		},
       
        getSkills: function () {
            this.$http.get(this.baseUrl+'skills').then(function (resp) { bus.$emit('skillsSet', resp.data.data); });
		},
                   
        getBadges: function () {
            this.$http.get(this.baseUrl + 'badges')
                .then(function (resp) { bus.$emit('badgesSet', resp.data.data); });
        },
        
        getEvents: function () {
            this.$http.get(this.baseUrl+'events')
                .then(function (resp) { bus.$emit('eventsSet', resp.data.data); });
		},
        
        getUsers: function () {
            this.$http.get(this.baseUrl+'users')
                .then(function (resp) { bus.$emit('usersSet', resp.data.data); });
        },
        
        getRoles: function () {
            this.$http.get(this.baseUrl+'roles') .then(function (resp) { bus.$emit('rolesSet', resp.data);     });
        },
        
        setupListeners: function () {
            var self = this;
            
            bus.$on('updateOrganizations', function () { self.getOrganizations(); });
            bus.$on('updatePlans', function () { self.getPlans(); });
            bus.$on('updateContracts', function () { self.getContracts(); });
            bus.$on('updateJobs', function () { self.getJobs(); });
            bus.$on('updateJobTypes', function () { self.getJobTypes(); });
            bus.$on('updateQuestionnaires', function (info) { self.getQuestionnaires(info); });
            bus.$on('updateMajors', function () { self.getMajors(); });
            bus.$on('updateDegrees', function () { self.getDegrees(); });
            bus.$on('updateIndustries', function () { self.getIndustries(); });
            bus.$on('updateLanguages', function () { self.getLanguages(); });
            bus.$on('updateSkills', function () { self.getSkills(); });
            bus.$on('updateBadges', function () { self.getBadges(); });
            bus.$on('updateEvents', function () { self.getEvents(); });
            bus.$on('updateUsers', function () { self.getUsers(); });
            bus.$on('updateRoles', function () { self.getRoles(); });
            
            bus.$on('screenLoaded', function(name) {
                self.loadedScreens += 1;
                console.log("Loaded screens: #"+self.loadedScreens +": "+name);
                if (self.loadedScreens==self.expectedScreens) { self.callOthers(); }
            });
        },
  
    },

    filters: { },
});
