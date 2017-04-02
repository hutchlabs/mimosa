<gradlead-inbox-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>
    <div>

        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
                <!-- main header -->
                <div class="bg-light lter b-b wrapper-md">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <h1 class="m-n font-thin h3 text-black">Message Contact Lists</h1>
                            <small class="text-muted">@{{authUser.name}} contact lists</small>
                        </div>
                    </div>
                </div>
                <!-- / main header -->
            </div>
        </div>

        <gradlead-inbox-lists :user="authUser"></gradlead-inbox-lists>

    </div>
</gradlead-inbox-screen>
