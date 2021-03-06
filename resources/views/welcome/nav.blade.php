<div class="nav-container">
  <nav class="top-bar">
    <div class="container">
     
      <div class="row utility-menu">

        <div class="col-sm-12">
          <div class="utility-inner clearfix" style="padding-bottom:0; border:none">
        
            <div class="col-sm-3 col-md-2 columns">
                <a style="cursor: pointer" href="/">
                    <img class="logo logo-light" style="bottom:0" alt="Logo" src="/dist/assets/img/gradlead-light.png">
                    <img class="logo logo-dark" style="bottom:0" alt="Logo" src="/dist/assets/img/gradlead-dark.png">
                </a>
            </div>

            <ul class="menu pull-left" style="top:10px;">
                <li><a style="color: {{ ($link=='home')? '#339966': ''}}" href="/">Home</a></li>
                <li><a style="color: {{ (substr($link,0,3)=='jobs')? '#339966': ''}}" href="/vjobs">Jobs</a></li>
                <li>
                    <a style="color: {{ (substr($link,0,8)=='employers')? '#339966': ''}}" href="/employers">
                        Employers
                    </a>
                </li>
                <li><a style="color: {{ ($link=='partners')? '#339966': ''}}" href="/partners">Partners</a></li>
                <li><a style="color: {{ ($link=='contact')? '#339966': ''}}" href="/contact">Contact</a></li>
            </ul>

             <div class="pull-right">
                  <gradlead-authenticate></gradlead-authenticate>
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
