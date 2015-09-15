<!-- First Row  -->
  <div class="col-lg-3 col-md-3 col-sm-6">
    <!-- commission -->
    <div class="tile">
      <div class="tile-heading"><?php echo $heading_title_commission; ?> </div>
      <div class="tile-body"><i class="fa fa-money"></i> <h3 class="pull-right"><?php echo $total_formated_commission; ?></h3>
      </div>
      <div class="tile-footer"><a href="<?php echo $commission; ?>"><?php echo $text_view; ?></a>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-3 col-sm-6">
    <!-- sale -->
    <div class="tile">
      <div class="tile-heading"><?php echo $heading_title_sale; ?>
        <span class="pull-right"> </span>
      </div>
      <div class="tile-body">
        <i class="fa fa-cubes"></i> <h3 class="pull-right"><?php echo $total_formated_sale; ?></h3>
      </div>
      <div class="tile-footer"><a href="<?php echo $sale; ?>"><?php echo $text_view; ?></a></div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-3 col-sm-6">
    <!-- order -->
    <div class="tile">
      <div class="tile-heading"><?php echo $heading_title_order; ?>
        <span class="pull-right"> </span>
      </div>
      <div class="tile-body"><i class="fa fa-shopping-cart"></i>
        <h2 class="pull-right"><?php echo $total_order; ?></h2>
      </div>
      <div class="tile-footer"><a href="<?php echo $order; ?>"><?php echo $text_view; ?></a></div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-3 col-sm-6">
    <!-- customer -->
    <div class="tile">
      <div class="tile-heading"><?php echo $heading_title_customer; ?></div> 
      <div class="tile-body"><i class="fa fa-users"></i>
        <h2 class="pull-right"><?php echo $total_vip; ?>/<?php echo $total_card; ?></h2>
      </div>
      <div class="tile-footer"><a href="<?php echo $customer; ?>"><?php echo $text_view; ?></a></div>
    </div>
  </div>

