<?php

class SiteController extends Controller
{
		
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('acervoDigital','filebrowser'),
				'users'=>array('@'),
			),
			
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(isset($_POST['LoginForm']))
		{
			$this->actionLogin();
		}
		$this->render('index');
	}
	
	public function actionAgenda()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('agenda');
	}
	
	public function actionSobre()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('/site/pages/about');
	}
	
	public function actionAcervoDigital(){
		
		//Verifica se o usuários está logado
		if(Yii::app()->user->isGuest)
			$this->redirect(array('site/login'));	
		//Requere o FTP.
		$ftp = Yii::app()->ftp;
		
		//Se o usuário é um admin ele terá acesso ao FTP de admin.
		if(in_array(Yii::app()->user->name, Yii::app()->params['admins'])){
			$ftp->setActive(false);
			$ftp->username = "ADM_CEPIK";
			$ftp->password = "Adm#2011";
			$ftp->setActive(true);
		}else{
			//Usúarios para grupo que nao é admin
			$ftp->setActive(false);
			$ftp->username = "E_CEPIK";
			$ftp->password = "Equipe#2010";
			$ftp->setActive(true);
		}
				
		//Seta a pasta inicial
		$dir = '/ACERVO DIGITAL';
		
		if(isset($_GET['download'])){
			$dir = $_GET['download'];
			$link = '143.54.64.51' .$dir;
			echo '143.54.64.51' .$dir;
			header("Location: ftp://" .$link);
			//$this->redirect($link);
			Yii::app()->end();
			
		}
		
		if(isset($_GET['f']))
			$dir = $_GET['f'];
			
		
		//Define o diretório acima
		$lastDir = $ftp->currentDir();
		$lastDir = substr($lastDir, 0, strrpos($lastDir,'/') + 1);
		
		//Move para o diretório
		if($ftp->directory_exists($dir))
		 	$ftp->chdir($dir);
		 	else
		 		$ftp->chdir($lastDir);
		 			
					
		
		//Captura os arquivos
		 $files = $ftp->listFiles($ftp->currentDir());
		
		//Define o diretório acima atualizado
		$lastDir = $ftp->currentDir();
		$lastDir = substr($lastDir, 0, strrpos($lastDir,'/') + 1);
		
		$this->render('/site/acervodigital', array('ftp'=>$ftp, 'lastDir'=>$lastDir));


	}
	
public function actionDownload()
	{
		
		
 		$model = $this->loadModel($id);

 		header("Location: application/save");
		Yii::app()->end();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
public function actionFileBrowser()
	{
		$root = '/';
		$_POST['dir'] = 'protected';
		$_POST['dir'] = urldecode($_POST['dir']);

		if( file_exists($root . $_POST['dir']) ) {
			$files = scandir($root . $_POST['dir']);
			natcasesort($files);
			if( count($files) > 2 ) { /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				// All files
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
						$ext = preg_replace('/^.*\./', '', $file);
						echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
					}
				}
				echo "</ul>";	
			}
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function addUser(){
		
		$model=new LoginForm;
		
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
	
			
			
			
			
		}
		// display the login form
		$this->render('login',array('model'=>$model));
			
			$user = $this->username;
			$password = $this->password;
			$host = "ec-server";
			$domain = "ecepik.local";
			$basedn = "dc=ecepik,dc=local";
			$group = "EquipeCepik";
			try{
				$ds = ldap_connect("{$host}.{$domain}");
			}catch(CHttpException $e){
				throw $e(400,'Não foi possível conectar ao nosso servidor LDAP.');
			}
			
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			
			//Adiciona user
			if ($ds) {
				
				 // prepare data
			    $info["cn"] = "John Jones";
			    $info["sn"] = "Jones";
			    $info["mail"] = "jonj@example.com";
			    $info["objectclass"] = "person";
			
			    // add data to directory
			    $r = ldap_add($ds, "cn=John Jones, o=My Company, c=US", $info);
			    if(!$f){
			    	throw new CHttpException(400,'Não foi possivel adicionar o usuário');
			    }
			
			    ldap_close($ds);
			
			}else{
				throw new CHttpException(400,'Não foi possivel conectar com o servidor');
			}
		 
		
	}
}