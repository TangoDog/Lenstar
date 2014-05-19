<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xmlFile
 *
 * @author gerald
 */
class xmlFile extends CFormModel {
    //put your code here
    // attributes
    public $xmlfile; // where the file is uploaded
    public $DateTime;
    public $LastName;
    public $FirstName;
    public $Mi;
    public $ChartID;// = (string) $xml->Patient['ID'];

    public $Birthday;// = (string) $xml->Patient['Birthday'];
    public $Ethnicity;// = (string) $xml->Patient['Ethnicity'];
    public $Sex;// =;//(string) $xml->Patient['Sex'];
    public $Sex;// = strtoupper(substr($Sex, 0, 1));
    public $Thisuser;// = (string) $xml->Login['User'];
    public $Thispwd;//= (string) $xml->Login['Pwd'];  - guid here
    public $Technician;//=(string) $xml->Login['Technician'];
    public $Office;//string) $xml->Login['Office'];
    public $Surgeon ;// (string) $xml->Login['Surgeon'];
    public $preop;  // array of left and/or right eyes preop values
    public $postop;// array of left and/or right eyes preop values
    
    public function init(){
        // overrides CFormModel init
        // gets the posted xml file and stores it in attributes of this model
        if (isset($_FILES)) {
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
                //print_r($_FILES);
                //print_r("...........\n");
                //readfile($upload);
                //$upload = "C:\FullMonteIOL\lensStar.xml";
        
            $xml = file_get_contents($upload);
            $xmlfile = simplexml_load_string($xml); 
        } else throw new Exception('No File Uploaded- Process halted');
        parent::init();
        return(true);  // if success
    }
    
    public function setPatient() {
        if (isset($xmlfile)){
                $DateTime = new DateTime('NOW');
                Yii::trace( $DateTime->format('c')); // ISO8601 formated datetime
                //$result_array = json_decode($json_string, TRUE);
                $ChartID = (string) $xml->Patient['ID'];
                Yii::trace('Lenstar PatientID: '.$ChartID);
                $LastName = $xmlfile->Patient['LastName'];
                $LastName = str_ireplace(".","",$LastName);
                $LastName = str_ireplace(" ","",$LastName);
                $LastName = html2txt($LastName); //removes offensive tags
                Yii::trace('LastName: '.$LastName."");

                $FirstName = (string) $xmlfile->Patient['FirstName'];
                Yii::trace('FirstName: '.$FirstName);

                // strip off any MI
                $Mi = "";
                // find a space -
                Yii::trace('FirstName: '.$FirstName."\n");
                $FirstNameMI = getFirstNameMI($FirstName);
                $FirstName =  $FirstNameMI[0];           
                $MI =  $FirstNameMI[1];           
                $ChartID = (string) $xmlfile->Patient['ID'];

                $Birthday = (string) $xmlfile->Patient['Birthday'];
                $Ethnicity = (string) $xmlfile->Patient['Ethnicity'];
                $Sex = (string) $xmlfile->Patient['Sex'];
                $Sex = strtoupper(substr($Sex, 0, 1));
                $Thisuser = (string) $xmlfile->Login['User'];
                $Thispwd = (string) $xmlfile->Login['Pwd'];
                $Technician=(string) $xmlfile->Login['Technician'];
                $Office=(string) $xmlfile->Login['Office'];
                $Surgeon = (string) $xmlfile->Login['Surgeon'];
                return(true);
        }
       else return(false);

    }
    
    public function setPreop () {
        
    }
    
    public function setPostop () {
        
    }
    private function html2txt($document){
                $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
                );
                $text = preg_replace($search, '', $document);
                return $text;
    }  // end function html2txt

    // following are utility functions
    private function preprint($str) { echo "\n".$str;}
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
                    $FirstName1 = html2txt($FirstName1);
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
    
}  // end class xmlfile
