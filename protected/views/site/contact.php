<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'contactus');

$this->breadcrumbs = array(
    Yii::t('lang', 'contactus'),
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 contact-part" style="margin-bottom: 30px">
    <?php echo $page->page_content; ?>

    <?php $this->renderPartial('_contact', array('model' => $model)); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('.contact-top').offset().top - 20
            }, 1500);
        });
    </script>