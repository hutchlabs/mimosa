Vue.component('gradlead-templates', {
    props: ['authUser'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
 			<div class="wrapper-md">\
            <div class="row">\
                <div class="col-md-12">\
                    <div class="panel panel-default nav-tabs-alt no-border">\
                        <ul class="nav nav-tabs nav-justified no-border">\
                            <li role="presentation" class="active">\
                                <a href="#alerts" aria-controls="alerts" role="tab" data-toggle="tab">\
                                    <b>Alerts</b>\
                                </a>\
                            </li>\
                            <li role="presentation">\
                                <a href="#auto" aria-controls="auto" role="tab" data-toggle="tab">\
                                   <b>Auto Responders</b>\
                                </a>\
                            </li>\
                            <li role="presentation">\
                                <a href="#emails" aria-controls="emails" role="tab" data-toggle="tab">\
                                   <b>Emails</b>\
                                </a>\
                            </li>\
                        </ul>\
                    </div>\
                </div>\
            </div>\
			<div class="row">\
				<div class="col-md-12">\
				<div class="tab-content">\
                <div role="tabpanel" class="tab-pane active" id="alerts">\
					<div class="col-md-12 wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <br/><br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Name</th><th>Description</th><th></th></tr></thead>\
                        <tbody v-if="alerts.length>0">\
                            <tr v-for="e in alerts">\
                                <td class="spark-table-pad">{{ e.name }}</td>\
                                <td class="spark-table-pad">{{ e.description}}</a></td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editTemplate(e)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button v-show="!e.system" class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeTemplate(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                        <tbody v-else><tr><td colspan="4">No alert templates set</td></tr></tbody>\
                     </table>\
                 	</div>\
				</div>\
                <div role="tabpanel" class="tab-pane" id="auto">\
					<div class="col-md-12 wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <br/><br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Name</th><th>Description</th><th></th></tr></thead>\
                        <tbody v-if="responders.length>0">\
                            <tr v-for="e in responders">\
                                <td class="spark-table-pad">{{ e.name }}</td>\
                                <td class="spark-table-pad">{{ e.description}}</a></td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editTemplate(e)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button v-show="!e.system" class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeTemplate(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                        <tbody v-else><tr><td colspan="4">No auto responder templates set</td></tr></tbody>\
                     </table>\
                 	</div>\
				</div>\
                <div role="tabpanel" class="tab-pane" id="emails">\
					<div class="col-md-12 wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <a class="btn btn-sm btn-info btn-addon" @click.prevent="addTemplate(\'Email\')"><i class="fa fa-plus"></i> Add Email Template</a>\
                    <br/><br/>\
                    <table class="table table-striped m-b-none"><thead>\
                        <tr><th>Name</th><th>Description</th><th></th></tr></thead>\
                        <tbody v-if="email.length>0">\
                            <tr v-for="e in email">\
                                <td class="spark-table-pad">{{ e.name }}</td>\
                                <td class="spark-table-pad">{{ e.description}}</a></td>\
                                <td class="spark-table-pad">\
                                    <button class="btn btn-warning btn-addon btn-sm btn-circle" @click.prevent="editTemplate(e)">\
                                        <i class="fa fa-pencil"></i> Edit\
                                    </button>\
                                    <button v-show="!e.system" class="btn btn-danger btn-addon btn-sm btn-cirlce" @click.prevent="removeTemplate(e)">\
                                        <i class="fa fa-trash-o"></i> Delete </button>\
                                </td>\
                            </tr>\
                        </tbody>\
                        <tbody v-else><tr><td colspan="4">No email templates set</td></tr></tbody>\
				</div>\
				</div>\
			</div>\
                  <div class="modal fade" id="modal-add-utemplate" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Template</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.addForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Name*\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'name\'" \
                                                            :input="forms.addForm.name">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Description*\'" \
                                                            :form="forms.addForm" \
                                                            :name="\'description\'" \
                                                            :input="forms.addForm.description">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                            <gl-textarea :id="\'utpl-container\'" :display="\'Template:\'" :form="forms.addForm" :name="\'template\'" :placeholder="\'Your template\'" :input="forms.addForm.template"></gl-textarea>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewTemplate()" :disabled="forms.addForm.busy">\
                                      <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
                  <div class="modal fade" id="modal-edit-utemplate" tabindex="-1" role="dialog" style="margin:auto;">\
                      <div class="modal-dialog">\
                          <div class="modal-content">\
                              <div class="modal-header">\
                                  <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                  <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update Template</h4>\
                              </div>\
                              <div class="modal-body">\
                                  <gl-error-alert :form="forms.updateForm"></gl-error-alert>\
                                  <!-- Add Form -->\
                                  <form class="form-horizontal" role="form">\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Name*\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'name\'" \
                                                            :input.sync="forms.updateForm.name">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                              <gl-text :display="\'Description*\'" \
                                                            :form="forms.updateForm" \
                                                            :name="\'description\'" \
                                                            :input.sync="forms.updateForm.description">\
                                              </gl-text>\
                                          </div>\
                                      </div>\
                                      <div class="row">\
                                          <div class="col-md-12">\
                                            <gl-textarea :id="\'uetpl-container\'" :display="\'Template:\'" :form="forms.updateForm" :name="\'template\'" :placeholder="\'Your template\'" :input.sync="forms.updateForm.template"></gl-textarea>\
                                          </div>\
                                      </div>\
                                  </form>\
                              </div>\
                              <div class="modal-footer">\
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                                  <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateTemplate()" :disabled="forms.updateForm.busy">\
                                      <span v-if="forms.updateForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>\
                                      <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                                  </button>\
                              </div>\
                          </div>\
                      </div>\
                  </div>\
               </div></div>',

    mounted: function () {
        this.setupListeners();
        this.getAuthUser();
    },

    watch: {
        'authUser': function(x) {
            this.setList(x.organization.templates);
        }
    },

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

            alerts: [],
            responders: [],
            email: [],

            currentTemplate: {},

            tempateTypes: [
                {text:'Alert', value:'Alert'},
                {text:'Auto Responder', value:'Auto Responder'},
                {text:'Email', value:'Email'},
            ],

            forms: {
                addForm: new SparkForm ({
                    name:'',
                    type:'',
                    description:'',
                    template:'',
                }),
                updateForm: new SparkForm ({
                    id:'',
                    name:'',
                    type:'',
                    description:'',
                    template:'',
                }),
            },
        }
    },

    methods: {
        setList: function(l) { 
            var self = this;
            this.alerts = []; 
            this.responders = []; 
            this.email = []; 
            $.each(l, function(i, x) {
                if (x.type=='Alert') { self.alerts.push(x); }
                if (x.type=='Auto Responder') { self.responders.push(x); }
                if (x.type=='Email') { self.email.push(x); }
            });
        
        },

        removeT: function(x) {
            //if (x.type=='Alert') { this.alerts =  this.removeFromList(this.alerts, e);  }
            //if (x.type=='Auto Responder') { this.responders =  this.removeFromList(this.responders, e);  }
            if (x.type=='Email') { this.email =  this.removeFromList(this.email, e);  }
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        addTemplate: function(type) {
            this.forms.addForm.name = '';
            this.forms.addForm.type = type;
            this.forms.addForm.description = '';
            this.forms.addForm.template = '';
            this.forms.addForm.errors.forget();
            $('#modal-add-utemplate').modal('show');
        },

        editTemplate: function(e) {
            this.forms.updateForm.id = e.id;
            this.forms.updateForm.name = e.name;
            this.forms.updateForm.type = e.type;
            this.forms.updateForm.description = e.description;
            this.forms.updateForm.template = e.template;
            this.forms.updateForm.errors.forget();
            $('#modal-edit-utemplate').modal('show');
        },

        addNewTemplate: function () {
            var self = this;
            Spark.post(self.baseUrl+'templates', this.forms.addForm)
                .then(function () {
                    $('#modal-add-utemplate').modal('hide');
                    self.showSuccess({message:'New template added'});
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.forms.addForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        updateTemplate: function () {
            var self = this;
            var eid = this.forms.updateForm.id;
            Spark.put(self.baseUrl+'templates/' + eid, this.forms.updateForm)
                .then(function () {
                    $('#modal-edit-utemplate').modal('hide');
                    self.showSuccess({message:'Template updated'});
                    bus.$emit('updateAuthUser');
                }, function(resp){
                    self.forms.updateForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeTemplate: function (e) {
            var self = this;
            this.$http.delete(self.baseUrl+'templates/' + e.id)
                .then(function () {
            		self.email =  this.removeFromList(self.email, e);
                    self.showSuccess();
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    self.showError({'message': resp.error[0]});
                });
        },

        getAuthUser: function () {
            var self = this;
            this.$http.get(self.baseUrl+'fauthuser')
                .then(function (user) { self.setList(user.data.organization.templates); });
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSe t', function (user) {  self.setList(user.organization.templates); });
        },
    }
});
