<?php

class ApplicationConfigBehavior extends CBehavior {

    /**
     * Declares events and the event handler methods
     * See yii documentation on behaviour
     */
    public function events() {
        return array_merge(parent::events(), array(
            'onBeginRequest' => 'beginRequest',
        ));
    }

    /**
     * Load configuration that cannot be put in config/main
     */
    public function beginRequest() {
        try{
            $code = Yii::app()->user->getState('lang');
            if (!empty($code)) {
                $lang = $code;
            } else {
                Yii::app()->user->setState('lang', 'sv');
                $lang = Yii::app()->user->getState('lang');
            }

            $folder = Yii::getPathOfAlias('webroot.protected.messages') . DIRECTORY_SEPARATOR;
            $sql = "select lang_id from tbl_lang where lang_shortcode='" . $lang . "' ";

            $list = Yii::app()->db->createCommand($sql)->queryAll();

            if (!is_dir($folder . $lang) && !empty($list)) {
                $oldumask = umask(0);
                @mkdir($folder . $lang, 0777);
                @umask($oldumask);
                copy($folder . "fr/lang.php", $folder . $lang . "/lang.php");
            }

            if (isset(Yii::app()->request->cookies['pref_lang'])) {
                $this->owner->language = Yii::app()->request->cookies['pref_lang']->value;
            } else {
                $this->owner->language = $lang;
            }
        } catch(CDbException $x) {
            $string = file_get_contents(Yii::getPathOfAlias('webroot.protected.views.site') . DIRECTORY_SEPARATOR ."maintain.php");            
            print_r($string);
            die;
        }
    }

}

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Auktion Viivilla',
    'behaviors' => array('ApplicationConfigBehavior'),
    'timeZone' => 'Europe/Stockholm',
    'preload'=>array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.vendors.phpexcel.PHPExcel',
        'ext.yiireport.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            //'ipFilters'=>array($_SERVER['REMOTE_ADDR']),
            'ipFilters' => array('127.0.0.1', '::1', $_SERVER['REMOTE_ADDR']),
        ),
        'SimplePaypal' => array(
            'components' => array(
                'paypalManager' => array(
                    'class' => 'SimplePaypal.components.Paypal',
                ),
            ),
        ),
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => ['/dashboard/admin'],
        ),
        'ThumbsGen' => array(
            'class' => 'application.extensions.ThumbsGen.ThumbsGen',
        ),
        'twitter' => array(
            'class' => 'ext.yiitwitteroauth.YiiTwitter',
            'consumer_key' => 'v4WWxsBzJmtxp4TwHzJFMOCQe',
            'consumer_secret' => '7b5eQIhMG9q4AlLrnkFfU0Vc8q3mnrsrDGpJR6XMyZYDs29ie5',
            'callback' => 'http://' . $_SERVER["HTTP_HOST"] . '/site/twittercallback',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
//            'urlSuffix' => '.html',
//            'useStrictParsing' => true,
            'rules' => array(
                'admin' => 'dashboard/index',
                'om-oss' => 'site/about',
                'kontakta-oss' => 'site/contact',
                'villkor' => 'site/terms_conditions',
                'auktionspaket' => 'site/package',
                'registrera' => 'site/register',
                'mitt-konto' => 'site/myaccount',
                'min-profil' => 'site/profile',
                'mina-betalningar' => 'site/summary',
                'mina-bud' => 'site/history',
                'pågående-auktioner' => 'site/ongoingauctions',
                'avslutade-auktioner' => 'site/closedauctions',
                'betalda-auktioner' => 'site/paidauctions',
                'obetalda-auktioner' => 'site/unpaidauctions',
                'auktion/<id:\d+>/<title>' => 'site/product',
                'visa-historik/<id:\d+>' => 'site/showhistory',
                'författare/<id:\d+>/<name>' => 'site/author',
                'sök-sikt/<name>' => 'site/searchterm',
                'sök/<id:\d+>/<name>' => 'site/search',
                '<action:[\w\-]+>' => 'site/<action>',
                //'<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=auktionviivilla',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
            'persistent' => true
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendor.mpdf.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                /* 'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                  'mode'              => '', //  This parameter specifies the mode of the new document.
                  'format'            => 'A4', // format A4, A5, ...
                  'default_font_size' => 0, // Sets the default document font size in points (pt)
                  'default_font'      => '', // Sets the default font-family for the new document.
                  'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                  'mgr'               => 15, // margin_right
                  'mgt'               => 16, // margin_top
                  'mgb'               => 16, // margin_bottom
                  'mgh'               => 9, // margin_header
                  'mgf'               => 9, // margin_footer
                  'orientation'       => 'P', // landscape or portrait orientation
                  ) */
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendors.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                /* 'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                  'orientation' => 'P', // landscape or portrait orientation
                  'format'      => 'A4', // format A4, A5, ...
                  'language'    => 'en', // language: fr, en, it ...
                  'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                  'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                  'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                  ) */
                )
            ),
        ),
    ),
    'params' => array(
        //'adminEmail' => 'aman.r@cisinlabs.com',
        'adminEmail' => 'kundtjanst@smediagroup.se',
        'site_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/'
    ),
);
