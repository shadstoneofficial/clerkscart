<div class="list-group">
  <?php if (!$logged) { ?>
  <a href="<?php echo $login; ?>" class="list-group-item"><?php echo $text_login; ?></a> <a href="<?php echo $register; ?>" class="list-group-item"><?php echo $text_register; ?></a> <a href="<?php echo $forgotten; ?>" class="list-group-item"><?php echo $text_forgotten; ?></a>
  <?php } ?>
  <a href="<?php echo $account; ?>" class="list-group-item"><?php echo $text_account; ?></a>
  <?php if ($logged) { ?>
  <a href="<?php echo $edit; ?>" class="list-group-item"><?php echo $text_edit; ?></a> <a href="<?php echo $password; ?>" class="list-group-item"><?php echo $text_password; ?></a>
  <?php } ?>
  <a href="<?php echo $address; ?>" class="list-group-item"><?php echo $text_address; ?></a> <a href="<?php echo $wishlist; ?>" class="list-group-item"><?php echo $text_wishlist; ?></a> <a href="<?php echo $order; ?>" class="list-group-item"><?php echo $text_order; ?></a> <a href="<?php echo $download; ?>" class="list-group-item"><?php echo $text_download; ?></a><a href="<?php echo $recurring; ?>" class="list-group-item"><?php echo $text_recurring; ?></a> <a href="<?php echo $reward; ?>" class="list-group-item"><?php echo $text_reward; ?></a> <a href="<?php echo $return; ?>" class="list-group-item"><?php echo $text_return; ?></a> <a href="<?php echo $transaction; ?>" class="list-group-item"><?php echo $text_transaction; ?></a> <a href="<?php echo $newsletter; ?>" class="list-group-item"><?php echo $text_newsletter; ?></a>
  <?php if ($logged) { ?>
  <?php if ($seller == 1) { ?>
      <h2><?php echo $text_clerkad; ?></h2>
        <a href="<?php echo $seller_edit; ?>" class="list-group-item"><?php echo $text_selleredit; ?></a>
        <a href="<?php echo $product_add; ?>" class="list-group-item"><?php echo $text_product_add; ?></a>
        <a href="<?php echo $product_form; ?>" class="list-group-item"><?php echo $text_productlist; ?></a>
        <a href="<?php echo $download_add; ?>" class="list-group-item"><?php echo $text_download_add; ?></a>
        <a href="<?php echo $download_form; ?>" class="list-group-item"><?php echo $text_downloadlist; ?></a>
        <a href="<?php echo $orderlist; ?>" class="list-group-item"><?php echo $text_orderlist; ?></a>
        <a href="<?php echo $seller_transaction; ?>" class="list-group-item"><?php echo $text_transaction; ?></a>
        <a href="<?php echo $seller_shipping; ?>" class="list-group-item"><?php echo $text_sellershipping; ?></a>
        <a href="<?php echo $seller_coupon; ?>" class="list-group-item"><?php echo $text_coupon; ?></a>
        <a href="<?php echo $returnlist; ?>" class="list-group-item"><?php echo $text_return; ?></a>
      <?php } ?>
  <a href="<?php echo $logout; ?>" class="list-group-item"><?php echo $text_logout; ?></a>
  <?php } ?>
</div>
