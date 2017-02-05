<gradlead-screening-screen inline-template>

    <div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
        <!-- main -->
        <div class="col">

            <!-- main header -->
            <div class="bg-light lter b-b wrapper-md">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1 class="m-n font-thin h3 text-black">Screening Questionnaires</h1>
                        <small class="text-muted">{{$name}} Questionnaires</small>
                    </div>
                </div>
            </div>
            <!-- / main header -->

            <div class="col wrapper-md">

                <div class="app-content-body fade-in-up tab-content">
                    <div role="tabpanel" class="tab-pane active" id="questionnaires">
                        @include('dashboards.screening.questionnaires')    
                    </div>

                    <div role="tabpanel" class="tab-pane" id="addquestionnaire">
                        @include('dashboards.screening.questionnaires-add')    
                    </div>

                    <div role="tabpanel" class="tab-pane" id="editquestionnaire">
                        @include('dashboards.screening.questionnaires-edit')    
                    </div>

                    <div role="tabpanel" class="tab-pane" id="questions">
                        @include('dashboards.screening.questions')    
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="addquestion">
                        @include('dashboards.screening.questions-add')    
                    </div>

                    <div role="tabpanel" class="tab-pane" id="editquestion">
                        @include('dashboards.screening.questions-edit')    
                    </div>
                </div>

            </div>
        </div>
        <!-- / main -->
    </div>

</gradlead-screening-screen>
