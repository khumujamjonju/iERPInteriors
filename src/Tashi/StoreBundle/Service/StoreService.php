<?php
namespace Tashi\StoreBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\StoreBuildingMaster;
use Tashi\CommonBundle\Entity\StoreFloorMaster;
use Tashi\CommonBundle\Entity\StoreMaster;
use Tashi\CommonBundle\Entity\StoreRackMaster;
use Tashi\CommonBundle\Entity\StoreRoomMaster;
use Tashi\CommonBundle\Entity\CmnLocationAddressMaster;
use Tashi\CommonBundle\Entity\StoreBinMaster;

class StoreService {    
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
    
    
    
      public function displayAllResult($tbl_name){  
         try {
                return $this->commonService->activeList($tbl_name);
         }
         catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    
}
    /*************this service is mainly for store store(Adding, Updating , Retrieving ,Deleting) master************/
public function saveStoreMaster($request) {
        try {

            $dataUI = json_decode($request->getContent());

            $storename = $dataUI->storename;
           // echo $storename; die();
            $storedescription=$dataUI->storedescription;

            $StoreObj = new StoreMaster();
            $StoreObj->setStoreName($storename);
            $StoreObj->setStoreDesc($storedescription);
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $this->em->persist($StoreObj);
            $this->em->flush();
            $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('StoreMaster') ;
                $id=$StoreObj->getStoreMasterPk();
             
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Record Save Sucessfully',
//            'result' => $this->commonService->activeList('StoreMaster'),
//            'id' => $StoreObj->getStoreMasterPk()
//        );
//    }
    
    public function updateAddStoreMaster($request, $Stid) 
     {
      
        try {
            $dataUI = json_decode($request->getContent());
            $storename = $dataUI->storename;
            $storedescription=$dataUI->storedescription;

           
            
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($Stid);
            $StoreObj->setStoreName($storename);
            $StoreObj->setStoreDesc($storedescription);

           
            $StoreObj->setRecordUpdateDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $this->em->persist($StoreObj);
            $this->em->flush();
            $returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('StoreMaster') ;
                $id=$StoreObj->getStoreMasterPk();
            }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                            );
    }           
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Update Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreMaster'),
//            'id' => $StoreObj->getStoreMasterPk());
//     }
    
     public function retreiveAddStoreAction($Stid) 
      {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($Stid);
            $return = array('Stid' => $Stid,
                'storename' => $StoreObj->getStoreName(),
                'storedescription' => $StoreObj->getStoreDesc(),
                'storeregistrationno' => $StoreObj->getRegisteredNo()
                );
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
        
    public function deleteAddStoreMaster($Stid) 
     {
      
        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($Stid);
            $StoreObj->setRecordActiveFlag(0);
            $StoreObj->setRecordUpdateDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($StoreObj);
            $this->em->flush();   
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('StoreMaster') ;
            $id=$StoreObj->getStoreMasterPk();
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
//            'result' => $this->commonService->activeList('StoreMaster'),
//            'id' => $StoreObj->getStoreMasterPk());
//     }
    
   /*************this service is mainly for store storebuilding(Adding, Updating , Retrieving ,Deleting) master************/
public function saveStoreDetailsBuildingAction($request) {
    $conn=$this->em->getConnection();
        try {
            $conn->beginTransaction();
            $dataUI = json_decode($request->getContent());
            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            
            $address1 = $dataUI->address1; 
            $address2 = $dataUI->address2;
            $country= $dataUI->txt_country; 
            $state = $dataUI->txt_state; 
            $district = $dataUI->txt_district; 
            $city = $dataUI->txt_city; 
            $pin = $dataUI->zipcode;     

            
            $CommonAddressObj = new CmnLocationAddressMaster();
            $CountryObj=$this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country);
            $StateObj=$this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state);
            $DistrictObj=$this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district);
            $CityObj=$this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city);
          
            
            $CommonAddressObj->setCountryCodeFk($CountryObj);
            $CommonAddressObj->setStateCodeFk($StateObj);
            $CommonAddressObj->setDistrictFk($DistrictObj);
            $CommonAddressObj->setCityCodeFk($CityObj);
            $CommonAddressObj->setAddress1($address1);
            $CommonAddressObj->setAddress2($address2);
            $CommonAddressObj->setPinNumber($pin);
            $CommonAddressObj->setRecordActiveFlag(1); 
            $CommonAddressObj->setRecordInsertDate(new \Datetime());
            $CommonAddressObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonAddressObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($CommonAddressObj);
            $this->em->flush();
            
            $StoreObj = new StoreBuildingMaster();
            $StoreObj->setStoreMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storenameId));
            $StoreObj->setBuildingName($buildingname);
            $StoreObj->setAddressMasterFk($CommonAddressObj);
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $this->em->persist($StoreObj);
            $this->em->flush();
            $conn->commit(); 
            $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('StoreBuildingMaster') ;
                $id=$StoreObj->getStoreBuildingPk();
             
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            $conn->rollBack();
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Record Save Sucessfully',
//            'result' => $this->commonService->activeList('StoreBuildingMaster'),
//            'id' => $StoreObj->getStoreBuildingPk()
//        );
//    }
    
    public function updateAddStoreBuildingAction($request, $StBid) {
                $conn=$this->em->getConnection();
        try {
            $conn->beginTransaction();
            $dataUI = json_decode($request->getContent());
            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            $address1 = $dataUI->address1;
            $address2 = $dataUI->address2;
            $country = $dataUI->txt_country;
            $state = $dataUI->txt_state;
            $district = $dataUI->txt_district;
            $city = $dataUI->txt_city;
            $zipcode = $dataUI->zipcode;
            
            $StoreBuidingObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($StBid);
            
            $StoreBuidingObj->setStoreMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storenameId));
            $StoreBuidingObj->setBuildingName($buildingname);
            $StoreBuidingObj->setRecordUpdateDate(new \Datetime());
            $StoreBuidingObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreBuidingObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            //get address master id
            $addressMasterID = $StoreBuidingObj->getAddressMasterFk()->getAddressPk();
            $addressMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addressMasterID);
            
            
            $addressMasterObj->setAddress1($address1);
            $addressMasterObj->setAddress2($address2);
            $addressMasterObj->setPinNumber($zipcode);
            $addressMasterObj->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country));
            $addressMasterObj->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state));
            $addressMasterObj->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district));
            $addressMasterObj->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city));
            $addressMasterObj->setRecordUpdateDate(new \Datetime());
            $addressMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $addressMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();            
             $conn->commit();
             $returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('StoreBuildingMaster') ;
                $id=$StoreBuidingObj->getStoreBuildingPk();
            }
            catch (\Exception $ex) {
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
//        return array('msg' => 'Update Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreBuildingMaster'),
//            'id' => $StoreBuidingObj->getStoreBuildingPk());
//     }
    
     public function retreiveAddStoreBuilding($StBid) 
      {  

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($StBid);   
            $country=$StoreObj->getAddressMasterFk()->getCountryCodeFk();
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
            
            $cityArr=$this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->
                    findBy(array('countryFk'=>$country,'recordActiveFlag'=>1),array('cityName'=>'ASC'));

            $cityIdArr=array();
            $cityNameArr=array();
            foreach($cityArr as $city ){
                array_push($cityIdArr,$city->getCityPk());
                array_push($cityNameArr,$city->getCityName());
            }
            
            $return = array('StBid' => $StBid,
                            'storenameId' => $StoreObj->getStoreMasterFk()->getStoreMasterPk(),
                            'buildingname' => $StoreObj->getBuildingName(),
                            'storeaddressId' => $StoreObj->getAddressMasterFk()->getAddress1(),
                            'storeaddress2Id' => $StoreObj->getAddressMasterFk()->getAddress2(),
                            'pin' => $StoreObj->getAddressMasterFk()->getPinNumber(),
//                            'countryID' => $StoreObj->getAddressMasterFk()->getCountryCodeFk()->getCountryPk(),
                            'countryID' => $country->getCountryPk(),
                            'stateIdArr'=>$stateIdArr,'stateNameArr'=>$stateNameArr,
                            'stateID' => $StoreObj->getAddressMasterFk()->getStateCodeFk()->getStatePk(),
                            'districtIdArr'=>$districtIdArr,'districtNameArr'=>$districtNameArr,
                            'districtID' => $StoreObj->getAddressMasterFk()->getDistrictFk()->getPkid(),
                            'cityIdArr'=>$cityIdArr,'cityNameArr'=>$cityNameArr,
                            'cityID' => $StoreObj->getAddressMasterFk()->getCityCodeFk()->getCityPk()
                            );
           
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
       public function deleteStoreBuildingMaster($StBid) {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($StBid);
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(0);
            $this->em->persist($StoreObj);
            $this->em->flush();
        $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('StoreBuildingMaster') ;
            $id=$StoreObj->getStoreBuildingPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreBuildingMaster'),
//            'id' => $StoreObj->getStoreBuildingPk());
//     }
    
     /*************this service is mainly for store storeFloor(Adding, Updating , Retrieving ,Deleting) master************/
     public function saveStoreFloor($request) {
        try {

            $dataUI = json_decode($request->getContent());

            $storenameId = $dataUI->storename;
            $buildingname = $dataUI->buildingname;
            $floorno = $dataUI->floorno;

            //$buildingNameObj = $this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->findOneBy(array('buildingName' => $buildingname, 'recordActiveFlag' => 1));
            $floorNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->findOneBy(array
                ('storeBuildingMasterFk' => $buildingname, 'storeFloorNo' => $floorno, 'recordActiveFlag' => 1));

            if ($floorNoObj) {
                $Codeflag = 0;
                return array('msg' => '!Floor no already exist for building name','codeFlag' => $Codeflag);
            } else {

                $StoreObj = new StoreFloorMaster();
                //$StoreObj->setstore($this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storenameId));
                $StoreObj->setStoreFloorNo($floorno);
                $StoreObj->setStoreBuildingMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($buildingname));
                $StoreObj->setRecordInsertDate(new \Datetime());
                $StoreObj->setApplicationUserId($this->session->get('EMPID'));
                $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
                $StoreObj->setRecordActiveFlag(1);
                $this->em->persist($StoreObj);
                $this->em->flush();
                $Codeflag = 1;
                $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('StoreFloorMaster') ;
                $id=$StoreObj->getStoreFloorPk();
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
//                return array('msg' => 'Record Save Sucessfully',
//                    'result' => $this->commonService->activeList('StoreFloorMaster'),
//                    'id' => $StoreObj->getStoreFloorPk(),
//                    'codeFlag' => $Codeflag );
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//    }
    
    public function updateStoreFloor($request, $Fid) 
     {
      
        try {
           $dataUI = json_decode($request->getContent());

            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            $floorno=$dataUI->floorno;             
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($Fid);
            $StoreObj->setStoreMasterFk($storenameId);       
            $StoreObj->setStoreBuildingMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($buildingname));
            $floorNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->findOneBy(array
                ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname, 'storeFloorNo' => $floorno, 'recordActiveFlag' => 1));

            if ($floorNoObj) {
                $Codeflag = 0;
                return array('msg' => '!Floor no exist , please edit floor no','codeFlag' => $Codeflag);
            } 
            else 
            {
            $StoreObj->setStoreFloorNo($floorno);
            $StoreObj->setRecordUpdateDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $this->em->flush();
            $Codeflag = 1;
            $returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('StoreFloorMaster') ;
                $id=$StoreObj->getStoreFloorPk();
            }
           }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('codeFlag'=>$Codeflag,
//            'msg' => 'Update Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreFloorMaster'),
//            'id' => $StoreObj->getStoreFloorPk());
//     }
    
     public function retreiveStoreFloor($Fid) 
      {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($Fid);
            $store=$StoreObj->getStoreBuildingMasterFk()->getStoreMasterFk();
            $biuldingArr=$this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->
                    findBy(array('storeMasterFk'=>$store,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));

            $buildingIdArr=array();
            $buildingNameArr=array();
            foreach($biuldingArr as $building ){
                array_push($buildingIdArr,$building->getStoreBuildingPk());
                array_push($buildingNameArr,$building->getBuildingName());
            }
            $return = array('Fid' => $Fid,
                'storenameId' => $store->getStoreMasterPk(),
                'buildingIdArr'=>$buildingIdArr,'buildingNameArr'=>$buildingNameArr,
                'buildingnameId' => $StoreObj->getStoreBuildingMasterFk()->getStoreBuildingPk(),
                'floorno' => $StoreObj->getStoreFloorNo()
                );
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
           public function deleteStoreFloorMaster($Fid) {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($Fid);
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(0);
            $this->em->persist($StoreObj);
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('StoreFloorMaster') ;
            $id=$StoreObj->getStoreFloorPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } 
//        catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreFloorMaster'),
//            'id' => $StoreObj->getStoreFloorPk());
//     }
    
    
    
     /*************this service is mainly for store storeRoom(Adding, Updating , Retrieving ,Deleting) master************/
public function saveStoreRoom($request) {
        try {

            $dataUI = json_decode($request->getContent());

            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            $floorno=$dataUI->floorno;
            $roomno=$dataUI->roomno;
            
            //$floorNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->findOneBy(array('storeFloorNo' => $floorno, 'recordActiveFlag' => 1));
            //$roomNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->findOneBy(array('storeRoomNo' => $roomno, 'recordActiveFlag' => 1));
            $roomNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->findOneBy(array
                ('storeFloorMasterFk' => $floorno, 'storeRoomNo' => $roomno, 'recordActiveFlag' => 1));
           if ($roomNoObj) {
                $Codeflag = 0;
                return array('msg' => '!Room no already exist for building name','codeFlag' => $Codeflag);
            } 
            else 
                {
                $StoreObj = new StoreRoomMaster();            
                $StoreObj->setStoreMasterFk($storenameId);
                $StoreObj->setStoreFloorMasterFk($this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($floorno));
                $StoreObj->setStoreBuildingMasterFk($buildingname);
                $StoreObj->setStoreRoomNo($roomno);

                $StoreObj->setRecordInsertDate(new \Datetime());
                $StoreObj->setApplicationUserId($this->session->get('EMPID'));
                $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
                $StoreObj->setRecordActiveFlag(1);
                $this->em->persist($StoreObj);
                $this->em->flush();
                $Codeflag = 1;
                $returnmsg='Record Save Sucessfully';
                $result=$this->commonService->activeList('StoreRoomMaster') ;
                $id=$StoreObj->getStoreRoomPk();
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
//                        'result' => $this->commonService->activeList('StoreRoomMaster'),
//                        'id' => $StoreObj->getStoreRoomPk(),
//                        'codeFlag' => $Codeflag );
//                }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//    }
    
    public function updateStoreRoom($request, $Rid) 
     {
      
        try {
           $dataUI = json_decode($request->getContent());

            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            $floorno=$dataUI->floorno;
            $roomno=$dataUI->roomno;

            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($Rid);               
            
            $StoreObj->setStoreMasterFk($storenameId);
            $StoreObj->setStoreFloorMasterFk($this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($floorno));
            $StoreObj->setStoreBuildingMasterFk($buildingname);
            $RoomNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->findOneBy(array
                ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname, 'storeFloorMasterFk' => $floorno, 'storeRoomNo' => $roomno, 'recordActiveFlag' => 1)); 
            if ($RoomNoObj) {
                $Codeflag = 0;
                return array('msg' => '!Room No exist , please edit Room no','codeFlag' => $Codeflag);
            } 
            else 
            {
            $StoreObj->setStoreRoomNo($roomno);          
            $StoreObj->setRecordUpdateDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $this->em->flush();
            $Codeflag = 1;
            $returnmsg='Record updated Sucessfully';
                $result=$this->commonService->activeList('StoreRoomMaster') ;
                $id=$StoreObj->getStoreRoomPk();
            }
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
//            }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('codeFlag'=>$Codeflag,
//            'msg' => 'Update Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreRoomMaster'),
//            'id' => $StoreObj->getStoreRoomPk());
//        
//     }
    
     public function retreiveStoreRoom($Rid) 
      {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($Rid);
            $store=$StoreObj->getStoreFloorMasterFk()->getStoreBuildingMasterFk()->getStoreMasterFk();
            $biuldingArr=$this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->
                    findBy(array('storeMasterFk'=>$store,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));

            $buildingIdArr=array();
            $buildingNameArr=array();
            foreach($biuldingArr as $building ){
                array_push($buildingIdArr,$building->getStoreBuildingPk());
                array_push($buildingNameArr,$building->getBuildingName());
            }
            
            $floorArr=$this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->
                    findBy(array('storeBuildingMasterFk'=>$StoreObj->getStoreFloorMasterFk()->getStoreBuildingMasterFk(),'recordActiveFlag'=>1),array('storeFloorNo'=>'ASC'));

            $floorIdArr=array();
            $floorNameArr=array();
            foreach($floorArr as $floor ){
                array_push($floorIdArr,$floor->getStoreFloorPk());
                array_push($floorNameArr,$floor->getStoreFloorNo());
            }
            $return = array('Rid' => $Rid,
                'storenameId' => $store->getStoreMasterPk(),
                'buildingIdArr'=>$buildingIdArr,'buildingNameArr'=>$buildingNameArr,
                'buildingnameId' => $StoreObj->getStoreFloorMasterFk()->getStoreBuildingMasterFk()->getStoreBuildingPk(), 
                'floorIdArr'=>$floorIdArr,'floorNameArr'=>$floorNameArr,
                'floornoId' => $StoreObj->getStoreFloorMasterFk()->getStoreFloorPk(),
                'roomno'=>$StoreObj->getStoreRoomNo()
                );
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
    public function deleteStoreRoomMaster($Rid) {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($Rid);
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(0);
            $this->em->persist($StoreObj);
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('StoreRoomMaster') ;
            $id=$StoreObj->getStoreRoomPk();
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
//        return array('msg' => 'Deleted Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreRoomMaster'),
//            'id' => $StoreObj->getStoreRoomPk());
//     }
    
    /*************this service is mainly for store store rack(Adding, Updating , Retrieving ,Deleting) master************/
public function saveStoreRack($request) {
        try {

            $dataUI = json_decode($request->getContent());

            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            $floorno=$dataUI->floorno;
            $roomno=$dataUI->roomno;
            
            $rackno = $dataUI->rackno;
            $rackrowno=$dataUI->rackrowno;
            $rackcolumnno=$dataUI->rackcolumnno;
//            $rackColumnNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array 
//               ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname,'storeFloorMasterFk' => $floorno, 'storeRoomMasterFk' => $roomno,
//                'rackName' => $rackno,'rowNumber' => $rackrowno,'columnNumber' => $rackcolumnno, 'recordActiveFlag' => 1));
//            $rackRowNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array   
//               ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname,'storeFloorMasterFk' => $floorno, 'storeRoomMasterFk' => $roomno,
//                'rackName' => $rackno,'rowNumber' => $rackrowno,'recordActiveFlag' => 1));
//            $rackNameObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array
//                ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname,'storeFloorMasterFk' => $floorno, 'storeRoomMasterFk' => $roomno,
//                'rackName' => $rackno,'recordActiveFlag' => 1));           
//           
//           if ($rackColumnNoObj) {
//                $Codeflag = 0;
//                return array('msg' => '!Column Name already exist for building name','codeFlag' => $Codeflag);
//            }
//            if ($rackRowNoObj){
//                $Codeflag = 0;
//                return array('msg' => '!Row No already exist for building name','codeFlag' => $Codeflag);
//            }
//            if ($rackNameObj){
//                $Codeflag = 0;
//                return array('msg' => '!Rack Name already exist for building name','codeFlag' => $Codeflag);
//            }
            $checkColno=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array('storeRoomMasterFk'=>$roomno,'rackName'=>$rackno,'rowNumber'=>$rackrowno,'columnNumber'=>$rackcolumnno,'recordActiveFlag'=>1));
            if($checkColno){               
                return array('msg' => 'Column no already exist for the given Row','codeFlag' => 0);
            }
            $StoreObj = new StoreRackMaster();
//            $StoreObj->setStoreMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storenameId));
//            $StoreObj->setStoreFloorMasterFk($this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($floorno));
//            $StoreObj->setStoreBuildingMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($buildingname));
            $StoreObj->setStoreRoomMasterFk($this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($roomno));
            
            
            $StoreObj->setRackName($rackno);
            $StoreObj->setRowNumber($rackrowno);
            $StoreObj->setColumnNumber($rackcolumnno);
            
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $this->em->persist($StoreObj);
            $this->em->flush($StoreObj);
            $Codeflag = 1;
            $returnmsg='Record Save Sucessfully';
            $result=$this->commonService->activeList('StoreRackMaster') ;
            $id=$StoreObj->getStoreRackPk();
            
            } catch (\Exception $ex) {
                $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => $Codeflag
                            );
    }
    public function InsertBinNo($request) {
        try {

            $dataUI = json_decode($request->getContent());
            $rackid=$dataUI->selRack;
            $binNo=$dataUI->binno;
            $rack=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($rackid);
            $checkBin=$this->em->getRepository(CommonConstant::ENT_BIN_MASTER)->findBy(array('rackFk'=>$rack,'binNo'=>$binNo,'recordActiveFlag'=>1));
            if($checkBin){
                return array('msg' => 'Same Bin No. already exist for the selected Rack','codeFlag' => 0);
            }

            $bin=new StoreBinMaster();
            $bin->setRackFk($rack);
            $bin->setBinNo($binNo);
            $bin->setRecordInsertDate(new \Datetime());
            $bin->setApplicationUserId($this->session->get('EMPID'));
            $bin->setApplicationUserIpAddress($this->session->get('IP'));
            $bin->setRecordActiveFlag(1);
            $this->em->persist($bin);
            $this->em->flush($bin);
            $Codeflag = 1;
            $returnmsg='Record Save Sucessfully';
            $result=$this->commonService->activeList('StoreBinMaster') ;
            $id=$bin->getPkid();
            
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
//                         'result' => $this->commonService->activeList('StoreRackMaster'),
//                         'id' => $StoreObj->getStoreRackPk(),
//                         'codeFlag' => $Codeflag
//                         );
//            
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//     }
    
    public function updateStoreRack($request, $Rackid) 
     {
      
        try {
           $dataUI = json_decode($request->getContent());

            $storenameId = $dataUI->storename;
            $buildingname=$dataUI->buildingname;
            $floorno=$dataUI->floorno;
            $roomno=$dataUI->roomno;
            
            $rackno = $dataUI->rackno;
            $rackrowno=$dataUI->rackrowno;
            $rackcolumnno=$dataUI->rackcolumnno;
            
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($Rackid);
            
            $StoreObj->setStoreMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storenameId));
            $StoreObj->setStoreFloorMasterFk($this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($floorno));
            $StoreObj->setStoreBuildingMasterFk($this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($buildingname));
            $StoreObj->setStoreRoomMasterFk($this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($roomno));
//            $rackColumnNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array 
//               ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname,'storeFloorMasterFk' => $floorno, 'storeRoomMasterFk' => $roomno,
//                'rackName' => $rackno,'rowNumber' => $rackrowno,'columnNumber' => $rackcolumnno, 'recordActiveFlag' => 1));
//            $rackRowNoObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array   
//               ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname,'storeFloorMasterFk' => $floorno, 'storeRoomMasterFk' => $roomno,
//                'rackName' => $rackno,'rowNumber' => $rackrowno,'recordActiveFlag' => 1));
//            $rackNameObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array
//                ('storeMasterFk' => $storenameId,'storeBuildingMasterFk' => $buildingname,'storeFloorMasterFk' => $floorno, 'storeRoomMasterFk' => $roomno,
//                'rackName' => $rackno,'recordActiveFlag' => 1));     
//            $checkRackName=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array('storeRoomMasterFk'=>$roomno,'rackName'=>$rackno,'recordActiveFlag'=>1));
//            if($checkRackName){
//                foreach($checkRackName as $rackobj){
//                    if($rackobj->getStoreRackPk()!=$Rackid){
//                        return array('msg' => 'Rack Name already exist for the selected building name','codeFlag' => 0);
//                    }
//                }
//            }
//            $checkRowno=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array('storeRoomMasterFk'=>$roomno,'rackName'=>$rackno,'rowNumber'=>$rackrowno,'recordActiveFlag'=>1));
//            if($checkRowno){
//                foreach($checkRowno as $rowobj){
//                    if($rowobj->getStoreRackPk()!=$Rackid){
//                        return array('msg' => 'Row no already exist','codeFlag' => 0);
//                    }
//                }
//            }
            $checkColno=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array('storeRoomMasterFk'=>$roomno,'rackName'=>$rackno,'rowNumber'=>$rackrowno,'columnNumber'=>$rackcolumnno,'recordActiveFlag'=>1));
            if($checkColno){
                foreach($checkColno as $colobj){
                    if($colobj->getStoreRackPk()!=$Rackid){
                        return array('msg' => 'Column no already exist for the given Row','codeFlag' => 0);
                    }
                }
            }
            $StoreObj->setRackName($rackno);
            $StoreObj->setRowNumber($rackrowno);
            $StoreObj->setColumnNumber($rackcolumnno);
            $StoreObj->setRecordUpdateDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(1);
            $Codeflag = 1;
            $returnmsg='Update Record Sucessfully';
                $result=$this->commonService->activeList('StoreRackMaster') ;
                $id=$StoreObj->getStoreRackPk();
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
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('codeFlag'=>$Codeflag,
//            'msg' => 'Update Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreRackMaster'),
//            'id' => $StoreObj->getStoreRackPk());
//        
//     }
            
//            $this->em->flush();
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Update Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreRackMaster'),
//            'id' => $StoreObj->getStoreRackPk());
//     }
    public function UpdateBin($request, $binid) 
     {      
        try {
            $dataUI = json_decode($request->getContent());
            $rackid=$dataUI->selRack;
            $binNo=$dataUI->binno;
            $rack=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($rackid);
            $checkBin=$this->em->getRepository(CommonConstant::ENT_BIN_MASTER)->findBy(array('binNo'=>$binNo,'rackFk'=>$rack,'recordActiveFlag'=>1));
            if($checkBin){
                foreach($checkBin as $cbin){
                    if($cbin->getPkid()!=$binid){
                        return array('msg' => 'Same Bin No. already exist for the selected Rack','codeFlag'=>0);
                    }
                }
            }
            $bin=$this->em->getRepository(CommonConstant::ENT_BIN_MASTER)->find($binid);
            $bin->setRackFk($rack);
            $bin->setBinNo($binNo);
            $bin->setRecordUpdateDate(new \Datetime());
            $bin->setApplicationUserId($this->session->get('EMPID'));
            $bin->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($bin);            
            $returnmsg='Record Updated Successfully.';
                $result=$this->commonService->activeList('StoreBinMaster') ;
                $id=$bin->getPkid();
            }
            catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id,
                                'codeFlag' => 1
                            );
    }
     public function retreiveStoreRack($Rackid) 
      {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($Rackid);
            $store=$StoreObj->getStoreRoomMasterFk()->getStoreFloorMasterFk()->getStoreBuildingMasterFk()->getStoreMasterFk();
            $biuldingArr=$this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->
                    findBy(array('storeMasterFk'=>$store,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));

            $buildingIdArr=array();
            $buildingNameArr=array();
            foreach($biuldingArr as $building ){
                array_push($buildingIdArr,$building->getStoreBuildingPk());
                array_push($buildingNameArr,$building->getBuildingName());
            }
            
            $floorArr=$this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->
                    findBy(array('storeBuildingMasterFk'=>$StoreObj->getStoreRoomMasterFk()->getStoreFloorMasterFk()->getStoreBuildingMasterFk(),'recordActiveFlag'=>1),array('storeFloorNo'=>'ASC'));

            $floorIdArr=array();
            $floorNameArr=array();
            foreach($floorArr as $floor ){
                array_push($floorIdArr,$floor->getStoreFloorPk());
                array_push($floorNameArr,$floor->getStoreFloorNo());
            }
            
            $roomArr=$this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->
                    findBy(array('storeFloorMasterFk'=>$StoreObj->getStoreRoomMasterFk()->getStoreFloorMasterFk(),'recordActiveFlag'=>1),array('storeRoomNo'=>'ASC'));

            $roomIdArr=array();
            $roomNameArr=array();
            foreach($roomArr as $room ){
                array_push($roomIdArr,$room->getStoreRoomPk());
                array_push($roomNameArr,$room->getStoreRoomNo());
            }
            $return = array('Rackid' => $Rackid,
                'storenameId' => $store->getStoreMasterPk(),
                'buildingIdArr'=>$buildingIdArr,'buildingNameArr'=>$buildingNameArr,
                'buildingnameId' => $StoreObj->getStoreRoomMasterFk()->getStoreFloorMasterFk()->getStoreBuildingMasterFk()->getStoreBuildingPk(), 
                'floorIdArr'=>$floorIdArr,'floorNameArr'=>$floorNameArr,
                'floornoId' => $StoreObj->getStoreRoomMasterFk()->getStoreFloorMasterFk()->getStoreFloorPk(),
                'roomIdArr'=>$roomIdArr,'roomNameArr'=>$roomNameArr,
                'roomnoId'=>$StoreObj->getStoreRoomMasterFk()->getStoreRoomPk(),
                
                 'rackno'=>$StoreObj->getRackName() ,
                'rackrowno'=>$StoreObj->getRowNumber() ,
                'rackcolumnno'=>$StoreObj->getColumnNumber() 
                );
            }
            catch (\Exception $ex) 
            {
            throw new \Exception($ex->getMessage());
            }

        return $return;
    }
    
    
        public function deleteStoreRackMaster($Rackid) {

        try {
            $StoreObj = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($Rackid);
            $StoreObj->setRecordInsertDate(new \Datetime());
            $StoreObj->setApplicationUserId($this->session->get('EMPID'));
            $StoreObj->setApplicationUserIpAddress($this->session->get('IP'));
            $StoreObj->setRecordActiveFlag(0);
            $this->em->persist($StoreObj);
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('StoreRackMaster') ;
            $id=$StoreObj->getStoreRackPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
    public function deleteBin($binid) {

        try {
            $bin = $this->em->getRepository(CommonConstant::ENT_BIN_MASTER)->find($binid);
            $bin->setRecordUpdateDate(new \Datetime());
            $bin->setApplicationUserId($this->session->get('EMPID'));
            $bin->setApplicationUserIpAddress($this->session->get('IP'));
            $bin->setRecordActiveFlag(0);
            $this->em->flush($bin);
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('StoreBinMaster') ;
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                    'result' => $result,
                    'code'=>1);
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Record Sucessfully',
//            'result' => $this->commonService->activeList('StoreRackMaster'),
//            'id' => $StoreObj->getStoreRackPk());
//     }
     
     
      public function cmnLoadLocationList($request, $key){
      try{
          
          $load_location_key = $request->request->get('load_list_key');
          switch ($key){
              case 'S': //load state, for the particular country
                        $result = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('countryCodeFk' => $load_location_key, 'recordActiveFlag' => 1),array('stateName'=>'ASC'));
                        break;
              case 'D'://load district, for the particular state
                        $result = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('stateFk' => $load_location_key, 'recordActiveFlag' => 1),array('districtName'=>'ASC'));
                        break;
              case 'C'://load city, for the particular district
                        $result = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('districtFk' => $load_location_key, 'recordActiveFlag' => 1),array('cityName'=>'ASC'));
                        break;
          }        
      }catch (\Exception $ex) {        
            throw new \Exception($ex->getMessage());
      }      
      return array('key' => $key, 'loadList' => $result);
  }
  
        public function cmnLoadStoreList($request, $key){
      try{
          
          $load_location_key = $request->request->get('load_list_key'); 
          switch ($key){
              case 'B': //load building, for the particular store
                        $result = $this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->findBy(array('storeMasterFk' => $load_location_key, 'recordActiveFlag' => 1));
                        break;
              case 'F'://load floor, for the particular building
                        $result = $this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->findBy(array('storeBuildingMasterFk' => $load_location_key, 'recordActiveFlag' => 1));
                        break;
              case 'R'://load room, for the particular floor
                        $result = $this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->findBy(array('storeFloorMasterFk' => $load_location_key, 'recordActiveFlag' => 1));
                        break;
            case 'Rack'://load room, for the particular floor
                        $result = $this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array('storeRoomMasterFk' => $load_location_key, 'recordActiveFlag' => 1));
                        break;
          }        
      }catch (\Exception $ex) {        
            throw new \Exception($ex->getMessage());
      }
      
      return array('key' => $key, 'loadList' => $result);
  }
    
    
}
