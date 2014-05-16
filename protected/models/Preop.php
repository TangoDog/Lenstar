<?php

/**
 * This is the model class for table "preop".
 *
 * The followings are the available columns in table 'preop':
 * @property integer $ID
 * @property integer $PatientID
 * @property integer $Technician
 * @property integer $Office
 * @property string $Eye
 * @property integer $Vision
 * @property double $Sphere
 * @property double $Cylinder
 * @property integer $Axis
 * @property double $FlatK
 * @property double $SteepK
 * @property integer $SteepAxis
 * @property double $Q_ShapeFactor
 * @property double $Pupil
 * @property double $Axial_Length
 * @property integer $CCT
 * @property double $ACD
 * @property double $LensThick
 * @property double $WTW
 * @property double $STS
 * @property integer $Biometry
 * @property string $ResearchMarker
 * @property integer $UseForCalculation
 * @property double $PlannedRefraction
 * @property integer $Keratometry
 * @property integer $RK
 * @property integer $PRK_Lasik
 * @property integer $HyperopicLasikPRK
 * @property integer $PostRefractiveSurgery
 * @property double $ELP
 * @property double $STS_d
 * @property double $Rc
 * @property double $Rc1
 * @property double $Rc2
 * @property double $Rp
 * @property double $Rp1
 * @property double $Rp2
 * @property double $RpSteepAxis
 * @property string $PlanSurgeryDate
 * @property integer $dbowner
 * @property integer $Meters
 * @property double $Capsulorhexis
 * @property double $ExtraField1
 * @property double $ExtraField2
 * @property integer $IncisionAxis
 * @property double $IncisionLength
 * @property integer $LRI1Length
 * @property integer $LRI1Axis
 * @property integer $LRI2Axis
 * @property integer $LRI2Length
 * @property string $TS
 * @property string $ExamDateTime
 * @property double $RetinalThickness
 */
