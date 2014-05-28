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
 * @property string $sex
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
    private function emptyToNull($val) {
                return(empty($val)?'NULL':$val);
            }
    private function dashToNull($value) {return ( is_numeric($value)? $value :'NULL');}
    private function getFirstNameMI($FirstName){
        $space = strpos($FirstName," ");
            if ($space!=false) {  // there is a middle initial 
                    $FirstName1 = strrev( strchr(strrev($FirstName)," ") );  //ABE J. => .J EBA
                    //print_r('FirstName1: '.$FirstName1."\n");
                    $FirstName1 = str_ireplace(".","",$FirstName1);
                    //print_r('FirstName1: '.$FirstName1."\n");
                    $FirstName1 = str_ireplace(" ","",$FirstName1);
                    //print_r('FirstName1: '.$FirstName1."\n");
                    $FirstName1 = htmlspecialchars(strip_tags($FirstName1));
                    //print_r('FirstName1: '.$FirstName1."\n");

                    $Mi2 =  strstr($FirstName," ") ;  // gives false if no space, or space plus rest  --like " S." if exists
                    if ($Mi2) $Mi = str_ireplace(" ","",$Mi2);
                    $Mi = str_ireplace(".","",$Mi);  // remove periods
                    $Mi = str_ireplace(",","",$Mi);  // remove commas
                    //print_r( "MI = ".$Mi ."\n");
                    $FirstName = $FirstName1;
                    return(array('FirstName'=>$FirstName,
                                 'Mi'       =>$Mi,
                        ));
            } // do not change and don't strip out the Middle Init
    }
           
        public function uploadPreop() {
             Yii::trace('Entering xmlFile.uploadPreop','application.models.XmlUpload');
             $xml = simplexml_load_file('/var/www/lenstar/LensStar.XML');
 //            if (isset($_FILES['file']['tmp_name'])) {
 //                       Yii::trace('$_FILES is set','application.models.xmlFile');
 
                        //$upload = $xml;// $_FILES['file']['tmp_name'];

                        //$xml = file_get_contents($upload);
                        $this->xmlFile = $xml;//simplexml_load_string($xml); 
                        //$this->lastName = $xml->
                        // echo var_dump($this->xmlFile);
//             } else  {
//                 Yii::log('Error in $xmlFile::__construct','Error','app.models.xmlFile');
//                 throw new Exception('No File Uploaded- Process halted');
//             }           
         }
        public function xmlLogin() {
    
		$model2=new LoginForm;

		

		// collect user input data
		$model2->username = $this->thisUser;
                $model2->password = $this->thisPwd;  // in the model this will be the guid, not the password
                // the password field in the XML file is really the user's guid
                // we don't want passwords here for a lot of reasons - security and also if user changes password

			// validate user input 
		if($model2->validate() && $model2->login()) {
		  return true;		
		}
                else return false;
	}
        

        public function setPatient() {
       // if (isset($this->xmlFile)){
                //$this->DateTime = new DateTime('NOW');
                $now =  new DateTime('NOW');
                $format = 'Y-m-d H:i:s';
                $this->created_at =$now->format($format);  // could do this as a behavior
                $this->updated_at = $this->created_at;
                $this->preop='';
                $this->postop='';        
                //Yii::trace($this->created_at->format('c')); // ISO8601 formated datetime
                Yii::trace($this->created_at); // ISO8601 formated datetime
                //$result_array = json_decode($json_string, TRUE);
                $this->chartID = (string) $this->xmlFile->Patient['ID'];
                Yii::trace('Lenstar PatientID: '.$this->chartID);
                $this->lastName = $this->xmlFile->Patient['LastName'];
                $this->lastName = str_ireplace(".","",$this->lastName);
                $this->lastName = str_ireplace(" ","",$this->lastName);
                $this->lastName = CHtml::encode(strip_tags($this->lastName)); //removes offensive tags
                Yii::trace('LastName: '.$this->lastName."");

                $this->firstName = (string) $this->xmlFile->Patient['FirstName'];
                Yii::trace('firstName: '.$this->firstName);

                // strip off any MI
                $this->mi = "";
                // find a space -
                //Yii::trace('firstName: '.$this->firstName."\n");
                $firstNameMI = $this->getfirstNameMI($this->firstName);
                if (isset($firstNameMI)) {
                    $this->firstName =  $firstNameMI[0];           
                    $this->mi =  $firstNameMI[1];  
                }
                $this->chartID = (string) $this->xmlFile->Patient['ID'];

                $this->birthDate = (string) $this->xmlFile->Patient['Birthday'];
                $this->ethnicity = (string) $this->xmlFile->Patient['Ethnicity'];
                $this->sex = (string) $this->xmlFile->Patient['Sex'];
                $this->sex = strtoupper(substr($this->sex, 0, 1));
                $this->thisUser = (string) $this->xmlFile->Login['User'];
                $this->thisPwd = (string) $this->xmlFile->Login['Pwd'];
                $this->technician=(string) $this->xmlFile->Login['Technician'];
                $this->office=(string) $this->xmlFile->Login['Office'];
                $this->surgeon = (string) $this->xmlFile->Login['Surgeon'];
                $this->dbowner = (string) $this->xmlFile->Login['dbowner'];
                return(true);
     //   }
      // else return(false);

    }
        /*
         * create New Patient and store data - of if patient exists (like in postop) get PKID and moveon
         */
        public function storePatient() {
            // first check to see if patient exists
            $pt = new Patient();
            $pt->ChartID = $this->chartID;
            $pt->LastName = $this->lastName;
            $pt->FirstName = $this->firstName;
            $pt->BirthDate = $this->birthDate;
            $pt->dbowner = $this->dbowner;
            $pat = Patient::model()->findByAttributes(array('ChartID'=>$this->chartID,'dbowner'=>$this->dbowner));
            if (isset($pat)) {
                // patient found by ChartID and dbowner
                // get the PatID for the Preop stuff
                // will always assume to add new preops (postops are updated)
                $PatID = $pat['ID'];
                //$preop = new Preop();
                
                return $PatID;
            }
            $pat = Patient::model()->findByAttributes(
               array('LastName'=>$this->lastName,
              'FirstName'=>$this->firstName,
              'BirthDate'=>$this->birthDate,
              'dbowner'=>$this->dbowner));
            if (isset($pat)) {
                // patient found by ChartID and dbowner
               $PatID = $pat['ID'];
                //$preop = new Preop();
                
                return $PatID;   
            }
            // no patient found
            $pat = new Patient();
            $pat->ChartID = $this->chartID;
            $pat->LastName = $this->lastName;
            $pat->FirstName = $this->firstName;
            $pat->BirthDate = $this->birthDate;
            $pat->dbowner = $this->dbowner;
            $pat->Sex = $this->sex;
            $pat->Ethnicity = $this->ethnicity;
            $pat->EntryDate = $this->created_at;
            $pat->Surgeon = $this->surgeon;
            $pat->Office = $this->office;
            if ($pat->save()) {
                $pat->ID = Yii::app()->db->lastInsertID;
                return $pat->ID;
            }
     
        }
        
        /**
         * storePreop - creates the preop record from xml preop($num,$patid) and inserts it in the database
         * always assumes you will insert a new preop from the data
         */
        public function storePreop($num,$pat_id){
            $preop = new Preop();
            $preop->ID = $pat_id;
            if (isset($this->xmlFile->Patient->Exam[$num])) {
                $json_string = json_encode($this->xmlFile ->Patient->Exam[$num]);
                // the string looks like this - need to remove {"@attributes: and closing "}"

        //{"@attributes":{"Eye":"OD","Time":"2013\/07\/25 13:40","MeasurementMode":"Phakic","R1":"8.13","R2":"7.74","R1Axis":"97","FlatK1":"41.50","SteepK1":"43.61","Astigmatism":"2.12 ","AxisAstig":"7","n":"1.3375","CCT":"567","AD":"2.99","LT":"4.62","AL":"26.42","WTW":"12.31","Pupil":"-----"}}

                $result_array =  substr_replace($json_string, '', $start=0,$length=15);
                $result_array =  substr_replace($result_array, '', $start=-1);

                $result_array = json_decode($result_array, TRUE);
                Yii::trace('Exam['.$num.'] = '. CVarDumper::dump($result_array));
                if (count($result_array)>0){  // insert this record

                    $findLensStar = "Select ID from keratometry where dbowner=".$this->dbowner." and `Keratometry` like 'LenStar%'";
                    $findLensStarCMD = Yii::app()->db->createCommand($findLensStar);
                    $KeraID = $findLensStarCMD->queryScalar();


        // this should be added to the LenStar XML file

                    $AvgRc = ($result_array['R1']+$result_array['R2'])/2;
                    $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,dbowner,Keratometry)";
                    $preopInsert .=" values (".$pat_id.",". $this->technician.",".$this->office.",'".$result_array['Eye']."',".$result_array['FlatK1'];
                    $preopInsert .=",".$result_array['SteepK1'].",".$result_array['AxisAstig'].",".$result_array['AL'];
                    $preopInsert .=",".$this->dashToNull($result_array['CCT']).",".$this->dashToNull($result_array['ACD']).",".$this->dashToNull($result_array['LT']).",".$this->dashToNull($result_array['WTW']).",13,".$AvgRc.",CONVERT('".$result_array['Time']."',datetime),".$this->dbowner.",".$KeraID.")";
                    //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array
                    Yii::trace($preopInsert);
                    $insertCMD =  Yii::app()->db->createCommand( $preopInsert);
                    try {
                     $inserted = $insertCMD->execute();
                    }
                    catch (PDOException $e) {
                        Yii::trace('PDOexception'.$e->getMessage(),'XmlUpload.storePreop','error');
                    }
                    
                    if ($inserted){
                       Yii::trace("Data".$num." Insertion succeeded");
                    }
                    else Yii::trace("Data".$num." Insertion failed") ;
                } //(count($result_array)>0)
            } //(isset($xml->Patient->Exam[$num]))
            
        }  // end function storePreop($num,$pat_id)

      public function storePostop($num,$pat_id){
              $preop = new Preop();
            $preop->ID = $pat_id;
            if (isset($this->xmlFile->Patient->Exam[$num])) {
                $json_string = json_encode($this->xmlFile ->Patient->Exam[$num]);
                // the string looks like this - need to remove {"@attributes: and closing "}"

        //{"@attributes":{"Eye":"OD","Time":"2013\/07\/25 13:40","MeasurementMode":"Phakic","R1":"8.13","R2":"7.74","R1Axis":"97","FlatK1":"41.50","SteepK1":"43.61","Astigmatism":"2.12 ","AxisAstig":"7","n":"1.3375","CCT":"567","AD":"2.99","LT":"4.62","AL":"26.42","WTW":"12.31","Pupil":"-----"}}

                $result_array =  substr_replace($json_string, '', $start=0,$length=15);
                $result_array =  substr_replace($result_array, '', $start=-1);

                $result_array = json_decode($result_array, TRUE);
                Yii::trace('Exam['.$num.'] = '. CVarDumper::dump($result_array));
                if (count($result_array)>0){  // insert this record

                    $findLensStar = "Select ID from keratometry where dbowner=".$this->dbowner." and `Keratometry` like 'LenStar%'";
                    $findLensStarCMD = Yii::app()->db->createCommand($findLensStar);
                    $KeraID = $findLensStarCMD->queryScalar();


                    if (is_numeric($result_array['R1']) && is_numeric($result_array['R1']))
                                $AvgRc = ($result_array['R1']+$result_array['R2'])/2;
                    else $AvgRC = 'NULL';
                    // now check if this postop exists (created from IOLCalc page)
		    $findPostOp = "Select * from postop where PatientID = ".$pat_id ." AND Eye='".$result_array['Eye']."'"; 
//                    //// this should exist if postop was created from template
//                    //$postops = mysqli_query($conn, $findPostOp);
//                    //Yii::trace($findPostOp,'application.xmlUpload.storePostop','trace');
                    $findPostOpCMD =  Yii::app()->db->createCommand( $findPostOp);
                    $postops = $findPostOpCMD->queryRow();
		    if ($postops) {  // record exists
////					preprint('Entering Update Postop');
                            $postopUpdate = "UPDATE postop set `PostopFlatK` = ".$this->dashToNull($result_array['FlatK1']).",`PostopSteepK` = ".$this->dashToNull($result_array['SteepK1']).",`PostopAxisK` = ".$this->dashToNull($result_array['AxisAstig']);
                            $postopUpdate .= " Where postop.ID = ".$postops['ID'];
//                            Yii:trace($postopUpdate,'application.xmlUpload.updatePostop','trace');
                            $updateCMD = Yii::app()->db->createCommand( $postopUpdate);
                            $updateSuccess = $updateCMD->execute();	   
                            if ($updateSuccess){
                                Yii:trace("Postop Update succeeded");
                            }
                            else {
                                Yii:trace("Postop Update failed") ;
                            }	// end updateSuccess	
                            return $updateSuccess;
                    }  //($postops) >0
                    // if you get here you need to insert
                    //preprint('Entering Insert Postop');
                    $postopInsert = "INSERT INTO postop (PatientID,BaseSurgeonID,SurgeonID,Eye,PostopFlatK,PostopSteepK,PostopAxisK,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,`Exam Date`,Pupil,dbowner,Keratometry)";
                    $postopInsert .=" values (".$pat_id.",".$this->surgeon.",".$this->surgeon.",'".$result_array['Eye']."',".$this->dashToNull($result_array['FlatK1']);
                    $postopInsert .=",".$this->dashToNull($result_array['SteepK1']).",".$this->dashToNull($result_array['AxisAstig']).",".$this->dashToNull($result_array['AL']);
                    $postopInsert .=",".$this->dashToNull($result_array['CCT']).",".$this->dashToNull($result_array['ACD']).",".$this->dashToNull($result_array['LT']).","
                                        .$this->dashToNull($result_array['WTW']).",13,".$AvgRc.",CONVERT('".$result_array['Time']."',datetime),".$this->emptyToNull($result_array['Pupil']).",".$this->dbowner."," .$KeraID .")";
                    //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array
                    $updateCMD = Yii::app()->db->createCommand( $postopInsert);
                    $updateSuccess = $updateCMD->execute();
                    if ($updateSuccess ){
                        Yii::trace("PostopData".$num." Insertion succeeded\n");
                    }
                    else Yii::trace("PostopData".$num." Insertion failed\n") ;
                 } //(count($result_array)>0)
            } //(isset($xml->Patient->Exam[$num]))
        
      }
