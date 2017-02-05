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

              <li>
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-search icon text-success-lter"></i>
                  <span class="font-bold">Job Board</span>
                </a>
                <ul class="nav nav-sub dk">
                  <li class="nav-sub-header">
                    <a href><span>Job Board</span></a>
                  </li>
                    <li>
                    <a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">
                        <span>Job Postings</span>
                    </a>
                  </li>
                  <li>
                    <a href="#applications" aria-controls="applications" role="tab" data-toggle="tab">
                        <span>Applications</span>
                    </a>
                  </li>
                  <li>
                    <a href="#resumes" aria-controls="resumes" role="tab" data-toggle="tab">
                        <span>Job Seekers</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li v-if="canEdit">
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-home icon text-warning-lter"></i>
                  <span class="font-bold">Organizations</span>
                </a>
                <ul class="nav nav-sub dk">
                  <li class="nav-sub-header">
                    <a href><span>Organizations</span></a>
                  </li>
                  <li>
                    <a href="#employers" aria-controls="employers" role="tab" data-toggle="tab">
                        <span>Employers</span>
                    </a>
                  </li>
                  <li>
                    <a href="#schools" aria-controls="schools" role="tab" data-toggle="tab">
                        <span>Schools</span>
                    </a>
                  </li>
                </ul>
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

              <li v-if="isAdmin">
                <a href="#badges" aria-controls="badges" role="tab" data-toggle="tab">
                  <i class="glyphicon glyphicon-certificate icon"></i>
                  <span class="font-bold">Badges</span>
                </a>
              </li>

              <li v-if="isAdmin">
                <a href="#plans" aria-controls="plans" role="tab" data-toggle="tab">
                  <i class="glyphicon glyphicon-shopping-cart icon"></i>
                  <span class="font-bold">Pricing Plans</span>
                </a>
              </li>

              <li v-if="isAdmin && canDoScreening">
                <a href="#screening" aria-controls="screening" role="tab" data-toggle="tab">
                  <i class="glyphicon glyphicon-question-sign icon"></i>
                  <span class="font-bold">Screening Qs</span>
                </a>
              </li>

              <!--
              <li v-if="isAdmin">
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
                    <a href="#university" aria-controls="university" role="tab" data-toggle="tab">
                        <span>Universities</span>
                    </a>
                  </li>
                  <li>
                    <a href="#industry" aria-controls="industry" role="tab" data-toggle="tab">
                        <span>Industries</span>
                    </a>
                  </li>
                  <li>
                    <a href="#jtypes" aria-controls="jtypes" role="tab" data-toggle="tab">
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
             -->

              <li v-if="isAdmin">
                <a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab">
                  <i class="glyphicon glyphicon-ok-circle icon"></i>
                  <span class="font-bold">Permissions</span>
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
                  <span class="font-bold">{{ $name }} Profile</span>
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

            <div v-if="canEdit" role="tabpanel" class="tab-pane" id="schools">
                @include('dashboards.organizations.schools')
            </div>

            <div v-if="canEdit && canDoEvents" role="tabpanel" class="tab-pane" id="events">
                @include('dashboards.events.index')
            </div>
         
            <div v-if="isAdmin" role="tabpanel" class="tab-pane" id="permissions">
                @include('dashboards.permissions.index')
            </div>

            <div v-if="isAdmin" role="tabpanel" class="tab-pane" id="badges">
                @include('dashboards.badges.index')
            </div>

            <div v-if="isAdmin" role="tabpanel" class="tab-pane" id="plans">
                @include('dashboards.plans.index')
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
