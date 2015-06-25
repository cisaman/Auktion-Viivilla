<?php if (Yii::app()->user->hasFlash('message')) { ?>
    <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="successmsg">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php } else { ?>
    <meta http-equiv="refresh" content="0;url=/" />    
<?php } ?>

<style type="text/css">
    .alert {
        font-size: 20px;
        margin-top: 20px;
        text-align: center;
    }
</style>

<script type="text/javascript">
    $("#successmsg").animate({opacity: 1.0}, 10000, function() {
        window.location.href = '/';
    });
</script>