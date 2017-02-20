Vue.component('gradlead-badges-screen', {

    mounted: function() {
        this.setupListeners();
    },

    data: function() {
        return {
            baseUrl: '/mimosa/',
            modname: 'Badges',
            
            badges: [],
			files: [],

            editingBadge: {'name':'none'},
            removingBadgeId: null,
            
            nameError: false,
            descError: false,

            forms: {
               updateBadge: new SparkForm ({
                    name: '',
                    description: '',
                    image: '',
                }),
            }
        };
    },

    events: {
    },

    computed: {
        everythingLoaded: function () {
            return this.badges != null;
        }
    },

    methods: {
        addBadge: function() {
            this.nameError = false;
            this.descError = false;
            $('#modal-add-badge').modal('show');
        },
        
        editBadge: function (badge) {
            this.editingBadge = badge;
            this.nameError = false;
            this.descError = false;
            $('#uname').val(badge.name);
            $('#udescription').val(badge.description);
            $('#bid').val(badge.id);
            $('#modal-edit-badge').modal('show');
        },

        removingBadge: function(id) { return (this.removingBadgeId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        getImage: function (b) {
            if (b.id) {
                return this.baseUrl + 'badges/image/' + b.id;
            } else {
                return this.baseUrl+'img/a0.jpg';
            }
        },
           
        addNewBadge: function (e) {
            var self = this;
            if($('#name').val()=='') { this.nameError = true; }
            if ($('#description').val()=='') { this.descError = true; }
            
            if ( $('#name').val() != "" && $('#description').val()!='') {
                    $('#modal-add-badge').modal('hide');
            } else {
                e.preventDefault();
            }
        },   
            
        updateBadge: function (e) {
            var self = this;
            if($('#uname').val()=='') { this.nameError = true; }
            if ($('#udescription').val()=='') { this.descError = true; }
            
            if ( $('#uname').val() != "" && $('#udescription').val()!='') {
                    $('#modal-edit-badge').modal('hide');
            } else {
                e.preventDefault();
            }
        },

        removeBadge: function (badge) {
            var self = this;
            self.removingBadgeId = badge.id;

            this.$http.delete(self.baseUrl + 'badges/' + badge.id)
                .then(function () {
                    self.removingBadgeId = 0;
                    self.badges = self.removeFromList(this.badges, badge);
                    bus.$emit('updateBadges');
                }, function(resp) {
                    self.removingBadgeId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        setupListeners: function () {
            var self = this;
            bus.$on('badgesSet', function (items) {
                //console.log("Got badges in "+ self.modname);
                self.badges = items;
            });
            
            bus.$emit('screenLoaded',self.modname);
        },

  
    },

    filters: {
        capitalize: function(value) {
            return value[0].toUpperCase() + value.substring(1);
        },
    },
});
