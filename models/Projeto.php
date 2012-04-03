<?php

/**
 * This is the model class for table "projeto".
 *
 * The followings are the available columns in table 'projeto':
 * @property integer $cod_projeto
 * @property string $nome
 * @property string $codigo_projeto
 * @property string $data_inicio
 * @property string $data_fim
 * @property string $data_relatorio
 * @property string $ultima_modificacao
 * @property string $descricao
 * @property boolean $finalizado
 * @property double $verba_custeio
 * @property double $verba_capital
 * @property double $verba_bolsa
 *
 * The followings are the available model relations:
 * @property ProjetoFinanceiro[] $projeto_financeiro
 * @property PessoaFinanceiro[] $pessoas_recebimento
 * @property Pessoa $coordenador
 * @property Pessoa $professor
 * @property Pessoa $pos_graduando
 * @property Pessoa $graduando
 * @property ProjetoCategoria $categoria
 * @property Pessoa[] $pessoas_atuantes
 * @property Pessoa[] $pessoas_permitidas
 * @property PatrimonioTermos[] $patrimonio_termos
 * @property Livro[] $livros
 * @property Atividade[] $atividades
 */
class Projeto extends CActiveRecord
{
	//Gastos	
	public $gasto_bolsa;
	public $gasto_custeio;
	public $gasto_capital;
	public $gasto_outros;
	public $gasto_servico;
	public $gasto_livros;
	public $gasto_patrimonios;
	//Verbas
	public $verba_outros;
		
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projeto the static model class
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
		return 'projeto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, cod_categoria', 'required'),
			array('cod_professor', 'validaResponsavel', 'cod_pos_grad', 'cod_grad'),
			array('cod_grad', 'validaResponsavel', 'cod_pos_grad', 'cod_professor'),
			array('cod_pos_grad', 'validaResponsavel', 'cod_professor', 'cod_grad'),
			array('cod_professor, cod_grad, cod_pos_grad,  cod_categoria', 'numerical', 'integerOnly'=>true),
			array('verba_custeio, verba_capital, verba_bolsa', 'numerical'),
			array('codigo_projeto, finalizado, data_inicio, data_fim, data_relatorio,ultima_modificacao, descricao, pessoas_atuantes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cod_projeto, nome, codigo_projeto, data_inicio, data_fim, data_relatorio, descricao, verba_custeio, verba_capital, verba_bolsa', 'safe', 'on'=>'search'),
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
			//'pessoaFinanceiros' => array(self::MANY_MANY, 'PessoaFinanceiro', 'projeto_pessoa_financeiro(cod_projeto, cod_financeiro)'),
			'professor' => array(self::BELONGS_TO, 'Pessoa', 'cod_professor'),
			'pos_graduando' => array(self::BELONGS_TO, 'Pessoa', 'cod_pos_grad'),
			'graduando' => array(self::BELONGS_TO, 'Pessoa', 'cod_grad'),
			'pessoas_atuantes' => array(self::MANY_MANY, 'Pessoa', 'projeto_pessoa_atuante(cod_pessoa, cod_projeto)', 'order'=>'nome'),
			'atividades' => array(self::MANY_MANY, 'Atividade', 'atividade_projeto(cod_atividade, cod_projeto)'),
			'patrimonio_termos' => array(self::HAS_MANY, 'PatrimonioTermo', 'cod_projeto'),
			'livros' => array(self::HAS_MANY, 'Livro', 'cod_projeto', 'order'=>'titulo'),
			'pessoas_recebimento' => array(self::HAS_MANY, 'PessoaFinanceiro', 'projeto_vinculado'),
			'projeto_financeiro' => array(self::HAS_MANY, 'ProjetoFinanceiro', 'cod_projeto'),
			'categoria' => array(self::BELONGS_TO, 'ProjetoCategoria', 'cod_categoria'),
			//'pessoas_permitidas' => array(self::MANY_MANY, 'Pessoa', 'permissao_projeto(cod_projeto, cod_pessoa)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cod_projeto' => 'ID',
			'nome' => 'Nome',
			'codigo_projeto' => 'Código do Projeto',
			'data_inicio' => 'Início',
			'data_fim' => 'Término',
			'data_relatorio' => 'Data do Relatório',
			'descricao' => 'Descricao',
			'verba_custeio' => 'Verba Custeio',
			'verba_capital' => 'Verba Capital',
			'verba_bolsa' => 'Verba Bolsa',
			'verba_outros'=>'Verba Outros',
			'gasto_outros'=>'Gasto Outros',
			'gasto_custeio'=>'Gasto Custeio',
			'gasto_capital'=>'Gasto Capital',
			'gasto_bolsa'=>'Gasto Bolsa',
			'finalizado'=>'Finalizado',
			'cod_categoria'=>'Categoria',
			'cod_professor'=>'Professor',
			'cod_pos_grad'=>'Pós-Graduando',
			'cod_grad'=>'Graduando',
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

		$criteria->compare('cod_projeto',$this->cod_projeto);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('codigo_projeto',$this->codigo_projeto,true);
		$criteria->compare('data_inicio',$this->data_inicio,true);
		$criteria->compare('data_fim',$this->data_fim,true);
		$criteria->compare('data_relatorio',$this->data_relatorio,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('verba_custeio',$this->verba_custeio);
		$criteria->compare('verba_capital',$this->verba_capital);
		$criteria->compare('verba_bolsa',$this->verba_bolsa);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	protected function afterFind(){
			
		$this->calculaGastosVerbas();
		
	}
	
	protected function beforeSave(){
		$this->ultima_modificacao = date("Y-m-d");
		parent::beforeSave();
		return true;
	}
	
	
	private function calculaGastosVerbas(){
		
		//Inicialização das propriedades de gastos e verbas
		
			 //Gastos	
			 $this->gasto_bolsa = 0;
			 $this->gasto_custeio = 0;
			 $this->gasto_capital = 0;
			 $this->gasto_outros = 0;
			 $this->gasto_servico = 0;
			 //Verbas
			 $this->verba_outros = 0;
		
		foreach ($this->projeto_financeiro as $financa){
			
				if($financa->categoria->nome == 'gasto_custeio') //se gasto custeio
					$this->gasto_custeio += $financa->valor;
					
				if($financa->categoria->nome == 'gasto_capital') //se gasto capital
					$this->gasto_capital += $financa->valor;
					
				if($financa->categoria->nome == 'gasto_outros') //se gasto outros
					$this->gasto_outros += $financa->valor;
				
				if($financa->categoria->nome == 'gasto_bolsa') //se gasto bolsa
					$this->gasto_bolsa += $financa->valor;
					
				if($financa->categoria->nome == 'verba_custeio') //se verba custeio
					$this->verba_custeio += $financa->valor;
					
				if($financa->categoria->nome == 'verba_capital') //se verba capital
					$this->verba_capital += $financa->valor;
					
				if($financa->categoria->nome == 'verba_outros') //se verba outros
					$this->verba_outros += $financa->valor;
					
				if($financa->categoria->nome == 'verba_bolsa') //se verba bolsa
					$this->verba_bolsa += $financa->valor;
									
			 //endforeach	
			}
			
			//Implementa os gasto capital coms os patrimonios
			$this->gasto_patrimonios = 0;
			foreach ($this->patrimonio_termos as $termo){
				$this->gasto_patrimonios += $termo->valor_total;
			}
			
			//Atualiza os gastos com capital
			$this->gasto_capital += $this->gasto_patrimonios;				
			
			//Calcula o gasto com bolsas e serviços
			foreach ($this->pessoas_recebimento as $recebimento){
				if($recebimento->cod_categoria != 3) //se não for serviço
					$this->gasto_bolsa += $recebimento->valor_total;
				else{
					$this->gasto_servico += $recebimento->valor_total;
				}
			}
			
			
			
			//Calcula gastos com livros
			$this->gasto_livros = 0;
			foreach ($this->livros as $livro){
				$this->gasto_livros += $livro->valor;
			}
			
			//Atualiza gastos com custeio
			$this->gasto_custeio += $this->gasto_servico;
			$this->gasto_custeio += $this->gasto_livros;
			
			
			
		//end calculaGastosVerbas			
	}
	
	/**
	 * 
	 * Retorna os  projetos que acabam em 6 meses 
	 */
	public static function getLasts(){
		$criteria = new CDbCriteria();
		$dataLimite =  date("d/m/Y", mktime(0, 0, 0, date("m") + 6, date("d"), date("Y")));
		$dataAtual = date("d/m/Y");
		$criteria->addCondition("t.data_fim <= '$dataLimite'", 'AND');
		$criteria->addCondition("t.data_fim >= '$dataAtual'", 'AND');
		$criteria->order = 't.data_fim DESC, t.nome ASC';
		return Projeto::model()->findALL($criteria);;
	}
	
	/**
	 * retorna um array de logins permitidos a fazer determinada ação com determinado nível
	 * @param $nivel
	 * @return array $logins[]
	 */
	public function loginsPermitidos($nivel){
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("nivel_permissao >= '$nivel'", 'AND');
		$criteria->addCondition("cod_projeto = '$this->cod_projeto'", 'AND');
		
		$loginsArray = array();
		$pesPermitidas = PermissaoProjeto::model()->findAll($criteria);
		foreach($pesPermitidas as $p){
			$loginsArray[] = $p->pessoa->login;
		}
		return $loginsArray;
		
	}
	
	/**
	 * 
	 * Retorna um array com os logins das pessoas participantes permitidas a ver o projeto
	 * @return array $pessoas_atuantes[]
	 */
	public function pessoasAtuantesToArray(){
		$pessoas = array();
		
		foreach($this->pessoas_atuantes as $p){
			$pessoas[] += $p->login;
		}
		
		return $pessoas;
	}
	
	/**
	 * 
	 * Valida se uma pessoa é responsável em mais de um tipo de categoria (professor, pos, grad)
	 * @param $attribute
	 * @param array $params
	 */
	public function validaResponsavel($attribute,$params){
		if($this->$attribute == $this->$params[0] || $this->$attribute == $this->$params[1])
		 $this->addError($attribute, 'Você deve especificar uma pessoa diferente.');
	}
		
}