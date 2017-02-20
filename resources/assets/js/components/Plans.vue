Vue.component('gradlead-plans-screen', {

    components: {
        Datepicker
    },

    mounted: function() {
        this.setupListeners();
    },

    data: function() {
        return {
            baseUrl: '/',
            modname: 'Plans',
            
            plans: [],

            editingPlan: {'name':'none'},
            removingPlanId: null,

            yesNoOptions: [
                            {'text': 'Yes', 'value':'1'},
                            {'text': 'No', 'value':'0'},
                         ],
            durationOptions: [
                            {'text': '1 Month', 'value':'30'},
                            {'text': '3 Months', 'value':'90'},
                            {'text': '6 Months', 'value':'180'},
                            {'text': '9 Months', 'value':'270'},
                            {'text': '1 Year', 'value':'360'},
                            {'text': 'Unlimited', 'value':'0'},
                         ],

            numOptions: [
                            {'text': '1', 'value':'1'},
                            {'text': '10', 'value':'10'},
                            {'text': '15', 'value':'15'},
                            {'text': '20', 'value':'20'},
                            {'text': '50', 'value':'50'},
                            {'text': '1000', 'value':'100'},
                            {'text': 'Unlimited', 'value':'0'},
                         ],


            forms: {
                addPlan: new SparkForm ({
                    name: '',
                    description: '',
                    cost: 0,
                    num_posts: 1,
                    num_notifications: 1,
                    feature_job: 0,
                    feature_company: 0,
                    duration: 0,
                    start_date: new Date(),
                    end_date: '',
                }),

                updatePlan: new SparkForm ({
                    id: '',
                    name: '',
                    description: '',
                    cost: 0,
                    num_posts: '',
                    num_notifications: '',
                    feature_job: '',
                    feature_company: '',
                    duration: '',
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
            return this.plans != null;
        }
    },

    methods: {
        addPlan: function () {
            this.forms.addPlan.name = '';
            this.forms.addPlan.description = '';
            this.forms.addPlan.cost = 0;
            this.forms.addPlan.num_posts = 10;
            this.forms.addPlan.num_notifications = 10;
            this.forms.addPlan.feature_job = 0;
            this.forms.addPlan.feature_company = 0;
            this.forms.addPlan.duration = 0;
            this.forms.addPlan.start_date = '';
            this.forms.addPlan.end_date = '';
            this.forms.addPlan.errors.forget();
            $('#modal-add-plan').modal('show');
        },
        editPlan: function (plan) {
            this.editingPlan = plan;
            this.forms.updatePlan.id = plan.id
            this.forms.updatePlan.name = plan.name
            this.forms.updatePlan.description = plan.description;
            this.forms.updatePlan.cost = plan.cost;
            this.forms.updatePlan.num_posts = plan.num_posts;
            this.forms.updatePlan.num_notifications = plan.num_notifications;
            this.forms.updatePlan.feature_job = plan.feature_job;
            this.forms.updatePlan.feature_company = plan.feature_company;
            this.forms.updatePlan.duration = plan.duration;
            this.forms.updatePlan.start_date = plan.start_date;
            this.forms.updatePlan.end_date = plan.end_date; 
            this.forms.updatePlan.errors.forget();
            $('#modal-edit-plan').modal('show');
        },

        removingPlan: function(id) { return (this.removingPlanId == id); },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) {
                return i.id === item.id;
            });
        },

        // Ajax calls
        addNewPlan: function () {
            var self = this;
            Spark.post(self.baseUrl+'plans', this.forms.addPlan)
                .then(function () {
                    $('#modal-add-plan').modal('hide');
                    bus.$emit('updatePlans');
            }, function(resp) {
                    self.forms.addPlan.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },
        updatePlan: function () {
            var self = this;
            Spark.put(self.baseUrl+'plans/' + this.editingPlan.id, this.forms.updatePlan)
                .then(function () {
                    bus.$emit('updatePlans');
                    $('#modal-edit-plan').modal('hide');
                });
        },
        removePlan: function (plan) {
            var self = this;
            self.removingPlanId = plan.id;

            this.$http.delete(self.baseUrl+'plans/' + plan.id)
                .then(function () {
                    self.removingPlanId = 0;
                    self.plans = self.removeFromList(this.plans, plan);
                    bus.$emit('updatePlans');
                }, function(resp) {
                    self.removingPlanId = 0;
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },

        setupListeners: function () {
            var self = this;
            bus.$on('plansSet', function (items) {
                //console.log("Got plans in "+ self.modname);
                self.plans = items;
            });
            bus.$emit('screenLoaded',self.modname);

        },

    },

    filters: {
        infinite_check: function (value) {
            return (value==0) ? 'Unlimited' : value;
        },
        feature_check: function (value) {
            return (value==0) ? 'No' : 'Yes';
        },
        duration_text: function (value) {
            if (value==0) { return 'Unlimited'; }
            if (value==360) { return '1 Year'; }
            if (value==30) { return '1 Month'; }
            return (value / 30) + ' Months';
        },
    },
});
