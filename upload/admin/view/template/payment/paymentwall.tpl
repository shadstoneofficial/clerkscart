<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-cod" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <div class="panel panel-default">
            <!--BEGIN HEADING-->
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <!--END HEADING-->
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-paymentwall" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_key"><?php echo $entry_key; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="paymentwall_key" value="<?php echo $paymentwall_key; ?>" id="paymentwall_key" class="form-control"/>
                            <?php if ($error_key) { ?>
                            <div class="text-danger"><?php echo $error_key; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_secret"><?php echo $entry_secret; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="paymentwall_secret" value="<?php echo $paymentwall_secret; ?>" id="paymentwall_secret" class="form-control"/>
                            <?php if ($error_secret) { ?>
                            <div class="text-danger"><?php echo $error_secret; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_widget"><?php echo $entry_widget; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="paymentwall_widget" value="<?php echo $paymentwall_widget; ?>" id="paymentwall_widget" class="form-control"/>
                            <?php if ($error_widget) { ?>
                            <div class="text-danger"><?php echo $error_widget; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_complete_status"><?php echo $entry_complete_status; ?></label>
                        <div class="col-sm-10">
                            <select name="paymentwall_complete_status" id="paymentwall_complete_status" class="form-control">
                                <?php foreach($statuses as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"
                                <?php if($key == $paymentwall_complete_status) echo ' selected="selected" ' ?> >
                                <?php echo $value; ?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_cancel_status"><?php echo $entry_cancel_status; ?></label>
                        <div class="col-sm-10">
                            <select name="paymentwall_cancel_status" id="paymentwall_cancel_status" class="form-control">
                                <?php foreach($statuses as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"
                                <?php if($key == $paymentwall_cancel_status) echo ' selected="selected" ' ?> >
                                <?php echo $value; ?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_test"><?php echo $entry_test; ?></label>
                        <div class="col-sm-10">
                            <?php if ($paymentwall_test) { ?>
                            <input type="radio" name="paymentwall_test" value="1" checked="checked"/>
                            <?php echo $text_enabled; ?>
                            <input type="radio" name="paymentwall_test" value="0"/>
                            <?php echo $text_disabled; ?>
                            <?php } else { ?>
                            <input type="radio" name="paymentwall_test" value="1"/>
                            <?php echo $text_enabled; ?>
                            <input type="radio" name="paymentwall_test" value="0" checked="checked"/>
                            <?php echo $text_disabled; ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_delivery"><?php echo $entry_delivery; ?></label>
                        <div class="col-sm-10">
                            <?php if ($paymentwall_delivery) { ?>
                            <input type="radio" name="paymentwall_delivery" value="1" checked="checked"/>
                            <?php echo $text_enabled; ?>
                            <input type="radio" name="paymentwall_delivery" value="0"/>
                            <?php echo $text_disabled; ?>
                            <?php } else { ?>
                            <input type="radio" name="paymentwall_delivery" value="1"/>
                            <?php echo $text_enabled; ?>
                            <input type="radio" name="paymentwall_delivery" value="0" checked="checked"/>
                            <?php echo $text_disabled; ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_success_url"><?php echo $entry_success_url; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="paymentwall_success_url" value="<?php echo $paymentwall_success_url; ?>" id="paymentwall_success_url" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="paymentwall_status"><?php echo $entry_active; ?></label>
                        <div class="col-sm-10">
                            <select name="paymentwall_status" class="form-control">
                                <?php if ($paymentwall_status) { ?>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <?php } else { ?>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>