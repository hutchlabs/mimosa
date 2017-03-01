Vue.component('spark-profile-preferences', {
    props: ['userid','preferences','title'],

    components: {
        Multiselect
    },

    template: '<div><div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">Job Types</h4>\
                    <br/>\
                    <multiselect :options="jtList" :multiple="true" :hide-selected="true"\
                                 :value="jtVal" v-model="jt"\
                                 :close-on-select="true" placeholder="Choose preferred job types..."\
                                 label="name" key="id"></multiselect>\
                </div>\
              </div>\
              <div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">Area of Work</h4>\
                    <br/>\
                    <multiselect :options="jpList" :multiple="true" :hide-selected="true"\
                                 :value="jpVal" v-model="jp"\
                                 :close-on-select="true" placeholder="Choose preferred work areas..."\
                                 label="name" key="id"></multiselect>\
                </div>\
              </div>\
              <div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">Countries</h4>\
                    <br/>\
                    <multiselect :options="cList" :multiple="true" :hide-selected="true"\
                                 :value="cVal" v-model="c"\
                                 :close-on-select="true" placeholder="Choose preferred countries..."\
                                 label="name" key="id"></multiselect>\
                                 <br/>\
                        <gl-checkbox :display="\'Remote?\'" \
                            :form="forms.addForm" \
                            :name="\'remote_work\'" \
                            :input.sync="forms.addForm.remote_work" >\
                        </gl-select>\
                    </div>\
                </div>\
                </div>\
                </div>\
               </div>',

    mounted: function () {
        this.setList(this.preferences);
        this.setupListeners();
    },

    watch: { 
        'jt': function (nw) { if (this.isEditMode) { this.updatePreferences(); } else { this.addPreferences(); } },
        'jp': function (nw) { if (this.isEditMode) { this.updatePreferences(); } else { this.addPreferences(); } },
        'c': function (nw) { if (this.isEditMode) { this.updatePreferences(); } else { this.addPreferences(); } },
        'forms.addForm.remote_work': function (nw) { if (this.isEditMode) { this.updatePreferences(); } else { this.addPreferences(); } },
    },

    computed: {
        isEditMode: function() { return (this.mode=='edit'); }
    },

    events: {},

    notifications: {
      showError: { title: 'Preferences Error', message: 'Failed to reach server', type: 'error' },
      showSuccess: { title: 'Preferences success', message: 'Successfully modified preferences', type: 'success' },
    },

    data: function () {
        return {
            baseUrl: '/',
            mode: 'add',
            
            id: '',

            prefs: [],
            jt:[], jp:[], c:[],
            jtVal: '', jpVal:'', cVal:'',
            jtList: [], jpList: [], cList: [],

            forms: {
                addForm: new SparkForm ({ user_id:'', job_types:'', positions:'', countries:'', remote_work:''}),
                updateForm: new SparkForm ({ id:'', user_id:'', job_types:'', positions:'', countries:'', remote_work:''}),
            },
        }
    },

    methods: {
        setList: function(l) { 
            this.prefs = l; 
            if (this.prefs!=null) {
                this.mode = 'edit';
                this.id = this.prefs.id;
                this.jtVal = this.getValuesAsArray(this.prefs.job_types);
                this.jpVal = this.getValuesAsArray(this.prefs.job_positions);
                this.cVal = this.getValuesAsArray(this.prefs.countries);
                this.forms.addForm.remote_work = this.prefs.remote_work;
            }
        },

        getValuesAsArray: function (value) {
            var self = this;
            var vals = (typeof value == 'undefined' || value==null) ? [] : value.split(',');
            $.each(vals, function(i, v) {  vals[i] = {id:v, name:v}});
            return vals;
        },

        getValuesAsString: function(nw) {
            var vals = '';
            for (var i = 0; i < nw.length; i++) { vals += nw[i].name + ((i < nw.length - 1) ? ',' : ''); }
            return vals;
        },

        addPreferences: function(skills) {
            var self = this;
            this.forms.addForm.user_id = this.userid;
            this.forms.addForm.job_types = this.getValuesAsString(this.jt);
            this.forms.addForm.positions = this.getValuesAsString(this.jp);
            this.forms.addForm.countries = this.getValuesAsString(this.c);

            Spark.post(self.baseUrl+'profiles/users/preference', this.forms.addForm)
                .then(function () {
                    self.showSuccess({message:'Preference added'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updatePreferences: function(skills) {
            this.forms.updateForm.id = this.id;
            this.forms.updateForm.user_id = this.userid;
            this.forms.updateForm.job_types = this.getValuesAsString(this.jt);
            this.forms.updateForm.positions = this.getValuesAsString(this.jp);
            this.forms.updateForm.countries = this.getValuesAsString(this.c);
            this.forms.updateForm.remote_work = this.forms.addForm.remote_work;

            var self = this;
            Spark.put(self.baseUrl+'profiles/users/preference/' + this.id, this.forms.updateForm)
                    .then(function () {
                        //self.showSuccess({message:'Preferences updated'});
                        bus.$emit('updateAuthUser');
                    }, function(resp){
                        self.forms.updateForm.busy = false;
                        self.showError({'message': resp.error[0]});
                    });
        },

        setupListeners: function () {
            var self = this;
            bus.$on('allLoaded', function() { });

            bus.$on('jobTypesSet', function (items) {
                self.jtList = [];
                $.each(items, function(i,j){ self.jtList.push({id:j.name, name:j.name}); });
            });

            bus.$on('industriesSet', function (items) {
                self.jpList = [];
                $.each(items, function(i,j){ self.jpList.push({id:j.name, name:j.name}); });
            });

            bus.$on('countriesSet', function (items) {
                self.cList = [];
                $.each(items, function(i,j){ self.cList.push({id:j.name, name:j.name}); });
            });
        },
    },
    filters: { },
});
