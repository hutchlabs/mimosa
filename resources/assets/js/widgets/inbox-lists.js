Vue.component('gradlead-inbox-lists', {
    props: ['user'],

    template: '<div class="col wrapper-md">\
              <div class="clearfix m-b">\
                    <button class="btn btn-info btn-addon" @click.prevent="addList()">\
                         <i class="fa fa-plus"></i> Add Mailing List</button>\
             </div>\
            <div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Name</th><th>Description</th><th></th></tr></thead>\
                        <tbody>\
                            <tr v-for="i in list">\
                                <td class="spark-table-pad">{{ i.name}}</td>\
                                <td class="spark-table-pad">{{ i.description }}</td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editList(i)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeList(i)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                     </table>\
                  </div>\
                  <div class="modal fade" id="modal-add-list" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add List</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Name\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'name\'" \
                                                            :placeholder="\'Enter name\'"\
                                                            :input="forms.addForm.name">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Description\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'description\'" \
                                                            :placeholder="\'Enter description\'"\
                                                            :input="forms.addForm.description">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                                <gl-multiselect :display="\'Contacts:\'" :form="forms.addForm" :name="\'contacts\'" :input="forms.addForm.contacts" :multiple="true" :items="contacts" :placetext="\'\'" :val="\'id\'"></gl-multiselect>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewList()" :disabled="forms.addForm.busy">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
                  <div class="modal fade" id="modal-edit-list" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update List</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.updateForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Name\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'name\'" \
                                                            :placeholder="\'Enter name\'"\
                                                            :input.sync="forms.updateForm.name">\
                                              </gl-text>\
                                          </div>\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Description\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'description\'" \
                                                            :placeholder="\'Enter description\'"\
                                                            :input.sync="forms.updateForm.description">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                                <gl-multiselect :display="\'Contacts:\'" :form="forms.updateForm" :name="\'contacts\'" :input.sync="forms.updateForm.contacts" :multiple="true" :items="contacts" :placetext="\'\'" :val="\'id\'"></gl-multiselect>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateList()" :disabled="forms.updateForm.busy">\
                                      <span v-if="forms.updateForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div></div>\
               </div>',

    mounted: function () {
        var self = this;
        this.setList(this.user.contacts);
        this.setupListeners();
    },

    watch: {},

    events: {},

    notifications: {
      showError: {
          title: 'Template Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Template success',
          message: 'Successfully modified template',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',

            list: [],
            contacts: [],

            forms: {
                addForm: new SparkForm ({
                    name:'',
                    description:'',
                    contacts:'',
                }),
                updateForm: new SparkForm ({
                    id:'',
                    name:'',
                    description:'',
                    contacts:'',
                }),
            },
        }
    },

    methods: {
        setList: function(l) {
            var self = this;
			this.list = [];		
			this.contacts = [];		
            $.each(l, function(i, c) {
                if (c.type=='list') { self.list.push({'name':c.text, 'id':c.value, 'description':c.description, 'id':c.id, 'contacts':c.contacts}); }
                else { self.contacts.push({'name':c.text, 'id':c.value}); }
            });
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        addList: function() {
            this.forms.addForm.name = '';
            this.forms.addForm.contacts = '';
            this.forms.addForm.description = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-list').modal('show');
        },

        editList: function(e) {
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.name = e.name;
            this.forms.updateForm.description = e.description;
            this.forms.updateForm.contacts = e.contacts;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-list').modal('show');
        },

        addNewList: function () {
            var self = this;
            Spark.post(self.baseUrl+'users/message/contacts', this.forms.addForm)
                .then(function () {
                    $('#modal-add-list').modal('hide');
                    self.showSuccess({message:'New list added'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateList: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'users/message/contacts/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-list').modal('hide');
                    self.showSuccess({message:'List updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeList: function (e) {
            var self = this;

            this.$http.delete(self.baseUrl+'users/message/contacts/' + e.id)
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
            bus.$on('authUserSet', function (user) { self.setList(user.contacts); });
        },
    }
});
