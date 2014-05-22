<?php

/**
 * This is the model class for table "xmlUpload".
 *
 * The followings are the available columns in table 'xmlUpload':
 * @property integer $id
 * @property string $xmlFile
 * @property string $created_at
 * @property string $updated_at
 * @property string $lastName
 * @property string $firstName
 * @property string $mi
 * @property string $birthDate
 * @property string $chartID
 * @property string $ethnicity
 * @property string $thisUser
 * @property string $thisPwd
 * @property integer $technician
 * @property integer $surgeon
 * @property integer $dbowner
 * @property integer $office
 * @property string $preop
 * @property string $postop
 * @property integer $user_id
 */
class XmlUpload extends CActiveRecord
{
	/**
         * override __construct of CActiveRecord
         * get the xml file sent to this script
         * parse the file, login, set values of the XmlUpload ActiveRecord modeld
         * 
         *          
         * 
         */
//         public function __construct() {
//             Yii::trace('Entering xmlFile.__construct','application.models.xmlFile');
//             parent::__construct();
//         }
         
         public function uploadPreop() {
             Yii::trace('Entering xmlFile.uploadPreop','application.models.XmlUpload');
             if (isset($_FILES['file']['tmp_name'])) {
                        Yii::trace('$_FILES is set','application.models.xmlFile');
 
                        $upload = $_FILES['file']['tmp_name'];

                        $xml = file_get_contents($upload);
                        $this->xmlFile = simplexml_load_string($xml); 
                        var_dump($this->xmlFile);
             } else  {
                 Yii::log('Error in $xmlFile::__construct','Error','app.models.xmlFile');
                 throw new Exception('No File Uploaded- Process halted');
             }           
         }

         /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'xmlUpload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('xmlFile, created_at, updated_at, lastName, firstName, mi, birthDate, chartID, ethnicity, thisUser, thisPwd, technician, surgeon, dbowner, office, preop, postop, user_id', 'required'),
			array('technician, surgeon, dbowner, office, user_id', 'numerical', 'integerOnly'=>true),
			array('lastName, firstName', 'length', 'max'=>100),
			array('mi', 'length', 'max'=>2),
			array('chartID, ethnicity, thisUser', 'length', 'max'=>20),
			array('thisPwd', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, xmlFile, created_at, updated_at, lastName, firstName, mi, birthDate, chartID, ethnicity, thisUser, thisPwd, technician, surgeon, dbowner, office, preop, postop, user_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'xmlFile' => 'Xml File',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'lastName' => 'Last Name',
			'firstName' => 'First Name',
			'mi' => 'Mi',
			'birthDate' => 'Birth Date',
			'chartID' => 'Chart',
			'ethnicity' => 'Ethnicity',
			'thisUser' => 'This User',
			'thisPwd' => 'This Pwd',
			'technician' => 'Technician',
			'surgeon' => 'Surgeon',
			'dbowner' => 'Dbowner',
			'office' => 'Office',
			'preop' => 'Preop',
			'postop' => 'Postop',
			'user_id' => 'User',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('xmlFile',$this->xmlFile,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('mi',$this->mi,true);
		$criteria->compare('birthDate',$this->birthDate,true);
		$criteria->compare('chartID',$this->chartID,true);
		$criteria->compare('ethnicity',$this->ethnicity,true);
		$criteria->compare('thisUser',$this->thisUser,true);
		$criteria->compare('thisPwd',$this->thisPwd,true);
		$criteria->compare('technician',$this->technician);
		$criteria->compare('surgeon',$this->surgeon);
		$criteria->compare('dbowner',$this->dbowner);
		$criteria->compare('office',$this->office);
		$criteria->compare('preop',$this->preop,true);
		$criteria->compare('postop',$this->postop,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return XmlUpload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
