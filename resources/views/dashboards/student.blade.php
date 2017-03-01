@extends('layouts.app') @section('content')
<!-- menu -->
<div class="app-aside hidden-xs bg-dark">
    <div class="aside-wrap">
        <div class="navi-wrap">

            <!-- nav -->
            <nav ui-nav class="navi">
                <ul class="nav">
<!--
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
-->

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Job Search</span>
                    </li>

                    <li class="active">
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
                            <i class="fa fa-paperclip icon text-info-lter"></i>
                            <span class="font-bold">Resumes</span>
                        </a>
                    </li>

<!--
                    <li class="line dk"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Tracking</span>
                    </li>

                    <li>
                        <a href="#badges" aria-controls="badges" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-certificate icon"></i>
                            <span class="font-bold">Achievements</span>
                        </a>
                    </li>
                    <li>
                        <a href="#alerts" aria-controls="alerts" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-bell icon"></i>
                            <span class="font-bold">Alerts</span>
                        </a>
                    </li>
                    <li>
                        <a href="#bookmarks" aria-controls="bookmarks" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-bookmark icon"></i>
                            <span class="font-bold">Bookmarks</span>
                        </a>
                    </li>
-->

                    <li class="line dk hidden-folded"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span>Settings</span>
                    </li>
                    <li>
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
        <div role="tabpanel" class="tab-pane" id="dashboard">
            @include('dashboards.stats.index')
        </div>
        
        <div role="tabpanel" class="tab-pane" id="applications">
            @include('dashboards.applications.student')
        </div>

        <div role="tabpanel" class="tab-pane active" id="jobs">
            @include('dashboards.jobs.search')
        </div>

        <div role="tabpanel" class="tab-pane" id="resumes">
            @include('dashboards.resumes.index')
        </div>

        <div role="tabpanel" class="tab-pane" id="myprofile">
            @include('dashboards.profiles.studentprofile')
        </div>
    </div>
</div>
<!-- /content -->

<!-- aside right -->
<!-- / aside right -->
@endsection
