<?php $this->pageTitle = Yii::app()->name . ' | View Product' . '(#' . $model->product_id . ')'; ?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-shopping-cart"></i> View Product | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('product/index'); ?>">Back to Listing</a></small></h1></li>
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
                    <li class="active"><a href="#booking-view" data-toggle="tab">View Product(#<?php echo $model->product_id; ?>)</a></li>
                </ul>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="booking-view">                            
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