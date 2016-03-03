<?php
      
namespace Tashi\LocationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Tashi\LocationBundle\Helper\LocationConstant;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Description of LocationMasterController
 *
 * @author SANATOMBA
 */
class LocationController extends Controller {
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container); 
        $this->erpMessage = new ERPMessage();
    }
    /**
     * @Route ("/location/master_location", name="_location_master")
     */
    public function locationDashboardAction() {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('locationDashboardAction');
        if($accessRight==1){            
            try {
                $this->erpMessage->setHtml($this->renderView(LocationConstant::TWIG_Location_DASHBOARD));
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
     * @Route ("/location/add_master_location", name="_master_location_details")
     */
    public function AddLocationDetailsAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCountryMaster');
            // $resultdocument = $this->get('hcm.case.service')->displayAllResult('DocumentTypeMaster');
            $this->erpMessage->setHtml($this->renderView(LocationConstant::LOCATION_DETAIL, array('record' => $result)));
            $this->erpMessage->setSuccess(true);
            //$this->erpMessage->setMessage($result['msg']);
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
     * @Route ("/location/country", name="_add_country_details")
     */
    public function AddCountryDetailsAction(Request $request) { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){                        
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->addCountryMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_COUNTRY_DETAIL, array('record' => $result)));
                }
                $this->erpMessage->setJsonData($result);
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
     * @Route ("/location/delete_country/{cid}", name="_delete_country")
     * 
     */
    public function deleteCountryAction($cid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteLocation');
        if($accessRight==1){                        
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->deleteCountryMaster($cid);
                $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_COUNTRY_DETAIL, array('record' => $result)));
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
     * @Route ("/location/add_master_state", name="_masterstate")
     */
    public function AddStateAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){     
            try {
                $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCountryMaster');
                $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationStateMaster');
                $this->erpMessage->setHtml($this->renderView(LocationConstant::STATE_DETAIL, array('result' => $result, 'result1' => $result1)));
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
     * @Route ("/location/state", name="_add_state_details")
     */
    public function AddStateDetailsAction(Request $request) {        
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){            
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->saveStateMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_STATE_DETAIL, array('result1' => $result)));
                }
                $this->erpMessage->setJsonData($result);
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
     * @Route ("/location/add_master_district", name="_masterdistrict")
     */
    public function AddDistrictAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){           
            
            try {
                $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCountryMaster');
                $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationStateMaster');
                $districresult = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationDistrictMaster');
                $this->erpMessage->setHtml($this->renderView(LocationConstant::DISTRICT_DETAIL, array('country' => $result, 'state' => $result1, 'district' => $districresult)));
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
     * @Route ("/location/add_district", name="_adddistrict")
     */
    public function AddDistrictDetailsAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){      
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->saveDistrictMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_DISTRICT_DETAIL, array('result1' => $result)));
                }
                $this->erpMessage->setJsonData($result);
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
     * @Route ("/location/add_master_city", name="_mastercity")
     */
    public function AddCityAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){     
            try {
                $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCountryMaster');
                $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationStateMaster');
                $districresult = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationDistrictMaster');
                $cityresult = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCityMaster');
                $this->erpMessage->setHtml($this->renderView(LocationConstant::CITY_DETAIL, array('countryid' => $result, 'stateid' => $result1, 'districtid' => $districresult, 'city' => $cityresult)));
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
     * @Route ("/location/addcity", name="_add_city")
     */
    public function AddCityDetailsAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){          
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->saveCityMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_CITY_DETAIL, array('result1' => $result)));
                }
                $this->erpMessage->setJsonData($result);
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
     * @Route ("/location/add_master_addresstype", name="_masteraddress_type")
     */
    public function AddAddressTypeAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){     
            try {
                $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationAddressTypeMaster');
                $this->erpMessage->setHtml($this->renderView(LocationConstant::ADDRESSTYPE_DETAIL, array('record' => $result)));
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
     * @Route ("/location/saveAddressType", name="_save_address_type")
     */
    public function AddAddressTypeDetailsAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddLocation');
        if($accessRight==1){     
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->saveAddressTypeMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_ADDRESSTYPE_DETAIL, array('record' => $result)));
                }
                $this->erpMessage->setJsonData($result);
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

    /*     * ************************updating record section********************************* */

    /**
     * @Route ("/location/update_country", name="_update_country")
     * 
     */
    public function updateCountryAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditLocation');
        if($accessRight==1){     
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->updateCountryMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_COUNTRY_DETAIL, array('record' => $result)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setJsonData($result);
                } else {
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
     * @Route ("/location/update_state", name="_update_state")
     * 
     */
    public function updateStateAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditLocation');
        if($accessRight==1){       
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->updateStateMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_STATE_DETAIL, array('result1' => $result)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setJsonData($result);
                } else {
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
     * @Route ("/location/update_district", name="_update_district")
     * 
     */
    public function updateDistrictAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditLocation');
        if($accessRight==1){     
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->updateDistrictMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_DISTRICT_DETAIL, array('result1' => $result)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setJsonData($result);
                } else {
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
     * @Route ("/location/update_city", name="_update_city")
     * 
     */
    public function updateCityDetailsAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditLocation');
        if($accessRight==1){    
//            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->updateCityMaster($request);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_CITY_DETAIL, array('result1' => $result)));
                    $this->erpMessage->setSuccess(true);
                    //$this->erpMessage->setJsonData($result);
                } else {
                    $this->erpMessage->setSuccess(false);
                }
                $this->erpMessage->setMessage($result['msg']);
//            } catch (\Exception $ex) {
////            $this->erpMessage->setMessage($ex->getMessage());
//            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
////            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setSuccess(false);
//            }
            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }

    /**
     * @Route ("/location/update_address_type", name="_update_address_type")
     * 
     */
    public function updateAddressTypeAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditLocation');
        if($accessRight==1){
            $dataUI=json_decode($request->getContent());
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->updateAddressTypeMaster($request, $dataUI->inputcid);
                if ($result['codeFlag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_ADDRESSTYPE_DETAIL, array('record' => $result)));
                }
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /*     * ****************************ends here********************************* */





    /*     * ************************retreiving record section********************************* */

    /**
     * @Route ("/location/retreive_country/{cid}", name="_retreive_countryid")
     */
    public function retreiveCountryAction($cid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $countryresult = $this->get(LocationConstant::SERVICE_LOCATION)->retreiveCountrydetails($cid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($countryresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/location/retreive_state/{sid}", name="_retreive_stateid")
     */
    public function retreiveStateAction($sid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $stateresult = $this->get(LocationConstant::SERVICE_LOCATION)->retreiveStatedetails($sid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($stateresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/location/retreive_district/{did}", name="_retreive_district_id")
     */
    public function retreiveDistrictAction($did) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $stateresult = $this->get(LocationConstant::SERVICE_LOCATION)->retreiveDistrictdetails($did);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($stateresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/location/retreive_city/{cid}", name="_retreive_city_id")
     */
    public function retreiveCityAction($cid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $cityresult = $this->get(LocationConstant::SERVICE_LOCATION)->retreiveCitydetails($cid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($cityresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/location/retreive_address_type/{aTid}", name="_retreive_address_type")
     */
    public function retreiveAddressTypeAction($aTid) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $addtyperesult = $this->get(LocationConstant::SERVICE_LOCATION)->retreiveAddressTypedetails($aTid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($addtyperesult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /*     * ****************************ends here********************************* */

    /**
     * @Route ("/location/delete_state/{sid}", name="_delete_state")
     * 
     */
    public function deleteStateAction($sid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteLocation');
        if($accessRight==1){
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->deleteStateMaster($sid);
                $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_STATE_DETAIL, array('result1' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }            
        }
        else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/location/delete_district/{did}", name="_delete_district")
     * 
     */
    public function deleteDistrictAction($did) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteLocation');
        if($accessRight==1){
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->deleteDistrictMaster($did);
                $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_DISTRICT_DETAIL, array('result1' => $result)));
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
     * @Route ("/location/delete_city/{cid}", name="_delete_city")
     * 
     */
    public function deleteCityDetailsAction($cid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteLocation');
        if($accessRight==1){
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->deleteCityMaster($cid);
                $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_CITY_DETAIL, array('result1' => $result)));
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
     * @Route ("/location/delete_address_type/{aTid}", name="_delete_address_type")
     * 
     */
    public function deleteAddressTypeAction($aTid) {
         $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteLocation');
        if($accessRight==1){
            try {
                $result = $this->get(LocationConstant::SERVICE_LOCATION)->deleteAddressTypeMaster($aTid);
                $this->erpMessage->setHtml($this->renderView(LocationConstant::DISPLAY_ADDRESSTYPE_DETAIL, array('record' => $result)));
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
     * @Route ("/location/cmn_load_list/{key}", name="_cmn_load_list")
     */
    public function cmnLoadLocationListAction(Request $request, $key) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(LocationConstant::SERVICE_LOCATION)->cmnLoadLocationList($request, $key);
            $this->erpMessage->setHtml($this->renderView(LocationConstant::TWIG_LOC_LOAD, array('result' => $result)));
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
