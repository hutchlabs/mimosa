@extends('layouts.app') @section('content')
<!-- menu -->
<div class="app-aside hidden-xs bg-dark">
    <div class="aside-wrap">
        <div class="navi-wrap">

            <!-- nav -->
            <nav ui-nav class="navi">
                <ul class="nav">
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Job Search</span>
                    </li>

                    <li :class="listClass('#jobs')">
                        <a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">
                            <i class="fa fa-suitcase icon text-info-lter"></i>
                            <span class="font-bold">Job Postings</span>
                        </a>
                    </li>
                    <li :class="listClass('#applications')">
                        <a href="#applications" aria-controls="applications" role="tab" data-toggle="tab">
                            <i class="fa fa-folder-open icon text-info-lter"></i>
                            <span class="font-bold">Applications</span>
                        </a>
                    </li>

                    <li :class="listClass('#resumes')">
                        <a href="#resumes" aria-controls="resumes" role="tab" data-toggle="tab">
                            <i class="fa fa-paperclip icon text-info-lter"></i>
                            <span class="font-bold">Job Profile</span>
                        </a>
                    </li>

                    <li class="line dk"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Tracking</span>
                    </li>

                    <li :class="listClass('#messages')">
                        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
                            <b class="badge bg-info pull-right">@{{ newMessageLength }}</b>
                            <i class="glyphicon glyphicon-envelope icon"></i>
                            <span class="font-bold">Messages</span>
                        </a>
                    </li>

                    <li :class="listClass('#alerts')">
                        <a href="#alerts" aria-controls="alerts" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-bell icon"></i>
                            <span class="font-bold">Alerts</span>
                        </a>
                    </li>

                    <li :class="listClass('#bookmarks')">
                        <a href="#bookmarks" aria-controls="bookmarks" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-bookmark icon"></i>
                            <span class="font-bold">Bookmarks</span>
                        </a>
                    </li>

                    <li class="line dk hidden-folded"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Settings</span>
                    </li>
                    <li :class="listClass('#myprofile')">
                        <a href="#myprofile" aria-controls="myprofile" role="tab" data-toggle="tab">
                            <i class="icon-user icon text-success-lter"></i>
                            <span class="font-bold">My Profile</span>
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
        <div role="tabpanel" :class="tabClass('#applications')" id="applications">
            @include('dashboards.applications.student')
        </div>

        <div role="tabpanel" :class="tabClass('#jobs')" id="jobs">
            @include('dashboards.jobs.search')
        </div>

        <div role="tabpanel" :class="tabClass('#resumes')" id="resumes">
            @include('dashboards.resumes.index')
        </div>

        <div role="tabpanel" :class="tabClass('#messages')" id="messages">
            @include('dashboards.messages.index')
        </div>

        <div role="tabpanel" :class="tabClass('#alerts')" id="alerts">
            @include('dashboards.jobs.alerts')
        </div>

        <div role="tabpanel" :class="tabClass('#bookmarks')" id="bookmarks">
            @include('dashboards.jobs.bookmarks')
        </div>

        <div role="tabpanel" :class="tabClass('#myprofile')" id="myprofile">
            @include('dashboards.profiles.userprofile')
        </div>
    </div>
</div>
<!-- /content -->

<!-- aside right -->
<!-- / aside right -->
@endsection
