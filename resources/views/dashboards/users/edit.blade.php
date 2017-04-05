<div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i> Update User</h4>
            </div>

            <div class="modal-body">

                <gl-error-alert :form="forms.updateUser"></gl-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <gl-select :display="'Organization*'" :form="forms.updateUser" :name="'organization_id'" :items="orgsOptions" :input.sync="forms.updateUser.organization_id">
                            </gl-select>


                            <gl-select :display="'Role*'" :form="forms.updateUser" :name="'role_id'" :items="roleOptions" :input.sync="forms.updateUser.role_id">
                            </gl-select>

                            <gl-select :display="'Type*'" :form="forms.updateUser" :name="'type'" :items="getTypeOptions()" :input.sync="forms.updateUser.type">
                            </gl-select>


                            <gl-text :required="true" :display="'First Name*'" :form="forms.updateUser" :name="'first'" :input.sync="forms.updateUser.first">
                            </gl-text>
                            <gl-text :required="true" :display="'Last Name*'" :form="forms.updateUser" :name="'last'" :input.sync="forms.updateUser.last">
                            </gl-text>

                            <gl-email :display="'Email*'" :form="forms.updateUser" :name="'email'" :input.sync="forms.updateUser.email">
                            </gl-email>

                            <gl-password :display="'Current Password'" :form="forms.updateUser" :name="'current_password'" :input.sync="forms.updateUser.current_password">
                            </gl-password>

                            <gl-password :display="'New Password'" :form="forms.updateUser" :name="'password'" :input.sync="forms.updateUser.password">
                            </gl-password>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateUser" :disabled="forms.updateUser.busy">
                    <span v-if="forms.updateUser.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Updating
                        </span>

                    <span v-else>
                            <i class="fa fa-btn fa-save"></i> Update
                        </span>
                </button>
            </div>
        </div>
    </div>
</div>
