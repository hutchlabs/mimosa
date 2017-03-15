Vue.component('gradlead-profile-clubs', {
    props: ['userid','clubs','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <a class="btn btn-sm btn-info btn-addon pull-right" @click.prevent="addClub()"><i class="fa fa-plus"></i> Add</a>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Club</th><th>Position</th><th></th></tr></thead>\
                        <tbody v-if="list.length>0">\
                            <tr v-for="e in list">\
                                <td class="spark-table-pad">{{ e.name}}</td>\
                                <td class="spark-table-pad">{{ e.position }}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editClub(e)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeClub(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                        <tbody v-else><tr><td colspan="3">No Club information</td></tr></tbody>\
                     </table>\
                  </div>\
                  <div class="modal fade" id="modal-add-club" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Club</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Name\'" \
                                                       :required="true"\
                                                       :form="forms.addForm" \
                                                       :name="\'name\'" \
                                                       :input="forms.addForm.name">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'position\'" \
                                                       :form="forms.addForm" \
                                                       :required="true"\
                                                       :name="\'position\'" \
                                                       :placeholder="\'E.g. member or secretary\'"\
                                                       :input="forms.addForm.position">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewClub()" :disabled="forms.addForm.busy">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
                  <div class="modal fade" id="modal-edit-club" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update Primary Education</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.updateForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'Name\'" \
                                                       :required="true"\
                                                       :form="forms.updateForm" \
                                                       :name="\'name\'" \
                                                       :input.sync="forms.updateForm.name">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-text :display="\'position\'" \
                                                       :form="forms.updateForm" \
                                                       :required="true"\
                                                       :name="\'position\'" \
                                                       :placeholder="\'E.g. member or secretary\'"\
                                                       :input.sync="forms.updateForm.position">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateClub()" :disabled="forms.updateForm.busy">\
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
        this.list = (typeof this.clubs=='undefined') ? [] : this.clubs;
        this.setupListeners();
    },

    watch: {
        'clubs': function(v) {
            this.setList(v);
        },
    },

    events: {},

    notifications: {
      showError: {
          title: 'Club Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Club success',
          message: 'Successfully modified club',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',

            list: [],

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    name:'',
                    position:'',
                    visible: 1,
                }),
                updateForm: new SparkForm ({
                    id:'',
                    user_id:'',
                    name:'',
                    position:'',
                    visible: 1,
                }),
            },
        }
    },

    methods: {
        setList: function(l) {
            this.list = l;
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        addPrimary: function(e) {
            this.forms.addForm.user_id = this.userid;
            this.forms.addForm.name = '';
            this.forms.addForm.position = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-club').modal('show');
        },

        editEdu: function(e) {
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.user_id = e.user_id;
            this.forms.updateForm.name = e.name;
            this.forms.updateForm.position = e.position;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-club').modal('show');
        },

        addNewClub: function () {
            var self = this;
            Spark.post(self.baseUrl+'profiles/users/club', this.forms.addForm)
                .then(function () {
                    $('#modal-add-club').modal('hide');
                    self.showSuccess({message:'New club added'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateClub: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'profiles/users/club/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-club').modal('hide');
                    self.showSuccess({message:'Club updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeClub: function (e) {
            var self = this;

            this.$http.delete(self.baseUrl+'profiles/users/club/' + e.id)
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
            bus.$on('authUserSet', function (user) { self.setList(user.clubs); });
        },
    }
});
