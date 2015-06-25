<div class="center-srch form-group">

    <form action="/searchterm" method="get">
        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
        <input class="form-control search-input ui-autocomplete-input changefont" placeholder="Nyckelord + Enter" name="keyword" value="<?php echo @$_GET['keyword'] ?>" type="text" autocomplete="off"/>
        <input id="search_btn" type="submit" value="" >
    </form>        

</div> 

<div class="col-lg-12 col-md-12 col-sm-12 slider-part">
    <div class="row">
        <div class="slider-head">
            <h3 style="text-transform: none;" class="changefont">
                <?php echo ucfirst(Yii::t('lang', 'recent_auctions')); ?>
            </h3>
        </div>
        <div class="slide-show">
            <div id="owl-demo" class="owl-carousel owl-theme">
                <?php foreach ($recent as $product) { ?>
                    <div class="item">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>">
                            <img src="<?php echo $product['p_image']; ?>" alt="<?php echo $product['p_name']; ?>"/>
                            <span class="img-top">
                                <h4>
                                    <?php echo (Yii::app()->user->getState('lang') == 'en') ? Yii::t('lang', 'currency') : '' ?>
                                    <span class="price_<?php echo $product['p_id']; ?>"><?php echo $product['p_price']; ?></span>
                                    <?php echo (Yii::app()->user->getState('lang') == 'sv') ? Yii::t('lang', 'currency') : '' ?>
                                </h4>
                            </span>
                        </a>
                        <p><a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>"><?php echo $product['p_name']; ?></a></p>
                        <ul class="list-part pid_r_<?php echo $product['p_id']; ?>" key="pid_r_<?php echo $product['p_id']; ?>" data="<?php echo $product['p_new_expiry']; ?>">
                            <li><span class="pid_d"></span><span><?php echo Yii::t('lang', 'days'); ?></span></li>
                            <li><span class="pid_h"></span><span><?php echo Yii::t('lang', 'hours'); ?></span></li>
                            <li><span class="pid_m"></span><span><?php echo Yii::t('lang', 'minutes'); ?></span></li>
                            <li><span class="pid_s"></span><span><?php echo Yii::t('lang', 'seconds'); ?></span></li>
                        </ul>                                        
                    </div>
                <?php } ?>                           
            </div>

            <div class="customNavigation">
                <a class="btn prev"><img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/prev.png"></a>
                <a class="btn next"><img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/next.png"></a>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 slider-part-1">
    <div class="row">
        <div class="nxt-slider-head" id="list_all" style="padding: 0px ! important;">
            <h3 style="font-size: 18px; color: rgb(100, 102, 102); padding: 15px 10px; margin: 0px ! important;" class="changefont">
                <?php echo Yii::t('lang', 'gallery_products'); ?>
                <div class="btn-group pull-right" style="top: -5px;">
                    <!-- <a class="btn btn-default btn-sm" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-sort-by-order"></span> Sortera
                        <span class="label label-success order_title"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li style="text-align:center;">Sortera efter</li>
                        <li class="divider"></li>
                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="ASC">Bokstavsordning (A-Ö)</a></li>
                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="DESC">Bokstavsordning (Ö-A)</a></li>
                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="expiry_date" data-value="ASC">Äldsta</a></li>
                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="expiry_date" data-value="DESC">Senaste</a></li>                                    
                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="temp_current_price" data-value="ASC">Pris, fallande</a></li>
                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="temp_current_price" data-value="DESC">Pris, stigande</a></li>
                    </ul> -->
                </div>
            </h3>
        </div>          
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 inner-part">
    <?php
    $count = 0;
    foreach ($all as $product) {
        if ($count == 0) {
            echo '<div class="row">';
        }
        ?>    
        <div class="col-lg-4 col-md-4 col-sm-4 inner-blog">            
            <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>">
                <img src="<?php echo $product['p_image']; ?>" alt="<?php echo $product['p_name']; ?>" />
                <span class="img-top">
                    <h4>
                        <?php echo (Yii::app()->user->getState('lang') == 'en') ? Yii::t('lang', 'currency') : '' ?>
                        <span class="price_<?php echo $product['p_id']; ?>"><?php echo $product['p_price']; ?></span>
                        <?php echo (Yii::app()->user->getState('lang') == 'sv') ? Yii::t('lang', 'currency') : '' ?>                        
                    </h4>
                </span>
            </a>
            <p>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>"><?php echo $product['p_name']; ?></a>
            </p>
            <ul class="list-part pid_r_<?php echo $product['p_id']; ?>" key="pid_r_<?php echo $product['p_id']; ?>" data="<?php echo $product['p_new_expiry']; ?>">
                <li><span class="pid_d"></span><span><?php echo Yii::t('lang', 'days'); ?></span></li>
                <li><span class="pid_h"></span><span><?php echo Yii::t('lang', 'hours'); ?></span></li>
                <li><span class="pid_m"></span><span><?php echo Yii::t('lang', 'minutes'); ?></span></li>
                <li><span class="pid_s"></span><span><?php echo Yii::t('lang', 'seconds'); ?></span></li>
            </ul>            
        </div>

        <?php
        if ($count == 2) {
            echo '</div>';
            $count = 0;
        } else {
            $count++;
        }
        ?>
    <?php } ?> 
    <?php echo ($count == 2) ? '</div>' : ''; ?>           
