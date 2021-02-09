<div class="row">
    <div class="col-md-3">
        <?php include 'sidebar.php'; ?>
    </div>
    <div class="col-md-9">
        <section class="panel">
            <div class="tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#email_config" data-toggle="tab"><i class="far fa-envelope"></i> <?=translate('semysms_config')?></a>
                    </li>
<!--                    <li>-->
<!--                        <a href="--><?//=base_url('school_settings/semysmstemplate' . $url)?><!--"><i class="fas fa-sitemap"></i> --><?//=translate('semysms_triggers')?><!--</a>-->
<!--                    </li>-->
                </ul>
                <div class="tab-content">
                    <div id="email_config" class="tab-pane active">
                        <?php echo form_open('school_settings/saveSemySmsConfig' . $url, array('class' => 'form-horizontal form-bordered frm-submit-msg')); ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=translate('device')?> <span class="required">*</span></label>
                            <div class="col-md-6">
                                <input class="form-control" value="<?=$config['device']?>" name="device"
                                       type="text" placeholder="from application">
                                <span class="error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=translate('token')?> <span class="required">*</span></label>
                            <div class="col-md-6">
                                <input class="form-control" value="<?=$config['token']?>" name="token"
                                       type="text" placeholder="from semysms website">
                                <span class="error"></span>
                            </div>
                        </div>


                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-md-2 col-sm-offset-3">
                                    <button type="submit" class="btn btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                                        <i class="fas fa-plus-circle"></i> <?=translate('save')?>
                                    </button>
                                </div>
                            </div>
                        </footer>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
