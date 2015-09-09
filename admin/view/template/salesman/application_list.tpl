<!-- @author HU -->
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
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_fullname; ?>" id="input-name" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status == 1) { ?>
                  <option value="1" selected="selected"><?php echo $text_status_1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_status_1; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 2) { ?>
                  <option value="2" selected="selected"><?php echo $text_status_2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_status_2; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 3) { ?>
                  <option value="3" selected="selected"><?php echo $text_status_3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_status_3; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 4) { ?>
                  <option value="4" selected="selected"><?php echo $text_status_4; ?></option>
                  <?php } else { ?>
                  <option value="4"><?php echo $text_status_4; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 5) { ?>
                  <option value="5" selected="selected"><?php echo $text_status_5; ?></option>
                  <?php } else { ?>
                  <option value="5"><?php echo $text_status_5; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-date-first-applied"><?php echo $entry_date_first_applied; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_first_applied" value="<?php echo $filter_date_first_applied; ?>" placeholder="<?php echo $entry_date_first_applied; ?>" data-date-format="YYYY-MM-DD" id="input-apply-date" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php if ($sort == 'fullname') { ?>
                    <a href="<?php echo $sort_fullname; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_fullname; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_fullname; ?>"><?php echo $column_fullname; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'email') { ?>
                    <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_first_applied') { ?>
                    <a href="<?php echo $sort_date_first_applied; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_first_applied; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_first_applied; ?>"><?php echo $column_date_first_applied; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'application_status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_salesman_info; ?></td>
                  <td class="text-center"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($applications) { ?>
                <?php foreach ($applications as $application) { ?>
                <tr>
                  <td class="text-left" style="text-decoration:underline"><a href="<?php echo $application['salesman_info'] ?>" data-toggle="tooltip" title="<?php echo $text_saleman_info; ?>"> <?php echo $application['fullname']; ?></a></td>
                  <td class="text-left"><?php echo $application['email']; ?></td>
                  <td class="text-left"><?php echo $application['date_first_applied']; ?></td>
                  <td class="text-left">
                  	<?php
                  		if ($application['status'] == 1) { echo $text_status_1;}
						if ($application['status'] == 2) { echo $text_status_2;}
						if ($application['status'] == 3) { echo $text_status_3;}
						if ($application['status'] == 4) { echo $text_status_4;}
                  	?>
                  </td>
                  <td class="text-center"><a href="<?php echo $application['salesman_info'] ?>" data-toggle="tooltip" title="<?php echo $text_saleman_info; ?>" class="btn btn-info"><i class="fa fa-user"></i><?php echo $text_saleman_info; ?></a></td>
                  <td class="text-center">
                  	<?php if ($application['status'] == 1 || $application['status'] == 4) { ?>
                    	<a href="<?php echo $application['records']; ?>" data-toggle="tooltip" title="<?php echo $botton_records; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    	<a href="<?php echo $application['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    <?php } elseif ($application['status'] == 2 || $application['status'] == 3) { ?>
                    	<a href="<?php echo $application['records']; ?>" data-toggle="tooltip" title="<?php echo $botton_records; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
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
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=salesman/application&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_email = $('input[name=\'filter_email\']').val();

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	var filter_date_first_applied = $('input[name=\'filter_date_first_applied\']').val();

	if (filter_date_first_applied) {
		url += '&filter_date_first_applied=' + encodeURIComponent(filter_date_first_applied);
	}

	location = url;
});
//--></script>
  <script type="text/javascript"><!--
  $('input[name=\'filter_name\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=salesman/application/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
			$('input[name=\'filter_name\']').val(item['label']);
		}
	});

  $('input[name=\'filter_email\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=salesman/application/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['email'],
							value: item['salesman_id']
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'filter_email\']').val(item['label']);
		}
	});
//--></script>
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>
