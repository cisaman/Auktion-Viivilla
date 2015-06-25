<?php $this->pageTitle = Yii::app()->name . ' | View Log' . '(#' . $model->log_id . ')'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-log"></i> View Log | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('log/index'); ?>">Back to Log History</a></small></h1></li>
            </ol>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="view">   

                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-green"><?php echo CHtml::encode($model->log_name); ?></h3>
                                    <hr/>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="portlet portlet-default">
                                        <div class="portlet-heading">
                                            <div class="portlet-title">
                                                <h4>Log's Information</h4>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="portlet-body">
                                            <table class="table table-bordered table-responsive">            
                                                <tbody>
                                                    <tr>
                                                        <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('log_name')); ?></th>
                                                        <td><?php echo CHtml::encode($model->log_name); ?></td>                    
                                                    </tr>
                                                    <tr>
                                                        <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('log_userid')); ?></th>
                                                        <td><?php echo CHtml::encode($model->log_userid); ?></td>
                                                    </tr>
                                                    <?php if ($model->log_usertype == 3) { ?>
                                                        <tr>
                                                            <th class="head">Buyer's Nickname</th>
                                                            <td><?php echo CHtml::encode(Buyers::getBuyerNickName($model->log_userid)); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="head">Buyer's Name</th>
                                                            <td><?php echo CHtml::encode(Buyers::getBuyerName($model->log_userid)); ?></td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <th class="head">Seller's Nickname</th>
                                                            <td><?php echo CHtml::encode(Sellers::model()->getSellersUsername($model->log_userid)); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="head">Sellers's Name</th>
                                                            <td><?php echo CHtml::encode(Sellers::model()->getSellersFullName($model->log_userid)); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('log_productid')); ?></th>
                                                        <td><?php echo CHtml::encode($model->log_productid); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="head">Product's Name</th>
                                                        <td><?php echo CHtml::encode(Product::getProductNameById($model->log_productid)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('log_created')); ?></th>
                                                        <td><?php echo CHtml::encode($model->log_created); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('log_desc')); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="mybox">
                                                                <?php echo $model->log_desc; ?>
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
    </div>    
</div>

<style type="text/css">
    @media (min-width:320px) and (min-width:360px) {.view {padding: 0 !important;}}
    @media (min-width:361px){.view {padding: 0 30px !important;}}
    .tt th, .tt td{text-align: center;}
    .dashedBorder {border: 1px dashed #ccc;}
    .head{width: 200px;}
    .mybox {border: 3px solid black;border-radius: 5px;padding: 10px;}
</style>