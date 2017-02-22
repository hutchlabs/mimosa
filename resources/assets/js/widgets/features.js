Vue.component('spark-featured-jobs', {
    props: [],

    // TODO: Finish onclick 
    template: '<div> \
        <div v-for="job in jobs" class="col-md-4 col-sm-6 blog-masonry-item development card" style="cursor:pointer">\
          <div v-if="job.organization.profile!=null" class="item-inner quote-post">\
            <div class="post-title">\
              <div class="row">\
                <div class="col-md-4">\
                    <img :src="job.orglogo" class="img-circle emp-logo">\
                </div>\
                <div class="col-md-8">\
                  <h5 class="real-h5"> {{ job.organization.name }}</h5\>\
                  <h3>{{job.title}}</h3>\
                  <div class="post-meta">\
                    <span class="sub alt-font"></span>\
                  </div>\
                </div>\
              </div>\
            </div>\
          </div>\
          </div>\
        </div>',
 
    mounted: function () {
        this.getFeaturedJobs();
    },
    data: function () {
        return {
            jobs: []
        }
    },

    methods: {
        getFeaturedJobs: function () {
            this.$http.get('/jobs/featured')
                .then(function (resp) {
                    this.jobs = resp.data.data;
                });
        },
    }    
});

Vue.component('spark-featured-employers', {
    props: [],

    // TODO: Finish onclick 
    template: '<div> \
                <div v-for="o in orgs" class="col-md-2 col-sm-4" style="cursor:pointer">\
                    <img alt="Client Logo" :src="o.logo_url">\
                </div>\
            </div>',
 
    mounted: function () {
        this.getFeaturedEmployers();
    },
    data: function () {
        return {
            orgs: []
        }
    },

    methods: {
        getFeaturedEmployers: function () {
            this.$http.get('/organizations/featured')
                .then(function (resp) {
                    this.orgs = resp.data.data;
                });
        },
    }    
});
