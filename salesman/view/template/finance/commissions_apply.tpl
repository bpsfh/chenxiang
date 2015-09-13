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
                <label class="control-label" for="input-bind-status"><?php echo $entry_settle_status; ?></label>
                <select name="filter_settle_status" id="input-bind-status" class="form-control">
                  <option value="*"></option>
                  <option value="0" <?php if(!is_null($filter_settle_status) && (int)$filter_settle_status === 0) echo("selected") ?>><?php echo $text_settle_status_0; ?></option>
                  <option value="1" <?php if($filter_settle_status && $filter_settle_status == 1) echo("selected") ?>><?php echo $text_settle_status_1; ?></option>
                  <option value="2" <?php if($filter_settle_status && $filter_settle_status == 2) echo("selected") ?>><?php echo $text_settle_status_2; ?></option>
                  <option value="3" <?php if($filter_settle_status && $filter_settle_status == 3) echo("selected") ?>><?php echo $text_settle_status_3; ?></option>
                </select>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-fullname"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_settlement_id" value="<?php echo $filter_settlement_id; ?>" placeholder="<?php echo $entry_settlement_id; ?>" id="input-name" class="form-control" />
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
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php if ($sort == 'num') { ?>
                  <a href="<?php echo $sort_num; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_num; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_num; ?>"><?php echo $column_num; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'settlement_id') { ?>
                  <a href="<?php echo $sort_settlement_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_settlement_id; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_settlement_id; ?>"><?php echo $column_settlement_id; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'period') { ?>
                  <a href="<?php echo $sort_period; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_period; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_period; ?>"><?php echo $column_period; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'commission') { ?>
                  <a href="<?php echo $sort_commission; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_commission; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_commission; ?>"><?php echo $column_commission; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'apply_date') { ?>
                  <a href="<?php echo $sort_apply_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_apply_date; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_apply_date; ?>"><?php echo $column_apply_date; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'status') { ?>
                  <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php if ($sort == 'payment_status') { ?>
                  <a href="<?php echo $sort_payment_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_payment_status; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_payment_status; ?>"><?php echo $column_payment_status; ?></a>
                  <?php } ?></td>
                 <td class="text_center"> </td>
              </tr>
            </thead>
            <tbody>
              <?php if ($settlements) { ?>
              <?php foreach ($settlements as $settlement) { ?>
              <tr>
                <td class="text-left"><?php echo $settlement['num']; ?></td>
                <td class="text-left"><?php echo $settlement['settlement_id']; ?></td>
                <td class="text-left"><?php echo $settlement['period']; ?></td>
                <td class="text-left"><?php echo $settlement['settlement_id']; ?></td>
                <td class="text-left"><?php echo $settlement['commission']; ?></td>
                <td class="text-left"><?php echo $settlement['apply_date']; ?></td>
                <td class="text-left"><?php echo $settlement['status']; ?></td>
                <td class="text-left"><?php echo $settlement['payment_status']; ?></td>
                <td class="text_center">
                   <div class="text-right" id="<?php echo ('apply-'.$key); ?>"<?php if ($settlement['status'] != 0) {echo ('style = "display : none"');} ?>>
<a href="javascript:void(0)" id="<?php echo ('apply-button-'.$key); ?>" onclick="apply(<?php echo ('\''.$settlement['num'].'\',\''.$key.'\''); ?>);" class="btn btn-success" title="<?php echo $column_apply; ?>" ><i class="fa fa-share"></i> </a>
                   </div>
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
	url = 'index.php?route=finance/unit_commission&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	location = url;

});
//--></script> 
  <script type="text/javascript"><!--
  $('input[name=\'filter_name\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=finance/commissions_apply/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
				dataType: 'json',			
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['settlement_id']
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'filter_name\']').val(item['label']);
		}	
	});
//--></script></div>
<?php echo $footer; ?> 
