<!-- @author HU -->
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_commit; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">
          <div class="form-group">
          	<input name="salesman_id" value="<?php echo $salesman_id; ?>" style="display: none"/>
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-5">
              <select name="status" id="input-status" class="form-control" onchange="isShow();">
                <option value="2"><?php echo $text_apply_status_2; ?></option>
                <option value="3"><?php echo $text_apply_status_3; ?></option>
              </select>
            </div>
          </div>
          <div class="form-group" id="reject-reason" style="display: none">
            <label class="col-sm-2 control-label" for="input-reject-reason"><?php echo $entry_reject_reason; ?></label>
            <div class="col-sm-5">
              <textarea name="reject_reason" cols="60" rows="5" placeholder="<?php echo $entry_reject_reason; ?>" id="input-reject-reason" class="form-control"></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  function isShow() {
	var status = document.getElementById("input-status");
	var reason_control = document.getElementById("reject-reason");
	
	if (status.value == '3') {
		reason_control.style.display = 'block';
	} else if (status.value == '2') {
		// clean the value of reject_reason
		var reason = document.getElementById("input-reject-reason");
		reason.value = '';
		
		reason_control.style.display = 'none';
	}
  }
//--></script>
<?php echo $footer; ?>