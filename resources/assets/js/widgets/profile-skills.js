//TODO: move to  multiselect comppnent
Vue.component('spark-profile-skills', {
    props: ['userid','skills','title'],

    components: {
        Multiselect
    },

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <multiselect :options="skillsList" :multiple="true" :hide-selected="true"\
                                 :value="multiCSK_val" v-model="multiCSK"\
                                 :close-on-select="true" placeholder="Choose skills..."\
                                 label="name" key="id">\
                </div>\
               </div>',

    mounted: function () {
        this.setList(this.skills);
        this.setupListeners();
    },

    watch: { 
        'multiCSK': function (nw) {
            var vals = '';
            for (var i = 0; i < nw.length; i++) {
                vals += nw[i].name + ((i < nw.length - 1) ? ',' : '');
            }
            if (this.isEditMode) { this.updateSkills(vals); } 
            else { this.addSkills(vals); }
        },
    
    },

    computed: {
        isEditMode: function() { return (this.mode=='edit'); }
    },

    events: {},

    notifications: {
      showError: { title: 'Skills Error', message: 'Failed to reach server', type: 'error' },
      showSuccess: { title: 'Skills success', message: 'Successfully modified skills', type: 'success' },
    },

    data: function () {
        return {
            baseUrl: '/',
            mode: 'add',
            
            id: '',
            list: [],
            skillsList: [],
            multiCSK: [],
            multiCSK_val: '',

            forms: {
                addForm: new SparkForm ({ user_id:'', skills:'', visible: 1, }),
                updateForm: new SparkForm ({ id:'', user_id:'', skills:'', visible: 1, }),
            },
        }
    },

    methods: {
        setList: function(l) { 
            this.list = l; 
            if (this.list!=null && this.list.length>0) {
                this.mode = 'edit';
                this.id = this.list[0].id;
                this.multiCSK_val = this.getMultiValues(this.list[0].skills);
            }
        },

        getMultiValues: function (value) {
            var self = this;
            var vals = (typeof value == 'undefined') ? [] : value.split(',');
            $.each(vals, function(i, v) {  vals[i] = {id:v, name:v}});
            return vals;
        },

        addSkills: function(skills) {
            var self = this;
            this.forms.addForm.user_id = this.userid;
            this.forms.addForm.skills = skills;

            Spark.post(self.baseUrl+'profiles/users/skill', this.forms.addForm)
                .then(function () {
                    self.showSuccess({message:'New work item added to skills'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateSkills: function(skills) {
                this.forms.updateForm.id = this.id;
                this.forms.updateForm.user_id = this.userid;
                this.forms.updateForm.skills = skills;

                var self = this;
                Spark.put(self.baseUrl+'profiles/users/skill/' + this.id, this.forms.updateForm)
                    .then(function () {
                        self.showSuccess({message:'Skills updated'});
                        bus.$emit('updateAuthUser');
                    }, function(resp){
                        self.forms.updateForm.busy = false;
                        self.showError({'message': resp.error[0]});
                    });
        },

        isInArray: function (item, array) {
            return !!~$.inArray(item, array);
        },

        setupListeners: function () {
            var self = this;
            bus.$on('allLoaded', function() { });
            bus.$on('skillsSet', function (items) { self.skillsList = items; });
        },
    },
    filters: { },
});
