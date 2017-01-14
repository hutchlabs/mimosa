Vue.component('gradlead-users-screen', {

    mounted: function() {
        this.getUsers();
        this.getRoles();
        this.getOrganizations();
    },

    data: function() {
        return {
            roles: [],
            users: [],
            organizations: [],

            editingUser: {'name':'none'},
            removingUserId: null,

            roleOptions: [],
            orgsOptions: [],
            typeOptions: [
                            {'text': 'Gradlead Employee', 'value':'gradlead'},
                            {'text': 'Employer', 'value':'employer'},
                            {'text': 'School Employee', 'value':'school'},
                            {'text': 'Current Student', 'value':'student'},
                            {'text': 'Graduate', 'value':'graduate'},
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
    },

    methods: {
        addUser: function () {
            this.forms.addUser.name = '';
            this.forms.addUser.email = '';
            this.forms.addUser.password = '';
            this.forms.addUser.role_id = '';
            this.forms.addUser.organization_id = '';
            this.forms.addUser.type = '';
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
            $('#modal-edit-user').modal('show');
        },

        removingUser: function(id) { return (this.removingUserId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        addNewUser: function () {
            var self = this;
            Spark.post('/mimosa/api/users', this.forms.addUser)
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
            Spark.put('/mimosa/api/users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    self.getUsers();
                    $('#modal-edit-user').modal('hide');
                });
        },
        removeUser: function (user) {
            var self = this;
            self.removingUserId = user.id;

            this.$http.delete('/mimosa/api/users/' + user.id)
                .then(function () {
                    self.removingUserId = 0;
                    self.users = self.removeFromList(this.users, user);
                }, function(resp) {
                    self.removingUserId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },

        getUsers: function () {
            this.$http.get('/mimosa/api/users')
                .then(function (resp) {
                    this.users = resp.data;
                });
        },
        
        getRoles: function () {
            this.$http.get('/mimosa/api/roles')
                .then(function (resp) {
                    this.roles = resp.data;
                    this.roleOptions =[];
                    for(var i=0; i < this.roles.length; ++i) {
                        this.roleOptions.push({'text': this.roles[i].name, 'value':this.roles[i].id});
                    }
                });
        },
        
        getOrganizations: function () {
            var self = this;
            this.$http.get('/mimosa/api/organizations')
                .then(function (resp) {
                    self.organizations = resp.data;
                    self.orgsOptions = [];
                    for(var i=0; i < self.organizations.length; ++i) {
                        self.orgsOptions.push({'text': self.organizations[i].name, 'value': self.organizations[i].id});
                    }
                });
        },
    },

    filters: {
        role_is_editor: function (value) {
            return (value=='member') ? 'No' : 'Yes';
        },
    },
});
