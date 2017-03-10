Vue.component('gl-achievement', {
    props: ['user','badgeOptions'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                        <div v-if="options.length>0" class="row">\
                            <form class="form-horizontal" role="form">\
                            <div class="col-md-8">\
                                <gl-select :display="\'Badges\'" \
                                           :form="forms.addForm" \
                                           :name="\'badge_id\'" \
                                           :placetext="\'Select Badge\'" \
                                           :items="options" \
                                           :input="forms.addForm.badge_id">\
                                </gl-select>\
                            </div>\
                            <div class="col-md-3">\
                                <label style="border:0px solid red; margin-bottom: 7px;">&nbsp;</label><br/>\
                                <button type="button" class="btn btn-sm btn-info btn-addon pull-left" @click.prevent="addAchievement()" :disabled="forms.addForm.busy || (options.length<=0)">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-plus"></i> Add </span>\
                                </button>\
                            </div>\
                            </form>\
                         </div>\
                         <div v-else class="row"><div class="col-md-8"><b>All badges assigned</b><br/></div></div>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th></th><th>Name</th><th>Description</th><th>Awarded</th><th></th></tr></thead>\
                        <tbody v-if="list.length>0">\
                            <tr v-for="a in list">\
                                <td class="spark-table-pad"><img :src="getImage(a.badge)"></td>\
                                <td class="spark-table-pad">{{ a.badge.name }}</td>\
                                <td class="spark-table-pad">{{ a.badge.description }} </td>\
                                <td class="spark-table-pad">{{ a.created_at }}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeAchievement(a)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                        <tbody v-else><tr><td colspan="5">No badges</td></tr></tbody>\
                     </table>\
                  </div>\
               </div>',

    mounted: function () {
        this.setupListeners();
        this.forms.addForm.errors.forget();
        this.setList(this.user.achievements);
        this.setOptions();
    },

    watch: {
        'user': function(v) { this.setList(v.achievements); this.setOptions(); }
    },

    events: {},

    notifications: {
      showError: {
          title: 'Achievement Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Achievement success',
          message: 'Successfully modified achievement',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',

            list: [],
            options: [],

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    badge_id:'',
                }),
            },
        }
    },

    methods: {
        getImage: function (b) {
            if (b.id) {
                return this.baseUrl + 'badges/image/' + b.id;
            } else {
                return this.baseUrl+'img/a0.jpg';
            }
        },

        setList: function(l) { this.list = (typeof l=='undefined') ? [] : l; },

        setOptions: function() {
            var self = this;
            self.options = [];
            $.each(this.badgeOptions,function(i,b) {
                var has = false;
                for(var i=0; i < self.list.length; i++) {
                    var a = self.list[i];
                    if (a!=null) { if (a.badge_id==b.value) { has = true; } }
                }
                if (!has) { self.options.push(b);}
            }); 
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        addAchievement: function () {
            var self = this;
            this.forms.addForm.user_id = this.user.id;
            Spark.post(self.baseUrl+'users/badge', this.forms.addForm)
                .then(function () {
                    self.forms.addForm.errors.forget();
                    self.showSuccess({message:'New achievement added'});
                    bus.$emit('updateUsers');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeAchievement: function (e) {
            var self = this;

            this.$http.delete(self.baseUrl+'users/badge/' + e.id)
                .then(function () {
                    self.forms.addForm.errors.forget();
                    self.list = self.removeFromList(this.list, e);
                    self.showSuccess();
                    bus.$emit('updateUsers');
                }, function(resp) {
                    self.showError({'message': resp.error[0]});
                });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('allLoaded', function() { });
            bus.$on('usersSet', function (users) { 
                var u = self.user;
                for(var i=0; i < users.length; i++) { if (u.id == users[i].id) { u = users[i];  } }
                self.setList(u.achievements); 
                self.setOptions();
            });
        },
    }
});

Vue.component('gl-achievement-display', {
    props: ['user', 'tiny'],

    template: '<div v-if="list.length>0">\
                    <div v-for="a in list">\
                        <img v-if="tiny" :src="getImage(a.badge)" width="16px" height="16px">\
                        <img v-else :src="getImage(a.badge)">\
                    </div>\
               </div>\
               <div v-else>No badges</div>',

    mounted: function () {
        this.setupListeners();
        this.setList(this.user.achievements);
    },

    watch: {
        'user': function(v) { this.setList(v.achievements);}
    },

    events: {},

    data: function () {
        return {
            baseUrl: '/',
            list: [],
        }
    },

    methods: {
        getImage: function (b) {
            if (b.id) {
                return this.baseUrl + 'badges/image/' + b.id;
            } else {
                return this.baseUrl+'img/a0.jpg';
            }
        },

        setList: function(l) { this.list = (typeof l=='undefined') ? [] : l; },

        setupListeners: function () {
            var self = this;

            bus.$on('allLoaded', function() { });
            bus.$on('usersSet', function (users) { 
                var u = self.user;
                for(var i=0; i < users.length; i++) { if (u.id == users[i].id) { u = users[i];  } }
                self.setList(u.achievements); 
            });
        },
    }
});
