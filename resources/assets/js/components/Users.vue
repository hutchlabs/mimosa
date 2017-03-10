Vue.component('gradlead-users-screen', {

    props: ['authUser', 'usertype', 'permissions'],

    mounted: function () {
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Users',

            roles: [],
            users: [],
            organizations: [],

            editingUser: {
                'name': 'none'
            },
            removingUserId: null,

            roleOptions: [],
            orgsOptions: [],
            allTypeOptions: [
                {
                    'text': 'Gradlead Employee',
                    'value': 'gradlead'
                },
                {
                    'text': 'Employer',
                    'value': 'employer'
                },
                {
                    'text': 'School Employee',
                    'value': 'school'
                },
                {
                    'text': 'Current Student',
                    'value': 'student'
                },
                {
                    'text': 'Graduate',
                    'value': 'graduate'
                },
                         ],
            schoolTypeOptions: [
                {
                    'text': 'School Employee',
                    'value': 'school'
                },
                {
                    'text': 'Current Student',
                    'value': 'student'
                },
                {
                    'text': 'Graduate',
                    'value': 'graduate'
                },
                         ],
            employerTypeOptions: [
                {
                    'text': 'Employer',
                    'value': 'employer'
                },
                         ],

            forms: {
                addUser: new SparkForm({
                    first: '',
                    last: '',
                    email: '',
                    password: '',
                    type: '',
                    organization_id: '',
                    role_id: '',
                }),

                updateUser: new SparkForm({
                    first: '',
                    last: '',
                    email: '',
                    password: '',
                    current_password: '',
                    type: '',
                    role_id: '',
                    organization_id: '',
                }),
            }
        };
    },

    events: {
    },

    computed: {
        everythingLoaded: function () {
            return this.roles.length > 0 && this.organizations.length > 0 && this.users.length > 0;
        }
    },

    methods: {
        addUser: function () {
            this.forms.addUser.first = '';
            this.forms.addUser.last = '';
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
            this.forms.updateUser.first = user.first;
            this.forms.updateUser.last = user.last;
            this.forms.updateUser.email = user.email;
            this.forms.updateUser.password = '';
            this.forms.updateUser.current_password = user.password;
            this.forms.updateUser.type = user.type;
            this.forms.updateUser.role_id = user.role_id;
            this.forms.updateUser.organization_id = user.organization_id;
            this.forms.updateUser.errors.forget();
            $('#modal-edit-user').modal('show');
        },

        removingUser: function (id) {
            return (this.removingUserId == id);
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        getTypeOptions: function () {
            if (this.usertype.isGradlead) { return this.allTypeOptions; }
            if (this.usertype.isSchool) { return this.schoolTypeOptions; }
            if (this.usertype.isCompany) { return this.employerTypeOptions; }
            return this.allTypeOptions;
        },

        filteredUsers: function () {
            var l = this.users;
            if (this.users.length > 0) {
                if (this.authUser.role_id != 1) {
                    l = [];
                    for (var i = 0; i < this.users.length; i++) {
                        if (this.users[i].role_id != 1) {
                            l.push(this.users[i]);
                        }
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
            Spark.post(self.baseUrl + 'users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-user').modal('hide');
                    bus.$emit('updateUsers');
                }, function (resp) {
                    self.forms.addUser.busy = false;
                    //NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000, });
                });
        },
        updateUser: function () {
            var self = this;
            Spark.put(self.baseUrl + 'users/' + this.editingUser.id, this.forms.updateUser)
                .then(function () {
                    bus.$emit('updateUsers');
                    $('#modal-edit-user').modal('hide');
                });
        },
        removeUser: function (user) {
            var self = this;
            self.removingUserId = user.id;

            this.$http.delete(self.baseUrl + 'users/' + user.id)
                .then(function () {
                    self.removingUserId = 0;
                    self.users = self.removeFromList(this.users, user);
                    bus.$emit('updateUsers');

                }, function (resp) {
                    self.removingUserId = 0;
                    //NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000, });
                });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('usersSet', function (users) {
                self.users = users;
            });

            bus.$on('rolesSet', function (roles) {
                self.roles = roles
                self.roleOptions = [];
                for (var i = 0; i < self.roles.length; ++i) {
                    if (self.roles[i].id != 1) {
                        self.roleOptions.push({
                            'text': self.roles[i].name,
                            'value': self.roles[i].id
                        });
                    }
                }
            });

            bus.$on('organizationsSet', function (orgs) {
                self.organizations = [];

                if (self.usertype.isGradlead) {
                    self.organizations = orgs[0];
                } else {
                    var orgs = orgs[0];
                        for (var i = 0; i < orgs.length; i++) {
                            if (orgs[i].id == self.authUser.organization_id) {
                                self.organizations.push(orgs[i]);
                            }
                        }

                }

                self.orgsOptions = [];
                for (var i = 0; i < self.organizations.length; ++i) {
                    self.orgsOptions.push({
                        'text': self.organizations[i].name,
                        'value': self.organizations[i].id
                    });
                }

            });

            bus.$emit('screenLoaded',self.modname);
        },
    },

    filters: {
        role_is_editor: function (value) {
            return (value == 'Member') ? 'No' : 'Yes';
        },
    },
});
