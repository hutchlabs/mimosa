Vue.component('gradlead-badges-screen', {

    mounted: function() {
        this.getBadges();
    },

    data: function() {
        return {
            badges: [],

            editingBadge: {'name':'none'},
            removingBadgeId: null,

            forms: {
                addBadge: new SparkForm ({
                    name: '',
                    description: '',
                    uploaded_file: '',
                }),

                updateBadge: new SparkForm ({
                    name: '',
                    description: '',
                    uploaded_file: '',
                }),
            }
        };
    },

    events: {
        'badgesUpdated': function(newusers) {
            this.getBadges();
         }
    },

    computed: {
    },

    methods: {
        addBadge: function () {
            this.forms.addBadge.name = '';
            this.forms.addBadge.description = '';
            this.forms.addBadge.uploaded_file = '';
            $('#modal-add-badge').modal('show');
        },
        editBadge: function (badge) {
            this.editingBadge = badge;
            this.forms.updateBadge.name = badge.name;
            this.forms.updateBadge.description = badge.description;
            this.forms.updateBadge.uploaded_file = '';
            $('#modal-edit-badge').modal('show');
        },

        removingBadge: function(id) { return (this.removingBadgeId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        addNewBadge: function () {
            var self = this;
            Spark.post('/mimosa/api/badges', this.forms.addBadge)
                .then(function () {
                    $('#modal-add-badge').modal('hide');
                    self.getBadges();
                }, function(resp) {
                    self.forms.addBadge.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updateBadge: function () {
            var self = this;
            Spark.put('/mimosa/api/badges/' + this.editingBadge.id, this.forms.updateBadge)
                .then(function () {
                    self.getBadges();
                    $('#modal-edit-badge').modal('hide');
                });
        },
        removeBadge: function (badge) {
            var self = this;
            self.removingBadgeId = badge.id;

            this.$http.delete('/mimosa/api/badges/' + badge.id)
                .then(function () {
                    self.removingBadgeId = 0;
                    self.badges = self.removeFromList(this.badges, badge);
                }, function(resp) {
                    self.removingBadgeId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        getBadges: function () {
            var self = this;
            this.$http.get('/mimosa/api/badges')
                .then(function (resp) {
                    self.badges = resp.data;
                });
        },
    },

    filters: {
        capitalize: function(value) {
            return value[0].toUpperCase() + value.substring(1);
        },
    },
});
