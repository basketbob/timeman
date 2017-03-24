<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'     => 'Timeman',
    //'sourceLanguage'=>'en',
    'language'=>'en',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'mkpt29',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','188.32.77.55','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'WebUser',
            'allowAutoLogin'=>true,
		),
        'request'=>array(
            'enableCookieValidation'=>true,
            'enableCsrfValidation'=>false,
        ),
        'urlManager'=>array(
            'class'=>'application.components.UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
                '<language:(ru|en)>/' => 'site/index',
                '<language:(ru|en)>/<action:(contact|login|logout|about|terms|privacy|pricing|signup)>/*' => 'site/<action>',
                '<action:(contact|login|logout|about|terms|privacy|pricing|signup)>/*' => 'site/<action>',
                '<language:(ru|en)>/<controller:\w+>/'=>'<controller>/index',
                '<language:(ru|en)>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<language:(ru|en)>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<language:(ru|en)>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
            ),
        ),
		// uncomment the following to enable URLs in path-format
		/*'urlManager'=>array(
			 'showScriptName' => false,
            'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/
		/* 'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		), */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => '',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
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

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@timeman.org',
        'supportEmail' => 'support@timeman.org',
        'languages'=>array( 'en'=>'English', 'ru'=>'Русский' ),
	),
);
