<?php $this->pageTitle = Yii::app()->name; ?>

<div id="maincontent">
    <?php 
    echo $this->renderPartial('index_ajax', array(
                'recent' => $recent,
                'all' => $all,
                'pages' => $pages,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
    ?>
</div>