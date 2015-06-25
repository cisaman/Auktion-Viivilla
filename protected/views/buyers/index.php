<div id="maincontent">

    <?php
    $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'users');

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });   

    $('.search-form form').submit(function(){
        $('#buyers-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");

    $setNewPasswordJs = 'js:function(__event) {
    __event.preventDefault(); // disable default action

    var
         $this                     = $(this), // link/button         
         confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
         url                         = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link
   
    if(confirm(confirm_message)) {        
        $("#buyers-grid").yiiGridView("update", {
            type    : "POST", // importatnt! we only allow POST in filters()            
            url       : url,            
            success : function(response) {   
                response = JSON.parse(response);               

                $("#statusMsg").addClass("alert alert-" + response.type);
                $("#statusMsg").html(response.msg);
                $("#statusMsg").show();

                $("#buyers-grid").yiiGridView("update"); // refresh gridview via AJAX

                setInterval(function(){ $("#statusMsg").fadeOut("slow"); }, 3000);
            },
            error   : function(xhr) {
                console.log("Error:", xhr);
            }
        });
    }
}';
    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <ol class="breadcrumb">
                    <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'buyers'); ?></h1></li>
                </ol>
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet portlet-default">
                <div class="portlet-body">

                    <div id="statusMsg"></div>

                    <?php if (Yii::app()->user->hasFlash('message')): ?>
                        <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                            <?php echo Yii::app()->user->getFlash('message'); ?>
                        </div>
                    <?php endif; ?>

                    <ul id="userTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyers-user-list" data-toggle="tab">
                                <?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'buyers'); ?> 
                            </a>
                        </li>                    
                    </ul>
                    <div id="userTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="buyers-user-list">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-2 col-sm-offset-9">
                                                <label style="width: 100%; margin: 0px; text-align: right; font-weight: bold ! important; line-height: 34px;">
                                                    Records per Page
                                                </label>
                                            </div>
                                            <div class="col-sm-1" style="padding-left: 0;">
                                                <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10; ?>
                                                <?php echo CHtml::dropDownList('limitdata', $limit, array('10' => '10', '25' => '25', '50' => '50', '75' => '75', '100' => '100'), array('class' => 'form-control')); ?>
                                            </div>                                    
                                        </div>
                                        <hr/>
                                        <?php
                                        $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'buyers-grid',
                                            'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                            'dataProvider' => $model->search(),
                                            'filter' => $model,
                                            'columns' => array(
                                                array(
                                                    'header' => Yii::t('lang', 'sno'),
                                                    'name' => 'S. No.',
                                                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                                    'htmlOptions' => array('style' => 'text-align:center'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:60px'),
                                                ),
                                                array(
                                                    'header' => Yii::t('lang', 'photo'),
                                                    'name' => 'buyers_image',
                                                    'type' => 'html',
                                                    'value' => '!empty($data->buyers_image) ? CHtml::image(Utils::UserImagePath() . $data->buyers_image, $data->buyers_image, array("width" => "60px", "height" => "70px")) : CHtml::image(($data->buyers_gender == "") ? Utils::UserImagePath_M() : (($data->buyers_gender == "M") ? Utils::UserImagePath_M() : Utils::UserImagePath_F()), "N/A", array("width" => "60px", "height" => "70px"))',
                                                    'htmlOptions' => array('style' => 'text-align:center'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'filter' => ''
                                                ),
                                                array(
                                                    'name' => 'buyers_nickname',
                                                    'value' => '$data->buyers_nickname',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'buyers_nickname', array('placeholder' => $model->getAttributeLabel('buyers_nickname'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'buyers_fname',
                                                    'value' => '$data->buyers_fname',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'buyers_fname', array('placeholder' => $model->getAttributeLabel('buyers_fname'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'buyers_lname',
                                                    'value' => '$data->buyers_lname',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'buyers_lname', array('placeholder' => $model->getAttributeLabel('buyers_lname'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'buyers_gender',
                                                    'value' => '($data->buyers_gender == "") ? "-" : (($data->buyers_gender == "M") ? Yii::t("lang", "male") : Yii::t("lang", "female"))',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'filter' => CHtml::activeDropDownList($model, 'buyers_gender', $model->getGenderOptions(), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'gender')))
                                                ),
                                                array(
                                                    'name' => 'buyers_email',
                                                    'value' => '$data->buyers_email',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'buyers_email', array('placeholder' => $model->getAttributeLabel('buyers_lname'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'buyers_password',
                                                    'value' => 'Buyers::model()->getPasswordDecrypted($data->buyers_password)',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:120px'),
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'visible' => Yii::app()->user->name == 'Administrator',
                                                    'filter' => ''
                                                ),
                                                array(
                                                    'name' => 'buyers_status',
                                                    'type' => 'raw',
                                                    'value' => '($data->buyers_status == 0) ? "<a class=\"btn btn-xs btn-red\">" . Yii::t("lang", "inactive") . "</a>" : "<a class=\"btn btn-xs btn-green\">" . Yii::t("lang", "active")  . "</a>"',
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'filter' => CHtml::activeDropDownList($model, 'buyers_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                                ),
//                                            array(
//                                                'name' => 'user_created',
//                                                'value' => 'Yii::app()->dateFormatter->format("dd-MM-yyyy", strtotime($data->user_created))',
//                                                'htmlOptions' => array('style' => 'text-align:center;'),
//                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'), 'filter' => ''
//                                            ),
//                                            array(
//                                                'name' => 'user_updated',
//                                                'value' => 'Yii::app()->dateFormatter->format("dd-MM-yyyy", strtotime($data->user_updated))',
//                                                'htmlOptions' => array('style' => 'text-align:center;'),
//                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
//                                                'filter' => ''
//                                            ),
                                                array(
                                                    'header' => 'Action',
                                                    'class' => 'CButtonColumn',
                                                    'deleteConfirmation' => 'Are you sure you want to delete this record?',
                                                    'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'visible' => Yii::app()->user->name == 'Administrator',
                                                    'template' => '{view} {password} {update} {delete}',
                                                    'buttons' => array
                                                        (
                                                        'password' => array
                                                            (
                                                            'label' => '<i class="fa fa-key"></i>',
                                                            'imageUrl' => FALSE,
                                                            'url' => 'Yii::app()->createUrl("buyers/setNewPassword", array("id"=>$data->buyers_id))',
                                                            'options' => array(
                                                                'title' => 'Set New Password for Buyer',
                                                                'data-confirm' => 'Do you really want to Set New Password for this Buyer?',
                                                            ),
                                                            'click' => $setNewPasswordJs,
                                                        ),
                                                        'view' => array
                                                            (
                                                            'label' => '<i class="fa fa-search"></i>',
                                                            'options' => array('title' => 'View Buyer'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                        'update' => array
                                                            (
                                                            'label' => '<i class="fa fa-edit"></i>',
                                                            'options' => array('title' => 'Update Buyer'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                        'delete' => array
                                                            (
                                                            'label' => '<i class="fa fa-times"></i>',
                                                            //'url' => '$data->buyers_id',
                                                            'options' => array('title' => 'Remove Buyer', 'class' => 'remove'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover table-green dataTable',
                                            'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                                            'summaryCssClass' => 'dataTables_info',
                                            'template' => '{items}<div class = "row"><div class = "col-xs-4">{summary}</div><div class = "col-xs-8">{pager}</div></div>',
                                            'pager' => array(
                                                'htmlOptions' => array('class' => 'pagination', 'id' => ''),
                                                'header' => '',
                                                'firstPageLabel' => '<<',
                                                'prevPageLabel' => '<',
                                                'nextPageLabel' => '>',
                                                'lastPageLabel' => '>>',
                                                'cssFile' => false,
                                                'selectedPageCssClass' => 'active',
                                                'previousPageCssClass' => 'prev',
                                                'nextPageCssClass' => 'next',
                                                'hiddenPageCssClass' => 'disabled',
                                                'maxButtonCount' => 5,
                                            ),
                                            'emptyText' => '<span class="text-danger text-center">No Record Found!</span>',
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>    
    </div>

</div>

<script type="text/javascript" async>
    $(document).ready(function () {
        $("#limitdata").change(function () {
            var link = 'index?ajax=Buyers';
            var limit = $(this).val();

            $.ajax({
                url: link,
                type: "GET",
                data: {limit: limit},
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);

                }
            });
        });
    });
</script>