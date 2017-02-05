<div class="col wrapper-md">
    <div class="clearfix m-b">
        <a class="btn btn-info btn-addon" href="#addquestionnaire" aria-controls="addquestionnaire" role="tab" data-toggle="tab" @mouseover="clearFields('qnAddForm')">
            <i class="fa fa-plus"></i> Add Questionnaire
        </a>
    </div>

    <!-- Questionnaires -->
    <div class="panel hbox hbox-auto-xs no-border">

        <div class="col wrapper">
            <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
            <!-- table -->
            <div class="table-responsive" v-if="questionnaires.length> 0">

                <table class="table table-striped m-b-none">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Passing Score</th>
                            <th># of Questions</th>
                            <th>Auto-reply more?</th>
                            <th>Auto-reply less?</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in questionnaires">
                            <td class="spark-table-pad"> @{{ i.name }} </td>
                            <td class="spark-table-pad"> @{{ i.passing_score | passing_score_text }} </td>
                            <td class="spark-table-pad">
                                <span v-if="i.numquestions > 0">
                                    <b class="badge bg-info">  @{{ i.numquestions }}</b>
                                    <a class="btn btn-default btn-sm" href="#questions" aria-controls="questions" role="tab" data-toggle="tab" @click="setQuestionnaire(i)">View</a>    
                                </span>
                                <span v-else>
                                     <a class="btn btn-default btn-sm" href="#addquestion" aria-controls="addquestion" role="tab" data-toggle="tab" @click="setQuestionnaire(i)"  @mouseover="clearFields('qAddForm')">Add</a>
                                </span>
                            </td>
                            <td class="spark-table-pad"> @{{ i.send_auto_reply_more | auto_reply_text }} </td>
                            <td class="spark-table-pad"> @{{ i.send_auto_reply_less | auto_reply_text }} </td>

                            <td class="spark-table-pad">
                                <a class="btn btn-info btn-sm" href="#editquestionnaire" aria-controls="editquestionnaire" role="tab" data-toggle="tab" @click="setQuestionnaire(i)" @mouseover="clearFields('qnUpdateForm')">
                                    <i class="fa fa-pencil"></i></a>

                                <button class="btn btn-danger  btn-sm" @click.prevent="removeQuestionnaire(i)">
                                    <span><i class="fa fa-trash-o"></i></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="panel-body">
                No questionnaires found.
            </div>

        </div>

    </div>
    <!-- / Questionnaires -->

</div>
