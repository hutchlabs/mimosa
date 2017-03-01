Vue.component('spark-profile-education', {
    props: ['userid','education','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <a class="btn btn-sm btn-info btn-addon pull-right" @click.prevent="addEdu()"><i class="fa fa-plus"></i> Add</a>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>University</th><th>Degree</th><th>Graduation</th><th></th></tr></thead>\
                        <tbody>\
                            <tr v-for="e in list">\
                                <td class="spark-table-pad">{{ e.university}}, {{ e.country }}</td>\
                                <td class="spark-table-pad">{{ e.degree_level }} in {{ e.degree_major }}</td>\
                                <td class="spark-table-pad">Graduation {{ getMonthName(e.graduation_month) }} {{ e.graduation_year}}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editEdu(e)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeEdu(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                     </table>\
                  </div>\
                  <div class="modal fade" id="modal-add-edu" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Education</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'University\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'university\'" \
                                                            :items="universityOptions" \
                                                            :input="forms.addForm.university">\
                                              </gl-select>\
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
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewEdu()" :disabled="forms.addForm.busy">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
                  <div class="modal fade" id="modal-edit-edu" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update Education</h4>\
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
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateEdu()" :disabled="forms.updateForm.busy">\
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

        this.list = this.education;

        var today = new Date();
        var cy = today.getFullYear();
        for (var i = cy-10; i < (cy + 30); i++) {
            this.yearOptions.push({text: i, value: i});
        }

        this.setupListeners();
    },

    watch: {},

    events: {},

    notifications: {
      showError: {
          title: 'Education Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Education success',
          message: 'Successfully modified education',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',

            list: [],

            universityOptions: [],
            countryOptions: [],
            degreeOptions:[],
            majorOptions:[],
            yearOptions: [],
            monthOptions: [
                { text:'January', value:1},
                { text:'February', value:2},
                { text:'March', value:3},
                { text:'April', value:4},
                { text:'May', value:5},
                { text:'June', value:6},
                { text:'July', value:7},
                { text:'August', value:8},
                { text:'September', value:9},
                { text:'October', value:11},
                { text:'November', value:11},
                { text:'January', value:12},
            ],

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    university:'',
                    country:'',
                    degree_level:'',
                    degree_major:'',
                    graduation_month:'',
                    graduation_year:'',
                    visible: 1,
                }),
                updateForm: new SparkForm ({
                    id:'',
                    user_id:'',
                    university:'',
                    country:'',
                    degree_level:'',
                    degree_major:'',
                    graduation_month:'',
                    graduation_year:'',
                    visible: 1,
                }),
            },
        }
    },

    methods: {
        setList: function(l) {
            this.list = l;
            console.log("Updating user list");
        },

        getMonthName: function(m) {
                return $.grep(this.monthOptions, function(i, mn) {
                        return (mn.text==m);
                }).text;
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        addEdu: function(e) {
            this.forms.addForm.user_id = this.userid;
            this.forms.addForm.university = '';
            this.forms.addForm.country = 'Ghana';
            this.forms.addForm.degree_level = '';
            this.forms.addForm.degree_major = '';
            this.forms.addForm.graduation_month = '';
            this.forms.addForm.graduation_year = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-edu').modal('show');
        },

        editEdu: function(e) {
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.user_id = e.user_id;
            this.forms.updateForm.university = e.university;
            this.forms.updateForm.country = e.country;
            this.forms.updateForm.degree_level = e.degree_level;
            this.forms.updateForm.degree_major = e.degree_major;
            this.forms.updateForm.graduation_month = e.graduation_month;
            this.forms.updateForm.graduation_year = e.graduation_year;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-edu').modal('show');
        },

        addNewEdu: function () {
            var self = this;
            Spark.post(self.baseUrl+'profiles/users/education', this.forms.addForm)
                .then(function () {
                    $('#modal-add-edu').modal('hide');
                    self.showSuccess({message:'New school added to  education'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateEdu: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'profiles/users/education/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-edu').modal('hide');
                    self.showSuccess({message:'Education updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeEdu: function (e) {
            var self = this;

            this.$http.delete(self.baseUrl+'profiles/users/education/' + e.id)
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

            bus.$on('authUserSet', function (user) { self.setList(user.education); });

            bus.$on('universitiesSet', function (items) {
                self.universityOptions = [];
                $.each(items, function(i,j){
                    self.universityOptions.push({text:j.name, value:j.name});
                });
            });

            bus.$on('countriesSet', function (items) {
                self.countryOptions = [];
                $.each(items, function(i,j){
                    self.countryOptions.push({text:j.name, value:j.name});
                });
            });

            bus.$on('degreesSet', function (items) {
                self.degreeOptions = [];
                $.each(items, function(i,j){
                    self.degreeOptions.push({text:j.name, value:j.name});
                });
            });

            bus.$on('majorsSet', function (items) {
                self.majorOptions = [];
                $.each(items, function(i,j){
                    self.majorOptions.push({text:j.name, value:j.name});
                });
            });
        },
    }
});
