<gradlead-search-screen v-bind:hpath="hpath" v-bind:hsearch="hsearch" v-bind:auth-user="authUser" v-bind:permissions="permissions" v-bind:usertype="usertype" inline-template>
    <div>
        <a href="#detailpage" ref="toJobPage" aria-controls="detailpage" role="tab" data-toggle="tab" style="display:none"></a>
            
        <div class="tab-content">
        
            <div role="tabpanel" :class="tabClass('sp')" id="searchpage">

                <div class="bg-light lter b-b wrapper-md">
                    <h1 class="m-n font-thin h3"><i class="icon-magnifier i-sm m-r-sm"></i> Job Search</h1>
                </div>

                <div class="wrapper-md">
                    <form action="#" class="m-b-md">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" v-model="q" class="form-control input-lg" placeholder="what are you looking for?">
                            </div>
                            <div class="col-md-5">
                                <input type="text" v-model="l" class="form-control input-lg" placeholder="where do you want to work?">
                            </div>
                            <div class="col-md-2">
                                <span class="input-group-btn">
                                    <button @click.prevent="search()" class="btn btn-lg btn-default" type="button">Search</button>
                                 </span>
                            </div>
                          </div>
                       </form>

                    <div class="row" style="border:0px solid red; padding-top: 20px">
                        <div v-if="isSearch" class="col-md-6">
                            <span v-if="!hasBookmarkedSearch()">
                                <a @click.prevent="bookmarkSearch()">
                                   <span class="label bg-info pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Bookmark Search Results
                                   </span> 
                                </a>
                            </span>
                            <span v-else>
                                <a @click.prevent="unbookmarkSearch()">
                                   <span class="label bg-danger pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Un-Bookmark Search Results
                                   </span> 
                                </a>
                            </span>
                        </div>
                        <div class="col-md-6">
                          <p class="m-b-md pull-right" ref="resultsText"></p>
                        </div>
                    </div>
                    
                    <div class="wrapper bg-white b-b">
                        <ul class="nav nav-pills nav-sm">
                            <li role="presentation" class="active">
                                <a href="#all" aria-controls="all" role="tab" data-toggle="tab">
                                    <span class="badge badge-sm m-l-xs">@{{ allCount }}</span>&nbsp;All Jobs
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#mysch" aria-controls="mysch" role="tab" data-toggle="tab">
                                    <span class="badge badge-sm m-l-xs">@{{ schoolCount}}</span>&nbsp;&nbsp;{{$name}} Jobs
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#feeds" aria-controls="all" role="tab" data-toggle="tab">
                                   <span class="badge badge-sm m-l-xs">@{{ otherCount }}</span>&nbsp;&nbsp;Job Feeds</a>
                            </li>
                          </ul>
                    </div>

                    <div class="wrapper bg-white b-b">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">

                                    <!-- All Job detals -->
                                    <div role="tabpanel" class="tab-pane active" id="all">
                                        <ul class="list-group list-group-alt list-group-lg no-borders pull-in m-b-none">

                                            <li v-for="j in jobsAll" class="list-group-item" style="border-bottom: 1px dashed #aaa">

                                                <a :href="getOrgUrl(j)" target="_blank" class="pull-right thumb-md m-r">
                                                    <img :src="j.orglogo" :alt="j.orgname">
                                                </a>

                                                <div class="clear">
                                                    <a @click.prevent="showJob(j)" :href="getJobUrl(j)" class="h4 text-primary m-b-sm m-t-sm block">@{{j.title}}</a>
                                                    <p>@{{ j.description_text }}</p>
                                                    <div style="padding-top: 10px">
                                                        <span v-if="!hasBookmarked(j)">
                                                            <a @click.prevent="bookmarkJob(j)">
                                                               <span class="label bg-info pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Bookmark
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-else>
                                                            <a @click.prevent="unbookmarkJob(j)">
                                                               <span class="label bg-danger pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Un-Bookmark
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-if="!hasApplied(j)">
                                                            <a @click.prevent="apply(j)">
                                                               <span class="label bg-primary pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-open"></i> Apply
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-else class="text-muted">
                                                            Applied. Status: @{{ appStatus(j.id) }}
                                                        </span>
                                                    </div>
                                                    <span class="text-muted" style="font-size:10px">Posted: @{{ j.created_at }}</span>        
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="mysch">
                                        <ul class="list-group list-group-alt list-group-lg no-borders pull-in m-b-none">

                                            <li v-for="j in jobsSchool"  class="list-group-item">
                                                <a :href="getOrgUrl(j)" target="_blank" class="pull-right thumb-md m-r" style="">
                                                    <img :src="j.orglogo" :alt="j.orgname">
                                                </a>

                                                <div class="clear">
                                                    <a @click.prevent="showJob(j)" :href="getJobUrl(j)" class="h4 text-primary m-b-sm m-t-sm block">@{{j.title}}</a>
                                                    <p>@{{ j.description_text }}</p>
                                                    <div style="padding-top: 10px">
                                                        <span v-if="!hasBookmarked(j)">
                                                            <a @click.prevent="bookmarkJob(j)">
                                                               <span class="label bg-info pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Bookmark
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-else>
                                                            <a @click.prevent="unbookmarkJob(j)">
                                                               <span class="label bg-danger pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Un-Bookmark
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-if="!hasApplied(j)">
                                                            <a @click.prevent="apply(j)">
                                                               <span class="label bg-primary pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-open"></i> Apply
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-else class="text-muted">
                                                            Applied. Status: @{{ appStatus(j.id) }}
                                                        </span>
                                                    </div>
                                                    <span class="text-muted" style="font-size:10px">Posted: @{{ j.created_at }}</span>        
                                                </div>
                                            </li>
                                        </ul>

                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="feeds">
                                         <ul class="list-group list-group-alt list-group-lg no-borders pull-in m-b-none">

                                            <li v-for="j in jobsOther"  class="list-group-item">
                                                <a :href="getOrgUrl(j)" target="_blank" class="pull-right thumb-md m-r" style="">
                                                    <img :src="j.orglogo" :alt="j.orgname">
                                                </a>

                                                <div class="clear">
                                                    <a @click.prevent="showJob(j)" :href="getJobUrl(j)" class="h4 text-primary m-b-sm m-t-sm block">@{{j.title}}</a>
                                                    <p>@{{ j.description_text }}</p>
                                                    <div style="padding-top: 10px">
                                                        <span v-if="!hasBookmarked(j)">
                                                            <a @click.prevent="bookmarkJob(j)">
                                                               <span class="label bg-info pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Bookmark
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-else>
                                                            <a @click.prevent="unbookmarkJob(j)">
                                                               <span class="label bg-danger pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-bookmark"></i> Un-Bookmark
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-if="!hasApplied(j)">
                                                            <a @click.prevent="apply(j)">
                                                               <span class="label bg-primary pos-rlt m-r inline wrapper-xs"><i class="glyphicon glyphicon-open"></i> Apply
                                                               </span> 
                                                            </a>
                                                        </span>
                                                        <span v-else class="text-muted">
                                                            Applied. Status: @{{ appStatus(j.id) }}
                                                        </span>
                                                    </div>
                                                    <span class="text-muted" style="font-size:10px">Posted: @{{ j.created_at }}</span>        
                                                </div>
                                            </li>
                                        </ul>                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div role="tabpanel" :class="tabClass('detail')" id="detailpage">
                @include('dashboards.jobs.detail') 
            </div>
            
            @include('dashboards.jobs.apply') 

        </div>
    </div>
</gradlead-search-screen>
