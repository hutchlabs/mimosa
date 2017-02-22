<gradlead-profiles-org-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype" inline-template>

    <div class="hbox hbox-auto-xs hbox-auto-sm">
        <div class="col">

            <div style="background:url(img/c4.jpg) center center; background-size:cover">
                <div class="wrapper-lg bg-white-opacity">
                    <div class="row m-t">
                        <div class="col-sm-7">
                            <a href class="thumb-lg pull-left m-r">
                                <img v-bind:src="avatar" class="img-circle"/>
                            </a>
                            <div class="clear m-b">
                                <div class="m-b m-t-sm">
                                    <span class="h3 text-black">{{ $name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper bg-white b-b">
                <ul class="nav nav-pills nav-sm">
                    <li role="presentation" class="active">
                        <a href="#orgprofile" aria-controls="orgprofile" role="tab" data-toggle="tab">&nbsp;Profile</a>
                    </li>
                </ul>
            </div>

            <div class="panel hbox hbox-auto-xs no-border">
                <div class="col wrapper">
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>

                    <div role="tabpanel" class="tab-pane active" id="orgprofile">

                        <spark-error-alert :form="forms.updateProfile"></spark-error-alert>

                        <!-- Add Form -->
                        <form class="form-horizontal " role="form">
                            <spark-text :display="'Summary*'" :form="forms.updateProfile" :name="'summary'" :input.sync="forms.updateProfile.summary">
                            </spark-text>

                            <spark-file :display="'Logo'" :form="forms.updateProfile" v-on:updated="setFileName" 
                                       :name="'icon_file'" :warning="'File must be less than 20MB. Must be an image file'"     :filename.sync="forms.updateProfile.file_name" 
                                :input.sync="forms.updateProfile.icon_file">
                            </spark-file>
                        </form>

                        <div class="panel-footer" style="margin-left:250px">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                            <button v-if="isSchool" type="button" class="btn btn-primary" @click.prevent="updateSchoolProfile" :disabled="forms.updateProfile.busy">
                                <span v-if="forms.updateProfile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                                <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                            </button>
                            <button v-else type="button" class="btn btn-primary" @click.prevent="updateCompanyProfile" :disabled="forms.updateProfile.busy">
                                <span v-if="forms.updateProfile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                                <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</gradlead-profiles-org-screen>
