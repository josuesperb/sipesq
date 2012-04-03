<?php

class PatrimonioTermoController extends Controller
{
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
				'users'=>Yii::app()->params['admins'],
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>Yii::app()->params['admins'],
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
		$criteria=new CDbCriteria;
		$criteria->with = array('projeto','patrimonio_items');
		$criteria->together = true;
		
		$model=PatrimonioTermo::model()->findByPk((int)$id, $criteria);
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
			
		$pItem=new PatrimonioItem('search');
		$pItem->unsetAttributes();  // clear any default values
		if(isset($_GET['PatrimonioItem']))
			$pItem->attributes=$_GET['PatrimonioItem'];
		$pItem->cod_termo = $model->cod_termo;
		
		$this->render('view',array(
			'model'=>$model,
			'pItem'=>$pItem,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PatrimonioTermo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PatrimonioTermo']))
		{
			$model->attributes=$_POST['PatrimonioTermo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cod_termo));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PatrimonioTermo']))
		{
			$model->attributes=$_POST['PatrimonioTermo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cod_termo));
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
	public function actionIndex()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('projeto','patrimonio_items');
		$criteria->together = true;
		$criteria->order = 'nro_termo_responsabilidade,  patrimonio_items.nome ASC';
		
		$dataProvider=new CActiveDataProvider('PatrimonioTermo', array('criteria'=>$criteria, 'pagination'=>array('pageSize'=>999,),));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PatrimonioTermo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PatrimonioTermo']))
			$model->attributes=$_GET['PatrimonioTermo'];
			
		
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
		$model=PatrimonioTermo::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='patrimonio-termo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
