<div class="modal fade" id="modal-edit-badge" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i> Update Badge</h4>
            </div>

            <div class="modal-body">

                <!-- Update Form -->
                <form v-on:submit="updateBadge($event)" class="form-horizontal" 
                      action="/badges" method="post" enctype="multipart/form-data" id="myuform">
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" id="bid" name="id" value="" />
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name*</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="uname" class="form-control" />
                                    <p class="help-block" v-show="nameError">
                                        <span style="color: red">The name field is required.</span> 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                                   
                   <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Description*</label>
                                <div class="col-md-6">
                                    <input type="text" name="description" id="udescription" class="form-control" />
                                    <p class="help-block" v-show="descError">
                                        <span style="color: red">The description field is required.</span> 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Upload file</label>
                                <div class="col-md-6">
                                    <input type="file" name="image" id="ufiler_input" data-jfiler-showThumbs="true" class="form-control">
                                    <p class="help-block">
                                        <span style="color:red">File must be less than 20MB. Must be jpeg, png, bmp, gif, or svg</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-addon" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Update" class="btn btn-primary btn-addon">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
$(document).ready(function() {
     $('#ufiler_input').filer();  
});
</script>
@endsection
