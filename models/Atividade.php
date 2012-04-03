<?php

/**
 * This is the model class for table "atividade".
 *
 * The followings are the available columns in table 'atividade':
 * @property integer $cod_atividade
 * @property integer $cod_pessoa 
 * @property string $tipo_vinculo
 * @property string $nome_atividade
 * @property string $descricao
 * @property string $data_inicio
 * @property string $data_fim
 * @property integer $turnos_trabalho
 * @property boolean $estagio
 *
 * The followings are the available model relations:
 * @property PessoaFinanceiro[] $bolsas
 * @property Projeto[] $projetos
 * @property Pessoa[] $pessoas
 * @property Pessoa $responsavel
 * @property AtividadeCategoria $categoria
 */

/*
 * pensar na marcação dos relatórios
 */

class Atividade extends CActiveRecord
{
	public $class;
	public $status;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Atividade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'atividade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod_pessoa, nome_atividade, cod_categoria, descricao, data_inicio, data_fim', 'required'),
			array('projetos', 'validaProjetos'),
			array('pessoas', 'validaPessoas'),
			array('cod_pessoa, cod_categoria', 'numerical', 'integerOnly'=>true),
			array('tipo_vinculo, estagio', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cod_atividade, cod_pessoa, tipo_vinculo, nome_atividade, descricao, data_inicio, data_fim, turnos_trabalho, estagio', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bolsas' => array(self::MANY_MANY, 'PessoaFinanceiro', 'atividade_financeiro(cod_atividade, cod_financeiro)'),
			'projetos' => array(self::MANY_MANY, 'Projeto', 'atividade_projeto(cod_atividade, cod_projeto)'),
			'pessoas' => array(self::MANY_MANY, 'Pessoa', 'atividade_pessoa(cod_atividade, cod_pessoa)'),
			'responsavel' => array(self::BELONGS_TO, 'Pessoa', 'cod_pessoa'),
			'categoria' => array(self::BELONGS_TO, 'AtividadeCategoria', 'cod_categoria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cod_atividade' => 'ID',
			'cod_pessoa' => 'Responsável',
			'tipo_vinculo' => 'Tipo de Vínculo',
			'nome_atividade' => 'Nome da Atividade',
			'descricao' => 'Descrição',
			'data_inicio' => 'Data de Início',
			'data_fim' => 'Data de Fim',
			'turnos_trabalho' => 'Turnos de Trabalho',
			'estagio' => 'Finalizado', //amarelo (andamento) ,Verde(Finalizado), Vermelho(Atrasado)
			'responsavel'=>'Responsável',
			'status'=>'Estágio',
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cod_atividade',$this->cod_atividade);
		$criteria->compare('cod_pessoa',$this->cod_pessoa);
		$criteria->compare('tipo_vinculo',$this->tipo_vinculo,true);
		$criteria->compare('nome_atividade',$this->nome_atividade,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('data_inicio',$this->data_inicio,true);
		$criteria->compare('data_fim',$this->data_fim,true);
		$criteria->compare('turnos_trabalho',$this->turnos_trabalho);
		$criteria->compare('estagio',$this->estagio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function afterFind(){
		$this->calculaStatus();
		
		parent::afterFind();
	}
	
	private function calculaStatus(){
		
		if($this->estagio){
			$this->class = 'verde';
			$this->status = 'Atividade Finalizada';
			return false;
		}
		
		if((strtotime(date("Y-m-d")) < strtotime($this->data_fim)) && !$this->estagio){
			$this->class = 'amarelo';
			$this->status = 'Atividade em Andamento';
		}else{
			$this->class = 'vermelho';
			$this->status = 'Atividade Atrasada';
		}
		
	}
	
	/**
	 * 
	 * Retorna as atividades que acabam em 6 meses 
	 */
	public static function getLasts(){
		$criteria=new CDbCriteria;
		$dataLimite =  date("Y-m-d", mktime(0, 0, 0, date("m") + 6, date("d"), date("Y")));
		$dataAtual = date("Y-m-d");
		$criteria->addCondition("t.data_fim <= '$dataLimite'", 'AND');
		$criteria->addCondition("t.data_fim >= '$dataAtual'", 'AND');
		$criteria->order = 't.data_fim DESC, t.nome_atividade ASC';
		return Atividade::model()->findALL($criteria);;
	}
	
/**
	 * 
	 * Retorna as atividades que acabam em 6 meses de determinado usuário
	 */
	public static function getLastsByUser($user){
		
		$pessoa = Pessoa::model()->find('login = :user', array('user'=>$user));
		
		if($pessoa == null){
			//Se a pessoa não contém login retorna um array vazio
			return array();
		}
		$cod_pessoa = $pessoa->cod_pessoa; 
		
		$criteria=new CDbCriteria;
		$dataLimite =  date("Y-m-d", mktime(0, 0, 0, date("m") + 6, date("d"), date("Y")));
		$dataAtual = date("Y-m-d");
		$criteria->addCondition("t.data_fim <= '$dataLimite'", 'AND');
		$criteria->addCondition("t.data_fim >= '$dataAtual'", 'AND');
		$criteria->with = array('pessoas');
		$criteria->addCondition("pessoas.cod_pessoa = $cod_pessoa", 'AND');
		$criteria->order = 't.data_fim DESC, t.nome_atividade ASC';
		return Atividade::model()->findALL($criteria);;
	}
	
	public function validaProjetos($attribute,$params){
			 if(count($this->$attribute) < 1)
			 	$this->addError($attribute, 'Você deve especificar pelo menos um projeto.');
	}
	
	public function validaPessoas($attribute, $params){
			if(count($this->$attribute) < 1)
			 	$this->addError($attribute, 'Você deve especificar pelo menos uma pessoa.');
	}
}