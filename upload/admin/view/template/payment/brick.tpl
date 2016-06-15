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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-brick"
                      class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_public_key"><?php echo $entry_public_key; ?></label>

                        <div class="col-sm-10">
                            <input type="text" name="brick_public_key" value="<?php echo $brick_public_key; ?>"
                                   id="brick_public_key" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_private_key"><?php echo $entry_private_key; ?></label>

                        <div class="col-sm-10">
                            <input type="text" name="brick_private_key" value="<?php echo $brick_private_key; ?>"
                                   id="brick_private_key" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_public_key"><?php echo $entry_public_test_key; ?></label>

                        <div class="col-sm-10">
                            <input type="text" name="brick_public_test_key"
                                   value="<?php echo $brick_public_test_key; ?>"
                                   id="brick_public_test_key" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_private_key"><?php echo $entry_private_test_key; ?></label>

                        <div class="col-sm-10">
                            <input type="text" name="brick_private_test_key"
                                   value="<?php echo $brick_private_test_key; ?>"
                                   id="brick_private_test_key" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_complete_status"><?php echo $entry_complete_status; ?></label>

                        <div class="col-sm-10">
                            <select name="brick_complete_status" id="brick_complete_status" class="form-control">
                                <?php foreach($statuses as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"
                                <?php if($key == $brick_complete_status) echo ' selected="selected" ' ?> >
                                <?php echo $value; ?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_under_review_status"><?php echo $entry_under_review_status; ?></label>

                        <div class="col-sm-10">
                            <select name="brick_under_review_status" id="brick_under_review_status" class="form-control">
                                <?php foreach($statuses as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"
                                <?php if($key == $brick_under_review_status) echo ' selected="selected" ' ?> >
                                <?php echo $value; ?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="brick_test_mode"><?php echo $entry_test; ?></label>

                        <div class="col-sm-10">
                            <?php if ($brick_test_mode) { ?>
                            <input type="radio" name="brick_test_mode" value="1" checked="checked"/>
                            <?php echo $text_enabled; ?>
                            <input type="radio" name="brick_test_mode" value="0"/>
                            <?php echo $text_disabled; ?>
                            <?php } else { ?>
                            <input type="radio" name="brick_test_mode" value="1"/>
                            <?php echo $text_enabled; ?>
                            <input type="radio" name="brick_test_mode" value="0" checked="checked"/>
                            <?php echo $text_disabled; ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="brick_status"><?php echo $entry_active; ?></label>

                        <div class="col-sm-10">
                            <select name="brick_status" class="form-control">
                                <?php if ($brick_status) { ?>
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