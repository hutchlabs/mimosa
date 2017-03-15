<div class="hbox hbox-auto-xs hbox-auto-sm">
  <!-- main -->
  <div class="col">
    
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Bookmarks</h1>
          <small class="text-muted">@{{authUser.name}}'s Bookmarks</small>
        </div>
      </div>
    </div>
    <!-- / main header -->
   
    <div class="col wrapper-md">
        <gradlead-bookmark :auth-user="authUser"></gradlead-bookmark>  
    </div>
  
  </div>
  <!-- / main -->
</div>
