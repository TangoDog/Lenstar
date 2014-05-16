<?php

/**
 * This is the model class for table "postop".
 *
 * The followings are the available columns in table 'postop':
 * @property integer $ID
 * @property integer $PatientID
 * @property integer $IOLCalculationID
 * @property string $Surgery_Date
 * @property string $Exam_Date
 * @property string $Eye
 * @property integer $Vision
 * @property integer $UCVA
 * @property double $Sphere
 * @property double $Cylinder
 * @property integer $Axis
 * @property integer $IOL_Implanted
 * @property double $IOL_Power_Implanted
 * @property double $Intended_Sph_Refraction
 * @property double $Sph_Error
 * @property double $Calc_d_ref
 * @property double $FlatK
 * @property double $SteepK
 * @property integer $SteepAxis
 * @property double $Q_ShapeFactor
 * @property double $Pupil
 * @property double $Axial_Length
 * @property integer $CCT
 * @property double $ACD
 * @property double $WTW
 * @property double $STS
 * @property double $STS_d
 * @property double $LensThick
 * @property integer $Biometry
 * @property string $ResearchMarker
 * @property string $ResearchMarker2
 * @property string $keyword1
 * @property integer $keyword2
 * @property integer $UseForOptimization
 * @property integer $Formula
 * @property double $CalcSRK_T
 * @property double $CalcHoll1SF
 * @property double $CalcHofferQ_ACD
 * @property double $CalcSISphere
 * @property double $CalcSIA
 * @property double $CalcSIA_Axis
 * @property double $CalcSIAK
 * @property double $CalcSIAK_Axis
 * @property double $CalcELP
 * @property double $Rc
 * @property double $Rc1
 * @property double $Rc2
 * @property double $Rp
 * @property double $Rp1
 * @property double $Rp2
 * @property double $RpSteepAxis
 * @property integer $SurgeonID
 * @property integer $BaseLensID
 * @property integer $BaseSurgeonID
 * @property double $PreOpSphere
 * @property double $PreOpCylinder
 * @property integer $PreOpAxis
 * @property integer $IolID
 * @property integer $dbowner
 * @property integer $PostRK
 * @property integer $PostLasik
 * @property integer $HyperopicLasikPRK
 * @property integer $PostRefractiveSurgery
 * @property integer $Age
 * @property integer $Meters
 * @property integer $Keratometry
 * @property double $Capsulorhexis
 * @property double $ExtraField1
 * @property double $ExtraField2
 * @property integer $IncisionAxis
 * @property double $IncisionLength
 * @property integer $LRI1Length
 * @property integer $LRI1Axis
 * @property integer $LRI2Axis
 * @property integer $LRI2Length
 * @property double $CylinderPowerAtIOLPlane
 * @property integer $ImplantAxis
 * @property integer $SurgicalInducedAstigmatismEffectAxis
 * @property double $PostopFlatK
 * @property double $PostopSteepK
 * @property integer $PostopAxisK
 * @property integer $PreopID
 * @property double $RetinalThickness
 */
