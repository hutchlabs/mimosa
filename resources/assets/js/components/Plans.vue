Vue.component('gradlead-plans-screen', {
    props: ['authUser', 'usertype', 'permissions'],

    components: {
        Datepicker
    },

    mounted: function() {
        this.contracts = this.authUser.organization.contracts;
            this.contracts.sort(function(a,b) { 
                    var x = (a.expired) ? 1 : 0; 
                    var y = (b.expired) ? 1 : 0; 
                    return (x < y) ? -1 : ((x > y) ? 1 : 0);
            });
        this.setupListeners();
    },

    data: function() {
        return {
            baseUrl: '/',
            modname: 'Plans',
            
            plans: [],
            contracts: [],

            editingPlan: {'name':'none'},
            removingPlanId: null,

            availablePlans: [],

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

                addContract: new SparkForm ({
                    'organization_id': '',
                    'plan_id': '',
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
   
    watch: {
        'contracts': function() {
        }
    },

    events: { },

    computed: {
        everythingLoaded: function () {
            return this.authUser != null && this.plans != null;
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

        addContract: function () {
            var self = this;

            this.forms.addContract.organization_id = this.authUser.organization_id;

            Spark.post(self.baseUrl+'plans/contracts', this.forms.addContract)
                .then(function () {
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
            }, function(resp) {
                    self.forms.addContract.busy = false;
                    NotificationStore.addNotification({ text: resp.statusText, type: "btn-danger", timeout: 5000,});
                });
        },

        removeContract: function (contract) {
            var self = this;

            this.$http.delete(self.baseUrl+'plans/contracts/' + contract.id)
                .then(function () {
                    self.contracts = self.removeFromList(self.contracts, contract);
                    bus.$emit('updateAuthUser');
                    bus.$emit('updateOrganizations');
                }, function(resp) {
                    NotificationStore.addNotification({ text: resp.error[0], type: "btn-danger", timeout: 5000,});
                });
        },

        setAvailablePlans: function () {
                var self = this;
                if (this.plans.length > 0) {
                    this.availablePlans = [];
                    $.each(this.plans, function (idx, plan) {
                        //if (!plan.expired && plan.id != 1 && self.noContract(plan.id)) {
                        if (!plan.expired && plan.id != 1) {
                            var posts = (plan.num_posts == 0) ? 'Unlimited' : plan.num_posts;
                            var name = 'New Plan: ' + plan.name + ' | Posts: ' + posts + ' | Price: GHC ' + plan.cost;
                            self.availablePlans.push({'text': name, 'value':plan.id});
                        }
                    });
                }
        },

        noContract: function (planid) {
            var cin = true;
            $.each(this.contracts, function (i, c) { if (planid == c.plan.id) { cin = false; } });
            return cin;
        },

        setupListeners: function () {
            var self = this;
            bus.$on('plansSet', function (items) { 
                self.plans = items; 
                self.setAvailablePlans();
            });

            bus.$on('authUserSet', function (user) { 
                self.contracts = user.organization.contracts;
                self.contracts.sort(function(a,b) { 
                    var x = (a.expired) ? 1 : 0; 
                    var y = (b.expired) ? 1 : 0; 
                    return (x < y) ? -1 : ((x > y) ? 1 : 0);
                });
                self.setAvailablePlans();
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
        expiry_check: function (value) {
            return (value) ? 'Yes' : 'No';
        },
        duration_text: function (value) {
            if (value==0) { return 'Unlimited'; }
            if (value==360) { return '1 Year'; }
            if (value==30) { return '1 Month'; }
            return (value / 30) + ' Months';
        },
    },
});
