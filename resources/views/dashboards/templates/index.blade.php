<div>
        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
                <!-- main header -->
                <div class="bg-light lter b-b wrapper-md">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <h1 class="m-n font-thin h3 text-black">Templates</h1>
                            <small class="text-muted">@{{authUser.name}} templates</small>
                        </div>
                    </div>
                </div>
                <!-- / main header -->
            </div>
        </div>

        <div class="hbox hbox-auto-xs hbox-auto-sm bg-light fade-up-in" style="height:780px" v-if="everythingLoaded">
            <gradlead-templates :authUser="authUser"></gradlead-templates>
        </div>

</div>
