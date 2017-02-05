<div class="col wrapper-md">
   
    <div class="clearfix m-b">
        <a class="btn btn-default btn-addon" href="#questionnaires" aria-controls="questionnaires" role="tab" data-toggle="tab">
            <i class="fa fa-long-arrow-left"></i> Back
        </a>&nbsp;&nbsp;
        <h4 style="display:inline">@{{ currentQn.name }} >> Questions</h4>
    </div>
    
    <div class="clearfix m-b">
        <a class="btn btn-info btn-addon" href="#addquestion" aria-controls="addquestion" role="tab" data-toggle="tab" @click="setQuestionnaire(currentQn)" @mouseover="clearFields('qAddForm')">
            <i class="fa fa-plus"></i> Add Question
        </a>
    </div>

    <!-- Questions -->
    <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
            <!-- table -->
            <div class="table-responsive" v-if="questions.length> 0">

                <table class="table table-striped m-b-none">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Required</th>
                            <th>Answer Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in questions">
                            <td class="spark-table-pad"> @{{ i.caption }} </td>
                            <td class="spark-table-pad"> @{{ i.is_required | auto_reply_text }} </td>
                            <td class="spark-table-pad"> @{{ i.type | type_text }} </td>

                            <td class="spark-table-pad">
                                <a class="btn btn-info btn-sm" href="#editquestion" aria-controls="editquestion" role="tab" data-toggle="tab" @click="setQuestion(i)" @mouseover="clearFields('qUpdateForm')">
                                    <i class="fa fa-pencil"></i></a>

                                <button class="btn btn-danger  btn-sm" @click.prevent="removeQuestion(i)">
                                    <span><i class="fa fa-trash-o"></i></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="panel-body">
                No questions found.
            </div>

        </div>

    </div>
    <!-- / Questions -->

</div>
