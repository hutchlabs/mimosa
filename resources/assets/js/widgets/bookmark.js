Vue.component('gradlead-bookmark', {
    props: ['authUser'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Bookmark</th><th>URL</th><th>Created</th><th></th></tr></thead>\
                        <tbody>\
                            <tr v-for="e in list">\
                                <td class="spark-table-pad">{{ e.description}}</td>\
                                <td class="spark-table-pad"><a :href="e.url" style="color:#336699">Link to page</a></td>\
                                <td class="spark-table-pad">{{ e.created_at }}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeBookmark(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                     </table>\
                  </div>\
               </div>',

    mounted: function () {
        this.list = this.authUser.bookmarks;
        this.setupListeners();
    },

    watch: {},

    events: {},

    data: function () {
        return {
            baseUrl: '/',
            list: [],
        }
    },

    methods: {
        setList: function(l) { this.list = l; },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        removeBookmark: function (e) {
            var self = this;

            this.$http.delete(self.baseUrl+'users/bookmark/' + e.id)
                .then(function () {
                    self.list = self.removeFromList(this.list, e);
                    bus.$emit('updateAuthUser');
                }, function(resp) { });
        },

        setupListeners: function () {
            var self = this;
            bus.$on('allLoaded', function() { });
            bus.$on('authUserSet', function (user) { self.setList(user.bookmarks); });
        },
    }
});
