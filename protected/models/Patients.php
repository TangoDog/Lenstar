<?php

/**
 * This is the model class for table "patients".
 *
 * The followings are the available columns in table 'patients':
 * @property integer $ID
 * @property string $ChartID
 * @property string $LastName
 * @property string $FirstName
 * @property string $MI
 * @property string $BirthDate
 * @property string $Sex
 * @property string $Ethnicity
 * @property string $EntryDate
 * @property integer $Surgeon
 * @property integer $Office
 * @property string $Phone
 * @property integer $Referral
 * @property integer $CalcRightEye
 * @property integer $CalcLeftEye
 * @property integer $dbowner
 */
class Patients extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'patients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Ethnicity, EntryDate', 'required'),
			array('Surgeon, Office, Referral, CalcRightEye, CalcLeftEye, dbowner', 'numerical', 'integerOnly'=>true),
			array('ChartID', 'length', 'max'=>20),
			array('LastName, FirstName, MI, Phone', 'length', 'max'=>255),
			array('Sex', 'length', 'max'=>1),
			array('Ethnicity', 'length', 'max'=>10),
			array('BirthDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, ChartID, LastName, FirstName, MI, BirthDate, Sex, Ethnicity, EntryDate, Surgeon, Office, Phone, Referral, CalcRightEye, CalcLeftEye, dbowner', 'safe', 'on'=>'search'),
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
			'ID' => 'ID',
			'ChartID' => 'Chart',
			'LastName' => 'Last Name',
			'FirstName' => 'First Name',
			'MI' => 'Mi',
			'BirthDate' => 'Birth Date',
			'Sex' => 'Sex',
			'Ethnicity' => 'Ethnicity',
			'EntryDate' => 'Entry Date',
			'Surgeon' => 'Surgeon',
			'Office' => 'Office',
			'Phone' => 'Phone',
			'Referral' => 'Referral',
			'CalcRightEye' => 'Calc Right Eye',
			'CalcLeftEye' => 'Calc Left Eye',
			'dbowner' => 'Dbowner',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('ChartID',$this->ChartID,true);
		$criteria->compare('LastName',$this->LastName,true);
		$criteria->compare('FirstName',$this->FirstName,true);
		$criteria->compare('MI',$this->MI,true);
		$criteria->compare('BirthDate',$this->BirthDate,true);
		$criteria->compare('Sex',$this->Sex,true);
		$criteria->compare('Ethnicity',$this->Ethnicity,true);
		$criteria->compare('EntryDate',$this->EntryDate,true);
		$criteria->compare('Surgeon',$this->Surgeon);
		$criteria->compare('Office',$this->Office);
		$criteria->compare('Phone',$this->Phone,true);
		$criteria->compare('Referral',$this->Referral);
		$criteria->compare('CalcRightEye',$this->CalcRightEye);
		$criteria->compare('CalcLeftEye',$this->CalcLeftEye);
		$criteria->compare('dbowner',$this->dbowner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Patients the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
