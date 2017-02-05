Vue.component('gradlead-orgs-screen', {

    mounted: function() {
        this.getOrganizations();
    },

    data: function() {
        return {
            baseUrl: '/mimosa/api/',

            organizations: [],
            employers: [],
            schools: [],

            editingOrganization: {'name':'none'},
            removingOrganizationId: null,

            forms: {
                addOrganization: new SparkForm ({
                    name: '',
                    type: '',
                    subdomain: '',
                }),

                updateOrganization: new SparkForm ({
                    name: '',
                    type: '',
                    subdomain: '',
                }),
            }
        };
    },
    
    events: {
    },

    computed: {
        everythingLoaded: function() {
            return this.organizations.length > 0;
        }
    },

    methods: {
        addOrganization: function (type) {
            this.forms.addOrganization.name = '';
            this.forms.addOrganization.type = type;
            this.forms.addOrganization.subdomain = (type=='school')?'':'localhost';
            this.forms.addOrganization.errors.forget();
            $('#modal-add-'+type+'-org').modal('show');
        },
        editOrganization: function (org) {
            this.editingOrganization = org;
            this.forms.updateOrganization.name = org.name;
            this.forms.updateOrganization.type = org.type;
            this.forms.updateOrganization.subdomain = org.subdomain;
            this.forms.updateOrganization.errors.forget();
            $('#modal-edit-'+org.type+'-org').modal('show');
        },

        removingOrganization: function(id) { return (this.removingOrganizationId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        addNewOrganization: function (type) {
            var self = this;
            Spark.post(self.baseUrl+'organizations', this.forms.addOrganization)
                .then(function () {
                    $('#modal-add-'+type+'-org').modal('hide');
                    self.getOrganizations();
                }, function(resp) {
                    self.forms.addOrganization.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updateOrganization: function (type) {
            var self = this;
            Spark.put(self.baseUrl+'organizations/' + this.editingOrganization.id, this.forms.updateOrganization)
                .then(function () {
                    self.getOrganizations();
                    $('#modal-edit-'+type+'-org').modal('hide');
                });
        },
        removeOrganization: function (org) {
            var self = this;
            self.removingOrganizationId = org.id;

            this.$http.delete(self.baseUrl+'organizations/' + org.id)
                .then(function () {
                    self.removingOrganizationId = 0;
                    self.organizations = self.removeFromList(this.organizations, org);
                }, function(resp) {
                    self.removingOrganizationId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
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
                });
        },
    },

    filters: {
        affiliations: function (org) {
            return (org.type=='gradlead' || org.type=='school') ? org.numrecruiters : org.numschools;
        },
        capitalize: function(value) {
            return value[0].toUpperCase() + value.substring(1);
        },
    },
});