Vue.component('spark-profile-languages', {
    props: ['userid','languages','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <a class="btn btn-sm btn-info btn-addon pull-right" @click.prevent="addItem()"><i class="fa fa-plus"></i> Add</a>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Language</th><th>Level</th><th></th></tr></thead>\
                        <tbody>\
                            <tr v-for="i in list">\
                                <td class="spark-table-pad">{{ i.language }}</td>\
                                <td class="spark-table-pad">{{ i.level }}</td>\
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
                  <div class="modal fade" id="modal-add-language" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Language</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Language\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'language\'" \
                                                            :items="languageOptions" \
                                                            :input="forms.addForm.language">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Proficiency Level\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'level\'" \
                                                            :items="levelOptions" \
                                                            :input="forms.addForm.level">\
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
                  <div class="modal fade" id="modal-edit-language" tabindex="-1" role="dialog" style="margin:auto;">\
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
                                              <gl-select :display="\'Language\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'language\'" \
                                                            :items="languageOptions" \
                                                            :input.sync="forms.updateForm.language">\
                                              </gl-select>\
                                          </div>\
                                          <div class="col-md-6">\
                                              <gl-select :display="\'Proficiency Level\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'level\'" \
                                                            :items="levelOptions" \
                                                            :input="forms.updateForm.level">\
                                              </gl-select>\
                                          </div>\
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
        this.list = this.languages;
        this.setupListeners();
    },

    watch: { },

    events: {},

    notifications: {
      showError: { title: 'Languages Error', message: 'Failed to reach server', type: 'error' },
      showSuccess: { title: 'Languages success', message: 'Successfully modified languages', type: 'success' },
    },

    data: function () {
        return {
            baseUrl: '/',

            list: [],

            languageOptions: [],
            levelOptions:[
                {text:'Native Speaker', value:'Native Speaker'},
                {text:'Beginner', value:'Beginner'},
                {text:'Intermediate', value:'Intermediate'},
                {text:'Expert', value:'Expert'},
            ],

            forms: {
                addForm: new SparkForm ({
                    user_id:'',
                    language:'',
                    level:'',
                    visible: 1,
                }),
                updateForm: new SparkForm ({
                    id:'',
                    user_id:'',
                    language:'',
                    level:'',
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

        addItem: function(e) {
            this.forms.addForm.user_id = this.userid;
            this.forms.addForm.language = '';
            this.forms.addForm.level = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-language').modal('show');
        },

        editItem: function(e) {
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.user_id = e.user_id;
            this.forms.updateForm.language = e.language;
            this.forms.updateForm.level = e.level;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-language').modal('show');
        },

        addNewItem: function () {
            var self = this;
            Spark.post(self.baseUrl+'profiles/users/language', this.forms.addForm)
                .then(function () {
                    $('#modal-add-language').modal('hide');
                    self.showSuccess({message:'New language added'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateItem: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'profiles/users/language/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-language').modal('hide');
                    self.showSuccess({message:'Language updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeItem: function (e) {
            var self = this;
            this.$http.delete(self.baseUrl+'profiles/users/language/' + e.id)
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
            bus.$on('authUserSet', function (user) { self.setList(user.languages); });
            bus.$on('languagesSet', function (items) {
                $.each(items, function(i,j){
                    self.languageOptions.push({text:j.name, value:j.name});
                });
            });
        },
    },

    filters: { },
});
