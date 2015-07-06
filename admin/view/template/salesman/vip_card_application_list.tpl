<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-fullname"><?php echo $entry_fullname; ?></label>
                <input type="text" name="filter_fullname" value="<?php echo $filter_fullname; ?>" placeholder="<?php echo $entry_fullname; ?>" id="input-fullname" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_apply_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if (!is_null($filter_status) && $filter_status == 0) { ?>
                  <option value="0" selected="selected"><?php echo $entry_apply_status_0; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $entry_apply_status_0; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 1) { ?>
                  <option value="1" selected="selected"><?php echo $entry_apply_status_1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_apply_status_1; ?></option>
                  <?php } ?>
                  <?php if ((int)$filter_status == 2) { ?>
                  <option value="2" selected="selected"><?php echo $entry_apply_status_2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $entry_apply_status_2; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-apply-date"><?php echo $entry_date_applied; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_applied" value="<?php echo $filter_date_applied; ?>" placeholder="<?php echo $entry_date_applied; ?>" data-date-format="YYYY-MM-DD" id="input-apply-date" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-3">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-customer">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <!-- <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td> -->
                  <td class="text-left"><?php if ($sort == 'apply_id') { ?>
                    <a href="<?php echo $sort_apply_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_apply_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_apply_id; ?>"><?php echo $column_apply_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_salesman_id; ?></td>
                  <td class="text-left"><?php if ($sort == 's.fullname') { ?>
                    <a href="<?php echo $sort_fullname; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_fullname; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_fullname; ?>"><?php echo $column_fullname; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_apply_qty; ?></td>
                  <td class="text-left"><?php if ($sort == 'date_applied') { ?>
                    <a href="<?php echo $sort_date_applied; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_applied; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_applied; ?>"><?php echo $column_date_applied; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_apply_reason; ?></td>
                  <td class="text-left"><?php echo $column_apply_status; ?></td>
                  <td class="text-left"><?php if ($sort == 'date_processed') { ?>
                    <a href="<?php echo $sort_date_processed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_processed; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_processed; ?>"><?php echo $column_date_processed; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_reject_reason; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($applications) { ?>
                <?php foreach ($applications as $application) { ?>
                <tr>
                  <td class="text-left"><?php echo $application['apply_id']; ?></td>
                  <td class="text-left"><?php echo $application['salesman_id']; ?></td>
                  <td class="text-left"><?php echo $application['fullname']; ?></td>
                  <td class="text-left"><?php echo $application['apply_qty']; ?></td>
                  <td class="text-left"><?php echo $application['date_applied']; ?></td>
                  <td class="text-left"><?php echo $application['apply_reason']; ?></td>
                  <td class="text-left">
                  	<?php 
                  		if ($application['apply_status'] == 0) { echo $entry_apply_status_0;}
                  		if ($application['apply_status'] == 1) { echo $entry_apply_status_1;}
                  		if ($application['apply_status'] == 2) { echo $entry_apply_status_2;}
                  	?>
                  </td>
                  <td class="text-left"><?php echo $application['date_processed']; ?></td>
                  <td class="text-left"><?php echo $application['reject_reason']; ?></td>
                  <td class="text-right">
                  	<?php if ($application['apply_status'] == 0) { ?>
                    	<a href="<?php echo $application['approve']; ?>" data-toggle="tooltip" title="<?php echo $botton_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a>
                    	<a href="<?php echo $application['reject']; ?>" data-toggle="tooltip" title="<?php echo $botton_reject; ?>" class="btn btn-primary"><i class="fa fa-thumbs-o-down"></i></a>
                    <?php } elseif ($application['apply_status'] == 2) { ?>
                    	<a href="<?php echo $application['reject']; ?>" data-toggle="tooltip" title="<?php echo $botton_reject; ?>" class="btn btn-primary"><i class="fa fa-thumbs-o-down"></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
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
$('#button-filter').on('click', function() {
	url = 'index.php?route=salesman/vip_card&token=<?php echo $token; ?>';
	
	var filter_fullname = $('input[name=\'filter_fullname\']').val();
	
	if (filter_fullname) {
		url += '&filter_fullname=' + encodeURIComponent(filter_fullname);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	
	var filter_date_applied = $('input[name=\'filter_date_applied\']').val();
	
	if (filter_date_applied) {
		url += '&filter_date_applied=' + encodeURIComponent(filter_date_applied);
	}
	
	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_fullname\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=salesman/vip_card/autocomplete&token=<?php echo $token; ?>&filter_fullname=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['fullname'],
						value: item['salesman_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_fullname\']').val(item['label']);
	}	
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?> 