class Preop extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'preop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TS', 'required'),
			array('PatientID, Technician, Office, Vision, Axis, SteepAxis, CCT, Biometry, UseForCalculation, Keratometry, RK, PRK_Lasik, HyperopicLasikPRK, PostRefractiveSurgery, dbowner, Meters, IncisionAxis, LRI1Length, LRI1Axis, LRI2Axis, LRI2Length', 'numerical', 'integerOnly'=>true),
			array('Sphere, Cylinder, FlatK, SteepK, Q_ShapeFactor, Pupil, Axial_Length, ACD, LensThick, WTW, STS, PlannedRefraction, ELP, STS_d, Rc, Rc1, Rc2, Rp, Rp1, Rp2, RpSteepAxis, Capsulorhexis, ExtraField1, ExtraField2, IncisionLength, RetinalThickness', 'numerical'),
			array('Eye', 'length', 'max'=>2),
			array('ResearchMarker', 'length', 'max'=>50),
			array('PlanSurgeryDate, ExamDateTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, PatientID, Technician, Office, Eye, Vision, Sphere, Cylinder, Axis, FlatK, SteepK, SteepAxis, Q_ShapeFactor, Pupil, Axial_Length, CCT, ACD, LensThick, WTW, STS, Biometry, ResearchMarker, UseForCalculation, PlannedRefraction, Keratometry, RK, PRK_Lasik, HyperopicLasikPRK, PostRefractiveSurgery, ELP, STS_d, Rc, Rc1, Rc2, Rp, Rp1, Rp2, RpSteepAxis, PlanSurgeryDate, dbowner, Meters, Capsulorhexis, ExtraField1, ExtraField2, IncisionAxis, IncisionLength, LRI1Length, LRI1Axis, LRI2Axis, LRI2Length, TS, ExamDateTime, RetinalThickness', 'safe', 'on'=>'search'),
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
			'PatientID' => 'Patient',
			'Technician' => 'Technician',
			'Office' => 'Office',
			'Eye' => 'Eye',
			'Vision' => 'Vision',
			'Sphere' => 'Sphere',
			'Cylinder' => 'Cylinder',
			'Axis' => 'Axis',
			'FlatK' => 'Flat K',
			'SteepK' => 'Steep K',
			'SteepAxis' => 'Steep Axis',
			'Q_ShapeFactor' => 'Q Shape Factor',
			'Pupil' => 'Pupil',
			'Axial_Length' => 'Axial Length',
			'CCT' => 'Cct',
			'ACD' => 'Acd',
			'LensThick' => 'Lens Thick',
			'WTW' => 'Wtw',
			'STS' => 'Sts',
			'Biometry' => 'Biometry',
			'ResearchMarker' => 'Research Marker',
			'UseForCalculation' => 'Use For Calculation',
			'PlannedRefraction' => 'Planned Refraction',
			'Keratometry' => 'Keratometry',
			'RK' => 'Rk',
			'PRK_Lasik' => 'Prk Lasik',
			'HyperopicLasikPRK' => 'Hyperopic Lasik Prk',
			'PostRefractiveSurgery' => 'Post Refractive Surgery',
			'ELP' => 'Elp',
			'STS_d' => 'Sts D',
			'Rc' => 'Rc',
			'Rc1' => 'Rc1',
			'Rc2' => 'Rc2',
			'Rp' => 'Rp',
			'Rp1' => 'Rp1',
			'Rp2' => 'Rp2',
			'RpSteepAxis' => 'Rp Steep Axis',
			'PlanSurgeryDate' => 'Plan Surgery Date',
			'dbowner' => 'Dbowner',
			'Meters' => 'Meters',
			'Capsulorhexis' => 'Capsulorhexis',
			'ExtraField1' => 'Extra Field1',
			'ExtraField2' => 'Extra Field2',
			'IncisionAxis' => 'Incision Axis',
			'IncisionLength' => 'Incision Length',
			'LRI1Length' => 'Lri1 Length',
			'LRI1Axis' => 'Lri1 Axis',
			'LRI2Axis' => 'Lri2 Axis',
			'LRI2Length' => 'Lri2 Length',
			'TS' => 'Ts',
			'ExamDateTime' => 'Exam Date Time',
			'RetinalThickness' => 'Retinal Thickness',
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
		$criteria->compare('PatientID',$this->PatientID);
		$criteria->compare('Technician',$this->Technician);
		$criteria->compare('Office',$this->Office);
		$criteria->compare('Eye',$this->Eye,true);
		$criteria->compare('Vision',$this->Vision);
		$criteria->compare('Sphere',$this->Sphere);
		$criteria->compare('Cylinder',$this->Cylinder);
		$criteria->compare('Axis',$this->Axis);
		$criteria->compare('FlatK',$this->FlatK);
		$criteria->compare('SteepK',$this->SteepK);
		$criteria->compare('SteepAxis',$this->SteepAxis);
		$criteria->compare('Q_ShapeFactor',$this->Q_ShapeFactor);
		$criteria->compare('Pupil',$this->Pupil);
		$criteria->compare('Axial_Length',$this->Axial_Length);
		$criteria->compare('CCT',$this->CCT);
		$criteria->compare('ACD',$this->ACD);
		$criteria->compare('LensThick',$this->LensThick);
		$criteria->compare('WTW',$this->WTW);
		$criteria->compare('STS',$this->STS);
		$criteria->compare('Biometry',$this->Biometry);
		$criteria->compare('ResearchMarker',$this->ResearchMarker,true);
		$criteria->compare('UseForCalculation',$this->UseForCalculation);
		$criteria->compare('PlannedRefraction',$this->PlannedRefraction);
		$criteria->compare('Keratometry',$this->Keratometry);
		$criteria->compare('RK',$this->RK);
		$criteria->compare('PRK_Lasik',$this->PRK_Lasik);
		$criteria->compare('HyperopicLasikPRK',$this->HyperopicLasikPRK);
		$criteria->compare('PostRefractiveSurgery',$this->PostRefractiveSurgery);
		$criteria->compare('ELP',$this->ELP);
		$criteria->compare('STS_d',$this->STS_d);
		$criteria->compare('Rc',$this->Rc);
		$criteria->compare('Rc1',$this->Rc1);
		$criteria->compare('Rc2',$this->Rc2);
		$criteria->compare('Rp',$this->Rp);
		$criteria->compare('Rp1',$this->Rp1);
		$criteria->compare('Rp2',$this->Rp2);
		$criteria->compare('RpSteepAxis',$this->RpSteepAxis);
		$criteria->compare('PlanSurgeryDate',$this->PlanSurgeryDate,true);
		$criteria->compare('dbowner',$this->dbowner);
		$criteria->compare('Meters',$this->Meters);
		$criteria->compare('Capsulorhexis',$this->Capsulorhexis);
		$criteria->compare('ExtraField1',$this->ExtraField1);
		$criteria->compare('ExtraField2',$this->ExtraField2);
		$criteria->compare('IncisionAxis',$this->IncisionAxis);
		$criteria->compare('IncisionLength',$this->IncisionLength);
		$criteria->compare('LRI1Length',$this->LRI1Length);
		$criteria->compare('LRI1Axis',$this->LRI1Axis);
		$criteria->compare('LRI2Axis',$this->LRI2Axis);
		$criteria->compare('LRI2Length',$this->LRI2Length);
		$criteria->compare('TS',$this->TS,true);
		$criteria->compare('ExamDateTime',$this->ExamDateTime,true);
		$criteria->compare('RetinalThickness',$this->RetinalThickness);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Preop the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
