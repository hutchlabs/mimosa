<div class="modal fade" id="modal-user-view-profile" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> @{{profilingUser.name}} Profile</h4>
            </div>

            <div class="modal-body">
                     <gl-view-profile-seeker :user.sync="profilingUser"></gl-view-profile-seeker>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
