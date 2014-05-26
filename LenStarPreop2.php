<?php
//error_reporting( E_ALL );
// revised GPC 10/23/13
// version 1.1 - changes to Patient - add ID
//  preop - change ACD and add pupil size to fields
global $curl;
$curl=TRUE;
libxml_use_internal_errors(true);
function html2txt($document){
$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
);
$text = preg_replace($search, '', $document);
return $text;
}  // end function html2txt
function display_xml_error($error, $xml)
{
    $return  = $xml[$error->line - 1] . "\n";
    $return .= str_repeat('-', $error->column) . "^\n";

    switch ($error->level) {
        case LIBXML_ERR_WARNING:
            $return .= "Warning $error->code: ";
            break;
         case LIBXML_ERR_ERROR:
            $return .= "Error $error->code: ";
            break;
        case LIBXML_ERR_FATAL:
            $return .= "Fatal Error $error->code: ";
            break;
    }

    $return .= trim($error->message) .
               "\n  Line: $error->line" .
               "\n  Column: $error->column";

    if ($error->file) {
        $return .= "\n  File: $error->file";
    }

    return "$return\n\n--------------------------------------------\n\n";
}
echo "LensStar --> FM_IOL v1.0\n";
$upload = $_FILES['file']['tmp_name'];
var_dump($upload);
// the xml is very sensitive - watch <Login ....> </Login>

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
//
//readfile($upload);
$string = file_get_contents($upload);
print_r($string);
//remove the character * from the $string
$string = str_replace("*", "", $string);
$xml = simplexml_load_string($string); 
// report the xml syntax errors
if (!$xml) {
    $errors = libxml_get_errors();

    foreach ($errors as $error) {
        echo display_xml_error($error, $xml);
    }

    libxml_clear_errors();
}


print_r("XML DOC: ".$xml);
//$string =$fileXML;                                                                       
global $conn;                                      
//$xml = simplexml_load_string($string); 
//print_r($xml);
//$json_string = json_encode($xml);
echo "\nEntered lenStar.php\n";
//$result_array = json_decode($json_string, TRUE);
$patient = (string) $xml->Patient['ID'];
print_r('\nLenstar PatientID: '.$patient."\n");
$LastName = $xml->Patient['LastName'];
$LastName = str_ireplace(".","",$LastName);
$LastName = str_ireplace(" ","",$LastName);
$LastName = html2txt($LastName); //removes offensive tags
print_r('LastName: '.$LastName."\n");

$FirstName = (string) $xml->Patient['FirstName'];
// strip off any MI
$Mi = "";
// find a space -
$space = strpos($FirstName," ");
$FirstName1 = strrev( strchr(strrev($FirstName)," ") );
$FirstName1 = str_ireplace(".","",$FirstName1);
$FirstName1 = str_ireplace(" ","",$FirstName1);
$FirstName1 = html2txt($FirstName1);
print_r('FirstName1: '.$FirstName1."\n");

$Mi2 =  strstr($FirstName," ") ;  // gives false if no space, or space plus rest  --like " S." if exists
if ($Mi2) $Mi = str_ireplace(" ","",$Mi2);
$Mi = str_ireplace(".","",$Mi);
$Mi = str_ireplace(",","",$Mi);
print_r( "MI = ".$Mi ."\n");
$FirstName = $FirstName1;
print_r("Firstname = ".$FirstName);
// remove periods, anything not numchars
$Birthday = (string) $xml->Patient['Birthday'];
$Ethnicity = (string) $xml->Patient['Ethnicity'];
$Sex = (string) $xml->Patient['Sex'];
$Sex = strtoupper(substr($Sex, 0, 1));
$Thisuser = (string) $xml->Login['User'];
$Thispwd = (string) $xml->Login['Pwd'];
$Technician=(string) $xml->Login['Technician'];
$Office=(string) $xml->Login['Office'];
$Surgeon=(string)$xml->Login['Surgeon'];
$ChartID=(string)$xml->Login['ID'];

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
        if ($result_array1['R1Axis']==="-----") $result_array1['R1Axis']=180;
        if ($result_array1['Pupil']==="-----") $result_array1['Pupil']="";
        print_r($result_array1);
        
}
if (isset($xml->Patient->Exam[1])) {
	$json_string = json_encode($xml->Patient->Exam[1]);
        // remove the @attribute tag, and the final}
 	$result_array2 =  substr_replace($json_string, '', $start=0,$length=15);
	$result_array2 =  substr_replace($result_array2, '', $start=-1);
        
        $result_array2 = json_decode($result_array2, TRUE);
        if ($result_array2['R1Axis']==="-----") $result_array2['R1Axis']=180;
        if ($result_array2['Pupil']==="-----") $result_array2['Pupil']="";
       print_r($result_array2);
 
}
echo "Logging in...\n";
include "lenstarLogin.php";  // does the login logic, borrowed from standard code

function emptyToNull($ChartID) { return(empty($ChartID)?'NULL':"'".$ChartID."'.");}

