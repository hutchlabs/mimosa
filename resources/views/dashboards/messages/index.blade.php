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
                <gradlead-inbox-compose :user="authUser" @goback="showList"></gradlead-inbox-compose>
            </div> 
            <!-- / Compose -->
        </div>

    </div>
</gradlead-inbox-screen>
