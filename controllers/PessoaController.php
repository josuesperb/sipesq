<?php

class PessoaController extends Controller
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
				'actions'=>array('create','update' ,'myself','index', 'equipe','view', 'search','json','addprojetoatuante',),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('bolsistas', 'ajaxpessoa'),
				'users'=>Yii::app()->params['admins'],
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'search'),
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
		$this->render('_fullview',array(
			'data'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Pessoa;
		$model->data_nascimento = date("d/m/Y");
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pessoa']))
		{
			$model->attributes=$_POST['Pessoa'];
			
			if(isset($_POST['Atividade']['projetos_atuante']))
				$model->projetos_atuante = $_POST['Pessoa']['projetos_atuante'];
				
			if($model->save()){
					
					foreach ($model->projetos_atuante as $p){
						$ppa = new ProjetoPessoaAtuante();
						$ppa->cod_pessoa = $model->cod_pessoa;
						$ppa->cod_projeto = $p;
						$ppa->save();
						unset($ppa);		
					}
					
					$this->redirect(array('view','id'=>$model->cod_pessoa));
				}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionAddProjetoAtuante($id)
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$projeto_atuante = new ProjetoPessoaAtuante();
		$projeto_atuante->cod_pessoa = $id;
		if(isset($_POST['ProjetoPessoaAtuante']))
		{
			$projeto_atuante->attributes=$_POST['ProjetoPessoaAtuante'];
			$projeto_atuante->cod_pessoa = $id;
			if($projeto_atuante->save())
				$this->redirect(array('view','id'=>$id));
		} 	
		
		$this->render('createProjetoAtuante',array(
			'model'=>$projeto_atuante,
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
		
		//Se não for admin (testado por "user->id") ou se não for o perfil do próprio usuário bloqueia esta ação
		//if(!Yii::app()->user->id || !Yii::app()->user->name == $model->login)
			//throw new CHttpException(400,'Você não está autorizado a fazer esta operação');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pessoa']))
		{
				$connection=Yii::app()->db;
				$sql = "delete from projeto_pessoa_atuante where cod_pessoa = :cod_pessoa";
				$command = $connection->createCommand($sql);
				$command->bindParam(":cod_pessoa",$id,PDO::PARAM_STR);
				$command->execute();
			
			$model->attributes=$_POST['Pessoa'];
			
			if(isset($_POST['Pessoa']['projetos_atuante']))
				$model->projetos_atuante = $_POST['Pessoa']['projetos_atuante'];
				
				
			if($model->save()){
				
				foreach ($model->projetos_atuante as $p){
					$ppa = new ProjetoPessoaAtuante();
					$ppa->cod_pessoa = $model->cod_pessoa;
					$ppa->cod_projeto = $p;
					$ppa->save();
					unset($ppa);		
				}
				
				$this->redirect(array('view','id'=>$model->cod_pessoa));
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pessoa', array( 
							'pagination'=>array('pageSize'=>10,),
			
		'criteria'=>array('with'=>array('projetos_atuante'),'order'=> 'nome ASC'),
    						));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		'model'=> new Pessoa(),
		));
	}
	
	public function actionAjaxPessoa($id){
			$data = Pessoa::model()->findByPk($id);
			$data->getActiveRelation('pessoa_financeiro');
			$this->layout=false;
			
		 $this->render('_info_financeiro',array(
			'data'=>$data,
		));
	}
	
	/**
	 * 
	 * Carrega a página pessoal de uma pessoa logada no sistema.
	 */
	public function actionMyself(){
		$pessoa = Yii::app()->user->name;
		$model = Pessoa::model()->find("login = '{$pessoa}'");
		
		if($model == null)
			throw new CHttpException(404,'Não há página para o usuário ' .Yii::app()->user->name);
			
		$this->render('_fullview',array(
			'data'=>$model,
		));
		 
	}
	
	public function actionAutocompleteTest() {
    $res = array();
 	
    if (isset($_GET['term'])) {
        // http://www.yiiframework.com/doc/guide/database.dao
        $qtxt ="SELECT nome FROM pessoa WHERE nome LIKE :nome";
        $command =Yii::app()->db->createCommand($qtxt);
        $command->bindValue(":nome", '%'.$_GET['test1'].'%', PDO::PARAM_STR);
        $res =$command->queryColumn();
    }


    echo CJSON::encode($res);

    Yii::app()->end();
}
	
	
	
	/**
	 * JSON Test
	 */
	public function actionJson($id=null)
	{  
		$this->layout=false;
		header('Content-type: application/json');
		
		if($id != null){
			$pessoa = Pessoa::model()->findByPk((int)$id);
			$json = CJSON::encode($pessoa);
			echo $json;
			Yii::app()->end();
			return true;
		}
		
		$dataProvider=new CActiveDataProvider('Pessoa', array( 
							'pagination'=>array('pageSize'=>10,),
    						));
		
 
		
		foreach($dataProvider->getData() as $model){
		 $json = CJSON::encode($model);
		 echo $json;
		}
		
		Yii::app()->end();
	}
	
	
	/**
	 * Procura uma determinada Pessoa.
	 */
	public function actionSearch()
	{	
		$model=new Pessoa();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pessoa']))
		  $model->attributes=$_GET['Pessoa'];
		
		$criteria=new CDbCriteria;
		$criteria->with = array('projetos_atuante','vinculo_institucional');
		$criteria->together = true;

		$criteria->addSearchCondition('t.nome', $model->nome,true,'OR','ILIKE');
		$criteria->addSearchCondition('projetos_atuante.nome', $model->nome,true,'OR','ILIKE');
		$criteria->addSearchCondition('vinculo_institucional.nome', $model->nome,true,'OR','ILIKE');
		$criteria->addSearchCondition('telefone', $model->nome,true,'OR','ILIKE');
		$criteria->addSearchCondition('email', $model->nome,true,'OR','ILIKE');
		$criteria->addSearchCondition('cidade', $model->nome,true,'OR','ILIKE');
//		
		$criteria->order = 't.nome ASC';

		$dataProvider=new CActiveDataProvider('Pessoa', array(
							'criteria'=>$criteria, 
							'pagination'=>array('pageSize'=>10,),
    						));
    						
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
	}
	
	
/**
 * Mostra todas as pessoas que tem recebimentos financeiros.
 */
public function actionBolsistas()
	{
		
		$dataProvider=new CActiveDataProvider('Pessoa',array(
			                'criteria' => array(
			                 'with' => array('pessoa_financeiro'=>array( 'joinType'=>'LEFT JOIN')),
			                'together'=>true,
			                'condition'=>'pessoa_financeiro.cod_pessoa = t.cod_pessoa',
							'order'=>'nome, data_fim DESC',
			   				), 
			   				'pagination'=>array('pageSize'=>999,),
			   				)); 
		
		$this->render('bolsistas',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Mostra todos os membros atuais da equipe
	*/
public function actionEquipe()
	{
		
		$dataProvider=new CActiveDataProvider('Pessoa',array(
			                'criteria' => array(
			                'condition'=>'t.equipe_atual = true',
							'order'=>'nome',
			   				),
			   				)); 
		
		
			$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=> new Pessoa(),
		));
	}
	
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pessoa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pessoa']))
			$model->attributes=$_GET['Pessoa'];

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
		$criteria=new CDbCriteria;
		//$criteria->with = array('projetos_atuante','vinculo_institucional');
		//$criteria->together = true;
		
		$model=Pessoa::model()->findByPk((int)$id, $criteria);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pessoa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
