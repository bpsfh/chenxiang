<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
  <?php if($isAuthorized) { ?>
  <li id="vip"><a class="parent"><i class="fa fa-credit-card fa-fw"></i> <span><?php echo $text_vip_card_mgmt; ?></span></a>
    <ul>
      <li><a href="<?php echo $vip_card_srch; ?>"><?php echo $text_vip_card_srch; ?></a></li>
      <li><a href="<?php echo $vip_card_apply; ?>"><?php echo $text_vip_card_apply; ?></a></li>
      <li><a href="<?php echo $vip_customer; ?>"><?php echo $text_vip_customer; ?></a></li>
      <li><a href="<?php echo $vip_order; ?>"><?php echo $text_vip_order; ?></a></li>
    </ul>
  </li>
  <?php } else { ?>
  <li id="vip"><a class="parent"><i class="fa fa-credit-card fa-fw"></i> <span><?php echo $text_vip_card_mgmt; ?></span></a>
  </li>
  <?php } ?>

  <?php if($isAuthorized) { ?>
  <li id="finance"><a class="parent"><i class="fa fa-money fa-fw"></i> <span><?php echo $text_finance; ?></span></a>
    <ul>
      <li><a href="<?php echo $unit_commission; ?>"><?php echo $text_unit_commission; ?></a></li>
      <li><a href="<?php echo $order_commissions; ?>"><?php echo $text_order_commissions; ?></a></li>
      <li><a href="<?php echo $commissions_apply; ?>"><?php echo $text_commissions_apply; ?></a></li>
    </ul>
  </li>
  <?php } else { ?>
  <li id="finance"><a class="parent"><i class="fa fa-money fa-fw"></i> <span><?php echo $text_finance; ?></span></a>
  </li>
  <?php } ?>

  <li id="account"><a class="parent"><i class="fa fa-user fa-fw"></i> <span><?php echo $text_account; ?></span></a>
    <ul>
      <li><a href="<?php echo $basic_info; ?>"><?php echo $text_basic_info; ?></a></li>
      <li><a href="<?php echo $bank_info; ?>"><?php echo $text_bank_info; ?></a></li>
      <li><a href="<?php echo $contact_us; ?>"><?php echo $text_contact_us; ?></a></li>
      <?php if($isAuthorized) { ?>
      <li><a href="<?php echo $invoice_upload; ?>"><?php echo $text_invoice_upload; ?></a></li>
      <!--<li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>-->
      <!--<li><a href="<?php echo $system_notice; ?>"><?php echo $text_system_notice; ?></a></li>-->
      <?php } ?>
    </ul>
  </li>

  <?php if($isAuthorized && $isWithGrantOpt) { ?>
    <li><a class="parent"><i class="fa fa-users fa-fw"></i> <span><?php echo $text_sub_salesman; ?></span></a>
	  <ul>
	    <li><a href="<?php echo $sub_salesman; ?>"><?php echo $text_sub_salesman_user; ?></a></li>
	    <li><a href="<?php echo $vip_card_application; ?>"><?php echo $text_vip_card_application; ?></a></li>
	    <li><a href="<?php echo $sub_unit_commission; ?>"><?php echo $text_sub_salesman_commission; ?></a></li>
	    <li><a href="<?php echo $sub_salesman_contact; ?>"><?php echo $text_sub_salesman_contact; ?></a></li>
	  </ul>
    </li>
  <?php } ?>

</ul>
