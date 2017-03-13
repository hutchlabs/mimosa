var _moment = require('moment');

Vue.component('gradlead-search-screen', {

    props: ['hpath','hsearch','authUser', 'usertype', 'permissions'],

    components: {
        Datepicker,
        Multiselect
    },

    mounted: function () {
        this.setupListeners();
        this.setResumes(this.authUser.resumes);
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Jobs',

            q: '',
            l: '',
            isSearch: false,
            searching: false,

            jobs:[],
            jobsAll: [],
            jobsFeatured: [],
            jobsSchool: [],
            jobsOther: [],
            currentJob: {title:'',id:0,organization:{profile:{}}},
            
            srText: '<strong>RESNUM</strong> Results found for: <strong>KEYWORD</strong>',
            degrees: [],
            industries: [],
            jobTypes: [],
            languages: [],
            majors: [],
            skills: [],
            
            questionnaires: [],
            resumes: [],
            
             forms: {
                applyForm: new SparkForm ({
                    user_id: '',
					job_id: '',
           			resume_id: '',
		           	screening: '',
                }),
                bookmarkForm: new SparkForm ({
                    user_id: '',
           			description: '',
		           	url: '',
                }),
            }
        };
    },

    watch: {
        'jobs': function(v) {
          this.$refs.resultsText.innerHTML = this.getResultsText();
        },
        'q': function(v) {
          this.searching = true;
          this.$refs.resultsText.innerHTML = this.getResultsText();
        },
        'l': function(v) {
          this.searching = true;
          this.$refs.resultsText.innerHTML = this.getResultsText();
        }
    },

    events: {},

    computed: {
        everythingLoaded: function () { return true; },
        isLoggedIn: function () { return this.authUser!=null; },
        allCount: function () { return this.jobsAll.length; },
        schoolCount: function () { return this.jobsSchool.length; },
        otherCount: function () { return this.jobsOther.length; },
        hasNotApplied: function() { return ! this.hasApplied(this.currentJob) },
        hasResumes: function() { return this.resumes.length > 0; },
        detailSet: function() { return (typeof this.hsearch.page != 'undefined'); }
    },

    methods: {
        showJob: function(j) {
            this.currentJob = j;
            var btn = this.$refs.toJobPage;
            btn.click();
        },

        processJobs: function() {
            var self = this;
            this.jobsAll= [];
            this.jobsFeatured= [];
            this.jobsSchool= [];
            this.jobsOther= [];

            $.each(this.jobs, function(i, j) {
                self.jobsAll.push(j);
                if (self.detailSet && (j.id==self.hsearch.id)) { self.currentJob = j; console.log('setting current job'); }

                if (j.featured) { self.jobsFeatured.push(j); }
                if (self.isLoggedIn) {
                    if  (self.isInArray(self.authUser.organization_id, j.school_ids.split(','))) {
                        self.jobsSchool.push(j); }
                }
            });

            this.$refs.resultsText.innerHTML = this.getResultsText();
        },

        setResumes: function(resumes) {
            var self = this;
            resumes = (resumes==null) ? [] : resumes;
            $.each(resumes, function(i,r) {
                self.resumes.push({text:r.name, value:r.id});       
            });    
        },
        
        hasApplied: function(job) {
            var self = this;
            var applied = false;
            $.each(this.authUser.applications, function(i,a){
                if (a.job_id==job.id) { applied = true; } 
            });
            return applied;
        },

        hasBookmarked: function(job) {
            var bid = this.getBookmarkId(this.getJobUrl(job));
            return (bid==null) ? false : true;
        },

        hasBookmarkedSearch: function() {
            var self = this;
            var bid = this.getBookmarkId(this.getSearchUrl());
            return (bid==null) ? false : true;
        },

        getBookmarkId: function(url) {
            var id = null;
            $.each(this.authUser.bookmarks, function(i,a){
                if (a.url==url) { id = a.id; } 
            });
            return id;
        },

        appStatus: function(jobId) {
            var self = this;
            var status = "Unknown";
            $.each(this.authUser.applications, function(i,a){
                if (a.job_id==jobId) { status = a.status; } 
            });
            return (status=='Hired') ? status : 'Received';
        },
        
        apply: function(job) {
                this.currentJob = job;
                this.forms.applyForm.user_id = this.authUser.id;
                this.forms.applyForm.job_id = job.id;
                this.forms.applyForm.resume_id = '';
                this.forms.applyForm.screening = '';
                $('#modal-apply').modal('show');
        },

        bookmarkSearch: function() {
            this.forms.bookmarkForm.user_id = this.authUser.id;
            this.forms.bookmarkForm.url = this.getSearchUrl(); 
            this.forms.bookmarkForm.description = 'Search results for '+this.q+' '+this.l; 
            this.bookmark();
        },

        bookmarkJob: function(job) { 
            this.forms.bookmarkForm.user_id = this.authUser.id;
            this.forms.bookmarkForm.url = this.getJobUrl(job); 
            this.forms.bookmarkForm.description = "Job: "+job.title;
            this.bookmark();
        },

        unbookmarkSearch: function() {
            var bid = this.getBookmarkId(this.getSearchUrl());
            this.unbookmark(bid);
        },

        unbookmarkJob: function(job) {
            var bid = this.getBookmarkId(this.getJobUrl(job));
            this.unbookmark(bid);
        },
        
        
        processSearchResults: function(data) {
            this.jobs = data.all;
            this.jobsAll= data.all;
            this.jobsFeatured= data.featured;
            this.jobsSchool= data.school;
            this.jobsOther= data.other;
        },

        // Ajax calls functionality
        bookmark: function() { 
            this.$http.post(this.baseUrl+'users/bookmark', this.forms.bookmarkForm).then(function (resp) {
                bus.$emit('updateAuthUser'); }, function(resp) { });
        },

        unbookmark: function(bid) {
            this.$http.delete(this.baseUrl+'users/bookmark/'+bid).then(function (resp) {
                bus.$emit('updateAuthUser'); }, function(resp) { });
        },

        submitApp: function() {
            var self = this;
            this.$http.post(self.baseUrl+'jobs/apply', this.forms.applyForm).then(function (resp) {
                $('#modal-apply').modal('hide');
                bus.$emit('updateAuthUser');
            }, function(resp) {
                
            });
        },
        
        search: function () {
            var self = this;
            var uri = self.baseUrl+'search/jobs/?q='+this.q+'&l='+this.l;
            this.$http.get(uri).then(function (resp) {
                   self.isSearch = true;
                   self.searching = false;
                   self.processSearchResults(resp.data.data);
            }, function(resp) {
             
            });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('authUserSet', function (user) { 
                self.setResumes(user.resumes);
            });
            
            bus.$on('jobsSet', function (items) {
                self.jobs = [];
                if (items!==null) {
                    $.each(items, function (idx, job) {
                        if (self.usertype.isGradlead || self.usertype.isSchool) { self.jobs.push(job) }
                        else if (self.authUser.organization_id==job.organziation_id) { self.jobs.push(job); }
                    });
                    
                    if (self.detailSet && self.hsearch.page=='sp') {
                        self.q = self.hsearch.q;
                        self.l = self.hsearch.l;
                        console.log("Setting search to "+self.q+ " "+self.l);
                        self.search();
                    } else {
                        self.processJobs();
                    }
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
        getOrgUrl: function(job) {
            return this.baseUrl+'o/'+job.organization_id;
        },

        getJobUrl: function(job) {
            return this.baseUrl+'home?page=detail&id='+job.id+'#jobs';
        },

        getSearchUrl: function() {
            return this.baseUrl+'home?page=sp&q='+this.q+'&l='+this.l+'#jobs';
        },
        
        tabClass: function(name) {
            if (!this.detailSet && name=='sp') return 'tab-pane active';
            var x = (this.detailSet && this.hsearch.page==name) ? 'tab-pane active' : 'tab-pane';
            return x;
        },

        getResultsText: function() {
            if (this.q=='' && this.l=='' && this.jobs.length==0) { return "<span class='text-muted'>waiting..</span>"; }

            if (this.q=='' && this.l=='' && this.jobs.length>0) {
                return 'Displaying <strong>'+this.jobs.length+'</strong> Results<strong>';
            }

            var st = this.q + ((this.l=='') ?'' : ' in '+this.l);
            if (this.searching) {
                return "Searching for <strong>"+st+"</strong>...";
            }

            var st = this.q + ((this.l=='') ?'' : ' in '+this.l);
            return this.srText.replace("RESNUM",this.jobs.length).replace("KEYWORD",st);

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
        nice_date: function(v) {
			return _moment().format(v,'Do MMMM, YYYY');
        }
    },
});
