<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

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
    }

}

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Auktion Viivilla',
    'behaviors' => array('ApplicationConfigBehavior'),
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
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
        'twitter' => array(
            'class' => 'ext.yiitwitteroauth.YiiTwitter',
            'consumer_key' => 'aR2zOxYU2FcHeM88jNumKNBVa',
            'consumer_secret' => 'FNJs5ZjIr0VM2zobx3YctamhFQdafg8MMZPFNHhPHSl3r0tWsC',
            'callback' => 'http://' . $_SERVER['HTTP_HOST'] . '/site/twittercallback',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
//            'urlSuffix' => '.html',
//            'useStrictParsing' => true,
            'rules' => array(
                'admin' => 'dashboard/admin',
                'product/<id:\d+>/<title>' => 'site/product',
                'showhistory/<id:\d+>' => 'site/showhistory',
                'author/<id:\d+>/<name>' => 'site/author',
                'search/<id:\d+>/<name>' => 'site/search',
                '<action:[\w\-]+>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=rtcisinl_viivilla',
            'emulatePrepare' => true,
            'username' => 'rtcisinl_viivill',
            'password' => '@KbF*R{las4C',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
            'persistent'=> true            
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
    ),
    'params' => array(
        'adminEmail' => 'aman.r@cisinlabs.com',
        'site_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/'
    ),
);
