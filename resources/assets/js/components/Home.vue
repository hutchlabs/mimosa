Vue.component('gradlead-home-screen', {

	components: {
    	BounceLoader,
	},

    mounted: function() {
        this.setupListeners();
        this.getAuthUser();
        this.setPaths();
        bus.$emit('screenLoaded', 'Home');
    },

    data: function() {
        return {
            baseUrl: '/',
            modname: 'Home',

            authUser: null,
            avatar: 'img/a0.jpg',
            logo: 'img/a0.jpg',
            hpath: '',
            hsearch: {},

            usertype: {'isGradlead': false, 'isCompany':false, 'isSchool':false, 'isAdmin':false, 'canEdit': false},
            permissions: {'canDoEvents': false, 'canDoScreening':false, 'canDoPreselect': false, 'canDoTracking':false},

            loadedScreens: 0,
            expectedScreens: 19,
            expectedCalls: 16,
            completedCalls: 0,
        };
    },

    events: { },

    computed: {
        everythingLoaded: function() {
            return ((this.authUser!=null) && (this.completedCalls>=this.expectedCalls));
        },

        userLoaded: function() { return (this.authUser==null) ? false : true; },
    },

    methods: {
        listClass: function(name) {
            if (this.hpath=='' && name=='#jobs') { return 'active'; }
            return (name==this.hpath) ? 'active' : '';
        },
        tabClass: function(name) {
            if (this.hpath=='' && name=='#jobs') { return 'tab-pane active'; }
            var x= (name==this.hpath) ? 'tab-pane active' : 'tab-pane';
            //console.log('Path: '+this.hpath+' Name: '+name+' Class: '+x);
            return x;
        },

        setPaths: function() {
            this.hpath  = window.location.hash;
            var query  = window.location.search.substr(1);
			
			var result = {};
  			query.split("&").forEach(function(part) {
    			if(!part) return;
    			part = part.split("+").join(" "); 
    			var eq = part.indexOf("=");
    			var key = eq>-1 ? part.substr(0,eq) : part;
    			var val = eq>-1 ? decodeURIComponent(part.substr(eq+1)) : "";
    			var from = key.indexOf("[");
    			if(from==-1) {
					result[decodeURIComponent(key)] = val;
    			} else {
      				var to = key.indexOf("]");
      				var index = decodeURIComponent(key.substring(from+1,to));
      				key = decodeURIComponent(key.substring(0,from));
      				if(!result[key]) result[key] = [];
      				if(!index) result[key].push(val);
      				else result[key][index] = val;
    			}
  			});
  			this.hsearch = result;
            //console.log('hash '+this.hpath);
            //console.log(this.hsearch);
        },

        icCounter: function() {
            this.completedCalls++;
            bus.$emit('allLoaded');
        },

        doLogout: function () {
            var self = this;
            this.$http.get(self.baseUrl+'flogout')
                .then(function (resp) {
					self.authUser = {};
                    window.location.href= self.baseUrl;
                });
        },

		getImageUrl: function() {
            if (this.authUser.profile != null) {
                return '/profiles/avatar/'+this.authUser.profile.id+'?'+new Date();
            }
        },
        
        getLogoUrl: function() {
            if (this.authUser.organization.profile != null) {
                var p = (this.usertype.isSchool) ? 'crest' : 'logo';
                return '/profiles/'+p+'/'+this.authUser.organization.profile.id+'?'+new Date();
            }
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
                    self.expectedScreens = (self.usertype.isGradlead) ? 19 : ((self.usertype.isCompany) ? 6 : 3);
                    self.logo = self.getLogoUrl();
                    self.avatar = self.getImageUrl();
                    bus.$emit('authUserSet', self.authUser);
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
            this.getUniversities();
            this.getCountries();

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
                   self.icCounter();
                   bus.$emit('organizationsSet', [organizations, employers, schools]);
                });
        },

        getPlans: function () {
            var self = this;
            this.$http.get(this.baseUrl + 'plans')
                .then(function(resp) { self.icCounter(); bus.$emit('plansSet', resp.data.data); });
        },

        getContracts: function () {
            var self = this;
            this.$http.get(this.baseUrl + 'contracts')
                .then(function (resp) { self.icCounter(); bus.$emit('contractsSet', resp.data.data); });
        },

        getJobs: function () {
            var self = this;
            this.$http.get(this.baseUrl+'jobs')
                .then(function (resp) { self.icCounter(); bus.$emit('jobsSet', resp.data.data); });
		},

        getJobTypes: function () {
            var self = this;
            this.$http.get(this.baseUrl+'jobtypes').then(function (resp) {
                self.icCounter();
                bus.$emit('jobTypesSet', resp.data.data); });
		},

        getQuestionnaires: function (info) {
            var self = this;
            this.$http.get(this.baseUrl+'questionnaires').then(function (resp) {
                self.icCounter();
                bus.$emit('questionnairesSet', [resp.data.data, info[0], info[1]]); });
		},

        getMajors: function () {
            var self = this;
            this.$http.get(this.baseUrl+'majors').then(function (resp) {
                var items = resp.data.data;
                items.sort(function(a,b) {
                    var x = a.name; var y = b.name;
                    return (x < y) ? -1 : ((x > y) ? 1 : 0);
                });
                $.each(items, function(i,x){ items[i].name = self.ucwords(x.name)});
                self.icCounter();
                bus.$emit('majorsSet', items);
            });
		},

        getCountries: function () {
            var self = this;
            this.$http.get(this.baseUrl+'countries').then(function (resp) {
                var items = resp.data.data;
                items.sort(function(a,b) {
                    var x = a.name; var y = b.name;
                    return (x < y) ? -1 : ((x > y) ? 1 : 0);
                });
                self.icCounter();
                bus.$emit('countriesSet', items);
            });
        },

        getUniversities: function () {
            var self = this;
            this.$http.get(this.baseUrl+'universities').then(function(resp) {
                self.icCounter();
                bus.$emit('universitiesSet',resp.data.data);});
		},

        getDegrees: function () {
            var self = this;
            this.$http.get(this.baseUrl+'degrees').then(function (resp) {
                self.icCounter();
                bus.$emit('degreesSet', resp.data.data); });
		},

        getIndustries: function () {
            var self = this;
            this.$http.get(this.baseUrl+'industries').then(function (resp) {
                self.icCounter();
                bus.$emit('industriesSet', resp.data.data); });
		},

        getLanguages: function () {
            var self = this;
            this.$http.get(this.baseUrl+'languages').then(function (resp) {
                self.icCounter();
                bus.$emit('languagesSet', resp.data.data); });
		},

        getSkills: function () {
            var self = this;
            this.$http.get(this.baseUrl+'skills').then(function (resp) {
            self.icCounter();
            bus.$emit('skillsSet', resp.data.data); });
		},

        getBadges: function () {
            var self = this;
            this.$http.get(this.baseUrl + 'badges')
                .then(function (resp) {
                    self.icCounter();
                    bus.$emit('badgesSet', resp.data.data); });
        },

        getEvents: function () {
            var self = this;
            this.$http.get(this.baseUrl+'events')
                .then(function (resp) {
                    self.icCounter();
                    bus.$emit('eventsSet', resp.data.data); });
		},

        getUsers: function () {
            var self = this;
            this.$http.get(this.baseUrl+'users')
                .then(function (resp) {
                    self.icCounter();
                    bus.$emit('usersSet', resp.data.data); });
        },

        getRoles: function () {
            var self = this;
            this.$http.get(this.baseUrl+'roles') .then(function (resp) {
                self.icCounter();
                bus.$emit('rolesSet', resp.data);     });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('updateAuthUser', function () { self.getAuthUser(); });
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
            bus.$on('updateUniversities', function () { self.getUniversities(); });
            bus.$on('updateCountries', function () { self.getCountries(); });

            bus.$on('screenLoaded', function(name) {
                self.loadedScreens += 1;
                //console.log("Loaded screens: #"+self.loadedScreens +": "+name);
                if (self.loadedScreens==self.expectedScreens) { self.callOthers(); }
            });
        },

        ucwords: function (str) {
            return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });
        },
    },

    filters: { },
});
