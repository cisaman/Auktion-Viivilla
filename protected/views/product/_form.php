<?php
$create_url = Yii::app()->createAbsoluteUrl('product/create');
$update_url = Yii::app()->createAbsoluteUrl('product/update/' . $model->product_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-form',
    'action' => ($model->isNewRecord) ? $create_url : $update_url,
    //'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'autocomplete' => 'off',
        'role' => 'form',
    //'target' => '_blank'
    ),
    'focus' => array($model, 'product_name'),
        ));

$flag_1 = ($model->isNewRecord) ? 1 : 0;
?>

<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/ckeditor/ckeditor.js"></script>

<link href="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/css/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/js/jquery.fileuploadmulti.min.js"></script>

<div class="row">
    <div class="col-md-9">        
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'basic_information'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet1" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet1">
                <div class="portlet-body">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_name'); ?>
                        <?php echo $form->textField($model, 'product_name', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_name'))); ?>
                        <?php echo $form->error($model, 'product_name', array('class' => 'text-red')); ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_description'); ?>
                        <?php //echo $form->textArea($model, 'page_content'); ?>           
                        <form action="sample_posteddata.php" method="post">                   
                            <textarea cols="80" id="Product_product_description" name="Product[product_description]" rows="20"><?php echo $model->product_description; ?></textarea>
                            <script>
                                CKEDITOR.replace('Product_product_description', {
                                    "filebrowserImageUploadUrl": "<?php echo Utils::GetBaseUrl() ?>/bootstrap/ckeditor/samples/plugins/imgupload.php"
                                });
                            </script>                    
                        </form>
                        <?php echo $form->error($model, 'product_description', array('class' => 'text-red')); ?>
                    </div> 
                </div>
            </div>          
        </div>

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'gallery_images'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet2" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet2">
                <div class="portlet-body">
                    <div class="form-group">
                        <div class="dropzone" id="myDropzone"></div>
                        <div id="attachments_em_" class="text-red" style="display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="portlet-footer">
                <?php echo Yii::t('lang', 'msg_images'); ?>
            </div>
        </div>

    </div>        
    <div class="col-md-3">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Action</h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet6" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet6">
                <div class="portlet-body">

                    <div class="form-group">
                        <?php if (!$model->isNewRecord) { ?>
                            <a href="<?php echo Utils::GetBaseUrl() . '/auktion/' . $model->product_id . '/' . strtolower(str_replace(' ', '-', $model->product_name)); ?>" target="_blank" id="newtab" class="newtab btn btn-green btn-block" ><?php echo Yii::t('lang', 'preview') ?></a>
                        <?php } ?>
                    </div>

                    <?php if (!$model->isNewRecord) { ?>
                        <div class="form-group">
                            <input type="hidden" name="publishthis" value="1"/>
                            <?php echo CHtml::submitButton(Yii::t('lang', 'publish'), array('class' => 'btn btn-green btn-block', 'id' => 'btnPublish', 'name' => 'btnPublish')); ?>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="unpublishthis" value="0"/>
                            <?php echo CHtml::submitButton(Yii::t('lang', 'unpublish'), array('class' => 'btn btn-green btn-block', 'id' => 'btnUnpublish', 'name' => 'btnUnpublish')); ?>
                        </div>                    
                        <div class="form-group">
                            <?php echo CHtml::submitButton(Yii::t('lang', 'update'), array('class' => 'btn btn-green btn-block', 'id' => 'btnUpdate', 'name' => 'btnUpdate')); ?>
                        </div>
                    <?php } ?>

                    <?php if ($model->isNewRecord) { ?>
                        <div class="form-group">
                            <?php echo CHtml::submitButton(Yii::t('lang', 'save'), array('class' => 'btn btn-green btn-block', 'id' => 'btnSave', 'name' => 'btnSave')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-block', 'id' => 'btnReset')); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>               
        </div>

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'seller'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet3" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet3">
                <div class="portlet-body">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_sellersID'); ?>
                        <input type="hidden" name="sellerid" id="sellerid" value="<?php echo $model->product_sellersID; ?>"/>
                        <?php
//                        $sellers = CHtml::listData(Sellers::model()->findAll(array('order' => 'sellers_username ASC')), 'sellers_id', 'sellers_username');
//                        $seller = $model->product_sellersID;
//
//                        $selected = array();
//                        if (isset($sellers) && !empty($sellers)) {
//                            foreach ($sellers as $key => $value) {
//                                if ($key == $seller) {
//                                    $selected[$key] = array('selected' => 'selected');
//                                }
//                            }
//                        }
//
//                        echo $form->dropDownList($model, 'product_sellersID', $sellers, array('class' => 'form-control', 'options' => $selected, 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('product_sellersID')));

                        if (!empty($model->product_sellersID)) {
                            $model->product_sellersID = Sellers::model()->getSellersUsername($model->product_sellersID);
                            echo $form->textField($model, 'product_sellersID', array('class' => 'form-control typeahead', 'options' => $selected, 'placeholder' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('product_sellersID')));
                        } else {
                            echo $form->textField($model, 'product_sellersID', array('class' => 'form-control typeahead', 'options' => $selected, 'placeholder' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('product_sellersID')));
                        }
                        ?>
                        <?php echo $form->error($model, 'product_sellersID', array('class' => 'text-red')); ?>

                    </div>
                </div>
            </div>               
        </div>

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'tax'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet7" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet7">
                <div class="portlet-body">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_tax'); ?>
                        <?php
                        $taxs = array('25' => '25 %', '12' => '12 %', '6' => '6 %');
                        $tax = $model->product_tax;

                        foreach ($taxs as $k => $v) {
                            if ($k == $tax) {
                                $selected[$k] = array('selected' => 'selected');
                            }
                        }

                        echo $form->dropDownList($model, 'product_tax', $taxs, array('class' => 'form-control', 'options' => $selected, 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('product_tax')));
                        ?>
                        <?php echo $form->error($model, 'product_tax', array('class' => 'text-red')); ?>
                    </div>
                </div>
            </div>               
        </div>

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'category'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet4" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet4">
                <div class="portlet-body">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_categoryID'); ?>
                        <?php
                        $category = CHtml::listData(Category::model()->findAll(array('order' => 'category_name ASC')), 'category_id', 'category_name');
                        $cats = split(',', $model->product_categoryID);

                        foreach ($cats as $c) {
                            $selected[$c] = array('selected' => 'selected');
                        }

                        echo $form->listBox($model, 'product_categoryID', $category, array('size' => '10', 'multiple' => 'TRUE', 'class' => 'form-control', 'options' => $selected));
                        ?>
                        <?php echo $form->error($model, 'product_categoryID', array('class' => 'text-red')); ?>
                    </div>
                </div>
            </div>               
        </div>

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'featured_image'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet8" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet8">
                <div class="portlet-body">                    
                    <div class="form-group text-center">                    
                        <?php echo $form->labelEx($model, 'product_featuredimage'); ?>
                        <?php
                        $flag = 1;
                        $path = Utils::NoImagePath();
                        if (!empty($model->product_featuredimage)) {
                            $path = Utils::ProductImagePath() . $model->product_featuredimage;
                            $flag = 0;
                        }
                        ?>                                        
                        <div class="innerdiv">
                            <img id="imagePreview" style="height: 200px;width: 100%" src="<?php echo $path; ?>"/>
                            <span id="span_close">
                                <?php if ($flag == 0) { ?>
                                    <span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>
                                <?php } ?>
                            </span>                                                
                        </div>
                        <div id="statusMsg"></div>
                        <?php echo $form->fileField($model, 'product_featuredimage', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'product_featuredimage', array('class' => 'text-red')); ?>
                        <p class="help-block text-green"><?php echo Yii::t('lang', 'msg_images'); ?></p>                        
                    </div>
                </div>
            </div>               
        </div>

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo Yii::t('lang', 'auction_settings'); ?></h4>
                </div>
                <div class="portlet-widgets">
                    <a href="#defaultPortlet5" data-parent="#accordion" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="defaultPortlet5">
                <div class="portlet-body">                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_current_price'); ?>
                        <?php
                        $model->product_current_price = empty($model->product_current_price) ? 0 : $model->product_current_price;
                        echo $form->textField($model, 'product_current_price', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_current_price')));
                        ?>
                        <?php echo $form->error($model, 'product_current_price', array('class' => 'text-red')); ?>
                    </div>
                    <?php
                    $state = TRUE;
                    if ($model->isNewRecord) {
                        $state = FALSE;
                    }
                    ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_bid_diff_price'); ?>
                        <?php
                        //$model->product_bid_diff_price = empty($model->product_bid_diff_price) ? 1 : $model->product_bid_diff_price;
                        echo $form->textField($model, 'product_bid_diff_price', array('maxlength' => 50, 'class' => 'form-control', 'readonly' => FALSE, 'placeholder' => $model->getAttributeLabel('product_bid_diff_price')));
                        ?>
                        <?php echo $form->error($model, 'product_bid_diff_price', array('class' => 'text-red')); ?>
                    </div>
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'product_temp_current_price'); ?>
                            <?php echo $form->textField($model, 'product_temp_current_price', array('maxlength' => 50, 'class' => 'form-control', 'readonly' => FALSE, 'placeholder' => $model->getAttributeLabel('product_temp_current_price'))); ?>
                            <?php echo $form->error($model, 'product_temp_current_price', array('class' => 'text-red')); ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_reserve_price'); ?>
                        <?php echo $form->textField($model, 'product_reserve_price', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_reserve_price'))); ?>
                        <?php echo $form->error($model, 'product_reserve_price', array('class' => 'text-red')); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_shipping_price'); ?>
                        <?php echo $form->textField($model, 'product_shipping_price', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_shipping_price'))); ?>
                        <?php echo $form->error($model, 'product_shipping_price', array('class' => 'text-red')); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_buynow_price'); ?>
                        <?php echo $form->textField($model, 'product_buynow_price', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_buynow_price'))); ?>
                        <?php echo $form->error($model, 'product_buynow_price', array('class' => 'text-red')); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_winners'); ?>                    
                        <?php
                        //$model->product_winners = empty($model->product_winners) ? 3 : $model->product_winners;
                        echo $form->textField($model, 'product_winners', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_winners')));
                        ?>
                        <?php echo $form->error($model, 'product_winners', array('class' => 'text-red')); ?>
                    </div>                
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'product_expiry_date'); ?>
                        <?php echo $form->textField($model, 'product_expiry_date', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('product_expiry_date'))); ?>
                        <?php echo $form->error($model, 'product_expiry_date', array('class' => 'text-red')); ?>
                    </div>
                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            $curdate = date("Y-m-d H:i:s");
                        } else {
                            $curdate = $model->product_publish_date;
                        }
                        ?>
                        <?php echo $form->labelEx($model, 'product_publish_date'); ?>
                        <?php echo $form->textField($model, 'product_publish_date', array('maxlength' => 50, 'class' => 'form-control', 'value' => $curdate, 'placeholder' => $model->getAttributeLabel('product_publish_date'))); ?>
                        <?php echo $form->error($model, 'product_publish_date', array('class' => 'text-red')); ?>
                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>



<?php $this->endWidget(); ?>

<link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<link href="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/css/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/js/plugins/dropzone/dropzone.js" type="text/javascript"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">
                                $(document).ready(function () {

                                    $("div.dropzone").sortable({
                                        items: '.dz-preview',
                                        cursor: 'move',
                                        opacity: 0.5,
                                        containment: "parent",
                                        distance: 20,
                                        tolerance: 'pointer',
                                        update: function (e, ui) {

                                        }
                                    });


                                    $('#Product_product_expiry_date').datetimepicker({
                                        weekStart: 1,
                                        todayBtn: 1,
                                        autoclose: 1,
                                        todayHighlight: 1,
                                        startView: 2,
                                        forceParse: 0,
                                        showMeridian: 1
                                    });
                                    $('#Product_product_publish_date').datetimepicker({
                                        weekStart: 1,
                                        todayBtn: 1,
                                        autoclose: 1,
                                        todayHighlight: 1,
                                        startView: 2,
                                        forceParse: 0,
                                        showMeridian: 1,
                                    });
                                    Dropzone.autoDiscover = false;
                                    var count = 1;
                                    $("div.dropzone").dropzone({url: "<?php echo Utils::GetBaseUrl(); ?>/product/upload",
                                        addRemoveLinks: true,
                                        acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
                                        maxFilesize: 2,
                                        success: function (file, res) {
                                            var resp = $.parseJSON(res);
                                            var objectOn = $("div.dropzone .dz-details .dz-filename span:contains('" + file.name + "')");
                                            //console.log(objectOn);
                                            $(objectOn).append("<input type='hidden' data='" + file.name + "' value='" + resp.fname + "' name ='gallery[]' >");
                                            //$('.dz-details').append("<input type='hidden' data=" + file.name + " value=" + resp.fname + " name ='gallery[]' >");
                                            $(".dz-success-mark").show();
                                            $(".dz-success-mark").css("opacity", "1");
                                        },
                                        removedfile: function (res) {
                                            $("div.dropzone .dz-details .dz-filename span:contains('" + res.name + "')").parent().parent().parent().remove();
                                            $.each($('input:hidden'), function (i, val) {
                                                var resd1 = ($.trim($(this).attr("data")));
                                                var resd11 = ($.trim($(this).val()));
                                                var resd2 = $.trim(res.name);
                                                if (resd1 == resd2) {
                                                    $("#product-form").append("<input type='hidden'  value='" + resd11 + "' name ='remgallery[]' >");
                                                    //$('.dz-details').append("<input type='hidden' data=" + value.name + " value=" + value.name + " name ='gallery[]' >");
                                                    $(this).remove();
                                                }
                                            });
                                        }
                                    });

                                    /*********************************************************/
                                    /*   User Image Block Start   */
                                    /*********************************************************/
                                    $("#Product_product_featuredimage").change(function () {
                                        var files = !!this.files ? this.files : [];
                                        if (!files.length || !window.FileReader)
                                            return;
                                        var ftype = $(this)[0].files[0].type;
                                        var types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                                        if ($.inArray(ftype, types) > 0) {
                                            if (/^image/.test(files[0].type)) {
                                                if ($(this)[0].files[0].size > 2097152) {
                                                    $('#statusMsg').addClass('alert alert-danger').html('The Image Size is too Big. Max size for the image is 2MB');
                                                    $(this).val('');
                                                    $("#imagePreview").attr("src", '<?php echo!empty($model->product_featuredimage) ? Utils::ProductImagePath() . $model->product_featuredimage : Utils::NoImagePath(); ?>');
                                                    setTimeout(function () {
                                                        $('#statusMsg').removeClass('alert alert-danger').html('');
                                                    }, 6000);
                                                } else {
                                                    var reader = new FileReader();
                                                    reader.readAsDataURL(files[0]);
                                                    reader.onloadend = function (event) {
                                                        $("#imagePreview").attr("src", event.target.result);
                                                        $("#span_close").html('<span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>');
                                                    }
                                                }
                                            } else {
                                                $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                                                $(this).val('');
                                                $("#imagePreview").attr("src", '<?php echo!empty($model->product_featuredimage) ? Utils::ProductImagePath() . $model->product_featuredimage : Utils::NoImagePath() ?>');
                                                setTimeout(function () {
                                                    $('#statusMsg').removeClass('alert alert-danger').html('');
                                                }, 6000);
                                            }
                                        } else {
                                            $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                                            $(this).val('');
                                            $("#imagePreview").attr("src", '<?php echo!empty($model->product_featuredimage) ? Utils::ProductImagePath() . $model->product_featuredimage : Utils::NoImagePath(); ?>');
                                            setTimeout(function () {
                                                $('#statusMsg').removeClass('alert alert-danger').html('');
                                            }, 6000);
                                        }
                                        $("#imagePreview").mouseover(function () {
                                            $("#close").show();
                                        });
                                        $("#close").mouseover(function () {
                                            $("#close").show();
                                        });
                                        $("#span_close").mouseover(function () {
                                            $("#close").show();
                                        });
                                        $("#close").mouseout(function () {
                                            $("#close").hide();
                                        });
                                        $("#imagePreview").mouseout(function () {
                                            $("#close").hide();
                                        });

                                        $("#close").on("click", function () {
                                            var img_data = '<?php echo $model->product_featuredimage; ?>';
                                            if (img_data) {
                                                $.post(
                                                        '<?php echo Yii::app()->request->baseUrl; ?>/product/removeImage',
                                                        {'id': '<?php echo $model->product_id; ?>'},
                                                function (data) {
                                                    if (data == 1) {
                                                        $('#statusMsg').addClass('alert alert-success').html('Photo deleted successfully.');
                                                        setTimeout(function () {
                                                            $('#statusMsg').removeClass('alert alert-danger').html('');
                                                        }, 6000);
                                                        //window.location.reload();
                                                    } else {
                                                        $('#statusMsg').addClass('alert alert-danger').html('System Error.');
                                                        setTimeout(function () {
                                                            $('#statusMsg').removeClass('alert alert-danger').html('');
                                                        }, 6000);
                                                    }
                                                });
                                            } else {
                                                $("#imagePreview").attr("src", '<?php echo Utils::NoImagePath() ?>');
                                                $('#Product_product_featuredimage').val('');
                                                $("#span_close").html("");
                                            }
                                        });

                                        $("#span_close").on("click", function () {
                                            $("#imagePreview").attr("src", '<?php echo Utils::NoImagePath() ?>');
                                            $('#Product_product_featuredimage').val('');
                                            $("#span_close").html("");
                                        });
                                        /*********************************************************/
                                        /*   User Image Block End   */
                                        /*********************************************************/
                                    });
                                });
<?php if ($flag_1 == 0) { ?>
                                    Dropzone.options.myDropzone = {
                                        init: function () {
                                            thisDropzone = this;
                                            $.get('<?php echo Utils::GetBaseUrl(); ?>/product/getimages/<?php echo $model->product_id; ?>', function (data) {
                                                            $.each(data, function (key, value) {

                                                                var mockFile = {name: value.name, size: value.size, id: "all"};

                                                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "<?php echo Utils::ProductImageThumbnailPath(); ?>" + value.name);
                                                                var objectOn = $("div.dropzone .dz-details .dz-filename span:contains('" + value.name + "')");
                                                                //console.log(objectOn);
                                                                $(objectOn).append("<input type='hidden' data=" + value.name + " value=" + value.name + " name ='gallery[]' >");

                                                            });
                                                            $(".dz-success-mark").show();
                                                            $(".dz-success-mark").css("opacity", "1");
                                                        });

                                                    }
                                                };
<?php } ?>

</script>
<style type="text/css">
    .cke_contents{min-height: 600px !important;}
    #close{right: 0;position: absolute;top: -2px;display: block;cursor: pointer;color: #d82551;}
    .innerdiv{position: relative;margin: 0 auto;text-align: center;border: 1px solid #ccc;padding: 4px;}
</style>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/bootstrap-typeahead.min.js" charset="UTF-8"></script>


<script type="text/javascript">
                                            var sellers = [];
                                            $.ajax({
                                                url: '/index.php/sellers/getAllSellers',
                                                type: 'POST',
                                                async: false,
                                                dataType: 'JSON',
                                                success: function (res) {
                                                    $.each(res, function (key, value) {
                                                        sellers.push(value);
                                                    });
                                                }
                                            });

                                            $(function () {
                                                function displayResult(item) {
                                                    //alert(item.value);
                                                    $('#sellerid').val(item.value);
                                                }

                                                $('#Product_product_sellersID').typeahead({
                                                    source: sellers,
                                                    displayField: 'name',
                                                    valueField: 'id',
                                                    onSelect: displayResult
                                                });
                                            });
</script>