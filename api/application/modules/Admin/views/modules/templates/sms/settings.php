<div class="container">
    <?php if(! empty($this->session->flashdata('sms_api_ack')) ): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('sms_api_ack') ?></div>
    <?php endif; ?>
    <form action="<?= base_url('admin/templates/sms_settings') ?>" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title"><i class="fa fa-cogs"></i>SMS Settings</div>
            </div>
            <div class="panel-body">
                <div class="tab-content form-horizontal">
                    <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
                        <?php foreach($sms_api as $key => $val): ?>
                            <?php $label = ucfirst(str_replace('_', ' ', $key)); ?>
                            <div class="row form-group">
                                <label class="col-md-2 control-label text-left"><?=$label?></label>
                                <div class="col-md-4">
                                    <input type="text" name="<?=$key?>" value="<?=$val?>" placeholder="<?=$label?>" class="form-control">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#testSmsModalBox">Individual SMS Test</button>
            </div>
        </div>
    </form>

    <!-- Modal test -->
    <div id="testSmsModalBox" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Test SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-md-3 control-label text-left">Receivers Number</label>
                        <div class="col-md-9">
                            <input type="text" name="recepient" value="" class="form-control" placeholder="Number">
                            <small>Use number without +. e.g 92xxx#######</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 control-label text-left">Message</label>
                        <div class="col-md-9">
                            <textarea type="text" name="message" class="form-control" placeholder="Message">Hello World</textarea>
                        </div>
                    </div>
                    <div id="alertBox"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSendSms">Send</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-success">
        <p>For Documentation : <a href="https://phptravels.com/documentation/nexmo-sms-setting/" target="_blank"><strong>Click Here</strong></a></p>
    </div>

    <!-- Modal modelEdit -->
    <div id="modelEdit" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <label>Shortcode Variables</label>
                    <div class="well well-sm" id="modalShortCode"></div>
                    <p><textarea rows="8" class="form-control" id="modalBody"></textarea></p>

                    <div id="alertBox"></div>
                </div>
                <div class="modal-footer">
                    <br>
                    <input type="hidden" name="objectId">
                    <button type="button" class="btn btn-success" id="btnSave">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal modelTest -->
    <div id="modelTest" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">

                    <p><textarea rows="8" class="form-control" id="modalBody" disabled></textarea></p>
                    <input type="text" name="recepient" class="form-control" placeholder="Moblle Number" required/>
                    <small>Use number without +. e.g 92xxx#######</small>
                    <br>

                    <div id="alertBox"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnSend">Send</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading"><strong>SMS TEMPLATES</strong></div>
        <div class="panel-body">
            <?php foreach($templates as $template): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title pull-left"><?=$template->category?></span>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr role="row">
                                <th class="col-md-1"><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
                                <th class="col-md-9">Template Name</th>
                                <th class="col-md-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php $serial = 1; ?>
                        <?php foreach($template->templates as $tempObject): ?>
                            <tr>
                                <td><?= $serial ?></td>
                                <td><a href="javascript:void()"><?= $tempObject->name ?></a></td>
                                <td align="center">
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" onclick="editModelBtn(this)" data-content='<?=json_encode($tempObject)?>'><i class="fa fa-edit"></i> Edit</button>
                                    <button data-toggle="modal" class="btn btn-xs btn-primary" onclick="testModelBtn(this)" data-content='<?=json_encode($tempObject)?>'><i class="fa fa-envelope"></i> TEST SMS</button>
                                </td>
                            </tr>
                            <?php $serial += 1; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>        
        </div>
    </div>

</div>
