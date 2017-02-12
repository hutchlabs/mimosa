Vue.component('gradlead-welcome-screen', {

    mounted: function() {
    },

    data: function() {
        return {
            jobs: [],
            companies: [],
            baseUrl: '/mimosa/',
        };
    },
    
    events: {
    },

    computed: { },

    methods: {
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
    },

    filters: {
    },
});
