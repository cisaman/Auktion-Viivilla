<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public function init() {

        //Yii::app()->db->setactive(FALSE);        

        error_reporting(E_ERROR | E_PARSE);
        ini_set('display_errors', 1);

        if (!in_array(Yii::app()->controller->id, array('dashboard', 'site', 'payment'))) {
            if (!isset(Yii::app()->session['admin_data'])) {
                $this->redirect(array('dashboard/sellers'));
            }
        }
    }

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/site_column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $data = array();

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {

            $this->layout = '//layouts/error';

            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    function replace($array, $str) {
        foreach ($array as $key => $value) {
            $str = str_replace("$" . $key, $value, $str);
        }
        return $str;
    }

    public function Send($to, $to_name, $subject, $message, $addbcc = NULL) {
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->IsSMTP();
        $mail->Host = 'premium7.oderland.com:465';
        //$mail->Host = 'smtp.googlemail.com:465';
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = TRUE;
        //$mail->Username = 'aman@auktioner.io';
        $mail->Username = 'kundtjanst@smediagroup.se';
        //$mail->Password = 'bidallyoucanbid!';
        $mail->Password = '0g53E@30@_S1';
        //$mail->Username = 'aman.r@cisinlabs.com';
        //$mail->Password = 'gKBn1Rngt4';
        $mail->SetFrom('kundtjanst@smediagroup.se', 'viivilla Auktion');
        $mail->Subject = $subject;
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->MsgHTML($message);
        $mail->AddAddress($to, $to_name);

        if (!empty($addbcc)) {
            $mail->AddBCC($addbcc);
        }

        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
    }

    public static function CreateThumbForImages($width, $height, $source, $destination) {
        Yii::app()->ThumbsGen->thumbWidth = $width;
        Yii::app()->ThumbsGen->thumbHeight = $height;
        Yii::app()->ThumbsGen->createthumb($source, $destination);
    }

}
