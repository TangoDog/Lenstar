<?php
// WORKING ERSION
//error_reporting( E_ALL );
// Version 1.1 20131121
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

function preprint($str) { echo "\n".$str;}
function emptyToNull($val) {
    return(empty($val)?'NULL':$val);
}
$upload = $_FILES['file']['tmp_name'];
//
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
//$upload = "C:\FullMonteIOL\lensStar.xml";
$xml = file_get_contents($upload);
$xml = simplexml_load_string($xml); 
//print_r($xml);
//$string =$fileXML;                                                                       
global $conn;                                      
//$xml = simplexml_load_string($string); 
//print_r($xml);
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
    print_r("\n............\n");
    print_r($findNameQry);
    print_r("\n............\n");
    print_r($findNameQry1);
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
            echo "Found by Chart PatientID: " .$patientID;
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


// this should be added to the LenStar XML file

function dashToNull($value) {return ( is_numeric($value)? $value :'NULL');}

// right eye first
    if (count($result_array1)>0  && is_numeric($result_array1['FlatK1'])){  // insert this record
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
		   
    if (count($result_array2)>0  && is_numeric($result_array2['FlatK1'])){  // insert this record or update found postop
			$findPostOp2 = "Select * from postop where PatientID = ".$patientID ." AND Eye='".$result_array2['Eye']."'";// this should exist if postop was created from template
			preprint($findPostOp2);
			$postops = mysqli_query($conn, $findPostOp2);
			if ($postops) {
			   // records exist this should be an update
				if ($record = mysqli_fetch_array($postops)) {
					preprint('Entering Update Postop');
					$postopUpdate = "UPDATE postop set `PostopFlatK` = ".dashToNull($result_array2['FlatK1']).",`PostopSteepK` = ".emptyToNull($result_array2['SteepK1']).",`PostopAxisK` = ".emptyToNull($result_array2['AxisAstig']);
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
					$AvgRc = ($result_array2['R1']+$result_array2['R2'])/2;
									preprint('Entering Insert Postop');
					$preopInsert = "INSERT INTO postop (PatientID,BaseSurgeonID,SurgeonID,Eye,PostopFlatK,PostopSteepK,PostopAxisK,`Axial Length`,CCT,ACD,LensThick,WTW,Biometry,Rc,`Exam Date`,Pupil,dbowner,Keratometry)";
					$preopInsert .=" values (".$patientID.",". $Surgeon.",".$Surgeon.",'".$result_array2['Eye']."',".dashToNull($result_array2['FlatK1']);
					$preopInsert .=",".dashToNull($result_array2['SteepK1']).",".dashToNull($result_array2['AxisAstig']).",".dashToNull($result_array2['AL']);
					$preopInsert .=",".dashToNull($result_array2['CCT']).",".dashToNull($result_array2['ACD']).",".dashToNull($result_array2['LT']).",".dashToNull($result_array2['WTW']).",13,".$AvgRc.",CONVERT('".
									$result_array2['Time']."',datetime),".emptyToNull($result_array2['Pupil']).",".$_SESSION['OwnerID']."," .$KeraID .")";
					//,SteepAxis,`Axial Length`,CCT,ACD,LensThick,WTW$.$result_array2
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
				    //if ($record = mysqli_fetch_array($postops))
			} // if $postops
	} // insert this record or update found postop
}  // loginSuccess	
else      // unsuccessful login
     echo "LOGIN FAILED";
     

exit();
?>