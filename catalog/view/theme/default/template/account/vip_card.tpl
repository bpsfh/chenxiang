<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
    	<?php echo $content_top; ?>
    	<?php if ($vip_card_num && !$error_warning) { ?>
    		<legend><?php echo $vip_heading_title; ?></legend>
    		<div>
    			<label class="col-sm-2 control-label" for="input-fullname"><?php echo $entry_vip_card_num; ?> </label>
    			<label><?php echo $vip_card_num; ?></label>
    		</div>
    		<div>
    			<label class="col-sm-2 control-label" for="input-fullname"><?php echo $entry_date_bind_to_customer; ?> </label>
    			<label><?php echo $date_bind_to_customer; ?></label>
    		</div>
    	<?php } else {?>
	  		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
	        	<fieldset>
	        		<legend><?php echo $heading_title; ?></legend>
	          		<div class="form-group required">
		           		<label class="col-sm-2 control-label" for="input-fullname"><?php echo $entry_vip_card_num; ?> </label>
		            	<div class="col-sm-10">
		              		<input type="text" name="vip_card_num" maxlength='16' value="<?php echo $vip_card_num; ?>" placeholder="<?php echo $entry_vip_card_num; ?>" id="input-vipCardNum" class="form-control" />
		              		<?php if ($error_vip_card_num) { ?>
		              			<div class="text-danger"><?php echo $error_vip_card_num; ?></div>
		              		<?php } ?>
		            	</div>
	          		</div>
	          </fieldset>
	          <div class="buttons clearfix">
		          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
		          <div class="pull-right">
		            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
		          </div>
        	  </div>
	         </form>
         <?php } ?> 
  		<?php echo $content_bottom; ?>
  	</div>
  	<?php echo $column_right; ?>
  </div>
</div>
<?php echo $footer; ?>