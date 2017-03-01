var _moment = require('moment');

Vue.component('spark-profile-work', {
    props: ['userid','work','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <a class="btn btn-sm btn-info btn-addon pull-right" @click.prevent="addItem()"><i class="fa fa-plus"></i> Add</a>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Company</th><th>Title</th><th>Duration</th><th>Where</th><th></th></tr></thead>\
                        <tbody>\
                            <tr v-for="i in list">\
                                <td class="spark-table-pad">{{ i.company}}</td>\
                                <td class="spark-table-pad">{{ i.title }}</td>\
                                <td class="spark-table-pad">{{ format_start_date(i.start_date) }} to {{ format_end_date(i) }}</td>\
                                <td class="spark-table-pad">{{ getLocation(i) }}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editItem(i)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeItem(i)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                     </table>\
                  </div>\
                  <div class="modal fade" id="modal-add-item" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Experience</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Company\'" \
                                                          :form="forms.addForm" \
                                                          :name="\'company\'" \
                                                          :placeholder="\'e.g. MTN\'" \
                                                          :input="forms.addForm.company">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Title\'" \
                                                          :form="forms.addForm" \
                                                          :name="\'title\'" \
                                                          :placeholder="\'e.g. Sales Representative\'" \
                                                          :input="forms.addForm.title">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-textarea :id="\'addDescription\'"\
                                                           :display="\'Description\'" \
                                                           :form="forms.addForm" \
                                                           :name="\'description\'" \
                                                           :placeholder="\'What did you do for the company?\'" \
                                                           :input="forms.addForm.description">\
                                              </gl-textarea>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-location :id="\'addWorkLoc\'"\
                                                           :display="\'Location\'" \
                                                           :form="forms.addForm" \
                                                           :name="\'country\'" \
                                                           :placeholder="\'e.g. Accra, Ghana\'">\
                                              </gl-location>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-4">\
                                              <gl-date :display="\'Start Date\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'start_date\'" \
                                                            :start="addStart"\
                                                            :input="forms.addForm.start_date" v-model="addSD">\
                                              </gl-date>\
                                          </div>\
                                          <div class="col-md-4">\
                                              <gl-date :display="\'End Date\'" \
                                                       :form="forms.addForm" \
                                                       :name="\'end_date\'" \
                                                       :start="addeStart"\
                                                       :input="forms.addForm.end_date" v-model="addED">\
                                              </gl-date>\
                                          </div>\
                                          <div class="col-md-4">\
                                              <gl-checkbox :display="\'Current?\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'current\'" \
                                                            :input="forms.addForm.current">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewItem()" :disabled="forms.addForm.busy">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
                  <div class="modal fade" id="modal-edit-item" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update Education</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.updateForm"></gl-error-alert>\
                                  <form class="form-horizontal" role="form">\
                                   <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Company\'" \
                                                          :form="forms.updateForm" \
                                                          :name="\'company\'" \
                                                          :placeholder="\'e.g. MTN\'" \
                                                          :input.sync="forms.updateForm.company">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Title\'" \
                                                          :form="forms.updateForm" \
                                                          :name="\'title\'" \
                                                          :placeholder="\'e.g. Sales Representative\'" \
                                                          :input.sync="forms.updateForm.title">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-textarea :id="\'editDescription\'"\
                                                           :display="\'Description\'" \
                                                           :form="forms.updateForm" \
                                                           :name="\'description\'" \
                                                           :placeholder="\'What did you do for the company?\'" \
                                                           :input.sync="forms.updateForm.description">\
                                              </gl-textarea>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-location :id="\'editWorkLoc\'"\
                                                           :display="\'Location\'" \
                                                           :form="forms.updateForm" \
                                                           :name="\'country\'" \
                                                           :input="loc">\
                                                           :placeholder="\'e.g. Accra, Ghana\'">\
                                              </gl-location>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-4">\
                                              <gl-date :display="\'Start Date\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'start_date\'" \
                                                            :start="editStart"\
                                                            :input.sync="forms.updateForm.start_date" >\
                                              </gl-date>\
                                          </div>\
                                          <div class="col-md-4">\
                                              <gl-date :display="\'End Date\'" \
                                                       :form="forms.updateForm" \
                                                       :name="\'end_date\'" \
                                                       :start="editeStart"\
                                                       :input.sync="forms.updateForm.end_date">\
                                              </gl-date>\
                                          </div>\
                                          <div class="col-md-4">\
                                              <gl-checkbox :display="\'Current?\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'current\'" \
                                                            :input.sync="forms.updateForm.current">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateItem()" :disabled="forms.updateForm.busy">\
                                      <span v-if="forms.updateForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
               </div>',

    mounted: function () {
        this.list = this.work;
        this.setupListeners();
    },

    watch: { 
        //'addED': function(v) { console.log('edit start changed'); },
        //'editED': function(v) { console.log('update start changed'); }
    },

    events: {},

    notifications: {
      showError: {
          title: 'Work Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Work success',
          message: 'Successfully modified work experience',
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

            addStart: _moment('1950-01-01').format('YYYY-MM-DD'),
            addeStart: _moment('1950-01-01').format('YYYY-MM-DD'),
            editStart: _moment('1950-01-01').format('YYYY-MM-DD'),
            editeStart: _moment('1950-01-01').format('YYYY-MM-DD'),
            addSD: '', addED: '', editSD: '', editED: '',
            loc:'',

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    company:'',
                    title:'',
                    description:'',
                    country:'',
                    city:'',
                    start_date:'',
                    end_date:'',
                    current:'',
                    visible: 1,
                }),
                updateForm: new SparkForm ({
                    id:'',
                    user_id:'',
                    company:'',
                    title:'',
                    description:'',
                    country:'',
                    city:'',
                    loc:'',
                    neighborhood:'',
                    start_date:'',
                    end_date:'',
                    current:'',
                    visible: 1,
                }),
            },
        }
    },

    methods: {
        setList: function(l) { this.list = l; },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        getLocation: function(e) {
            return [e.neighborhood, e.city, e.country].join(', ');
        },

        addItem: function(e) {
            this.forms.addForm.user_id = this.userid;
            this.forms.addForm.company = '';
            this.forms.addForm.title = '';
            this.forms.addForm.description = '';
            this.forms.addForm.neighborhood = '';
            this.forms.addForm.country = '';
            this.forms.addForm.city = '';
            this.forms.addForm.start_date = '';
            this.forms.addForm.end_date = '';
            this.forms.addForm.current = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-item').modal('show');
        },

        editItem: function(e) {
            this.loc = this.getLocation(e);
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.user_id = e.user_id;
            this.forms.updateForm.company = e.company;
            this.forms.updateForm.title = e.title;
            this.forms.updateForm.description = e.description;
            this.forms.updateForm.country = e.country;
            this.forms.updateForm.city = e.city;
            this.forms.updateForm.neighborhood = e.neighborhood;
            this.forms.updateForm.current = e.current;
            this.forms.updateForm.start_date = e.start_date;
            this.forms.updateForm.end_date = e.end_date;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-item').modal('show');
        },

        addNewItem: function () {
            var self = this;
            Spark.post(self.baseUrl+'profiles/users/experience', this.forms.addForm)
                .then(function () {
                    $('#modal-add-item').modal('hide');
                    self.showSuccess({message:'New work item added to  experience'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateItem: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'profiles/users/experience/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-item').modal('hide');
                    self.showSuccess({message:'Work Experience updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeItem: function (e) {
            var self = this;
            this.$http.delete(self.baseUrl+'profiles/users/experience/' + e.id)
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
            bus.$on('authUserSet', function (user) { self.setList(user.work); });
        },
        format_start_date: function(v) {
            return _moment(v).format('MMMM Do, YYYY');
        },
        format_end_date: function(v) {
            return (v.current) ? 'Present' : _moment(v.end_date).format('MMMM Do, YYYY');
        }
    },

    filters: { },

});
