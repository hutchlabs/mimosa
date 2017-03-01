Vue.component('gradlead-search-screen', {

    props: ['authUser', 'usertype', 'permissions'],

    components: {
        Datepicker,
        Multiselect
    },

    mounted: function () {
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Jobs',

            q: '',
            l: '',

            jobs:[],
            jobsAll: [],
            jobsFeatured: [],
            jobsSchool: [],
            jobsOther: [],

            srText: '<strong>RESNUM</strong> Results found for: <strong>KEYWORD</strong>',
            degrees: [],
            industries: [],
            jobTypes: [],
            languages: [],
            majors: [],
            skills: [],
            questionnaires: [],
        };
    },

    watch: {
        'jobs': function(v) {
           console.log("Jobs changed");
          this.$refs.resultsText.innerHTML = this.getResultsText();
        },
        'q': function(v) {
           console.log(v);
          this.$refs.resultsText.innerHTML = this.getResultsText();
        },
        'l': function(v) {
          this.$refs.resultsText.innerHTML = this.getResultsText();
          console.log(v);
        }
    },

    events: {},

    computed: {
        everythingLoaded: function () { return true; },
        isLoggedIn: function () { return this.authUser!=null; },
        allCount: function () { return this.jobsAll.length; },
        schoolCount: function () { return this.jobsSchool.length; },
        otherCount: function () { return this.jobsOther.length; },
    },

    methods: {
        processJobs: function() {
            var self = this;
            this.jobsAll= [];
            this.jobsFeatured= [];
            this.jobsSchool= [];
            this.jobsOther= [];

            $.each(this.jobs, function(i, j) {
                self.jobsAll.push(j);
                if (j.featured) { self.jobsFeatured.push(j); }
                if (self.isLoggedIn) {
                    if  (self.isInArray(self.authUser.organization_id, j.school_ids.split(','))) {
                        self.jobsSchool.push(j); }
                }
            });

            this.$refs.resultsText.innerHTML = this.getResultsText();
        },

        processSearchResults: function(data) {
               var st = self.q + ((self.l=='') ?'' : ' in '+self.l);
                this.jobs = data.all;
                this.jobsAll= data.all;
                this.jobsFeatured= data.featured;
                this.jobsSchool= data.school;
                this.jobsOther= data.other;
                var st = this.q + ((this.l=='') ?'' : ' in '+this.l);
                this.srText.replace("RESNUM",self.jobs.length).replace("KEYWORD",st);
        },

        // Ajax calls functionality
        search: function () {
            var self = this;
            var uri = self.baseUrl+'search/jobs/?q='+this.q+'&l='+this.l;
            this.$http.get(uri).then(function (resp) {
                   self.processSearchResults(resp.data.data);
            }, function(resp) {
                    //NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('jobsSet', function (items) {
                self.jobs = [];
                if (items!==null) {
                    $.each(items, function (idx, job) {
                        if (self.usertype.isGradlead || self.usertype.isSchool) { self.jobs.push(job) }
                        else if (self.authUser.organization_id==job.organziation_id) { self.jobs.push(job); }
                    });
                    self.processJobs();
                }
            });

            bus.$on('jobTypesSet', function (items) { self.jobTypes = items; });
            bus.$on('questionnairesSet', function (items) { self.questionnaires = items[0]; });
            bus.$on('languagesSet', function (items) { self.languages = items; });
            bus.$on('degreesSet', function (items) { self.degrees = items; });
            bus.$on('industriesSet', function (items) { self.industries = items; });
            bus.$on('skillsSet', function (items) { self.skills = items; });
            bus.$on('majorsSet', function (items) {
                self.majors = items;
                self.majors.sort(function(a,b) {
                    var x = a.name; var y = b.name;
                    return (x < y) ? -1 : ((x > y) ? 1 : 0);
                });
            });

            bus.$emit('screenLoaded',self.modname);
        },

        // Helpers
        getResultsText: function() {
            if (this.q=='' && this.l=='' && this.jobs.length==0) { return "<span class='text-muted'>waiting..</span>"; }

            if (this.q=='' && this.l=='' && this.jobs.length>0) {
                return 'Displaying <strong>'+this.jobs.length+'</strong> Results<strong>';
            }

            var st = this.q + ((this.l=='') ?'' : ' in '+this.l);
            if (this.q != '' && this.l != '') {
                return "Searching for <strong>"+st+"</strong>";
            }

            return "<span class='text-muted'>waiting..</span>";

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

    filters: {
    },
});
