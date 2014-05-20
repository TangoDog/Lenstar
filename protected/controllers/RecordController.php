<?php

class RecordController extends Controller
{
	public function accessRules()
	{
		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','preop','postop'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


        public function actionPostop() {
                        

                // WORKING VERSION
                //error_reporting( E_ALL );
                // Version 1.1 20131121
                global $curl;
                $curl=TRUE;

 
                $upload = $_FILES['file']['tmp_name'];
                //
                // changed to allow posting - only can be done with curl on SSL with -k
                // the curl command line is 
                // curl -k --verbose -F "file=@kozel.xml" https:iols24-7.com/FM_IOL_03ex/lensStar.php >kozel.html
                // the data looks like:
                // 2013_07_25_13_40_33_Adams_Warren_S.XML
                // change the template file in EyeSuite directory - to reflect User/Pwd/Office/Technician
                // user needs to create the FullMonteIOL directory under c:\
                // add curl to this directory
                // change the template to above noted
                // add an export task with the curl function about
                // send a test file
                //Yii::trace($_FILES);
                //Yii::trace("...........\n");
                //readfile($upload);
                //$upload = "C:\FullMonteIOL\lensStar.xml";
                $xml = file_get_contents($upload);
                $xml = simplexml_load_string($xml); 
                //Yii::trace($xml);
                //$string =$fileXML;                                                                       
                global $conn;                                      
                //$xml = simplexml_load_string($string); 
                //Yii::trace($xml);
                //$json_string = json_encode($xml);
                echo "Entered LenStarPostop.php Version 1.0 20131107";
                $objDateTime = new DateTime('NOW');
                echo $objDateTime->format('c'); // ISO8601 formated datetime
                echo "\n";
                //$result_array = json_decode($json_string, TRUE);
                $ChartID = (string) $xml->Patient['ID'];
                preprint('Lenstar PatientID: '.$ChartID);
                $LastName = $xml->Patient['LastName'];
                $LastName = str_ireplace(".","",$LastName);
                $LastName = str_ireplace(" ","",$LastName);
                $LastName = html2txt($LastName); //removes offensive tags
                preprint('LastName: '.$LastName."");

                $FirstName = (string) $xml->Patient['FirstName'];
                preprint('FirstName: '.$FirstName);

                // strip off any MI
                $Mi = "";
                // find a space -
                Yii::trace('FirstName: '.$FirstName."\n");
 
                getFirstNameMI($FirstName);           
                $ChartID = (string) $xml->Patient['ID'];

                $Birthday = (string) $xml->Patient['Birthday'];
                $Ethnicity = (string) $xml->Patient['Ethnicity'];
                $Sex = (string) $xml->Patient['Sex'];
                $Sex = strtoupper(substr($Sex, 0, 1));
                $Thisuser = (string) $xml->Login['User'];
                $Thispwd = (string) $xml->Login['Pwd'];
                $Technician=(string) $xml->Login['Technician'];
                $Office=(string) $xml->Login['Office'];
                $Surgeon = (string) $xml->Login['Surgeon'];
                echo "Office: ". $Office;
                echo "Surgeon: ". $Surgeon;
                // get the two exams:
                // <Exam Eye="OD" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.13" R2="7.74" R1Axis="97" FlatK1="41.50" SteepK1="43.61" Astigmatism="2.12 " AxisAstig="7" n="1.3375" CCT="567" AD="2.99" LT="4.62" AL="26.42" WTW="12.31" Pupil="-----" />
                //  <Exam Eye="OS" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.06" R2="7.75" R1Axis="84" FlatK1="41.85" SteepK1="43.53" Astigmatism="1.68 " AxisAstig="174" n="1.3375" CCT="566" AD="2.99" LT="4.65" AL="26.40" WTW="12.28" Pupil="-----" /> 
                if (isset($xml->Patient->Exam[0])) {
                        $json_string = json_encode($xml->Patient->Exam[0]);
                        // the string looks like this - need to remove {"@attributes: and closing "}"

                //{"@attributes":{"Eye":"OD","Time":"2013\/07\/25 13:40","MeasurementMode":"Phakic","R1":"8.13","R2":"7.74","R1Axis":"97","FlatK1":"41.50","SteepK1":"43.61","Astigmatism":"2.12 ","AxisAstig":"7","n":"1.3375","CCT":"567","AD":"2.99","LT":"4.62","AL":"26.42","WTW":"12.31","Pupil":"-----"}}

                        $result_array1 =  substr_replace($json_string, '', $start=0,$length=15);
                        $result_array1 =  substr_replace($result_array1, '', $start=-1);

                        $result_array1 = json_decode($result_array1, TRUE);
                        $result_array1['Pupil'] = $result_array1['Pupil']==='-----'?'':$result_array1['Pupil'];
                        preprint($result_array1);

                }
                if (isset($xml->Patient->Exam[1])) {
                        $json_string = json_encode($xml->Patient->Exam[1]);
                        // remove the @attribute tag, and the final}
                        $result_array2 =  substr_replace($json_string, '', $start=0,$length=15);
                        $result_array2 =  substr_replace($result_array2, '', $start=-1);

                        $result_array2 = json_decode($result_array2, TRUE);
                        $result_array2['Pupil'] = $result_array2['Pupil']==='-----'?'':$result_array2['Pupil'];

                         preprint($result_array2);

                }
                preprint( "Logging in...");
                //
                include "lenstarLogin.php";  // does the login logic, borrowed from standard code
                //$dbowner should be set from here
                //$conn = mysqli_connect('localhost','gpclarke','Pen7dejo','fm_ioln4');
                //$_SESSION['OwnerID']=1;
                //$loginSuccess = TRUE;
                //preprint('dbowner='.$_SESSION('OwnerID'));
                if ($loginSuccess) {
                        preprint( "Login Success..");
                        // CREATE A NEW RECORD, OR UPDATE AN OLD ONE
                    // First check to see if the patient is in the record
                    $findNameQry = "Select * from patients where `LastName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($LastName)."','99220a8fde41445eab441169c1d80e2c')) as char)
                                   AND `FirstName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($FirstName)."','99220a8fde41445eab441169c1d80e2c')) as char)
                                   AND `BirthDate` = date('" .$Birthday.  "') AND dbowner=".$_SESSION['OwnerID'];
                    $findNameQry1 = "Select * from patients where `ChartID` ='". $conn->real_escape_string($ChartID).
                                 "' AND dbowner=".$_SESSION['OwnerID'];
                    Yii::trace("\n............\n");
                    Yii::trace($findNameQry);
                    Yii::trace("\n............\n");
                    Yii::trace($findNameQry1);
                    // run the chart id query first
                    $res =  mysqli_query($conn, $findNameQry);
                    if ($res->num_rows>0) {  // found a record
                        $found = mysqli_fetch_array($res);
                        if ($found) {
                        // found the record, get the ID and insert the preop exam;
                            $patientID =$found['ID'];
                            echo "Found by Name PatientID: " .$patientID;
                        }

                    } else {  //  num_rows = 0
                                $res2 =  mysqli_query($conn, $findNameQry1);  // name query
                                $found = mysqli_fetch_array($res2);
                        if ($found) {
                        // found the record, get the ID and insert the preop exam;
                            $patientID =$found['ID'];
                            echo "Found by ChartID PatientID: " .$patientID;
                        }
                        }
                    echo "\nPatientID: " .$patientID;   //echo($fields);
                    // found the record, get the ID and insert the preop exam;
                    // <Exam Eye="OD" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.13" R2="7.74" R1Axis="97" FlatK1="41.50" SteepK1="43.61" Astigmatism="2.12 " AxisAstig="7" n="1.3375" 
                    // CCT="567" AD="2.99" LT="4.62" AL="26.42" WTW="12.31" Pupil="-----" />
                    //  <Exam Eye="OS" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.06" R2="7.75" R1Axis="84" FlatK1="41.85" SteepK1="43.53" Astigmatism="1.68 " AxisAstig="174" n="1.3375" CCT="566" AD="2.99" LT="4.65" AL="26.40" WTW="12.28" Pupil="-----" /> 
                     $findLensStar = "Select ID from keratometry where dbowner=".$_SESSION['OwnerID'] ." and `Keratometry` like 'LenStar%'";
                         $KeraID = 6;  // default
                         if ( $stmt = $conn->prepare($findLensStar)){
                              if($stmt->execute()) {
                                        if($stmt->store_result()) {
                                                if ($stmt->bind_result($KeraID)) {
                                                        if (!($stmt->fetch())){
                                                                $KeraID = 6; 
                                                                Yii::trace("Fetch Error: ", $stmt->error);
                                                        }
                                                        $stmt->close();
                                                        } 
                                                        else Yii::trace("Bind Params  Failed: ",$stmt->error);
                                                }
                                                else Yii::trace("Store Result  Failed: ",$stmt->error);
                                        } 
                                        else Yii::trace("Statement Execution Failed: ", $conn->error);
                        } 
                        else  Yii::trace("Statement prepare error", $conn->error);


                // this should be added to the LenStar XML file

 
                // right eye first
                    if (count($result_array1)>0  && is_numeric($result_array1['FlatK1'])){  // update this record
                                        $findPostOp = "Select * from postop where PatientID = ".$patientID ." AND Eye='".$result_array1['Eye']."'"; // this should exist if postop was created from template
                                preprint($findPostOp);
                                        $postops = mysqli_query($conn, $findPostOp);
                                        if ($postops) {
                                           // records exist this should be an update
                                                if ($record = mysqli_fetch_array($postops)) {
                                                        preprint('Entering Update Postop');
                                                        $postopUpdate = "UPDATE postop set `PostopFlatK` = ".dashToNull($result_array1['FlatK1']).",`PostopSteepK` = ".dashToNull($result_array1['SteepK1']).",`PostopAxisK` = ".dashToNull($result_array1['AxisAstig']);
                                                        $postopUpdate .= " Where postop.ID = ".$record['ID'];
                                                        preprint($postopUpdate);
                                                        $updateSuccess =  mysqli_query($conn, $postopUpdate);	   
                                                        if ($updateSuccess){
                                                                preprint("Postop Update succeeded");
                                                        }
                                                                else {
                                                                preprint("Postop Update failed") ;
                                                        }	// end updateSuccess	
                                                }  //($record = mysqli_fetch_array($postops))
                                                else {		// must be an insertion

                                                        // no postop exists so create one based on this data - however now the user's obligation to edit this to look like preop
                                                        if (is_numeric($result_array1['R1']) && is_numeric($result_array1['R1']))
                                                                $AvgRc = ($result_array1['R1']+$result_array1['R2'])/2;
                                                        else $AvgRC = 'NULL';
                                                        preprint('Entering Insert Postop');
                                                        $preopInsert = "INSERT INTO postop (PatientID,BaseSurgeonID,SurgeonID,Eye,PostopFlatK,PostopSteepK,PostopAxisK,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,`Exam Date`,Pupil,dbowner,Keratometry)";
                                                        $preopInsert .=" values (".$patientID.",". $Surgeon.",".$Surgeon.",'".$result_array1['Eye']."',".dashToNull($result_array1['FlatK1']);
                                                        $preopInsert .=",".dashToNull($result_array1['SteepK1']).",".dashToNull($result_array1['AxisAstig']).",".dashToNull($result_array1['AL']);
                                                        $preopInsert .=",".dashToNull($result_array1['CCT']).",".dashToNull($result_array1['ACD']).",".dashToNull($result_array1['LT']).",".dashToNull($result_array1['WTW']).",13,".$AvgRc.",CONVERT('".$result_array1['Time']."',datetime),".emptyToNull($result_array1['Pupil']).",".$_SESSION['OwnerID']."," .$KeraID .")";
                                                        //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array1
                                                        preprint($preopInsert);
                                                        $insert =  mysqli_query($conn, $preopInsert);

                                                        preprint("\n............\n");

                                                        if ($insert){
                                                                preprint("Data1 Insertion succeeded\n");
                                                        }
                                                        else {
                                                                                                                preprint("Data1 Insertion failed\n") ;
                                                                                                                preprint($conn->errno."  ". $conn->error);
                                                                }
                                                }  // must be an insertion
                                        }// if $postops
                        } //(count($result_array1)>0)

                    if (count($preop[1])>0  && is_numeric($preop[1]['FlatK1'])){  // insert this record or update found postop
                                        $findPostOp2 = "Select * from postop where PatientID = ".$patientID ." AND Eye='".$preop[1]['Eye']."'";// this should exist if postop was created from template
                                        preprint($findPostOp2);
                                        $postops = mysqli_query($conn, $findPostOp2);
                                        if ($postops) {
                                           // records exist this should be an update
                                                if ($record = mysqli_fetch_array($postops)) {
                                                        preprint('Entering Update Postop');
                                                        $postopUpdate = "UPDATE postop set `PostopFlatK` = ".dashToNull($preop[1]['FlatK1']).",`PostopSteepK` = ".emptyToNull($preop[1]['SteepK1']).",`PostopAxisK` = ".emptyToNull($preop[1]['AxisAstig']);
                                                        $postopUpdate .= " Where postop.ID = ".$record['ID'];
                                                        preprint($postopUpdate);
                                                        $updateSuccess =  mysqli_query($conn, $postopUpdate);	   
                                                        if ($updateSuccess){
                                                                preprint("Postop Update succeeded");
                                                        }
                                                                else {
                                                                preprint("Postop Update failed") ;
                                                        }	// end updateSuccess	
                                                }
                                                else {		// must be an insertion

                                                        // no postop exists so create one based on this data - however now the user's obligation to edit this to look like preop
                                                        $AvgRc = ($preop[1]['R1']+$preop[1]['R2'])/2;
                                                                                        preprint('Entering Insert Postop');
                                                        $preopInsert = "INSERT INTO postop (PatientID,BaseSurgeonID,SurgeonID,Eye,PostopFlatK,PostopSteepK,PostopAxisK,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,`Exam Date`,Pupil,dbowner,Keratometry)";
                                                        $preopInsert .=" values (".$patientID.",". $Surgeon.",".$Surgeon.",'".$preop[1]['Eye']."',".dashToNull($preop[1]['FlatK1']);
                                                        $preopInsert .=",".dashToNull($preop[1]['SteepK1']).",".dashToNull($preop[1]['AxisAstig']).",".dashToNull($preop[1]['AL']);
                                                        $preopInsert .=",".dashToNull($preop[1]['CCT']).",".dashToNull($preop[1]['ACD']).",".dashToNull($preop[1]['LT']).",".dashToNull($preop[1]['WTW']).",13,".$AvgRc.",CONVERT('".
                                                                                        $preop[1]['Time']."',datetime),".emptyToNull($preop[1]['Pupil']).",".$_SESSION['OwnerID']."," .$KeraID .")";
                                                        //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$preop[1]
                                                        preprint($preopInsert);
                                                        $insert =  mysqli_query($conn, $preopInsert);

                                                        preprint("\n............\n");

                                                        if ($insert){
                                                                preprint("Data2 Insertion succeeded\n");
                                                        }
                                                        else {
                                                                preprint("Data1 Insertion failed\n") ;
                                                                preprint($conn->errno."  ". $conn->error);
                                                                }
                                                }  // must be an insertion
                                                    //if ($record = mysqli_fetch_array($postops))
                                        } // if $postops
                        } // insert this record or update found postop
                }  // loginSuccess	
                else      // unsuccessful login
                     echo "LOGIN FAILED";


                exit();

                                $this->render('postop');
        }

	public function actionPreop()
	{
            $xml = new xmlFile; // this will initialze the XML file structure
            // now parse the patient portion;
            if (isset($xml)) $Ptsuccess = $xml->setPatient();
           // changed to allow posting - only can be done with curl on SSL with -k
            // the curl command line is 4
            // curl -k --verbose -F "file=@kozel.xml" https:iols24-7.com/FM_IOL_03ex/lensStar.php >kozel.html
            // the data looks like:
            // 2013_07_25_13_40_33_Adams_Warren_S.XML
            // change the template file in EyeSuite directory - to reflect User/Pwd/Office/Technician
            // user needs to create the FullMonteIOL directory under c:\
            // add curl to this directory
            // change the template to above noted
            // add an export task with the curl function about
            // send a test file
            //Yii::trace($_FILES);
            //Yii::trace("...........\n");
            //readfile($upload);
  

            // get the two exams:
            if ($Ptsuccess) {
                $Preop1 = $xml->setPreop(0);  // will be similar in postop action
                $Preop2 = $xml->setPreop(1);
                
            }
   
            //echo "Logging in...\n";
            Yii::trace('Logging in ...');
            /*
             * New Login using guid and user name - no passwords are passed
             */
            $logger = new LoginForm;
            $logger->username = $Thisuser;
            $logger->password = $Thispwd;
            if ($logger->validate() && $logger->login()){
                $loginSuccess = true;
            } else {
                Yii::trace('Login Failed');
                $message = 'Login Failed';
                throw new Exception($message);
               
            }
               
            $dbowner = Yii::app()->user->getDbowner();
            //include "lenstarLogin.php";  // does the login logic, borrowed from standard code
            //$dbowner should be set from here
            if ($loginSuccess) {
                 Yii::trace( "Login Success...\n");
                    // CREATE A NEW RECORD, OR UPDATE AN OLD ONE
                // First check to see if the patient is in the record
                $OwnerID = $_SESSION['OwnerID'];
                $findNameQry = "Select * from patients where `LastName` = cast(hex(DES_ENCRYPT( :LastName,'99220a8fde41445eab441169c1d80e2c')) as char)
                     AND `FirstName` = cast(hex(DES_ENCRYPT( :FirstName,'99220a8fde41445eab441169c1d80e2c')) as char) AND `BirthDate` = date(:Birthday)
                     AND dbowner=:OwnerID";
                $findName2Qry = "Select * from patients where `LastName` = cast(hex(DES_ENCRYPT( :LastName,'99220a8fde41445eab441169c1d80e2c')) as char)
                     AND `FirstName` = cast(hex(DES_ENCRYPT( :FirstName,'99220a8fde41445eab441169c1d80e2c')) as char) AND `BirthDate` = date(:Birthday)
                     AND dbowner=:OwnerID AND `ChartID` =:ChartID";
               
                $findQryID = "Select * from patients where `ChartID` =:ChartID AND dbowner=";
                //$command = Yii::app()->db->createCommand($findQryID);
                $patient = Patient::model()->findAllBySql($findQryID, array(':ChartID' => $xml->ChartID, ':OwnerID' => $OwnerID));
//                Yii::trace("\n............\n");
//                Yii::trace($findNameQry);
//                Yii::trace("\n............\n");
//                Yii::trace($findQryID);
               // $res =  mysqli_query($conn, $findQryID);
               // $res1 =  mysqli_query($conn, $findNameQry);
              //  $res2 =  mysqli_query($conn, $findName2Qry);
                if (isset($patient)) {  // found a record
                    //$found = mysqli_fetch_array($res);
                    //if ($found) {
                    // found the record, get the ID and insert the preop exam;
                        $patientID =$patient['ID'];
                        echo "Found by ChartID; PatientID is : " .$patientID;
                    }
                 else {  // try by Name and Birthdate
                    $patient = Patient::model()->findAllBySql($findNameQry , array(':LastName' => $xml->LastName,':FirstName' => $xml->FirstName, ':BirthDate' => $xml->BirthDate,  ':OwnerID' => $OwnerID));
                    if (isset($patient)) {   
                    
                    // found the record, get the ID and insert the preop exam;
                        $patientID =$patient['ID'];
                        echo "Found by FullName PatientID: " .$patientID;
                    }   
                    else 
                    { // need to insert a new record
                        $sqlPatInsert = "INSERT INTO patients (LastName,FirstName,MI,BirthDate,ChartID,Ethnicity,Sex,dbowner,Office,Surgeon) "
                                . "values (cast(hex(DES_ENCRYPT(:LastName,'99220a8fde41445eab441169c1d80e2c')) as char),";
                        $sqlPatInsert .= " cast(hex(DES_ENCRYPT( :FirstName,'99220a8fde41445eab441169c1d80e2c')) as char),".
                                          ":Mi,date(:Birthdate),:ChartID,:Ethnicity,:Sex,:OwnerID,:Office,:Surgeon)";
                       Yii::trace($sqlPatInsert,'trace');
                       //Yii::trace("\n............\n");
                       $command = Yii::app()->db->createCommand($sqlPatInsert); 
                       $insert = $command->execute(array(':LastName' => $xml->LastName,':FirstName'=>$ml->FirstName,
                                                           ':Mi'=>$xml->Mi, ':BirthDate'=>$xml->Birthday,
                                                           ':ChartID'=>$xml->ChartID, ':Ethnicity'=>$xml->Ethnicity,
                                                           ':Sex'=>$xml->Sex,':OwnerID'=>$OwnerID,
                                                           ':Office'=>$xml->Office,':Surgeon'=>$xml->Surgeon));
                        if($insert) {
                          $patientID = Yii::app()->db->getLastInsertID(); // gets most recent ID
                          if (!isset($patientID)) throw new Exception ('Patient insertion Failed');
                      }
                         else {
                          Yii::trace("SQL Error: Patient insertion Failed");
                        }
                    }
                echo "\nPatientID: " .$patientID;
               // $fields = mysqli_fetch_all(mysqli_query($conn, "SHOW COLUMNS FROM PREOP"));
                //echo($fields);
                // found the record, get the ID and insert the preop exam;
                // <Exam Eye="OD" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.13" R2="7.74" R1Axis="97" FlatK1="41.50" SteepK1="43.61" Astigmatism="2.12 " AxisAstig="7" n="1.3375" 
                // CCT="567" AD="2.99" LT="4.62" AL="26.42" WTW="12.31" Pupil="-----" />
                //  <Exam Eye="OS" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.06" R2="7.75" R1Axis="84" FlatK1="41.85" SteepK1="43.53" Astigmatism="1.68 " AxisAstig="174" n="1.3375" CCT="566" AD="2.99" LT="4.65" AL="26.40" WTW="12.28" Pupil="-----" /> 
                                     // Statement MysQLI
                            // if ($stmt = $conn->prepare($qrySelect)) {
                                            // $rs = $stmt->execute();		
                              // $stmt->store_result(); 
                              // $stmt->bind_result($FirstOperatorName, $FirstOperatorPassword,$FirstOperatorEMail);
                                    // while ($stmt->fetch()) {
                                    // }
                            // should only be one record
                                    /* close statement */
                            //	$stmt->close();
                            //}   echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                 // find the keratometry id that contains LensStar
                 $findLensStar = "Select ID from keratometry where dbowner=:OwnerID and `Keratometry` like 'LenStar%'";
                $KeraID = 6;  // default
                if ( $stmt = Yii::app()->db->createCommand($findLensStar)){
                    $stmt->execute(array(':OwnerID'=>$OwnerID));
                    if($stmt->store_result()) {
                            if ($stmt->bind_result($KeraID)) {
                                    if (!($stmt->fetch())){
                                            $KeraID = 6; 
                                            Yii::trace("Fetch Error: ", $stmt->error);
                                    }
                                    $stmt->close();
                                    } 
                                    else Yii::trace("Bind Params  Failed: ",$stmt->error);
                            } else Yii::trace("Store Result  Failed: ",$stmt->error);
               } 
                else  Yii::trace("Statement prepare error",'trace');
                Yii::trace( "KeraID = ". $KeraID);
            // this should be added to the LenStar XML file

            

                if (count($preop[0])>0  && is_numeric($preop[0]['FlatK1'])){  // insert this record
                        $AvgRc = ($preop[0]['R1']+$preop[0]['R2'])/2;
                        $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,dbowner,Keratometry)";
                        $preopInsert .=" values (".$patientID.",". $xml->Technician.",".$xml->Office.",'".$preop[0]['Eye']."',".dashToNull($preop[0]['FlatK1']);
                        $preopInsert .=",".dashToNull($preop[0]['SteepK1']).",".dashToNull($preop[0]['AxisAstig']).",".dashToNull($preop[0]['AL']);
                        $preopInsert .=",".dashToNull($preop[0]['CCT']).",".dashToNull($preop[0]['ACD']).",".dashToNull($preop[0]['LT']).",".dashToNull($preop[0]['WTW']).",13,".$AvgRc.",CONVERT('".$preop[0]['Time']."',datetime),".$_SESSION['OwnerID'].",".$KeraID.")";
                        //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$preop[0]
                        Yii::trace($preopInsert);
                        $stmtPreop1 = Yii::app()->db->createCommand($preopInsert);
                        $insert =  $stmtPreop1->execute();
                        Yii::trace("\n............\n");

                        if ($insert){
                            Yii::trace("Data1 Insertion succeeded\n");
                        }
                            else {
                              Yii::trace("Data1 Insertion failed\n") ;
                              Yii::trace("Error:". $conn->error);
                            }
                }
                if (count($preop[1])>0  && is_numeric($preop[1]['FlatK1'])){  // insert this record
                        $AvgRc = ($preop[1]['R1']+$preop[1]['R2'])/2;
                        $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,dbowner,Keratometry)";
                        $preopInsert .=" values (".$patientID.",". $Technician.",".$Office.",'".$preop[1]['Eye']."',".dashToNull($preop[1]['FlatK1']);
                        $preopInsert .=",".dashToNull($preop[1]['SteepK1']).",".dashToNull($preop[1]['AxisAstig']).",".dashToNull($preop[1]['AL']);
                        $preopInsert .=",".dashToNull($preop[1]['CCT']).",".dashToNull($preop[1]['ACD']).",".dashToNull($preop[1]['LT']).",".dashToNull($preop[1]['WTW']).",13,".$AvgRc.",CONVERT('".$preop[1]['Time']."',datetime),".$_SESSION['OwnerID'].",".$KeraID.")";
                         //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$preop[1]
                        echo($preopInsert);
                        $stmtPreop1 = Yii::app()->db->createCommand($preopInsert);
                        $insert =  $stmtPreop1->execute();
                        Yii::trace("\n............\n");

                        if ($insert){
                            Yii::trace("Data2 Insertion succeeded\n");
                        }
                        else {
                              Yii::trace("Data2 Insertion failed\n") ;
                              Yii::trace("Error:". $conn->error);
                        }

                }
            }
            }
            else {  
                    // unsuccessful login
                    echo "LOGIN FAILED";

            }

            //Yii::trace( "Patient: " .$patient. " " . $lastName);
            // login in to the database:
            exit();

	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}