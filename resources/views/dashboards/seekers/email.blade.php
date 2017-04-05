<div class="modal fade" id="modal-email-seeker" tabindex="-1" role="dialog" style="margin:auto; width: 660px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i> Email Job Seekers</h4>
            </div>

            <div class="modal-body">
                <gradlead-inbox-compose @goback="closeEmail" :to.sync="checkedboxes" :user.sync="authUser" :showheader="false"></gradlead-inbox-compose>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
