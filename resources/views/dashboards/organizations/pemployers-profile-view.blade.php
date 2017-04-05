<div class="modal fade" id="modal-pemployer-view-profile" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> @{{profilingOrganization.name}} Profile</h4>
            </div>

            <div class="modal-body">
                     <gl-view-profile-org 
                           :organization.sync="profilingOrganization"
                           :canupdate="false"
                           :auth-user="authUser"
                           :usertype="usertype"
                           :permissions="permissions"
                           :industries="jpList"
                           :jobtypes="jtList">
                    </gl-view-profile-org>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
