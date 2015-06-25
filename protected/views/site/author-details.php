<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'author') . '-' . $author['u_name'];

$this->breadcrumbs = array(
    Yii::t('lang', 'author'),
    $author['u_name']
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 product-main">
            <div class="main-product">
                <div class="bottom-head">
                    <h2>Author</h2>
                </div>

                <div class="tab-part">
                    <div class="row">
                        <div class="col-md-4">
                            <img alt="" class="avatar img-responsive" src="<?php echo $author['u_image']; ?>">
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-8">
                            <h2 style="margin-top: 0px;">
                                <span><?php echo $author['u_name']; ?></span>
                            </h2>
                            <div class="linkbar">
                                <span><i class="fa fa-globe"></i> Visit Website</span>
                                <span><i class="fa fa-facebook-square"></i> Facebook</span>
                                <span><i class="fa fa-twitter-square"></i> Twitter</span>
                                <span><i class="fa fa-google-plus-square"></i> Google+</span>
                            </div>
                            <?php if (!empty($author['u_summary'])) { ?>
                                <p><?php echo $author['u_summary']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center">
                        <?php
                        $temp = 0;
                        if (isset($author['u_totalproducts']))
                            $temp = $author['u_totalproducts'];
                        ?>
                        This user has published <?php echo $temp; ?> listings.
                        <?php if ($temp) { ?>
                            <h3 style="text-align: center;">
                                <a style="text-decoration:underline;color: #000;" href="<?php echo Yii::app()->createAbsoluteUrl('search/' . $author['u_id'] . '/' . $author['u_slug']); ?>">
                                    View All Listings
                                </a>
                            </h3>     
                        <?php } ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .list-info{
        float: right;
    }
    .linkbar {
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
        margin-bottom: 20px;
        padding: 15px;
    }
    .avatar {
        border: 1px solid #ddd;
        padding: 2px;
    }
    .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
        display: block;
        height: auto;
        max-width: 100%;
    }    
    .product-page{
        padding: 0px !important;
        margin: 0px !important;
    }
    .product-page .product-main{
        padding-right: 12px !important;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.tab-part').offset().top - 50
        }, 1500);
    });
</script>