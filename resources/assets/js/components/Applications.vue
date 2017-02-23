Vue.component('gradlead-applications-screen', {
    
    props: ['authUser', 'usertype', 'permissions'],

    mounted: function () {
        this.setupListeners();
        this.currentJob = this.defaultJob;
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Applications',
            
            apps: [],
            jobs: [],
            questionnaires: [],

            filter: '',
            query: '',
            availableApps: [],

            bins: [
                {
                    name: 'Pending'
                },
                {
                    name: 'Approved'
                },
                {
                    name: 'Interviewed'
                },
                {
                    name: 'Hired'
                },
                {
                    name: 'Rejected'
                },
                {
                    name: 'Failed'
                },
            ],

            currentJob: {
                'id': 'none'
            },
            defaultJob: {
                'id': 'default',
                'title': 'none',
                'applications': []
            },
            currentApp: {
                'id': 0,
                'status': 'none'
            },
        };
    },

    watch: {
        'currentJob': function (job) {
            this.setJob(job);
        },
        'query': function (name) {
            this.setAvailableApps();
        },
        'filter': function (name) {
            this.setAvailableApps();
        },
        'multiJB': function (nw) {
            var vals = '';
            for (var i = 0; i < nw.length; i++) {
                vals += nw[i].name + ((i < nw.length - 1) ? ',' : '');
            }
        },
    },

    events: {},

    computed: {
        everythingLoaded: function () { return this.authUser != null; },
        isPending: function () { return this.currentApp.status == 'Pending'; },
        isApproved: function () { return this.currentApp.status == 'Approved'; },
        isInterviewed: function () { return this.currentApp.status == 'Interviewed'; },
        isHired: function () { return this.currentApp.status == 'Hired'; },
        isRejected: function () { return this.currentApp.status == 'Rejected'; },
        isFailed: function () { return this.currentApp.status == 'Failed'; },
        hasApps: function () { return this.availableApps.length > 0; },
        canRejectApp: function () { return !this.isInArray(this.currentApp.status, ['Hired', 'Rejected', 'Failed']); },
    },

    methods: {
        binCount: function (bin) {
            return (bin=='') ? this.apps.length : this.apps.reduce(function (c, app) {
                return (app.status == bin) ? c + 1 : c;
            }, 0);
        },
        
        binCountClass: function (bin) {
            if (bin == '') {
                return (this.apps.length == 0) ? 'badge bg-default pull-right' : 'badge bg-info pull-right';
            }
            return (this.binCount(bin) == 0) ? 'badge bg-default pull-right' : 'badge bg-info pull-right';
        },

        setJob: function (job) {
            var self = this;
            this.apps = [];

            if (job.id != 'default') {
                this.apps = job.applications;
            } else {
                $.each(this.jobs, function (idx, j) {
                    if (j.applications.length) {
                        self.apps = self.apps.concat.apply([], j.applications);
                    }
                });
            }
            this.setAvailableApps();
        },

        setAvailableApps: function () {
            var self = this;
            var clean = this.query.replace(/\[|\]|[|&;$%@"<>()+,]/g, "");
            var regexp = new RegExp(clean, 'i');
            this.availableApps = [];
            $.each(this.apps, function (idx, app) {
                var consider = true;
                var t = regexp.test(app.applicant);
                //console.log("Searching on "+clean+" against "+app.applicant+" regtest is "+t);
                if (self.filter != '' && app.status != self.filter) {
                    consider = false;
                }
                if (t === false) {
                    consider = false;
                }
                if (consider) {
                    self.availableApps.push(app);
                }
            });
            if (self.availableApps.length) {
                this.currentApp = (this.isSameApp()) ? this.currentApp : self.availableApps[0];
            }
        },

        selectBin: function (bin) {
            this.filter = bin.name;
        },

        selectApp: function (app) {
            this.currentApp = app;
        },

        isSameApp: function () {
            return (this.currentApp.job_id == this.currentJob.id);
        },

        // Remove functionality
        removeApp: function (app) {
            var self = this;
            this.$http.delete(self.baseUrl + 'jobs/application/' + app.id)
                .then(function () {
                    self.jobs = self.removeFromList(this.jobs, job);
                }, function (resp) {});
        },


        // Ajax calls
        setStatus: function (status) {
            var self = this;
            this.currentApp.status = status;
            this.$http.get(self.baseUrl + 'jobs/applications/' + this.currentApp.id + '/status/' + status).then(function () {
                bus.$emit('updateJobs');
            });
        },

        setupListeners: function () {
            var self = this;
            
            bus.$on('jobsSet', function (items) {
                self.jobs = [];
                if (items!==null) {
                    $.each(items, function (idx, job) {
                        if (self.usertype.isGradlead) { self.jobs.push(job) }
                        else if (self.authUser.organization_id==job.organziation_id) { 
                            self.jobs.push(job); 
                        }
                    });
                }
                self.setJob(self.currentJob);
            });
            
            bus.$on('questionnairesSet', function (items) {
                self.questionnaires = items;
            });
            
            bus.$emit('screenLoaded',self.modname);
        },


        // Helpers
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

    filters: {
        status_text: function (value) {
            return (value) ? 'Active' : 'Not Active';
        },
    },
});