//      }
//           Yii::trace('entering storePostop','app.xmlUpload.storePostop','trece');
//           if (isset($this->xmlFile->Patient->Exam[$num])) {
//                $json_string = json_encode($this->xmlFile ->Patient->Exam[$num]);
//                // the string looks like this - need to remove {"@attributes: and closing "}"
//
//        //{"@attributes":{"Eye":"OD","Time":"2013\/07\/25 13:40","MeasurementMode":"Phakic","R1":"8.13","R2":"7.74","R1Axis":"97","FlatK1":"41.50","SteepK1":"43.61","Astigmatism":"2.12 ","AxisAstig":"7","n":"1.3375","CCT":"567","AD":"2.99","LT":"4.62","AL":"26.42","WTW":"12.31","Pupil":"-----"}}
//
//                $result_array =  substr_replace($json_string, '', $start=0,$length=15);  // removes {"@attributes
//                $result_array =  substr_replace($result_array, '', $start=-1);//and closing "}"
//
//                $result_array = json_decode($result_array, TRUE);
//                Yii::trace('Exam['.$num.'] = '. CVarDumper::dump($result_array));
//                if (count($result_array)>0 && is_numeric($result_array['FlatK1'])){  // insert or update this record
//
//                    $findLensStar = "Select ID from keratometry where dbowner=".$this->dbowner." and `Keratometry` like 'LenStar%'";
//                    $findLensStarCMD = Yii::app()->db->createCommand($findLensStar);
//                    $KeraID = $findLensStarCMD->queryScalar();
//                    // see if Postop already exists
//                    
// 		    $findPostOp = "Select * from postop where PatientID = ".$pat_id ." AND Eye='".$result_array['Eye']."'"; 
//                    //// this should exist if postop was created from template
//                    //$postops = mysqli_query($conn, $findPostOp);
//                    Yii::trace($findPostOp,'application.xmlUpload.storePostop','trace');
//                    $findPostOpCMD =  Yii::app()->db->createCommand( $findPostOp);
//                    $postops = $findPostOpCMD->queryRow();
//		    if ($postops) {  // recored exists
////					preprint('Entering Update Postop');
//                            $postopUpdate = "UPDATE postop set `PostopFlatK` = ".$this->dashToNull($result_array['FlatK1']).",`PostopSteepK` = ".$this->dashToNull($result_array['SteepK1']).",`PostopAxisK` = ".$this->dashToNull($result_array['AxisAstig']);
//                            $postopUpdate .= " Where postop.ID = ".$postops['ID'];
//                            Yii:trace($postopUpdate,'application.xmlUpload.updatePostop','trace');
//                            $updateCMD = Yii::app()->db->createCommand( $postopUpdate);
//                            $updateSuccess = $updateCMD->execute();	   
//                            if ($updateSuccess){
//                                Yii:trace("Postop Update succeeded");
//                            }
//                            else {
//                                Yii:trace("Postop Update failed") ;
//                            }	// end updateSuccess	
//                    }  //($record = mysqli_fetch_array($postops))
//                    else {		// must be an insertion
//
//                        // no postop exists so create one based on this data - however now the user's obligation to edit this to look like preop
//                        if (is_numeric($result_array['R1']) && is_numeric($result_array['R1']))
//                                $AvgRc = ($result_array['R1']+$result_array['R2'])/2;
//                        else $AvgRC = 'NULL';
//                        Yii:trace('Entering Insert Postop','application.xmlUpload.updatePostop','trace');//preprint('Entering Insert Postop');
//                        $postopInsert = "INSERT INTO postop (PatientID,BaseSurgeonID,SurgeonID,Eye,PostopFlatK,PostopSteepK,PostopAxisK,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,`Exam Date`,Pupil,dbowner,Keratometry)";
//                        $postopInsert .=" values (".$pat_id.",".$this->surgeon.",".$this->surgeon.",'".$result_array['Eye']."',".$this->dashToNull($result_array['FlatK1']);
//                        $postopInsert .=",".$this->dashToNull($result_array['SteepK1']).",".$this->dashToNull($result_array['AxisAstig']).",".$this->dashToNull($result_array['AL']);
//                        $postopInsert .=",".$this->dashToNull($result_array['CCT']).",".$this->dashToNull($result_array['ACD']).",".$this->dashToNull($result_array['LT']).","
//                                            .$this->dashToNull($result_array['WTW']).",13,".$AvgRc.",CONVERT('".$result_array['Time']."',datetime),".$this->emptyToNull($result_array['Pupil']).",".$this->dbowner."," .$KeraID .")";
//                        //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array
//                        $updateCMD = Yii::app()->db->createCommand( $postopInsert);
//                        $updateSuccess = $updateCMD->execute();
//                        if ($updateSuccess ){
//                            Yii::trace("PostopData".$num." Insertion succeeded\n");
//                        }
//                        else Yii::trace("PostopData".$num." Insertion failed\n") ;
//                    } //// must be an insertion
//                } //if (count($result_array)>0 && is_numeric($result_array['FlatK1']))
//             } //if (isset($this->xmlFile->Patient->Exam[$num]))
//        }  // end function storePostop($num,$pat_id)

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
			//array('xmlFile, created_at, updated_at, lastName, firstName, mi, birthDate, chartID, ethnicity, thisUser, thisPwd, technician, surgeon,  office, preop, postop', 'required'),
			array('technician, surgeon, dbowner, office, user_id', 'numerical', 'integerOnly'=>true),
			array('lastName, firstName', 'length', 'max'=>100),
			array('mi', 'length', 'max'=>2),
			//array('chartID, ethnicity, thisUser', 'length', 'max'=>20),
			//array('thisPwd', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, xmlFile, created_at, updated_at, lastName, firstName, mi, birthDate, chartID, ethnicity, thisUser, thisPwd, technician, surgeon, dbowner, office, preop, postop, user_id', 'safe', 'on'=>'search'),
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