class Postop extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'postop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Exam_Date, UCVA', 'required'),
			array('PatientID, IOLCalculationID, Vision, UCVA, Axis, IOL_Implanted, SteepAxis, CCT, Biometry, keyword2, UseForOptimization, Formula, SurgeonID, BaseLensID, BaseSurgeonID, PreOpAxis, IolID, dbowner, PostRK, PostLasik, HyperopicLasikPRK, PostRefractiveSurgery, Age, Meters, Keratometry, IncisionAxis, LRI1Length, LRI1Axis, LRI2Axis, LRI2Length, ImplantAxis, SurgicalInducedAstigmatismEffectAxis, PostopAxisK, PreopID', 'numerical', 'integerOnly'=>true),
			array('Sphere, Cylinder, IOL_Power_Implanted, Intended_Sph_Refraction, Sph_Error, Calc_d_ref, FlatK, SteepK, Q_ShapeFactor, Pupil, Axial_Length, ACD, WTW, STS, STS_d, LensThick, CalcSRK_T, CalcHoll1SF, CalcHofferQ_ACD, CalcSISphere, CalcSIA, CalcSIA_Axis, CalcSIAK, CalcSIAK_Axis, CalcELP, Rc, Rc1, Rc2, Rp, Rp1, Rp2, RpSteepAxis, PreOpSphere, PreOpCylinder, Capsulorhexis, ExtraField1, ExtraField2, IncisionLength, CylinderPowerAtIOLPlane, PostopFlatK, PostopSteepK, RetinalThickness', 'numerical'),
			array('Eye, ResearchMarker', 'length', 'max'=>255),
			array('ResearchMarker2, keyword1', 'length', 'max'=>50),
			array('Surgery_Date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, PatientID, IOLCalculationID, Surgery_Date, Exam_Date, Eye, Vision, UCVA, Sphere, Cylinder, Axis, IOL_Implanted, IOL_Power_Implanted, Intended_Sph_Refraction, Sph_Error, Calc_d_ref, FlatK, SteepK, SteepAxis, Q_ShapeFactor, Pupil, Axial_Length, CCT, ACD, WTW, STS, STS_d, LensThick, Biometry, ResearchMarker, ResearchMarker2, keyword1, keyword2, UseForOptimization, Formula, CalcSRK_T, CalcHoll1SF, CalcHofferQ_ACD, CalcSISphere, CalcSIA, CalcSIA_Axis, CalcSIAK, CalcSIAK_Axis, CalcELP, Rc, Rc1, Rc2, Rp, Rp1, Rp2, RpSteepAxis, SurgeonID, BaseLensID, BaseSurgeonID, PreOpSphere, PreOpCylinder, PreOpAxis, IolID, dbowner, PostRK, PostLasik, HyperopicLasikPRK, PostRefractiveSurgery, Age, Meters, Keratometry, Capsulorhexis, ExtraField1, ExtraField2, IncisionAxis, IncisionLength, LRI1Length, LRI1Axis, LRI2Axis, LRI2Length, CylinderPowerAtIOLPlane, ImplantAxis, SurgicalInducedAstigmatismEffectAxis, PostopFlatK, PostopSteepK, PostopAxisK, PreopID, RetinalThickness', 'safe', 'on'=>'search'),
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
			'IOLCalculationID' => 'Iolcalculation',
			'Surgery_Date' => 'Surgery Date',
			'Exam_Date' => 'Exam Date',
			'Eye' => 'Eye',
			'Vision' => 'Vision',
			'UCVA' => 'Ucva',
			'Sphere' => 'Sphere',
			'Cylinder' => 'Cylinder',
			'Axis' => 'Axis',
			'IOL_Implanted' => 'Iol Implanted',
			'IOL_Power_Implanted' => 'Iol Power Implanted',
			'Intended_Sph_Refraction' => 'Intended Sph Refraction',
			'Sph_Error' => 'Sph Error',
			'Calc_d_ref' => 'Calc D Ref',
			'FlatK' => 'Flat K',
			'SteepK' => 'Steep K',
			'SteepAxis' => 'Steep Axis',
			'Q_ShapeFactor' => 'Q Shape Factor',
			'Pupil' => 'Pupil',
			'Axial_Length' => 'Axial Length',
			'CCT' => 'Cct',
			'ACD' => 'Acd',
			'WTW' => 'Wtw',
			'STS' => 'Sts',
			'STS_d' => 'Sts D',
			'LensThick' => 'Lens Thick',
			'Biometry' => 'Biometry',
			'ResearchMarker' => 'Research Marker',
			'ResearchMarker2' => 'Research Marker2',
			'keyword1' => 'Keyword1',
			'keyword2' => 'Keyword2',
			'UseForOptimization' => 'Use For Optimization',
			'Formula' => 'Formula',
			'CalcSRK_T' => 'Calc Srk T',
			'CalcHoll1SF' => 'Calc Holl1 Sf',
			'CalcHofferQ_ACD' => 'Calc Hoffer Q Acd',
			'CalcSISphere' => 'Calc Sisphere',
			'CalcSIA' => 'Calc Sia',
			'CalcSIA_Axis' => 'Calc Sia Axis',
			'CalcSIAK' => 'Calc Siak',
			'CalcSIAK_Axis' => 'Calc Siak Axis',
			'CalcELP' => 'Calc Elp',
			'Rc' => 'Rc',
			'Rc1' => 'Rc1',
			'Rc2' => 'Rc2',
			'Rp' => 'Rp',
			'Rp1' => 'Rp1',
			'Rp2' => 'Rp2',
			'RpSteepAxis' => 'Rp Steep Axis',
			'SurgeonID' => 'Surgeon',
			'BaseLensID' => 'Base Lens',
			'BaseSurgeonID' => 'Base Surgeon',
			'PreOpSphere' => 'Pre Op Sphere',
			'PreOpCylinder' => 'Pre Op Cylinder',
			'PreOpAxis' => 'Pre Op Axis',
			'IolID' => 'Iol',
			'dbowner' => 'Dbowner',
			'PostRK' => 'Post Rk',
			'PostLasik' => 'Post Lasik',
			'HyperopicLasikPRK' => 'Hyperopic Lasik Prk',
			'PostRefractiveSurgery' => 'Post Refractive Surgery',
			'Age' => 'Age',
			'Meters' => 'Meters',
			'Keratometry' => 'Keratometry',
			'Capsulorhexis' => 'Capsulorhexis',
			'ExtraField1' => 'Extra Field1',
			'ExtraField2' => 'Extra Field2',
			'IncisionAxis' => 'Incision Axis',
			'IncisionLength' => 'Incision Length',
			'LRI1Length' => 'Lri1 Length',
			'LRI1Axis' => 'Lri1 Axis',
			'LRI2Axis' => 'Lri2 Axis',
			'LRI2Length' => 'Lri2 Length',
			'CylinderPowerAtIOLPlane' => 'Cylinder Power At Iolplane',
			'ImplantAxis' => 'Implant Axis',
			'SurgicalInducedAstigmatismEffectAxis' => 'Surgical Induced Astigmatism Effect Axis',
			'PostopFlatK' => 'Postop Flat K',
			'PostopSteepK' => 'Postop Steep K',
			'PostopAxisK' => 'Postop Axis K',
			'PreopID' => 'Preop',
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
		$criteria->compare('IOLCalculationID',$this->IOLCalculationID);
		$criteria->compare('Surgery_Date',$this->Surgery_Date,true);
		$criteria->compare('Exam_Date',$this->Exam_Date,true);
		$criteria->compare('Eye',$this->Eye,true);
		$criteria->compare('Vision',$this->Vision);
		$criteria->compare('UCVA',$this->UCVA);
		$criteria->compare('Sphere',$this->Sphere);
		$criteria->compare('Cylinder',$this->Cylinder);
		$criteria->compare('Axis',$this->Axis);
		$criteria->compare('IOL_Implanted',$this->IOL_Implanted);
		$criteria->compare('IOL_Power_Implanted',$this->IOL_Power_Implanted);
		$criteria->compare('Intended_Sph_Refraction',$this->Intended_Sph_Refraction);
		$criteria->compare('Sph_Error',$this->Sph_Error);
		$criteria->compare('Calc_d_ref',$this->Calc_d_ref);
		$criteria->compare('FlatK',$this->FlatK);
		$criteria->compare('SteepK',$this->SteepK);
		$criteria->compare('SteepAxis',$this->SteepAxis);
		$criteria->compare('Q_ShapeFactor',$this->Q_ShapeFactor);
		$criteria->compare('Pupil',$this->Pupil);
		$criteria->compare('Axial_Length',$this->Axial_Length);
		$criteria->compare('CCT',$this->CCT);
		$criteria->compare('ACD',$this->ACD);
		$criteria->compare('WTW',$this->WTW);
		$criteria->compare('STS',$this->STS);
		$criteria->compare('STS_d',$this->STS_d);
		$criteria->compare('LensThick',$this->LensThick);
		$criteria->compare('Biometry',$this->Biometry);
		$criteria->compare('ResearchMarker',$this->ResearchMarker,true);
		$criteria->compare('ResearchMarker2',$this->ResearchMarker2,true);
		$criteria->compare('keyword1',$this->keyword1,true);
		$criteria->compare('keyword2',$this->keyword2);
		$criteria->compare('UseForOptimization',$this->UseForOptimization);
		$criteria->compare('Formula',$this->Formula);
		$criteria->compare('CalcSRK_T',$this->CalcSRK_T);
		$criteria->compare('CalcHoll1SF',$this->CalcHoll1SF);
		$criteria->compare('CalcHofferQ_ACD',$this->CalcHofferQ_ACD);
		$criteria->compare('CalcSISphere',$this->CalcSISphere);
		$criteria->compare('CalcSIA',$this->CalcSIA);
		$criteria->compare('CalcSIA_Axis',$this->CalcSIA_Axis);
		$criteria->compare('CalcSIAK',$this->CalcSIAK);
		$criteria->compare('CalcSIAK_Axis',$this->CalcSIAK_Axis);
		$criteria->compare('CalcELP',$this->CalcELP);
		$criteria->compare('Rc',$this->Rc);
		$criteria->compare('Rc1',$this->Rc1);
		$criteria->compare('Rc2',$this->Rc2);
		$criteria->compare('Rp',$this->Rp);
		$criteria->compare('Rp1',$this->Rp1);
		$criteria->compare('Rp2',$this->Rp2);
		$criteria->compare('RpSteepAxis',$this->RpSteepAxis);
		$criteria->compare('SurgeonID',$this->SurgeonID);
		$criteria->compare('BaseLensID',$this->BaseLensID);
		$criteria->compare('BaseSurgeonID',$this->BaseSurgeonID);
		$criteria->compare('PreOpSphere',$this->PreOpSphere);
		$criteria->compare('PreOpCylinder',$this->PreOpCylinder);
		$criteria->compare('PreOpAxis',$this->PreOpAxis);
		$criteria->compare('IolID',$this->IolID);
		$criteria->compare('dbowner',$this->dbowner);
		$criteria->compare('PostRK',$this->PostRK);
		$criteria->compare('PostLasik',$this->PostLasik);
		$criteria->compare('HyperopicLasikPRK',$this->HyperopicLasikPRK);
		$criteria->compare('PostRefractiveSurgery',$this->PostRefractiveSurgery);
		$criteria->compare('Age',$this->Age);
		$criteria->compare('Meters',$this->Meters);
		$criteria->compare('Keratometry',$this->Keratometry);
		$criteria->compare('Capsulorhexis',$this->Capsulorhexis);
		$criteria->compare('ExtraField1',$this->ExtraField1);
		$criteria->compare('ExtraField2',$this->ExtraField2);
		$criteria->compare('IncisionAxis',$this->IncisionAxis);
		$criteria->compare('IncisionLength',$this->IncisionLength);
		$criteria->compare('LRI1Length',$this->LRI1Length);
		$criteria->compare('LRI1Axis',$this->LRI1Axis);
		$criteria->compare('LRI2Axis',$this->LRI2Axis);
		$criteria->compare('LRI2Length',$this->LRI2Length);
		$criteria->compare('CylinderPowerAtIOLPlane',$this->CylinderPowerAtIOLPlane);
		$criteria->compare('ImplantAxis',$this->ImplantAxis);
		$criteria->compare('SurgicalInducedAstigmatismEffectAxis',$this->SurgicalInducedAstigmatismEffectAxis);
		$criteria->compare('PostopFlatK',$this->PostopFlatK);
		$criteria->compare('PostopSteepK',$this->PostopSteepK);
		$criteria->compare('PostopAxisK',$this->PostopAxisK);
		$criteria->compare('PreopID',$this->PreopID);
		$criteria->compare('RetinalThickness',$this->RetinalThickness);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Postop the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
