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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-commissions-status"><?php echo $entry_commissions_status; ?></label>
                <select name="filter_commissions_status" id="input-commissions-status" class="form-control">
				  <option value="*"></option>
				  <option value="0" <?php if(!is_null($filter_commissions_status) && (int)$filter_commissions_status === 0) echo("selected") ?>><?php echo $text_commissions_status_0; ?></option>
				  <option value="1" <?php if($filter_commissions_status == 1) echo("selected") ?>><?php echo $text_commissions_status_1; ?></option>
				</select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                 <td class="text-left"><?php echo $column_num; ?></td>
                 <td class="text-left"><?php if ($sort == 'date') { ?>
                    <a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
                    <?php } ?></td>
                 <td class="text-left"><?php if ($sort == 'order_num') { ?>
                    <a href="<?php echo $sort_order_num; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_num; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order_num; ?>"><?php echo $column_order_num; ?></a>
                    <?php } ?></td>
                 <td class="text-left"><?php if ($sort == 'order_total') { ?>
                    <a href="<?php echo $sort_order_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order_total; ?>"><?php echo $column_order_total; ?></a>
                    <?php } ?></td>
                 <td class="text-left"><?php if ($sort == 'commissions_total') { ?>
                    <a href="<?php echo $sort_commissions_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_commissions_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_commissions_total; ?>"><?php echo $column_commissions_total; ?></a>
                    <?php } ?></td>
                 <td class="text-left"><?php if ($sort == 'commissions_status') { ?>
                    <a href="<?php echo $sort_commissions_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_commissions_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_commissions_status; ?>"><?php echo $column_commissions_status; ?></a>
                    <?php } ?></td>
                <!-- <td class="text-left"><?php echo $column_date; ?></td>
                <td class="text-left"><?php echo $column_order_num ?></td>
                <td class="text-right"><?php echo $column_order_total; ?></td>
                <td class="text-right"><?php echo $column_commissions_total; ?></td>
                <td class="text-right"><?php echo $column_commissions_status; ?></td> -->
              </tr>
            </thead>
            <tbody>
              <?php if ($commissions) { ?>
              <?php foreach ($commissions as $commission) { ?>
              <tr>
                <td class="text-left"><?php echo $commission['num']; ?></td>
                <td class="text-left"><?php echo $commission['date']; ?></td>
                <td class="text-left"><?php echo $commission['order_num']; ?></td>
                <td class="text-right"><?php echo $commission['order_total']; ?></td>
                <td class="text-right"><?php echo $commission['commissions_total']; ?></td>
                <td class="text-right"><?php echo $commission['commissions_status']; ?></td>
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
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
	$('#button-filter').on('click', function() {
		url = 'index.php?route=finance/order_commissions&token=<?php echo $token; ?>';

		var filter_date_start = $('input[name=\'filter_date_start\']').val();

		if (filter_date_start) {
			url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
		}

		var filter_date_end = $('input[name=\'filter_date_end\']').val();

		if (filter_date_end) {
			url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
		}

		var filter_commissions_status = $('select[name=\'filter_commissions_status\']').val();
		    filter_commissions_status
		if (filter_commissions_status != '*') {
			url += '&filter_commissions_status=' + encodeURIComponent(filter_commissions_status);
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
