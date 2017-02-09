Vue.component('gradlead-users-screen', {

    mounted: function() {
        this.getAuthUser();
    },

    data: function() {
        return {
            baseUrl: '/mimosa/',

            user: null,
            roles: [],
            users: [],
            organizations: [],

            editingUser: {'name':'none'},
            removingUserId: null,

            roleOptions: [],
            orgsOptions: [],
            allTypeOptions: [
                            {'text': 'Gradlead Employee', 'value':'gradlead'},
                            {'text': 'Employer', 'value':'employer'},
                            {'text': 'School Employee', 'value':'school'},
                            {'text': 'Current Student', 'value':'student'},
                            {'text': 'Graduate', 'value':'graduate'},
                         ],
            schoolTypeOptions: [
                            {'text': 'School Employee', 'value':'school'},
                            {'text': 'Current Student', 'value':'student'},
                            {'text': 'Graduate', 'value':'graduate'},
                         ],
            employerTypeOptions: [
                            {'text': 'Employer', 'value':'employer'},
                         ],

            forms: {
                addUser: new SparkForm ({
                    name: '',
                    email: '',
                    password: '',
                    type:'',
                    organization_id:'',
                    role_id:'',
                }),

                updateUser: new SparkForm ({
                    name: '',
                    email: '',
                    password: '',
                    current_password: '',
                    type: '',
                    role_id:'',
                    organization_id: '',
                }),
            }
        };
    },
    
    events: {
        'usersUpdated': function(newusers) {
            this.getUsers();
        }
    },

    computed: {
        everythingLoaded: function () {
            return this.user != null;
        }
    },

    methods: {
        addUser: function () {
            this.forms.addUser.name = '';
            this.forms.addUser.email = '';
            this.forms.addUser.password = '';
            this.forms.addUser.role_id = '';
            this.forms.addUser.organization_id = '';
            this.forms.addUser.type = '';
            this.forms.addUser.errors.forget();
            $('#modal-add-user').modal('show');
        },
        editUser: function (user) {
            this.editingUser = user;
            this.forms.updateUser.name = user.name;
            this.forms.updateUser.email = user.email;
            this.forms.updateUser.password = '';
            this.forms.updateUser.current_password = user.password;
            this.forms.updateUser.type = user.type;
            this.forms.updateUser.role_id = user.role_id;
            this.forms.updateUser.organization_id = user.organization_id;
            this.forms.updateUser.errors.forget();
            $('#modal-edit-user').modal('show');
        },

        removingUser: function(id) { return (this.removingUserId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        getTypeOptions: function() {
            if (this.user.organization.type=='gradlead') { return this.allTypeOptions; }
            if (this.user.organization.type=='school') { return this.schoolTypeOptions; }
            if (this.user.organization.type=='employer') { return this.employerTypeOptions; }
            return this.allTypeOptions;
        },

        filteredUsers: function() {
            var l = this.users;
            if (this.users.length > 0) {
                if (this.user.role_id != 1) {
                    l = [];
                    for (var i=0; i<this.users.length; i++) {
                        if (this.users[i].role_id != 1) { l.push(this.users[i]); }    
                    }
                }
                return l;
            } else {
                return [];
            }
        },

        // Ajax calls
        addNewUser: function () {
            var self = this;
            Spark.post(self.baseUrl+'users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-user').modal('hide');
                    self.getUsers();
                }, function(resp) {
                    self.forms.addUser.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updateUser: function () {
            var self = this;
            Spark.put(self.baseUrl+'users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    self.getUsers();
                    $('#modal-edit-user').modal('hide');
                });
        },
        removeUser: function (user) {
            var self = this;
            self.removingUserId = user.id;

            this.$http.delete(self.baseUrl+'users/' + user.id)
                .then(function () {
                    self.removingUserId = 0;
                    self.users = self.removeFromList(this.users, user);
                }, function(resp) {
                    self.removingUserId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },

        getUsers: function () {
            var self = this;
            this.$http.get(self.baseUrl+'users')
                .then(function (resp) {
                    self.users = resp.data.data;
                });
        },
        
        getRoles: function () {
            var self = this;
            this.$http.get(self.baseUrl+'roles')
                .then(function (resp) {
                    self.roles = resp.data;
                    self.roleOptions =[];
                    for(var i=0; i < self.roles.length; ++i) {
                        if (self.roles[i].id != 1) {
                            self.roleOptions.push({'text': self.roles[i].name, 'value':self.roles[i].id});
                        }
                    }
                });
        },
        
        getOrganizations: function () {
            var self = this;
            this.$http.get(self.baseUrl+'organizations')
                .then(function (resp) {
                    self.organizations = [];
                    
                    if (self.user.organization_id==1) {
                        self.organizations = resp.data.data;
                    } else {
                        for(var i=0; i<resp.data.data.length; i++) {
                            if (resp.data.data[i].id==self.user.organization_id) {
                                self.organizations.push(resp.data.data[i]);
                            }
                        }
                    }

                    self.orgsOptions = [];
                    for(var i=0; i < self.organizations.length; ++i) {
                        self.orgsOptions.push({'text': self.organizations[i].name, 'value': self.organizations[i].id});
                    }
                });
        },
        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) {
                    self.user = user.data; 
                    self.getUsers();
                    self.getRoles();
                    self.getOrganizations();
                });
        },
    },

    filters: {
        role_is_editor: function (value) {
            return (value=='Member') ? 'No' : 'Yes';
        },
    },
});
