<!-- @author HU -->
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
      	<div class="table-responsive">
      		<table id="commission" class="table table-striped table-bordered table-hover">
      			<thead>
                	<tr>
                      <td class="text-left"><?php echo $column_fullname; ?></td>
                      <td class="text-left"><?php echo $column_period; ?></td>
                      <td class="text-right"><?php echo $column_order_total; ?></td>
                      <td class="text-right"><?php echo $column_amount_total; ?></td>
                      <td class="text-right"><?php echo $column_commission_total; ?></td>
                      <td class="text-left"><?php echo $column_status_now; ?></td>
                      <?php if ($status == 1) {?><td class="text-left"><?php echo $column_apply_date; ?></td><?php }?>
                      <?php if ($status == 2) {?><td class="text-left"><?php echo $column_cancel_date; ?></td><?php }?>
                   	  <?php if ($status == 3) {?><td class="text-left"><?php echo $column_approve_date; ?></td><?php }?>
                      <?php if ($status == 4) {?><td class="text-left"><?php echo $column_pay_date; ?></td><?php }?>
                      <?php if ($status == 9) {?><td class="text-left"><?php echo $column_reject_date; ?></td><?php }?>
                    </tr>
             	</thead>
            	<tbody>
            		<tr>
            		  <td class="text-left"><?php echo $fullname; ?></td>
                      <td class="text-left"><?php echo $period; ?></td>
                      <td class="text-right"><?php echo $order_total; ?></td>
                      <td class="text-right"><?php echo $amount_total; ?></td>
                      <td class="text-right"><?php echo $commission_total; ?></td>
                      <?php if ($status == 1) {?><td class="text-left"><?php echo $text_settle_status_1; ?></td><td class="text-left"><?php echo $apply_date; ?></td><?php }?>
                      <?php if ($status == 2) {?><td class="text-left"><?php echo $text_settle_status_2; ?></td><td class="text-left"><?php echo $cancel_date; ?></td><?php }?>
                   	  <?php if ($status == 3) {?><td class="text-left"><?php echo $text_settle_status_3; ?></td><td class="text-left"><?php echo $approve_date; ?></td><?php }?>
                      <?php if ($status == 4) {?><td class="text-left"><?php echo $text_settle_status_4; ?></td><td class="text-left"><?php echo $pay_date; ?></td><?php }?>
                      <?php if ($status == 9) {?><td class="text-left"><?php echo $text_settle_status_9; ?></td><td class="text-left"><?php echo $reject_date; ?></td><?php }?>
            		</tr>  
            	</tbody>
      		</table>
      	</div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">
          <input type="hidden" name="apply_id" value="<?php echo $apply_id;?>"/>
          <div class="form-group">
          	<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_settle_status; ?></label>
          	<div class="col-sm-3">
            	<select name="status" id="input-status" class="form-control">
                	<option value="1" <?php if($status == 1) echo("selected") ?>><?php echo $text_settle_status_1; ?></option>
                	<option value="2" <?php if($status == 2) echo("selected") ?>><?php echo $text_settle_status_2; ?></option>
                	<option value="3" <?php if($status == 3) echo("selected") ?>><?php echo $text_settle_status_3; ?></option>
                	<option value="4" <?php if($status == 4) echo("selected") ?>><?php echo $text_settle_status_4; ?></option>
                	<option value="9" <?php if($status == 9) echo("selected") ?>><?php echo $text_settle_status_9; ?></option>
           		</select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-comments"><?php echo $entry_comments; ?></label>
            <div class="col-sm-5">
              <textarea name="comments" cols="60" rows="5" placeholder="<?php echo $entry_comments; ?>" id="input-comments" class="form-control"><?php echo $comments; ?></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>