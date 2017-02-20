Vue.component('gradlead-permissions-screen', {

    mounted: function() {
        this.setupListeners();
    },

    data: function() {
        return {
            baseUrl: '/mimosa/',
            modname: 'Permissions',
            
            organizations: null,

            preselect: [],
            screening: [],
            tracking: [],
            events: [],


            forms: {
                updatePermission: new SparkForm ({
                    organization_id: '',
                    preselect: '',
                    screening: '',
                    tracking: '',
                    events: '',
                    badges: 0,
                }),
            }
        };
    },
   
    events: {
    },

    computed: {
        everythingLoaded: function () {
            return this.organizations != null;
        }
    },

    methods: {
        // Ajax calls
        updatePermission: function (org, type) {
            var self = this;
            this.forms.updatePermission.organization_id = org.id; 

            if (type=='preselect') { this.preselect[org.id] = !this.preselect[org.id]; }
            if (type=='screening') { this.screening[org.id] = !this.screening[org.id]; }
            if (type=='tracking') { this.tracking[org.id] = !this.tracking[org.id]; }
            if (type=='events') { this.events[org.id] = !this.events[org.id]; }

            this.forms.updatePermission.preselect = this.preselect[org.id]; 
            this.forms.updatePermission.screening = this.screening[org.id]; 
            this.forms.updatePermission.tracking =  this.tracking[org.id]; 
            this.forms.updatePermission.events = this.events[org.id]; 

            Spark.put(self.baseUrl+'permissions/' + org.permissions.id,         this.forms.updatePermission).then(function(resp) {
                bus.$emit('updateOrganizations');
            });
        },
        
        setupListeners: function () {
            var self = this;

            bus.$on('organizationsSet', function (orgs) {
                var orgs = orgs[0];
                self.organizations = [];
                for(var i=0; i < orgs.length; i++) {
                    // only schools and employers 
                    if (orgs[i].type!='gradlead') { 
                        self.organizations.push(orgs[i]); 
                        self.preselect[orgs[i].id] = orgs[i].permissions.preselect; 
                        self.screening[orgs[i].id] = orgs[i].permissions.screening; 
                        self.tracking[orgs[i].id] = orgs[i].permissions.tracking; 
                        self.events[orgs[i].id] = orgs[i].permissions.events; 
                    }
                }
            });
            
            bus.$emit('screenLoaded',self.modname);
        },
        
    },

    filters: {
    },
});
