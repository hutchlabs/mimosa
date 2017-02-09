Vue.component('gradlead-permissions-screen', {

    mounted: function() {
        this.getOrganizations();
   
    },

    data: function() {
        return {
            organizations: null,
            preselect: [],
            screening: [],
            tracking: [],
            events: [],

            baseUrl: '/mimosa/',

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
                self.getOrganizations();  
            });
        },
        
        getOrganizations: function () {
            var self = this;
            this.$http.get(self.baseUrl + 'organizations').then(function (resp) {
                    self.organizations = [];
                    for(var i=0; i < resp.data.data.length; i++) {
                        // only schools and employers 
                        if (resp.data.data[i].type!='gradlead') { 
                            self.organizations.push(resp.data.data[i]); 
                            self.preselect[resp.data.data[i].id] = resp.data.data[i].permissions.preselect; 
                            self.screening[resp.data.data[i].id] = resp.data.data[i].permissions.screening; 
                            self.tracking[resp.data.data[i].id] = resp.data.data[i].permissions.tracking; 
                            self.events[resp.data.data[i].id] = resp.data.data[i].permissions.events; 
                        }
                    }
            });
        },
    },

    filters: {
    },
});
