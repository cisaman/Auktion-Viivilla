<div class="view">   

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-green"><?php echo CHtml::encode($model->sellers_fname . ' ' . $model->sellers_lname); ?></h3>
            <hr/>   
        </div>
    </div>

    <h4 class="text-dark-blue">Basic Information:</h4>
    <hr/>
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">            
            <tbody> 
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_username')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_username); ?></td>
                    <td rowspan="14" align="center" style="vertical-align:top">
                        <?php
                        $thumb_path = Utils::UserThumbnailImagePath() . $model->sellers_image;
                        $path = Utils::UserImagePath() . $model->sellers_image;
                        $no_image = Utils::NoImagePath();
                        ?>

                        <?php if (!empty($model->user_image)) { ?>
                            <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $path; ?>">
                                <img src="<?php echo $thumb_path; ?>" alt="<?php echo $thumb_path; ?>" title="Click to enlarge" class="gallery_img" />
                            </a>
                        <?php } else { ?>
                            <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $no_image; ?>">
                                <img src="<?php echo $no_image; ?>" alt="<?php echo $no_image; ?>" title="Click to enlarge" class="gallery_img" />
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_vatno')); ?></th>
                    <td><?php echo CHtml::encode(empty($model->sellers_vatno) ? '-' : $model->sellers_vatno); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_fname')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_fname); ?></td>                    
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_lname')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_lname); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_email')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_email); ?></td>                    
                </tr>                
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_address')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_address); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_city')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_city); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_country')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_country); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_zipcode')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_zipcode); ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_contactno')); ?></th>
                    <td><?php echo CHtml::encode($model->sellers_contactno == 0 ? '-' : $model->sellers_contactno); ?></td>
                </tr> 
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_website')); ?></th>
                    <td><?php echo CHtml::encode(empty($model->sellers_website) ? '-' : $model->sellers_website); ?></td>
                </tr> 
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('sellers_status')); ?></th>
                    <td><?php echo ($model->sellers_status == 1) ? 'Activated' : 'De-Actived'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-body">
                <img id="show_img"/>                
            </div>            
        </div>        
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('.view_img').click(function () {
            var path = $(this).attr('data-img');
            $('#show_img').attr('src', '');
            $('#show_img').attr('src', path);
            $('#msgModal').modal('show');
        });
        ;

    });
</script>


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

    .gallery_img{       
        padding: 5px; 
        border: 1px solid rgb(204, 204, 204); 
        margin: 10px 0px;
        height: 200px; 
        width: 180px; 
        padding: 5px; 
        border: 1px solid rgb(204, 204, 204); 
        /*        margin: 5px 20px;*/
        border-radius: 5px;
    }
</style>