Vue.component('gradlead-welcome-screen', {

    mounted: function() {
    },

    data: function() {
        return {
            jobs: [],
            companies: [],
        };
    },
    
    events: {
    },

    computed: {
    },

    methods: {
        getFeaturedJobs: function () {
            this.$http.get('/mimosa/jobs/featured')
                .then(function (resp) {
                    this.jobs = resp.data;
                });
        },
        
        getFeaturedCompanies: function () {
            this.$http.get('/mimosa/organizations/featured')
                .then(function (resp) {
                    this.companies = resp.data;
                });
        },
    },

    filters: {
    },
});
