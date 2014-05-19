<?php

/**
 * This is the model class for table "operatorprefs".
 *
 * The followings are the available columns in table 'operatorprefs':
 * @property integer $ID
 * @property string $Name
 * @property double $EntryErrToleranceSdev
 * @property integer $Validate
 * @property string $EMail
 * @property string $Password
 * @property double $glblTolerance
 * @property integer $group
 * @property integer $dbowner
 * @property integer $CreatorID
 * @property string $groupID
 * @property string $guid
 */
class Operatorprefs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operatorprefs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, CreatorID', 'required'),
			array(' group, dbowner, CreatorID, jumpPreop', 'numerical', 'integerOnly'=>true),
			array('EntryErrToleranceSdev, glblTolerance', 'numerical'),
			array('Name, EMail, Password', 'length', 'max'=>255),
			array('groupID', 'length', 'max'=>20),
			array('guid', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('ID, Name, Hints, Meters, Prefer_ShapeFactor, EntryErrToleranceSdev, Validate, EMail, Password, glblTolerance, preferLattice, preferGGPlot, preferLattice2, group, dbowner, CreatorID, groupID, jumpPreop, guid', 'safe', 'on'=>'search'),
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
			'Name' => 'Name',
			'Hints' => 'Hints',
			'Meters' => 'Meters',
			'Prefer_ShapeFactor' => 'Prefer Shape Factor',
			'EntryErrToleranceSdev' => 'Entry Err Tolerance Sdev',
			'Validate' => 'Validate',
			'EMail' => 'Email',
			'Password' => 'Password',
			'glblTolerance' => 'Glbl Tolerance',
			'preferLattice' => 'Prefer Lattice',
			'preferGGPlot' => 'Prefer Ggplot',
			'preferLattice2' => 'Prefer Lattice2',
			'group' => 'Group',
			'dbowner' => 'Dbowner',
			'CreatorID' => 'Creator',
			'groupID' => 'Group',
			'jumpPreop' => 'Jump Preop',
			'guid' => 'Guid',
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
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('guid',$this->guid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Operatorprefs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
