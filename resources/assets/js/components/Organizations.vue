Vue.component('gradlead-orgs-screen', {

    mounted: function() {
        this.getOrganizations();
    },

    data: function() {
        return {
            organizations: [],

            editingOrganization: {'name':'none'},
            removingOrganizationId: null,

            typeOptions: [
                            {'text': 'Gradlead', 'value':'gradlead'},
                            {'text': 'Employer', 'value':'employer'},
                            {'text': 'School', 'value':'school'},
                         ],

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
        'usersUpdated': function(newusers) {
            this.getOrganizations();
         }
    },

    computed: {
    },

    methods: {
        addOrganization: function () {
            this.forms.addOrganization.name = '';
            this.forms.addOrganization.type = '';
            this.forms.addOrganization.subdomain = '';
            $('#modal-add-org').modal('show');
        },
        editOrganization: function (org) {
            this.editingOrganization = org;
            this.forms.updateOrganization.name = org.name;
            this.forms.updateOrganization.type = org.type;
            this.forms.updateOrganization.subdomain = org.subdomain;
            $('#modal-edit-org').modal('show');
        },

        removingOrganization: function(id) { return (this.removingOrganizationId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        addNewOrganization: function () {
            var self = this;
            Spark.post('/mimosa/api/organizations', this.forms.addOrganization)
                .then(function () {
                    $('#modal-add-org').modal('hide');
                    self.getOrganizations();
                }, function(resp) {
                    self.forms.addOrganization.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updateOrganization: function () {
            var self = this;
            Spark.put('/mimosa/api/organizations/' + this.editingOrganization.id, this.forms.updateOrganization)
                .then(function () {
                    self.getOrganizations();
                    $('#modal-edit-org').modal('hide');
                });
        },
        removeOrganization: function (org) {
            var self = this;
            self.removingOrganizationId = org.id;

            this.$http.delete('/mimosa/api/organizations/' + org.id)
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
            this.$http.get('/mimosa/api/organizations')
                .then(function (resp) {
                    self.organizations = resp.data;
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
