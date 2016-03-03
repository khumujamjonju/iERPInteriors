<?php

namespace Tashi\StoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Tashi\StoreBundle\Helper\StoreConstant;
use Symfony\Component\DependencyInjection\ContainerInterface;
class StoreController extends Controller{  
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    /**
     * @Route ("/store/_store_dashboard", name="_store_dashboard")
     */
    public function storeDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('storeDashboardAction');
	if($accessRight==1){
            try{                   
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_DASHBOARD));
                $this->erpMessage->setSuccess(true);        
            }
             catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    // landing for submenus starts here
     /**
     * @Route ("/store/_add_store", name="_add_store")
     */
    public function addStoreAction()
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('storeDashboardAction');
	if($accessRight==1){
            try{  
               $result = $this->get(StoreConstant::SERVICE_STORE)->displayAllResult('StoreMaster'); 
                 $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_ADD_STORE,
                         array('record'=>$result) ));
                 $this->erpMessage->setSuccess(true);        
            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/store/_store_building", name="_store_building")
     */
    public function addStoreBuildingAction()
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{   
           $storename = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreMaster');
           $storeaddress = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationAddressMaster');
            $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreBuildingMaster');
            $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCountryMaster');
             $result2 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationStateMaster');
             $result3 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationDistrictMaster');
             $result4 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCityMaster');
             $result5 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationAddressTypeMaster');
             $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_ADD_BUILDING,
                     array('record'=>$result,'storename'=>$storename,'storeaddress'=>$storeaddress,'countryid'=>$result1,'stateid'=>$result2 ,'districtid'=>$result3,'cityid'=>$result4,'addrs_id'=>$result5 )));
             $this->erpMessage->setSuccess(true);        
        }
        catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
      
    /**
     * @Route ("/store/buildingfloor", name="_building_floor")
     */
    public function StoreBuildingFloorAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
            $storename = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreMaster');
            $building = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreBuildingMaster');
             $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreFloorMaster');
             $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_FLOOR,
                     array('buildingname'=>$building,'storename'=>$storename,'record'=>$result)));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/store/buildingroom", name="_building_room")
     */
    public function StoreBuildingRoomAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{     
           $storename = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreMaster');
            $building = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreBuildingMaster');
             $floor = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreFloorMaster');
             $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreRoomMaster');
             $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_ROOM,
                      array('buildingname'=>$building,'storename'=>$storename,'record'=>$result,'floor'=>$floor)));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/store/buildingrack", name="_building_rack")
     */
    public function StoreBuildingRackAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
           $storename = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreMaster');
            $building = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreBuildingMaster');
             $floor = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreFloorMaster');
             $room = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreRoomMaster');
             $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreRackMaster');
             $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_RACK
                  , array('buildingname'=>$building,'storename'=>$storename,'record'=>$result,'floor'=>$floor,'room'=>$room) ));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
     /**
     * @Route ("/store/addbin", name="_addbin")
     */
    public function BinPageAction()
    {       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
            $storeArr = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreMaster');            
            $binArr = $this->get(CommonConstant::SERVICE_COMMON)->activeList('StoreBinMaster');
            $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_BIN, array('storeArr'=>$storeArr,'binArr'=>$binArr)));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
   // landing for submenus ends here 
    // for saving
    
    /**
     * @Route ("/store/saveStore", name="_saveStore")
     */
    public function saveStoreDetailsAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddStoreRecord');
	if($accessRight==1){
            try{  
                 $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreMaster($request);                
                 $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_addStore , 
                         array('record' => $result) ));
                 $this->erpMessage->setSuccess(true);
                 $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);       
    }
    /**
     * @Route ("/store/saveStoreBuilding", name="_saveStoreBuilding")
     */
    public function saveStoreDetailsBuildingAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddStoreRecord');
	if($accessRight==1){
            try{  
                 $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreDetailsBuildingAction($request);                
                 $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_addStoreBuilding , 
                         array('record' => $result) ));
                 $this->erpMessage->setSuccess(true);
                 $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);   
    }
    /**
     * @Route ("/store/saveStoreFloor", name="_saveStoreFloor")
     */
    public function saveStoreDetailsFloorAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddStoreRecord');
	if($accessRight==1){
            try{  
                $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreFloor($request); 
                if($result['codeFlag'] == 0){
               
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(false);
                }else
                {
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreFloor , array('record' => $result) ));
                }
                $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
         
    }
     /**
     * @Route ("/store/saveStoreRoom", name="_saveStoreRoom")
     */
    public function saveStoreDetailsRoomAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddStoreRecord');
	if($accessRight==1){
            try{  
                $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreRoom($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(false);
                } else {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRoom, array('record' => $result)));
                }
               
                $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
         
    }
    /**
     * @Route ("/store/saveStoreRack", name="_saveStoreRack")
     */
    public function saveStoreDetailsRackAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddStoreRecord');
	if($accessRight==1){
           try{  
                $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreRack($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(false);
                } else {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRack, array('record' => $result)));
                }
               
                $this->erpMessage->setMessage($result['msg']);
            }
