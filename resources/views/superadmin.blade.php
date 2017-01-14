    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-justified">
                   <li role="presentation" class="active">
                        <a href="#orgs" aria-controls="users" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-office"></i>&nbsp;Organizations
                        </a>
                    </li>
                   <li role="presentation">
                        <a href="#users" aria-controls="users" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Users
                        </a>
                    </li>

                   <li role="presentation">
                        <a href="#badges" aria-controls="sections" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Badges
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="orgs">
                    @include('orgs.index')
                </div>

                <div role="tabpanel" class="tab-pane" id="users">
                    @include('users.index')
                </div>

                <div role="tabpanel" class="tab-pane" id="badges">
                    @include('badges.index')
                </div>
            </div>
        </div>
    </div>

