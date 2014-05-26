<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
//$xmlSource = dirname(__FILE__) . '/../components/XmlFile.php';
//require_once('/var/www/protected/models/LoginForm.php');

//require_once( $xmlSource);
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'LenStar API',
        'charset' => 'ISO-8859-1',
	// preloading 'log' component
        'preload'=>array('log', 'session'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Pen7dejo',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
                        'authTimeout' => (60*15), // 15 minutes
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(    
			'connectionString' => 'mysql:host=localhost;dbname=yii_oldfm',
			'emulatePrepare' => true,
			'username' => 'gpclarke',
			'password' => 'Pen7dejo',
			'charset' => 'utf8',
			'enableParamLogging' => true,
			'tablePrefix' => 'tbl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
                'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                            array(
                                'class'=>'CWebLogRoute',
                                'levels'=>'trace,info,error,warning',
                                'filter' => array(
                                    'class' => 'CLogFilter',
                                    'prefixSession' => true,
                                    'prefixUser' => false,
                                    'logUser' => true,
                                    'logVars' => array(),
                                ),
                            ),
                            array(
                                'class'=>'CFileLogRoute',
                                'levels'=>'info, trace,error,warning',
                                'logFile'=>'info.log',
                            ),
//                'class'=>'CFileLogRoute',
//					'levels'=>'error, warning,trace',
//                                        'levels'=>'trace',
//                                            //
//                                            // I include *vardump* but you
                                            // can include more separated by commas
               // 'categories'=>'vardump',
                                            //
                                            // This is self-explanatory right?
     //                                   'showInFireBug'=>true
				),
				// uncomment the following to show log messages on web pages

			),
		),
	

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);