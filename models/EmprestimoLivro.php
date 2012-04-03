<?php

/**
 * This is the model class for table "emprestimo_livro".
 *
 * The followings are the available columns in table 'emprestimo_livro':
 * @property integer $cod_livro
 * @property string $data_retirada
 * @property string $data_devolucao
 * @property integer $cod_pessoa
 *
 * The followings are the available model relations:
 * @property Livro $livro
 * @property Pessoa $pessoa
 */
class EmprestimoLivro extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmprestimoLivro the static model class
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
		return 'emprestimo_livro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod_livro, data_retirada, cod_pessoa', 'required'),
			array('cod_livro, cod_pessoa', 'numerical', 'integerOnly'=>true),
			array('data_devolucao', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cod_livro, data_retirada, data_devolucao, cod_pessoa', 'safe', 'on'=>'search'),
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
			'livro' => array(self::BELONGS_TO, 'Livro', 'cod_livro'),
			'pessoa' => array(self::BELONGS_TO, 'Pessoa', 'cod_pessoa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cod_livro' => 'Cod Livro',
			'data_retirada' => 'Data Retirada',
			'data_devolucao' => 'Data Devolucao',
			'cod_pessoa' => 'Cod Pessoa',
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

		$criteria->compare('cod_livro',$this->cod_livro);
		$criteria->compare('data_retirada',$this->data_retirada,true);
		$criteria->compare('data_devolucao',$this->data_devolucao,true);
		$criteria->compare('cod_pessoa',$this->cod_pessoa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}