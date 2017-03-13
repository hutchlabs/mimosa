Vue.component('gradlead-alert', {
    props: ['authUser'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <a class="btn btn-sm btn-info btn-addon pull-right" @click.prevent="addAlert()"><i class="fa fa-plus"></i> Add</a>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Name</th><th>Jobs</th><th>Created</th><th></th></tr></thead>\
                        <tbody>\
                            <tr v-for="e in list">\
                                <td class="spark-table-pad">{{ e.name }}</td>\
                                <td class="spark-table-pad">{{ e.jobs.length }} jobs</td>\
                                <td class="spark-table-pad">{{ e.created_at }}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editAlert(e)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeAlert(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                     </table>\
                  </div>\
                  <div class="modal fade" id="modal-add-alert" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Alert</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Name*\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'name\'" \
                                                            :input="forms.addForm.name">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Country\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'country\'" \
                                                            :items="countryOptions" \
                                                            :input="forms.addForm.country">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Degree\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'degree_level\'" \
                                                            :items="degreeOptions" \
                                                            :input="forms.addForm.degree_level">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Major\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'degree_major\'" \
                                                            :items="majorOptions" \
                                                            :input="forms.addForm.degree_major">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Graduation Month\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'graduation_month\'" \
                                                            :items="monthOptions" \
                                                            :input="forms.addForm.graduation_month">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Graduation Year\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'graduation_year\'" \
                                                            :items="yearOptions" \
                                                            :input="forms.addForm.graduation_year">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'GPA\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'gpa\'" \
                                                            :placeholder="\'Enter GPA\'"\
                                                            :input="forms.addForm.gpa">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewAlert()" :disabled="forms.addForm.busy">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
                  <div class="modal fade" id="modal-edit-alert" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update Alert</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.updateForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'University\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'university\'" \
                                                            :items="universityOptions" \
                                                            :input.sync="forms.updateForm.university">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Country\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'country\'" \
                                                            :items="countryOptions" \
                                                            :input.sync="forms.updateForm.country">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Degree Level\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'degree_level\'" \
                                                            :items="degreeOptions" \
                                                            :input.sync="forms.updateForm.degree_level">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Major\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'degree_major\'" \
                                                            :items="majorOptions" \
                                                            :input.sync="forms.updateForm.degree_major">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Graduation Month\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'graduation_month\'" \
                                                            :items="monthOptions" \
                                                            :input.sync="forms.updateForm.graduation_month">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Graduation Year\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'graduation_year\'" \
                                                            :items="yearOptions" \
                                                            :input.sync="forms.updateForm.graduation_year">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'GPA\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'gpa\'" \
                                                            :placeholder="\'Enter GPA\'"\
                                                            :input.sync="forms.updateForm.gpa">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateAlert()" :disabled="forms.updateForm.busy">\
                                      <span v-if="forms.updateForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
               </div>',

    mounted: function () {
        var self = this;
        this.list = this.authUser.alerts;
        this.setupListeners();
    },

    watch: {},

    events: {},

    notifications: {
      showError: {
          title: 'Alert Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Alert success',
          message: 'Successfully modified alert',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',

            list: [],

            freqOptions: [
                {text:'Daily', value:'daily'},
                {text:'Weekly', value:'Weekly'},
                {text:'Monthly', value:'Monthly'},
            ],

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    name:'',
                    country:'',
                    city:'',
                    neighborhood:'',
                    job_type:'',
                    category:'',
                    language:'',
                    frequency:'',
                }),
                updateForm: new SparkForm ({
                    id:'',
                    user_id:'',
                    name:'',
                    country:'',
                    city:'',
                    neighborhood:'',
                    job_type:'',
                    category:'',
                    language:'',
                    frequency:'',
                }),
            },
        }
    },

    methods: {
        setList: function(l) { this.list = l; },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        addAlert: function(e) {
            this.forms.addForm.user_id = this.authUser.id;
            this.forms.addForm.name = '';
            this.forms.addForm.country = 'Ghana';
            this.forms.addForm.city = '';
            this.forms.addForm.neighborhood = '';
            this.forms.addForm.job_type = '';
            this.forms.addForm.category = '';
            this.forms.addForm.language = '';
            this.forms.addForm.frequency = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-alert').modal('show');
        }

        editAlert: function(e) {
            this.forms.updateForm.user_id = this.authUser.id;
            this.forms.updateForm.name = e.name;
            this.forms.updateForm.country = e.country;;
            this.forms.updateForm.city = e.city;
            this.forms.updateForm.neighborhood = e.neighborhood;;
            this.forms.updateForm.job_type = e.job_type;
            this.forms.updateForm.category = e.category;
            this.forms.updateForm.language = e.language;
            this.forms.updateForm.frequency = e.frequency;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-alert').modal('show');
        },

        addNewAlert: function () {
            var self = this;
            Spark.post(self.baseUrl+'users/alert', this.forms.addForm)
                .then(function () {
                    $('#modal-add-alert').modal('hide');
                    self.showSuccess({message:'New alert added'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateAlert: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'users/alert/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-alert').modal('hide');
                    self.showSuccess({message:'Alert updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeAlert: function (e) {
            var self = this;

            this.$http.delete(self.baseUrl+'users/alert/' + e.id)
                .then(function () {
                    self.list = self.removeFromList(this.list, e);
                    self.showSuccess();
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.showError({'message': resp.error[0]});
                });
        },

        setupListeners: function () {
            var self = this;

            bus.$on('allLoaded', function() { });

            bus.$on('authUserSet', function (user) { self.setList(user.alerts); });

            bus.$on('languagesSet', function (items) {
                self.languages = items;
            });

            bus.$on('jobTypesSet', function (items) {
                self.jobTypes = items;
            });

            bus.$on('skillsSet', function (items) {
                self.skills = items;
            });
            
        },
    }
});
