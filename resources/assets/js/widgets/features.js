Vue.component('spark-featured-jobs', {
    props: [],

    // TODO: Finish avatar load and onclick 
    template: '<div> \
        <div v-for="job in jobs" class="col-md-4 col-sm-6 blog-masonry-item development card">\
          <div v-if="job.organization.profile!=null" class="item-inner quote-post">\
            <div class="post-title">\
              <div class="row">\
                <div class="col-md-4">\
                    <img src="" class="img-circle emp-logo">\
                </div>\
                <div class="col-md-8">\
                  <h5 class="real-h5"> {{ job.organization.name }}</h5\>\
                  <h4> {{ job.organization.profile.industries }}</h4>\
                </div>\
              </div>\
              <h3>{{job.title}}</h3>\
              <div class="post-meta">\
                <span class="sub alt-font">{{job.country}}</span>\
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

    // TODO: Finish logo load and onclick 
    template: '<div> \
                <div class="col-md-2 col-sm-4">\
                    <img alt="Client Logo" src="http://app.gradlead.com/dist/assets/img/client1.png">\
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
