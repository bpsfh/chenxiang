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
				<label class="control-label" for="input-vip-card-num"><?php echo $entry_vip_card_num; ?></label>
				<input type="text" name="filter_vip_card_num" value="<?php echo $filter_vip_card_num; ?>" placeholder="<?php echo $entry_vip_card_num; ?>" id="input-vip-card-num" class="form-control" />
			  </div>
			  <div class="form-group">
				<label class="control-label" for="input-date-bind-to-customer-fr"><?php echo $entry_date_bind_to_customer_fr; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_bind_to_customer_fr" value="<?php echo $filter_date_bind_to_customer_fr; ?>" placeholder="<?php echo $entry_date_bind_to_customer_fr; ?>" data-date-format="YYYY-MM-DD" id="input-date-bind-to-customer-fr" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
			</div>
			<div class="col-sm-3">
			  <div class="form-group">
				<label class="control-label" for="input-bind-status"><?php echo $entry_bind_status; ?></label>
				<select name="filter_bind_status" id="input-bind-status" class="form-control">
				  <option value="*"></option>
				  <option value="0" <?php if(!is_null($filter_bind_status) && (int)$filter_bind_status === 0) echo("selected") ?>><?php echo $text_bind_status_0; ?></option>
				  <option value="1" <?php if($filter_bind_status && $filter_bind_status == 1) echo("selected") ?>><?php echo $text_bind_status_1; ?></option>
				  <option value="2" <?php if($filter_bind_status && $filter_bind_status == 2) echo("selected") ?>><?php echo $text_bind_status_2; ?></option>
				  <option value="3" <?php if($filter_bind_status && $filter_bind_status == 3) echo("selected") ?>><?php echo $text_bind_status_3; ?></option>
				</select>
			  </div>
			  <div class="form-group">
				<label class="control-label" for="input-date-bind-to-customer-to"><?php echo $entry_date_bind_to_customer_to; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_bind_to_customer_to" value="<?php echo $filter_date_bind_to_customer_to; ?>" placeholder="<?php echo $entry_date_bind_to_customer_to; ?>" data-date-format="YYYY-MM-DD" id="input-date-bind-to-customer-to" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
			</div>
			<div class="col-sm-3">
			  <div class="form-group">
				<label class="control-label" for="input-date-bind-to-salesman-fr"><?php echo $entry_date_bind_to_salesman_fr; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_bind_to_salesman_fr" value="<?php echo $filter_date_bind_to_salesman_fr; ?>" placeholder="<?php echo $entry_date_bind_to_salesman_fr; ?>" data-date-format="YYYY-MM-DD" id="input-date-bind-to-salesman-fr" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
			  <div class="form-group">
			  </div>
			</div>
			<div class="col-sm-3">
			  <div class="form-group">
				<label class="control-label" for="input-date-bind-to-salesman-to"><?php echo $entry_date_bind_to_salesman_to; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_bind_to_salesman_to" value="<?php echo $filter_date_bind_to_salesman_to; ?>" placeholder="<?php echo $entry_date_bind_to_salesman_to; ?>" data-date-format="YYYY-MM-DD" id="input-date-bind-to-salesman-to" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
			   <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
			</div>
          </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="form-vip">
          <div class="table-responsive">
            <div class="row">
               <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
               <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <!-- <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td> -->
                  <td class="text-left"><?php echo $column_num; ?></td>
                  <td class="text-left"><?php if ($sort == 'v.vip_card_num') { ?>
                    <a href="<?php echo $sort_vip_card_num; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_vip_card_num; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_vip_card_num; ?>"><?php echo $column_vip_card_num; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'v.bind_status') { ?>
                    <a href="<?php echo $sort_bind_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_bind_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_bind_status; ?>"><?php echo $column_bind_status; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'bind_customer') { ?>
                    <a href="<?php echo $sort_bind_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_bind_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_bind_customer; ?>"><?php echo $column_bind_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'bind_customer_telephone') { ?>
                    <a href="<?php echo $sort_bind_customer_telephone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_bind_customer_telephone; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_bind_customer_telephone; ?>"><?php echo $column_bind_customer_telephone; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'v.date_bind_to_salesman') { ?>
                    <a href="<?php echo $sort_date_bind_to_salesman; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_bind_to_salesman; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_bind_to_salesman; ?>"><?php echo $column_date_bind_to_salesman; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'v.date_bind_to_customer') { ?>
                    <a href="<?php echo $sort_date_bind_to_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_bind_to_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_bind_to_customer; ?>"><?php echo $column_date_bind_to_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_activate_status; ?></td>
                  <td class="text-center"><?php echo $column_generate_QR_code; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($vips)) { ?>
                <?php foreach ($vips as  $key => $vip) { ?>
                <tr>
                  <!-- <td class="text-center"><?php if (in_array($vip['vip_card_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $vip['vip_card_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $vip['vip_card_id']; ?>" />
                    <?php } ?></td> -->
                  <td class="text-left"><?php echo $vip['num']; ?></td>
                  <td class="text-left"><?php echo $vip['vip_card_num']; ?></td>
                  <td class="text-left">
                  <?php if((int)$vip['bind_status'] === 0) {echo ($text_bind_status_0) ;}
                        elseif($vip['bind_status'] == 1) { echo ($text_bind_status_1) ;}
                        elseif($vip['bind_status'] == 2) { echo ($text_bind_status_2) ;}
                        elseif($vip['bind_status'] == 3) { echo ($text_bind_status_3) ;} ?>
                  </td>
                  <td class="text-left"><?php echo $vip['bind_customer']; ?></td>
                  <td class="text-left"><?php echo $vip['bind_customer_telephone']; ?></td>
                  <td class="text-left"><?php echo $vip['date_bind_to_salesman']; ?></td>
                  <td class="text-left"><?php echo $vip['date_bind_to_customer']; ?></td>
                  <td class="text-center">
	                  <div class="text-left" id="<?php echo ('activate-display-'.$key); ?>" <?php if (!$vip['activate_status']) {echo ('style = "display : none"');} ?>>
	                    <a href="javascript:void(0)" id="<?php echo ('activate-button-'.$key); ?>" class="btn btn-success" onclick="firm(<?php echo ('\''.$vip['vip_card_id'].'\',\''.$vip['vip_card_num'].'\',\''.$key.'\''); ?>);" title="<?php echo $text_send_vip; ?>"><i class="fa fa-thumbs-o-up"></i></a>
	                  </div>
	                  <div class="text-right" id="<?php echo ('generate-display-'.$key); ?>"<?php if ($vip['activate_status']) {echo ('style = "display : none"');} ?>>
	                    <a href="javascript:void(0)" id="<?php echo ('generate-button-'.$key); ?>" onclick="generate(<?php echo ('\''.$vip['vip_card_num'].'\',\''.$key.'\''); ?>);" class="btn btn-success" title="<?php echo $column_generate_QR_code; ?>" ><i class="fa fa-share"></i> </a>
	                   </div>
	              </td>
                  <td class="text-center">
                  	<div id="<?php echo ('qr-code-'.$key); ?>"  class="text-center"></div>
                  </td>
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
<script type="text/javascript" src="view/javascript/jquery/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery.qrcode.js"></script>
<script type="text/javascript" src="view/javascript/jquery/qrcode.js"></script>
<script type="text/javascript"><!--
	function generate(vip_card_num , key) {
		var qrCode = "#qr-code-"+key;
		jQuery(qrCode).qrcode({
			render	: "canvas",
			width: 60,
			height:60,
			text	: vip_card_num
		});
		var generateButton = "generate-button-"+key;
		document.getElementById(generateButton).onclick = null;
	}

	function firm(vip_card_id, vip_card_num, key) {
		var activateId = "activate-button-"+key;
		var activateDisplayId = "activate-display-"+key;
		var generateDisplayId = "generate-display-"+key;
        if (confirm('<?php echo $text_send_vip_confirm?>')) {
        	$.ajax({
        		url: 'index.php?route=vip/vip/setVipStatus&vip_card_id=' + vip_card_id+'&token=<?php echo $token; ?>',
        		dataType: 'json',
        		beforeSend: function() {
        		},
        		complete: function() {
        		},
        		success: function(json) {
        			alert('<?php echo $text_send ?>' + vip_card_num + '<?php echo $text_invite_code ?>');
        			document.getElementById(activateDisplayId).style.display = "none";
        			document.getElementById(generateDisplayId).style.display = "block";

        		},
        		error: function(xhr, ajaxOptions, thrownError) {
        			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        		}
        	});
        }
        else {
            return false;
        }

    }
//--></script>

<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
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
