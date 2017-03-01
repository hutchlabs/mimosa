<div class="modal fade" id="modal-edit-edu" tabindex="-1" role="dialog" style="margin:auto; width: 760px">\
    <div class="modal-dialog">\
        <div class="modal-content">\
            <div class="modal-header">\
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Update Education</h4>\
            </div>\
            <div class="modal-body">\
                <spark-error-alert :form="forms.updateForm"></spark-error-alert>\
                <!-- Add Form -->\
                <form class="form-horizontal" role="form">\
                    <div class="row">\
                        <div class="col-md-6">\
                            <spark-select :display="'University'" \
                                          :form="forms.updateForm" \
                                          :name="'univerity'" \
                                          :items="universityOptions" \
                                          :input.sync="forms.updateForm.univerity">\
                            </spark-select>\
                        </div>\
                        <div class="col-md-6">\
                            <spark-select :display="'Country'" \
                                          :form="forms.updateForm" \
                                          :name="'country'" \
                                          :items="countryOptions" \
                                          :input.sync="forms.updateForm.country">\
                            </spark-select>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-6">\
                            <spark-select :display="'Degree Level'" \
                                          :form="forms.updateForm" \
                                          :name="'degree_level'" \
                                          :items="degreeOptions" \
                                          :input.sync="forms.updateForm.degree_level">\
                            </spark-select>\
                        </div>\
                        <div class="col-md-6">\
                            <spark-select :display="'Major'" \
                                          :form="forms.updateForm" \
                                          :name="'degree_major'" \
                                          :items="majorOptions" \
                                          :input.sync="forms.updateForm.degree_major">\
                            </spark-select>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-6">\
                            <spark-select :display="'Graduation'" \
                                          :form="forms.updateForm" \
                                          :name="'graduation_month'" \
                                          :items="monthOptions" \
                                          :input.sync="forms.updateForm.graduation_month">\
                            </spark-select>\
                        </div>\
                        <div class="col-md-6">\
                            <spark-select :display="''" \
                                          :form="forms.updateForm" \
                                          :name="'graduation_year'" \
                                          :items="yearOptions" \
                                          :input.sync="forms.updateForm.graduation_year">\
                            </spark-select>\
                        </div>\
                    </div>\
                </form>\
            </div>\
            <div class="modal-footer">\
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                <button type="button" class="btn btn-primary btn-addon" @click.prevent="updateForm()" :disabled="forms.updateForm.busy">\
                    <span v-if="forms.updateForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Updating </span>\
                    <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>\
                </button>\
            </div>\
        </div>\
    </div>\
</div>\
