<?php
namespace Tashi\LocationBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\CmnLocationCountryMaster;
use Tashi\CommonBundle\Entity\CmnLocationStateMaster;
use Tashi\CommonBundle\Entity\CmnLocationDistrictMaster;
use Tashi\CommonBundle\Entity\CmnLocationCityMaster;
use Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster;


class LocationService {
    //put your code here
    
    protected $em;
    protected $session;
    protected $commonService;
    protected $webRoot;

    public function __construct(EntityManager $em, Session $session, $rootDir, $commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->commonService = $commonService;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
    }
    
    /*************this service is mainly for Country Location(Adding, Updating , Retrieving ,Deleting) master************/
public function addCountryMaster($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $country = $dataUI->country;
            $code=$dataUI->countrycode;
            $CountryNameObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findOneBy(array('countryName' => $country, 'recordActiveFlag' => 1));
            $CountryCodeObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findOneBy(array('countryCode' => $code, 'recordActiveFlag' => 1));
            $Codeflag = 0;
            if($CountryNameObj && !is_null($CountryNameObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! Country Name already Exist',
                            'codeFlag' => $Codeflag
                    );
            }
             if($code!='' && $CountryCodeObj && !is_null($CountryCodeObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! Country Code already Exist ',
                            'codeFlag' => $Codeflag
                    );
            }
            else
            {  
                $CountryObj = new CmnLocationCountryMaster();
                $CountryObj->setCountryName($country);
                $CountryObj->setCountryCode($code);
                $CountryObj->setRecordInsertDate(new \Datetime());
                $CountryObj->setRecordActiveFlag(1);
                $CountryObj->setApplicationUserId($this->session->get('EMPID'));
                $CountryObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($CountryObj);
                $this->em->flush();
                $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('CmnLocationCountryMaster') ;
                $id=$CountryObj->getCountryPk();
            }
//        } catch (\Exception $ex) {
//            throw new \Exception(CommonConstant::ERR_DB_OPERATION);
//        }        
//    }  
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
    public function updateCountryMaster($request) 
     {
      
        try {
            $dataUI = json_decode($request->getContent());
            $cid= $dataUI->inputcid;
            $ccountry = $dataUI->country;
            $ccode=$dataUI->countrycode;   
            
            $CountryNameObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findBy(array('countryName'=>$ccountry,'recordActiveFlag' => 1));
            $Codeflag = 0;
            
            if($CountryNameObj)
            {   
                foreach($CountryNameObj as $country){
                    if($country->getCountryPk()!=$cid && $country->getCountryName()==$ccountry){
                       return array('msg' => 'Country Name already Exist',
                            'codeFlag' => 1);
                    }
                    if($ccode!='' && $country->getCountryPk()!=$cid && $country->getCountryCode()==$ccode){
                       return array('msg' => 'Country Code already Exist',
                            'codeFlag' => 1);                       
                    }
                }       
            }
            
            $CountryObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($cid);
            $CountryObj->setCountryName($ccountry);
            $CountryObj->setCountryCode($ccode);
            $CountryObj->setRecordUpdateDate(new \Datetime());
            $CountryObj->setApplicationUserId($this->session->get('EMPID'));
            $CountryObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush(); 
            $returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('CmnLocationCountryMaster') ;
                $id=$CountryObj->getCountryPk();
            }
//            return array('msg' => 'Update Record Sucessfully',
//                         'result' => $this->commonService->activeList('CmnLocationCountryMaster'),
//                         'id' => $CountryObj->getCountryPk(),
//                         'codeFlag' => $Codeflag
//            );                           
//            
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//     }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
    
     public function retreiveCountrydetails($cid) 
      {

        try {
            $CountryObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($cid);
         
            $return = array('cid' => $cid,
                'countryname' => $CountryObj->getCountryName(),
                'countrycode' => $CountryObj->getCountryCode());
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
        public function deleteCountryMaster($cid) 
     {
      
        try {        
            $CountryObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($cid);   
            $CountryObj->setRecordActiveFlag(0);
            $CountryObj->setRecordUpdateDate(new \DateTime("NOW"));
            $CountryObj->setApplicationUserId($this->session->get('EMPID'));
            $CountryObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();  
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('CmnLocationCountryMaster') ;
            $id=$CountryObj->getCountryPk();
            
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Sucessfully',
//            'result' => $this->commonService->activeList('CmnLocationCountryMaster'),
//            'id' => $CountryObj->getCountryPk());
//     }
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
     

    // for state--------------------------------
    public function saveStateMaster($request) {
        try {

            $dataUI = json_decode($request->getContent());

            $state = $dataUI->state;
            $Scode=$dataUI->statecode;
            $countrycode=$dataUI->country; 
            $StateNameObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findOneBy(array('stateName' => $state, 'recordActiveFlag' => 1));
            $StateCodeObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findOneBy(array('stateCode' => $Scode, 'recordActiveFlag' => 1));
            $Codeflag = 0;
            if($StateNameObj && !is_null($StateNameObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! State Name already Exist',
                            'codeFlag' => $Codeflag
                    );
            }
            if($Scode!='' && $StateCodeObj && !is_null($StateCodeObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! State Code already Exist ',
                            'codeFlag' => $Codeflag
                    );
            }
            else
            {  
            $StateObj=new CmnLocationStateMaster();
            $StateObj->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countrycode));
            $StateObj->setStateName($state);
            $StateObj->setStateCode($Scode);
            $StateObj->setRecordInsertDate(new \Datetime());
            $StateObj->setRecordActiveFlag(1);
            $StateObj->setApplicationUserId($this->session->get('EMPID'));
            $StateObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($StateObj);
            $this->em->flush();
            $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('CmnLocationStateMaster') ;
                $id=$StateObj->getStatePk();
            } 
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            return array('msg' => 'Record Save Sucessfully',
//                         'result' => $this->commonService->activeList('CmnLocationStateMaster'),
//                         'id' => $StateObj->getStatePk(),
//                         'codeFlag' => $Codeflag
//                         );
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//
//    }
    
    public function updateStateMaster($request) 
     {
      
        try {
            $dataUI = json_decode($request->getContent());
            $sid= $dataUI->inputsid;
            $sname = $dataUI->state;
            $Scode=$dataUI->statecode;
            $countrycode=$dataUI->country;
            
            $StateNameObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('stateName'=>$sname,'recordActiveFlag' => 1));
            $Codeflag = 0;
            
            if($StateNameObj)
            {   
                foreach($StateNameObj as $state){
                    if($state->getStatePk()!=$sid && $state->getStateName()==$sname){
                       return array('msg' => 'State Name already Exist',
                            'codeFlag' => 1);
                    }
                    if($Scode!='' && $state->getStatePk()!=$sid && $state->getStateCode()==$Scode){
                       return array('msg' => 'State Code already Exist',
                            'codeFlag' => 1);
                    }
                }       
            }           
            
            $StateObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($sid);
            $StateObj->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countrycode));
            $StateObj->setStateName($sname);
            $StateObj->setStateCode($Scode);
            $StateObj->setRecordUpdateDate(new \Datetime());
            $StateObj->setApplicationUserId($this->session->get('EMPID'));
            $StateObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();            
$returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('CmnLocationStateMaster') ;
                $id=$StateObj->getStatePk();
            }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            return array('msg' => 'Update Record Sucessfully',
//                         'result' => $this->commonService->activeList('CmnLocationStateMaster'),
//                         'id' => $StateObj->getStatePk(),
//                         'codeFlag' => $Codeflag
//                          );
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//     }
    
     public function retreiveStatedetails($sid) 
      {
        try {

            $StateObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($sid);
            $return = array('sid' => $sid,
                            'countryId' => $StateObj->getCountryCodeFk()->getCountryPk(),
                            'statename' => $StateObj->getStateName(),
                            'statecode' => $StateObj->getStateCode()
                           );
            
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
         public function deleteStateMaster($sid) 
     {
      
        try {           
            $StateObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($sid);
            $StateObj->setRecordActiveFlag(0);
            $StateObj->setRecordUpdateDate(new \Datetime()); 
            $StateObj->setApplicationUserId($this->session->get('EMPID'));
            $StateObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush(); 
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('CmnLocationStateMaster') ;
            $id=$StateObj->getStatePk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Delete Record Sucessfully',
//            'result' => $this->commonService->activeList('CmnLocationStateMaster'),
//            'id' => $StateObj->getStatePk());
//     }
    
    //for district
     public function saveDistrictMaster($request) {
        try {

            $dataUI = json_decode($request->getContent());

            
            $Scode=$dataUI->txt_state; 
            $countrycode=$dataUI->txt_country; 
            $district=$dataUI->districts;
            $districtcode=$dataUI->districtcode;
            
            $DistrictNameObj = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findOneBy(array('districtName' => $district, 'recordActiveFlag' => 1));
            $DistrictCodeObj = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findOneBy(array('districtCode' => $districtcode, 'recordActiveFlag' => 1));
            $Codeflag = 0;
            if($DistrictNameObj && !is_null($DistrictNameObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! District Name already Exist',
                            'codeFlag' => $Codeflag
                    );
            }
            if($districtcode!='' && $DistrictCodeObj && !is_null($DistrictCodeObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! District Code already Exist ',
                            'codeFlag' => $Codeflag
                    );
            }
            else
            {  
            $DistrictObj=new CmnLocationDistrictMaster();
            $DistrictObj->setCountryFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countrycode));
            $DistrictObj->setStateFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($Scode));
            $DistrictObj->setDistrictName($district);
            $DistrictObj->setDistrictCode($districtcode);
            $DistrictObj->setRecordInsertDate(new \Datetime());
            $DistrictObj->setRecordActiveFlag(1);
            $DistrictObj->setApplicationUserId($this->session->get('EMPID'));
            $DistrictObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($DistrictObj);
            $this->em->flush();
            $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('CmnLocationDistrictMaster') ;
                $id=$DistrictObj->getPkid();
            } 
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//                    return array('msg' => 'Record Save Sucessfully',
//                                 'result' => $this->commonService->activeList('CmnLocationDistrictMaster'),
//                                 'id' => $DistrictObj->getPkid(),
//                                 'codeFlag' => $Codeflag
//                                 );
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//
//    }
    
     public function updateDistrictMaster($request) 
     {
      
        try {
           $dataUI = json_decode($request->getContent());
            $did= $dataUI->inputdid;
            $Scode=$dataUI->txt_state; 
            $countrycode=$dataUI->txt_country; 
            $ddistrict=$dataUI->districts;
            $ddistrictcode=$dataUI->districtcode;
//            echo $did; die();
            $DistrictNameObj = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('districtName'=>$ddistrict,'recordActiveFlag' => 1));
            $Codeflag = 0;
            
            if($DistrictNameObj)
            {   
                foreach($DistrictNameObj as $district){
                    if($district->getPkid()!=$did && $district->getDistrictName()==$ddistrict){
                       return array('msg' => 'District Name already Exist',
                            'codeFlag' => 1);
                    }
                    if($ddistrictcode!='' && $district->getPkid()!=$did && $district->getDistrictCode()==$ddistrictcode){
                       return array('msg' => 'District Code already Exist',
                            'codeFlag' => 1);
                    }
                }       
            }         
            $DistrictObj=$this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($did);
            $DistrictObj->setCountryFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countrycode));
            $DistrictObj->setStateFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($Scode));
            $DistrictObj->setDistrictName($ddistrict);
            $DistrictObj->setDistrictCode($ddistrictcode);
            $DistrictObj->setRecordUpdateDate(new \Datetime());
            $DistrictObj->setApplicationUserId($this->session->get('EMPID'));
            $DistrictObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('CmnLocationDistrictMaster') ;
                $id=$DistrictObj->getPkid();
            }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            return array('msg' => 'Update Record Sucessfully',
//                         'result' => $this->commonService->activeList('CmnLocationDistrictMaster'),
//                         'id' => $DistrictObj->getPkid(),
//                         'codeFlag' => $Codeflag
//                          );
//            
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//     }     
     
     public function retreiveDistrictdetails($did) 
    {

        try {
            $DistrictObj = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($did);
            $country=$DistrictObj->getCountryFk();
            $stateArr=$this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->
                    findBy(array('countryCodeFk'=>$country,'recordActiveFlag'=>1),array('stateName'=>'ASC'));

            $stateIdArr=array();
            $stateNameArr=array();
            foreach($stateArr as $state ){
                array_push($stateIdArr,$state->getStatePk());
                array_push($stateNameArr,$state->getStateName());
            }
            $return = array('did' => $did,
                            'countryId' => $country->getCountryPk(),
                            'stateIdArr'=>$stateIdArr,'stateNameArr'=>$stateNameArr,
                            'stateId' => $DistrictObj->getStateFk()->getStatePk(),
                            'districtname' => $DistrictObj->getDistrictName(),
                            'districtcode' => $DistrictObj->getDistrictCode(),
                            );
            
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    

     public function deleteDistrictMaster($did) 
     {
      
        try {           
            $DistrictObj = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($did);
            $DistrictObj->setRecordActiveFlag(0);
            $DistrictObj->setRecordUpdateDate(new \Datetime());    
            $DistrictObj->setApplicationUserId($this->session->get('EMPID'));
            $DistrictObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('CmnLocationDistrictMaster') ;
            $id=$DistrictObj->getPkid();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Delete Record Sucessfully',
//            'result' => $this->commonService->activeList('CmnLocationDistrictMaster'),
//            'id' => $DistrictObj->getPkid());
//     }
    
    //for city
     public function saveCityMaster($request) {
        try {

            $dataUI = json_decode($request->getContent());

            
            $countrycode=$dataUI->txt_country; 
            $Scode=$dataUI->txt_state;
            $district=$dataUI->txt_district; 
            $city=$dataUI->city_name;
            $citycode=$dataUI->citycode;
            
            $CityNameObj = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findOneBy(array('cityName' => $city, 'recordActiveFlag' => 1));
            $CityCodeObj = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findOneBy(array('cityCode' => $citycode, 'recordActiveFlag' => 1));
            $Codeflag = 0;
            if($CityNameObj && !is_null($CityNameObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! City Name already Exist',
                            'codeFlag' => $Codeflag
                    );
            }
            if($citycode!='' && $CityCodeObj && !is_null($CityCodeObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! City Code already Exist ',
                            'codeFlag' => $Codeflag
                    );
            }
            else
            {  
            $districtObj=$this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district);
            $LocationObj=new CmnLocationCityMaster();
            $LocationObj->setCountryFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countrycode));
            $LocationObj->setStateFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($Scode));
            $LocationObj->setDistrictFk($districtObj);
            $LocationObj->setCityName($city);
            $LocationObj->setCityCode($citycode);
            $LocationObj->setRecordInsertDate(new \Datetime());
            $LocationObj->setRecordActiveFlag(1);
            $LocationObj->setApplicationUserId($this->session->get('EMPID'));
            $LocationObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($LocationObj);
            $this->em->flush();
            $returnmsg='Record Save Sucessfully';
                $result=$this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('districtFk'=>$district,'recordActiveFlag'=>1)) ;
                $id=$LocationObj->getCityPk();
            } 
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag,
                                'district'=>$districtObj
                            );
    }

//             return array('msg' => 'Record Save Sucessfully',
//                          'result' => $this->commonService->activeList('CmnLocationCityMaster'),
//                          'id' => $LocationObj->getCityPk(),
//                          'codeFlag' => $Codeflag
//                           );           
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//    } 
    
     public function updateCityMaster($request) 
     {
      
        try {
            $dataUI = json_decode($request->getContent());
            $cid= $dataUI->inputcid;
            $countrycode=$dataUI->txt_country; 
            $Scode=$dataUI->txt_state;
            $district=$dataUI->txt_district; 
            $ccity=$dataUI->city_name;
            $ccitycode=$dataUI->citycode;
            
            $CityNameObj = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('cityName'=>$ccity,'recordActiveFlag' => 1));
            $Codeflag = 0;
            
            if($CityNameObj)
            {   
                foreach($CityNameObj as $city){
                    if($city->getCityPk()!=$cid && $city->getCityName()==$ccity){
                       return array('msg' => 'City Name already Exist',
                            'codeFlag' => 1);
                    }
//                    if($ccitycode!='' && $city->getCityPk()!=$cid && $city->getCityCode()==$ccitycode){
//                       return array('msg' => 'City Code already Exist',
//                            'codeFlag' => 1);
//                    }
                }       
            }
            $districtObj=$this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district);
            $LocationObj=$this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($cid);
            $LocationObj->setCountryFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countrycode));
            $LocationObj->setStateFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($Scode));
            $LocationObj->setDistrictFk($districtObj);
            $LocationObj->setCityName($ccity);
            $LocationObj->setCityCode($ccitycode);
            $LocationObj->setRecordUpdateDate(new \Datetime());  
            $LocationObj->setApplicationUserId($this->session->get('EMPID'));
            $LocationObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush(); 
            $returnmsg='Update Record Sucessfully';
            $result=$this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('districtFk'=>$district,'recordActiveFlag'=>1)) ;
            $id=$LocationObj->getCityPk();
            }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag,
                                'district'=>$districtObj
                            );
    }
