<div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Update User</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.updateUser"></spark-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-select :display="'Organization*'" :form="forms.updateUser" :name="'organization_id'" :items="orgsOptions" :input.sync="forms.updateUser.organization_id">
                            </spark-select>


                            <spark-select :display="'Role*'" :form="forms.updateUser" :name="'role_id'" :items="roleOptions" :input.sync="forms.updateUser.role_id">
                            </spark-select>

                            <spark-select :display="'Type*'" :form="forms.updateUser" :name="'type'" :items="typeOptions" :input.sync="forms.updateUser.type">
                            </spark-select>


                            <spark-text :display="'Name*'" :form="forms.updateUser" :name="'name'" :input.sync="forms.updateUser.name">
                            </spark-text>

                            <spark-email :display="'Email*'" :form="forms.updateUser" :name="'email'" :input.sync="forms.updateUser.email">
                            </spark-email>

                            <spark-password :display="'Current Password'" :form="forms.updateUser" :name="'current_password'" :input.sync="forms.updateUser.current_password">
                            </spark-password>

                            <spark-password :display="'New Password'" :form="forms.updateUser" :name="'password'" :input.sync="forms.updateUser.password">
                            </spark-password>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary" @click.prevent="updateUser" :disabled="forms.updateUser.busy">
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
