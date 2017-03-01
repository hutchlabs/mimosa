<gradlead-profiles-user-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype" inline-template>

    <div class="hbox hbox-auto-xs hbox-auto-sm">
        <div class="col">

            <div style="background:url(img/c4.jpg) center center; background-size:cover">
                <div class="wrapper-lg bg-white-opacity">
                    <div class="row m-t">
                        <div class="col-sm-7">
                            <a href class="thumb-lg pull-left m-r">
                                <img v-bind:src="avatar" class="img-circle" />
                            </a>
                            <div class="clear m-b">
                                <div class="m-b m-t-sm">
                                    <span class="h3 text-black">@{{ authUser.name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper bg-white b-b">
                <ul class="nav nav-pills nav-sm">
                    <li role="presentation" class="active">
                        <a href="#userprofile" aria-controls="userprofile" role="tab" data-toggle="tab">&nbsp;Profile</a>
                    </li>
                    <li role="presentation">
                        <a href="#userprefs" aria-controls="userprefs" role="tab" data-toggle="tab">&nbsp;Preferences</a>
                    </li>
                    <li role="presentation">
                        <a href="#useraccount" aria-controls="useraccount" role="tab" data-toggle="tab">&nbsp;Account</a>
                    </li>
                </ul>
            </div>

            <div class="hbox hbox-auto-xs no-border">

                <div class="col wrapper">

                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="userprofile">
                            <spark-profile-summary :title="'Summary'" :profileid:="authUser.profile.id" :userid="authUser.id" :uuid="authUser.profile.uuid" :summary="authUser.profile.summary">
                            </spark-profile-summary>

                            <spark-profile-work :title="'Professional Experience'" :userid="authUser.id" :work="authUser.work">
                            </spark-profile-work>

                            <spark-profile-education :title="'Education'" :userid="authUser.id" :education="authUser.education">
                            </spark-profile-education>

                            <div class="row">
                                <div class="col-sm-6">
                                    <spark-profile-languages :title="'Languages'" :userid="authUser.id" :languages="authUser.languages">
                                    </spark-profile-languages>
                                </div>
                                <div class="col-sm-6">
                                    <spark-profile-skills :title="'Skills'" :userid="authUser.id" :skills="authUser.skills">
                                    </spark-profile-skills>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="userprefs">
                            <spark-profile-preferences :title="'Preferences'" :userid="authUser.id" :preferences="authUser.preferences">
                            </spark-profile-preferences>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="useraccount">
                            <div class="panel hbox hbox-auto-xs no-border">
                                <div class="col wrapper">
                                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
                                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">Details</h4>
                                    <br/>
                                    <spark-error-alert :form="forms.updateProfile"></spark-error-alert>

                                    <!-- Add Form -->
                                    <form class="form-horizontal " role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <spark-text :display="'UUID*'" :form="forms.updateProfile" :name="'uuid'" :input.sync="forms.updateProfile.uuid">
                                                </spark-text>
                                             </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                              <gl-location :id="'userLoc'"
                                                           :display="'Address (Area, City, Country)'" 
                                                           :form="forms.updateProfile" 
                                                           :name="'country'"
                                                           :input="location"
                                                           :placeholder="'e.g. Accra, Ghana'">
                                              </gl-location>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <gl-file :display="'Logo'" :form="forms.updateProfile" v-on:updated="setFileName" :name="'icon_file'" :warning="'File must be less than 20MB. Must be an image file'" :filename.sync="forms.updateProfile.file_name" :input.sync="forms.updateProfile.icon_file">
                                                </gl-file>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="panel-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary pull-right" @click.prevent="updateUserProfile" :disabled="forms.updateProfile.busy">
                                            <span v-if="forms.updateProfile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                                            <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

</gradlead-profiles-user-screen>
