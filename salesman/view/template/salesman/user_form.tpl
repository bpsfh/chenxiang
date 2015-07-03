<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-user" data-toggle="tooltip"
					title="<?php echo $button_save; ?>" class="btn btn-primary">
					<i class="fa fa-save"></i>
				</button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip"
					title="<?php echo $button_cancel; ?>" class="btn btn-default"><i
					class="fa fa-reply"></i></a>
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
    <div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post"
					enctype="multipart/form-data" id="form-user"
					class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
						<div class="col-sm-10">
							<input type="text" name="email" value="<?php echo $email; ?>"
								placeholder="<?php echo $entry_email; ?>" id="input-email"
								class="form-control" readonly="readonly"/>
						</div>
					</div>
					<div class="form-group required">
            <label class="col-sm-2 control-label" for="input-fullname"><?php echo $entry_fullname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="fullname" value="<?php echo $fullname; ?>" placeholder="<?php echo $entry_fullname; ?>" id="input-fullname" class="form-control" />
              <?php if ($error_fullname) { ?>
              <div class="text-danger"><?php echo $error_fullname; ?></div>
              <?php } ?>
            </div>
          </div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
						<div class="col-sm-10">
							<a href="" id="thumb-image" data-toggle="image"
								class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt=""
								title="" data-placeholder="<?php echo $placeholder; ?>" /></a> <input
								type="hidden" name="image" value="<?php echo $image; ?>"
								id="input-image" />
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
						<div class="col-sm-10">
							<input type="text" name="telephone" value="<?php echo $telephone; ?>"
								placeholder="<?php echo $telephone; ?>" id="input-telephone"
								class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-fax"><?php echo $entry_fax; ?></label>
						<div class="col-sm-10">
							<input type="text" name="fax" value="<?php echo $fax; ?>"
								placeholder="<?php echo $fax; ?>" id="input-fax"
								class="form-control" />
						</div>
					</div>
					<div class="form-group required">
            <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
            <div class="col-sm-10">
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
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
            <div class="col-sm-10">
              <select name="zone_id" id="input-zone" class="form-control">
              </select>
              <?php if ($error_zone) { ?>
              <div class="text-danger"><?php echo $error_zone; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
            <div class="col-sm-10">
              <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <div class="text-danger"><?php echo $error_city; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?></label>
            <div class="col-sm-10">
              <input type="text" name="address" value="<?php echo $address; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address" class="form-control" />
              <?php if ($error_address) { ?>
              <div class="text-danger"><?php echo $error_address; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
            <div class="col-sm-10">
              <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_postcode) { ?>
              <div class="text-danger"><?php echo $error_postcode; ?></div>
              <?php } ?>
            </div>
          </div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
						<div class="col-sm-10">
							<input type="password" name="password"
								value="<?php echo $password; ?>"
								placeholder="<?php echo $entry_password; ?>" id="input-password"
								class="form-control" autocomplete="off" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php  } ?>
            </div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
						<div class="col-sm-10">
							<input type="password" name="confirm"
								value="<?php echo $confirm; ?>"
								placeholder="<?php echo $entry_confirm; ?>" id="input-confirm"
								class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php  } ?>
            </div>
					</div>
				</form>
			</div>
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
<?php echo $footer; ?>