Vue.component('gl-view-profile-seeker', {

    props: ['user'],

    template: '<div class="hbox hbox-auto-xs hbox-auto-sm">\
        <div class="col">\
            <div class="wrapper bg-white b-b">\
                <ul class="nav nav-pills nav-sm">\
                    <li role="presentation" class="active">\
                        <a href="#gusrprofile" aria-controls="gusrprofile" role="tab" data-toggle="tab">&nbsp;Profile</a>\
                    </li>\
                    <li role="presentation">\
                        <a href="#guresumes" aria-controls="guresumes" role="tab" data-toggle="tab">&nbsp;Resumes</a>\
                    </li>\
                    <li role="presentation">\
                        <a href="#gudocs" aria-controls="gudocs" role="tab" data-toggle="tab">&nbsp;Documents</a>\
                    </li>\
                </ul>\
            </div>\
            <div class="hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <div class="tab-content">\
                        <div role="tabpanel" class="tab-pane active" id="gusrprofile">\
                            Coming...View <a target="_blank" :href="user.profile_url">Public profile</a>\
                        </div>\
                        <div role="tabpanel" class="tab-pane" id="guresumes">\
                            coming\
                        </div>\
                        <div role="tabpanel" class="tab-pane" id="gudocs">\
                            coming\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>',

    mounted: function () { },

    data: function () {
        return {
            baseUrl: '/',
        };
    },

    watch: { },

    events: {},

    computed: { },

    methods: { },

    filters: { },
});
