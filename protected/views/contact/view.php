<?php $this->pageTitle = Yii::app()->name . ' | View Message' . '(#' . $model->contact_id . ')'; ?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-shopping-cart"></i> View Message | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('contact/index'); ?>">Back to Listing</a></small></h1></li>
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
                    <li class="active"><a href="#message" data-toggle="tab">View Message</a></li>
                    <li><a href="#reply" data-toggle="tab">Reply</a></li>
                    <li><a href="#replyMessageList" id="replyMessageListTab" data-toggle="tab">Reply Message List</a></li>
                </ul>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="message">
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_view', array('model' => $model)); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reply">
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_reply', array('model' => $model)); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="replyMessageList">
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_reply_message_list', array('model' => $model)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>    
</div>