var _moment = require('moment');

Vue.component('gradlead-inbox-dropdown', {
    props: ['user'],

    template:'<li class="dropdown"><a href="#" class="dropdown-toggle clear" data-toggle="dropdown">\
                <i class="glyphicon glyphicon-envelope icon fa-fw"> </i> <span class="visible-xs-inline">Messages</span>\
                <span :class="((newMessages)?\'bg-danger\':\'bg-default\')" class="badge badge-sm up pull-right-xs">{{ list.length }}</span></a>\
                <div class="dropdown-menu w-xl animated fadeInUp">\
                    <div class="panel bg-white">\
                        <div v-if="newMessages" class="panel-heading b-light bg-light">\
                            <strong> You have <span> {{list.length}} </span> new messages</strong>\
                        </div>\
                        <div v-else class="panel-heading b-light bg-light">\
                            <strong> You have no new messages</strong>\
                        </div>\
                        <div v-show="newMessages" class="list-group">\
                            <p v-for="l in list" class="media list-group-item">\
                                <span class="pull-left thumb-sm">\
                                    <img :src="(l.from.type==\'student\' || l.from.type==\'graduate\')?l.from.avatar:l.from.orgurl" class="img-circle">\
                                </span>\
                                <span class="media-body block m-b-none">\
                                    {{ l.subject }} <br>\
                                    <small class="text-muted"> {{ l.created_at | fromNow }} </small>\
                                </span>\
                            </p>\
                        </div>\
                        <div class = "panel-footer text-sm">\
                            <a href class="pull-right"> <i class="fa fa-cog"></i></a>\
                            <a href="/home?#messages" data-toggle="class:show animated fadeInRight">See all the messages</a>\
                        </div>\
                    </div>\
                </div></li>',
    
    mounted: function () {
        this.setupListeners();
        this.setList(this.user.inbox);
    },

    computed: {
        newMessages: function() { return this.list.length>0; }
    },

    watch: { },

    events: {},

    data: function () {
        return {
            baseUrl: '/',
            list: [],
        }
    },

    methods: {
        setList: function (l) {
            var self = this;
            self.list = [];

            l = (typeof l == 'undefined') ? [] : l;

            if (l.length>0) {
                l.sort(function(a,b) {
                    var x = a.id; var y = b.id;
                    return (x < y) ? -1 : ((x > y) ? 1 : 0);
                });
            
                $.each(l, function(i, x) { if (!x.seen) { self.list.push(x); } });
            }
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('allLoaded', function () {});
            bus.$on('usersSet', function (users) {
                var u = self.user;
                for (var i = 0; i < users.length; i++) {
                    if (u.id == users[i].id) { u = users[i]; }
                }
                self.setList(u.inbox);
            });
        },
    },

    filters: { 
        fromNow: function(v) { return _moment(v).fromNow() },
    },

});
