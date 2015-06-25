<div id="maincontent">
    <?php
    $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'search');

    $this->breadcrumbs = array(
        Yii::t('lang', 'search')
    );
    ?>

    <div class="col-lg-12 col-md-12 col-sm-12 product-page">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 product-main">
                <div class="main-product">
                    <div class="bottom-head">
                        <h2 class="changefont">Sökresultat</h2>
                    </div>

                    <div class="tab-part">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 changefont">   
                                <?php if ($pages->itemCount > 0) { ?>
                                    Vi hittade <?php echo $pages->itemCount; ?> produkter som matchade din sökning.
                                <?php } else { ?>
                                    Det fanns inget som matchade din sökning, vänligen prova igen.
                                <?php } ?>
                                <!--div class="btn-group pull-right">
                                    <a class="btn btn-default btn-sm" data-toggle="dropdown" href="#">
                                        <span class="glyphicon glyphicon-sort-by-order"></span> Order
                                        <span class="label label-success order_title"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li style="text-align:center;">Order Results By</li>
                                        <li class="divider"></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="ASC">Title (A-z)</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="DESC">Title (Z-a)</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="expiry_date" data-value="ASC">Expiry Date (Oldest First)</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="expiry_date" data-value="DESC">Expiry Date (Newest First)</a></li>                                    
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="current_price" data-value="ASC">Price (Hig - Low)</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="current_price" data-value="DESC">Price (Low - Hig)</a></li>
                                    </ul>
                                </div-->
                            </div>                       
                        </div>                    
                    </div>
                </div>

                <div class="main-product-search">
                    <div class="tab-part-1">                        
                        <div class="col-sm-12">                            

                            <?php if (count($all) > 0) { ?>    
                                <?php foreach ($all as $product) { ?>    

                                    <div class="col-sm-4 inner-blog">            
                                        <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>">
                                            <img src="<?php echo $product['p_image']; ?>" alt="<?php echo $product['p_name']; ?>" style="height: 172px;" />
                                            <span class="img-top">
                                                <h4>
                                                    <?php echo (Yii::app()->user->getState('lang') == 'en') ? Yii::t('lang', 'currency') : '' ?>
                                                    <?php echo $product['p_price']; ?>
                                                    <?php echo (Yii::app()->user->getState('lang') == 'sv') ? Yii::t('lang', 'currency') : '' ?>                        
                                                </h4>
                                            </span>
                                        </a>
                                        <p><?php echo $product['p_name']; ?></p>       
                                        <?php if ($product['p_expiry'] <= 0) { ?>                                           
                                            <div class="bid_expired" style="margin-bottom:10px;font-weight: normal;font-size: 16px;border-radius: 4px;">
                                                <?php echo Yii::t('lang', 'bid_time_over'); ?>
                                            </div>
                                        <?php } else { ?>
                                            <ul class="list-part pid_r_<?php echo $product['p_id']; ?>" key="pid_r_<?php echo $product['p_id']; ?>" data="<?php echo $product['p_new_expiry']; ?>">
                                                <li>
                                                    <span class="pid_d"></span>
                                                    <span><?php echo Yii::t('lang', 'days'); ?></span>
                                                </li>
                                                <li>
                                                    <span class="pid_h"></span>
                                                    <span><?php echo Yii::t('lang', 'hours'); ?></span>
                                                </li>
                                                <li>
                                                    <span class="pid_m"></span>
                                                    <span><?php echo Yii::t('lang', 'minutes'); ?></span>
                                                </li>
                                                <li>
                                                    <span class="pid_s"></span>
                                                    <span><?php echo Yii::t('lang', 'seconds'); ?></span>
                                                </li>
                                            </ul>
                                        <?php } ?>                                        
                                    </div>    

                                <?php } ?>
                            <?php } else { ?>
                                <h4 class="text-red text-center changefont" style="color: red">Inga produkter hittades.</h4>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
            <?php
            $this->widget('CLinkPager', array(
                'header' => '',
                'firstPageLabel' => '&lt;&lt; Första',
                'prevPageLabel' => '&lt; Föregående',
                'nextPageLabel' => 'Nästa &gt;',
                'lastPageLabel' => 'Sista &gt;&gt;',
                'pages' => $pages,
                'htmlOptions' => array('class' => 'pagination', 'id' => ''),
                'selectedPageCssClass' => 'active',
                'previousPageCssClass' => 'prev',
                'nextPageCssClass' => 'next',
                'hiddenPageCssClass' => 'disabled',
                'maxButtonCount' => 5,
            ));
            ?>
        </div>
    </div>

    <style type="text/css">
        .list-info{float: right;}
        .linkbar {border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;margin-bottom: 20px;padding: 15px;}
        .avatar {border: 1px solid #ddd;padding: 2px;}
        .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {display: block;height: auto;max-width: 100%;}    
        .main-product-search {border: 1px solid #ccc;margin-top: 15px;}
        .dropdown-menu li {border-top: 0px dotted #cccccc !important;}
        .tab-part-1{padding: 10px;overflow: hidden !important;}
        .inner-blog{margin: 0px !important;padding: 0px 15px !important;}
        .col-sm-4{width: 33.3333% !important;}
        .order_title{font-size: 100% !important;padding: 0.3em 0.6em !important;}
        .product-page{padding: 0px !important;}
        .product-page .product-main{padding-right: 12px !important;}
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            /* For Gallery Products using Pagination by AJAX */
            $(".pagination li a ").click(function(e) {
                link = $(this).attr("href");
                link = link + "&by=ajax";
                //console.log(link);
                e.preventDefault();
                $.ajax({
                    url: link,
                    type: "get", success: function(out_res) {
                        $("#maincontent").html(out_res);

                        $('html, body').animate({
                            scrollTop: $('.main-product').offset().top - 10
                        }, 1000);
                    }
                });
            });

            /* For Sorting of Products by AJAX */
            $('.order').click(function() {
                var order_title = $(this).html();
                var sort_by = $(this).attr('data-name');
                if (sort_by === '') {
                    return false;
                }
                var order_by = $(this).attr('data-value');
                var link = '<?php echo Utils::GetBaseUrl(); ?>?sort_by=' + sort_by + '&order_by=' + order_by + '&by=ajax';

                //console.log(link);

                $.ajax({
                    url: link,
                    type: "get",
                    success: function(out_res) {
                        $('#maincontent').html(out_res);

                        $('html, body').animate({
                            scrollTop: $('.main-product').offset().top - 10
                        }, 1000);

                        $('.order_title').text(order_title);
                    }
                });
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('.tab-part').offset().top - 50
            }, 1500);
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".time-list").each(function() {
                var id  = $(this).attr("key");
                createNewClock(id);
            });

            $(".list-part").each(function() {
                var id  = $(this).attr("key");
                createNewClock(id);
            });
        });
    </script> 

</div>