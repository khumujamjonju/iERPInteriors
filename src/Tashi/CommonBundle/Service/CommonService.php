<?php

namespace Tashi\CommonBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\XmlEncoder;                    // symfony serializer
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\RequestStack;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
class CommonService {
    //put your code here
    protected $em;
    protected $session;
    protected $webRoot;   
    protected $request;  
    public function __construct(EntityManager $em, Session $session,$rootDir,RequestStack $request_stack) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = str_replace('app', '', $rootDir);
        $this->request=$request_stack;
    }    
    public function getSerializer() {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        return new Serializer($normalizers, $encoders);
    }
    public function check($entityName) {
        return $entityName;
    }
    public function displayAllRecords($entityName) {
        return $this->em->getRepository('TashiCommonBundle:' . $entityName)->findAll(); //findAll(array('activeFlag'=>1));
    }

    public function activeList($entityName) {
        $query = $this->em->createQuery("SELECT r  FROM TashiCommonBundle:" . $entityName . " r WHERE r.recordActiveFlag = 1");
        return $query->getResult();
    }

    public function inactiveList($entityName) {
        $query = $this->em->createQuery("SELECT r  FROM TashiCommonBundle:" . $entityName . " r WHERE r.recordActiveFlag = 0");
        return $query->getResult();
    }

   public function displayRecordsById($entityName, $entityId) {
        return $this->em->getRepository('TashiCommonBundle:' . $entityName)->find($entityId);
    }
    
   public function getBranchIdByGivingEmpId($empID) {
        $empObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeeId($empID);
        return $empObj->getBranchOfficeCode()->getPkid();
    }
    
    
    //date string reverse
    public function reverseDate($date){
        $array = explode('-', $date);
        $rev = array_reverse($array);
        $date = implode('-', $rev);
        return $date;
    }
    
    /*****************************ERP***********************/
    public function getJsonData($erpMessage) {
        try {
            /* get the serializer object */
            $serializer = $this->getSerializer();
            $jsondata = $serializer->serialize($erpMessage, 'json');
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $jsondata;
    }

    public function checkrole($controllerName)
    {
        //$accessRight = 0;
        try {   
            // $session = $this->getRequest()->getSession();
            if($this->session->get('PRIVILEGE')=='Su'){
                return 1;
            }
            $arrayOFRole = $this->session->get('ROLELIST');
            foreach($arrayOFRole as $arrayRole)
                {
                if($arrayRole['Role']==$controllerName)
                    { 
                        return 1; 
                    }
                }  
                return 0; //change it to false boolean after implementation of user access controll...
        }catch (\Exception $ex) 
        {
            return 0; //change it to false boolean after implementation of user access controll...
            /* render the error_menu twig file with parameter Label Name */
        }
    }
    
    public function getAll($tbName){
        return $this->em->getRepository($tbName)->findAll();   
    }
    public function getRecordById($tbName,$id){
        return $this->em->getRepository($tbName)->find($id);
    }
    public function getRecordsByArray($tbName,$criteriaArr){
        return $this->em->getRepository($tbName)->findBy($criteriaArr);    
    }
    public function getOneRecordByArray($tbName,$criteriaArr){
        return $this->em->getRepository($tbName)->findOneBy($criteriaArr);    
    }
    public function IsRecordExist($tbName,$criteria){
        try{
            $prd=$this->em->getRepository($tbName)->findOneBy($criteria);
            if($prd){
                return true;
            }
            else {
                return false;
            }
        }
        catch(\Exception $ex){
            return false;
        }
    }
    /*
     * This function is to check duplicate data entry in database for unique key field
     */
    public function isDuplicateEntry($dbale,$uKeyName){
        /*$dbale= DBalException Object
          $uKyeyName=Name of the Unique key in Database Table*/
        $errCode=$dbale->getPrevious()->errorInfo[1];
        $errMsg=$dbale->getPrevious()->errorInfo[2];
        echo $errMsg;
        if($errCode=='1062' && substr_count($errMsg,$uKeyName)>0){ //1062 is a system code that represents duplicate entry
            return true;
        }
        else{
            return false;
        }
    }
    public function AddressFormaterforDetail($address){
        $formattedAdd='';
        $add1=$address->getAddress1();
        $add2=$address->getAddress2();
        $countryObj=$address->getCountryCodeFk();
        $stateObj=$address->getStateCodeFk();
        $cityObj=$address->getCityCodeFk();
        $distObj=$address->getDistrictFk();       
        $locality=$address->getLocality();
        $block=$address->getBlockVillage();
        if($countryObj){
            $country=$countryObj->getCountryName();
        }
        if($stateObj){
            $state=$stateObj->getStateName();
        }
        if($cityObj){
            $city=$cityObj->getCityName();
        }
        else{
            $city=$address->getCityName();
        }
        if($distObj){
            $district=$distObj->getDistrictName();
        }
        $pin=$address->getPinNumber();
        $ps=$address->getPoliceStation();
        $po=$address->getPostOffice();
        
        $formattedAdd.=$add1;
        if(!empty($add2)){
            $formattedAdd.='<br/>'.$add2;
        }
        if(!empty($city)){
            $formattedAdd.='<br/>'.$city;
        }
        if(!empty($state)){
            $formattedAdd.='<br/>'.$state;
        }
        $formattedAdd.='-'.$pin;
        if(!empty($country)){
            $formattedAdd.='<br/>'.$country;
        }        
        if(!empty($district)){
            $formattedAdd.='<br/><strong>District:</strong> '.$district;
        }        
        if(!empty($locality)){
            $formattedAdd.='<br/><strong>Locality:</strong> '.$locality;
        }
        if(!empty($block)){
            $formattedAdd.='<br/><strong>Block/Village:</strong> '.$block;
        }         
        return $formattedAdd;
    }
    public function AddressFormaterforList($address){
        $formattedAdd='';
        $add1=$address->getAddress1();
        $add2=$address->getAddress2();
        $countryObj=$address->getCountryCodeFk();
        $stateObj=$address->getStateCodeFk();
        $cityObj=$address->getCityCodeFk();
        $distObj=$address->getDistrictFk();       
        $locality=$address->getLocality();
        $block=$address->getBlockVillage();
        if($countryObj){
            $country=$countryObj->getCountryName();
        }
        if($stateObj){
            $state=$stateObj->getStateName();
        }
        if($cityObj){
            $city=$cityObj->getCityName();
        }
        else{
            $city=$address->getCityName();
        }
        if($distObj){
            $district=$distObj->getDistrictName();
        }
        $pin=$address->getPinNumber();
        
        $formattedAdd.=$add1;
        if(!empty($add2)){
            $formattedAdd.=$add2;
        }
        if(!empty($locality)){
            $formattedAdd.=', '.$locality;
        }
        if(!empty($block)){
            $formattedAdd.=', '.$block;
        }
        if(!empty($city)){
            $formattedAdd.=', '.$city;
        }
        if(!empty($district)){
            $formattedAdd.=', '.$district;
        }
        if(!empty($state)){
            $formattedAdd.=', '.$state;
        }
        $formattedAdd.='-'.$pin;
        if(!empty($country)){
            $formattedAdd.=', '.$country;
        }            
        return $formattedAdd;
    }    
    public function getLatestNumber($tbname,$autoColName){
        $qb=$this->em->createQueryBuilder();
        $qb->select('max(tb.'.$autoColName.') as number')
                ->from('TashiCommonBundle:'.$tbname,'tb');
        $query=$qb->getQuery();
        $result=$query->getResult();
        if($result){
            return $result;
        }
        else{
            return 1;
        }
    }
    public function AutoGenerate($prefixChar,$length,$tbname,$autoColName){        
        $result=$this->getLatestNumber($tbname, $autoColName);
        $number=$result[0]['number'];
        if(!$number){
            $number=1;
        }
        while(strlen($number)<=$length){
            $number='0'.$number;
        }
        return $prefixChar.$number;
    }
    public function RandomAlpha($length){
         $str='ASDFGHJKLQWERTYUIOPZXCVBNMpoiuytrewqlkjhgfdsamnbvcxz';
         $random='';
         while(strlen($random)<$length){
             $i=rand(0,  strlen($str)-1);
             $random.=$str[$i];
         }
         return $random;                 
    }
    public function RandomDigit($length){
         $str='12345678900987654321';
         $random='';
         while(strlen($random)<$length){
             $i=rand(0,  strlen($str)-1);
             $random.=$str[$i];
         }
         return $random;
                 
    }
    public function RandomAlphaNumeric($length){
         $str='123456789ASDFGHJKLQWERTYUPZXCVBNM987654321';
         $random='';
         while(strlen($random)<$length){
             $i=rand(0,  strlen($str)-1);
             $random.=$str[$i];
         }
         return $random;                 
    }
    public function UploadFile($fileupload,$path,$maxFileSizeinMb,$validFileExtArr){
        $fullpath='';
        try{
            //$maxFileSizeinMb; // 512Kb
           // $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
            $fullname=$fileupload->getClientOriginalName();
            $fext=  pathinfo($fullname,PATHINFO_EXTENSION);
            $foriname=  pathinfo($fullname,PATHINFO_FILENAME);        
            $fsize=$fileupload->getClientSize();
            $ftype=$fileupload->getClientMimeType();  
            if(count($validFileExtArr)>1){
                if(!in_array($ftype, $validFileExtArr)){
                    return array('code'=>0,'msg'=>'The file(s) you have selected is invalid.');
                }
            }
//            if($maxFileSizeinMb!=0 && ($fsize/1024)/1024>$maxFileSizeinMb || $fsize==0){
//                return array('code'=>0,'msg'=>'File size exceeds maximum uploadable size. Recommended size is upto '.$maxFileSizeinMb.'Mb');
//            }
            $newfname=$this->RandomAlpha(rand(10,30)).'.'.$fext;           
            $dirpath=  $this->webRoot.'web/'.$path; //path without the new filename
            $dirStatus=false;
            if(is_dir($dirpath)){
                $dirStatus=true;
            }
            else{
                $dirStatus=mkdir($dirpath,0777,true);
            }
            if($dirStatus){                        
                $tempFpath=$dirpath.$newfname; //path with filename
                if (!is_dir($tempFpath) && !file_exists($tempFpath)) {
                   $fullpath= $fileupload->move($dirpath,$newfname); 
                }
            }
            return array('code'=>1,'msg'=>'','fullpath'=>$fullpath,'newname'=>$newfname,'oriname'=>$foriname,
                         'ext'=>$fext);
        }catch(\Exception $ex){
            if(file_exists($fullpath)){
                unlink($fullpath);
            }
            return array('code'=>0,'msg'=>'Error while uploading file.'.$ex->getMessage());
        }
    } 
    public function UploadFileWithOriginalName($fileupload,$path,$maxFileSizeinMb,$validFileExtArr){
        $fullpath='';
        try{
            //$maxFileSizeinMb; // 512Kb
           // $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
            $fullname=$fileupload->getClientOriginalName();
            $fext=  pathinfo($fullname,PATHINFO_EXTENSION);
            $foriname=  pathinfo($fullname,PATHINFO_FILENAME);        
            $fsize=$fileupload->getClientSize();
            $ftype=$fileupload->getClientMimeType();  
//            if(count($validFileExtArr)>1){
//                if(!in_array($ftype, $validFileExtArr)){
//                    return array('code'=>0,'msg'=>'The file(s) you have selected is invalid.');
//                }
//            }
            if($maxFileSizeinMb!=0 && ($fsize/1024)/1024>$maxFileSizeinMb || $fsize==0){
                return array('code'=>0,'msg'=>'File size exceeds maximum size. Recommended size is upto '.$maxFileSizeinMb.'Mb');
            }                       
            $dirpath=  $this->webRoot.'web/'.$path; //path without the new filename
            $dirStatus=false;
            if(is_dir($dirpath)){
                $dirStatus=true;
            }
            else{
                $dirStatus=mkdir($dirpath,0777,true);
            }
            if($dirStatus){                        
                $tempFpath=$dirpath.$fullname; //path with filename
                if (!is_dir($tempFpath) && !file_exists($tempFpath)) {
                   $fullpath= $fileupload->move($dirpath,$fullname); 
                }
            }
            return array('code'=>1,'msg'=>'','fullpath'=>$dirpath.$fullname,'oriname'=>$foriname,
                         'ext'=>$fext);
        }catch(\Exception $ex){
            if(file_exists($fullpath)){
                unlink($fullpath);
            }
            return array('code'=>0,'msg'=>'Error while uploading file.'.$ex->getMessage());
        }
    }
    function GetClientIP() {
    // check for shared internet/ISP IP    
        $server=$this->request->getCurrentRequest()->server;    
        if (!empty($server->get('HTTP_CLIENT_IP')) && $this->validate_ip($server->get('HTTP_CLIENT_IP'))) {
            return $server->get('HTTP_CLIENT_IP');
        }
        // check for IPs passing through proxies
        if (!empty($server->get('HTTP_X_FORWARDED_FOR'))) {
            // check if multiple ips exist in var
            if (strpos($server->get('HTTP_X_FORWARDED_FOR'), ',') !== false) {
                $iplist = explode(',', $server->get('HTTP_X_FORWARDED_FOR'));
                foreach ($iplist as $ip) {
                    if (validate_ip($ip))
                        return $ip;
                }
            } else {
                if (validate_ip($server->get('HTTP_X_FORWARDED_FOR')))
                    return $server->get('HTTP_X_FORWARDED_FOR');
            }
        }
        if (!empty($server->get('HTTP_X_FORWARDED')) && $this->validate_ip($server->get('HTTP_X_FORWARDED')))
            return $server->get('HTTP_X_FORWARDED');
        if (!empty($server->get('HTTP_X_CLUSTER_CLIENT_IP')) && $this->validate_ip($server->get('HTTP_X_CLUSTER_CLIENT_IP')))
            return $server->get('HTTP_X_CLUSTER_CLIENT_IP');
        if (!empty($server->get('HTTP_FORWARDED_FOR')) && $this->validate_ip($server->get('HTTP_FORWARDED_FOR')))
            return $server->get('HTTP_FORWARDED_FOR');
        if (!empty($server->get('HTTP_FORWARDED')) && $this->validate_ip($server->get('HTTP_FORWARDED')))
            return $server->get('HTTP_FORWARDED');

        // return unreliable ip since all else failed
        return $server->get('REMOTE_ADDR');
    }

    /**
     * Ensures an ip address is both a valid IP and does not fall within
     * a private network range.
     */
    function validate_ip($ip) {
        if (strtolower($ip) === 'unknown')
        {return false;}

        // generate ipv4 network address
        $ip = ip2long($ip);

        // if the ip is set and not equivalent to 255.255.255.255
        if ($ip !== false && $ip !== -1) {
            // make sure to get unsigned long representation of ip
            // due to discrepancies between 32 and 64 bit OSes and
            // signed numbers (ints default to signed in PHP)
            $ip = sprintf('%u', $ip);
            // do private network range checking
            if ($ip >= 0 && $ip <= 50331647) {return false;}
            if ($ip >= 167772160 && $ip <= 184549375) {return false;}
            if ($ip >= 2130706432 && $ip <= 2147483647) {return false;}
            if ($ip >= 2851995648 && $ip <= 2852061183) {return false;}
            if ($ip >= 2886729728 && $ip <= 2887778303) {return false;}
            if ($ip >= 3221225984 && $ip <= 3221226239) {return false;}
            if ($ip >= 3232235520 && $ip <= 3232301055) {return false;}
        if ($ip >= 4294967040) {return false;}
        }
        {return true;}
    }
    public function CommonError($ex,$errType){
        if(strcasecmp($errType, 'retrieval')==0){
            return \Tashi\CommonBundle\Helper\CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage();
        }elseif(strcasecmp($errType, 'dberror')==0){
            return \Tashi\CommonBundle\Helper\CommonConstant::ERR_DB_OPERATION.$ex->getMessage();
        }elseif(strcasecmp($errType, 'unknown')==0){
            return \Tashi\CommonBundle\Helper\CommonConstant::ERR_UNKNOWN.$ex->getMessage();
        }elseif(strcasecmp($errType, 'email')==0){
            return \Tashi\CommonBundle\Helper\CommonConstant::ERR_EMAIL_SENDING.$ex->getMessage();
        }
    }
    public function NumberToWords($no)
    {   
        $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
        if($no == 0)
            return ' ';
        else {
            $novalue='';
            $highno=$no;
            $remainno=0;
            $value=100;
            $value1=1000;       
            while($no>=100)    {
                if(($value <= $no) &&($no  < $value1))    {
                $novalue=$words["$value"];
                $highno = (int)($no/$value);
                $remainno = $no % $value;
                break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }       
            if(array_key_exists("$highno",$words))
                return $words["$highno"]." ".$novalue." ".$this->NumberToWords($remainno);
            else {
               $unit=$highno%10;
               $ten =(int)($highno/10)*10;            
               return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->NumberToWords($remainno);
            }
        }
    }
}

