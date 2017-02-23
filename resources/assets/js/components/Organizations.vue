Vue.component('gradlead-orgs-screen', {
    
    props: ['authUser', 'usertype', 'permissions'],

    // TODO: handle approval

    mounted: function() {
        this.setupListeners();
    },
    
    data: function() {
        return {
            baseUrl: '/',
            modname: 'Organizations',
            
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
            this.forms.addOrganization.subdomain = (type!='gradlead')?'':'localhost';
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
                    bus.$emit('updateOrganizations');
                }, function(resp) {
                    self.forms.addOrganization.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updateOrganization: function (type) {
            var self = this;
            Spark.put(self.baseUrl+'organizations/' + this.editingOrganization.id, this.forms.updateOrganization)
                .then(function () {
                    bus.$emit('updateOrganizations');
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
                    bus.$emit('updateOrganizations');
                }, function(resp) {
                    self.removingOrganizationId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },

        isInArray: function (item, array) {
            return !!~$.inArray(item, array);
        },

        
        setupListeners: function () {
            var self = this;
            bus.$on('organizationsSet', function (orgs) {
                self.organizations = orgs[0];
                //self.employers = orgs[1];
                self.schools = orgs[2];

                self.employers = [];
                $.each(orgs[1], function (idx, emp) {
                       if (self.authUser.organization.id==1) { self.employers.push(emp) }
                       else if (self.isInArray(self.authUser.organization_id, emp.schools)) { 
                           self.employers.push(emp); 
                       }
                });
            });
            bus.$emit('screenLoaded',self.modname);
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
