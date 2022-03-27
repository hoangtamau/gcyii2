<?php

$params = require(__DIR__ . '/params.php');
$basePath = dirname(__DIR__);
$webroot = dirname($basePath);
define('SITE_PATH', 'http://localhost/gamecard');
define('EMAIL_SERVER', 'vae@demandvi.com');

$config = [
    'id' => 'app',
    'basePath' => $basePath,
    'bootstrap' => ['log'],
    'language' => 'en-US',
    'runtimePath' => $webroot . '/runtime',
    'vendorPath' => $webroot . '/vendor',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
        // set custom module properties here ...
        ],
//        'usermoney' => [
//            'class' => 'app\modules\usermoney\usermoney',
//        ],
//        'laythe1' => [
//            'class' => 'app\modules\laythe\laythe',
//        ],
    ],
	//'layout' => 'main_testlogingoogle',
    'components' => [
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart',
        ],
        'ipAdd' => [
            'class' => 'app\components\iplocation\iplocation',
        ],
        /*'geoip' => [
            'class' => 'app\components\CGeoIP',
            'filename' => dirname(__DIR__) . '/components/GeoIP/GeoLiteCity.dat', // specify filename location for the corresponding database
            'mode' => 'STANDARD', // Choose MEMORY_CACHE or STANDARD mode
        ],*/
        'geoip' => [
            'class' => 'dpodium\yii2\geoip\components\CGeoIP',
        ],
        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
            // uncomment this to use streams in safe_mode
            //'useStreamsFallback' => true,
            ],
            'services' => [// You can change the providers and their classes.


                'google_oauth' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '682272291530-k1m59bokufpnkga4hragg299u2doiq04.apps.googleusercontent.com',//'708172856088-74f5hf8et50ni588a0kg20lbqqf06r30.apps.googleusercontent.com',//'738398957162-214v6ftf17hnjm6n35tk1cc4nm0tj6vr.apps.googleusercontent.com',
                    'clientSecret' => '-NEus-JRtydw1uH7rSGAmh3O',//'8EI8eFK9n0MFXQfVh1b83DPQ',//'OnEdgfuTA64mfamrvG_x9_Yc',
                    'title' => 'Google (OAuth)',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '366324126869078', //'730283887072058',
                    'clientSecret' => '35d5171372b4519f54f4dd34e74da411', //'08cc25da6d2ed33e6c462669d347bb36',
                ],
                'yahoo' => [
                    'class' => 'nodge\eauth\services\YahooOpenIDService',
                //'realm' => '*.example.org', // your domain, can be with wildcard to authenticate on subdomains.
                ],
            ],
        ],
        'users' => [
            'class' => 'amnah\yii2\user\components\Users',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'l0KFPiy4dKURPolfSoph', //5lTaT6a15ueLOcpQtssWbq
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /* 'mailer' => [
          'class' => 'yii\swiftmailer\Mailer',
          'viewPath' => '@app/mail',
          'transport' => [
          'class' => 'Swift_SmtpTransport',
          'host' => 's1.vnetbank.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
          'username' => 'smtp@vnsupermark.com',
          'password' => 'M@ilServer2015!',
          'port' => '587', // Port 25 is a very common port too
          'encryption' => 'tls', // It is often used, check your provider or mail server specs
          ],
          'useFileTransport' => false,
          ], */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 's1.vnetbank.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'smtp@gamecard.vn',
                'password' => 'gamecardvn123!',
                'port' => '26', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            'useFileTransport' => false,
            'viewPath' => '@app/mail',
        ],
		
        'urlManager' => [
            'rules' => [
                //'' => 'site/index',
                //'cat' => 'shop/index',
                // '<controller>/' => '<controller>/index',
                'site/login/<service:google_oauth|facebook|yahoo>' => 'site/login',
                'lien-he.html' => 'lienhe/index',
                'tin-tuc.html' => 'tintuc/index',
                'khuyen-mai.html' => 'khuyenmai/index',
                'huong-dan.html' => 'huongdan/index',
                'tai-khoan.html' => 'user/account',
                'detail-news/<slug>' => 'articles/view',
                'create-new-account.html' => 'user/register',
                'forgot-password.html' => 'user/forgot',
                'shop-cart.html' => 'shopcart/index',
                'nap-tien.html' => 'usermoney/usermoney',
                'mua-the.html' => 'laythe1/laythe',
                'lay-the-online.html' => 'user/laytheonline',
                'du-doan-ty-so.html' => 'dudoan/index',
                'cap-nhat-luot-doan.html' => 'orderluotdoan/index',
                'hiep-khach-san-the.html' => 'eventcard/index',
                'miss-game/<slug:[\w-]+>' => 'missgame/view',
                'qpal-the-bit.html' => 'the/category',
                'minh-chau-corp-the-mobay.html' => 'the/category',
                'zing-card-zing-xu-vinagame.html' => 'the/category',
                'gate-bac-gate-fpt.html' => 'the/category',
                'vcoin-vn.html' => 'the/category',
                'oncash-vdcnet2e-sgame.html' => 'the/category',
                'garena-nap-so.html' => 'the/category',
                'the-mobifone.html' => 'the/category',
                'the-vinaphone.html' => 'the/category',
                'the-viettel.html' => 'the/category',
                'the-megacard-vnpt-epay' => 'the/category',
                'the-vcard-the-nap-game-bai' => 'the/category',
                'the-appota' => 'the/category',
				'the-sohacoin-sohagame' => 'the/category',
				'the-scoin-vtc-mobile' => 'the/category',
                'the-appota-nap-game-gamota' => 'the/category',
				'the-funcard-funtap' => 'the/category',
				'the-link-glink' => 'the/category',
				'the-gosu-nha-cung-cap-gosu' => 'the/category',
				
                'category/the-game/<slug>' => 'the/category',
                'the-game-online' => 'the/catalog1',
                'the-dien-thoai' => 'the/catalog1',
				'ctv/<slug>' => 'site/ctv',
                '<slug>.htm' => 'the/categoryquatang',
                '<slug>.html' => 'the/chitiet',
                'product/qpal-the-bit/<slug>.html' => 'the/chitiet',
                'product/the-game/<slug>.html' => 'the/chitiet',
                'product/the-dien-thoai/<slug>.html' => 'the/chitiet',
                'category/<slug>' => 'the/cat',
                'catalog/<slug>' => 'the/catalog',
                'the-dien-thoai-online' => 'the/thedienthoai',
                'tin-tuc/<slug:[\w-]+>.html' => 'tintuc1/tintuc/chitiet',
                'user/view/<orderid:\d+>' => 'user/view',
                '<controller:\w+>/view/<slug:[\w-]+>' => '<controller>/view',
                '<controller:\w+>/chi-tiet/<slug:[\w-]+>' => '<controller>/chitiet',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/cat/<slug:[\w-]+>' => '<controller>/cat',
            ],
        ],
        'i18n' => array(
            'translations' => array(
                'eauth' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ),
            ),
        ),
        'assetManager' => [
            // uncomment the following line if you want to auto update your assets (unix hosting only)
            //'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'],
                //'js' => ['jquery.js'],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'],
                //'js' => ['js/bootstrap.js'],
                ],
            ],
        ],
        /* 'log' => [
          'traceLevel' => YII_DEBUG ? 3 : 0,
          'targets' => [
          [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
          ],
          ],
          ], */
        'db' => require(__DIR__ . '/db_ggggg.php'),
    ],
    'params' => $params,
];


if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';

    $config['components']['db']['enableSchemaCache'] = true;
}

//return array_merge_recursive($config, require($_SERVER['DOCUMENT_ROOT'] . '/vendor/noumo/easyii/config/easyii.php'));

return array_merge_recursive($config, require(dirname(__FILE__) . '/../../vendor/noumo/easyii/config/easyii.php'));

