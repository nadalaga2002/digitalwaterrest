<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
YiiBase::setPathOfAlias('rest', realpath(__DIR__ . '/../extensions/yii-rest-api/library/rest'));
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Water Usage Management',

	// preloading 'log' component
	'preload'=>array('log','restService'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'restService' => array(
            'class'  => '\rest\Service',
            'enable' => isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'], '/api/') !== false), //for example
        ),
		'urlManager' => array(
			'urlFormat'      => 'path',
			'showScriptName' => false,
            'baseUrl'        => '',
            'rules'          => array(
                array('restUser/index',  'pattern' => 'api/users', 'verb' => 'GET', 'parsingOnly' => true),
                array('restUser/create', 'pattern' => 'api/users', 'verb' => 'POST', 'parsingOnly' => true),
                array('restUser/view',   'pattern' => 'api/users/<id>', 'verb' => 'GET', 'parsingOnly' => true),
                array('restUser/update', 'pattern' => 'api/users/<id>', 'verb' => 'PUT', 'parsingOnly' => true),
                array('restUser/delete', 'pattern' => 'api/users/<id>', 'verb' => 'DELETE', 'parsingOnly' => true),
				array('Task/index',  'pattern' => 'api/task', 'verb' => 'GET', 'parsingOnly' => true),
                array('Task/create', 'pattern' => 'api/task', 'verb' => 'POST', 'parsingOnly' => true),
                array('Task/view',   'pattern' => 'api/task/<id>', 'verb' => 'GET', 'parsingOnly' => true),
                array('Task/update', 'pattern' => 'api/task/<id>', 'verb' => 'PUT', 'parsingOnly' => true),
                array('Task/delete', 'pattern' => 'api/task/<id>', 'verb' => 'DELETE', 'parsingOnly' => true),
				array('Valve/index',  'pattern' => 'api/valve', 'verb' => 'GET', 'parsingOnly' => true),
                array('Valve/create', 'pattern' => 'api/valve', 'verb' => 'POST', 'parsingOnly' => true),
                array('Valve/view',   'pattern' => 'api/valve/<id>', 'verb' => 'GET', 'parsingOnly' => true),
				array('Valve/viewbysiteid',   'pattern' => 'api/site/valve/<siteid>', 'verb' => 'GET', 'parsingOnly' => true),
				array('Valve/viewwaterusage',   'pattern' => 'api/waterusage/<siteid>', 'verb' => 'GET', 'parsingOnly' => true),
                array('Valve/update', 'pattern' => 'api/valve/<id>', 'verb' => 'PUT', 'parsingOnly' => true),
                array('Valve/delete', 'pattern' => 'api/valve/<id>', 'verb' => 'DELETE', 'parsingOnly' => true),
				
            )
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=digitalwatermanagement',
			'emulatePrepare' => true,
			'username' => 'root',
			 'password' => '',
			//'password' => 'password',			 
			//'password' => '',
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
		'adminEmail'=>'webmaster@example.com',
	),
);