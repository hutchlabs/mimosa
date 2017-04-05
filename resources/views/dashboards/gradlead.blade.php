@extends('layouts.app') @section('content')
<!-- menu -->
<div class="app-aside hidden-xs bg-dark">
    <div class="aside-wrap">
        <div class="navi-wrap">

            <!-- nav -->
            <nav ui-nav class="navi">
                <ul class="nav">
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Navigation</span>
                    </li>
<!--

                    <li class="active">
                        <a href="#dashboard" aria-controls="dashboard" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-stats icon text-success-lter"></i>
                            <span class="font-bold">Dashboard</span>
                        </a>
                    </li>
-->

                    <li class="line dk"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Job Board</span>
                    </li>

                    <li :class="listClass('#jobs')">
                        <a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">
                            <i class="fa fa-suitcase icon text-info-lter"></i>
                            <span class="font-bold">Job Postings</span>
                        </a>
                    </li>
                    <li>
                        <a href="#applications" aria-controls="applications" role="tab" data-toggle="tab">
                            <i class="fa fa-folder-open icon text-info-lter"></i>
                            <span class="font-bold">Applications</span>
                        </a>
                    </li>
                    <li>
                        <a href="#resumes" aria-controls="resumes" role="tab" data-toggle="tab">
                            <b class="badge bg-info pull-right">@{{ jobSeekerNum }}</b>
                            <i class="fa fa-group icon text-info-lter"></i>
                            <span class="font-bold">Job Seekers</span>
                        </a>
                    </li>


                    <li class="line dk"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Messages</span>
                    </li>

                    <li :class="listClass('#messages')">
                        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
                            <b class="badge bg-info pull-right">@{{ newMessageNum }}</b>
                            <i class="glyphicon glyphicon-envelope icon"></i>
                            <span class="font-bold">Inbox</span>
                        </a>
                    </li>

                    <li v-if="usertype.canEdit" :class="listClass('#maillists')">
                        <a href="#maillists" aria-controls="maillists" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-list-alt icon"></i>
                            <span class="font-bold">Mail Lists</span>
                        </a>
                    </li>

                    <li v-if="usertype.canEdit" class="line dk"></li>

                    <li v-if="usertype.canEdit" class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Organizations</span>
                    </li>

                    <li v-if="usertype.canEdit">
                        <a href="#employers" aria-controls="employers" role="tab" data-toggle="tab">
                            <i class="fa fa-building icon text-warning-lter"></i>
                            <span class="font-bold">Employers</span>
                        </a>
                    </li>
                    <li v-if="usertype.canEdit">
                        <a href="#partners" aria-controls="partners" role="tab" data-toggle="tab">
                            <i class="fa fa-institution icon text-warning-lter"></i>
                            <span class="font-bold">Partners</span>
                        </a>
                    </li>

                    <li v-if="usertype.canEdit" class="line dk"></li>

                    <li v-if="usertype.canEdit && permissions.canDoEvents" class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Content</span>
                    </li>

                    <li v-if="usertype.canEdit && permissions.canDoEvents">
                        <a href="#events" aria-controls="events" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-calendar icon text-danger-lter"></i>
                            <span class="font-bold">Events</span>
                        </a>
                    </li>

                    <li v-if="usertype.canEdit">
                        <a href="#theme" aria-controls="theme" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-picture icon text-danger-lter"></i>
                            <span class="font-bold">Theme</span>
                        </a>
                    </li>

                    <li v-if="usertype.canEdit">
                        <a href="#template" aria-controls="template" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-book icon text-danger-lter"></i>
                            <span class="font-bold">Templates</span>
                        </a>
                    </li>


                    <li v-if="usertype.isAdmin" class="line dk"></li>

                    <li v-if="usertype.isAdmin" class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Settings</span>
                    </li>

                    <li v-if="usertype.isAdmin">
                        <a href="#badges" aria-controls="badges" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-certificate icon"></i>
                            <span class="font-bold">Badges</span>
                        </a>
                    </li>

                    <li v-if="usertype.isAdmin">
                        <a href="#plans" aria-controls="plans" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-shopping-cart icon"></i>
                            <span class="font-bold">Pricing Plans</span>
                        </a>
                    </li>

                    <li v-if="usertype.isAdmin && permissions.canDoScreening">
                        <a href="#screening" aria-controls="screening" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-question-sign icon"></i>
                            <span class="font-bold">Screening Qs</span>
                        </a>
                    </li>

              <li v-if="usertype.isAdmin">
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-list icon"></i>
                  <span class="font-bold">Lists</span>
                </a>
                <ul class="nav nav-sub dk">
                  <li class="nav-sub-header">
                    <a href><span>Lists</span></a>
                  </li>
                  <li>
                    <a href="#degrees" aria-controls="degrees" role="tab" data-toggle="tab">
                        <span>Degrees</span>
                    </a>
                  </li>
                  <li>
                    <a href="#majors" aria-controls="majors" role="tab" data-toggle="tab">
                        <span>Majors</span>
                    </a>
                  </li>
                  <li>
                    <a href="#universities" aria-controls="universities" role="tab" data-toggle="tab">
                        <span>Universities</span>
                    </a>
                  </li>
                  <li>
                    <a href="#industries" aria-controls="industries" role="tab" data-toggle="tab">
                        <span>Industries</span>
                    </a>
                  </li>
                  <li>
                    <a href="#jobtypes" aria-controls="jobtypes" role="tab" data-toggle="tab">
                        <span>Job Types</span>
                    </a>
                  </li>
                  <li>
                    <a href="#skills" aria-controls="skills" role="tab" data-toggle="tab">
                        <span>Skills</span>
                    </a>
                  </li>
                  <li>
                    <a href="#languages" aria-controls="languages" role="tab" data-toggle="tab">
                        <span>Languages</span>
                    </a>
                  </li>
                </ul>
              </li>

                    <li v-if="usertype.isAdmin">
                        <a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-ok-circle icon"></i>
                            <span class="font-bold">Permissions</span>
                        </a>
                    </li>

                    <li v-if="usertype.isAdmin">
                        <a href="#users" aria-controls="users" role="tab" data-toggle="tab">
                            <i class="icon-users icon"></i>
                            <span class="font-bold">Users</span>
                        </a>
                    </li>

                    <li class="line dk hidden-folded"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Profiles</span>
                    </li>
                    <li>
                        <a href="#yourprofile" aria-controls="yourprofile" role="tab" data-toggle="tab">
                            <i class="icon-user icon text-success-lter"></i>
                            <span class="font-bold">Your Profile</span>
                        </a>
                    </li>
                    <li v-if="usertype.canEdit">
                        <a href="#orgprofile" aria-controls="orgprofile" role="tab" data-toggle="tab">
                            <i class="fa fa-building-o icon text-warning-lter"></i>
                            <span class="font-bold">{{ strtok($name," ") }} Profile</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- nav -->

        </div>
    </div>
