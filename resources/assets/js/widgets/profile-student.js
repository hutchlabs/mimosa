Vue.component('gl-student-profile', {
    props: ['user','def'],

    template: '<div>\
                  <spark-profile-summary :title="\'Summary\'" :profileid:="myuser.profile.id" :myuserid="myuser.id" :summary="myuser.profile.summary">\
                  </spark-profile-summary>\
                  <spark-profile-work :title="\'Professional Experience\'" :myuserid="myuser.id" :work="myuser.work">\
                  </spark-profile-work>\
                  <spark-profile-education :title="\'Education\'" :myuserid="myuser.id" :education="myuser.education">\
                  </spark-profile-education>\
                  <div class="row">\
                    <div class="col-sm-6">\
                        <spark-profile-languages :title="\'Languages\'" :myuserid="myuser.id" :languages="myuser.languages">\
                        </spark-profile-languages>\
                     </div>\
                     <div class="col-sm-6">\
                        <spark-profile-skills :title="\'Skills\'" :myuserid="myuser.id" :skills="myuser.skills">\
                        </spark-profile-skills>\
                     </div>\
                  </div>\
                </div>',

    mounted: function () { this.myuser = this.def; }, 
    watch: { 
        'user': function(u) { this.myuser = u; }
    },
    events: {},
    data: function () { return { baseUrl: '/', myuser: { 'name': 'none', 'id':0, profile:{'id':0}},
    
    } },
    methods: { }
});
