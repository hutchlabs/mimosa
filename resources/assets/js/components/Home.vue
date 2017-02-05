Vue.component('gradlead-home-screen', {

    mounted: function() {
        this.getAuthUser();
        this.getOrganizations();

    },

    data: function() {
        return {
            baseUrl: '/mimosa/api/',

            user: null,
            canEdit: false,
            isAdmin: false,
            canDoEvents: false,
            canDoScreening: false,
            canDoPreselect: false,
            canDoTracking: false,
            
            organizations: [],
            employers: [],
            schools: [],
        };
    },
    
    events: {
    },


    computed: {
        everythingLoaded: function() {
            return this.user != null;
        },
    },

    methods: {
        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) {
                    self.user = user.data; 
                    self.canEdit = (self.user.role.name=='Member') ? false : true;
                    self.isAdmin = (self.user.role.name=='Super Administrator' || self.user.role.name=='Administrator');
                    self.canDoEvents = self.user.organization.permissions.events;
                    self.canDoScreening = self.user.organization.permissions.screening;
                    self.canDoPreselect = self.user.organization.permissions.preselect;
                    self.canDoTracking = self.user.organization.permissions.tracking;

                    bus.$emit('authUserSet', self.user);
                });
        },
        getOrganizations: function () {
            var self = this;
            this.$http.get(self.baseUrl+'organizations')
                .then(function (resp) {
                   self.schools = [];
                   self.employers=[];
                   self.organizations = resp.data.data;
                   for(var i=0; i < self.organizations.length; i++) {
                        if (self.organizations[i].type=='school') { self.schools.push(self.organizations[i]); }
                        if (self.organizations[i].type=='employer') { self.employers.push(self.organizations[i]); }
                   }
                   bus.$emit('organizationsSet', [self.organizations,self.employers, self.schools]);
                });
        },
        doLogout: function () {
            var self = this;
            this.$http.get(self.baseUrl+'flogout')
                .then(function (resp) {
					self.user = {};
                    window.location.href= self.baseUrl;
                });
        },
    },

    filters: {
    },
});
