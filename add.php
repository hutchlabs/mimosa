<div class="modal fade" id="modal-add-edu" tabindex="-1" role="dialog" style="margin:auto; width: 760px">\
    <div class="modal-dialog">\
        <div class="modal-content">\
            <div class="modal-header">\
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i> Add Education</h4>\
            </div>\
\
            <div class="modal-body">\
\
                <spark-error-alert :form="forms.addForm"></spark-error-alert>\
\
                <!-- Add Form -->\
                <form class="form-horizontal" role="form">\
                    <div class="row">\
                        <div class="col-md-6">\
                            <spark-select :display="'University'" \
                                          :form="forms.addForm" \
                                          :name="'univerity'" \
                                          :items="universityOptions" \
                                          :input="forms.addForm.univerity">\
                            </spark-select>\
                        </div>\
                        <div class="col-md-6">\
                            <spark-select :display="'Country'" \
                                          :form="forms.addForm" \
                                          :name="'country'" \
                                          :items="countryOptions" \
                                          :input="forms.addForm.country">\
                            </spark-select>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-6">\
                            <spark-select :display="'Degree'" \
                                          :form="forms.addForm" \
                                          :name="'degree_level'" \
                                          :items="degreeOptions" \
                                          :input="forms.addForm.degree_level">\
                            </spark-select>\
                        </div>\
                        <div class="col-md-6">\
                            <spark-select :display="'Major'" \
                                          :form="forms.addForm" \
                                          :name="'degree_major'" \
                                          :items="majorOptions" \
                                          :input="forms.addForm.degree_major">\
                            </spark-select>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-6">\
                            <spark-select :display="'Graduation'" \
                                          :form="forms.addForm" \
                                          :name="'graduation_month'" \
                                          :items="monthOptions" \
                                          :input="forms.addForm.graduation_month">\
                            </spark-select>\
                        </div>\
                        <div class="col-md-6">\
                            <spark-select :display="''" \
                                          :form="forms.addForm" \
                                          :name="'graduation_year'" \
                                          :items="yearOptions" \
                                          :input="forms.addForm.graduation_year">\
                            </spark-select>\
                        </div>\
                    </div>\
                </form>\
            </div>\
\
            <div class="modal-footer">\
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                <button type="button" class="btn btn-primary btn-addon" @click.prevent="addNewEdu()" :disabled="forms.addForm.busy">\
                    <span v-if="forms.addForm.busy"> <i class="fa fa-btn fa-spinner fa-spin"></i> Adding </span>\
                    <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>\
                </button>\
            </div>\
        </div>\
    </div>\
</div>\
