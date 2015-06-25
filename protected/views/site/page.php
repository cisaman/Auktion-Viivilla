<?php
$this->pageTitle = Yii::app()->name . ' | ' . $page->page_name;

$slug = '';
switch ($page->page_id) {
    case 2:
        $slug = Yii::t('lang', 'contactus');
        break;
    case 4:
        $slug = Yii::t('lang', 'aboutus');
        break;
    case 5:
        $slug = Yii::t('lang', 'terms_conditions');
        break;
    case 6:
        $slug = Yii::t('lang', 'auction_package');
        break;
}

$this->breadcrumbs = array(
    $slug,
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main" style="margin-bottom: 0px;">
    <div class="row">
        <div class="about-page">

            <?php echo $page->page_content; ?>

            <?php if ($page->page_id == 5) { ?>            
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top: 20px ! important;">

                    <?php if (!empty($faqs) && count($faqs) > 0) { ?>
                        <?php $count = 0; ?>
                        <?php foreach ($faqs as $faq) { ?>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $count; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $count; ?>">
                                            <i class="fa fa-question-circle"></i>  <?php echo $faq->faqs_ques; ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse_<?php echo $count; ?>" class="panel-collapse collapse <?php echo ($count == 0) ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="heading_<?php echo $count; ?>">
                                    <div class="panel-body">                            
                                        <?php echo $faq->faqs_ans; ?>
                                    </div>
                                </div>
                            </div>

                            <?php $count++; ?>
                        <?php } ?>
                    <?php } ?>

                </div>
            <?php } ?>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('html, body').animate({
            scrollTop: $('.about-page').offset().top - 50
        }, 1500);
    });
</script>