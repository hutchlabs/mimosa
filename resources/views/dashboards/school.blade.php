@extends('layouts.app')

@section('content')
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
                  <i class="glyphicon glyphicon-stats icon text-info-dker"></i>
                  <span class="font-bold">Dashboard</span>
                </a>
              </li>

              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>Job Board</span>
              </li>

                <li>
                <a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">
                    <i class="icon icon-pin"></i>
                    <span>Job Postings</span>
                </a>
              </li>
              <li>
                <a href="#applications" aria-controls="applications" role="tab" data-toggle="tab">
                    <i class="icon icon-envelope-letter"></i>
                    <span>Applications</span>
                </a>
              </li>
              <li>
                <a href="#resumes" aria-controls="resumes" role="tab" data-toggle="tab">
                    <i class="icon icon-users"></i>
                    <span>Job Seekers</span>
                </a>
              </li>
              <li v-if="canEdit">
                    <a href="#employers" aria-controls="employers" role="tab" data-toggle="tab">
                        <i class="glyphicon glyphicon-home icon"></i>
                        <span>Employers</span>
                    </a>
                </li>

              <li v-if="canEdit" class="line dk"></li>

              <li v-if="canEdit && canDoEvents" class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>Content</span>
              </li>

              <li v-if="canEdit && canDoEvents">
                <a href="#events" aria-controls="events" role="tab" data-toggle="tab">
                  <i class="glyphicon glyphicon-calendar icon"></i>
                  <span class="font-bold">Events</span>
                </a>
              </li>

              <li v-if="isAdmin" class="line dk"></li>

              <li v-if="isAdmin" class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>Settings</span>
              </li>

              <li v-if="isAdmin && canDoScreening">
                <a href="#screening" aria-controls="screening" role="tab" data-toggle="tab">
                  <i class="glyphicon glyphicon-question-sign icon"></i>
                  <span class="font-bold">Screening Qs</span>
                </a>
              </li>

              <li v-if="isAdmin">
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
              <li v-if="canEdit">
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

            <div role="tabpanel" class="tab-pane" id="applications">
                Applications
            </div>

            <div role="tabpanel" class="tab-pane" id="jobs">
                @include('dashboards.jobs.index')
            </div>

            <div role="tabpanel" class="tab-pane" id="resumes">
                Resumes
            </div>

            <div v-if="canEdit" role="tabpanel" class="tab-pane" id="employers">
                @include('dashboards.organizations.employers')
            </div>

            <div v-if="canEdit && canDoEvents" role="tabpanel" class="tab-pane" id="events">
                @include('dashboards.events.index')
            </div>
         
            <div v-if="isAdmin && canDoScreening" role="tabpanel" class="tab-pane" id="screening">
                @include('dashboards.screening.index')
            </div>
           
            <div v-if="isAdmin" role="tabpanel" class="tab-pane" id="users">
                @include('dashboards.users.index')
            </div>

            <div role="tabpanel" class="tab-pane" id="yourprofile">
                Your profile
            </div>

            <div v-if="canEdit" role="tabpanel" class="tab-pane" id="orgprofile">
                Org profile
            </div>

      </div>    
    </div>
    <!-- /content -->
      
    <!-- aside right -->
    <!-- / aside right --> 
@endsection
