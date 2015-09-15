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
                <label class="control-label" for="input-ettle_status"><?php echo $entry_settle_status; ?></label>
                <select name="filter_settle_status" id="input-ettle_status" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if($filter_settle_status && $filter_settle_status == 1) echo("selected") ?>><?php echo $text_settle_status_1; ?></option>
                  <option value="2" <?php if($filter_settle_status && $filter_settle_status == 2) echo("selected") ?>><?php echo $text_settle_status_2; ?></option>
                  <option value="3" <?php if($filter_settle_status && $filter_settle_status == 3) echo("selected") ?>><?php echo $text_settle_status_3; ?></option>
                  <option value="4" <?php if($filter_settle_status && $filter_settle_status == 4) echo("selected") ?>><?php echo $text_settle_status_4; ?></option>
                  <option value="9" <?php if($filter_settle_status && $filter_settle_status == 9) echo("selected") ?>><?php echo $text_settle_status_9; ?></option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-peroid-from"><?php echo $entry_period_from; ?></label>
                <div class="input-group date">
                <input type="text" name="filter_period_from" value="<?php echo $filter_period_from; ?>" placeholder="<?php echo $entry_period_from; ?>" data-date-format="YYYY-MM-DD" id="input-period-from" class="form-control" />
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              </div>
           </div>
           <div class="col-sm-3">
             <div class="form-group">
               <label class="control-label" for="input-peroid-to"><?php echo $entry_period_to; ?></label>
               <div class="input-group date">
               <input type="text" name="filter_period_to" value="<?php echo $filter_period_to; ?>" placeholder="<?php echo $entry_period_to; ?>" data-date-format="YYYY-MM-DD" id="input-period-to" class="form-control" />
               <span class="input-group-btn">
                 <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
               </span></div>
             </div>
           </div>
           <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-apply_id"><?php echo $entry_apply_id; ?></label>
                <input type="text" name="filter_apply_id" value="<?php echo $filter_apply_id; ?>" placeholder="<?php echo $entry_apply_id; ?>" id="input-apply_id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-apply_date"><?php echo $entry_apply_date; ?></label>
                <div class="input-group date">
                <input type="text" name="filter_apply_date" value="<?php echo $filter_apply_date; ?>" placeholder="<?php echo $entry_apply_date; ?>" data-date-format="YYYY-MM-DD" id="input-apply_date" class="form-control" />
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
              </div>
            </div>
            <div class="col-sm-6">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php if ($sort == 'apply_id') { ?>
                  <a href="<?php echo $sort_apply_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_apply_id; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_apply_id; ?>"><?php echo $column_apply_id; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php echo $column_fullname; ?></td>
                <td class="text-left"><?php if ($sort == 'period_from') { ?>
                  <a href="<?php echo $sort_period_from; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_period; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_period_from; ?>"><?php echo $column_period; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'commission_total') { ?>
                  <a href="<?php echo $sort_commission_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_commission_total; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_commission_total; ?>"><?php echo $column_commission_total; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'apply_date') { ?>
                  <a href="<?php echo $sort_apply_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_apply_date; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_apply_date; ?>"><?php echo $column_apply_date; ?></a>
                  <?php } ?></td>
                <td class="text-center"><?php if ($sort == 'status') { ?>
                  <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                  <?php } ?></td>
                <td class="text-center"><?php if ($sort == 'payment_status') { ?>
                  <a href="<?php echo $sort_payment_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_payment_status; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_payment_status; ?>"><?php echo $column_payment_status; ?></a>
                  <?php } ?></td>
                 <td class="text-left"><?php echo $column_comments; ?></td>
                 <td class="text-right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($applys) { ?>
              <?php foreach ($applys as $apply) { ?>
              <tr>
                <td class="text-left"><?php echo $apply['apply_id']; ?></td>
                <td class="text-left"><?php echo $apply['fullname']; ?></td>
                <td class="text-left"><?php echo $apply['period']; ?></td>
                <td class="text-right"><?php echo $apply['commission_total']; ?></td>
                <td class="text-center"><?php echo $apply['apply_date']; ?></td>
                <td class="text-center">
                	<?php if($apply['status'] == 1) { echo $text_settle_status_1; }?>
                	<?php if($apply['status'] == 2) { echo $text_settle_status_2; }?>
                	<?php if($apply['status'] == 3) { echo $text_settle_status_3; }?>
                	<?php if($apply['status'] == 4) { echo $text_settle_status_4; }?>
                	<?php if($apply['status'] == 9) { echo $text_settle_status_9; }?>
                </td>
                <td class="text-center">
                	<?php if($apply['payment_status'] == 0) { echo $text_payment_status_0; }?>
                	<?php if($apply['payment_status'] == 1) { echo $text_payment_status_1; }?>
                </td>
                <td class="text-left">
                	<?php echo $apply['comments']; ?>
                </td>
                <td class="text-right">
                	<a href="<?php echo $apply['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-share"></i></a>
                </td>
               </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=salesman/commissions_apply&token=<?php echo $token; ?>';

	var filter_fullname = $('input[name=\'filter_fullname\']').val();

	if (filter_fullname) {
		url += '&filter_fullname=' + encodeURIComponent(filter_fullname);
	}
	
	var filter_settle_status = $('select[name=\'filter_settle_status\']').val();

	if (filter_settle_status != '*') {
		url += '&filter_settle_status=' + encodeURIComponent(filter_settle_status);
	}

	var filter_apply_id = $('input[name=\'filter_apply_id\']').val();

	if (filter_apply_id) {
		url += '&filter_apply_id=' + encodeURIComponent(filter_apply_id);
	}

	var filter_period_from = $('input[name=\'filter_period_from\']').val();

	if (filter_period_from) {
		url += '&filter_period_from=' + encodeURIComponent(filter_period_from);
	}

	var filter_period_to = $('input[name=\'filter_period_to\']').val();

	if (filter_period_to) {
		url += '&filter_period_to=' + encodeURIComponent(filter_period_to);
	}

	var filter_apply_date = $('input[name=\'filter_apply_date\']').val();

	if (filter_apply_date) {
		url += '&filter_apply_date=' + encodeURIComponent(filter_apply_date);
	}

	location = url;
});
//--></script>
<script type="text/javascript"><!--
  $('input[name=\'filter_fullname\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=salesman/commissions_apply/autocomplete&token=<?php echo $token; ?>&filter_fullname=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
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
