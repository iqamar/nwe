<?php 
if ($request_from != '') {?>
	<a class="connect" onmouseover="cancelAjaxRequest()" id="ajax_approval">Approval Pending</a>
    <a href="#" class="remove" data-toggle="modal" onmouseout="showAjaxApproval()" data-target="#delete_ajax_request" style="display:none;" id="ajax_request">Cancel Request</a>
    <div class="modal fade middlepopup" id="delete_ajax_request" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <a class="popupclose" data-dismiss="modal" aria-hidden="true" style="margin-right:0px;"></a>
                                    <h1 class="modal-title" id="myModalLabel">Delete</h1>
                                  </div>
                                  <div class="modal-body">
                                    <h2>Are You sure want to cancel connection request?</h2>
                                  </div>
                                  <div class="modal-footer">
                                   <button type="button" onclick="return remove_contact('<?php echo $connection_id;?>','','request_canel');" class="btn submitbttn" data-dismiss="modal">Yes</button>
                                    <button type="button" class="btn canclebttn" data-dismiss="modal">No</button>
                                  </div>
                                </div>
                              </div>
                        </div>
<?php } else {?>
<a class="connect">Approval Pending</a>
<?php }?>