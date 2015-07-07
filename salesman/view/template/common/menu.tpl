<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
  <?php if($isAuthorized) { ?>
  <li id="vip"><a class="parent"><i class="fa fa-credit-card fa-fw"></i> <span><?php echo $text_vip_card_mgmt; ?></span></a>
    <ul>
      <li><a href="<?php echo $vip_card_srch; ?>"><?php echo $text_vip_card_srch; ?></a></li>
      <li><a href="<?php echo $vip_record_srch; ?>"><?php echo $text_vip_record_srch; ?></a></li>
      <li><a href="<?php echo $vip_card_apply; ?>"><?php echo $text_vip_card_apply; ?></a></li>
      <li><a href="javascript:void(0);"><?php echo $text_vip_card_apply; ?></a></li>
    </ul>
  </li>
  <?php } else { ?>
  <li id="vip"><a class="parent"><i class="fa fa-credit-card fa-fw"></i> <span><?php echo $text_vip_card_mgmt; ?></span></a>
  </li>
  <?php } ?>

  <?php if($isAuthorized) { ?>
  <li id="financial "><a class="parent"><i class="fa fa-money fa-fw"></i> <span><?php echo $text_financial; ?></span></a>
    <ul>
      <li><a href="<?php echo $commission_srch; ?>"><?php echo $text_commission_srch; ?></a></li>
      <li><a href="<?php echo $settle_srch; ?>"><?php echo $text_settle_srch; ?></a></li>
      <li><a href="<?php echo $settle_account; ?>"><?php echo $text_settle_account; ?></a></li>
    </ul>
  </li>
  <?php } else { ?>
  <li id="financial "><a class="parent"><i class="fa fa-money fa-fw"></i> <span><?php echo $text_financial; ?></span></a>
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
      <li><a href="<?php echo $system_notice; ?>"><?php echo $text_system_notice; ?></a></li>
      <?php } ?>
    </ul>
  </li>
</ul>
