<div class="modal fade" id="modal-add-user" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add User</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addUser"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-select :display="'Organization*'" :form="forms.addUser" :name="'organization_id'" :items="orgsOptions" :input="forms.addUser.organization_id">
                            </spark-select>


                            <spark-select :display="'Role*'" :form="forms.addUser" :name="'role_id'" :items="roleOptions" :input="forms.addUser.role_id">
                            </spark-select>

                            <spark-select :display="'Type*'" :form="forms.addUser" :name="'type'" :items="typeOptions" :input="forms.addUser.type">
                            </spark-select>


                            <spark-text :display="'Name*'" :form="forms.addUser" :name="'name'" :input="forms.addUser.name">
                            </spark-text>

                            <spark-email :display="'Email*'" :form="forms.addUser" :name="'email'" :input="forms.addUser.email">
                            </spark-email>

                            <spark-password :display="'Password*'" :form="forms.addUser" :name="'password'" :input="forms.addUser.password">
                            </spark-password>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary" @click.prevent="addNewUser" :disabled="forms.addUser.busy">
                    <span v-if="forms.addUser.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Adding
                        </span>

                    <span v-else>
                            <i class="fa fa-btn fa-save"></i> Add
                        </span>
                </button>
            </div>
        </div>
    </div>
</div>
