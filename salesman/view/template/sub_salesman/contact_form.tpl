<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-contact-edit" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_title_reply; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-contact-edit" class="form-horizontal">
          <div class="form-group">
          <label class="col-sm-4 control-label" for="input-contact-title"><?php echo $text_title; ?></label>
          <div class="col-sm-3">
            <input type="text" name="contact_title" value="<?php echo $contact_title; ?>" id="input-contact-title" class="form-control"readonly="readonly" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="input-contact-phone"><?php echo $text_phone; ?></label>
          <div class="col-sm-3">
            <input type="text" name="contact_phone" value="<?php echo $contact_phone; ?>" id="input-contact-phone" class="form-control" readonly="readonly"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="input-contact-email"><?php echo $text_email; ?></label>
          <div class="col-sm-3">
            <input type="text" name="contact_email" value="<?php echo $contact_email; ?>" id="input-contact-email" class="form-control" readonly="readonly"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="input-contact-content"><?php echo $text_content; ?></label>
          <div class="col-sm-6">
            <textarea  name="contact_content" rows="5" placeholder="<?php echo $text_contact_content; ?>" id="input-contact-content" class="form-control" readonly="readonly"><?php echo $contact_content; ?></textarea>
          </div>
        </div>
        <div class="form-group required">
          <label class="col-sm-4 control-label" for="input-reply-content"><?php echo $text_reply; ?></label>
          <div class="col-sm-6">
            <textarea  name="reply_content" rows="5" placeholder="<?php echo $text_reply_content; ?>" id="input-reply-content" class="form-control" ><?php echo $reply_content; ?></textarea>
            <?php if ($error_reply_content) { ?>
            <div class="text-danger"><?php echo $error_reply_content; ?></div>
            <?php } ?>
          </div>
        </div>
	  </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
