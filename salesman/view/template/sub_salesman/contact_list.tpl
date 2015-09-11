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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_contact_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-filter-contact-title"><?php echo $text_title; ?></label>
                <input type="text" name="filter_contact_title" value="<?php echo $filter_contact_title; ?>" placeholder="<?php echo $text_title; ?>" id="input-filter-contact-title" class="form-control" />
              </div>
              <div class="form-group">
				<label class="control-label" for="input-date-replied-fr"><?php echo $entry_date_replied_fr; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_replied_fr" value="<?php echo $filter_date_replied_fr; ?>" placeholder="<?php echo $entry_date_replied_fr; ?>" data-date-format="YYYY-MM-DD" id="input-date-replied-fr" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
			</div>
            <div class="col-sm-3">
              <div class="form-group">
				<label class="control-label" for="input-reply-flg"><?php echo $entry_reply_flg; ?></label>
				<select name="filter_reply_flg" id="input-reply-flg" class="form-control">
				  <option value="*"></option>
				  <option value="0" <?php if(!is_null($filter_reply_flg) && (int)$filter_reply_flg === 0) echo("selected") ?>><?php echo $text_reply_flg_0; ?></option>
				  <option value="1" <?php if($filter_reply_flg && $filter_reply_flg == 1) echo("selected") ?>><?php echo $text_reply_flg_1; ?></option>
				</select>
			  </div>
              <div class="form-group">
				<label class="control-label" for="input-date-replied-to"><?php echo $entry_date_replied_to; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_replied_to" value="<?php echo $filter_date_replied_to; ?>" placeholder="<?php echo $entry_date_replied_to; ?>" data-date-format="YYYY-MM-DD" id="input-date-replied-to" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
			</div>
            <div class="col-sm-3">
              <div class="form-group">
				<label class="control-label" for="input-date-contacted-fr"><?php echo $entry_date_contacted_fr; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_contacted_fr" value="<?php echo $filter_date_contacted_fr; ?>" placeholder="<?php echo $entry_date_contacted_fr; ?>" data-date-format="YYYY-MM-DD" id="input-date-contacted-fr" class="form-control" />
				  <span class="input-group-btn">
				  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				  </span></div>
			  </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
				<label class="control-label" for="input-date-contacted-to"><?php echo $entry_date_contacted_to; ?></label>
				<div class="input-group date">
				  <input type="text" name="filter_date_contacted_to" value="<?php echo $filter_date_contacted_to; ?>" placeholder="<?php echo $entry_date_contacted_to; ?>" data-date-format="YYYY-MM-DD" id="input-date-contacted-to" class="form-control" />
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
                  <td class="text-left"><?php echo $column_num; ?></td>
                  <td class="text-left"><?php if ($sort == 'contact_title') { ?>
                    <a href="<?php echo $sort_contact_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_contact_title; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_contact_title; ?>"><?php echo $column_contact_title; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'reply_flg') { ?>
                    <a href="<?php echo $sort_reply_flg; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_reply_flg; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_reply_flg; ?>"><?php echo $column_reply_flg; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_contact_content; ?></td>
                  <td class="text-left"><?php echo $column_reply_content; ?></td>
                  <td class="text-left"><?php if ($sort == 'date_contacted') { ?>
                    <a href="<?php echo $sort_date_contacted; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_contacted; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_contacted; ?>"><?php echo $column_date_contacted; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_replied') { ?>
                    <a href="<?php echo $sort_date_replied; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_replied; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_replied; ?>"><?php echo $column_date_replied; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($contacts)) { ?>
                <?php foreach ($contacts as $contact) { ?>
                <tr>
                  <td class="text-left"><?php echo $contact['num']; ?></td>
                  <td class="text-left"><?php echo $contact['contact_title']; ?></td>
                  <td class="text-left"><?php if(!is_null($contact['reply_flg']) && (int)$contact['reply_flg'] === 0)  echo $text_reply_flg_0; ?>
                                        <?php if ((int)$contact['reply_flg'] == 1) echo $text_reply_flg_1; ?>
                  <td class="text-left"><?php echo $contact['contact_content']; ?></td>
                  <td class="text-left"><?php echo $contact['reply_content']; ?></td>
                  <td class="text-left"><?php echo $contact['date_contacted']; ?></td>
                  <td class="text-left"><?php echo $contact['date_replied']; ?></td>
                  <td class="text-center"> <a href="<?php echo $contact['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
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
  	url = 'index.php?route=sub_salesman/contact&token=<?php echo $token; ?>';

  	var filter_contact_title = $('input[name=\'filter_contact_title\']').val();

  	if (filter_contact_title) {
  		url += '&filter_contact_title=' + encodeURIComponent(filter_contact_title);
  	}

  	var filter_reply_flg = $('select[name=\'filter_reply_flg\']').val();

  	if (filter_reply_flg != '*') {
  		url += '&filter_reply_flg=' + encodeURIComponent(filter_reply_flg);
  	}

  	var filter_date_contacted_fr = $('input[name=\'filter_date_contacted_fr\']').val();

  	if (filter_date_contacted_fr) {
  		url += '&filter_date_contacted_fr=' + encodeURIComponent(filter_date_contacted_fr);
  	}

  	var filter_date_contacted_to = $('input[name=\'filter_date_contacted_to\']').val();

  	if (filter_date_contacted_to) {
  		url += '&filter_date_contacted_to=' + encodeURIComponent(filter_date_contacted_to);
  	}
  	var filter_date_replied_fr = $('input[name=\'filter_date_replied_fr\']').val();

  	if (filter_date_replied_fr) {
  		url += '&filter_date_replied_fr=' + encodeURIComponent(filter_date_replied_fr);
  	}

  	var filter_date_replied_to = $('input[name=\'filter_date_replied_to\']').val();

  	if (filter_date_replied_to) {
  		url += '&filter_date_replied_to=' + encodeURIComponent(filter_date_replied_to);
  	}
  	location = url;
  });

  //--></script>
  <script type="text/javascript"><!--
  $('input[name=\'filter_name\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=salesman/contact/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
                url: 'index.php?route=salesman/contact/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
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
