<gradlead-stats-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype" inline-template>

<div class="hbox hbox-auto-xs hbox-auto-sm">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Dashboard</h1>
          <small class="text-muted">Welcome to Gradlead</small>
        </div>
        <div class="col-sm-6 text-right hidden-xs">
          <div class="inline m-r text-left">
            <div class="m-b-xs">1290 <span class="text-muted">jobs</span></div>
            <gradlead-sparkline-bar :data="data1"></gradlead-sparkline-bar>

          </div>
          <div class="inline text-left">
            <div class="m-b-xs">$30,000 <span class="text-muted">revenue</span></div>
            <!--
            <gradlead-sparkline-bar :data="data2"></gradlead-sparkline-bar>
            -->
          </div>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="wrapper-md">
      <!-- stats -->
      <div class="row">
        <div class="col-md-5">
          <div class="row row-sm text-center">
            <div class="col-xs-6">
              <div class="panel padder-v item">
                <div class="h1 text-info font-thin h1">521</div>
                <span class="text-muted text-xs">New items</span>
                <div class="top text-right w-full">
                  <i class="fa fa-caret-down text-warning m-r-sm"></i>
                </div>
              </div>
            </div>
            <div class="col-xs-6">
              <a href class="block panel padder-v bg-primary item">
                <span class="text-white font-thin h1 block">930</span>
                <span class="text-muted text-xs">Uploads</span>
                <span class="bottom text-right w-full">
                  <i class="fa fa-cloud-upload text-muted m-r-sm"></i>
                </span>
              </a>
            </div>
            <div class="col-xs-6">
              <a href class="block panel padder-v bg-info item">
                <span class="text-white font-thin h1 block">432</span>
                <span class="text-muted text-xs">Comments</span>
                <span class="top text-left">
                  <i class="fa fa-caret-up text-warning m-l-sm"></i>
                </span>
              </a>
            </div>
            <div class="col-xs-6">
              <div class="panel padder-v item">
                <div class="font-thin h1">129</div>
                <span class="text-muted text-xs">Feeds</span>
                <div class="bottom text-left">
                  <i class="fa fa-caret-up text-warning m-l-sm"></i>
                </div>
              </div>
            </div>
            <div class="col-xs-12 m-b-md">
              <div class="r bg-light dker item hbox no-border">
                <div class="col w-xs v-middle hidden-md">
                  <div ui-jq="sparkline" ui-options="[60,40], {type:'pie', height:40, sliceColors:['#fad733','#fff']}" class="sparkline inline"></div>
                </div>
                <div class="col dk padder-v r-r">
                  <div class="text-primary-dk font-thin h1"><span>$12,670</span></div>
                  <span class="text-muted text-xs">Revenue, 60% of the goal</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="panel wrapper">
            <label class="i-switch bg-warning pull-right">
              <input type="checkbox" v-model="showSpline">
              <i></i>
            </label>
            <h4 class="font-thin m-t-none m-b text-muted">Latest Campaign</h4>
            <!--
                <gradlead-plot :data="plot1", :colors="plot1C" :showSpline="showSpline" :tip="plot1T"></gradlead-plot>
            -->
          </div>
        </div>
      </div>
      <!-- / stats -->

      <!-- service -->
      <div class="panel hbox hbox-auto-xs no-border">
        <div class="col wrapper">
          <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
          <h4 class="font-thin m-t-none m-b-none text-primary-lt">Managed Services</h4>
          <span class="m-b block text-sm text-muted">Service report of this year (updated 1 hour ago)</span>
            <!--
                <gradlead-plot :data="plot2", :colors="plot2C" :showSpline="showSpline" :tips="plot2T"></gradlead-plot>
            -->
        </div>
        <div class="col wrapper-lg w-lg bg-light dk r-r">
          <h4 class="font-thin m-t-none m-b">Reports</h4>
          <div class="">
            <div class="">
              <span class="pull-right text-primary">60%</span>
              <span>Consulting</span>
            </div>
            <!--
            <progressbar value="60" class="progress-xs m-t-sm bg-white" animate="true" type="primary"></progressbar>
            -->
            <div class="">
              <span class="pull-right text-info">35%</span>
              <span>Online tutorials</span>
            </div>
            <!--
            <progressbar value="35" class="progress-xs m-t-sm bg-white" animate="true" type="info"></progressbar>
            -->
            <div class="">
              <span class="pull-right text-warning">25%</span>
              <span>EDU management</span>
            </div>
            <!--
            <progressbar value="25" class="progress-xs m-t-sm bg-white" animate="true" type="warning"></progressbar>
            -->
          </div>
          <p class="text-muted">Dales nisi nec adipiscing elit. Morbi id neque quam. Aliquam sollicitudin venenatis</p>
        </div>
      </div>
      <!-- / service -->
    </div>
  
  </div>
  <!-- / main -->
</div>

</gradlead-stats-screen>