</div>
<!-- / menu -->

<!-- content -->
<div class="app-content">
    <div class="app-content-body fade-in-up tab-content">
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="degrees">
            @include('dashboards.lists.index', array('item'=>'Degrees'))
        </div>
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="industries">
            @include('dashboards.lists.index', array('item'=>'Industries'))
        </div>
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="jobtypes">
            @include('dashboards.lists.index', array('item'=>'JobTypes'))
        </div>
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="languages">
            @include('dashboards.lists.index', array('item'=>'Languages'))
        </div>
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="majors">
            @include('dashboards.lists.index', array('item'=>'Majors'))
        </div>
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="skills">
            @include('dashboards.lists.index', array('item'=>'Skills'))
        </div>
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="universities">
            @include('dashboards.lists.index', array('item'=>'Universities'))
        </div>

        <div role="tabpanel" class="tab-pane" id="dashboard">
            @include('dashboards.stats.index')
        </div>
        
        <div role="tabpanel" :class="tabClass('#messages')" id="messages">
            @include('dashboards.messages.index')
        </div>

        <div v-if="usertype.canEdit" role="tabpanel" :class="tabClass('#maillists')" id="maillists">
            @include('dashboards.messages.lists')
        </div>
        
        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="employers">
            @include('dashboards.organizations.employers')
        </div>

        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="partners">
            @include('dashboards.organizations.partners')
        </div>

        <div v-if="usertype.canEdit && permissions.canDoEvents" role="tabpanel" class="tab-pane" id="events">
            @include('dashboards.events.index')
        </div>

        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="theme">
            @include('dashboards.themes.index')
        </div>
        
        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="template">
            @include('dashboards.templates.index')
        </div>
        
        <div role="tabpanel" class="tab-pane" id="applications">
            @include('dashboards.applications.index')
        </div>

        <div role="tabpanel" class="tab-pane active" id="jobs">
            @include('dashboards.jobs.index')
        </div>

        <div role="tabpanel" class="tab-pane" id="resumes">
            @include('dashboards.seekers.index')
        </div>
        

        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="permissions">
            @include('dashboards.permissions.index')
        </div>

        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="badges">
            @include('dashboards.badges.index')
        </div>

        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="plans">
            @include('dashboards.plans.index')
        </div>

        
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="users">
            @include('dashboards.users.index')
        </div>

        <div v-if="usertype.isAdmin && permissions.canDoScreening" role="tabpanel" class="tab-pane" id="screening">
            @include('dashboards.screening.index')
        </div>


        <div role="tabpanel" class="tab-pane" id="yourprofile">
            @include('dashboards.profiles.userprofile')
        </div>

        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="orgprofile">
            @include('dashboards.profiles.orgprofile')
        </div>
    </div>
</div>
<!-- /content -->

<!-- aside right -->
<!-- / aside right -->
@endsection
