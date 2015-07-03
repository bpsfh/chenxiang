<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
            <label class="col-sm-2 control-label"><?php echo $entry_apply_id; ?></label>
            <span class="col-sm-2 control-value"><?php echo $apply_id; ?></span>
            <input name="apply_id" value="<?php echo $apply_id; ?>" style="display: none"/>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_salesman_id; ?></label>
            <span class="col-sm-2 control-value"><?php echo $salesman_id; ?></span>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_fullname; ?></label>
            <span class="col-sm-2 control-value"><?php echo $fullname; ?></span>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_apply_qty; ?></label>
            <span class="col-sm-2 control-value"><?php echo $apply_qty; ?></span>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_date_applied; ?></label>
            <span class="col-sm-2 control-value"><?php echo $date_applied; ?></span>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_apply_reason; ?></label>
            <span class="col-sm-2 control-value"><?php echo $apply_reason; ?></span>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_apply_status; ?></label>
            <?php if ($apply_status == 1) { ?>
            	<span class="col-sm-2 control-value"><?php echo $entry_apply_status_1; ?></span>
            <?php } elseif ($apply_status == 2) { ?>
            	<span class="col-sm-2 control-value"><?php echo $entry_apply_status_2; ?></span>
            <?php } else { ?>
            	<span class="col-sm-2 control-value"><?php echo $entry_apply_status_0; ?></span>
            <?php } ?>
          </div>
          <?php if ($date_processed != '' && $date_processed != null) {?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_last_date_processed; ?></label>
            <span class="col-sm-2 control-value"><?php echo $date_processed; ?></span>
          </div>
          <?php } ?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-reject-reason"><?php echo $entry_reject_reason; ?></label>
            <div class="col-sm-5">
              <textarea name="reject_reason" cols="60" rows="5" placeholder="<?php echo $entry_reject_reason; ?>" id="input-reject-reason" class="form-control"><?php echo $reject_reason; ?></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>