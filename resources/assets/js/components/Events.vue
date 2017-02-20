Vue.component('gradlead-events-screen', {

    components: {
        Datepicker
    },

    mounted: function() {
        this.setupListeners();
    },

    data: function() {
        return {
            baseUrl: '/',
            modname: 'Events',
            
            events: [],

            editingEvent: {'name':'none'},
            removingEventId: null,

            forms: {
                addEvent: new SparkForm ({
                    name: '',
                    description: '',
                    start_date: new Date(),
                    organization_id: '',
                    end_date: '',
                }),

                updateEvent: new SparkForm ({
                    id: '',
                    name: '',
                    description: '',
                    start_date: '',
                    end_date: '',
                }),
            }
        };
    },
    
    events: {
    },

    computed: {
        everythingLoaded: function () {
            return this.events != null;
        }
    },

    methods: {
        addEvent: function () {
            this.forms.addEvent.name = '';
            this.forms.addEvent.description = '';
            this.forms.addEvent.start_date = new Date();
            this.forms.addEvent.end_date = '';
            this.forms.addEvent.errors.forget();
            $('#modal-add-event').modal('show');
        },
        editEvent: function (event) {
            this.editingEvent = event;
            this.forms.updateEvent.id = event.id
            this.forms.updateEvent.name = event.name
            this.forms.updateEvent.description = event.description;
            this.forms.updateEvent.start_date = event.start_date;
            this.forms.updateEvent.end_date = event.end_date; 
            this.forms.updateEvent.errors.forget();
            $('#modal-edit-event').modal('show');
        },

        removingEvent: function(id) { return (this.removingEventId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        addNewEvent: function () {
            var self = this;
            Spark.post(self.baseUrl+'events', this.forms.addEvent)
                .then(function () {
                    $('#modal-add-event').modal('hide');
                    bus.$emit('updateEvents');
                }, function(resp) {
                    self.forms.addEvent.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updateEvent: function () {
            var self = this;
            Spark.put(self.baseUrl+'events/' + this.editingEvent.id, this.forms.updateEvent)
                .then(function () {
                    bus.$emit('updateEvents');
                    $('#modal-edit-event').modal('hide');
                });
        },
        removeEvent: function (event) {
            var self = this;
            self.removingEventId = event.id;

            this.$http.delete(self.baseUrl+'events/' + event.id)
                .then(function () {
                    self.removingEventId = 0;
                    self.events = self.removeFromList(this.events, event);
                    bus.$emit('updateEvents');
                }, function(resp) {
                    self.removingEventId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },
        
        setupListeners: function () {
            var self = this;
            bus.$on('eventsSet', function (items) {
                console.log("Got events in "+ self.modname);
                self.events = items;
            });
            
            bus.$emit('screenLoaded',self.modname);
        },
    },

    filters: {
    },
});