//           return array('msg' => 'Update Record Sucessfully',
//                        'result' => $this->commonService->activeList('CmnLocationCityMaster'),
//                        'id' => $LocationObj->getCityPk(),
//                        'codeFlag' => $Codeflag
//                         );
//            
//            
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//     }
    
    
    public function retreiveCitydetails($cid) 
      {

        try {
            $CityObj = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($cid);
            $country=$CityObj->getCountryFk();
            $stateArr=$this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->
                    findBy(array('countryCodeFk'=>$country,'recordActiveFlag'=>1),array('stateName'=>'ASC'));

            $stateIdArr=array();
            $stateNameArr=array();
            foreach($stateArr as $state ){
                array_push($stateIdArr,$state->getStatePk());
                array_push($stateNameArr,$state->getStateName());
            }
            
            $districtArr=$this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->
                    findBy(array('countryFk'=>$country,'recordActiveFlag'=>1),array('districtName'=>'ASC'));

            $districtIdArr=array();
            $districtNameArr=array();
            foreach($districtArr as $district ){
                array_push($districtIdArr,$district->getPkid());
                array_push($districtNameArr,$district->getDistrictName());
            }
            $return = array('cid' => $cid ,
                            'countryId' => $country->getCountryPk(),
                            'stateIdArr'=>$stateIdArr,'stateNameArr'=>$stateNameArr,
                            'stateId' => $CityObj->getStateFk()->getStatePk(),
                            'districtIdArr'=>$districtIdArr,'districtNameArr'=>$districtNameArr,
                            'districtId' => $CityObj->getDistrictFk()->getPkid(),
                            'cityname' => $CityObj->getCityName(),
                            'citycode' => $CityObj->getCityCode()
                            );
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
    
    public function deleteCityMaster($cid) 
     {
      
        try {            
            $LocationObj=$this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($cid);
            $LocationObj->setRecordActiveFlag(0);
            $LocationObj->setRecordUpdateDate(new \Datetime()); 
            $LocationObj->setApplicationUserId($this->session->get('EMPID'));
            $LocationObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('CmnLocationCityMaster') ;
            $id=$LocationObj->getCityPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Delete Record Sucessfully',
//            'result' => $this->commonService->activeList('CmnLocationCityMaster'),
//            'id' => $LocationObj->getCityPk());
//     }
    
    // for address type
    
     public function saveAddressTypeMaster($request) 
            {
       try {

           $dataUI = json_decode($request->getContent());

            $addType = $dataUI->addressType;
            $addTypecode=$dataUI->addressTypeCode;
            
            $AddressTypeNameObj = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findOneBy(array('addressTypeName' => $addType, 'recordActiveFlag' => 1));
            $AddressTypeCodeObj = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findOneBy(array('addressTypeCode' => $addTypecode, 'recordActiveFlag' => 1));
            $Codeflag = 0;
            if($AddressTypeNameObj && !is_null($AddressTypeNameObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! Address Type already Exist',
                            'codeFlag' => $Codeflag
                    );
            }
            if($addTypecode!='' && $AddressTypeCodeObj && !is_null($AddressTypeCodeObj))
            {   $Codeflag = 1;
           
                return array('msg' => '! Address Type Code already Exist ',
                            'codeFlag' => $Codeflag
                    );
            }
            else
            { 
            $AddressTypeObj = new CmnLocationAddressTypeMaster();
            $AddressTypeObj->setAddressTypeName($addType);
            $AddressTypeObj->setAddressTypeCode($addTypecode);
            $AddressTypeObj->setRecordActiveFlag(1);
            $AddressTypeObj->setRecordInsertDate(new \Datetime());
            $AddressTypeObj->setApplicationUserId($this->session->get('EMPID'));
            $AddressTypeObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($AddressTypeObj);
            $this->em->flush();
            $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('CmnLocationAddressTypeMaster') ;
                $id=$AddressTypeObj->getAddressTypePk();
            } 
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            return array('msg' => 'Record Save Sucessfully',
//                         'result' => $this->commonService->activeList('CmnLocationAddressTypeMaster'),
//                         'id' => $AddressTypeObj->getAddressTypePk(),
//                         'codeFlag' => $Codeflag
//                         );
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//    }
    
    public function updateAddressTypeMaster($request, $aTid) 
     {
      
        try {
            $dataUI = json_decode($request->getContent());
            $addTypes = $dataUI->addressType;
            $addTypecode=$dataUI->addressTypeCode;
           
            $AddressTypeNameObj = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findBy(array('recordActiveFlag' => 1));
            $Codeflag = 0;
            
            if($AddressTypeNameObj)
            {   
                foreach($AddressTypeNameObj as $addType){
                    if($addType->getAddressTypePk()!=$aTid && $addType->getAddressTypeName()==$addTypes){
                       return array('msg' => 'Address Name already Exist',
                            'codeFlag' => 1);
                    }
                    if($addTypecode!='' && $addType->getAddressTypePk()!=$aTid && $addType->getAddressTypeCode()==$addTypecode){
                       return array('msg' => 'Address Code already Exist',
                            'codeFlag' => 1);
                    }
                }       
            }              
            $AddressTypeObj = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($aTid);
            $AddressTypeObj->setAddressTypeName($addTypes);
            $AddressTypeObj->setAddressTypeCode($addTypecode);
            $AddressTypeObj->setRecordUpdateDate(new \Datetime()); 
            $AddressTypeObj->setApplicationUserId($this->session->get('EMPID'));
            $AddressTypeObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();             
$returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('CmnLocationAddressTypeMaster') ;
                $id=$AddressTypeObj->getAddressTypePk();
            }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            return array('msg' => 'Update Record Sucessfully',
//                         'result' => $this->commonService->activeList('CmnLocationAddressTypeMaster'),
//                         'id' => $AddressTypeObj->getAddressTypePk(),
//                         'codeFlag' => $Codeflag
//                         );
//            
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//     }
    
        
     public function retreiveAddressTypedetails($aTid) 
      {
        try {
            $AddressTypeObj = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($aTid);
            $return = array('aTid' => $aTid,
                'addressTypeName' => $AddressTypeObj->getAddressTypeName(),
                'addressTypeCode' => $AddressTypeObj->getAddressTypeCode());
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }

     public function deleteAddressTypeMaster($aTid) 
     {
      
        try {            
            $AddressTypeObj=$this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($aTid);
            $AddressTypeObj->setRecordActiveFlag(0);
            $AddressTypeObj->setRecordInsertDate(new \Datetime());
            $AddressTypeObj->setApplicationUserId($this->session->get('EMPID'));
            $AddressTypeObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('CmnLocationAddressTypeMaster') ;
            $id=$AddressTypeObj->getAddressTypePk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Delete Record Sucessfully',
//            'result' => $this->commonService->activeList('CmnLocationAddressTypeMaster'),
//            'id' => $AddressTypeObj->getAddressTypePk());
//     }
    
    
    /*********************************Ends here******************************************/

    
     public function displayAllResult($tbl_name){  
         try {
                return $this->commonService->activeList($tbl_name);
         }
         catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    
}

 
}