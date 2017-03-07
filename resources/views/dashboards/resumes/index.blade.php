<gradlead-resumes-screen v-bind:auth-user="authUser" v-bind:usertype="usertype" v-bind:permissions="permissions" inline-template>

    <div class="hbox hbox-auto-xs hbox-auto-sm">
        <div class="col">

            <div style="background:url(img/c4.jpg) center center; background-size:cover">
                <div class="wrapper-lg bg-white-opacity">
                    <div class="row m-t">
                        <div class="col-sm-7">
                            <a href class="thumb-lg pull-left m-r">
                                <img v-bind:src="authUser.profile.avatar" class="img-circle" />
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
                        <a href="#uresumes" aria-controls="uresumes" role="tab" data-toggle="tab">&nbsp;Resumes</a>
                    </li>
                    <li role="presentation">
                        <a href="#udocs" aria-controls="udocs" role="tab" data-toggle="tab">&nbsp;Documents</a>
                    </li>
                </ul>
            </div>

            <div class="hbox hbox-auto-xs no-border">

                <div class="col wrapper">

                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="userprofile">
                            <spark-profile-summary :title="'Summary'" :profileid:="authUser.profile.id" :userid="authUser.id" :summary="authUser.profile.summary">
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

                        <div role="tabpanel" class="tab-pane" id="uresumes">
                              @include('dashboards.resumes.resume')
                      
                        </div>

                        <div role="tabpanel" class="tab-pane" id="udocs">
                            @include('dashboards.resumes.docs')

                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

</gradlead-resumes-screen>
