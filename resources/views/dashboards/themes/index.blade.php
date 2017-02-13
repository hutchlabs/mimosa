<gradlead-themes-screen inline-template>

    <div class="col wrapper-md">

    <!-- Update theme -->
    <div class="panel hbox hbox-auto-xs no-border" v-if="everythingLoaded">

        <div class="wrapper-md">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default nav-tabs-alt no-border">
                        <ul class="nav nav-tabs nav-justified no-border">
                            <li role="presentation" class="active">
                                <a href="#themehome" aria-controls="themehome" role="tab" data-toggle="tab">
                                    <b>Home Page</b>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#themesch" aria-controls="themesch" role="tab" data-toggle="tab">
                                   <b>School Page</b>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#themecontact" aria-controls="themecontact" role="tab" data-toggle="tab">
                                    <b>Contact Page</b>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <spark-error-alert :form="forms.updateTheme"></spark-error-alert>

            <!-- Edit Form -->
            <form class="form-horizontal" role="form">

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <!-- Home page -->
                            <div role="tabpanel" class="tab-pane active" id="themehome">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Hero Banner</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;" style="padding: 10px">

                                                <spark-text2 :display="'Hero Text*'" :form="forms.updateTheme" :name="'home_header'" :input.sync="forms.updateTheme.home_header">
                                                </spark-text2>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">1st Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'home_first_title'" :input.sync="forms.updateTheme.home_first_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'home_first'" :input.sync="forms.updateTheme.home_first">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">2nd Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'home_second_title'" :input.sync="forms.updateTheme.home_second_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'home_second'" :input.sync="forms.updateTheme.home_second">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">3rd Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'home_third_title'" :input.sync="forms.updateTheme.home_third_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'home_third'" :input.sync="forms.updateTheme.home_third">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="m-t m-b">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-info btn-addon" @click.prevent="updateTheme" :disabled="forms.updateTheme.busy">
                                            <span v-if="forms.updateTheme.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                                            <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Schools page -->
                            <div role="tabpanel" id="themesch" class="tab-pane">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Hero Banner</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">

                                                <spark-text2 :display="'Hero Text*'" :form="forms.updateTheme" :name="'schools_header'" :input.sync="forms.updateTheme.schools_header">
                                                </spark-text2>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">1st Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'schools_first_title'" :input.sync="forms.updateTheme.schools_first_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'schools_first'" :input.sync="forms.updateTheme.schools_first">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">2nd Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'schools_second_title'" :input.sync="forms.updateTheme.schools_second_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'schools_second'" :input.sync="forms.updateTheme.schools_second">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">3rd Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'schools_third_title'" :input.sync="forms.updateTheme.schools_third_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'schools_third'" :input.sync="forms.updateTheme.schools_third">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="m-t m-b">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-info btn-addon" @click.prevent="updateTheme" :disabled="forms.updateTheme.busy">
                                            <span v-if="forms.updateTheme.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                                            <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        
                        
                              <!-- Contact Us page -->
                            <div role="tabpanel" id="themecontact" class="tab-pane">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Hero Banner</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">

                                                <spark-text2 :display="'Hero Text*'" :form="forms.updateTheme" :name="'contact_header'" :input.sync="forms.updateTheme.contact_header">
                                                </spark-text2>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">1st Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'contact_first_title'" :input.sync="forms.updateTheme.contact_first_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'contact_first'" :input.sync="forms.updateTheme.contact_first">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">2nd Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'contact_second_title'" :input.sync="forms.updateTheme.contact_second_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'contact_second'" :input.sync="forms.updateTheme.contact_second">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">3rd Block</div>
                                            <div class="panel-body" style="padding: 15px 30px 30px 30px;">
                                                <spark-text2 :display="'Title*'" :form="forms.updateTheme" :name="'contact_third_title'" :input.sync="forms.updateTheme.contact_third_title">
                                                </spark-text2>

                                                <spark-textarea :display="'Text*'" :form="forms.updateTheme" :name="'contact_third'" :input.sync="forms.updateTheme.contact_third">
                                                </spark-textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="m-t m-b">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-info btn-addon" @click.prevent="updateTheme" :disabled="forms.updateTheme.busy">
                                            <span v-if="forms.updateTheme.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                                            <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                                        </button>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- / Update Theme -->
</div>

        @include('dashboards.themes.edit')
</gradlead-themes-screen>

