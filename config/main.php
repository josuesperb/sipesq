<<<<<<< .mine
<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SIPESQ',

	'language'=>'pt',

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
			'password'=>'gorder',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
	 'ftp'=>array(
          'class'=>'application.extensions.ftp.EFtpComponent',
          'host'=>'143.54.64.51',
          //'host'=>'ftp.isape.com.br',
          'port'=>21,
          'username'=>'E_CEPIK',
          //'username'=>'isape',
          'password'=>'Equipe#2010',
          //'password'=>'ipesa123ipesa',
          'ssl'=>false,
          'timeout'=>90,
          'autoConnect'=>false,
    	),
    	'tcpdf'=>array('class'=>'application.extensions.tcpdf.ETcPdf'),
		'calendar'=>array(
			'class' => 'application.extensions.calendar.googlecalendar',
		),    	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
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
		
		/*
		//Banco de dados de produção
		'db'=>array(
			'connectionString' => 'pgsql:host=143.54.64.104;port=5432;dbname=sipesq',
			'emulatePrepare' => true,
			'username' => 'postgres',
			'password' => 'ecepik',
			'charset' => 'utf8',
		),
		*/
		
		// Banco de dados de desenvolvimento
		
		'db'=>array(
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=dev_sipesq',
			'emulatePrepare' => true,
			'username' => 'postgres',
			'password' => 'gorder',
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
		'adminEmail'=>'grsevero@gmail.com',
		'admins'=>array('grsevero', 'eduardo.u.bueno', 'mcepik','admin', 'pedro.txai', 'gustavom_moller'),
	),
	
);
=======
<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SIPESQ',

	'language'=>'pt',

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
			'password'=>'gorder',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
	 'ftp'=>array(
          'class'=>'application.extensions.ftp.EFtpComponent',
          'host'=>'143.54.64.51',
          //'host'=>'ftp.isape.com.br',
          'port'=>21,
          'username'=>'E_CEPIK',
          //'username'=>'isape',
          'password'=>'Equipe#2010',
          //'password'=>'ipesa123ipesa',
          'ssl'=>false,
          'timeout'=>90,
          'autoConnect'=>true,
    	),
    	'tcpdf'=>array('class'=>'application.extensions.tcpdf.ETcPdf'),
		'calendar'=>array(
			'class' => 'application.extensions.calendar.googlecalendar',
		),    	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
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
		
		
		//Banco de dados de produção
		'db'=>array(
			'connectionString' => 'pgsql:host=143.54.64.104;port=5432;dbname=dev_sipesq',
			'emulatePrepare' => true,
			'username' => 'postgres',
			'password' => 'ecepik',
			'charset' => 'utf8',
		),
		
		
		// Banco de dados de desenvolvimento
		/*
		'db'=>array(
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=dev_sipesq',
			'emulatePrepare' => true,
			'username' => 'postgres',
			'password' => 'gorder',
			'charset' => 'utf8',
		),
		*/
		
		
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
		'adminEmail'=>'grsevero@gmail.com',
		'admins'=>array('grsevero', 'eduardo.u.bueno', 'mcepik','admin', 'pedro.txai', 'gustavom_moller'),
	),
	
);
>>>>>>> .r4
