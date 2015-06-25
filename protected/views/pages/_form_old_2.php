<?php
$create_url = Yii::app()->createAbsoluteUrl('pages/create');
$update_url = Yii::app()->createAbsoluteUrl('pages/update/' . $model->page_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'pages-form',
    'action' => ($model->isNewRecord) ? $create_url : $update_url,
    'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'page_name'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'page_name'); ?>
                    <?php echo $form->textField($model, 'page_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('page_name'))); ?>
                    <?php echo $form->error($model, 'page_name', array('class' => 'text-red')); ?>
                </div>

                <!--                <div class="tinymce">
                <?php echo $form->labelEx($model, 'page_content'); ?>
                <?php echo $form->textArea($model, 'page_content'); ?>           
                <?php echo $form->error($model, 'page_content'); ?>
                                </div>  -->

                <div class="form-group tinymce">
                    <?php echo $form->labelEx($model, 'page_content'); ?>
                    <?php
                    $this->widget('application.extensions.tinymce.ETinyMce', array(
                        'model' => $model,
                        'attribute' => 'page_content',
                        'editorTemplate' => 'full',
                        'plugins' => array('openmanager' => array('file_browser_callback' => "openmanager", 'open_manager_upload_path' => 'uploads/',)),
                        'htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'tinymce')
                    ));
                    ?>
                    <?php echo $form->error($model, 'page_content'); ?>
                </div>

                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'page_status'); ?>
                        <?php echo $form->checkBox($model, 'page_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'page_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'page'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'page'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        tinyMCE.init({
            selector: "textarea#Pages_page_content",
            // General options            
            mode: "textareas",
            theme: "advanced",
            plugins: "autolink,lists,pagebreak,openmanager,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
            // Theme options
            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks,|,openmanager",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,
            //FILE UPLOAD MODS
            file_browser_callback: "openmanager",
            open_manager_upload_path: 'uploads/',
            // Example content CSS (should be your site CSS)
            content_css: "css/content.css",
            // Drop lists for link/image/media/template dialogs
            template_external_list_url: "lists/template_list.js",
            external_link_list_url: "lists/link_list.js",
            external_image_list_url: "lists/image_list.js",
            media_external_list_url: "lists/media_list.js",
            // Style formats
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
            // Replace values for the template plugin
            template_replace_values: {
                username: "Some User",
                staffid: "991234"
            }
        });
    });
</script>-->


<!--<script type="text/javascript" src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/tinymce/tinymce.min.js"></script>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/editor/tiny_mce/tiny_mce_src.js"></script>
<script type="text/javascript">

//    tinymce.init({
//        selector: "textarea#Pages_page_content",
//        theme: "modern",
//        //width: 900,
//        height: 300,
//        plugins: [
//            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
//            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
//            "save table contextmenu directionality emoticons template paste textcolor"
//        ],
//        content_css: "css/content.css",
//        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
//        style_formats: [
//            {title: 'Bold text', inline: 'b'},
//            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
//            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
//            {title: 'Example 1', inline: 'span', classes: 'example1'},
//            {title: 'Example 2', inline: 'span', classes: 'example2'},
//            {title: 'Table styles'},
//            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
//        ]
//    });    

//    tinyMCE.init({
//        // General options
//        mode: "exact",
//        elements: "Pages_page_content",
//        theme: "advanced",
//        height: 400,
//        plugins: "jbimages,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template,wordcount,advlist,autosave",
//        language: "en",
//        // Theme options
//        theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//        theme_advanced_buttons2: "copy,paste,pastetext,pasteword,|,insertlayer,styleprops,emotions,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,|,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,jbimages,fullscreen",
//        //theme_advanced_buttons3: "insertdate,inserttime,preview,|,forecolor,backcolor,|,jbimages,fullscreen",
//        theme_advanced_toolbar_location: "top",
//        theme_advanced_toolbar_align: "left",
//        theme_advanced_statusbar_location: "bottom",
//        theme_advanced_resizing: true,
//        // This is required for the image paths to display properly
//        relative_urls: false,
//        // Drop lists for link/image/media/template dialogs
//        template_external_list_url: "lists/template_list.js",
//        external_link_list_url: "lists/link_list.js",
//        external_image_list_url: "lists/image_list.js",
//        media_external_list_url: "lists/media_list.js",
//        // Style formats (OPTIONAL)
//        style_formats: [
//            {title: 'Bold text', inline: 'b'},
//            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
//            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
//            {title: 'Example 1', inline: 'span', classes: 'example1'},
//            {title: 'Example 2', inline: 'span', classes: 'example2'},
//            {title: 'Table styles'},
//            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
//        ]       
//    });
</script>

<style type="text/css">
    /*    .mce-fullscreen {
            z-index: 99999999999999999999;
        }
        .mceEditor, .mceLayout{
            width: 100% !important;
            //height: 300px !important;
            margin-bottom: 15px !important;
        }*/
</style>-->