Vue.component('gradlead-alert', {
    props: ['authUser'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <a class="btn btn-sm btn-info btn-addon" @click.prevent="addAlert()"><i class="fa fa-plus"></i> Add</a>\
                    <br/><br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Name</th><th>Jobs Matched</th><th>Created</th><th></th></tr></thead>\
                        <tbody v-if="list.length>0">\
                            <tr v-for="e in list">\
                                <td class="spark-table-pad">{{ e.name }}</td>\
                                <td class="spark-table-pad"><a :href="e.link" style="color:#336699">{{ e.jobs.length }} jobs</a></td>\
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
                        <tbody v-else><tr><td colspan="4">No alerts set</td></tr></tbody>\
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
                                              <gl-select :display="\'Frequency*\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'frequency\'" \
                                                            :items="freqOptions" \
                                                            :input="forms.addForm.frequency">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-location :id="\'addAlertLoc\'"\
                                                           :display="\'Location (Area or City or Country)\'" \
                                                           :form="forms.addForm" \
                                                           :name="\'location\'"\
                                                           :input="location"\
                                                           :placeholder="\'e.g. Accra, Ghana\'">\
                                              </gl-location>\
                                          </div>\
                                          <div class="col-md-6">\
                                                <gl-multiselect :display="\'Languages\'" :form="forms.addForm" :name="\'language\'" :input="forms.addForm.language" :multiple="true" :items="languages" :placetext="\'Choose languages...\'"></gl-multiselect>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                                <gl-multiselect :display="\'Job Types\'" :form="forms.addForm" :name="\'jobtype\'" :input="forms.addForm.jobtype" :multiple="true" :items="jobtypes" :placetext="\'Choose preferred job types...\'"></gl-multiselect>\
                                          </div>\
                                          <div class="col-md-6">\
                                                <gl-multiselect :display="\'Industries\'" :form="forms.addForm" :name="\'category\'" :input.sync="forms.addForm.category" :multiple="true" :items="industries" :placetext="\'Choose area of work...\'"></gl-multiselect>\
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
                                              <gl-text :display="\'Name*\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'name\'" \
                                                            :input.sync="forms.updateForm.name">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Frequency*\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'frequency\'" \
                                                            :items="freqOptions" \
                                                            :input.sync="forms.updateForm.frequency">\
                                              </gl-select>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-location :id="\'updateAlertLoc\'"\
                                                           :display="\'Location (Area or City or Country)\'" \
                                                           :form="forms.updateForm" \
                                                           :name="\'location\'" \
                                                           :input.sync="location"\
                                                           :placeholder="\'e.g. Accra, Ghana\'">\
                                              </gl-location>\
                                          </div>\
                                          <div class="col-md-6">\
                                                <gl-multiselect :display="\'Languages\'" :form="forms.updateForm" :name="\'language\'" :input.sync="forms.updateForm.language" :multiple="true" :items="languages" :placetext="\'Choose languages...\'"></gl-multiselect>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                                <gl-multiselect :display="\'Job Types\'" :form="forms.updateForm" :name="\'jobtype\'" :input.sync="forms.updateForm.jobtype" :multiple="true" :items="jobtypes" :placetext="\'Choose preferred job types...\'"></gl-multiselect>\
                                          </div>\
                                          <div class="col-md-6">\
                                                <gl-multiselect :display="\'Industries\'" :form="forms.updateForm" :name="\'category\'" :input.sync="forms.updateForm.category" :multiple="true" :items="industries" :placetext="\'Choose area of work...\'"></gl-multiselect>\
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
            location: [],
            languages: [],
            industries: [],
            jobtypes: [],

            freqOptions: [
                {text:'Daily', value:'daily'},
                {text:'Weekly', value:'weekly'},
                {text:'Monthly', value:'monthly'},
            ],

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    name:'',
                    country:'',
                    city:'',
                    neighborhood:'',
                    jobtype:'',
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
                    jobtype:'',
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

        getLocation: function(e) {
            var add = [];
            //if (e.street!='') { add.push(e.street); }
            if (e.neighborhood!='') { add.push(e.neighborhood); }
            if (e.city!='') { add.push(e.city); }
            if (e.country!='') { add.push(e.country); }
            return (add.length>0) ? add.join(', ') : '';
        },

        addAlert: function(e) {
            this.location='';
            this.forms.addForm.user_id = this.authUser.id;
            this.forms.addForm.name = '';
            this.forms.addForm.country = '';
            this.forms.addForm.city = '';
            this.forms.addForm.neighborhood = '';
            this.forms.addForm.jobtype = '';
            this.forms.addForm.category = '';
            this.forms.addForm.language = '';
            this.forms.addForm.frequency = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-alert').modal('show');
        },

        editAlert: function(e) {
            this.location = this.getLocation(e);
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.user_id = this.authUser.id;
            this.forms.updateForm.name = e.name;
            this.forms.updateForm.country = e.country;
            this.forms.updateForm.city = e.city;
            this.forms.updateForm.neighborhood = e.neighborhood;;
            this.forms.updateForm.jobtype = e.job_type;
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

            bus.$on('languagesSet', function (items) { self.languages = items; });
            bus.$on('industriesSet', function (items) { self.industries = items; });
            bus.$on('jobTypesSet', function (items) { self.jobtypes = items; });
        },
    }
});
