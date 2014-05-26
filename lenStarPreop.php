<?php
//error_reporting( E_ALL );
global $curl;
$curl=TRUE;

function html2txt($document){
$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
);
$text = preg_replace($search, '', $document);
return $text;
}  // end function html2txt

$upload = $_FILES['file']['tmp_name'];
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
//print_r($_FILES);
//print_r("...........\n");
//readfile($upload);
$xml = file_get_contents($upload);
$xml = simplexml_load_string($xml); 
print_r($xml);
//$string =$fileXML;                                                                       
global $conn;                                      
//$xml = simplexml_load_string($string); 
//print_r($xml);
//$json_string = json_encode($xml);
echo "\nEntered lenStarPreop.php Vers1.1 20131107";
//$result_array = json_decode($json_string, TRUE);
$patient = (string) $xml->Patient['ID'];
print_r('Lenstar ChartID: '.$patient."\n");
$LastName = $xml->Patient['LastName'];
$LastName = str_ireplace(".","",$LastName);
$LastName = str_ireplace(" ","",$LastName);
$LastName = html2txt($LastName); //removes offensive tags
print_r('LastName: '.$LastName."\n");

$FirstName = (string) $xml->Patient['FirstName'];
// strip off any MI
$Mi = "";
// find a space -
print_r('FirstName: '.$FirstName."\n");
$space = strpos($FirstName," ");
if ($space!=false) {  // there is a middle initial 
	$FirstName1 = strrev( strchr(strrev($FirstName)," ") );  //ABE J. => .J EBA
	print_r('FirstName1: '.$FirstName1."\n");
	$FirstName1 = str_ireplace(".","",$FirstName1);
	print_r('FirstName1: '.$FirstName1."\n");
	$FirstName1 = str_ireplace(" ","",$FirstName1);
	print_r('FirstName1: '.$FirstName1."\n");
	$FirstName1 = html2txt($FirstName1);
	print_r('FirstName1: '.$FirstName1."\n");

	$Mi2 =  strstr($FirstName," ") ;  // gives false if no space, or space plus rest  --like " S." if exists
	if ($Mi2) $Mi = str_ireplace(" ","",$Mi2);
	$Mi = str_ireplace(".","",$Mi);
	$Mi = str_ireplace(",","",$Mi);
	print_r( "MI = ".$Mi ."\n");
	$FirstName = $FirstName1;
	} // do not change and don't strip out the Middle Init
