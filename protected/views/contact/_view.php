<div class="view">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-green"><span style="font-weight: bold;">Subject:</span> <?php echo CHtml::encode($model->contact_subject); ?></h3>
            <hr/>   
        </div>
    </div>   
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">            
            <tbody> 
                <?php if (!empty($model->contact_productID)) { ?>
                    <tr>
                        <th><?php echo 'Product Code'; ?></th>
                        <td>
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('product/view/' . $model->contact_productID) ?>" target="_blank" title="View Product Detail" class="text-blue">
                                <?php echo CHtml::encode($model->contact_productID); ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('contact_name')); ?></th>
                    <td><?php echo CHtml::encode($model->contact_name); ?></td>                    
                </tr>                
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('contact_email')); ?></th>
                    <td><?php echo CHtml::encode($model->contact_email); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('contact_phone')); ?></th>
                    <td><?php echo CHtml::encode($model->contact_phone); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('contact_subject')); ?></th>
                    <td>
                        <div style="text-align:justify;-ms-word-break: break-all;word-break: break-all;">
                            <?php echo CHtml::encode($model->contact_subject); ?>
                        </div>
                    </td>                    
                </tr>                
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('contact_message')); ?></th>
                    <td>
                        <div style="text-align:justify;-ms-word-break: break-all;word-break: break-all;">
                            <?php echo CHtml::encode($model->contact_message); ?>
                        </div>
                    </td>
                </tr>                
            </tbody>
        </table>
    </div>
</div>

<style type="text/css">

    .modal-body > img {
        width: 100%;
    }

    th{
        width: 150px;
    }

    @media (min-width:320px) and (min-width:360px) {
        .view {
            padding: 0 !important;
        }
    }

    @media (min-width:361px){
        .view {
            padding: 0 30px !important;
        }
    }   
</style>