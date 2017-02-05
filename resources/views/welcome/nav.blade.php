<div class="nav-container">
  <nav class="top-bar">
    <div class="container">
     
      <div class="row utility-menu">
        <div class="col-sm-12">
          <div class="utility-inner clearfix">
             <div class="pull-right">
                  <spark-authenticate></spark-authenticate>
             </div>
            </div>
        </div>
      </div>
      
      <div class="row nav-menu">
        <div class="col-sm-3 col-md-2 columns">
          <a style="cursor: pointer" routerLink="/home" routerLinkActive="active">
            <img class="logo logo-light" alt="Logo" src="dist/assets/img/gradlead-light.png">
            <img class="logo logo-dark" alt="Logo" src="dist/assets/img/gradlead-dark.png">
          </a>
        </div>

        <div class="col-sm-9 col-md-10 columns">
          <ul class="menu">

            <li class=""><a style="cursor: pointer" routerLink="/home" routerLinkActive="active">Home</a></li>

            <li class=""><a style="cursor: pointer" routerLink="/jobs" routerLinkActive="active">Job Search</a></li>

            <li class=""><a style="cursor: pointer" routerLink="/employers" routerLinkActive="active">Employer Search</a> </li>

            <li class=""><a style="cursor: pointer" routerLink="/schools" routerLinkActive="active">Schools</a></li>

            <li class=""><a style="cursor: pointer" routerLink="/contact" routerLinkActive="active">Contact</a></li>

          </ul>
        </div>
      </div>
     
      <div class="mobile-toggle">
        <i class="icon icon_menu"></i>
      </div>
   
    </div>
  </nav>
</div>