//            try{  
//                $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreRack($request);  
//                if($result['codeFlag'] == 0){
//                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRack ,array('record' => $result) ));
//                }
//                $this->erpMessage->setJsonData($result);
//                $this->erpMessage->setSuccess(true);
//                $this->erpMessage->setMessage($result['msg']);
//            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
         
    }
    /**
     * @Route ("/store/insertBin", name="_insertBin")
     */
    public function InsertBinAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddStoreRecord');
	if($accessRight==1){
           try{  
                $result = $this->get(StoreConstant::SERVICE_STORE)->InsertBinNo($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(false);
                } else {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_BIN_LIST, array('record' => $result)));
                }
               
                $this->erpMessage->setMessage($result['msg']);
            }
//            try{  
//                $result = $this->get(StoreConstant::SERVICE_STORE)->saveStoreRack($request);  
//                if($result['codeFlag'] == 0){
//                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRack ,array('record' => $result) ));
//                }
//                $this->erpMessage->setJsonData($result);
//                $this->erpMessage->setSuccess(true);
//                $this->erpMessage->setMessage($result['msg']);
//            }
            catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
         
    }
    
   //for update
       /**
     * @Route ("/Store/update_addStore/{Stid}", name="_update_addStore")
     * 
     */
    public function updateAddStoreAction(Request $request, $Stid) 
    {   
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->updateAddStoreMaster($request, $Stid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_addStore, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
     /**
     * @Route ("/Store/update_addStoreBuilding/{StBid}", name="_update_addStoreBuilding")
     * 
     */
    public function updateAddStoreBuildingAction(Request $request, $StBid) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->updateAddStoreBuildingAction($request, $StBid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_addStoreBuilding, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/update_addStoreFloor/{Fid}", name="_update_addStoreFloor")
     * 
     */
    public function updateStoreFloorAction(Request $request, $Fid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->updateStoreFloor($request, $Fid);
                
                if($result['codeFlag']==0)
                {
                    $this->erpMessage->setSuccess(false);
                }
                else
                {
                     $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreFloor,array('record' => $result)));
                     $this->erpMessage->setSuccess(true);
                }
                     $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/update_addStoreRoom/{Rid}", name="_update_addStoreRoom")
     * 
     */
    public function updateStoreRoomAction(Request $request, $Rid) { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->updateStoreRoom($request, $Rid);                
                if($result['codeFlag']==0)
                {
                    $this->erpMessage->setSuccess(false);
                }
                else
                {
                     $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRoom, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                }
                     $this->erpMessage->setMessage($result['msg']);
        
//        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
//	if($accessRight==1){
//            try {
//                $result = $this->get(StoreConstant::SERVICE_STORE)->updateStoreRoom($request, $Rid);
//                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRoom,
//                        array('record' => $result)));
//                $this->erpMessage->setSuccess(true);
//                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/Store/update_addStoreRack/{Rackid}", name="_update_addStoreRack")
     * 
     */
    public function updateStoreRackAction(Request $request, $Rackid) {         
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->updateStoreRack($request, $Rackid);                
                if($result['codeFlag']==0)
                {
                    $this->erpMessage->setSuccess(false);
                }
                else
                {
                     $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRack,
                       array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                }
                     $this->erpMessage->setMessage($result['msg']);
                     } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/updatebin/{binid}", name="_updatebin")
     * 
     */
    public function UpdateBinAction(Request $request, $binid) {         
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->UpdateBin($request, $binid);                
                if($result['codeFlag']==0){
                    $this->erpMessage->setSuccess(false);
                }
                else{
                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_BIN_LIST, array('record' => $result)));
                    $this->erpMessage->setSuccess(true);
                }
                    $this->erpMessage->setMessage($result['msg']);
                } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
//            try {
//                $result = $this->get(StoreConstant::SERVICE_STORE)->updateStoreRack($request, $Rackid);
//                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRack,
//                        array('record' => $result)));
//                $this->erpMessage->setSuccess(true);
//                $this->erpMessage->setMessage($result['msg']);
//            } catch (\Exception $ex) {
//                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setSuccess(false);
//            }
//        }else{
//            $this->erpMessage->setJsonData('AD');
//            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//        }
//        $jsondata = $serializer->serialize($this->erpMessage, 'json');
//        return new Response($jsondata);
//    }
    // for retrieve
    /**
     * @Route ("/Store/retrieve_addStore/{Stid}", name="_retrieve_addStore")
     */
    public function retreiveAddStoreAction($Stid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try 
            {
                $storeresult = $this->get(StoreConstant::SERVICE_STORE)->retreiveAddStoreAction($Stid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($storeresult);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * @Route ("/Store/retrieve_addStoreBuilding/{StBid}", name="_retrieve_addStoreBuilding")
     */
    public function retreiveAddStoreBuildingAction($StBid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try 
            {

                $result = $this->get(StoreConstant::SERVICE_STORE)->retreiveAddStoreBuilding($StBid); 
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);

            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/retrieve_addStoreFloor/{Fid}", name="_retrieve_addStoreFloor")
     */
    public function retreiveStoreFloorAction($Fid) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try 
            {
                $storeresult = $this->get(StoreConstant::SERVICE_STORE)->retreiveStoreFloor($Fid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($storeresult);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/retrieve_addStoreRoom/{Rid}", name="_retrieve_addStoreRoom")
     */
    public function retreiveStoreRoomAction($Rid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try 
            {
                $storeresult = $this->get(StoreConstant::SERVICE_STORE)->retreiveStoreRoom($Rid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($storeresult);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
           $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/Store/retrieve_addStoreRack/{Rackid}", name="_retrieve_addStoreRack")
     */
    public function retreiveStoreRackAction($Rackid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try 
            {
                $storeresult = $this->get(StoreConstant::SERVICE_STORE)->retreiveStoreRack($Rackid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($storeresult);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/retrieveBin/{binid}", name="_retrieveBin")
     */
    public function RetrieveBin($binid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStoreRecord');
	if($accessRight==1){
            try 
            {           
                $em=$this->getDoctrine()->getManager();
                $bin=$em->getRepository(CommonConstant::ENT_BIN_MASTER)->find($binid);
                $storeArr=$em->getRepository(CommonConstant::ENT_ADD_STORE)->findBy(array('recordActiveFlag'=>1),array('storeName'=>'ASC'));

                $store=$bin->getRackFk()->getStoreRoomMasterFk()->getStoreFloorMasterFk()->getStoreBuildingMasterFk()->getStoreMasterFk();
                $bldg=$bin->getRackFk()->getStoreRoomMasterFk()->getStoreFloorMasterFk()->getStoreBuildingMasterFk();
                $floor=$bin->getRackFk()->getStoreRoomMasterFk()->getStoreFloorMasterFk();
                $room=$bin->getRackFk()->getStoreRoomMasterFk();            

                $bldgArr=$em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->findBy(array('storeMasterFk'=>$store,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));
                $floorArr=$em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->findBy(array('storeBuildingMasterFk'=>$bldg,'recordActiveFlag'=>1),array('storeFloorNo'=>'ASC'));
                $roomArr=$em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->findBy(array('storeFloorMasterFk'=>$floor,'recordActiveFlag'=>1),array('storeRoomNo'=>'ASC'));
                $rackArr=$em->getRepository(CommonConstant::ENT_BUILDING_RACK)->findBy(array('storeRoomMasterFk'=>$room,'recordActiveFlag'=>1),array('rackName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_EDIT_BIN,
                        array('bin'=>$bin,'storeArr'=>$storeArr,'bldgArr'=>$bldgArr,'floorArr'=>$floorArr,
                              'roomArr'=>$roomArr,'rackArr'=>$rackArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    
    /**
     * @Route ("/Store/delete_addStore/{Stid}", name="_delete_addStore")
     * 
     */
    public function deleteAddStoreAction($Stid) 
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->deleteAddStoreMaster($Stid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_addStore, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
      /**
     * @Route ("/Store/delete_addStoreBuilding/{StBid}", name="_delete_addStoreBuilding")
     * 
     */
    public function deleteStoreBuildingAction($StBid) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->deleteStoreBuildingMaster($StBid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_addStoreBuilding, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
        /**
     * @Route ("/Store/delete_addStoreFloor/{Fid}", name="_delete_addStoreFloor")
     * 
     */
    public function deleteStoreFloorAction($Fid) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->deleteStoreFloorMaster($Fid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreFloor,
                        array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/Store/delete_addStoreRoom/{Rid}", name="_delete_addStoreRoom")
     * 
     */
    public function deleteStoreRoomAction($Rid) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->deleteStoreRoomMaster($Rid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRoom,
                        array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * @Route ("/Store/delete_addStoreRack/{Rackid}", name="_delete_addStoreRack")
     * 
     */
    public function deleteStoreRackAction($Rackid) {  
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->deleteStoreRackMaster($Rackid);
                $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_Display_StoreRack,
                        array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/Store/deletebin/{binid}", name="_deletebin")
     * 
     */
    public function DeleteBinAction($binid) {  
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStoreRecord');
	if($accessRight==1){
            try {
                $result = $this->get(StoreConstant::SERVICE_STORE)->deleteBin($binid);
                if($result['code']==1){
                    $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_BIN,
                            array('binArr' => $result['result'])));
                    $this->erpMessage->setSuccess(true);
                }else{
                    $this->erpMessage->setSuccess(false);
                }
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
  /**
     * @Route ("/store/cmn_load_list/{key}", name="_cmn_load_list")
     */
    public function cmnLoadLocationListAction(Request $request, $key) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {           
            $result = $this->get(StoreConstant::SERVICE_STORE)->cmnLoadLocationList($request, $key);  
            $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_LOCATION_LOAD,array('result' => $result)));  
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/employee/cmn_load-store_list/{key}", name="_cmn_store_load_list")
     */
    public function cmnLoadStoreListAction(Request $request, $key) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {           
            $result = $this->get(StoreConstant::SERVICE_STORE)->cmnLoadStoreList($request, $key);  
            $this->erpMessage->setHtml($this->renderView(StoreConstant::TWIG_STORE_LIST,array('result' => $result)));  
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }   
  
    
}