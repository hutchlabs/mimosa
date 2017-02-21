Vue.component('gradlead-lists-screen', {

    props: ['list','authUser', 'usertype', 'permissions'],

    components: {
        'notifications': Notification,
    },

    mounted: function () {        
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Lists',

            degrees: [],
            industries: [],
            jobTypes: [],
            languages: [],
            majors: [],
            skills: [],
            universities: [],

            editingItem: '',
            categoryOptions: [],

            // forms
            forms: {
                addForm: new SparkForm ({
                    name: '',
                    website: '',
                    country: '',
                    category: '',
                }),

                updateForm: new SparkForm ({
                    id: '',
                    name: '',
                    website: '',
                    country: '',
                    category: '',
                }),
            },
        };
    },

    watch: { },

    events: {},

    computed: {
        everythingLoaded: function () {
            return this.authUser != null && this.list!='' && this.universities.length > 0; 
        },
        isMajor: function() { return this.list=='Majors'; },
        isUniversity: function() { return this.list=='Universities'; },
    },

    methods: {
        // List and applications
        addList: function () {
            this.forms.addForm.name = '';
            this.forms.addForm.webiste = '';
            this.forms.addForm.country = ''; 
            this.forms.addForm.category = '';
            this.forms.addForm.errors.forget();
        },
        editList: function (item) {
            this.editingItem = item;
            this.forms.updateForm.id = item.id
            this.forms.updateForm.name = item.name
            this.forms.updateForm.country = item.country;
            this.forms.updateForm.website = item.website;
            this.forms.updateForm.category = item.category;
            this.forms.updateForm.errors.forget();
        },

        // Ajax calls
        addNewListItem: function () {
            var self = this;
            var path = this.getPath();

            if (path != null) {
               Spark.post(self.baseUrl+path, this.forms.addForm)
                    .then(function () {
                        bus.$emit('update'+self.list);
                        var closeAddButton = self.$refs.closeAddItem;
                        closeAddButton.click();
                    }, function(resp) {
                        self.forms.addForm.busy = false;
                        NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                    });
            }
        },
        updateListItem: function () {
            var self = this;
            var path = this.getPath();

            if (path != null) {
                Spark.put(self.baseUrl+path+'/' + this.editingItem.id, this.forms.updateForm)
                    .then(function () {
                        bus.$emit('update'+self.list);
                        var closeEditButton = self.$refs.closeEditItem;
                        closeEditButton.click();
                    });
            }
        },
        removeListItem: function (item) {
            var self = this;
            var path = this.getPath();

            if (path != null) {
                this.$http.delete(self.baseUrl+path+'/' + item.id)
                    .then(function () {
                        self.removeItem(item);
                        bus.$emit('update'+self.list);
                    }, function(resp) {
                        NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                    });
            }
        },

        // Ajax calls
        setupListeners: function () {
            var self = this;
            bus.$on('degreesSet', function (items) { self.degrees = items; });
            bus.$on('industriesSet', function (items) { self.industries = items; });
            bus.$on('jobTypesSet', function (items) { self.jobTypes = items; });
            bus.$on('languagesSet', function (items) { self.languages = items; });
            bus.$on('majorsSet', function (items) { 
                self.majors = items; 
                self.categoryOptions = [];
                $.each(self.majors, function(idx, m) {
                    self.categoryOptions.push({'text':self.ucwords(m.category), 'value':m.category  });
                });
            });
            bus.$on('skillsSet', function (items) { self.skills = items; });
            bus.$on('universitiesSet', function (items) { self.universities = items; });
            bus.$emit('screenLoaded',self.modname);
         },

        // Helpers
        getList: function() {
            if (this.list=='Degrees') { return this.degrees; }
            if (this.list=='Industries') { return this.industries; }
            if (this.list=='JobTypes') { return this.jobTypes; }
            if (this.list=='Languages') { return this.languages; }
            if (this.list=='Majors') { return this.majors; }
            if (this.list=='Skills') { return this.skills; }
            if (this.list=='Universities') { return this.universities; }
            return [];
        },

        getPath: function() {
            var path = null;
            switch (this.list) {
                case 'Degrees': path='degrees'; break;
                case 'Industries': path='industries'; break;
                case 'JobTypes': path='jobtypes'; break;
                case 'Languages': path='languages'; break;
                case 'Majors': path='majors'; break;
                case 'Skills': path='skills'; break;
                case 'Universities': path='universities'; break;
                default: path= null;
            }
            return path;
        },

        removeItem: function(item) {
            if (this.list=='Degrees') { this.degrees = this.removeFromList(this.degrees, item); }
            if (this.list=='Industries') { this.industries = this.removeFromList(this.industries, item); }
            if (this.list=='JobTypes') { this.jobTypes = this.removeFromList(this.jobTypes, item); }
            if (this.list=='Languages') { this.languages = this.removeFromList(this.languages, item); }
            if (this.list=='Majors') { this.majors = this.removeFromList(this.majors, item); }
            if (this.list=='Skills') { this.skills = this.removeFromList(this.skills, item); }
            if (this.list=='Universities') { this.universities = this.removeFromList(this.universities, item); }
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        isInArray: function (item, array) {
            return !!~$.inArray(item, array);
        },

        ucwords: function (str) {
            return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });
        },
    },

    filters: { },
});
