<?php

class AtividadeController extends Controller
{
	protected $idMenu = 'menuGerencial';
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>Yii::app()->params['admins'],
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Atividade;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Atividade']))
		{
			$model->attributes=$_POST['Atividade'];
			
			//Valida projetos
			if(isset($_POST['Atividade']['projetos']))
				$model->projetos = $_POST['Atividade']['projetos'];
			
			//Valida pessoas
			if(isset($_POST['Atividade']['pessoas']))
				$model->pessoas = $_POST['Atividade']['pessoas'];
			
			
 			$model->cod_categoria = $_POST['Atividade']['cod_categoria'];
			
 			if(isset($_POST['Atividade']['bolsas'])) 
				$model->bolsas = $_POST['Atividade']['bolsas'];
				
				
			if($model->save()){
					
					$this->savaProjetos($model->cod_atividade, $model->projetos);
					$this->savaPessoas($model->cod_atividade, $model->pessoas);
				
					if(count($model->bolsas) > 0)
						$this->savaBolsas($model->cod_atividade, $model->bolsas);
						
				$this->redirect(array('view','id'=>$model->cod_atividade));
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be re	directed to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Atividade']))
		{
			$model->attributes=$_POST['Atividade'];
			
			if(isset($_POST['Atividade']['projetos']))
				$model->projetos = $_POST['Atividade']['projetos'];
				
			if(isset($_POST['Atividade']['pessoas']))	
			 $model->pessoas = $_POST['Atividade']['pessoas'];
			 
			if(isset($_POST['Atividade']['bolsas'])) 
				$model->bolsas = $_POST['Atividade']['bolsas'];

			if(isset($_POST['Atividade']['cod_categoria']))				
				$model->cod_categoria = $_POST['Atividade']['cod_categoria'];
			
			if($model->save()){
				
				if(count($model->bolsas) > 0)
					$this->savaBolsas($model->cod_atividade, $model->bolsas);
				
				if(count($model->pessoas) > 0)
					$this->savaPessoas($model->cod_atividade, $model->pessoas);
				
				if(count($model->projetos) > 0)
					$this->savaProjetos($model->cod_atividade, $model->projetos);
							
				$this->redirect(array('view','id'=>$model->cod_atividade));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($pessoa=null, $projeto=null, $finalizado=true, $categoria=null)
	{
		
		
		$criteria =new CDbCriteria;
		$criteria->with = array('categoria','pessoas'=>array('together'=>true),'projetos'=>array('together'=>true));
		
		if($categoria != null){
			$criteria->compare('categoria.cod_categoria_pai',$categoria);
		}
		
		if(!$finalizado)
		 	$criteria->addCondition('t.estagio=false', 'AND');
		
		
		if($pessoa != null){
			$criteria->addCondition('t.cod_pessoa = ' .$pessoa,'OR');
			$criteria->addCondition('pessoas.cod_pessoa = ' .$pessoa,'OR');
		}
		
		
		if($projeto != null){
			$criteria->compare('projetos.cod_projeto', $projeto);
		}
		
		 
		$dataProvider=new CActiveDataProvider('Atividade', array('criteria'=>$criteria,'pagination'=>array('pageSize'=>999,),))	;
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'projeto'=>$projeto,
			'pessoa'=>$pessoa,
			'categoria'=>$categoria,
			'finalizado'=>$finalizado,
		));
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Atividade('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Atividade']))
			$model->attributes=$_GET['Atividade'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Atividade::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='atividade-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function savaBolsas($cod_atividade, $bolsas){
		AtividadeFinanceiro::model()->deleteAll('cod_atividade = '.$cod_atividade);
		foreach ($bolsas as $bolsa){
			$a = new AtividadeFinanceiro();
			$a->cod_atividade = $cod_atividade;
			$a->cod_financeiro = $bolsa;
			$a->save();
			unset($a);		
		}
		
	}
	
	private function savaProjetos($cod_atividade,$projetos){
		AtividadeProjeto::model()->deleteAll('cod_atividade = '.$cod_atividade);
		foreach ($projetos as $p){
			$a = new AtividadeProjeto();
			$a->cod_atividade = $cod_atividade;
			$a->cod_projeto = $p;
			$a->save();
			unset($a);		
		}
		
	}
	
	private function savaPessoas($cod_atividade,$pessoas){
		AtividadePessoa::model()->deleteAll('cod_atividade = '.$cod_atividade);
		foreach ($pessoas as $p){
			$a = new AtividadePessoa();
			$a->cod_atividade = $cod_atividade;
			$a->cod_pessoa = $p;
			$a->save();
			unset($a);		
		}
	}
	
}
