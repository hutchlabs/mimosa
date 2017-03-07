<div class="hbox hbox-auto-xs hbox-auto-sm">
    <div class="col">

        <div style="background:url(img/c4.jpg) center center; background-size:cover">
            <div class="wrapper-lg bg-white-opacity">
                <div class="row m-t">
                    <div class="col-sm-7">
                        <a href class="thumb-lg pull-left m-r">
                            <img v-bind:src="logo" class="img-circle" />
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

        <div class="hbox hbox-auto-xs no-border">
            <div class="col wrapper">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="orgprofile">

                           <gl-profile-org 
                               :title="'Organization Details'" 
                               :auth-user="authUser"
                               :usertype="usertype"
                               :permissions="permissions">

                            </gl-profile-org>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>