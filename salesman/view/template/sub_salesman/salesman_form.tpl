<!-- @author HU -->
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-salesman" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-salesman" class="form-horizontal">
          <div class="tab-content">
                    <div class="tab-pane active" id="tab-salesman">
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-fullname"><?php echo $entry_fullname; ?></label>
                        <div class="col-sm-6">
                          <input type="text" name="fullname" value="<?php echo $fullname; ?>" placeholder="<?php echo $entry_fullname; ?>" id="input-fullname" class="form-control" />
                          <?php if ($error_fullname) { ?>
                          <div class="text-danger"><?php echo $error_fullname; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                        <div class="col-sm-6">
                          <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                          <?php if ($error_email) { ?>
                          <div class="text-danger"><?php echo $error_email; ?></div>
                          <?php  } ?>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
                        <div class="col-sm-6">
                          <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
                          <?php if ($error_telephone) { ?>
                          <div class="text-danger"><?php echo $error_telephone; ?></div>
                          <?php  } ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-fax"><?php echo $entry_fax; ?></label>
                        <div class="col-sm-6">
                          <input type="text" name="fax" value="<?php echo $fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-fax" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            				<div class="col-sm-6"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              				<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-1 control-label"></label>
			            <label class="col-sm-1-4 ">
			              <?php foreach ($languages as $language) { ?>
			              <select name="salesman_upload_description[<?php echo $language['language_id']; ?>][name]" id="salesman_upload_description" class="form-control" >
			                 <option value="<?php echo isset($salesman_upload_description[$language['language_id']]) ? $salesman_upload_description[$language['language_id']]['name'] : ''; ?>" ><?php echo $entry_identity; ?></option>
			              </select>
			               <?php } ?>
			            </label>
			            <div class="col-sm-4">
			              <div class="input-group">
			                <input type="text" name="filename" value="<?php echo $filename; ?>" placeholder="" id="input-filename" class="form-control" readonly="readonly"/>
			                <span class="input-group-btn">
			                  <?php if ($filename) { ?>
			                  <a href="<?php echo $download ?>" data-toggle="tooltip" title="<?php echo $button_download; ?>" class="btn btn-primary"><i class="fa fa-download"></i><?php echo $button_download; ?></a>
			                  <?php } ?>
			                </span>
			              </div>
			            </div>
			          </div>
			          <input type="hidden" name="upload_id" value="<?php echo $upload_id; ?>" id="input-upload-id" class="form-control" />
			          <input type="hidden" name="mask" value="<?php echo $mask; ?>" id="input-mask" class="form-control" />
			          <input type="hidden" name="category" value="<?php echo $category; ?>" id="input-category" class="form-control" />

                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
                        <div class="col-sm-6">
                          <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" autocomplete="off" />
                          <?php if ($error_password) { ?>
                          <div class="text-danger"><?php echo $error_password; ?></div>
                          <?php  } ?>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
                        <div class="col-sm-6">
                          <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" autocomplete="off" id="input-confirm" class="form-control" />
                          <?php if ($error_confirm) { ?>
                          <div class="text-danger"><?php echo $error_confirm; ?></div>
                          <?php  } ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-newsletter"><?php echo $entry_newsletter; ?></label>
                        <div class="col-sm-6">
                          <select name="newsletter" id="input-newsletter" class="form-control">
                            <?php if ($newsletter) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-6">
                          <select name="status" id="input-status" class="form-control">
                            <?php if ($status) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-with_grant_opt"><?php echo $entry_with_grant_opt; ?></label>
                        <div class="col-sm-6">
                          <select name="with_grant_opt" id="input-with_grant_opt" class="form-control">
                            <?php if ($with_grant_opt) { ?>
                            <option value="1" selected="selected"><?php echo $text_with_grant_opt_1; ?></option>
                            <option value="0"><?php echo $text_with_grant_opt_0; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_with_grant_opt_1; ?></option>
                            <option value="0" selected="selected"><?php echo $text_with_grant_opt_0; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-approved"><?php echo $entry_approved; ?></label>
                        <div class="col-sm-6">
                          <select name="approved" id="input-approved" class="form-control">
                            <?php if ($approved) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-safe"><?php echo $entry_safe; ?></label>
                        <div class="col-sm-6">
                          <select name="safe" id="input-safe" class="form-control">
                            <?php if ($safe) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="panel-heading">
						<h2 class="panel-title"><i class="fa fa-truck"></i> <?php echo $text_shipping_info; ?></h2>
						 <input type="hidden" name="address_id" value="<?php echo $address_id; ?>" id="input-address-id" class="form-control" />
     				  </div>
	     				  <div class="form-group ">
	                        <label class="col-sm-2 control-label" for="input-shipping-fullname"><?php echo $entry_shipping_fullname; ?></label>
                          <div class="col-sm-6">
                          <input type="text" name="shipping_fullname" value="<?php echo $shipping_fullname; ?>"  id="input-shipping-fullname" class="form-control" />
                          <?php if (isset($error_shipping_fullname)) { ?>
                          <div class="text-danger"><?php echo $error_shipping_fullname; ?></div>
                          <?php } ?>
                        </div>
                      </div>
					  <div class="form-group ">
						<label class="col-sm-2 control-label" for="input-shipping-telephone"><?php echo $entry_shipping_telephone; ?></label>
						<div class="col-sm-6">
							<input type="text" name="shipping_telephone" value="<?php echo $shipping_telephone; ?>"
								placeholder="<?php echo $shipping_telephone; ?>" id="input-shipping-telephone"
								class="form-control" />
						        <?php if ($error_shipping_telephone) { ?>
			                	<div class="text-danger "><?php echo $error_shipping_telephone; ?></div>
			                	<?php } ?>
							</div>
					  </div>
					  <div class="form-group">
						    <label class="col-sm-2 control-label" for="input-company' + address_row + '"><?php echo $entry_company; ?></label>
						    <div class="col-sm-6"><input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-company' + address_row + '" class="form-control" /></div>
					  </div>
					 <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
			            <div class="col-sm-6">
			              <select name="country_id" id="input-country" class="form-control">
			                <option value=""><?php echo $text_select; ?></option>
			                <?php foreach ($countries as $country) { ?>
			                <?php if ($country['country_id'] == $country_id) { ?>
			                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			                <?php } ?>
			                <?php } ?>
			              </select>
			              <?php if ($error_country) { ?>
			              <div class="text-danger"><?php echo $error_country; ?></div>
			              <?php } ?>
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
			            <div class="col-sm-6">
			              <select name="zone_id" id="input-zone" class="form-control">
			              </select>
			              <?php if ($error_zone) { ?>
			              <div class="text-danger"><?php echo $error_zone; ?></div>
			              <?php } ?>
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
			            <div class="col-sm-6">
			              <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
			              <?php if ($error_city) { ?>
			              <div class="text-danger"><?php echo $error_city; ?></div>
			              <?php } ?>
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?></label>
			            <div class="col-sm-6">
			              <input type="text" name="address" value="<?php echo $address; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address" class="form-control" />
			              <?php if ($error_address) { ?>
			              <div class="text-danger"><?php echo $error_address; ?></div>
			              <?php } ?>
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
			            <div class="col-sm-6">
			              <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
			              <?php if ($error_postcode) { ?>
			              <div class="text-danger"><?php echo $error_postcode; ?></div>
			              <?php } ?>
			            </div>
              	</div>
              	<input type="hidden" name="salesman_id" value="<?php echo $salesman_id; ?>" id="input-salesman-id" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {

	$.ajax({
		url: 'index.php?route=salesman/user/country&country_id=' + this.value+'&token=<?php echo $token; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {

			$('.fa-spin').remove();

			if (json['postcode_required'] == '1') {
				$('input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
			  		}

			  		html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'zone_id\']').html(html);

		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

});

$('select[name=\'country_id\']').trigger('change');
--></script>

  <script type="text/javascript"><!--
$('#content').delegate('button[id^=\'button-custom-field\'], button[id^=\'button-address\']', 'click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload/upload&token=<?php echo $token; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input[type=\'hidden\']').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);
					}

					if (json['code']) {
						$(node).parent().find('input[type=\'hidden\']').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

//--></script></div>
<?php echo $footer; ?>