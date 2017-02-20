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

                    <li class="active">
                        <a href="#dashboard" aria-controls="dashboard" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-stats icon text-success-lter"></i>
                            <span class="font-bold">Dashboard</span>
                        </a>
                    </li>

                    <li class="line dk"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Job Board</span>
                    </li>

                    <li>
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
                            <i class="fa fa-group icon text-info-lter"></i>
                            <span class="font-bold">Job Seekers</span>
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

                    <li v-if="usertype.isAdmin" class="line dk"></li>

                    <li v-if="usertype.isAdmin" class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Settings</span>
                    </li>

                    <li v-if="usertype.isAdmin && permissions.canDoScreening">
                        <a href="#screening" aria-controls="screening" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-question-sign icon"></i>
                            <span class="font-bold">Screening Qs</span>
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
        <div role="tabpanel" class="tab-pane active" id="dashboard">
            @include('dashboards.stats.index')
        </div>
        
        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="employers">
            @include('dashboards.organizations.employers')
        </div>

        <div v-if="usertype.canEdit && permissions.canDoEvents" role="tabpanel" class="tab-pane" id="events">
            @include('dashboards.events.index')
        </div>

        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="theme">
            @include('dashboards.themes.index')
        </div>
        
        <div role="tabpanel" class="tab-pane" id="applications">
            @include('dashboards.applications.index')
        </div>

        <div role="tabpanel" class="tab-pane" id="jobs">
            @include('dashboards.jobs.index')
        </div>

        <div role="tabpanel" class="tab-pane" id="resumes">
            @include('dashboards.seekers.index')
        </div>
        
        <div v-if="usertype.isAdmin" role="tabpanel" class="tab-pane" id="users">
            @include('dashboards.users.index')
        </div>

        <div v-if="usertype.isAdmin && permissions.canDoScreening" role="tabpanel" class="tab-pane" id="screening">
            @include('dashboards.screening.index')
        </div>


        <div role="tabpanel" class="tab-pane" id="yourprofile">
            Your profile
        </div>

        <div v-if="usertype.canEdit" role="tabpanel" class="tab-pane" id="orgprofile">
            Org profile
        </div>

    </div>
</div>
<!-- /content -->

<!-- aside right -->
<!-- / aside right -->
@endsection