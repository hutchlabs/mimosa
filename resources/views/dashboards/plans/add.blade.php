<div class="modal fade" id="modal-add-plan" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Plan</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.addPlan"></spark-error-alert>

                <!-- Add Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <spark-date :display="'Start Date*'" :form="forms.addPlan" :name="'start_date'" 
                                        :input="forms.addPlan.start_date">
                            </spark-date>

                            <spark-date :display="'End Date*'" :form="forms.addPlan" :name="'end_date'" 
                                        :input="forms.addPlan.end_date">
                            </spark-date>

                            <spark-text :display="'Name*'" :form="forms.addPlan" :name="'name'" :input="forms.addPlan.name">
                            </spark-text>

                            <spark-text :display="'Description*'" :form="forms.addPlan" :name="'description'" :input="forms.addPlan.description">
                            </spark-text>

                            <spark-text :display="'Cost*'" :form="forms.addPlan" :name="'cost'" :input="forms.addPlan.cost">
                            </spark-text>

                            <spark-select :display="'# of Posts'" :form="forms.addPlan" :name="'num_posts'" :items="numOptions" :input="forms.addPlan.num_posts">
                            </spark-select>

                            <spark-select :display="'# of Notifications'" :form="forms.addPlan" :name="'num_notifications'" :items="numOptions" :input="forms.addPlan.num_notifications">
                            </spark-select>


                            <spark-select :display="'Feature Job'" :form="forms.addPlan" :name="'feature_job'" :items="yesNoOptions" :input="forms.addPlan.feature_job">
                            </spark-select>

                            <spark-select :display="'Feature Company'" :form="forms.addPlan" :name="'feature_company'" :items="yesNoOptions" :input="forms.addPlan.feature_company">
                            </spark-select>

                            <spark-select :display="'Duration'" :form="forms.addPlan" :name="'duration'" :items="durationOptions" :input="forms.addPlan.duration">
                            </spark-select>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewPlan" :disabled="forms.addPlan.busy">
                    <span v-if="forms.addPlan.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Adding
                        </span>

                    <span v-else>
                            <i class="fa fa-btn fa-save"></i> Add
                        </span>
                </button>
            </div>
        </div>
    </div>
</div>
