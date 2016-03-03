<?php

namespace Tashi\ProjectBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\ProjectBundle\Helper\ProjectConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
/**
 * @Route("/Project")
 */
class ProjectController extends Controller
{
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
   /**
     * @Route ("/master_dashboard", name="_pro_master_dashboard")
     */
    public function projectDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('projectDashboardAction');
        if($accessRight==1){
            try{                   
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PRO_DASHBOARD ));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
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
     * Action: Navigate to new Project page
     * @Route("/newproject", name="_gotonewproject")
     */
    public function NewProjectAction()
    { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProject');
	if($accessRight==1){

            try{                   
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_NEW_PROJECT ));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
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
     * Action: Search Customer, Addresses, Contacts for use in project
     * @Route ("/searchcustomerproj", name="_searchcustomerproj")
     */
    public function SearchCustomerAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $dataUI=json_decode($request->getContent());
        try{
            $em=$this->getDoctrine()->getManager();                
            $custArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchCustomerForProject($dataUI->txtSearchCust);
            if($custArr){
                $addArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchCustomerAddressesforProject($dataUI->txtSearchCust);
                $mobArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchCustomerContactsforProject($dataUI->txtSearchCust);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_CUSTOMER_LIST,
                    array('customerArr'=>$custArr,'addressArr'=>$addArr,'contactArr'=>$mobArr)));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Matching Record Found!!!!');
            }                
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to search customer due to technical problem. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to project step 2 with all the required data
     * @Route ("/step2/{custid}", name="_projstep2")
     */
    public function ProjectStepTwoAction($custid,Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();          
//            $dataUI=  json_decode($request->getContent());
//            $custId=$dataUI->custId;
            $existingproject=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
            //$usergroupArr=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1));            
            $isExist=0;
            if($existingproject){
                $isExist=1;
            }
            $areaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
            if(!$areaArr){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Project Area not found. In order to create a new project you must first create Project Area.');
            }else{
                $industryArr=$em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('industryType'=>'ASC'));
                if(!$industryArr){
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('Industry Type not found. Industry Type is required to create a new project.');
                }else{
                    $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllEmployees();
                    if(!$empArr){
                        $this->erpMessage->setSuccess(false);
                        $this->erpMessage->setMessage('Employee Not Found. Employees are required in order to assign the project.');
                    }else{
                        $oppArr=$em->getRepository(CommonConstant::ENT_OPPORTUNITY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('pkid'=>'asc'));                        
                        $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_STATUS_MASTER)->findBy(
                                                                                            array('isPermanent'=>0,'recordActiveFlag'=>1));
                        $this->erpMessage->setSuccess(true);
                        $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STEP_2,
                                array('empArr'=>$empArr,'areaArr'=>$areaArr,'industryArr'=>$industryArr,
                                    'projStatusArr'=>$statusArr,'oppArr'=>$oppArr,'isexist'=>$isExist)));
                    }
                }
            }    
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);        
    }
    /**
     * Action: Create Project and Navigate to Step 3(item selection page)
     * @Route ("/createandproceed", name="_createproject_step3")
     */
    public function CreateProjectAndProceedAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->CreateProject($request);
        if($result['code']==1){
            try{
                $dataUI=  json_decode($request->getContent());
                $areaid=$dataUI->selProjArea;
                $em=$this->getDoctrine()->getManager();
                $cattxnArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetSortedProductCategoryByAreaId($areaid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_LIST,
                        array('projectid'=>$result['projectid'],'areaid'=>$areaid,'orderno'=>$result['ordno'],
                            'cattxnArr'=>$cattxnArr,'from'=>'createproject')));
            } catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Unable to proceed due to a technical error. Error: '.$ex->getMessage());
            }
        }else{
             $this->erpMessage->setSuccess(false);
             $this->erpMessage->setMessage($result['msg']);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);        
    }    
    /**
     * @Route("/loadprojectitems/{catid}", name="_loadprojitems")
     */
    public function LoadProjectItemByCategoryAction($catid){
        //TWIG_PROJ_ITEM_LIST
        $em=$this->getDoctrine()->getManager();
        try{
            $priceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetPriceByCatId($catid);    
            if($priceArr){
                $unitArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetItemUnitsByCatId($catid); 
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetExistingServiceByCatId($catid);
            }else{
                $unitArr=array();
                $serviceArr=array();
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_PRODUCT_LIST,
                    array('catid'=>$catid,'priceArr'=>$priceArr,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr)));
        }catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to proceed due to a technical error. Error: '.$ex->getMessage());
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();       
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Load Project Items for a selected Category
     * @Route ("/projectitems/{areaid}", name="_projectitems")
     */
    public function LoadProjectItemAction($areaid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
        try{
            $em=$this->getDoctrine()->getManager();                
            $cattxnArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetSortedProductCategoryByAreaId($areaid);
            $priceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemByAreaId($areaid);     
            $prodStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->findBy(array('recordActiveFlag'=>1));    
            $workerArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllWorkers(); 
            $unitArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetItemUnitsByAreaId($areaid); 
            $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetExistingServiceByAreaId($areaid);
            if($cattxnArr){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_LIST,
                    array('areaid'=>$areaid,'cattxnArr'=>$cattxnArr,'priceArr'=>$priceArr,'prdStatusArr'=>$prodStatusArr,
                        'workerArr'=>$workerArr,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr)));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Item(s) Found!!!');
            }                
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to load Project Item. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Add Project Item and Service
     * @Route ("/addprojectitemservice", name="_addprojectitemservice")
     */
    public function AddProjectItemServiceAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddProjectItemAndService($request);
        if($result['code']==1){
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_CONFIRM,array('project'=>$result['project'])));
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
     * Action: Load Project Add Items for a selected Category
     * @Route ("/projectadditems/{areaid}/{projectid}", name="_projectadditems")
     */
    public function GotoAddProjectItemServiceAction($areaid,$projectid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projectid);
            $cattxnArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetSortedProductCategoryByAreaId($areaid);
            $priceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemByAreaId($areaid);     
            $projectPrdArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemsByProjectId($projectid);
            $prodStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->findBy(array('recordActiveFlag'=>1));    
            $workerArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllWorkers(); 
            $unitArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetItemUnitsByAreaId($areaid); 
            $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetExistingServiceByAreaId($areaid);            
            _startover:
            $i=0;
            foreach($priceArr as $price){
                foreach($projectPrdArr as $prod){
                    if($price->getProduct()->getPkid()==$prod->getItemFk()->getPkid()){
                        array_splice($priceArr, $i,1);
                        goto _startover;
                    }
                }
                $i++;
            }
            if($priceArr){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_LIST,
                        array('projectid'=>$projectid,'areaid'=>$areaid,'orderno'=>$project->getOrderNo(),
                            'cattxnArr'=>$cattxnArr,'priceArr'=>$priceArr,'prdStatusArr'=>$prodStatusArr,
                            'workerArr'=>$workerArr,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>'projectdetail')));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Either all items are already added to the Project or No item has been added in the database yet.');
            }
        }catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to proceed due to a technical error. Error: '.$ex->getMessage());
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    
    /**
     * Action: Navigate to project step 3 for capturingProject detail
     * @Route ("/step3", name="_projstep3")
     */
    public function ProjectStepThreeAction(){
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();   
            $areaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(
                    array('recordActiveFlag'=>1),array('area'=>'ASC'));
            if($areaArr){                
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STEP_2,
                    array('areaArr'=>$areaArr,'empArr'=>$empArr)));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Project Category Found!!!');
            }                
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to load Project Category. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to project step 4 for capturing Advance Payment detail
     * @Route ("/step4", name="_projstep4")
     */
    public function ProjectStepFourAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();  
            $paymodes=$em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag'=>1),array('paymentModeName'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STEP_4,array('payModes'=>$paymodes)));
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to proceed due to a technical error. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * Action: Navigate to project step 5 and display summary of the project to be created
     * @Route ("/step5", name="_projstep5")
     */
    public function ProjectStepFiveAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        //$dataUI=json_decode($request->getContent());
        $dataUI= json_decode($request->getContent());
        try{
            $em=$this->getDoctrine()->getManager();  
            $custId=$dataUI->custId;
            $addId=$dataUI->addressId;
            $contactId=$dataUI->contactId;
            //customer detail
            $cust=$em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($custId);            
            $contact=$em->getRepository(CommonConstant::ENT_CONTACT_TXT)->find($contactId);
            $mobTxn=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contactId))[0];
            $addMaster=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($addId)->getAddressFk();
            $address=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($addMaster);
            //employee(site coordinator)
            $empId=$dataUI->selCoordinator;
            $emp=$em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($empId);
            //project category
            $areaid=$dataUI->projectArea;
            $area=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($areaid);
            //project items
            $itemIds=$dataUI->txtItemId;
            $prices=$dataUI->price;
            $qtys=$dataUI->txtQuantity;
            $costs=$dataUI->txtCharge;
            $isSelectedArr=$dataUI->txtIsSelected;
            $totPrice=$dataUI->txtGrandPrice;
            $totalCharge=$dataUI->txtGrandCharge;
            $totBudget=$dataUI->txtTotBudget;
            $itemArr=array('item'=>array(),'price'=>array(),'qty'=>array(), 'charge'=>array());
            if(is_array($itemIds)){
                for($i=0;$i<count($itemIds);$i++){
                    $itemid=$itemIds[$i];
                    if($isSelectedArr[$i]=='1'){
                        $item=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($itemid);
                        array_push($itemArr['item'],$item);
                        array_push($itemArr['price'],$prices[$i]);
                        array_push($itemArr['qty'],$qtys[$i]);
                        array_push($itemArr['charge'],$costs[$i]);
                    }
                }
            }else{
                if($isSelectedArr=='1'){
                    $item=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($itemIds);
                    array_push($itemArr['item'],$item);
                    array_push($itemArr['price'],$prices);
                    array_push($itemArr['qty'],$qtys);
                    array_push($itemArr['charge'],$costs);
                }
            } 
            //Project Detail
            $startDate=$dataUI->txtStartDate;
            $endDate=$dataUI->txtCompleteDate;
            $desc=$dataUI->txtProjDesc;
            //Referrer Detail
            $refname=$dataUI->txtReferrerName;
            $refno=$dataUI->txtReferrerNo;
            $aboutref=$dataUI->txtAboutRef;
            //Advance Payment
            $isAdvPaid=$dataUI->inputIsAdvPaid;
            if($isAdvPaid){
                $paymodeId=$dataUI->selpayMode;
                $paymode=$em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find(explode('&',$paymodeId)[0]);
                $payno='';
                if(isset($dataUI->txtTranNo)){
                    $payno=$dataUI->txtTranNo;
                }
                $bankname='';
                if(isset($dataUI->txtBankName)){
                    $bankname=$dataUI->txtBankName;
                }

                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STEP_5,
                    array('cust'=>$cust,'contact'=>$contact,'mob'=>$mobTxn,'address'=>$address,'emp'=>$emp,'itemArr'=>$itemArr,'totprice'=>$totPrice,
                        'totcharge'=>$totalCharge,'totbudget'=>$totBudget,'area'=>$area,
                        'sdate'=>$startDate,'edate'=>$endDate,'desc'=>$desc,'refName'=>$refname,'refno'=>$refno,'aboutref'=>$aboutref,
                        'paymode'=>$paymode->getPaymentModeName(),'payno'=>$payno,'bank'=>$bankname,'paydate'=>$dataUI->txtPayDate,
                        'amount'=>$dataUI->txtAmount,'remark'=>$dataUI->txtremarks)));               
            }
            else{
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STEP_5,
                    array('cust'=>$cust,'contact'=>$contact,'mob'=>$mobTxn,'address'=>$address,'emp'=>$emp,'itemArr'=>$itemArr,
                        'totprice'=>$totPrice,'totcharge'=>$totalCharge,'totbudget'=>$totBudget,'area'=>$area,
                        'sdate'=>$startDate,'edate'=>$endDate,'desc'=>$desc,'refName'=>$refname,'refno'=>$refno,'aboutref'=>$aboutref)));  
            }
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to proceed due to a technical error. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Save Project Detail
     * @Route ("/createproject", name="_createproject")
     */
    public function CreateProjectAction(Request $request){        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->CreateProject($request);
        if($result['code']=='1'){
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_CONFIRM,array('projectid'=>$result['projectid'],'orderno'=>$result['ordno'])));
        }else{
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($result['msg']);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);        
    }
    
     /**
     * Action: Save Project Detail
     * @Route ("/addprojectnewitem", name="_addprojectnewitem")
     */
    public function AddProjectNewItemAction(Request $request){        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddProjectNewItem($request);
        if($result['code']=='1'){
            $dataUI=  json_decode($request->getContent());
            $projid=$dataUI->inputProjId;
            $em=$this->getDoctrine()->getManager();
            $itemArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('startDate'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_DETAIL_LIST,array('itemArr'=>$itemArr,)));
        }else{
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($result['msg']);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * Action: Load project detail by project id & Navigate to Project Detail Index
     * @Route ("/projectdetailindex/{projid}", name="_projectdetailindex")
     */
    public function GotoProjectDetailIndex($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();
            $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllEmployees();
            $proj=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $totalPaidAmt=0;
            $totExpense=0;
            $limitAmt=0;
            $totAdv=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetTotalPaidAmount($projid);
            $expense=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetTotalExpense($projid);
            $limit=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetLimitAmount($projid);
            $pmLog=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetLastestModiLog($projid); //latest project modification log
            $pmLogArr=$em->getRepository(CommonConstant::ENT_PROJ_MODIFICATION_LOG)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('pkid'=>'desc'));

            if($pmLog){
                $pmLog=$pmLog[0];
            }
            if($totAdv){
                $totalPaidAmt=$totAdv[0]['Amount'];
            }
            if($expense){
                $totExpense=$expense[0]['Amount'];
            }
            if($limit){
                $limitAmt=$limit[0]['Amount'];
            }
            $address=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($proj->getCustomerAddressFk()->getAddressFk());
            $contact=$em->getRepository(CommonConstant::ENT_PROJ_CONTACT)->findBy(array('projectFk'=>$projid,'isPrimaryContact'=>1,'recordActiveFlag'=>1))[0];
            $mob=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contact->getContactFk(),'recordActiveFlag'=>1));
            if($mob){
                $mob=$mob[0];
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DETAIL_INDEX,array('projectid'=>$proj->getPkid())));
            $this->erpMessage->setSecondHtml($this->renderView(ProjectConstant::TWIG_PROJ_DETAIL,
                    array('proj'=>$proj,'address'=>$address,'contact'=>$contact,'mob'=>$mob,
                        'limitAmt'=>$limitAmt,'totalPaid'=>$totalPaidAmt,'totalExpense'=>$totExpense,'pmlog'=>$pmLog,'pmlogArr'=>$pmLogArr,'empArr'=>$empArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Load Items from project_item_txn table for capturing detail such as start date, end date,workers etc
     * @Route ("/projectdetail/{projid}", name="_projectdetail")
     */
    public function GotoProjectDetailAction($projid){
         $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager(); 
            $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllEmployees();
            $proj=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            //$advPayArr=$em->getRepository(CommonConstant::ENT_PROJ_ADV_PAYMENT)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('paymentDate'=>'DESC'));
            $totalPaidAmt=0;
            $totExpense=0;
            $limitAmt=0;
            $totAdv=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetTotalPaidAmount($projid);
            $expense=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetTotalExpense($projid);
            $limit=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetLimitAmount($projid);
            $pmLog=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetLastestModiLog($projid); //latest project modification log
            $pmLogArr=$em->getRepository(CommonConstant::ENT_PROJ_MODIFICATION_LOG)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('pkid'=>'desc'));
            if($pmLog){
                $pmLog=$pmLog[0];
            }
            if($totAdv){
                $totalPaidAmt=$totAdv[0]['Amount'];
            }
            if($expense){
                $totExpense=$expense[0]['Amount'];
            }
            if($limit){
                $limitAmt=$limit[0]['Amount'];
            }
            $totalBudget=0;
            $ItemService=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1));
//            if($advPayArr){
//                $totalPaidAmt+=$advPayArr[0]->getAmount();
//                $limitAmt=$advPayArr[0]->getAlertPc();
//            }else{
//                $limitAmt=0;
//            }
            if($ItemService){
                foreach($ItemService as $service){
                    $price=$service->getUnitPrice();
                    $qty=$service->getQuantity();
                    $totalBudget+=($price*$qty);
                }
            }
            $address=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($proj->getCustomerAddressFk()->getAddressFk());
            $contact=$em->getRepository(CommonConstant::ENT_PROJ_CONTACT)->findBy(array('projectFk'=>$projid,'isPrimaryContact'=>1,'recordActiveFlag'=>1))[0];
            $mob=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contact->getContactFk(),'recordActiveFlag'=>1));
            if($mob){
                $mob=$mob[0];
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DETAIL,
                    array('proj'=>$proj,'address'=>$address,'contact'=>$contact,'mob'=>$mob,'limitAmt'=>$limitAmt,
                        'totalPaid'=>$totalPaidAmt,'totalExpense'=>$totExpense,'totBudget'=>$totalBudget,'pmlog'=>$pmLog,'pmlogArr'=>$pmLogArr,'empArr'=>$empArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        } 
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to Edit Project detail action
     * @Route ("/editprojectdetail/{projid}", name="_editprojectdetail")
     */
    public function GotoEditProjectDetailAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProject');
        if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $industryArr=$em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('industryType'=>'ASC'));
            $oppArr=$em->getRepository(CommonConstant::ENT_OPPORTUNITY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('pkid'=>'asc'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_EDIT_DETAIL,array('proj'=>$project,'industryArr'=>$industryArr,'oppArr'=>$oppArr)));
        }catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Cancel Edit project  and reload the project detail page
     * @Route ("/canceleditproject/{projid}", name="_canceleditproject")
     */
    public function CancelEditProjectAction($projid){
         $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DETAIL_ONLY,array('proj'=>$project)));
        }catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Project Detail
     * @Route ("/updateproject/{projid}", name="_updateproject")
     */
    public function UpdateProjectAction(Request $request,$projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProject');
	if($accessRight==1){
            $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UpdateProject($request,$projid);
            if($result['code']==1){
                try{
                    $em=$this->getDoctrine()->getManager();
                    $proj=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                    $totalPaidAmt=0;
                    $totExpense=0;
                    $limitAmt=0;
                    $totAdv=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetTotalPaidAmount($projid);
                    $expense=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetTotalExpense($projid);
                    $limit=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetLimitAmount($projid);
                    $pmLog=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetLastestModiLog($projid); //latest project modification log
                    $pmLogArr=$em->getRepository(CommonConstant::ENT_PROJ_MODIFICATION_LOG)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('pkid'=>'desc'));

                    if($pmLog){
                        $pmLog=$pmLog[0];
                    }
                    if($totAdv){
                        $totalPaidAmt=$totAdv[0]['Amount'];
                    }
                    if($expense){
                        $totExpense=$expense[0]['Amount'];
                    }
                    if($limit){
                        $limitAmt=$limit[0]['Amount'];
                    }
                    $totalBudget=0;
                    $ItemService=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1));
                    if($ItemService){
                        foreach($ItemService as $service){
                            $price=$service->getUnitPrice();
                            $qty=$service->getQuantity();
                            $totalBudget+=($price*$qty);
                        }
                    }
                    $address=$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforDetail($proj->getCustomerAddressFk()->getAddressFk());
                    $contact=$em->getRepository(CommonConstant::ENT_PROJ_CONTACT)->findBy(array('projectFk'=>$projid,'isPrimaryContact'=>1,'recordActiveFlag'=>1))[0];
                    $mob=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contact->getContactFk(),'recordActiveFlag'=>1));
                    if($mob){
                        $mob=$mob[0];
                    }
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DETAIL_ONLY,array('proj'=>$proj,'address'=>$address,'contact'=>$contact,'mob'=>$mob,
                            'limitAmt'=>$limitAmt,'totalPaid'=>$totalPaidAmt,'totalExpense'=>$totExpense,'pmlog'=>$pmLog,'pmlogArr'=>$pmLogArr)));
                }catch (Exception $ex) {
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
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
     * Action: Navigate to Edit Project Referrer detail page for editing Project Referrer Detail
     * @Route ("/editprojectrefdetail/{projid}", name="_editprojectrefdetail")
     */
    public function GotoEditProjectRefDetailAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProject');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_EDIT_REF,array('proj'=>$project)));
        }catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
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
     * Action: Cancel Edit project Referrer  and reload the project detail page
     * @Route ("/canceleditprojectref/{projid}", name="_canceleditprojectref")
     */
    public function CancelEditProjectRefAction($projid){
         $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_REF_DETAIL_,array('proj'=>$project)));
        }catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Project Detail
     * @Route ("/updateprojectref/{projid}", name="_updateprojectref")
     */
    public function UpdateProjectRefAction(Request $request,$projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProject');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UpdateProjectRef($request,$projid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_REF_DETAIL_,array('proj'=>$project)));
            }catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        }
        else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    } 
    /**
     * Action: Change Project Coordinator
     * @Route ("/changecoordinator/{projid}", name="_changecoordinator")
     */
    public function ChangeProjectCoordinatorAction(Request $request,$projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProject');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->ChangeProjectCoordinator($request,$projid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllEmployees();
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_COORDINATOR_DETAIL,
                        array('proj'=>$project,'empArr'=>$empArr)));
            }catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
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
     * Action: Load Items from project_item_txn table for capturing detail such as start date, end date,workers etc
     * @Route ("/existingprojectitems/{projid}", name="_existingprojectitems")
     */
    public function LoadExistingProjectItemActions($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();   
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
//            $criteria=array('projectFk'=>$projid,'recordActiveFlag'=>1);
//            $sort=array('startDate'=>'ASC');
//            $itemArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->findBy($criteria,$sort);
            //$empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetAllWorkersByProjectId($projid);
            $itemArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemsByProjectId($projid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_DETAIL_LIST,array('project'=>$project,'itemArr'=>$itemArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Add Project Item and Service From Project Detail Page
     * @Route ("/addprojitemserviceprojdetail", name="_addprojitemserviceprojdetail")
     */
    public function AddProjectItemServiceSeparatelyAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
            $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddProjectItemAndService($request);
            if($result['code']==1){
                $em=$this->getDoctrine()->getManager();
                $dataUI=  json_decode($request->getContent());
                $projid=$dataUI->projectid;
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $this->erpMessage->setSuccess(true);
                $itemArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemsByProjectId($projid);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_DETAIL_LIST,array('itemArr'=>$itemArr,'project'=>$project)));
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
     * Action: Navigate to Add Item Detail Page for capturing detail of Item of a Project such as select worker, start date,end date etc
     * @Route ("/additemdetail/{itemid}", name="_additemdetail")
     */
    public function GotoAddItemDetailAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();            
                $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
                $workerArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllWorkers();
                $itemStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->findAll(array('statusName'=>'ASC'));
                $prodStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->findAll(array('statusName'=>'ASC'));
                //$address=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetAllWorkerAddress();
                $expertiseArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetFieldOfExpertize();
                //print_r($address);
    //            $addressArr=array('address'=>array(),'empid'=>array());
    //            if($address){
    //                foreach($address as $add){
    //                    array_push($addressArr['address'],$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforList($add->getAddressMasterFk()));
    //                    array_push($addressArr['empid'],$add->getEmpMasterFk()->getEmployeePk());
    //                }
    //            }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADD_ITEM_DETAIL,
                        array('item'=>$item,'empArr'=>$workerArr,'itemStatusArr'=>$itemStatusArr,
                            'prodStatusArr'=>$prodStatusArr,'expArr'=>$expertiseArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Add Detail for Project Item such as start date, deadline,status,assign worker etc,
     * @Route(path="/insertitemdetail", name="_insertitemdetail")
     */
    public function AddItemDetailAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddItemDetail($request);
        if($result['code']==1){
            $dataUI=  json_decode($request->getContent());            
            try{
                $em=$this->getDoctrine()->getManager();    
                $projid=$dataUI->inputProjectId;
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $criteria=array('projectFk'=>$projid,'recordActiveFlag'=>1);
                $sort=array('startDate'=>'ASC');
                $itemArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemsByProjectId($projid);
                $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetAllWorkersByProjectId($projid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_DETAIL_LIST,array('itemArr'=>$itemArr,'empArr'=>$empArr,'project'=>$project)));
            } catch (Exception $ex) {}
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
     * Action: Load Project Item detail and display
     * @Route ("/projitemdetail/{itemid}", name="_projitemdetail")
     */
    public function GotoProjectItemDetailAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();            
            $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $workerArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_WORKER_TXN)->findBy(
                    array('projectItemFk'=>$itemid,'recordActiveFlag'=>1));          
            $address=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetAllWorkerAddress();
            //print_r($address);
            $addressArr=array('address'=>array(),'empid'=>array());
            if($address){
                foreach($address as $add){
                    array_push($addressArr['address'],$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforList($add->getAddressMasterFk()));
                    array_push($addressArr['empid'],$add->getEmpMasterFk()->getEmployeePk());
                }
            }
            //print_r($address);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_DETAIL,
                    array('item'=>$item,'workerArr'=>$workerArr,'addressArr'=>$addressArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Load Project Item detail and display for editing Project Item Detail
     * @Route ("/editprojitemdetail/{itemid}", name="_editprojitemdetail")
     */
    public function GotoEditProjectItemDetailAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();            
            $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $product=$item->getItemFk();
            $itemworkerArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_WORKER_TXN)->findBy(
                    array('projectItemFk'=>$itemid,'recordActiveFlag'=>1));    
            $workerArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->RetrieveAllWorkers();
            $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->findAll(array('pkid'=>'ASC'));
            $prodStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->findAll(array('pkid'=>'ASC'));
            //$address=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetAllWorkerAddress();
            $workers=array('pkid'=>array(), 'empid'=>array(),'name'=>array(),'isExisting'=>array());
            $expertiseArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetFieldOfExpertize();
            $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('productFk'=>$product,'recordActiveFlag'=>1),array('unitName'=>'ASC'));
           //sync existing and new worker
            _repeat:
            for($i=0;$i<count($workerArr);$i++){
                $emp=$workerArr[$i];     
                array_push($workers['pkid'],$emp->getEmployeePk());
                array_push($workers['empid'],$emp->getEmployeeId());
                array_push($workers['name'],$emp->getPersonFk()->getPersonName());
                $flag=0;
                for($j=0;$j<count($itemworkerArr);$j++){
                    $iempid=$itemworkerArr[$j]->getWorkerFk()->getEmployeePk();                    
                    if($emp->getEmployeePk()==$iempid){
                        $flag=1;
                    }                   
                }
                if($flag==1){
                    array_push($workers['isExisting'],1);           
                }else{
                    array_push($workers['isExisting'],0);
                }
                array_splice($workerArr, $i,1);
                goto _repeat;
            }
//            $addressArr=array('address'=>array(),'empid'=>array());
//            if($address){
//                foreach($address as $add){
//                    array_push($addressArr['address'],$this->get(CommonConstant::SERVICE_COMMON)->AddressFormaterforList($add->getAddressMasterFk()));
//                    array_push($addressArr['empid'],$add->getEmpMasterFk()->getEmployeePk());
//                }
//            }
            //print_r($address);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_EDIT_ITEM,
                    array('item'=>$item,'itemworkerArr'=>$itemworkerArr,'expArr'=>$expertiseArr,
                        'itemStatusArr'=>$statusArr,'prodStatusArr'=>$prodStatusArr,'workerArr'=>$workers,'unitArr'=>$unitArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Load Related Services of a Project Item
     * @Route ("/loadprojitemservice/{itemid}", name="_loadprojitemservice")
     */
    public function LoadProjectItemService($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();       
            $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);            
            $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemService($item->getItemFk()->getPkid(),$item->getProjectFk()->getPkid());
            
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'item'=>$item)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Project Items
     * @Route(path="/edititemdetail/{itemid}", name="_edititemdetail")
     */
    public function EditItemDetailAction(Request $request,$itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->EditItemDetail($request,$itemid);
        if($result['code']==1){
            $dataUI=  json_decode($request->getContent());          
            try{
                $em=$this->getDoctrine()->getManager();    
                $projid=$dataUI->inputProjectId;
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $criteria=array('projectFk'=>$projid,'recordActiveFlag'=>1);
                $sort=array('startDate'=>'ASC');
                //$itemArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->findBy($criteria,$sort);
                $itemArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemsByProjectId($projid);
                $empArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetAllWorkersByProjectId($projid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_DETAIL_LIST,array('itemArr'=>$itemArr,'empArr'=>$empArr,'project'=>$project)));
            } catch (Exception $ex) {}
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
     * Action: Load Status log of a particular Project Item and display
     * @Route(path="/itemstatus/{itemid}", name="_itemstatus")
     */
    public function ItemStatusAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        try{
            $em=$this->getDoctrine()->getManager();
            $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $masterStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->findAll(array('pkid'=>'ASC'));
            $itemStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_TXN)->
                    findBy(array('itemFk'=>$itemid,'recordActiveFlag'=>1),array('statusDate'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_STATUS,
                    array('item'=>$item,'statusArr'=>$masterStatusArr,'itemstatusArr'=>$itemStatusArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Status  of a particular Project Item and display the status log
     * @Route(path="/updateitemstatus/{itemid}", name="_updateitemstatus")
     */
    public function UpdateItemStatusAction(Request $request,$itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UpdateItemStatus($request,$itemid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
                $masterStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->findAll(array('pkid'=>'ASC'));
                $itemStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_TXN)->
                        findBy(array('itemFk'=>$itemid,'recordActiveFlag'=>1),array('statusDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_STATUS,
                        array('item'=>$item,'statusArr'=>$masterStatusArr,'itemstatusArr'=>$itemStatusArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Load Status log of a particular Project Product and display
     * @Route(path="/productstatus/{itemid}", name="_productstatus")
     */
    public function ProductStatusAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
                $masterStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->findAll(array('pkid'=>'ASC'));
                $prodStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PRODUCT_STATUS_TXN)->
                        findBy(array('itemFk'=>$itemid,'recordActiveFlag'=>1),array('statusDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_PRODUCT_STATUS,
                        array('item'=>$item,'statusArr'=>$masterStatusArr,'prodstatusArr'=>$prodStatusArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Product Status  of a particular Project Item and display the status log
     * @Route(path="/updateprodstatus/{itemid}", name="_updateprodstatus")
     */
    public function UpdateProductStatusAction(Request $request,$itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UpdateProductStatus($request,$itemid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
                $masterStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->findAll(array('pkid'=>'ASC'));
                $prodStatusArr=$em->getRepository(CommonConstant::ENT_PROJ_PRODUCT_STATUS_TXN)->
                        findBy(array('itemFk'=>$itemid,'recordActiveFlag'=>1),array('statusDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_PRODUCT_STATUS,
                        array('item'=>$item,'statusArr'=>$masterStatusArr,'prodstatusArr'=>$prodStatusArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
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
     * Action: Search Advance Payment detail of a project and display
     * @Route (path="/searchadvancepayment/{projid}", name="_searchadvancepay")
     */
    public function SearchAdvancePaymentDetailsAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $payArr=$em->getRepository(CommonConstant::ENT_PROJ_ADV_PAYMENT)->findBy(
                    array('projectFk'=>$projid,'recordActiveFlag'=>1),array('pkid'=>'ASC'));
            $totalBudget=$project->getTotalEstimatedCost();
            $totalPaid=0;
            $totalPaidresult=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectPaidAmount($projid);
            foreach($totalPaidresult as $adv){
                $totalPaid=$adv['amount'];
            }
            $isDue=0;
            if($totalPaid<$totalBudget){
                $isDue=1;
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADV_PAY_LIST,array('payArr'=>$payArr,'project'=>$project,'isdue'=>$isDue)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }    
    /**
     * Action: Navigate to Add New Advance Payment Detail page
     * @Route ("/addadvpayment/{projid}", name="_addadvpayment")
     */
    public function GotoAddNewAdvPaymentAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();  
            $paymodes=$em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag'=>1),array('paymentModeName'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STEP_4,array('payModes'=>$paymodes,'projid'=>$projid)));
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Unable to proceed due to a technical error. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * 
     * @Route(path="/insertnewadvpay/{projid}",name="_insertadvpay")
     */
    public function AddNewAdvPaymentAction(Request $request,$projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddNewAdvancePayment($request,$projid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $payArr=$em->getRepository(CommonConstant::ENT_PROJ_ADV_PAYMENT)->findBy(
                        array('projectFk'=>$projid,'recordActiveFlag'=>1),array('paymentDate'=>'ASC'));                
                $totalBudget=$project->getTotalEstimatedCost();
                $totalPaid=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectPaidAmount($projid);
                $isDue=0;
                if($totalPaid<$totalBudget){
                    $isDue=1;
                }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADV_PAY_LIST,array('payArr'=>$payArr,'project'=>$projec,'isdue'=>$isDue)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }
        else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to Add Daily Report for capturing Daily Report of a project item
     * @Route ("/adddailyrpt/{itemid}", name="_adddailyrpt")
     */
    public function GotoAddDailyReportAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddDailyReport');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();            
            $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);            
            $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->findBy(array('isChangeable'=>1),array('statusName'=>'ASC'));           
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADD_DAILY_RPT,
                    array('item'=>$item,'statusArr'=>$statusArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Capture Daily Progress Report and save into database
     * @Route ("/insertdailyreport", name="_insertdailyreport")
     */
    public function InsertDailyReportAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddDailyReport');
	if($accessRight==1){
            $result=$this->get(ProjectConstant::SERVICE_PROJECT)->InsertDailyReport($request);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);                
            }else{
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);

    }
    /**
     * Action: View Daily Progress Report
     * @Route ("/viewdailyreport/{itemid}", name="_viewdailyreport")
     */
    public function DailyReportAction($itemid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DailyReportAction');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();  
            $item=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $rptArr=$em->getRepository(CommonConstant::ENT_PROJ_DAILY_RPT)->
                    findBy(array('projectItemFk'=>$itemid,'recordActiveFlag'=>1),array('reportDate'=>'ASC'));            
            $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->findBy(array('isChangeable'=>1),array('statusName'=>'ASC'));           
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DAILY_RPT,
                    array('item'=>$item,'reportArr'=>$rptArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }     
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Search Advance Payment detail of a project and display
     * @Route ("/searchexpenditure/{projid}", name="_searchexpenditure")
     */
    public function SearchExpenditureDetailsAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        try{
            $em=$this->getDoctrine()->getManager();
            $expArr=$em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)->findBy(
                    array('projectFk'=>$projid,'recordActiveFlag'=>1,'approvalFlag'=>1),array('pkid'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_EXPENDITURE_LIST,array('expArr'=>$expArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Search & Display all related documents of a project
     * @Route ("/searchprojdocs/{projid}", name="_searchprojdocs")
     */
    public function LoadProjectDocumentsAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectDocument');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $docArr=$em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->findBy(
                    array('projectFk'=>$projid,'recordActiveFlag'=>1),array('pkid'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DOC_LIST,array('docArr'=>$docArr,'project'=>$project)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
    }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    } 
    /**
     * Action: Navigate to Upload Project Documents
     * @Route ("/uploadprojdoc/{projid}", name="_gotouploadprojdoc")
     */
    public function GotoUploadDocAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectDocument');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();            
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);             
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DOC_UPLOAD,
                    array('project'=>$project)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to Upload Project Documents
     * @Route ("/adddocument/{projid}", name="_insertdocument")
     */
    public function UploadProjDocAction(Request $request,$projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectDocument');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UploadProjectDocument($request,$projid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $docArr=$em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->findBy(
                        array('projectFk'=>$projid,'recordActiveFlag'=>1),array('addDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DOC_LIST,array('docArr'=>$docArr,'project'=>$project)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }
        else{
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
     * Action: Navigate to Upload Project Documents for updating document
     * @Route ("/editprojdoc/{docid}", name="_gotoeditprojdoc")
     */
    public function GotoUpdateProjDocument($docid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        try{
            $em=$this->getDoctrine()->getManager();             
            $doc=$em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->find($docid);
            $project=$doc->getProjectFk();
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DOC_UPLOAD,array('doc'=>$doc,'project'=>$project)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }        
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Project DOcument details
     * @Route ("/updateprojdoc/{docid}", name="_updateprojdoc")
     */
    public function UpdateProjectDocument(Request $request,$docid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UpdateProjectDocument($request,$docid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager(); 
                $projid=$result['projid'];
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $docArr=$em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->findBy(
                        array('projectFk'=>$projid,'recordActiveFlag'=>1),array('addDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DOC_LIST,array('docArr'=>$docArr,'project'=>$project)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }
        else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Project DOcument details
     * @Route ("/deleteprojdoc/{docid}", name="_deleteprojdoc")
     */
    public function DeleteProjectDocument($docid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->DeleteProjectDocument($docid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager(); 
                $doctxn=$em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->find($docid);
                $project=$doctxn->getProjectFk();
                $docArr=$em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->findBy(
                        array('projectFk'=>$project,'recordActiveFlag'=>1),array('addDate'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_DOC_LIST,array('docArr'=>$docArr,'project'=>$project)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }
        else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
     /**
     * Action: Load project status log
     * @Route ("/viewprojectstatus/{projid}", name="_viewprojectstatus")
     */
    public function ViewProjectStatusLog($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        try{
            $em=$this->getDoctrine()->getManager(); 
            $poject=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_STATUS_TXN)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('pkid'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STATUS_LOG,array('statusArr'=>$statusArr,'project'=>$poject)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Nagivate to Project Status Update Page
     * @Route ("/projectstatus/{projid}", name="_projectstatus")
     */
    public function GotoProjectStatusUpdateAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        try{
            $em=$this->getDoctrine()->getManager(); 
            $poject=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_STATUS_MASTER)->findBy(
                    array('recordActiveFlag'=>1));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STATUS_UPDATE,array('statusArr'=>$statusArr,'project'=>$poject)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Update Project DOcument details
     * @Route ("/updateprojstatus/{projid}", name="_updateprojstatus")
     */
    public function UpdateProjectStatus(Request $request,$projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->UpdateProjectStatus($request,$projid);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();                
                $poject=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_STATUS_TXN)->findBy(array('projectFk'=>$projid,'recordActiveFlag'=>1),array('statusDate'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_STATUS_LOG,array('statusArr'=>$statusArr,'project'=>$poject)));
            } catch (Exception $ex) {                
            }
        }
        else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to search project page
     * @Route ("/searchprojectpage/", name="_gotosearchproject")
     */
    public function GotoSearchProjectAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchProject');
	if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();

                $areaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
                $statusArr=$em->getRepository(CommonConstant::ENT_PROJ_STATUS_MASTER)->findAll(array('statusName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_SEARCH,array('areaArr'=>$areaArr,'statusArr'=>$statusArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * Action: Search project
     * @Route ("/searchproject", name="_searchproject")
     */
    public function SearchProjectAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchProject');
	if($accessRight==1){
            $dataUI=json_decode($request->getContent());
            $criteria=$dataUI->selSearchProjCriteria;
            try{            
                $em=$this->getDoctrine()->getManager();
                switch($criteria){
                    case 'all':
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchAllProject();
                        break;
                    case 'ordno':
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchProjectByOrdNo(trim($dataUI->txtCriteria));
                        break;
                    case 'cname':
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchProjectByCustName(trim($dataUI->txtCriteria));
                        break;
                    case 'ename':
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchProjectByEmployee(trim($dataUI->txtCriteria));
                        break;
                    case 'area':
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchProjectByArea($dataUI->selProjArea);
                        break;
                    case 'date':
                        $sdate=$dataUI->txtsdate;
                        $edate=$dataUI->txtedate;
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->SearchProjectByDate($sdate,$edate);
                        break;
                    case 'status':
                        $statusid=$dataUI->selProjStatus;
                        $criteria=array('status'=>$statusid,'recordActiveFlag'=>1);                    
                        $projArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->findBy($criteria,array('startDate'=>'ASC'));
                        break;
                }
                if($projArr){ 
                    $advanceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectWiseAdvance();
                    $expenseArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectWiseExpenses();
                    $limitArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectWiseLimitAmount();
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_SEARCH_RESULT,
                            array('projArr'=>$projArr,'advanceArr'=>$advanceArr,'expenseArr'=>$expenseArr,'limitArr'=>$limitArr)));
                }else{
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No Matching Record Found!!!');
                }
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }  
    /**
     * Action: Goto to Add New Item service
     * @Route ("/additemservice/{itemtxnid}/{mode}", name="_gotoadditemservice")
     */
    public function GotoAddNewItemService($itemtxnid,$mode){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $em=$this->getDoctrine()->getManager();     
        try{      
            $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
            $serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('productFk'=>$itemtxn->getItemFk(),'recordActiveFlag'=>1),array('serviceName'=>'asc'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_SERVICE_DETAIL,
                    array('serviceArr'=>$serviceArr,'itemtxn'=>$itemtxn,'mode'=>$mode)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }   
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Insert new item service in project_item_txn
     * @Route ("/insertnewitemservice", name="_insertnewitemservice")
     */
    public function InsertNewItemServiceAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddNewItemService($request);
        if($result['code']==1){
            try{ 
                $dataUI=  json_decode($request->getContent());               
                $em=$this->getDoctrine()->getManager();   
                $itemtxnid=$dataUI->inputitemtxnid;
                $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemService($itemtxn->getItemFk()->getPkid(),$itemtxn->getProjectFk()->getPkid());
            
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'item'=>$itemtxn)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            } 
        }
        else{
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
     * Action: If value of mode = DEL then delete the selected service,else laod service detail and display
     * @Route ("/itemserviceaction/{itemtxnid}/{serviceid}/{mode}", name="_itemserviceaction")
     */
    public function ItemServiceAction($itemtxnid,$serviceid,$mode){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $em=$this->getDoctrine()->getManager();     
        if($mode=='EDT'){
            try{                   
                $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
                $service=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($serviceid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_SERVICE_DETAIL,
                        array('service'=>$service,'itemtxn'=>$itemtxn,'mode'=>$mode)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }elseif($mode=='DEL'){
            $result=$this->get(ProjectConstant::SERVICE_PROJECT)->DeleteItemService($serviceid);
            if($result['code']==1){
                $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemService($itemtxn->getItemFk()->getPkid(),$itemtxn->getProjectFk()->getPkid());
            
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'item'=>$itemtxn)));
            }else{
                $this->erpMessage->setSuccess(true);
            }
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
     * Action: Update  item service in project_item_txn
     * @Route ("/updateitemservice", name="_updateitemservice")
     */
    public function UpdateItemServiceAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->EditItemService($request);
        if($result['code']==1){
            try{ 
                $dataUI=  json_decode($request->getContent());               
                $em=$this->getDoctrine()->getManager();   
                $itemtxnid=$dataUI->inputitemtxnid;
                $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectItemService($itemtxn->getItemFk()->getPkid(),$itemtxn->getProjectFk()->getPkid());
            
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ITEM_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'item'=>$itemtxn)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            } 
        }
        else{
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
     * Action: Load Additional Services for a Project
     * @Route ("/additionservice/{projid}", name="_additionservice")
     */
    public function LoadAdditionalServicesAction($projid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();       
            $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);            
            $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectAdditionalService($projid);
            //if($serviceArr){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADDITIONAL_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'project'=>$project)));
//            }else{
//               $this->erpMessage->setSuccess(false);
//                $this->erpMessage->setMessage('There are no services for this project.'); 
//            }
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process your request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Goto to Add New  Addition Service
     * @Route ("/addadditionalservice/{projid}/{mode}", name="_gotoaddadditionalservice")
     */
    public function GotoAddNewAdditionalService($projid,$mode){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        //$em=$this->getDoctrine()->getManager();     
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        try{    
            //$project=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADDITIONAL_SERVICE_DETAIL,
                    array('projectid'=>$projid,'mode'=>$mode)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }      
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Insert new project additional service
     * @Route ("/insertadditionalservice", name="_insertadditionalservice")
     */
    public function InsertAdditionalServiceAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->AddAdditionalService($request);
        if($result['code']==1){
            try{ 
                $dataUI=  json_decode($request->getContent());               
                $projid=$dataUI->inputprojectid;
                $em=$this->getDoctrine()->getManager();
                $project=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);            
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectAdditionalService($projid);
            //if($serviceArr){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADDITIONAL_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'project'=>$project)));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            } 
        }
        else{
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
     * Action: If value of mode = DEL then delete the selected service,else laod service detail and display
     * @Route ("/additionalserviceaction/{serviceid}/{mode}", name="_additionalserviceaction")
     */
    public function AdditionalServiceAction($serviceid,$mode){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageProjectItemService');
	if($accessRight==1){
        $em=$this->getDoctrine()->getManager(); 
        $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($serviceid);
        if($mode=='EDT'){
            try{        
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADDITIONAL_SERVICE_DETAIL,
                        array('itemtxn'=>$itemtxn,'projectid'=>$itemtxn->getProjectFk()->getPkid(),'mode'=>$mode)));
            }catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }elseif($mode=='DEL'){
            $result=$this->get(ProjectConstant::SERVICE_PROJECT)->DeleteAdditionalService($serviceid);
            if($result['code']==1){                
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectAdditionalService($itemtxn->getProjectFk()->getPkid());
            
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADDITIONAL_SERVICE_LIST,
                    array('serviceArr'=>$serviceArr,'project'=>$itemtxn->getProjectFk())));
            }else{
                $this->erpMessage->setSuccess(true);
            }
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
     * Action: Update  Project Additional service in project_item_txn
     * @Route ("/updateadditionalservice", name="_updateadditionalservice")
     */
    public function UpdateAdditionalServiceAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $result=$this->get(ProjectConstant::SERVICE_PROJECT)->EditAdditionalService($request);
        if($result['code']==1){
            try{ 
                $dataUI=  json_decode($request->getContent());               
                $em=$this->getDoctrine()->getManager();   
                $itemtxnid=$dataUI->serviceid;
                $itemtxn=$em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemtxnid);
                $serviceArr=$em->getRepository(CommonConstant::ENT_PROJ_MASTER)->GetProjectAdditionalService($itemtxn->getProjectFk()->getPkid());
            
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_PROJ_ADDITIONAL_SERVICE_LIST,
                                            array('serviceArr'=>$serviceArr,'project'=>$itemtxn->getProjectFk())));
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            } 
        }
        else{
            $this->erpMessage->setSuccess(false);            
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
}


