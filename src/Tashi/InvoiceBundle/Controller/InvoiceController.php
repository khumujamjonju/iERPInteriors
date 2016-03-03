<?php
namespace Tashi\InvoiceBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Tashi\InvoiceBundle\Helper\InvoiceConstant;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @Route("/Invoice")
 */
class InvoiceController extends Controller
{ 
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    /**
     * @Route (path="/master_dashboard", name="_invoice_master_dashboard")
     */
    public function invoiceDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('invoiceDashboardAction');
	if($accessRight==1){
        try{            
            $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INV_DASHBOARD));
            $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
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
     * @Route ("/newinvoice", name="_gotonewinvoice")
     */
    public function GotoNewInvoiceAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
	if($accessRight==1){
            try{ 
                $em=$this->getDoctrine()->getManager();
                $custArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->SearchAllProjectCustomer();
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_NEW_INVOICE,array('custArr'=>$custArr)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
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
     * @Route ("/searchproject", name="_searchinvproject")
     */
    public function SearchInvoiceProjectAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
	if($accessRight==1){
        try{                   
             $dataUI=  json_decode($request->getContent());
             $custidname=$dataUI->txtcustid;
             $em=$this->getDoctrine()->getManager();
             $projArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetProjectByCustIdName($custidname);
             if($projArr){
                 $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_PROJECT_LIST,array('projArr'=>$projArr)));
                 $this->erpMessage->setSuccess(true);
             }
             else{
                 $this->erpMessage->setSuccess(false);
                 $this->erpMessage->setMessage('There are no projects associated with the given customer');
             }
          }
          catch (\Exception $ex) {
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
     * @Route ("/createnewinvoice/{projid}", name="_gotocreateinvoice")
     */
    public function GotoCreateInvoiceAction($projid)
    {
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $custid=$project->getCustomerFk()->getCustomerIdPk();
            $shipAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($project->getCustomerAddressFk()->getAddressFk());
            //$addressArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetAllAddressByCustId($custid);
            $addressArr=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
            $payModeArr=$em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER )->findBy(array('recordActiveFlag'=>1,'isGlobal'=>1),array('paymentModeName'=>'ASC'));
            $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllEmployees();
            $projcontact=$em->getRepository(CommonConstant::ENT_PROJ_CONTACT)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1));
            if($projcontact){
                $projcontact=$projcontact[0];
            }
            $contperson=$projcontact->getContactFk()->getPersonFk();
            $mobconttxn=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$projcontact->getContactFk(),'recordActiveFlag'=>1));
            $contno='';
            if($mobconttxn){
                $mobconttxn=$mobconttxn[0];
                $contno=$mobconttxn->getMobileNo()->getMobileNo();
            }
            
            $itemArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetUnbilledItems($projid);            
            $serviceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetUnbilledServices($projid);
            $finalArr=array();
            if($itemArr){
                foreach($itemArr as $item){
                    $finalArr[]=$item;
                    $itemprdid=$item->getItemFk()->getPkid();
                    foreach($serviceArr as $service){
                        $srvprdid=$service->getServiceFk()->getProductFk()->getPkid();
                        if($itemprdid==$srvprdid){
                            $finalArr[]=$service;
                        }
                    }
                }
            }elseif(!$itemArr && $serviceArr){
                foreach($serviceArr as $service){
                    $finalArr[]=$service;
                }
            }
            $vatTax=$em->getRepository(CommonConstant::ENT_TAX_MASTER)->findBy(array('taxCode'=>'VAT','recordActiveFlag'=>1));
            $serviceTax=$em->getRepository(CommonConstant::ENT_TAX_MASTER)->findBy(array('taxCode'=>'SERVICE','recordActiveFlag'=>1));
            $projExpense=$em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)
                    ->findBy(array('projectFk'=>$projid,'approvalFlag'=>1,'isBilled'=>0,'recordActiveFlag'=>1));
            $VAT=0;
            $SRVTAX=0;
            if($vatTax){
                $VAT=$vatTax[0]->getTaxValue();
            }
            if($serviceTax){
                $SRVTAX=$serviceTax[0]->getTaxValue();
            }
            if(!$finalArr && !$projExpense){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('There are no unbilled Item(s) for the selected project.');
            }else{
                $totAdvArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectPaidAmount($projid);
                $totAdv=0;
                foreach($totAdvArr as $adv){
                    $totAdv=$adv['amount'];
                }
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_CREATE_INVOICE,
                        array('proj'=>$project,'cperson'=>$contperson,'mobno'=>$contno,'addressArr'=>$addressArr,'payModeArr'=>$payModeArr,
                            'empArr'=>$empArr,'shipAdd'=>$shipAddress)));
                $this->erpMessage->setSecondHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_ITEM_SEL_LIST,
                                                array('itemArr'=>$finalArr,'totAdv'=>$totAdv,'projexpense'=>$projExpense,'vattax'=>$VAT,'sTax'=>$SRVTAX)));
                $this->erpMessage->setSuccess(true);
            }
         }
         catch (\Exception $ex) {
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/createinvoice", name="_createinvoice")
     */
    public function CreateInvoiceAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
	if($accessRight==1){
        $result=$this->get(InvoiceConstant::SERVICE_INVOICE)->CreateInvoice($request);
        if($result['code']==1){
            $em=$this->getDoctrine()->getManager();            
            $company=$em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findAll();
            if($company){
                $company=$company[0];
            }
            $invoice=$result['invoice'];
            $cmpaddtxn=$em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->findBy(array('companyFk'=>$company,'recordActiveFlag'=>1));
            $cmpadd='';            
            if($cmpaddtxn){
                $cmpaddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($cmpaddtxn[0]->getAddressFk());
            }else{
                $cmpaddress=null;
            }
            $mobArr=$em->getRepository(CommonConstant::ENT_COMPANY_MOBILE)->findBy(array('recordActiveFlag'=>1));
            $emailArr=$em->getRepository(CommonConstant::ENT_COMPANY_EMAIL)->findBy(array('recordActiveFlag'=>1));
            $phoneArr=$em->getRepository(CommonConstant::ENT_COMPANY_PHONE)->findBy(array('recordActiveFlag'=>1));
            $faxArr=$em->getRepository(CommonConstant::ENT_COMPANY_FAX)->findBy(array('recordActiveFlag'=>1));
            $billAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getBillingAddressFk()->getAddressFk());
            $shipAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getShippingAddressFk()->getAddressFk());
            $payterm=$em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $itemArr=$em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_CONFIRMED,array('invoiceno'=>$invoice->getInvoiceNo())));
            $this->erpMessage->setSecondHtml($this->renderView(InvoiceConstant::TWIG_PRINT_INVOICE,
                    array('company'=>$company,'cmpaddress'=>$cmpaddress,'invoice'=>$invoice,'billaddress'=>$billAddress,
                        'shipaddress'=>$shipAddress,'payterm'=>$payterm,'itemArr'=>$itemArr,'mobArr'=>$mobArr,
                        'emailArr'=>$emailArr,'phoneArr'=>$phoneArr,'faxArr'=>$faxArr)));
        }else{
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        }  
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
        * Action: Search Invoice by using Project Id
     * @Route ("/searchbyprojid/{projid}", name="_searchbyprojid")
     */
    public function SearchInvoiceByProjIdAction($projid)
    {
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{ 
            $em=$this->getDoctrine()->getManager();
            $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByProjectId($projid);
            if($invoiceArr){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_LIST,array('invoiceArr'=>$invoiceArr,'ref'=>'CREATE')));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No matching record found!!!');
            }
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }  
    /**
     * Action: Load Invoice detail and Display
     * @Route("/invoicedetail/{invoiceid}/{ref}",name="_invoicedetail")
     */
    public function ViewInvoiceDetail($invoiceid,$ref){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        if($ref=='APR'){
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }
        if($ref=='VIEW'){
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewInvoice');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }
        if($ref=='PRINT'){
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PrintInvoice');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }
        try{
            $em=$this->getDoctrine()->getManager();            
            $company=$em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findAll();
            $company=$company?$company[0]:null;
            $invoice=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($invoiceid);
            $cmpaddtxn=$em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->findBy(array('companyFk'=>$company,'recordActiveFlag'=>1));
            $cmpadd='';            
            if($cmpaddtxn){
                $cmpaddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($cmpaddtxn[0]->getAddressFk());
            }
            $mobArr=$em->getRepository(CommonConstant::ENT_COMPANY_MOBILE)->findBy(array('recordActiveFlag'=>1));
            $emailArr=$em->getRepository(CommonConstant::ENT_COMPANY_EMAIL)->findBy(array('recordActiveFlag'=>1));
            $phoneArr=$em->getRepository(CommonConstant::ENT_COMPANY_PHONE)->findBy(array('recordActiveFlag'=>1));
            $faxArr=$em->getRepository(CommonConstant::ENT_COMPANY_FAX)->findBy(array('recordActiveFlag'=>1));
            $billAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getBillingAddressFk()->getAddressFk());
            $shipAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getShippingAddressFk()->getAddressFk());
            $payterm=$em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $itemArr=$em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_DETAIL,
                    array('company'=>$company,'cmpaddress'=>$cmpaddress,'invoice'=>$invoice,'billaddress'=>$billAddress,
                        'shipaddress'=>$shipAddress,'payterm'=>$payterm,'itemArr'=>$itemArr,'mobArr'=>$mobArr,'ref'=>$ref,
                        'mobArr'=>$mobArr,'emailArr'=>$emailArr,'phoneArr'=>$phoneArr,'faxArr'=>$faxArr)));
            if($ref=='PRINT'){
                $this->erpMessage->setSecondHtml($this->renderView(InvoiceConstant::TWIG_PRINT_INVOICE,
                    array('company'=>$company,'cmpaddress'=>$cmpaddress,'invoice'=>$invoice,'billaddress'=>$billAddress,
                        'shipaddress'=>$shipAddress,'payterm'=>$payterm,'itemArr'=>$itemArr,'mobArr'=>$mobArr,
                        'emailArr'=>$emailArr,'phoneArr'=>$phoneArr,'faxArr'=>$faxArr)));
            }
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }    
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
    * Action: Load all Unapproved Invoices
    * @Route ("/invoiceapproval", name="_invoiceapproval")
    */
    public function SearchUnapprovedInvoiceAction()
    {
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
	if($accessRight==1){
        try{ 
            $em=$this->getDoctrine()->getManager();
            $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->
                    findBy(array('approvalFlag'=>0,'recordActiveFlag'=>1),array('invoiceDate'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_UNAPPROVE_INVOICE_DETAIL,array('invoiceArr'=>$invoiceArr)));
        }
         catch (\Exception $ex) {
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
    * Action: Approve Invoice
    * @Route ("/approveinvoice/{invoiceid}", name="_approbeinvoice")
    */
    public function ApproveInvoiceAction($invoiceid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
        if($accessRight==1){
        $result=$this->get(InvoiceConstant::SERVICE_INVOICE)->ApproveInvoice($invoiceid);
        if($result['code']==1){
            try{ 
                $em=$this->getDoctrine()->getManager();
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->
                        findBy(array('approvalFlag'=>0,'recordActiveFlag'=>1),array('invoiceDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_UNAPPROVE_INVOICE_DETAIL,array('invoiceArr'=>$invoiceArr)));
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
        }else{
           $this->erpMessage->setSuccess(false);           
        }
        $this->erpMessage->setMessage($result['msg']);   
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
    /**
    * Action: Delete Invoice
    * @Route ("/deleteinvoice/{invoiceid}/{ref}", name="_deleteinvoice")
    */
    public function DeleteInvoiceAction($invoiceid,$ref)
    {
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
        if($accessRight==1){
       $result=$this->get(InvoiceConstant::SERVICE_INVOICE)->DeleteInvoice($invoiceid);
       $this->erpMessage->setMessage($result['msg']);
        if($result['code']==1){
            $this->erpMessage->setSuccess(true);
            try{ 
                $em=$this->getDoctrine()->getManager();
                if($ref=='CREATE'){
                    $invoice=$result['invoice'];
                    $projid=$invoice->getProjectFk()->getPkid();
                    $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByProjectId($projid);                    
                    $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_LIST,array('invoiceArr'=>$invoiceArr,'ref'=>$ref)));                    
                }
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
        }else{
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
    * Action: Goto Search Invoice
    * @Route ("/searchinv", name="_gotosearchinv")
    */
    public function GotoSearchInvoiceAction(){
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchInvoice');
            if($accessRight==1){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_SEARCH_INVOICE));
            }else{
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
    }
    /**
    * Action:  Search Invoice
    * @Route ("/searchinvoice", name="_searchinvpice")
    */
    public function SearchInvoiceAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $dataUI=  json_decode($request->getContent());        
        $selcriteria=$dataUI->selSearchInvCriteria;
        $em=$this->getDoctrine()->getManager();
        try{
            switch($selcriteria){
            case 'all':
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->findBy(array('recordActiveFlag'=>1),array('invoiceDate'=>'ASC'));
                break;
            case 'invno':
                $invno=$dataUI->txtCriteria;
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->findBy(array('invoiceNo'=>$invno,'recordActiveFlag'=>1));
                break;
            case 'ordno':
                $ordno=$dataUI->txtCriteria;
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByOrderNo($ordno);
                break;
            case 'cname':
                $custnameid=$dataUI->txtCriteria;
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByCustomer($custnameid);
                break;
            case 'date':
                $date=$dataUI->txtinvdate;
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByDate($date);
                break;
            case 'status':
                $status=$dataUI->selInvStatus;
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByStatus($status);
                break;
            }
            if($invoiceArr){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_LIST,array('invoiceArr'=>$invoiceArr,'ref'=>'SEARCH')));
            }else{
                $this->erpMessage->setSuccess(false); 
                $this->erpMessage->setMessage('No Matching Record Found!!!'); 
            }
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
        }  
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
    * Action:  Search Invoice Payment History
    * @Route ("/invoicepaymenthistory/{invoiceid}", name="_invoicepaymenthistory")
    */
    public function InvoicePaymentHistoryAction($invoiceid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewInvoice');
        if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $invoice=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($invoiceid);
                $payArr=$em->getRepository(CommonConstant::ENT_INVOICE_PAYMENT_TXN)->findBy(array('invoiceFk'=>$invoiceid,'recordActiveFlag'=>1),array('paymentDate'=>'DESC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_INVOICE_PAYMENT_HISTORY,array('invoice'=>$invoice,'payArr'=>$payArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
    * Action:  Navigate to Edit Invoice Page
    * @Route ("/editinvoice/{invoiceid}", name="_gotoeditinvoice")
    */
    public function GotoEditInvoiceAction($invoiceid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
        if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $invoice=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($invoiceid);
                $custid=$invoice->getProjectFk()->getCustomerFk()->getCustomerIdPk();
                $projid=$invoice->getProjectFk()->getPkid();
                $InvItemArr=$em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1),array('pkid'=>'ASC'));                
                $invPayArr=$em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('invoiceFk'=>$invoiceid,'recordActiveFlag'=>1));
                $shipAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getProjectFk()->getCustomerAddressFk()->getAddressFk());
                $addressArr=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
                $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllEmployees();
                $payModeArr=$em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER )->
                        findBy(array('recordActiveFlag'=>1,'isGlobal'=>1),array('paymentModeName'=>'ASC'));
                $projcontact=$em->getRepository(CommonConstant::ENT_PROJ_CONTACT)->findBy(array('projectFk'=>$invoice->getProjectFk()->getPkid(),'recordActiveFlag'=>1))[0];
                $contperson=$projcontact->getContactFk()->getPersonFk();   
                $mobconttxn=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$projcontact->getContactFk(),'recordActiveFlag'=>1))[0];
                $contno=$mobconttxn->getMobileNo()->getMobileNo();
                $projExpense=$em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)
                    ->findBy(array('projectFk'=>$projid,'approvalFlag'=>1,'isBilled'=>0,'recordActiveFlag'=>1));
                $itemArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetUnbilledItems($projid);            
                $serviceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetUnbilledServices($projid);
                $vatTax=$em->getRepository(CommonConstant::ENT_TAX_MASTER)->findBy(array('taxCode'=>'VAT','recordActiveFlag'=>1));
                $serviceTax=$em->getRepository(CommonConstant::ENT_TAX_MASTER)->findBy(array('taxCode'=>'SERVICE','recordActiveFlag'=>1));
                $finalArr=array();
                if($itemArr){
                    foreach($itemArr as $item){
                        $finalArr[]=$item;
                        $itemprdid=$item->getItemFk()->getPkid();
                        foreach($serviceArr as $service){
                            $srvprdid=$service->getServiceFk()->getProductFk()->getPkid();
                            if($itemprdid==$srvprdid){
                                $finalArr[]=$service;
                            }
                        }
                    }
                }elseif(!$itemArr && $serviceArr){
                    foreach($serviceArr as $service){
                        $finalArr[]=$service;
                    }
                }
                $VAT=0;
                $SRVTAX=0;
                if($vatTax){
                    $VAT=$vatTax[0]->getTaxValue();
                }
                if($serviceTax){
                    $SRVTAX=$serviceTax[0]->getTaxValue();
                }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(InvoiceConstant::TWIG_EDIT_INVOICE,
                        array('invoice'=>$invoice,'invPayArr'=>$invPayArr,'addressArr'=>$addressArr,'empArr'=>$empArr,'shipAdd'=>$shipAddress,
                                'payModeArr'=>$payModeArr,'invPayArr'=>$invPayArr,'cperson'=>$contperson,'mobno'=>$contno)));
                $this->erpMessage->setSecondHtml($this->renderView(InvoiceConstant::TWIG_EDIT_INVOICE_ITEM_LIST,
                        array('InvItemArr'=>$InvItemArr,'newitemArr'=>$finalArr,'invoice'=>$invoice,'projexpense'=>$projExpense,
                        'vattax'=>$VAT,'sTax'=>$SRVTAX)));
            }catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/updateinvoice/{invoiceid}", name="_updateinvoice")
     */
    public function UpdateInvoiceAction(Request $request,$invoiceid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageInvoice');
        if($accessRight==1){
        $result=$this->get(InvoiceConstant::SERVICE_INVOICE)->UpdateInvoice($request,$invoiceid);
        if($result['code']==1){
            $em=$this->getDoctrine()->getManager();            
            $company=$em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findAll();
            $company=$company?$company[0]:null;
            $invoice=$result['invoice'];
            $cmpaddtxn=$em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->findBy(array('companyFk'=>$company,'isPrimaryAddress'=>1,'recordActiveFlag'=>1));
            $cmpadd='';            
            if($cmpaddtxn){
                $cmpaddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($cmpaddtxn[0]->getAddressFk());
            }
            $mobArr=$em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->GetAllActiveMobileNo();
            $billAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getBillingAddressFk()->getAddressFk());
            $shipAddress=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($invoice->getShippingAddressFk()->getAddressFk());
            $payterm=$em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $itemArr=$em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $this->erpMessage->setSuccess(true);            
        }else{
            $this->erpMessage->setSuccess(true);            
        }        
        $this->erpMessage->setMessage($result['msg']);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
}