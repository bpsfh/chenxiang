<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<button type="submit" form="form-vip-card-apply" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-vip-card-apply" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-apply-qty"><?php echo $entry_apply_qty; ?></label>
            <div class="col-sm-10">
              <input type="text" name="apply_qty" value="" placeholder="<?php echo $entry_apply_qty; ?>" id="input-apply-qty" class="form-control" />
              <?php if ($error_apply_qty) { ?>
              <div class="text-danger"><?php echo $error_apply_qty; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-apply-reason"><?php echo $entry_apply_reason; ?></label>
            <div class="col-sm-10">
              <textarea name="apply_reason" rows="5" placeholder="<?php echo $entry_apply_reason; ?>" id="input-apply-reason" class="form-control"></textarea>
              <?php if ($error_apply_reason) { ?>
              <div class="text-danger"><?php echo $error_apply_reason; ?></div>
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
        <form action=""  method="post" enctype="multipart/form-data" id="">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <!-- <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td> -->
                  <td class="text-left"><?php echo $column_num; ?></td>
                  <td class="text-left"><?php if ($sort == 'vca.apply_id') { ?>
                    <a href="<?php echo $sort_apply_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_apply_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_apply_id; ?>"><?php echo $column_apply_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'vca.date_applied') { ?>
                    <a href="<?php echo $sort_date_applied; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_applied; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_applied; ?>"><?php echo $column_date_applied; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'vca.apply_qty') { ?>
                    <a href="<?php echo $sort_apply_qty; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_apply_qty; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_apply_qty; ?>"><?php echo $column_apply_qty; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'vca.apply_reason') { ?>
                    <a href="<?php echo $sort_apply_reason; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_examine_approve_reason; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_apply_reason; ?>"><?php echo $column_examine_approve_reason; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'vca.apply_status') { ?>
                    <a href="<?php echo $sort_apply_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_examine_approve_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_apply_status; ?>"><?php echo $column_examine_approve_status; ?></a>
                    <?php } ?></td>
                  <td class="text-left">
                    <?php echo $column_reject_reason; ?>
                    </td>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($vip_card_applys)) { ?>
                <?php foreach ($vip_card_applys as  $key => $vip_card_apply) { ?>
                <tr>
                  <!-- <td class="text-center"><?php if (in_array($vip_card_apply['apply_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="" checked="checked" <?php if($vip_card_apply['is_applied']) echo ("disabled")?>/>
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="" <?php if($vip_card_apply['is_applied']) echo ("disabled")?>/>
                    <?php } ?></td>  -->
                  <td class="text-left"><?php echo $vip_card_apply['num']; ?></td>
                  <td class="text-left"><?php echo $vip_card_apply['apply_id']; ?></td>
                  <td class="text-left"><?php echo $vip_card_apply['date_applied']; ?></td>
                  <td class="text-left"><?php echo $vip_card_apply['apply_qty']; ?></td>
                  <td class="text-left"><?php echo $vip_card_apply['apply_reason']; ?></td>
                  <td class="text-left">
                  <?php if(!is_null($vip_card_apply['apply_status']) && (int)$vip_card_apply['apply_status'] === 0) echo ($text_apply_status_0);
                        elseif ($vip_card_apply['apply_status'] == 1) echo ($text_apply_status_1);
                        elseif ($vip_card_apply['apply_status'] == 2) echo ($text_apply_status_2); ?>
                  </td>
                  <td class="text-left"><?php echo $vip_card_apply['reject_reason']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
$('#button-add').on('click', function() {
	url = 'index.php?route=vip/vip&token=<?php echo $token; ?>';

	var filter_vip_card_num = $('input[name=\'filter_vip_card_num\']').val();

	if (filter_vip_card_num) {
		url += '&filter_vip_card_num=' + encodeURIComponent(filter_vip_card_num);
	}

	var filter_bind_status = $('select[name=\'filter_bind_status\']').val();

	if (filter_bind_status != '*') {
		url += '&filter_bind_status=' + encodeURIComponent(filter_bind_status);
	}

	var filter_date_bind_to_salesman_fr = $('input[name=\'filter_date_bind_to_salesman_fr\']').val();

	if (filter_date_bind_to_salesman_fr) {
		url += '&filter_date_bind_to_salesman_fr=' + encodeURIComponent(filter_date_bind_to_salesman_fr);
	}

	var filter_date_bind_to_salesman_to = $('input[name=\'filter_date_bind_to_salesman_to\']').val();

	if (filter_date_bind_to_salesman_to) {
		url += '&filter_date_bind_to_salesman_to=' + encodeURIComponent(filter_date_bind_to_salesman_to);
	}
	var filter_date_bind_to_customer_fr = $('input[name=\'filter_date_bind_to_customer_fr\']').val();

	if (filter_date_bind_to_customer_fr) {
		url += '&filter_date_bind_to_customer_fr=' + encodeURIComponent(filter_date_bind_to_customer_fr);
	}

	var filter_date_bind_to_customer_to = $('input[name=\'filter_date_bind_to_customer_to\']').val();

	if (filter_date_bind_to_customer_to) {
		url += '&filter_date_bind_to_customer_to=' + encodeURIComponent(filter_date_bind_to_customer_to);
	}

	location = url;
});

//--></script>
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>