// remove periods, anything not numchars
//$FirstName = (string)hex(DES_ENCRYPT( $xml->Patient['FirstName'],'99220a8fde41445eab441169c1d80e2c'));
$Birthday = (string) $xml->Patient['Birthday'];
$Ethnicity = (string) $xml->Patient['Ethnicity'];
$Sex = (string) $xml->Patient['Sex'];
$Sex = strtoupper(substr($Sex, 0, 1));
$Thisuser = (string) $xml->Login['User'];
$Thispwd = (string) $xml->Login['Pwd'];
$Technician=(string) $xml->Login['Technician'];
$Office=(string) $xml->Login['Office'];
$ChartID = (string) $xml->Patient['ID'];
$Surgeon = (string) $xml->Login['Surgeon'];


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
        print_r($result_array1);
        
}
if (isset($xml->Patient->Exam[1])) {
	$json_string = json_encode($xml->Patient->Exam[1]);
        // remove the @attribute tag, and the final}
 	$result_array2 =  substr_replace($json_string, '', $start=0,$length=15);
	$result_array2 =  substr_replace($result_array2, '', $start=-1);
        
        $result_array2 = json_decode($result_array2, TRUE);
         print_r($result_array2);
 
}
echo "Logging in...\n";
include "lenstarLogin.php";  // does the login logic, borrowed from standard code
//$dbowner should be set from here
if ($loginSuccess) {
echo "Logging in Success...\n";
	// CREATE A NEW RECORD, OR UPDATE AN OLD ONE
    // First check to see if the patient is in the record
    $findNameQry = "Select * from patients where `LastName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($LastName)."','99220a8fde41445eab441169c1d80e2c')) as char)
         AND `FirstName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($FirstName)."','99220a8fde41445eab441169c1d80e2c')) as char) AND `BirthDate` = date('" .$Birthday.
		 "') AND `ChartID` ='". $conn->real_escape_string($ChartID).
		 "' AND dbowner=".$_SESSION['OwnerID'];
    $findName2Qry = "Select * from patients where `LastName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($LastName)."','99220a8fde41445eab441169c1d80e2c')) as char)
         AND `FirstName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($FirstName)."','99220a8fde41445eab441169c1d80e2c')) as char) AND `BirthDate` = date('" .$Birthday.
		 "' AND dbowner=".$_SESSION['OwnerID'];
	$findQryID = "Select * from patients where `ChartID` ='". $ChartID . "' AND dbowner=".$_SESSION['OwnerID'];

    print_r("\n............\n");
    print_r($findNameQry);
	print_r("\n............\n");
    print_r($findQryID);
    $res =  mysqli_query($conn, $findQryID);
    $res1 =  mysqli_query($conn, $findNameQry);
    $res2 =  mysqli_query($conn, $findName2Qry);
    if ($res->num_rows>0) {  // found a record
        $found = mysqli_fetch_array($res);
        if ($found) {
        // found the record, get the ID and insert the preop exam;
            $patientID =$found['ID'];
            echo "Found by ChartID PatientID: " .$patientID;
        }
    } else if($res1->num_rows>0){   
	    $found = mysqli_fetch_array($res1);
        if ($found) {
        // found the record, get the ID and insert the preop exam;
            $patientID =$found['ID'];
            echo "Found by FullName PatientID: " .$patientID;
        }
    } else if($res2->num_rows>0){   
	    $found = mysqli_fetch_array($res2);
        if ($found) {
        // found the record, get the ID and insert the preop exam;
            $patientID =$found['ID'];
            echo "Found by Name PatientID: " .$patientID;
        }
     } else { // need to insert a new record
		$sqlPatInsert = "INSERT INTO patients (LastName,FirstName,MI,BirthDate,ChartID,Ethnicity,Sex,dbowner,Office,Surgeon) values (cast(hex(DES_ENCRYPT( '".
						$conn->real_escape_string($LastName)."','99220a8fde41445eab441169c1d80e2c')) as char),";
						$sqlPatInsert .= " cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($FirstName)."','99220a8fde41445eab441169c1d80e2c')) as char),'".
						$Mi."',date('".($Birthday)."'),'".$conn->real_escape_string($ChartID)."','".
						$Ethnicity."','".$Sex."',".$_SESSION['OwnerID'].",".$Office.",".$Surgeon.")";
        print_r($sqlPatInsert);
		print_r("\n............\n");
 		
        $insert =  mysqli_query($conn, $sqlPatInsert);
        
		if($insert) {
			$patientID = mysqli_insert_id ( $conn); // gets most recent ID
			echo "\nNew Patient Inserted";
			}
		else {
			print_r("SQL Error: ". $conn->error);
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
     $findLensStar = "Select ID from keratometry where dbowner=".$_SESSION['OwnerID'] ." and `Keratometry` like 'LenStar%'";
	 $KeraID = 6;  // default
	 if ( $stmt = $conn->prepare($findLensStar)){
	      if($stmt->execute()) {
			if($stmt->store_result()) {
				if ($stmt->bind_result($KeraID)) {
					if (!($stmt->fetch())){
						$KeraID = 6; 
						print_r("Fetch Error: ", $stmt->error);
					}
					$stmt->close();
					} 
					else print_r("Bind Params  Failed: ",$stmt->error);
				}
				else print_r("Store Result  Failed: ",$stmt->error);
			} 
			else print_r("Statement Execution Failed: ", $conn->error);
	} 
	else  print_r("Statement prepare error", $conn->error);
	  
	 // echo $findLensStar;
     // if ($keratometry = mysqli_query($conn,$findLensStar)){
	      // $Kid = mysqli_fetch_assoc($keratometry);
		  // $KeraID = $Kid['ID'];  // this is the keratometry ID
		  // }
	 // else $KeraID = 6;
	 echo "KeraID = ". $KeraID;
// this should be added to the LenStar XML file

function dashToNull($value) {return ( is_numeric($value)? $value :'NULL');};

    if (count($result_array1)>0  && is_numeric($result_array1['FlatK1'])){  // insert this record
            $AvgRc = ($result_array1['R1']+$result_array1['R2'])/2;
            $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,dbowner,Keratometry)";
            $preopInsert .=" values (".$patientID.",". $Technician.",".$Office.",'".$result_array1['Eye']."',".dashToNull($result_array1['FlatK1']);
            $preopInsert .=",".dashToNull($result_array1['SteepK1']).",".dashToNull($result_array1['AxisAstig']).",".dashToNull($result_array1['AL']);
            $preopInsert .=",".dashToNull($result_array1['CCT']).",".dashToNull($result_array1['ACD']).",".dashToNull($result_array1['LT']).",".dashToNull($result_array1['WTW']).",13,".$AvgRc.",CONVERT('".$result_array1['Time']."',datetime),".$_SESSION['OwnerID'].",".$KeraID.")";
            //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array1
            echo($preopInsert);
            $insert =  mysqli_query($conn, $preopInsert);
            print_r("\n............\n");

            if ($insert){
                print_r("Data1 Insertion succeeded\n");
            }
                else {
                  print_r("Data1 Insertion failed\n") ;
                  print_r("Error:". $conn->error);
                }
    }
    if (count($result_array2)>0  && is_numeric($result_array2['FlatK1'])){  // insert this record
            $AvgRc = ($result_array2['R1']+$result_array2['R2'])/2;
            $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,dbowner,Keratometry)";
           $preopInsert .=" values (".$patientID.",". $Technician.",".$Office.",'".$result_array2['Eye']."',".dashToNull($result_array2['FlatK1']);
            $preopInsert .=",".dashToNull($result_array2['SteepK1']).",".dashToNull($result_array2['AxisAstig']).",".dashToNull($result_array2['AL']);
            $preopInsert .=",".dashToNull($result_array2['CCT']).",".dashToNull($result_array2['ACD']).",".dashToNull($result_array2['LT']).",".dashToNull($result_array2['WTW']).",13,".$AvgRc.",CONVERT('".$result_array2['Time']."',datetime),".$_SESSION['OwnerID'].",".$KeraID.")";
             //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array2
            echo($preopInsert);
            $insert =  mysqli_query($conn, $preopInsert);
            print_r("\n............\n");

           if ($insert){
                print_r("Data2 Insertion succeeded\n");
            }
                 else {
                  print_r("Data2 Insertion failed\n") ;
                  print_r("Error:". $conn->error);
                }

    }
}
else {  
        // unsuccessful login
        echo "LOGIN FAILED";
  
}

//print_r( "Patient: " .$patient. " " . $lastName);
// login in to the database:
exit();
?>