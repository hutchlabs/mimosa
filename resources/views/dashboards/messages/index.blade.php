<gradlead-inbox-screen v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype"  inline-template>
    <div>

        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
                <!-- main header -->
                <div class="bg-light lter b-b wrapper-md">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <h1 class="m-n font-thin h3 text-black">Messages</h1>
                            <small class="text-muted">@{{authUser.name}} messages</small>
                        </div>
                    </div>
                </div>
                <!-- / main header -->
            </div>
        </div>

        <div class="hbox hbox-auto-xs hbox-auto-sm bg-light fade-up-in" style="height:780px" v-if="everythingLoaded">
            
            <!-- Folders -->
            <div class="col w b-r">
                <div class="vbox">
                    <div class="wrapper b-b">
                         <button class="btn btn-sm btn-default pull-right visible-sm visible-xs" ui-toggle-class="show" 
                                target="#email-menu"><i class="fa fa-bars"></i></button>
                         <a @click.prevent="compose()" class="btn btn-sm btn-danger w-xs font-bold">Compose</a>
                    </div>

                    <div class="row-row">
                        <div class="cell scrollable hover">
                            <div class="cell-inner">
                                <div class="list-group no-radius no-border no-bg m-b-none">
                                    <a class="list-group-item b-b" :class="(filter=='') ? 'focus':''" @click.prevent="selectBin({name:''})">
                                        Inbox <b :class="binCountClass('')">@{{ binCount('') }}</b>
                                    </a>
                                    <a v-for="item in bins" class="list-group-item m-l hover-anchor b-a no-select" :class="((filter==item.name) ? 'focus m-l-none': '')" @click.prevent="selectBin(item)">
                                        <span class="block m-l-n" :class="(filter==item.name ? 'm-n': '')">@{{item.name}}
                                            <b class="badge bg-default pull-right">@{{ binCount(item.name) }}</b>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper b-t">&nbsp;</div>
                </div>
            </div>
            <!-- / Folders -->

            <!-- Messages -->
 			<div v-show="listView">
				<div class="wrapper bg-light lter b-b">
				    <div class="btn-toolbar">
				      <div class="btn-group dropdown" v-if="filter==''">
				        <button class="btn btn-default btn-sm btn-bg dropdown-toggle" data-toggle="dropdown">
				          <span class="dropdown-label">Filter</span>
				          <span class="caret"></span>
				        </button>
				        <ul class="dropdown-menu text-left text-sm">
				          <li><a @click.prevent="filterInbox('')">All</a></li>
				          <li><a @click.prevent="filterInbox('unread')">Unread</a></li>
				          <li><a @click.prevent="filterInbox('read')">Read</a></li>
				        </ul>
                        </div>
				    </div>
			    </div>
				<ul class="list-group list-group-lg no-radius m-b-none m-t-n-xxs">
				    <li v-for="mail in availableMsgs" :class="labelClass(mail)" class="list-group-item clearfix b-l-3x">
				      <a :href="getUrl(mail)" target="_blank" class="avatar thumb pull-left m-r">
				        <img :src="getImage(mail)">
				      </a>
				      <div class="pull-right text-sm text-muted">
				        <span class="hidden-xs">@{{ mail.created_at | fromNow }}</span>
				      </div>
				      <div class="clear">
				        <div><a @click.prevent="selectMsg(mail)" class="text-md" style="color:#336699">@{{mail.subject}}</a></div>
				        <div class="text-ellipsis m-t-xs" v-html="limitTo(mail.message,100)"></div>
				      </div>
				    </li>
				  </ul>
			</div>
            <!-- / Messages -->

            <!-- Message -->
            <div v-show="messageView" class="col bg-white-only">
				<div class="wrapper bg-light lter b-b">
				    <div class="btn-group m-r-sm pull-right">
				      <button v-show="isInbox(currentMsg)" class="btn btn-sm btn-default w-xxs w-auto-xs" tooltip="Delete" @click.prevent="trashMsg(currentMsg)"><i class="fa fa-trash-o"></i></button>
				    </div>

				    <a @click.prevent="showList()" class="btn btn-sm btn-default w-xxs m-r-sm" tooltip="Back to Inbox"><i class="fa fa-long-arrow-left"></i></a>
				 </div>
				<div class="wrapper b-b">
				    <h2 class="font-thin m-n">@{{currentMsg.subject}}</h2>
				  </div>
				  <div class="wrapper b-b">
				    <img :src="getImage(currentMsg)" class="img-circle thumb-xs m-r-sm">
				    from @{{currentMsg.from.name}} (@{{currentMsg.from.orgname}})  <span class="text-muted">@{{currentMsg.created_at | fromNow }}</span>
				  </div>
				  <div class="wrapper" v-html="currentMsg.message"> </div>
				  <div class="wrapper" v-show="isInbox(currentMsg)">
				    <div class="panel b-a">
				      <div class="panel-heading" v-show="!reply">
				        <div class="m-b-lg">
				        Click here to <a href class="text-u-l" @click.prevent="reply=!reply">Reply</a>
				        </div>
				      </div>
				      <div class="ng-hide" v-show="reply">
				        <div class="panel-heading b-b b-light"> @{{currentMsg.from.email}} </div>
				        <div class="panel-heading b-b b-light"> Re: @{{currentMsg.subject}} </div>
				        <div class="wrapper" contenteditable="true" style="min-height:100px"></div>
				        <div class="panel-footer bg-light lt">
				          <button class="btn btn-link pull-right" @click.prevent="reply=!reply"><i class="fa fa-trash-o"></i></button>
				          <button class="btn btn-info w-xs font-bold" @click.prevent="replyMsg(msg)">Send</button>
				        </div>
				      </div>
				    </div>
				  </div>
            </div>
            <!-- / Message -->
            
            <!-- Compose -->
            <div v-show="composeView" class="col bg-white-only">
				  <!-- header -->
				  <div class="wrapper bg-light lter b-b">
				    <div class="btn-group m-r-sm">
				      <a @click.prevent="sendMsg()" class="btn btn-sm btn-default w-xxs w-auto-xs" tooltip="Save"><i class="fa fa-file"></i></a>
				      <a @click.prevent="showList()" class="btn btn-sm btn-default w-xxs w-auto-xs" tooltip="Discard"><i class="fa fa-trash-o"></i></a>
				    </div>
				  </div>
				  <!-- / header -->
                  
                  <div class="wrapper b-b">
                    <form name="newMail" class="form-horizontal m-t-lg">
                      <div class="form-group">
                        <label class="col-lg-2 control-label">To:</label>
                        <div class="col-lg-8">

                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Subject:</label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-10">
                          <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar" data-target="#editor">
                            <div class="btn-group dropdown">
                              <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" tooltip="Font"><i class="fa text-base fa-font"></i><b class="caret"></b></a>
                              <ul class="dropdown-menu">
                                <li><a href dropdown-toggle data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li> 
                                <li><a href dropdown-toggle data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li>
                                <li><a href dropdown-toggle data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li></ul>
                            </div>
                            <div class="btn-group dropdown">
                              <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" tooltip="Font Size"><i class="fa text-base fa-text-height"></i>&nbsp;<b              class="caret"></b></a>
                              <ul class="dropdown-menu">
                                <li><a href dropdown-toggle data-edit="fontSize 5" style="font-size:24px">Huge</a></li>
                                <li><a href dropdown-toggle data-edit="fontSize 3" style="font-size:18px">Normal</a></li>
                                <li><a href dropdown-toggle data-edit="fontSize 1" style="font-size:14px">Small</a></li>
                              </ul>
                            </div>
                            <div class="btn-group">
                              <a class="btn btn-sm btn-default" data-edit="bold" tooltip="Bold (Ctrl/Cmd+B)"><i class="fa text-base fa-bold"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="italic" tooltip="Italic (Ctrl/Cmd+I)"><i class="fa text-base fa-italic"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="strikethrough" tooltip="Strikethrough"><i class="fa text-base fa-strikethrough"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="underline" tooltip="Underline (Ctrl/Cmd+U)"><i class="fa text-base fa-underline"></i></a>
                            </div>
                           <div class="btn-group">
                              <a class="btn btn-sm btn-default" data-edit="insertunorderedlist" tooltip="Bullet list"><i class="fa text-base fa-list-ul"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="insertorderedlist" tooltip="Number list"><i class="fa text-base fa-list-ol"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="outdent" tooltip="Reduce indent (Shift+Tab)"><i class="fa text-base fa-dedent"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="indent" tooltip="Indent (Tab)"><i class="fa text-base fa-indent"></i></a>
                            </div>
                            <div class="btn-group">
                              <a class="btn btn-sm btn-default" data-edit="justifyleft" tooltip="Align Left (Ctrl/Cmd+L)"><i class="fa text-base fa-align-left"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="justifycenter" tooltip="Center (Ctrl/Cmd+E)"><i class="fa text-base fa-align-center"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="justifyright" tooltip="Align Right (Ctrl/Cmd+R)"><i class="fa text-base fa-align-right"></i></a>
                              <a class="btn btn-sm btn-default" data-edit="justifyfull" tooltip="Justify (Ctrl/Cmd+J)"><i class="fa text-base fa-align-justify"></i></a>
                            </div>
                          </div>
                          <div ui-jq="wysiwyg" class="form-control h-auto" style="min-height:200px;">
                            Go ahead&hellip;
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                          <button class="btn btn-info w-xs">Send</button>
                        </div>
                      </div>
                    </form>
                  </div>
            </div> 
            <!-- / Compose -->
        </div>

    </div>
</gradlead-inbox-screen>
