<?php
namespace Tashi\CompanyBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CompanyBundle\Helper\CompanyConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @Route(path="/company")
 */
class CompanyController extends Controller{
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    
    /**
    * @Route ("/dashboard", name="_companydashboard")
    */
    public function CompanyDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CompanyDashboardAction');
        if($accessRight==1){                
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_DASHBOARD));
            $this->erpMessage->setSuccess(true);            
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
    }
    /**
    * @Route ("/companyinformation", name="_gotocompanyinfo")
    */
    public function CompanyInformationAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
            try{
                $em=$this->getDoctrine()->getManager();
                $company=$em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findAll();
                $company=$company?$company[0]:null;
                $address=$em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->findOneByCompanyFk($company);
                $countryArr=$em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findBy(array('recordActiveFlag'=>1));                
                $countryid=$address?($address->getAddressFk()->getCountryCodeFk()?$address->getAddressFk()->getCountryCodeFk()->getCountryPk():''):'';
                $stateid=$address?($address->getAddressFk()->getStateCodeFk()?$address->getAddressFk()->getStateCodeFk()->getStatePk():''):'';
                $districtid=$address?($address->getAddressFk()->getDistrictFk()?$address->getAddressFk()->getDistrictFk()->getPkid():''):'';
                //$cityid=$address?($address->getCityCodeFkFk()?$address->getCityCodeFkFk()->getCityPk():''):'';
                
                $stateArr=($countryid!='') ? $em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('countryCodeFk'=>$countryid,'recordActiveFlag'=>1),array('stateName'=>'ASC')) :
                          $em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('recordActiveFlag'=>1),array('stateName'=>'ASC'));  
                $districtArr=($stateid!='') ? $em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('stateFk'=>$stateid,'recordActiveFlag'=>1),array('districtName'=>'ASC')) :
                          $em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('recordActiveFlag'=>1),array('districtName'=>'ASC'));  
                $cityArr=($districtid!='') ? $em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('districtFk'=>$districtid,'recordActiveFlag'=>1),array('cityName'=>'ASC')) :
                          $em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('recordActiveFlag'=>1),array('cityName'=>'ASC'));
                
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_INFO,
                        array('company'=>$company,'address'=>$address,'countryArr'=>$countryArr,
                            'stateArr'=>$stateArr,'districtArr'=>$districtArr,'cityArr'=>$cityArr)));
            }catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            }                     
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
    }
    /**
     * @Route ("/loaddropdown/{key}", name="_loaddropdown")
     */
    public function loaddropdownAction(Request $request, $key) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {           
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->cmnLoadCompanyList($request, $key);  
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_LOCATION,array('result' => $result)));  
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $$this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/savecompanyinfo", name="_savecompanyinfo")
     */
    public function SaveCompanyInfor(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCompany');
	if($accessRight==1){
        try {           
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->saveCompanyAction($request);  
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $$this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
    * @Route ("/company/Company_mobile", name="_Company_mobile")
    */
    public function companyMobileAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(CompanyConstant::SERVICE_COMPANY)->displayAllResult('CompanyContactTxn');
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_MOBILE, array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
         //   $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
          /**
     * @Route ("/company/Company_Email", name="_Company_Email")
     */
    public function companyEmailAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(CompanyConstant::SERVICE_COMPANY)->displayAllResult('CompanyEmailTxn');
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_EMAIL, array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//             $this->erpMessage->setMessage($ex->getMessage());
           $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
          /**
     * @Route ("/company/Company_telephone", name="_Company_telephone")
     */
    public function companyTelephoneAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(CompanyConstant::SERVICE_COMPANY)->displayAllResult('CompanyPhoneTxn');
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_TELEPHONE_NO, array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//             $this->erpMessage->setMessage($ex->getMessage());
           $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
          /**
     * @Route ("/company/Company_fax", name="_Company_fax")
     */
    public function companyfaxAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(CompanyConstant::SERVICE_COMPANY)->displayAllResult('CompanyFaxnoTxn');
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_FAX_NO, array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
       /**
     * @Route ("/employee/add_update_company_mobile", name="_add_update_company_mobile")
     */
    public function addUpdateCompanyMobileAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCompany');
	if($accessRight==1){
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->addUpdateCompanyMobile($request);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_MOBILE_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
           $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/employee/add_update_company_Email", name="_add_update_company_Email")
     */
    public function addUpdateCompanyEmailAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->addUpdateCompanyEmail($request);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_EMAIL_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
      /**
     * @Route ("/employee/add_update_company_telephone", name="_add_update_company_telephone")
     */
    public function addUpdateCompanyTelephoneAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->addUpdateCompanyTelephone($request);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_TELEPHONE_NO_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
           $this->erpMessage->setMessage($ex->getMessage());
 //           $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
      /**
     * @Route ("/employee/add_update_company_fax", name="_add_update_company_fax")
     */
    public function addUpdateCompanyFaxAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->addUpdateCompanyFax($request);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_FAX_NO_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
     /**
     * @Route ("/employee/retrieve_company_mobile/{comMobileId}", name="_retrieve_company_mobile")
     */
    public function retrieveCompanyMobileAction($comMobileId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->retrieveCompanyMobile($comMobileId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
     /**
     * @Route ("/employee/retrieve_company_Email/{comEmailId}", name="_retrieve_company_Email")
     */
    public function retrieveCompanyEmailAction($comEmailId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->retrieveCompanyEmail($comEmailId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/employee/retrieve_company_telephone/{comTeleId}", name="_retrieve_company_telephone")
     */
    public function retrieveCompanyTelephoneAction($comTeleId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->retrieveCompanyTelephone($comTeleId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/employee/retrieve_company_fax/{comFaxId}", name="_retrieve_company_fax")
     */
    public function retrieveCompanyFaxAction($comFaxId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->retrieveCompanyFax($comFaxId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
     /**
     * @Route ("/employee/delete_company_mobile/{comMobileId}", name="_delete_company_mobile")
     * 
     */
    public function deleteCompanyMobileAction($comMobileId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCompany');
	if($accessRight==1){
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->deleteCompanyMobileMasters($comMobileId);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_MOBILE_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/employee/delete_company_Email/{comEmailId}", name="_delete_company_Email")
     * 
     */
    public function deleteCompanyEmailAction($comEmailId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCompany');
	if($accessRight==1){
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->deleteCompanyEmailMasters($comEmailId);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_EMAIL_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/employee/delete_company_telephone/{comTeleId}", name="_delete_company_telephone")
     * 
     */
    public function deleteCompanyTelephoneAction($comTeleId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCompany');
	if($accessRight==1){
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->deleteCompanyTelephoneMasters($comTeleId);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_TELEPHONE_NO_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/employee/delete_company_fax/{comFaxId}", name="_delete_company_fax")
     * 
     */
    public function deleteCompanyFaxAction($comFaxId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCompany');
	if($accessRight==1){
        try {
            $result = $this->get(CompanyConstant::SERVICE_COMPANY)->deleteCompanyFaxMasters($comFaxId);
            $this->erpMessage->setHtml($this->renderView(CompanyConstant::TWIG_COMPANY_FAX_NO_DISPLAY, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
}else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
   
    
    
}
    
