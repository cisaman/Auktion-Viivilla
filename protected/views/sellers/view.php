<?php $this->pageTitle = Yii::app()->name . ' | View Seller' . '(#' . $model->sellers_id . ')'; ?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-shopping-cart"></i> View Seller | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('sellers/index'); ?>">Back to Listing</a></small></h1></li>
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
                    <li class="active"><a href="#seller-view" data-toggle="tab">View Seller(#<?php echo $model->sellers_id; ?>)</a></li>
                </ul>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="seller-view">
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_view', array('model' => $model)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>    
</div>