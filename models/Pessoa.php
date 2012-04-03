<?php

/**
 * This is the model class for table "pessoa".
 *
 * The followings are the available columns in table 'pessoa':
 * @property integer $cod_pessoa
 * @property string $nome
 * @property string $nome_curto
 * @property string $nome_mae
 * @property string $telefone
 * @property string $cpf
 * @property string $rg
 * @property string $cartao_ufrgs
 * @property integer $cod_projeto_atuante
 * @property string $email
 * @property string $cidade
 * @property string $rua_complemento
 * @property string $bairro
 * @property string $cep
 * @property string $banco
 * @property string $agencia
 * @property string $conta_corrente
 * @property string $lattes
 * @property string $data_nascimento
 * @property integer $cod_vinculo_institucional
 * @property string $cod_banco
 * @property boolean $status_equipe
 * @property string $login
 *
 * The followings are the available model relations:
 * @property PessoaFinanceiro[] $pessoaFinanceiros
 * @property Projeto[] $projetos
 * @property VinculoInstitucional $vinculo_institucional
 * @property Projeto[] $projetos_atuante
 * @property Atividade[] $atividades
 * @property FuncoesPessoa[] $funcoes
 * @property Pessoa[] $pessoas_permitidas
 * @property PessoaCategoria $categoria
 * 
 */
class Pessoa extends CActiveRecord
{
	public $equipe="";
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pessoa the static model class
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
		return 'pessoa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, nome_mae', 'required'),
			array('projetos_atuante', 'validaProjetos'),
			array('cod_projeto_atuante, cod_vinculo_institucional', 'numerical', 'integerOnly'=>true),
			array('telefone, cpf, rg, login, cartao_ufrgs, email, cidade, rua_complemento, bairro, cep, banco, agencia, conta_corrente, lattes, data_nascimento, cod_banco, equipe_atual, cod_categoria', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cod_pessoa, nome, nome_mae, login, telefone, cpf, rg, cartao_ufrgs, cod_projeto_atuante, email, cidade, rua_complemento, bairro, cep, banco, agencia, conta_corrente, lattes, data_nascimento, cod_vinculo_institucional, cod_banco', 'safe', 'on'=>'search'),
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
			'pessoa_financeiro' => array(self::HAS_MANY, 'PessoaFinanceiro', 'cod_pessoa'),
			'funcoes' => array(self::HAS_MANY, 'FuncoesPessoa', 'cod_pessoa'),
			'projetos' => array(self::HAS_MANY, 'Projeto', 'cod_pessoa_coordenador'),
			'vinculo_institucional' => array(self::BELONGS_TO, 'VinculoInstitucional', 'cod_vinculo_institucional'),
			'categoria' => array(self::BELONGS_TO, 'PessoaCategoria', 'cod_categoria'),
			//'projeto_atuante' => array(self::BELONGS_TO, 'Projeto', 'cod_projeto_atuante'),
			'projetos_atuante' => array(self::MANY_MANY, 'Projeto', 'projeto_pessoa_atuante(cod_pessoa, cod_projeto)'),
			'atividades' => array(self::MANY_MANY, 'Atividade', 'atividade_pessoa(cod_pessoa, cod_atividade)'),
			'permissao_projeto' => array(self::MANY_MANY, 'Projeto', 'permissao_projeto(cod_pessoa, cod_projeto)'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cod_pessoa' => 'Código',
			'nome' => 'Nome Completo',
			'nome_curto'=>'Nome',
			'nome_mae' => 'Nome Completo da Mãe',
			'telefone' => 'Código de Área e Telefone',
			'cpf' => 'CPF',
			'rg' => 'RG',
			'cartao_ufrgs' => 'Cartão da UFRGS',
			'cod_projeto_atuante' => 'Projeto Atuante',
			'email' => 'Email',
			'cidade' => 'Cidade',
			'rua_complemento' => 'Rua e Complemento',
			'bairro' => 'Bairro',
			'cep' => 'CEP',
			'banco' => 'Banco',
			'agencia' => 'Agência',
			'conta_corrente' => 'Conta Corrente',
			'lattes' => 'Currículo Lattes',
			'data_nascimento' => 'Data de Nascimento',
			'cod_vinculo_institucional' => 'Vínculo Institucional',
			'cod_banco' => 'Código do Banco',
			'login'=>'Login',
			'projetos_atuante' => 'Projetos em que atua',
			'cod_categoria'=>'Função',
			'categoria'=>'Função',
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

		$criteria->compare('cod_pessoa',$this->cod_pessoa);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('nome_mae',$this->nome_mae,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('cpf',$this->cpf,true);
		$criteria->compare('rg',$this->rg,true);
		$criteria->compare('cartao_ufrgs',$this->cartao_ufrgs,true);
		$criteria->compare('cod_projeto_atuante',$this->cod_projeto_atuante);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('rua_complemento',$this->rua_complemento,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('banco',$this->banco,true);
		$criteria->compare('agencia',$this->agencia,true);
		$criteria->compare('conta_corrente',$this->conta_corrente,true);
		$criteria->compare('lattes',$this->lattes,true);
		$criteria->compare('data_nascimento',$this->data_nascimento,true);
		$criteria->compare('cod_vinculo_institucional',$this->cod_vinculo_institucional);
		$criteria->compare('cod_banco',$this->cod_banco,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public static function toArray(){
		$arr = array();
		$pessoas = Pessoa::model()->findAll();
		foreach($pessoas as $p){
			$arr[] = $p->nome;
		}
		return $arr;
	}	
	
	public static function isInVacation($id){
		
		$hoje = date('Y-m-d');
		$condition = "cod_pessoa = :id AND";
		$condition .= " data_inicio <= :hoje AND ";
		$condition .= " data_fim >= :hoje ";
		
		$pessoas = Ferias::model()->findAll($condition, array('hoje'=>$hoje, 'id'=>$id));
		
		if(!empty($pessoas)){
			return true;
		}
		
		return false;
	}
	
	public function afterFind(){
		if($this->equipe_atual){
			$this->equipe = "Equipe Atual";
		}else{
			$this->equipe = "Outras Pessoas";
		}
		parent::afterFind();
	}
	
	/**
	 * 
	 * Valida se o usuario especificou pelo menos um projeto
	 * @param unknown_type $attribute
	 * @param unknown_type $params
	 */
	public function validaProjetos($attribute,$params){
			 if(count($this->$attribute) < 1)
			 	$this->addError($attribute, 'Você deve especificar pelo menos um projeto.');
	}
	
}