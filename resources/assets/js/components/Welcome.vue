Vue.component('gradlead-welcome-screen', {

    mounted: function() {
        this.getAuthUser();
    },

    data: function() {
        return {
            baseUrl: '/',
            user: null,
            loggedIn: false,
            
            jobs: [],
            companies: [],
        };
    },
    
    events: {
    },

    computed: { 
        canEdit: function() {
             return (self.user==null) ? false : ((self.user.role.name=='Member') ? false : true);
        },
    },

    methods: {
        showEmployer: function(id) {
            window.location.href= this.baseUrl+'o/'+id;
        },
        
        showJob: function(id) {
            window.location.href= this.baseUrl+'j/'+id;
        },

        showReg: function(id) {
            var url = this.baseUrl+'home?page=detail&id='+id+'&action=apply#jobs';
            bus.$emit('showRegistration',url);
        },

        showApply: function(id) {
            window.location.href= this.baseUrl+'home?page=detail&id='+id+'&action=apply#jobs';
        },

        getFeaturedJobs: function () {
            this.$http.get(self.baseUrl+'jobs/featured')
                .then(function (resp) {
                    this.jobs = resp.data;
                });
        },
        
        getFeaturedCompanies: function () {
            this.$http.get(self.baseUrl+'organizations/featured')
                .then(function (resp) {
                    this.companies = resp.data;
                });
        },
        
        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) {
                    self.user = user.data; 
                    self.loggedIn = (self.user.name) ? true : false;
                });
        },
    },

    filters: { },
});
