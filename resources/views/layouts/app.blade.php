<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="employers, recruiters, job search, jobs" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/simple-line-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/font.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" type="text/css" />
    <link href="{{ asset('css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" />

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]); ?>;
        window.Spark = { csrfToken: '{{  csrf_token() }}' };
    </script>
</head>
<body>
  <div class="app app-header-fixed" id="app">

    <gradlead-home-screen inline-template>
        <div v-if="userLoaded">

            <!-- navbar -->
            <div class="app-header navbar">
              <!-- navbar header -->
              <div class="navbar-header bg-dark">
                <button class="pull-right visible-xs dk" data-toggle="class:show" data-target=".navbar-collapse">
                  <i class="glyphicon glyphicon-cog"></i>
                </button>
                <button class="pull-right visible-xs" data-toggle="class:off-screen" data-target=".app-aside" ui-scroll="app">
                  <i class="glyphicon glyphicon-align-justify"></i>
                </button>
                <!-- brand -->
                <a href="#/" class="navbar-brand text-lt">
                  <i class="fa fa-graduation-cap"></i>
                  <img src="img/logo.png" alt="." class="hide">
                  <span class="hidden-folded m-l-xs">{{ strtok($name," ") }}</span>
                </a>
                <!-- / brand -->
              </div>
              <!-- / navbar header -->

              <!-- navbar collapse -->
              <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
                <!-- buttons -->
                <div class="nav navbar-nav hidden-xs">
                  <a href="#" class="btn no-shadow navbar-btn" data-toggle="class:app-aside-folded" data-target=".app">
                    <i class="fa fa-dedent fa-fw text"></i>
                    <i class="fa fa-indent fa-fw text-active"></i>
                  </a>
                </div>
                <!-- / buttons -->

                <!-- nabar right -->
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
                      <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                        <img v-bind:src="avatar" />
                        <i class="on md b-white bottom"></i>
                      </span>
                      <span class="hidden-sm hidden-md">{{ Auth::user()->name }}</span> <b class="caret"></b>
                    </a>
                    <!-- dropdown -->
                    <ul class="dropdown-menu animated fadeInRight w">
                      <li>
                        <a href="#yourprofile" aria-controls="yourprofile" role="tab" data-toggle="tab">Your Profile</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a style="cursor: pointer" @click.prevent="doLogout">Logout</a>
                      </li>
                    </ul>
                    <!-- / dropdown -->
                  </li>
                </ul>
                <!-- / navbar right -->

              </div>
              <!-- / navbar collapse -->
            </div>
            <!-- / navbar -->

            <!-- content -->
            @yield('content')
            <!-- / content -->

            <!-- footer -->
            <div class="app-footer wrapper b-t bg-light">
              <span class="pull-right">1.0.0 <a href="#app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>
              &copy; Gradlead 2017 Copyright.
            </div>
            <!-- / footer -->

        </div>

        <div v-else>
            <div style="position:fixed; top:50%; left:50%;">
                <bounce-loader :loading="1==1" :color="'#3AB982'" :size="'75px'"></bounce-loader>
            </div>
        </div>

    </gradlead-home-screen>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery.filer.min.js') }}"></script>
  <script src="{{ asset('js/vendors/dashboard.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7T2ffkCZ8eou8ylORC8C5SkMmWmSxyiM&libraries=places"></script>

   @yield('script')

</body>
</html>
