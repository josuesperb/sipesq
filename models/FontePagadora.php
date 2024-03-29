<?php

/**
 * This is the model class for table "fonte_pagadora".
 *
 * The followings are the available columns in table 'fonte_pagadora':
 * @property integer $cod_fonte_pagadora
 * @property string $nome
 * @property string $descricao
 *
 * The followings are the available model relations:
 * @property PessoaFinanceiro[] $pessoaFinanceiros
 */
class FontePagadora extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FontePagadora the static model class
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
		return 'fonte_pagadora';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome', 'required'),
			array('descricao', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cod_fonte_pagadora, nome, descricao', 'safe', 'on'=>'search'),
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
			'pessoaFinanceiros' => array(self::HAS_MANY, 'PessoaFinanceiro', 'cod_fonte_pagadora'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cod_fonte_pagadora' => 'Cod Fonte Pagadora',
			'nome' => 'Nome da Fonte Pagadora',
			'descricao' => 'Descrição',
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

		$criteria->compare('cod_fonte_pagadora',$this->cod_fonte_pagadora);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('descricao',$this->descricao,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}