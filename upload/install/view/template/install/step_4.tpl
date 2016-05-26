<?php echo $header; ?>
<div class="container">
  <header>
    <div class="row">
      <div class="col-sm-6">
        <h1 class="pull-left">4<small>/4</small></h1>
        <h3><?php echo $heading_title; ?><br>
          <small><?php echo $text_step_4; ?></small></h3>
      </div>
      <div class="col-sm-6">
        <div id="logo" class="pull-right hidden-xs"><img src="view/image/logo.png" alt="ClerksCart" title="ClerksCart" /></div>
      </div>
    </div>
  </header>
  <?php if ($success) { ?>
  <div class="alert alert-success"><?php echo $text_success; ?></div>
  <?php } ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <div class="visit">
    <div class="row">
      <div class="col-sm-5 col-sm-offset-1 text-center">
        <p><i class="fa fa-shopping-cart fa-5x"></i></p>
        <a href="../" class="btn btn-secondary"><?php echo $text_catalog; ?></a></div>
      <div class="col-sm-5 text-center">
        <p><i class="fa fa-cog fa-5x white"></i></p>
        <a href="../admin/" class="btn btn-secondary"><?php echo $text_admin; ?></a></div>
    </div>
  </div>
  <div class="modules">
    <div class="row">
      <h2 class="text-center"><?php echo $text_clerkscart_base; ?></h2>
    </div>
    <div class="row">
  <div class="modules">
    <div class="row" id="extension">
      <h2 class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i> <?php echo $text_loading; ?></h2>
    </div>
    <div class="row">
      <div class="col-sm-12 text-center"><a href="http://www.opencart.com/index.php?route=extension/extension&utm_source=opencart_install&utm_medium=store_link&utm_campaign=opencart_install" target="_BLANK" class="btn btn-default"><?php echo $text_extension; ?></a></div>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$.ajax({
		url: '<?php echo $extension; ?>',
		type: 'post',
		dataType: 'json',
		success: function(json) {
			if (json['extensions']) {
				html  = '';
				
				for (i = 0; i < json['extensions'].length; i++) {
					extension = json['extensions'][i];
					
					html += '<div class="col-sm-6 module">';
					html += '  <a class="thumbnail pull-left" href="' + extension['href'] + '"><img src="' + extension['image'] + '" alt="' + extension['name'] + '" /></a>';
					html += '  <h5>' + extension['name'] + '</h5>';
					html += '  <p>' + extension['price'] + ' <a target="_BLANK" href="' + extension['href'] + '"><?php echo $text_view; ?></a></p>';
					html += '  <div class="clearfix"></div>';
					html += '</div>';
					
					i++;
				}
				
				$('#extension').html(html);
			} else {
				$('#extension').fadeOut();
			}
		}
	});
});
//--></script>