<?php $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'view') . ' ' . Yii::t('lang', 'templates') . '(#' . $model->template_id . ')'; ?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-shopping-cart"></i> <?php echo Yii::t('lang', 'view') . ' ' . Yii::t('lang', 'templates') ?> | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('template/index'); ?>"><?php echo Yii::t('lang', 'back_to_listing') ?></a></small></h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-body">
                <ul id="bookingTab" class="nav nav-tabs">
                    <li class="active"><a href="#template-view" data-toggle="tab"><?php echo Yii::t('lang', 'view') . ' ' . Yii::t('lang', 'templates') ?>(#<?php echo $model->template_id; ?>)</a></li>
                </ul>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="template-view">                            
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">

                                <div class="col-md-12">                                
                                    <h3 class="text-green"><?php echo CHtml::encode($model->template_title); ?></h3>
                                    <hr/>   
                                </div>

                                <div class="col-md-12">                                
                                    <table class="table table-bordered table-striped">            
                                        <tbody>
                                            <tr>
                                                <th width="150px">Subject</th>
                                                <td><?php echo $model->template_subject; ?></td>
                                            </tr>                
                                            <tr>
                                                <th>Parameters</th>
                                                <td><?php echo $model->template_parameters; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Template Alias</th>
                                                <td><?php echo $model->template_alias; ?></td>
                                            </tr>
                                            <tr>                                                
                                                <td colspan="2">
                                                    <div class="mailboxlayout">
                                                        <?php echo $model->template_content; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .mailboxlayout{
        border: 1px solid #ccc;
        padding: 10px;
        margin:  10px 0;        
    }
</style>

<script type="text/javascript">
    $(function() {
        $('.mailboxlayout a').click(function(event) {
            event.preventDefault();
        });
    });
</script>

