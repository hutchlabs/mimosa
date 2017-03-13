<div class="hbox hbox-auto-xs hbox-auto-sm" v-if="everythingLoaded">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Alerts</h1>
          <small class="text-muted">@{{authUser.name}}'s Alerts</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
        <gradlead-alert :auth-user="authUser"></gradlead-alert>  
    </div>
  
  </div>
  <!-- / main -->
</div>
