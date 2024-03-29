<?php

/**
 * This is the model class for table "atividade_financeiro".
 *
 * The followings are the available columns in table 'atividade_financeiro':
 * @property integer $cod_atividade
 * @property integer $cod_financeiro
 */
class AtividadeFinanceiro extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AtividadeFinanceiro the static model class
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
		return 'atividade_financeiro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod_atividade, cod_financeiro', 'required'),
			array('cod_atividade, cod_financeiro', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cod_atividade, cod_financeiro', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cod_atividade' => 'Cod Atividade',
			'cod_financeiro' => 'Cod Financeiro',
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
		$criteria->compare('cod_financeiro',$this->cod_financeiro);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}