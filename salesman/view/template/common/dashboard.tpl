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
 
  <!-- Filter by date -->
  <div class="panel-body">
    <div class="well">
      <div class="row">
  
           <div class="col-sm-3">
             <div class="form-group">
               <label class="control-label" for="input-period-from"><?php echo $entry_period_from; ?></label>
               <div class="input-group date">
               <input type="text" name="filter_period_from" value="<?php echo $filter_period_from; ?>" placeholder="<?php echo $entry_period_from; ?>" data-date-format="YYYY-MM-DD" id="input-date-from" class="form-control" />
               <span class="input-group-btn">
                 <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
               </span></div>
             </div>
           </div>

           <div class="col-sm-3">
             <div class="form-group">
               <label class="control-label" for="input-period-to"><?php echo $entry_period_to; ?></label>
               <div class="input-group date">
               <input type="text" name="filter_period_to" value="<?php echo $filter_period_to; ?>" placeholder="<?php echo $entry_period_to; ?>" data-date-format="YYYY-MM-DD" id="input-date-to" class="form-control" />
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
  </div>

  <div class="container-fluid">
    <?php if($isAuthorized) { ?>
      <?php echo $achievement ?>
    <?php } else {?>
       <?php echo $application_status_message ?>
    <?php } ?>
  </div>
</div>

<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=common/dashboard&token=<?php echo $token; ?>';

	var filter_period_from = $('input[name=\'filter_period_from\']').val();

	if (filter_period_from) {
		url += '&filter_period_from=' + encodeURIComponent(filter_period_from);
	}

	var filter_period_to = $('input[name=\'filter_period_to\']').val();

	if (filter_period_to) {
		url += '&filter_period_to=' + encodeURIComponent(filter_period_to);
	}

	location = url;
});
//--></script>

<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>

<?php echo $footer; ?>
