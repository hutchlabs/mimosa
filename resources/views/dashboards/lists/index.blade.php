<gradlead-lists-screen v-bind:list="'{{$item}}'" v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>

    <div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
        <!-- main -->
        <div class="col">

            <!-- main header -->
            <div class="bg-light lter b-b wrapper-md">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1 class="m-n font-thin h3 text-black">{{$item}}</h1>
                        <small class="text-muted">{{$name}} {{$item}}</small>
                    </div>
                </div>
            </div>
            <!-- / main header -->

            <div class="col wrapper-md">

                <div class="app-content-body fade-in-up tab-content">
                    <div role="tabpanel" class="tab-pane active" id="{{$item}}_mlist">
                        @include('dashboards.lists.main')    
                    </div>

                    <div role="tabpanel" class="tab-pane" id="{{$item}}_addItem">
                        @include('dashboards.lists.add')    
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="{{$item}}_editItem">
                        @include('dashboards.lists.edit')    
                    </div>
                </div>

            </div>
        </div>
        <!-- / main -->
    </div>

</gradlead-lists-screen>
