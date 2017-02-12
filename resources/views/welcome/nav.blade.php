<div class="nav-container">
  <nav class="top-bar">
    <div class="container">
     
      <div class="row utility-menu">

        <div class="col-sm-12">
          <div class="utility-inner clearfix" style="padding-bottom:0; border:none">
        
            <div class="col-sm-3 col-md-2 columns">
                <a style="cursor: pointer" href="home">
                    <img class="logo logo-light" style="bottom:0" alt="Logo" src="dist/assets/img/gradlead-light.png">
                    <img class="logo logo-dark" style="bottom:0" alt="Logo" src="dist/assets/img/gradlead-dark.png">
                </a>
            </div>

            <ul class="menu pull-left" style="top:10px;">
                <li class="{{ ($link=='home')? 'active': ''}}"><a style="cursor: pointer" href="">Home</a></li>
                <li class="{{ ($link=='schools')? 'active': ''}}"><a style="cursor: pointer" href="schools">Schools</a></li>
                <li class="{{ ($link=='contact')? 'active': ''}}"><a style="cursor: pointer" href="contact">Contact</a></li>
            </ul>

             <div class="pull-right">
                  <spark-authenticate></spark-authenticate>
             </div>
            </div>
        </div>
      </div>
      <div class="mobile-toggle">
        <i class="icon icon_menu"></i>
      </div>
    </div>
  </nav>
</div>
