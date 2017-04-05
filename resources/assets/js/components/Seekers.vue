Vue.component('gradlead-seekers-screen', {

    props: ['authUser', 'usertype', 'permissions'],

    mounted: function() {
        this.profilingUser = this.authUser;
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Seekers',

            roles: [],
            users: [],
            organizations: [],
            jtList: [],
            jpList: [],

            editingUser: { 'name': 'none' },
            badgesUser: { 'name': 'none' },
            profilingUser: { 'name': 'none', 'id':0, profile:{'id':0}},
            removingUserId: null,

            roleOptions: [],
            orgsOptions: [],
            badgeOptions: [],

            masterChbx: false,
            checkedboxes: [],
            selAction: '',

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
                resumeBook: new SparkForm({
                    users: '',
                }),

                addUser: new SparkForm({
                    first: '',
                    last: '',
                    email: '',
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

    watch: {
        'masterChbx': function(v) {
             var self = this;
             this.checkedboxes = [];
             if (v) {
                $.each(this.filteredUsers(), function(i,u) {
                     self.checkedboxes.push(u);
                });
             }
        },
        'selAction': function(v) {
            if (v != "") {
                if (this.checkedboxes.length>0) {
                    if (v=='email') { this.sendEmail(); } 
                    if (v=='resumebook') { 
                        this.forms.resumeBook.users = this.checkedboxes;
                        this.downloadResumeBook(); 
                    } 
                } else {
                    alert('Please select users');
                }
                this.selAction="";
            }
        },
    },

    events: { },

    computed: {
        everythingLoaded: function () {
            return this.roles.length > 0 && this.organizations.length > 0 && this.users.length > 0;
        },
        seekerNum: function() {
            return (this.filteredUsers()).length;
        },
    },

    methods: {
        addUser: function () {
            this.forms.addUser.first = '';
            this.forms.addUser.last = '';
            this.forms.addUser.email = '';
            this.forms.addUser.role_id = 4;
            this.forms.addUser.type = '';
            this.forms.addUser.organization_id = (this.usertype.isGradlead) ? '' : this.authUser.organization_id;
            this.forms.addUser.errors.forget();
            $('#modal-add-seeker').modal('show');
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
            $('#modal-edit-seeker').modal('show');
        },

        manageBadges: function(user) {
            this.badgesUser = user;
            $('#modal-manage-badges').modal('show');
        },

        viewProfile: function(user) {
            this.profilingUser = user;
            $('#modal-user-view-profile').modal('show');
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
            if (this.authUser.organization.type == 'gradlead') {
                return this.allTypeOptions;
            }
            if (this.authUser.organization.type == 'school') {
                return this.schoolTypeOptions;
            }
            if (this.authUser.organization.type == 'employer') {
                return this.employerTypeOptions;
            }
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

        sendEmail: function() { $('#modal-email-seeker').modal('show'); },
        closeEmail: function() { $('#modal-email-seeker').modal('hide'); },

        // Ajax calls
        downloadResumeBook: function() {
            var self = this;
            Spark.post(self.baseUrl + 'users/resumebook', this.forms.resumeBook)
                .then(function () { }, function (resp) { 
                    alert('Cannot download resume book: '+resp);
                });
        },

        addNewUser: function () {
            var self = this;
            Spark.post(self.baseUrl + 'users', this.forms.addUser)
                .then(function () {
                    $('#modal-add-seeker').modal('hide');
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
                    $('#modal-edit-seeker').modal('hide');
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
                    //NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000, });
                });
        },


        setupListeners: function () {
            var self = this;

            bus.$on('usersSet', function (users) {
                if (users.length) {
                    self.users = [];
                    $.each(users, function(idx, u) {
                        if (u.type=='student' || u.type=='graduate') {
                            if (self.usertype.isCompany) {
                                if(u.profile.visible==1) { self.users.push(u); }
                            } else {
                                self.users.push(u);
                            }
                        }
                    });
                }
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

                if (self.authUser.organization_id == 1) {
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

            bus.$on('jobTypesSet', function (items) {
                self.jtList = [];
                $.each(items, function(i,j){ self.jtList.push({id:j.name, name:j.name}); });
            });

            bus.$on('industriesSet', function (items) {
                self.jpList = [];
                $.each(items, function(i,j){ self.jpList.push({id:j.name, name:j.name}); });
            });


            bus.$on('badgesSet', function (items) {
                self.badges = items;
                $.each(items, function(x, i) {        
                    self.badgeOptions.push({ 'text': i.name, 'value': i.id });
                });
                //console.log("Got badges in "+ self.modname);
            });

            bus.$emit('screenLoaded',self.modname);
        },
    },

    filters: {
        role_is_editor: function (value) {
            return (value == 'Member') ? 'No' : 'Yes';
        },
        ucwords: function (str) {
            return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });
        },
    },
});
