<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <h1><?php echo $widget_title; ?></h1>
            <p><?php echo $widget_notice;?></p>
            <div class="paymentwall-widget">
                <?php print_r($iframe); ?>
            </div>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>

<?php /* Please remove comments, If you want auto redirect to the success page
<script type="text/javascript">
    $(document).ready(function () {
        // Destroy interval if exist
        if (typeof paymentListener != 'undefined') {
            clearInterval(paymentListener);
        }
        paymentListener = setInterval(function () {
            $.post(
                'index.php?route=checkout/successornot',
                {
                    order_id: '<?php echo $orderId;?>'
                },
                function (data) {
                    if (data == 1) {
                        location.href = "index.php?route=checkout/success";
                    }
                }
            );
        }, 5000);
    });
</script>
*/ ?>