//$dbowner should be set from here
if ($loginSuccess) {
    echo "Logging in Success...\n";
	// CREATE A NEW RECORD, OR UPDATE AN OLD ONE
    // First check to see if the patient is in the record
    $findNameQry = "Select * from patients where `LastName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($LastName)."','99220a8fde41445eab441169c1d80e2c')) as char)
         AND `FirstName` = cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($FirstName)."','99220a8fde41445eab441169c1d80e2c')) as char) AND `BirthDate` = date('" .$conn->real_escape_string($Birthday). "') AND `ChartID`=".$conn->real_escape_string($ChartID) ." AND dbowner=".$_SESSION['OwnerID'];
    print_r("\n............\n");
    print_r($findNameQry);
    $res =  mysqli_query($conn, $findNameQry);
    if ($res->num_rows>0) {  // found a record
        $found = mysqli_fetch_array($res);
        if ($found) {
        // found the record, get the ID and insert the preop exam;
            $patientID =$found['ID'];
            echo "\nFound PatientID: " .$patientID;
        }
    } else {   // need to insert a new record
        $sqlPatInsert = "INSERT INTO patients (LastName,FirstName,MI,BirthDate,Ethnicity,Sex,dbowner,Surgeon,Office,ChartID) values (cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($LastName)."','99220a8fde41445eab441169c1d80e2c')) as char),";
        $sqlPatInsert .= " cast(hex(DES_ENCRYPT( '".$conn->real_escape_string($FirstName)."','99220a8fde41445eab441169c1d80e2c')) as char),'".$Mi."',date('".($conn->real_escape_string($Birthday))."'),'".$Ethnicity."','".$Sex."',".$_SESSION['OwnerID'].",".$Surgeon.",".$Office.",".emptyToNull($conn->real_escape_string($ChartID)).")";
        print_r($sqlPatInsert);
        $insertPatient =  mysqli_query($conn, $sqlPatInsert);
        if($insertPatient) $patientID = mysqli_insert_id ( $conn); // gets most recent ID
        if (!$insertPatient) 
        {
            echo("Patient Insertion failed\n");
		    print_r('Patient Insertion error: ' . $conn->errno. " ". $conn->error);
            exit();
        }
    }
    echo "\nPatientID: " .$patientID;
   // $fields = mysqli_fetch_all(mysqli_query($conn, "SHOW COLUMNS FROM PREOP"));
    //echo($fields);
    // found the record, get the ID and insert the preop exam;
    // <Exam Eye="OD" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.13" R2="7.74" R1Axis="97" FlatK1="41.50" SteepK1="43.61" Astigmatism="2.12 " AxisAstig="7" n="1.3375" 
    // CCT="567" AD="2.99" LT="4.62" AL="26.42" WTW="12.31" Pupil="-----" />
    //  <Exam Eye="OS" Time="2013/07/25 13:40" MeasurementMode="Phakic" R1="8.06" R2="7.75" R1Axis="84" FlatK1="41.85" SteepK1="43.53" Astigmatism="1.68 " AxisAstig="174" n="1.3375" CCT="566" AD="2.99" LT="4.65" AL="26.40" WTW="12.28" Pupil="-----" /> 


// this should be added to the LenStar XML file

    if (count($result_array1)>0){  // insert this record
            $AvgRc = ($result_array1['R1']+$result_array1['R2'])/2;
            $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,Pupil,dbowner)";
            $preopInsert .=" values (".$patientID.",". $Technician.",".$Office.",'".$result_array1['Eye']."',".$result_array1['FlatK1'];
            $preopInsert .=",".$result_array1['SteepK1'].",".$result_array1['AxisAstig'].",".$result_array1['AL'];
            $preopInsert .=",".$result_array1['CCT'].",".$result_array1['ACD'].",".$result_array1['LT'].",".$result_array1['WTW'].",13,".$AvgRc.",CONVERT('".$result_array1['Time']."',datetime),".emptyToNull($result_array1['Pupil']).",".$_SESSION['OwnerID'].")";
            //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array1
            echo($preopInsert);
			$stmt = mysqli_prepare($preopInsert);
			if ($stmt) {
				$insert = $stmt->execute();
				$stmt->close();
				}
			else "Insert Prepare failed: " .$conn->error;
		
            print_r("\n............\n");

            if ($insert){
                print_r("Data1 Insertion succeeded\n");
            }
                else print_r("Data1 Insertion failed\n".$conn->error) ;
    }
    if (count($result_array2)>0){  // insert this record
            $AvgRc = ($result_array2['R1']+$result_array2['R2'])/2;
            $preopInsert = "INSERT INTO preop (PatientID,Technician,Office,Eye,FlatK,SteepK,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,ExamDateTime,Pupil,dbowner)";
            $preopInsert .=" values (".$patientID.",". $Technician.",".$Office.",'".$result_array2['Eye']."',".$result_array2['FlatK1'];
            $preopInsert .=",".$result_array2['SteepK1'].",".$result_array2['AxisAstig'].",".$result_array2['AL'];
            $preopInsert .=",".$result_array2['CCT'].",".$result_array2['ACD'].",".$result_array2['LT'].",".$result_array2['WTW'].",13,".$AvgRc.",CONVERT('".$result_array1['Time']."',datetime),".emptyToNull($result_array1['Pupil']).",".$_SESSION['OwnerID'].")";
            //,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array2
            echo($preopInsert);
			$stmt = mysqli_prepare($preopInsert);
			if ($stmt) {
				$insert = $stmt->execute();
				$stmt->close();
				}
			else "Insert Prepare failed: " .$conn->error;
		
            print_r("\n............\n");

            if ($insert){
                print_r("Data1 Insertion succeeded\n");
            }
                else print_r("Data1 Insertion failed\n".$conn->error) ;   
    }
}
else 
        // unsuccessful login
		echo "LOGIN FAILED";
exit();
?>