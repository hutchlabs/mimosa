<div class="modal fade" id="modal-edit-plan" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i> Update Plan</h4>
            </div>

            <div class="modal-body">

                <spark-error-alert :form="forms.updatePlan"></spark-error-alert>

                <!-- Update Form -->
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <spark-hidden :form="forms.updatePlan" :name="'id'" 
                                  :input.sync="forms.updatePlan.id"></spark-hidden>

                            <spark-date :display="'Start Date*'" :form="forms.updatePlan" :name="'start_date'" 
                                        :input.sync="forms.updatePlan.start_date">
                            </spark-date>

                            <spark-date :display="'End Date*'" :form="forms.updatePlan" :name="'end_date'" 
                                        :input.sync="forms.updatePlan.end_date">
                            </spark-date>

                            <spark-text :display="'Name*'" :form="forms.updatePlan" :name="'name'" :input.sync="forms.updatePlan.name">
                            </spark-text>

                            <spark-text :display="'Description*'" :form="forms.updatePlan" :name="'description'" :input.sync="forms.updatePlan.description">
                            </spark-text>

                            <spark-text :display="'Cost*'" :form="forms.updatePlan" :name="'cost'" :input.sync="forms.updatePlan.cost">
                            </spark-text>

                            <spark-select :display="'# of Posts'" :form="forms.updatePlan" :name="'num_posts'" :items="numOptions" :input.sync="forms.updatePlan.num_posts">
                            </spark-select>

                            <spark-select :display="'# of Notifications'" :form="forms.updatePlan" :name="'num_notifications'" :items="numOptions" :input.sync="forms.updatePlan.num_notifications">
                            </spark-select>


                            <spark-select :display="'Feature Job'" :form="forms.updatePlan" :name="'feature_job'" :items="yesNoOptions" :input.sync="forms.updatePlan.feature_job">
                            </spark-select>

                            <spark-select :display="'Feature Company'" :form="forms.updatePlan" :name="'feature_company'" :items="yesNoOptions" :input.sync="forms.updatePlan.feature_company">
                            </spark-select>

                            <spark-select :display="'Duration'" :form="forms.updatePlan" :name="'duration'" :items="durationOptions" :input.sync="forms.updatePlan.duration">
                            </spark-select>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary btn-addon" @click.prevent="updatePlan" :disabled="forms.updatePlan.busy">
                    <span v-if="forms.updatePlan.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>
                    <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                </button>
            </div>
        </div>
    </div>
</div>