</div>

<?php if (!empty($pages) && isset($pages)) { ?>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="text-right">
                <?php
                $this->widget('CLinkPager', array(
                    'header' => '',
                    'firstPageLabel' => '&lt;&lt; Första',
                    'prevPageLabel' => '&lt; Föregående',
                    'nextPageLabel' => 'Nästa &gt;',
                    'lastPageLabel' => 'Sista &gt;&gt;',
                    'pages' => $pages,
                    'htmlOptions' => array('class' => 'pagination changefont', 'id' => ''),
                    'selectedPageCssClass' => 'active',
                    'previousPageCssClass' => 'prev',
                    'nextPageCssClass' => 'next',
                    'hiddenPageCssClass' => 'disabled',
                    'maxButtonCount' => 5,
                ));
                ?>
            </div>
        </div>
    </div>
<?php } ?> 

<?php if ($_SERVER['HTTP_HOST'] != 'localhost') { ?>
    <div class="col-lg-12 col-md-12 col-sm-12  bottom-image">    
        <div class="row">
            <!--JavaScript Tag with group ID // Tag for network 1525: Vi i Villa Sverige  // Website: viivilla.se // Page: SE-Main // Placement: SE-Main-Middle (5063962) // created at: Apr 3, 2014 10:49:57 AM-->
            <script language="javascript">
                <!--
            if (window.adgroupid == undefined) {
                    window.adgroupid = Math.round(Math.random() * 1000);
                }
                document.write('<scr' + 'ipt language="javascript1.1" src="http://adserver.adtech.de/addyn/3.0/1525/5063962/0/744/ADTECH;loc=100;target=_blank;key=auktion;grp=' + window.adgroupid + ';misc=' + new Date().getTime() + '"></scri' + 'pt>');
                //-->
            </script><noscript><a href="http://adserver.adtech.de/adlink/3.0/1525/5063962/0/744/ADTECH;loc=300;key=auktion" target="_blank"><img src="http://adserver.adtech.de/adserv/3.0/1525/5063962/0/744/ADTECH;loc=300;key=auktion" border="0" width="980" height="120"></a></noscript>
            <!-- End of JavaScript Tag -->
        </div>
    </div> 
<?php } ?>

<script type="text/javascript" async>
                $(document).ready(function () {
                    $(".time-list").each(function () {
                        var id = $(this).attr("key");
                        createNewClock(id);
                    });

                    $(".list-part").each(function () {
                        var id = $(this).attr("key");
                        createNewClock(id);
                    });
                });
</script>   

<!-- For Slider on HomePage -->
<script type="text/javascript">
    $(document).ready(function () {
        var owl = $("#owl-demo, #owl-demo1");
        owl.owlCarousel({
            autoPlay: 2000, //Set AutoPlay to 3 seconds
            pagination: false,
            stopOnHover: true,
            lazyLoad: true,
            items: 3, //10 items above 1000px browser width
            itemsDesktop: [1000, 3], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
            itemsTablet: [600, 2], //2 items between 600 and 0;
            itemsMobile: [599, 1], // itemsMobile disabled - inherit from itemsTablet option           
        });

        // Custom Navigation Events
        $(".next").click(function () {
            owl.trigger('owl.next');
        });
        $(".prev").click(function () {
            owl.trigger('owl.prev');
        });
    });
</script>

<!-- For Sorting of Products by AJAX -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.order').click(function () {
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
                success: function (out_res) {
                    $('#maincontent').html(out_res);
                    $('html, body').animate({
                        scrollTop: $('#list_all').offset().top - 10
                    }, 1000);
                    $('.order_title').text(order_title);
                }
            });
        });
    });
</script>

<!-- For Gallery Products using Pagination by AJAX -->
<script type="text/javascript" async>
    $(document).ready(function () {
        // $(".pagination li a ").click(function(e) {
        //     link = $(this).attr("href");
        //     //link = link + "&by=ajax";
        //     var matches = '';
        //     if (link != null && link != '') {
        //         matches = link.match(/\d+/g);
        //     }

        //     if (matches != null) {
        //         link = link + "&by=ajax";
        //     } else {
        //         link = "/index?index=&by=ajax&page=1";
        //     }
        //     e.preventDefault();
        //     $.ajax({
        //         url: link,
        //         type: "get",
        //         success: function(out_res) {
        //             $("#maincontent").html(out_res);
        //             $('html, body').animate({
        //                 scrollTop: $("#list_all").offset().top - 10
        //             }, 1000);
        //         }
        //     });
        // });
    });
</script>