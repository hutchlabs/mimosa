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
                        <a href="#usrprofile" aria-controls="usrprofile" role="tab" data-toggle="tab">&nbsp;Profile</a>
                    </li>
                    <li role="presentation">
                        <a href="#usrbadges" aria-controls="usrbadges" role="tab" data-toggle="tab">&nbsp;Badges</a>
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

                        <div role="tabpanel" class="tab-pane active" id="usrprofile">
				                  <spark-profile-summary :title="'Summary'" :profileid:="authUser.profile.id" :authUserid="authUser.id" :summary="authUser.profile.summary">
				                  </spark-profile-summary>
				                  <spark-profile-work :title="'Professional Experience'" :authUserid="authUser.id" :work="authUser.work">
				                  </spark-profile-work>
				                  <spark-profile-education :title="'Higher Education'" :authUserid="authUser.id" :education="authUser.education">
				                  </spark-profile-education>

				                  <spark-profile-education-primary :title="'Primary Education'" :authUserid="authUser.id" :education="authUser.primary">
				                  </spark-profile-education-primary>

				                  <gradlead-profile-clubs :title="'Clubs'" :authUserid="authUser.id" :education="authUser.clubs">
				                  </gradlead-profile-clubs>

				                  <div class="row">
				                    <div class="col-sm-6">
				                        <spark-profile-languages :title="'Languages'" :authUserid="authUser.id" :languages="authUser.languages">
				                        </spark-profile-languages>
				                     </div>
				                     <div class="col-sm-6">
				                        <spark-profile-skills :title="'Skills'" :authUserid="authUser.id" :skills="authUser.skills">
				                        </spark-profile-skills>
				                     </div>
				                  </div>

                        </div>

                        <div role="tabpanel" class="tab-pane" id="usrbadges">
				                  <div class="panel hbox hbox-auto-xs no-border">
                                    <div class="col wrapper"> 
                                        <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
                                        <h4 class="font-thin m-t-none m-b-none text-primary-lt">Badges</h4>
                                        <br/>
                                        <gl-achievement-display :user="authUser"
                                                :message="'No badges. You can obtain badges by completing Gradlead certified assessments. Contact Gradlead for more information.'"
                                            ></gl-achievement-display>
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
