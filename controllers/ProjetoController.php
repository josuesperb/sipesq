<?php

class ProjetoController extends Controller
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
		
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('coordenadores','index', 'view','create','update', 'ativos', 'finalizados'),
				'users'=>array('@'),
			),
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('permissoes', 'deletePermissao', 'relatorio','admin','delete','index', 'finalizados', 'ativos','view','create','update'),
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
		/*
		$criteria=new CDbCriteria;
		$criteria->with = array('coordenador','pessoas_atuantes', 'pessoas_recebimento');
		$criteria->together = true;
		*/
		
		$model = Projeto::model()->findByPk($id);
		
			//Verifica a permissão dos usuários.
			if(!in_array(Yii::app()->user->name, array_merge($model->loginsPermitidos(PermissaoProjeto::READ_PERMITION) , Yii::app()->params['admins'], $model->pessoasAtuantesToArray())))
				throw new CHttpException(401,'Acesso Negado. Você não está permitido a fazer esta operação.');
		
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	
/**
 * 
 * Relatório de projeto
 * @param integer $id
 */
	
public function actionRelatorio($id)
	{
		
		$model = Projeto::model()->findByPk($id);
		
		//Verifica a permissão dos usuários.
			if(!in_array(Yii::app()->user->name, array_merge($model->loginsPermitidos(PermissaoProjeto::READ_PERMITION) , Yii::app()->params['admins'])))
				throw new CHttpException(401,'Acesso Negado. Você não está permitido a fazer esta operação.');
		
		$this->layout = "//layouts/relatorio";
		$this->render('relatorio',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Projeto;
		$model->data_inicio = date("d/m/Y");
		$model->data_fim = date("d/m/Y");
		$model->data_relatorio = date("d/m/Y");

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Projeto']))
		{
			$model->attributes=$_POST['Projeto'];
			
			if(isset($_POST['Projeto']['pessoas_atuantes'])){
				$model->pessoas_atuantes = $_POST['Projeto']['pessoas_atuantes'];
			}
			
			if($model->save()){
				//Cria permissão para o coordenador
				$this->createDafaultPermissions($model);
				$this->salvaPessoas($model->cod_projeto, $model->pessoas_atuantes);
				$this->redirect(array('view','id'=>$model->cod_projeto));
				
			}
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

		//Verifica a permissão dos usuários.
		if(!in_array(Yii::app()->user->name, array_merge($model->loginsPermitidos(PermissaoProjeto::READ_WRITE_PERMITION) , Yii::app()->params['admins'])))
			throw new CHttpException(401,'Acesso Negado. Você não está permitido a fazer esta operação.');
		
		if(isset($_POST['Projeto']))
		{
			
			if(isset($_POST['Projeto']['pessoas_atuantes'])){
				$model->pessoas_atuantes = $_POST['Projeto']['pessoas_atuantes'];
			}
			
			//Retira a permisssão do coordenador antigo
			$this->deleteDafaultPermissions($model);
				
			$model->attributes=$_POST['Projeto'];
			if($model->save()){
				
				//Atualiza permissão do coordenador
				$this->createDafaultPermissions($model);
				$this->salvaPessoas($model->cod_projeto, $model->pessoas_atuantes);
				$this->redirect(array('view','id'=>$model->cod_projeto));
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
		//Deleta apenas se for um request do tipo POST
		if(Yii::app()->request->isPostRequest)
		{
		
			$model = $this->loadModel($id);
			
			//Verifica a permissão dos usuários.
			if(!in_array(Yii::app()->user->name, array_merge($model->loginsPermitidos(PermissaoProjeto::READ_WRITE_DELETE_PERMITION) , Yii::app()->params['admins'])))
				throw new CHttpException(401,'Acesso Negado. Você não está permitido a fazer esta operação.');
			
			 //	Deleta o projeto
			 $model->delete();
				
				
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
		$dataProvider=new CActiveDataProvider('Projeto', array('criteria'=>array('order'=>'nome')));
			   				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Mostra todos os projetos finalizados 
	 */
	public function actionFinalizados()
	{
		$dataProvider=new CActiveDataProvider('Projeto', array('criteria'=>array('order'=>'nome', 'condition'=>'finalizado = true')));
			   				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Mostra todos os projetos ativos
	 */
	
	public function actionAtivos()
	{
		$dataProvider=new CActiveDataProvider('Projeto', array('criteria'=>array('order'=>'nome', 'condition'=>'finalizado = false')));
			   				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	
	/**
	 * Deleta as permissões padrão para Bolsista Responsável e Coordenador
	 * @param Projeto $projeto - projeto que será atualizado
	 */
	 private function deleteDafaultPermissions($projeto){
	 	
	 	//deleta a permissao do professor
	 	$coordenador = PermissaoProjeto::model()->find('cod_pessoa = :pessoa AND cod_projeto = :projeto', array('pessoa'=>$projeto->cod_professor, 'projeto'=>$projeto->cod_projeto));
	 	if($coordenador != null){
	 		$coordenador->delete();
	 		
	 	}
	 	
	 	//Deleta a permissao do pos-graduando
	 	$responsavel = PermissaoProjeto::model()->find('cod_pessoa = :pessoa AND cod_projeto = :projeto', array('pessoa'=>$projeto->cod_pos_grad, 'projeto'=>$projeto->cod_projeto));
	 	if($responsavel != null){
	 		$responsavel->delete();
	 	}
	 	
	 //Deleta a permissao do graduando
	 	$responsavel = PermissaoProjeto::model()->find('cod_pessoa = :pessoa AND cod_projeto = :projeto', array('pessoa'=>$projeto->cod_grad, 'projeto'=>$projeto->cod_projeto));
	 	if($responsavel != null){
	 		$responsavel->delete();
	 	}
	 	
	 }
	 
	/**	
	 * Cria as permissões padrão para Bolsista Responsável e Coordenador
	 * @param Projeto $projeto - projeto que será atualizado
	 */
	 private function createDafaultPermissions($projeto){
	 	//Atualiza permissão do professor responsavel
		$permissao_professor = new PermissaoProjeto();
		$permissao_professor->cod_projeto = $projeto->cod_projeto;
		$permissao_professor->cod_pessoa = $projeto->cod_professor;
		$permissao_professor->nivel_permissao = PermissaoProjeto::READ_WRITE_DELETE_PERMITION;
		$permissao_professor->save();
		unset($permissao_professor);
		
		//Atualiza permissão do pos-graduando responsavel
		$permissao_pos_grad = new PermissaoProjeto();
		$permissao_pos_grad->cod_projeto = $projeto->cod_projeto;
		$permissao_pos_grad->cod_pessoa = $projeto->cod_pos_grad;
		$permissao_pos_grad->nivel_permissao = PermissaoProjeto::READ_WRITE_DELETE_PERMITION;
		$permissao_pos_grad->save();
		unset($permissao_pos_grad);
		
	 	//Atualiza permissão do graduando responsavel
		$permissao_grad = new PermissaoProjeto();
		$permissao_grad->cod_projeto = $projeto->cod_projeto;
		$permissao_grad->cod_pessoa = $projeto->cod_grad;
		$permissao_grad->nivel_permissao = PermissaoProjeto::READ_WRITE_PERMITION;
		$permissao_grad->save();
		unset($permissao_grad);
		
	 }
	
	/**
	 * Gerencia as permissões dos usuários nos projetos
	 * @param integer $id - identificador do projeto
	 */
	public function actionPermissoes($id){
		
		$model = new PermissaoProjeto();
		$model->cod_projeto = $id;
		
		if(isset($_POST['PermissaoProjeto']))
		{
			$model->attributes=$_POST['PermissaoProjeto'];
			if($model->save())
				$this->redirect(array('permissoes', 'id'=>$id));
		}
		
		
			//Renderiza a página de permissões confome o projeto
			$projeto = Projeto::model()->findByPk($id);
	
			if($projeto == null){
				//Se não existe este projeto dispara erro			
				throw new CHttpException(404,'Página não encontrada.');
			}
			
			$data = PermissaoProjeto::model()->findAll(array('condition'=>"cod_projeto = " .$id));
			$this->render('_form_permissao', array('data'=>$data, 'projeto'=>$projeto, 'model'=>$model));	
		
	}
	
	
	/**
	 * 
	 * Deleta uma permissão
	 * @param integer $id
	 * @throws CHttpException
	 */
	public function actionDeletePermissao($cod_projeto, $cod_pessoa)
	{
			$model = PermissaoProjeto::model()->find('cod_pessoa = :cod_pessoa AND cod_projeto = :cod_projeto', array('cod_projeto'=>$cod_projeto, 'cod_pessoa'=>$cod_pessoa));
			$projeto = Projeto::model()->findByPk($cod_projeto);
			
			//Verifica a permissão dos usuários.
			if(!in_array(Yii::app()->user->name, array_merge($projeto->loginsPermitidos(PermissaoProjeto::READ_WRITE_DELETE_PERMITION) , Yii::app()->params['admins'])))
				throw new CHttpException(401,'Acesso Negado. Você não está permitido a fazer esta operação.');
			
			 //	Deleta o projeto
			 $model->delete();
			$this->redirect(isset($_GET['returnUrl']) ? $_GET['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Projeto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Projeto']))
			$model->attributes=$_GET['Projeto'];

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
		$model=Projeto::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='projeto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function salvaPessoas($cod_projeto,$pessoas){
		ProjetoPessoaAtuante::model()->deleteAll('cod_projeto = '.$cod_projeto);
		foreach ($pessoas as $p){
			$a = new ProjetoPessoaAtuante();
			$a->cod_projeto = $cod_projeto;
			$a->cod_pessoa = $p;
			$a->save();
			unset($a);		
		}
	}
	
	public function actionCoordenadores(){
		$projetos = Projeto::model()->findAll();
		
		foreach($projetos as $p){
				
			
			if($p->save()){
				echo $p->nome ." foi salvo com sucesso<br>";
			}
		}
		
	  	Yii::app()->end();
		
		
	}

}
