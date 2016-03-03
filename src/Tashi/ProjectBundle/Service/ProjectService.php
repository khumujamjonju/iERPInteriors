<?php
namespace Tashi\ProjectBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\ProjectMaster;
use Tashi\CommonBundle\Entity\ProjectItemTxn;
use Tashi\CommonBundle\Entity\ProjectAdvancePayment;
use Tashi\CommonBundle\Entity\ProjectWallet;
use Tashi\CommonBundle\Entity\ProjectContactDetails;
use Tashi\CommonBundle\Entity\ProjectItemWorkerTxn;
use Tashi\CommonBundle\Entity\ProjectDailyReport;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\ProjectDocumentTxn;
use Tashi\CommonBundle\Entity\ProjectStatusTxn;
use Tashi\CommonBundle\Entity\ProjectItemStatusTxn;
use Tashi\CommonBundle\Entity\ProjectProductStatusTxn;
use Tashi\CommonBundle\Entity\ProjectModificationLog;
use Tashi\CommonBundle\Entity\ProjectNotification;
use Tashi\ProjectBundle\Helper\ProjectConstant;
use Tashi\CommonBundle\Entity\AccountHeadMaster;
class ProjectService {
    //put your code here
    protected $em;
    protected $mailer;
    protected $session;
    protected $webRoot;
    protected $commonService;
    protected $templating;
            
    public function __construct(EntityManager $em, Session $session, $rootDir,$commonService,$mailer,$templating) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = str_replace('app', '', $rootDir);
        $this->commonService = $commonService;
        $this->mailer=$mailer;
        $this->templating=$templating;
    }
    
    public function CreateProject($request){        
        //$dataUI=json_decode($request->getContent());
        $dataUI=  json_decode($request->getContent());
        $orderno='';
        $projectid='';
        $custid=$dataUI->custId;
        $addressid=$dataUI->addressId;
        $empid=$dataUI->selCoordinator;
        $industryid=$dataUI->selIndType;
        $opportunityid=$dataUI->selOpportunity;
        $dimension=$dataUI->txtdimension;
        $startDate=$dataUI->txtStartDate;
        $endDate=$dataUI->txtCompleteDate;
        $description=$dataUI->txtProjDesc;
        $refname=$dataUI->txtReferrerName;
        $refno=$dataUI->txtReferrerNo;
        $aboutref=$dataUI->txtAboutRef;
        $statusid=$dataUI->selProjectStatus;
        $areaid= $dataUI->selProjArea;        
        $empidArr=$dataUI->userlist;
      
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            //PROJECT MASTER
            $orderno=$this->commonService->AutoGenerate('P',7,'ProjectMaster','pkid');
            $area=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($areaid);
            $customer=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($custid);
            //$custName=$customer->getCustomerName();
            $address=$this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($addressid);
            $coordinator=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($empid);
            $projStatus=$this->em->getRepository(CommonConstant::ENT_PROJ_STATUS_MASTER)->find($statusid);
            $industry=$this->em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->find($industryid);
            $opportunity=$this->em->getRepository(CommonConstant::ENT_OPPORTUNITY_TYPE_MASTER)->find($opportunityid);
            $project=new ProjectMaster();  
            $project->setOrderNo(strtoupper($orderno));
            $project->setAreaFk($area);
            $project->setCustomerFk($customer);
            $project->setCustomerAddressFk($address);
            $project->setIndustryTypeFk($industry);
            $project->setOpportunityFk($opportunity);
            $project->setDimension($dimension);
            $project->setSiteCoordinator($coordinator);
            $project->setStartDate(new \DateTime($startDate));
            $project->setExpectedCompletionDate(new \DateTime($endDate));
            $project->setBalanceAmount(0);
            $project->setAmtLimit(0);
            $project->setDescription($description);
            $project->setReferrerName($refname);
            $project->setReferrerNumber($refno);
            $project->setReferrerAbout($aboutref);
            $project->setTotalEstimatedCost(0);
            $project->setRecordActiveFlag(1);
            $project->setRecordInsertDate(new \DateTime("NOW"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));           
            $project->setStatus($projStatus);
            $this->em->persist($project);
            $this->em->flush();  
            $projectid=$project->getPkid();
            
            //Insert Project Status Txn Array
            $status=new ProjectStatusTxn();
            $status->setProjectFk($project);
            $status->setStatusFk($projStatus);
            $status->setStatusDate(new \DateTime("NOW"));
            $status->setRemarks("Project Created");
            $status->setRecordActiveFlag(1);
            $status->setRecordInsertDate(new \DateTime("NOW"));
            $status->setApplicationUserId($this->session->get('EMPID'));
            $status->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($status);
            $this->em->flush();
           
            //PROJECT CONTACT
            $projCont=new ProjectContactDetails();
            $contactid=$dataUI->contactId;
            $contact=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->find($contactid);
            $projCont->setProjectFk($project);
            $projCont->setContactFk($contact);
            $projCont->setIsPrimaryContact(1);
            $projCont->setRecordActiveFlag(1);
            $projCont->setRecordInsertDate(new \DateTime("NOW"));
            $projCont->setApplicationUserId($this->session->get('EMPID'));
            $projCont->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->Persist($projCont);
            $this->em->flush();
            
            //PROJECT NOTIFICATION                        
            $applicationuserid=$this->session->get('EMPID');
            $applicationUser=  $this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($applicationuserid);
            $mob=$this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneBy(array('contact'=>$contact,'recordActiveFlag'=>1));            
            if(is_array($empidArr)){
                foreach($empidArr as $empid){                 
                    $employee=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($empid);                    
                    $person=$employee->getPersonFk();                    
                    $email=$person->getEmailIdOffice();
                    if(!$email){
                        $email=$person->getEmailId();
                    }
                    if(!empty($email)){
                        $template=$this->templating->render(ProjectConstant::TWIG_NOTIFICATION_TEMPLATE,
                                array('project'=>$project,'person'=>$person,'address'=>$this->commonService->AddressFormaterforDetail($address->getAddressFk()),
                                    'mob'=>$mob,'user'=>$applicationUser));
                        $this->SendMail($template, 'NEW PROJECT CREATED', $email, array());
                    }
                    
                    $projectNotification=new ProjectNotification();
                    $projectNotification->setEmpFk($employee);
                    $projectNotification->setProjectFk($project);
                    $projectNotification->setRecordInsertDate(new \DateTime('NOW'));
                    $this->em->persist($projectNotification);
                    $this->em->flush($projectNotification);                    
                }
            }else{
                if(!empty($empidArr)){    
                    $employee=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($empidArr);
                    $person=$employee->getPersonFk();
                    $email=$person->getEmailIdOffice();
                    if(!$email){
                        $email=$person->getEmailId();
                    }
                    if($email){
                        $template=$this->templating->render(ProjectConstant::TWIG_NOTIFICATION_TEMPLATE,
                                array('project'=>$project,'person'=>$person,'address'=>$this->commonService->AddressFormaterforDetail($address->getAddressFk()),
                                    'mob'=>$mob,'user'=>$applicationUser));
                        $this->SendMail($template, 'NEW PROJECT CREATED', $email, array());
                    }
                    $projectNotification=new ProjectNotification();
                    $projectNotification->setEmpFk($employee);
                    $projectNotification->setProjectFk($project);
                    $projectNotification->setRecordInsertDate(new \DateTime('NOW'));
                    $this->em->persist($projectNotification);
                    $this->em->flush($projectNotification);
                }
            }
            //CREATE ACCOUNT HEAD FOR THIS PROJECT
            //Account Head under INCOME
            $acHeadName=$customer->getCustomerName().'_'.$area->getArea().'_'.$orderno;
            $incomeAcHead=new AccountHeadMaster();
            $incomeAcHead->setAccountTypeFk($this->em->getRepository('TashiCommonBundle:AccountTypeMaster')->findOneByTypeName('Income'));
            $incomeAcHead->setHeadName($acHeadName);
            $incomeAcHead->setIsReserve(1);
            $incomeAcHead->setRecordActiveFlag(1);
            $incomeAcHead->setApplicationUserId($applicationuserid);
            $incomeAcHead->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($incomeAcHead);
            $this->em->flush($incomeAcHead);
            
            //Account Head under EXPENSE
            $expAcHead=new AccountHeadMaster();
            $expAcHead->setAccountTypeFk($this->em->getRepository('TashiCommonBundle:AccountTypeMaster')->findOneByTypeName('Expense'));
            $expAcHead->setHeadName($acHeadName);
            $expAcHead->setIsReserve(1);
            $expAcHead->setRecordActiveFlag(1);
            $expAcHead->setApplicationUserId($applicationuserid);
            $expAcHead->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($expAcHead);
            $this->em->flush($expAcHead);
            
            $conn->commit();
            $returnCode=1;            
            $returnmsg='';
            
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;           
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg,'ordno'=>$orderno,'projectid'=>$projectid);
    }
    public function AddProjectItemAndService($request){
        $dataUI=  json_decode($request->getContent());
        $projid=$dataUI->projectid;
        $prodIds=$dataUI->txtItemId;
        $prodSelectFlag=$dataUI->txtIsSelected;
        $prodUnits=$dataUI->selItemUnits;
        $prodPrices=$dataUI->price;
        $prodQtys=$dataUI->txtQuantity;        
        $totalBudget=0;
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $prevBudget=$project->getTotalEstimatedCost();
            //ADD PRODUCT/ITEMS
            if(is_array($prodSelectFlag)){
                for($i=0;$i<count($prodSelectFlag);$i++){
                    $isSelected=$prodSelectFlag[$i];
                    if($isSelected=='1'){
                        $totalBudget+=$prodQtys[$i]*$prodPrices[$i];
                        $product=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prodIds[$i]);
                        $projItem=new ProjectItemTxn();
                        $projItem->setProjectFk($project);
                        $projItem->setItemFk($product);
                        $projItem->setUnit($prodUnits[$i]);
                        $projItem->setUnitPrice($prodPrices[$i]);
                        $projItem->setQuantity($prodQtys[$i]);
                        $projItem->setIsStarted(0);
                        $projItem->setIsBilled(0);
                        $projItem->setRecordActiveFlag(1);
                        $projItem->setRecordInsertDate(new \DateTime("NOW"));
                        $projItem->setApplicationUserId($this->session->get('EMPID'));
                        $projItem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($projItem);
                        $this->em->flush($projItem);
                    }
                }
            }else{
                if($prodSelectFlag=='1'){
                    $totalBudget+=$prodQtys*$prodPrices;
                    $product=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prodIds);
                    $projItem=new ProjectItemTxn();
                    $projItem->setProjectFk($project);
                    $projItem->setItemFk($product);
                    $projItem->setUnit($prodUnits);
                    $projItem->setUnitPrice($prodPrices);
                    $projItem->setQuantity($prodQtys);
                    $projItem->setIsStarted(0);
                    $projItem->setIsBilled(0);
                    $projItem->setRecordActiveFlag(1);
                    $projItem->setRecordInsertDate(new \DateTime("NOW"));
                    $projItem->setApplicationUserId($this->session->get('EMPID'));
                    $projItem->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($projItem);
                    $this->em->flush($projItem);
                }
            }
            //ADD SERVICES
            if(isset($dataUI->txtServiceId)){
                $serviceIds=$dataUI->txtServiceId;
                $srvSelectFlag=$dataUI->txtserviceIsSelected;
                $serviceUnits=$dataUI->txtserviceunit;
                $serviceQtys=$dataUI->txtserviceqty;
                $servicePrices=$dataUI->txtserviceprice;
                
                if(is_array($srvSelectFlag)){
                    for($i=0;$i<count($srvSelectFlag);$i++){
                        $isSelected=$srvSelectFlag[$i];
                        if($isSelected=='1'){
                            $totalBudget+=$serviceQtys[$i]*$servicePrices[$i];
                            $service=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->find($serviceIds[$i]);
                            $projItem=new ProjectItemTxn();
                            $projItem->setProjectFk($project);
                            $projItem->setServiceFk($service);
                            $projItem->setUnit($serviceUnits[$i]);
                            $projItem->setUnitPrice($servicePrices[$i]);
                            $projItem->setQuantity($serviceQtys[$i]);
                            $projItem->setIsBilled(0);
                            $projItem->setRecordActiveFlag(1);
                            $projItem->setRecordInsertDate(new \DateTime("NOW"));
                            $projItem->setApplicationUserId($this->session->get('EMPID'));
                            $projItem->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($projItem);
                            $this->em->flush($projItem);
                        }
                    }
                }else{
                    if($srvSelectFlag=='1'){
                        $totalBudget+=$serviceQtys*$servicePrices;
                        $service=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->find($serviceIds);
                        $projItem=new ProjectItemTxn();
                        $projItem->setProjectFk($project);
                        $projItem->setServiceFk($service);
                        $projItem->setUnit($serviceUnits);
                        $projItem->setUnitPrice($servicePrices);
                        $projItem->setQuantity($serviceQtys);
                        $projItem->setIsBilled(0);
                        $projItem->setRecordActiveFlag(1);
                        $projItem->setRecordInsertDate(new \DateTime("NOW"));
                        $projItem->setApplicationUserId($this->session->get('EMPID'));
                        $projItem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($projItem);
                        $this->em->flush($projItem);
                    }
                }
            }
            //update project
            $project->setTotalEstimatedCost($totalBudget+$prevBudget);
            $project->setRecordUpdateDate(new \DateTime("Now"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($project);
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Product and related service has been added successfully.';            
        } catch (Exception $ex) {
            $conn->commit();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg,'project'=>$project);
    }    
    public function AddProjectNewItem($request){        
        //$dataUI=json_decode($request->getContent());
        $dataUI=  json_decode($request->getContent());
        $projid=$dataUI->inputProjId;
        $itemIds=$dataUI->txtItemId;
        $prices=$dataUI->price;
        $quantities=$dataUI->txtQuantity;
        $units=$dataUI->selItemUnits;
        $isItemSelected=$dataUI->txtIsSelected;
        $charges=$dataUI->txtCharge;       
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            // PROJECT ITEMS
            if(is_array($itemIds)){
                for($i=0;$i<count($itemIds);$i++){
                    if($isItemSelected[$i]){
                        $item=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($itemIds[$i]);    
                        $unit=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($units[$i]);
                        $projItem=new ProjectItemTxn();
                        $projItem->setProjectFk($project);
                        $projItem->setItemFk($item);
                        $projItem->setUnitFk($unit);
                        $projItem->setUnitPrice($prices[$i]);
                        $projItem->setQuantity($quantities[$i]);
                        $projItem->setCharge($charges[$i]);    
                        $projItem->setIsBilled(0);
                        $projItem->setRecordActiveFlag(1);
                        $projItem->setRecordInsertDate(new \DateTime("NOW"));
                        $projItem->setApplicationUserId($this->session->get('EMPID'));
                        $projItem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->Persist($projItem);
                        $this->em->flush();                        
                    }
                }
            }else{
                if($isItemSelected){
                        $item=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($itemIds); 
                        $unit=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($units);
                        $projItem=new ProjectItemTxn();
                        $projItem->setProjectFk($project);
                        $projItem->setItemFk($item);
                        $projItem->setUnitFk($unit);
                        $projItem->setUnitPrice($prices);
                        $projItem->setQuantity($quantities);
                        $projItem->setCharge($charges);  
                        $projItem->setIsBilled(0);
                        $projItem->setRecordActiveFlag(1);
                        $projItem->setRecordInsertDate(new \DateTime("NOW"));
                        $projItem->setApplicationUserId($this->session->get('EMPID'));
                        $projItem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->Persist($projItem);
                        $this->em->flush();                        
                    }
            }
            $conn->commit();
            $returnCode=1;            
            $returnmsg='Item has been successfully added to the Project';
            
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }    
    function UpdateProject($request,$projid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            $sDate=$dataUI->txtStartDate;
            $eDate=$dataUI->txtEndDate;
            $desc=$dataUI->txtDesc;
            $industryid=$dataUI->selIndType;
            $opportunityid=$dataUI->selOpportunity;
            $dimension=$dataUI->txtdimension;
            $remark=$dataUI->txtRemark;
            $conn->beginTransaction();
            
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $industry=$this->em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->find($industryid);
            $opportunity=$this->em->getRepository(CommonConstant::ENT_OPPORTUNITY_TYPE_MASTER)->find($opportunityid);
            
            $project->setIndustryTypeFk($industry);
            $project->setOpportunityFk($opportunity);
            $project->setDimension($dimension);
            $project->setStartDate(new \DateTime($sDate));
            $project->setExpectedCompletionDate(new \DateTime($eDate));
            $project->setDescription($desc);
            $project->setRecordUpdateDate(new \DateTime("NOW"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($project);
            //INSERT INTO PROJECT MODIFICATION LOG
            $pmlog=new ProjectModificationLog();
            $employee=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employeeId'=>$this->session->get('EMPID')));
            if($employee){
                $employee=$employee[0];
            }
            $pmlog->setProjectFk($project);
            if($this->session->get('PRIVILEGE')!='Su'){
            $pmlog->setModifiedByFk($employee);
            }
            $pmlog->setModifyDate(new \DateTime("NOW"));
            $pmlog->setRemark($remark);
            $pmlog->setRecordActiveFlag(1);
            $pmlog->setRecordInsertDate(new \DateTime("NOW"));
            $pmlog->setApplicationUserId($this->session->get('EMPID'));
            $pmlog->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($pmlog);
            $this->em->flush($pmlog);
            $conn->commit();
            $returnCode=1;            
            $returnmsg='Project Detail has been updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function UpdateProjectRef($request,$projid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            $refname=$dataUI->txtRefName;
            $refno=$dataUI->txtRefContact;
            $about=$dataUI->txtAboutRef;
            $conn->beginTransaction();
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $project->setReferrerName($refname);
            $project->setReferrerNumber($refno);
            $project->setReferrerAbout($about);
            $project->setRecordUpdateDate(new \DateTime("NOW"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($project);
            $conn->commit();
            $returnCode=1;            
            $returnmsg='Project Referrer Detail has been updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function ChangeProjectCoordinator($request,$projid){
        $dataUI=  json_decode($request->getContent());
        $coordinatorid=$dataUI->selCoordinator;        
        
        try{
           $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $employee=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($coordinatorid);
        
            $project->setsiteCoordinator($employee);
            $project->setRecordUpdateDate(new \DateTime("NOW"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($project);
            $returnCode=1;            
            $returnmsg='Project Coordinator has been changed successfully.';
        } catch (Exception $ex) {
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function AddItemDetail($request){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            //$projid=$dataUI->inputProjectId;
            $itemid=$dataUI->inputItemId;            
            $workstatusid=$dataUI->selItemStatus;
            $prodStatusid=$dataUI->selProdStatus;
            $sDate=$dataUI->txtStartDate;
            $eDate=$dataUI->txtDeadline;
            $teamno=$dataUI->txtTeamno;
            $area=$dataUI->txtArea;
            $instruction=$dataUI->txtInstruction;
            if(isset($dataUI->inputEmpId)){
                $workerIds=$dataUI->inputEmpId;
            }else{
                $workerIds='';
            
            }
            $conn->beginTransaction();
            
            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $workstatus = $this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->find($workstatusid);
            $prodStatus = $this->em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->find($prodStatusid);
            
            //update item detail
            $item->setStatusFk($workstatus);
            $item->setProductStatusFk($prodStatus);
            $item->setStartDate(new \DateTime($sDate));
            $item->setExpectedEndDate(new \DateTime($eDate));
            $item->setTeamNo($teamno);
            $item->setAreaDetail($area);
            $item->setSpecialInstruction($instruction);
            $item->setIsStarted(1);
            $item->setRecordUpdateDate(new \DateTime("NOW"));
            $item->setApplicationUserId($this->session->get('EMPID'));
            $item->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();         
            
            //insert workers            
            if(is_array($workerIds)){
                foreach($workerIds as $workerid){
                    if($workerid!=''){
                        $worker=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($workerid);
                        $itemworker=new ProjectItemWorkerTxn();
                        $itemworker->setProjectItemFk($item);
                        $itemworker->setWorkerFk($worker);
                        $itemworker->setRecordActiveFlag(1);
                        $itemworker->setRecordInsertDate(new \DateTime("NOW"));
                        $itemworker->setApplicationUserId($this->session->get('EMPID'));
                        $itemworker->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($itemworker);
                        $this->em->flush();
                    }
                }
            }else{
                if($workerIds!=''){
                    $worker=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($workerIds);
                    $itemworker=new ProjectItemWorkerTxn();
                    $itemworker->setProjectItemFk($item);
                    $itemworker->setWorkerFk($worker);
                    $itemworker->setRecordActiveFlag(1);
                    $itemworker->setRecordInsertDate(new \DateTime("NOW"));
                    $itemworker->setApplicationUserId($this->session->get('EMPID'));
                    $itemworker->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($itemworker);
                    $this->em->flush();
                }
            }
            $conn->commit();
            $returnCode=1;            
            $returnmsg='Item detail has been saved successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function UpdateItemStatus($request,$itemid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            $statusid=$dataUI->selItemStatus;
            $sdate=$dataUI->txtstatusDate;
            $remarks=$dataUI->txtRemarks;            
            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            if($item->getStatusFk()->getPkid()==$statusid){
               return array('code'=>0,'msg'=>'Item is already in \''.$item->getStatusFk()->getStatusName().'\' status');
            }
            $conn->beginTransaction();
            $status=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->find($statusid);
            
            //UPDATE STATUS IN PROJECT ITEM TXN
            $item->setStatusFk($status);
            $item->setRecordUpdateDate(new \DateTime("NOW"));
            $item->setApplicationUserId($this->session->get('EMPID'));
            $item->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($item);
            //INSERT IN ITEM STATUS TXN
            $itemstatus=new ProjectItemStatusTxn();
            $itemstatus->setItemFk($item);
            $itemstatus->setStatusFk($status);
            $itemstatus->setStatusDate(new \DateTime($sdate));
            $itemstatus->setRemarks($remarks);
            $itemstatus->setRecordActiveFlag(1);
            $itemstatus->setRecordInsertDate(new \DateTime("NOW"));
            $itemstatus->setApplicationUserId($this->session->get('EMPID'));
            $itemstatus->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($itemstatus);
            $this->em->flush($itemstatus);
            $conn->commit();
            $returnCode=1;
            $returnmsg='Status updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function UpdateProductStatus($request,$itemid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            $statusid=$dataUI->selProdStatus;
            $sdate=$dataUI->txtstatusDate;
            $remarks=$dataUI->txtRemarks;            
            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            if($item->getProductStatusFk()->getPkid()==$statusid){
               return array('code'=>0,'msg'=>'Item is already in \''.$item->getProductStatusFk()->getStatusName().'\' status');
            }
            $conn->beginTransaction();
            $status=$this->em->getRepository(CommonConstant::ENT_PROJ_PROD_STATUS_MASTER)->find($statusid);
            
            //UPDATE STATUS IN PROJECT ITEM TXN
            $item->setProductStatusFk($status);
            $item->setRecordUpdateDate(new \DateTime("NOW"));
            $item->setApplicationUserId($this->session->get('EMPID'));
            $item->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($item);
            //INSERT IN ITEM STATUS TXN
            $prodstatus=new ProjectProductStatusTxn();
            $prodstatus->setItemFk($item);
            $prodstatus->setStatusFk($status);
            $prodstatus->setStatusDate(new \DateTime($sdate));
            $prodstatus->setRemarks($remarks);
            $prodstatus->setRecordActiveFlag(1);
            $prodstatus->setRecordInsertDate(new \DateTime("NOW"));
            $prodstatus->setApplicationUserId($this->session->get('EMPID'));
            $prodstatus->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($prodstatus);
            $this->em->flush($prodstatus);
            $conn->commit();
            $returnCode=1;
            $returnmsg='Product Status updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function AddNewAdvancePayment($request,$projid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{            
            $paymodeid=explode('&',$dataUI->selpayMode)[0];
            $paydate=$dataUI->txtPayDate;
            $payno='';
            $bankname='';
            if(isset($dataUI->txtTranNo)){
                $payno=$dataUI->txtTranNo;
            }
            if(isset($dataUI->txtBankName)){
                $bankname=$dataUI->txtBankName;
            }
            $payremarks=$dataUI->txtremarks;
            $payamount=$dataUI->txtAmount;    
            $conn->beginTransaction();
            
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $currBalance=$project->getBalanceAmount();        
            $alertpc=$dataUI->txtalertpc;
            $limitamt=$payamount-$payamount*($alertpc/100);
            $balance= floatval($currBalance)+floatval($payamount);
            $project->setBalanceAmount($balance);
            $project->setamtLimit($limitamt);
            $this->em->flush();
            
            $paymode=$this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($paymodeid);
            
            $advance=new ProjectAdvancePayment();
            $advance->setProjectFk($project);
            $advance->setPaymentModeFk($paymode);
            $advance->setAmount($payamount);
            $advance->setAlertPc($alertpc);
            $advance->setPaymentDate(new \DateTime($paydate));
            $advance->setPaymentNo($payno);
            $advance->setBankName($bankname);
            $advance->setRemarks($payremarks);
            $advance->setRecordActiveFlag(1);
            $advance->setRecordInsertDate(new \DateTime("NOW"));
            $advance->setApplicationUserId($this->session->get('EMPID'));
            $advance->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->Persist($advance);
            $this->em->flush();

            $projWallet=new ProjectWallet();
            $projWallet->setProjectFk($project);
            $projWallet->setTransactionDate(new \DateTime($paydate));
            $projWallet->setPayMode($paymode);
            $projWallet->setPaymentNo($payno);                
            $projWallet->setParticulars("Advance Payment");
            $projWallet->setAmount($payamount);
            $projWallet->setBalance($balance);
            $projWallet->setRemarks($payremarks);
            $projWallet->setDrCr('Cr');
            $projWallet->setApprovalFlag(0);
            $projWallet->setRecordActiveFlag(1);
            $projWallet->setRecordInsertDate(new \DateTime("NOW"));
            $projWallet->setApplicationUserId($this->session->get('EMPID'));
            $projWallet->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($projWallet);
            $this->em->flush();
            $conn->commit();
            $returnCode=1;
            $returnmsg='Advance Payment detail has been added and Project balance has been updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    public function UploadProjectDocument($request,$projid){
        $dataUI=$request->request;
        $title=$dataUI->get('txtDocTitle');
        $desc=$dataUI->get('txtDocDesc');
        $fileupload=$request->files->get('fileProjDoc');
        $uploadedFiles='';
       // $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
        $validFileTypes=array('');
        $conn=$this->em->getConnection();
        try{            
            if(isset($fileupload)){
                $conn->beginTransaction();
                $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
                $custName=$project->getCustomerFk()->getCustomerName();
                $orderno=$project->getOrderNo();
                $path='upload/PROJECT/'.strtoupper($custName).'/'.strtoupper($orderno).'/RELATED DOCUMENTS/';
                $fileupResult=$this->commonService->UploadFile($fileupload,$path,0,$validFileTypes);
                if($fileupResult['code']==1){
                    $uploadedFiles[]=$fileupResult['fullpath'];                            
                    //save image in document master
                    $document=new CmnDocumentMaster();
                    $document->setPath($path.$fileupResult['newname']);
                    $document->setOriginalName($fileupResult['oriname']);
                    $document->setSystemName($fileupResult['newname']);
                    $document->setDocType($fileupResult['ext']);
                    $document->setRecordActiveFlag(1);
                    $document->setRecordInsertDate(new \DateTime("NOW"));
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($document);
                    $this->em->flush();

                    //INSERT INTO PROJECT DOCUMENT TXN
                    $doctxn=new ProjectDocumentTxn();
                    $doctxn->setProjectFk($project);
                    $doctxn->setDocumentFk($document);
                    $doctxn->setTitle($title);
                    $doctxn->setDescription($desc);
                    $doctxn->setAddDate(new \DateTime("NOW"));
                    $doctxn->setRecordActiveFlag(1);
                    $doctxn->setRecordInsertDate(new \DateTime("NOW"));
                    $doctxn->setApplicationUserId($this->session->get('EMPID'));
                    $doctxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($doctxn);
                    $this->em->flush();
                    $conn->commit();
                    $returnmsg='Document has been uploaded successfully';
                    $returnCode=1;
                }else{
                    $returnmsg=$fileupResult['msg'];
                    $returnCode=0;
                }
            }else{
                $returnmsg='Either you have not selected any document or the document is too large to handle.';
                $returnCode=0;
            }
        }catch (Exception $ex) {
            $conn->rollBack();
            foreach($uploadedFiles as $file){
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function UpdateProjectDocument($request,$docid){
        $dataUI=$request->request;
        $title=$dataUI->get('txtDocTitle');
        $desc=$dataUI->get('txtDocDesc');
        $fileupload=$request->files->get('fileProjDoc');
        $uploadedFiles='';
        $projid='';
       // $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
        $validFileTypes=array('');
        $conn=$this->em->getConnection();

        try{
            $conn->beginTransaction();  
            $doctxn=$this->em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->find($docid);
            $project=$doctxn->getProjectFk();
            if(isset($fileupload)){
                              
                $custName=$project->getCustomerFk()->getCustomerName();
                $orderno=$project->getOrderNo();
                $previousFile=$this->webRoot.'web/'.$doctxn->getDocumentFk()->getPath();
                $path='upload/PROJECT/'.strtoupper($custName).'/'.strtoupper($orderno).'/RELATED DOCUMENTS/';
                $fileupResult=$this->commonService->UploadFile($fileupload,$path,0,$validFileTypes);
                if($fileupResult['code']==1){
                    $uploadedFiles[]=$fileupResult['fullpath'];                            
                    //save image in document master           
                    $document=$doctxn->getDocumentFk();
                    $document->setPath($path.$fileupResult['newname']);
                    $document->setOriginalName($fileupResult['oriname']);
                    $document->setSystemName($fileupResult['newname']);
                    $document->setDocType($fileupResult['ext']);          
                    $document->setRecordUpdateDate(new \DateTime("NOW"));
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush();  
                }else{
                    $returnmsg=$fileupResult['msg'];
                    $returnCode=0;
                }
            }
            //UPDATE INTO PROJECT DOCUMENT TXN
           // $doctxn=new ProjectDocumentTxn();
            $doctxn->setProjectFk($project);
            if(isset($fileupload)){ //if new file is not selected then the document master won't be updated and no need to update in Project_Document_Txn
                $doctxn->setDocumentFk($document);
            }
            $doctxn->setTitle($title);
            $doctxn->setDescription($desc);
            $doctxn->setAddDate(new \DateTime("NOW"));
            $doctxn->setRecordActiveFlag(1);
            $doctxn->setRecordInsertDate(new \DateTime("NOW"));
            $doctxn->setApplicationUserId($this->session->get('EMPID'));
            $doctxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit();
            if(isset($fileupload) && file_exists($previousFile)){
                unlink($previousFile);
            }
            $projid=$project->getPkid();
            $returnmsg='Document detail has been updated successfully';
            $returnCode=1;
        }catch (Exception $ex) {
            $conn->rollBack();
            foreach($uploadedFiles as $file){
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg,'projid'=>$projid);
    }
    function DeleteProjectDocument($docid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $doctxn=$this->em->getRepository(CommonConstant::ENT_PROJ_DOCUMENT)->find($docid);
            $document=$doctxn->getDocumentFk();
            $filepath=$document->getPath();            
            //delete Document Master
            $document->setRecordActiveFlag(0);
            $document->setRecordUpdateDate(new \DateTime("NOW"));
            $document->setApplicationUserId($this->session->get('EMPID'));
            $document->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //Delete Project Document Txn
            $doctxn->setRecordActiveFlag(0);
            $doctxn->setRecordUpdateDate(new \DateTime("NOW"));
            $doctxn->setApplicationUserId($this->session->get('EMPID'));
            $doctxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            if(file_exists($filepath)){
                unlink($this->webRoot.'web/'. $filepath);
            }
            $conn->commit();
            $returnCode=1;
            $returnmsg='Document has been deleted successfully';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    public function InsertDailyReport($request){
        $dataUI=$request->request;
        $conn=$this->em->getConnection();
        try{
            $itemid=$dataUI->get('inputItemId');
            $statusid=$dataUI->get('selWorkStatus');
            $rptdate=$dataUI->get('txtRptDate');
            $rptDetail=$dataUI->get('txtRptdetail');
            $fileUpload=$request->files;
            
            $conn->beginTransaction();
            
            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $status=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_STATUS_MASTER)->find($statusid);
            
            //update item status
            $item->setStatusFk($status);
            $item->setRecordUpdateDate(new \DateTime("NOW"));
            $item->setApplicationUserId($this->session->get('EMPID'));
            $item->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
           
            //file upload
            $custname=strtoupper($item->getProjectFk()->getCustomerFk()->getCustomerName());
            $projname=strtoupper($item->getProjectFk()->getAreaFk()->getArea());
            $itemname=strtoupper($item->getItemFk()->getProductName());            
            foreach($fileUpload as $file){
                if ($_FILES['fileWorkImg']['size'] != 0) {
                    $fullpath=$request->files->get('fileWorkImg')->getClientOriginalName();
                    $fextension=  pathinfo($fullpath, PATHINFO_EXTENSION);
                    $orifname=  pathinfo($fullpath, PATHINFO_FILENAME);
                    //list($firstpart,$ext)=  explode('.', $orifname);
                    $currdateTime=(new \DateTime("NOW"))->format('YmdHis').  rand(1, 10);
                    $newfname=$currdateTime.'_RPT.'.$fextension;
                    $dynamicPath='upload/Documents/PROJECT/'.$custname.'/'.$projname.'/DAILYREPORT/'.$itemname.'/';
                    $folderPath=  $this->webRoot.'web/'.$dynamicPath;
                    $filepath='';
                    $dirStatus=false;
                    if(is_dir($folderPath)){
                        $dirStatus=true;
                    }
                    else{
                        $dirStatus=mkdir($folderPath,0777,true);
                    }
                    if($dirStatus){                        
                        $filepath=$folderPath.'/'.$newfname;
                        if (!is_dir($filepath) && !file_exists($filepath)) {
                            $path=$file->move($folderPath,$newfname);  
                            //Insert Document in Common Document Master Table
                            $document=new CmnDocumentMaster();
                            $document->setOriginalName($orifname);
                            $document->setSystemName($newfname);
                            $document->setPath($dynamicPath);
                            $document->setDocType($fextension);
                            $document->setRecordActiveFlag(1);
                            $document->setRecordInsertDate(new \DateTime("NOW"));
                            $document->setApplicationUserId($this->session->get('EMPID'));
                            $document->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($document);
                            $this->em->flush();

                            //Insert Daily Report
                            $report=new ProjectDailyReport();
                            $report->setProjectItemFk($item);
                            $report->setStatusFk($status);
                            $report->setDocumentFk($document);
                            $report->setReport($rptDetail);
                            $report->setReportDate(new \DateTime($rptdate));
                            $report->setRecordActiveFlag(1);
                            $report->setRecordInsertDate(new \DateTime("NOW"));
                            $report->setApplicationUserId($this->session->get('EMPID'));
                            $report->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($report);
                            $this->em->flush();                            
                        }
                    }else{
                        $returnCode=0;
                        $returnmsg='Something went wrong while uploading the image.Please try later.';
                        return array('code'=>$returnCode,'msg'=>$returnmsg); 
                    }
                }
                else{
                    //Insert Daily Report
                    $report=new ProjectDailyReport();
                    $report->setProjectItemFk($item);
                    $report->setStatusFk($status);
                    //$report->setDocumentFk($document);
                    $report->setReport($rptDetail);
                    $report->setReportDate(new \DateTime($rptdate));
                    $report->setRecordActiveFlag(1);
                    $report->setRecordInsertDate(new \DateTime("NOW"));
                    $report->setApplicationUserId($this->session->get('EMPID'));
                    $report->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($report);
                    $this->em->flush();
                }
            }            
            $conn->commit();
            $returnCode=1;
            $returnmsg='Report has been uploaded successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);        
    }
    public function UpdateProjectStatus($request,$projid){
        $conn=$this->em->getConnection();
        try{
            $dataUI=  json_decode($request->getContent());
            $statusid=$dataUI->selProjectStatus;
            $sdate=$dataUI->txtstatusDate;
            $remarks=$dataUI->txtRemarks;
            
            $conn->beginTransaction();
            $status=$this->em->getRepository(CommonConstant::ENT_PROJ_STATUS_MASTER)->find($statusid);
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            
            //Update Project Status Master
            $project->setStatus($status);
            $project->setRecordInsertDate(new \DateTime("NOW"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush(); 
            
            //INSERT PRODUCT STATUS TXN
            $statustxn=new ProjectStatusTxn();
            $statustxn->setProjectFk($project);
            $statustxn->setStatusFk($status);
            $statustxn->setStatusDate(new \DateTime($sdate));
            $statustxn->setRemarks($remarks);
            $statustxn->setRecordActiveFlag(1);
            $statustxn->setRecordInsertDate(new \DateTime("NOW"));
            $statustxn->setApplicationUserId($this->session->get('EMPID'));
            $statustxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($statustxn);
            $this->em->flush($statustxn);       
            
            $conn->commit();
            $returnCode=1;
            $returnmsg='Project Status has been updated successfully.';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    function EditItemDetail($request,$itemid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            //$projid=$dataUI->inputProjectId;
            $sDate=$dataUI->txtStartDate;
            $eDate=$dataUI->txtDeadline;
            $teamno=$dataUI->txtTeamno;
            $area=$dataUI->txtArea;
            $instruction=$dataUI->txtInstruction;
            $quantity=$dataUI->txtQty;
            $unitprice=$dataUI->txtPrice;
            $unit=$dataUI->selItemUnit;
           // $charge=$dataUI->txtCharge;
            $subtotal=$dataUI->txtTotal;
            $workerIds=$dataUI->inputEmpId;
            $conn->beginTransaction();
            
            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemid);
            $project=$item->getProjectFk();
            $existingItems=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->findBy(array('projectFk'=>$project,'recordActiveFlag'=>1));
            $custName=$project->getCustomerFk()->getCustomerName();
            $orderno=$project->getOrderNo();      

            $existingTotal=0;
            if($existingItems){
                foreach($existingItems as $eitem){ //finding current project budget excluding currently updating item
                    if($eitem->getPkid()!=$itemid){
                        $qty=$eitem->getQuantity();
                        $eprice=$eitem->getUnitPrice();
                        //$echarge=$eitem->getCharge();
                        $existingTotal+=$qty*$eprice;
                    }
                }
            }
            $newbudget=$existingTotal+$subtotal;
            //update item detail
            //$unit=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unitid);
            $item->setStartDate(new \DateTime($sDate));
            $item->setExpectedEndDate(new \DateTime($eDate));            
            $item->setUnit($unit);
            $item->setQuantity($quantity);
            //$item->setCharge($charge);
            $item->setTeamNo($teamno);
            $item->setAreaDetail($area);
            $item->setSpecialInstruction($instruction);
            $item->setRecordUpdateDate(new \DateTime("NOW"));
            $item->setApplicationUserId($this->session->get('EMPID'));
            $item->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($item);         
            
            //update project estimated cost            
            $project->setTotalEstimatedCost($newbudget);
            $project->setRecordUpdateDate(new \DateTime("NOW"));
            $project->setApplicationUserId($this->session->get('EMPID'));
            $project->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($project); 
            
            //change worker 
            $workers=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_WORKER_TXN)->findBy(array('projectItemFk'=>$itemid));
            //reset recordactiveflag of all existing worker to 0
            foreach($workers as $worker){                   
                    $worker->setRecordActiveFlag(0);
                    $worker->setRecordUpdateDate(new \DateTime("NOW"));
                    $worker->setApplicationUserId($this->session->get('EMPID'));
                    $worker->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($worker);
            }
            if(is_array($workerIds)){
                foreach($workerIds as $workerid){
                    if($workerid!=''){
                        $itemworker=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_WORKER_TXN)->findOneBy(array('workerFk'=>$workerid,'projectItemFk'=>$itemid));
                        if($itemworker){
                            $itemworker->setRecordActiveFlag(1);
                            $itemworker->setRecordUpdateDate(new \DateTime("NOW"));
                            $itemworker->setApplicationUserId($this->session->get('EMPID'));
                            $itemworker->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->flush($itemworker);
                        }else{
                            $worker=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($workerid);
                            $itemworker=new ProjectItemWorkerTxn();
                            $itemworker->setProjectItemFk($item);
                            $itemworker->setWorkerFk($worker);
                            $itemworker->setRecordActiveFlag(1);
                            $itemworker->setRecordInsertDate(new \DateTime("NOW"));
                            $itemworker->setApplicationUserId($this->session->get('EMPID'));
                            $itemworker->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($itemworker);
                            $this->em->flush();
                        } 
                    }
                }
            }
            else{
                if($workerIds!=''){
                        $itemworker=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_WORKER_TXN)->findOneBy(array('workerFk'=>$workerIds,'projectItemFk'=>$itemid));
                        if($itemworker){
                            $itemworker->setRecordActiveFlag(1);
                            $itemworker->setRecordUpdateDate(new \DateTime("NOW"));
                            $itemworker->setApplicationUserId($this->session->get('EMPID'));
                            $itemworker->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->flush($itemworker);
                        }else{
                            $worker=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($workerIds);
                            $itemworker=new ProjectItemWorkerTxn();
                            $itemworker->setProjectItemFk($item);
                            $itemworker->setWorkerFk($worker);
                            $itemworker->setRecordActiveFlag(1);
                            $itemworker->setRecordInsertDate(new \DateTime("NOW"));
                            $itemworker->setApplicationUserId($this->session->get('EMPID'));
                            $itemworker->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($itemworker);
                            $this->em->flush();
                        } 
                    }
            }
            //Change Image
            
            $conn->commit();
            $returnCode=1;            
            $returnmsg='Item detail has been updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returnCode,'msg'=>$returnmsg);
    }
    public function AddNewItemService($request){
        $dataUI=  json_decode($request->getContent());
        $projid=$dataUI->inputprojectid;
        $serviceid=$dataUI->selServicelist;
        $desc=$dataUI->txtDesc;
        $unit=$dataUI->txtUnit;
        $charge=$dataUI->txtCharge;
        $qty=$dataUI->txtQty;
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            $service=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->find($serviceid);
            
            //INSERT INTO PROJECT_ITEM_TXN
            $itemsrv=new ProjectItemTxn();
            $itemsrv->setProjectFk($project);
            $itemsrv->setServiceFk($service);
            $itemsrv->setServiceDescription($desc);
            $itemsrv->setUnit($unit);
            $itemsrv->setUnitPrice($charge);
            $itemsrv->setQuantity($qty);
            $itemsrv->setIsBilled(0);
            $itemsrv->setRecordActiveFlag(1);
            $itemsrv->setRecordInsertDate(new \DateTime("NOW"));
            $itemsrv->setApplicationUserId($this->session->get('EMPID'));
            $itemsrv->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($itemsrv);
            $this->em->flush($itemsrv);           
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Service has been successfully added';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function EditItemService($request){
        $dataUI=  json_decode($request->getContent());
        $projid=$dataUI->inputprojectid;
        $serviceid=$dataUI->inputServicepkid;
        $desc=$dataUI->txtDesc;
        $unit=$dataUI->txtUnit;
        $charge=$dataUI->txtCharge;
        $qty=$dataUI->txtQty;
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            
            //INSERT INTO PROJECT_ITEM_TXN
            $itemsrv=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($serviceid);
            $itemsrv->setServiceDescription($desc);
            $itemsrv->setUnit($unit);
            $itemsrv->setUnitPrice($charge);
            $itemsrv->setQuantity($qty);
            $itemsrv->setRecordUpdateDate(new \DateTime("NOW"));
            $itemsrv->setApplicationUserId($this->session->get('EMPID'));
            $itemsrv->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($itemsrv);           
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Service detail has been updated successfully.';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function DeleteItemService($serviceid){        
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();            
            $itemsrv=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($serviceid);
            $itemsrv->setRecordActiveFlag(0);
            $itemsrv->setRecordUpdateDate(new \DateTime("NOW"));
            $itemsrv->setApplicationUserId($this->session->get('EMPID'));
            $itemsrv->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($itemsrv);           
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Service detail has been deleted successfully.';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function AddAdditionalService($request){
        $dataUI=  json_decode($request->getContent());
        $projid=$dataUI->inputprojectid;
        $servicename=$dataUI->txtServiceName;
        $desc=$dataUI->txtDesc;
        $unit=$dataUI->txtUnit;
        $charge=$dataUI->txtCharge;
        $qty=$dataUI->txtQty;
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);
            
            //INSERT INTO PROJECT_ITEM_TXN
            $itemsrv=new ProjectItemTxn();
            $itemsrv->setProjectFk($project);
            $itemsrv->setItemName($servicename);
            $itemsrv->setServiceDescription($desc);
            $itemsrv->setUnit($unit);
            $itemsrv->setUnitPrice($charge);
            $itemsrv->setQuantity($qty);
            $itemsrv->setIsBilled(0);
            $itemsrv->setRecordActiveFlag(1);
            $itemsrv->setRecordInsertDate(new \DateTime("NOW"));
            $itemsrv->setApplicationUserId($this->session->get('EMPID'));
            $itemsrv->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($itemsrv);
            $this->em->flush($itemsrv);           
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Service has been successfully added';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function EditAdditionalService($request){
        $dataUI=  json_decode($request->getContent());
        $serviceid=$dataUI->serviceid;
        $servicename=$dataUI->txtServiceName;
        $desc=$dataUI->txtDesc;
        $unit=$dataUI->txtUnit;
        $charge=$dataUI->txtCharge;
        $qty=$dataUI->txtQty;
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            
            //UPDATE INTO PROJECT_ITEM_TXN
            $itemsrv=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($serviceid);
            $itemsrv->setItemName($servicename);
            $itemsrv->setServiceDescription($desc);
            $itemsrv->setUnit($unit);
            $itemsrv->setUnitPrice($charge);
            $itemsrv->setQuantity($qty);
            $itemsrv->setRecordUpdateDate(new \DateTime("NOW"));
            $itemsrv->setApplicationUserId($this->session->get('EMPID'));
            $itemsrv->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($itemsrv);           
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Service detail has been updatead successfully.';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function DeleteAdditionalService($serviceid){        
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();            
            $itemsrv=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($serviceid);
            $itemsrv->setRecordActiveFlag(0);
            $itemsrv->setRecordUpdateDate(new \DateTime("NOW"));
            $itemsrv->setApplicationUserId($this->session->get('EMPID'));
            $itemsrv->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($itemsrv);           
            
            $conn->commit();
            $returncode=1;
            $returnmsg='Service detail has been deleted successfully.';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=1;
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function SendMail($msg,$subject,$recipient,$attachArr){
        try{
            $uploadedFileArr=array();            
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('itsupport@tashiinteriors.com','TASHI-INTERIOR')
                ->setTo($recipient)
                ->setBody($msg, 'text/html');
            if($attachArr){
                foreach($attachArr as $attachment){
                    $path='upload/COMMUNICATION/ATTACHMENT/';
                    $fuploadresult=$this->cmnservice->UploadFileWithOriginalName($attachment,$path,25,'');
                    if($fuploadresult['code']==1){
                        $uploadedFile=$fuploadresult['fullpath'];               
                        $message->attach(\Swift_Attachment::fromPath($uploadedFile));
                        array_push($uploadedFileArr,$uploadedFile);
                    }else{                            
                        return array('code'=>0,'msg'=>$fuploadresult['msg'],'files'=>$uploadedFileArr);                        
                    }
                }
            }

            if($this->mailer->send($message)==1){                
                return array('code'=>1,'msg'=> 'Email sent successfully','files'=>$uploadedFileArr);
            }else{
                return array('code'=>0,'msg'=>  CommonConstant::ERR_EMAIL_SENDING,'files'=>$uploadedFileArr);
            }
        }
        catch(\Swift_TransportException $se){
            return array('code'=>0,'msg'=>  $this->cmnservice->CommonError($se,'email'));
        }
        catch (\Exception $ex){
            return array('code'=>0,'msg'=>  $this->cmnservice->CommonError($ex,'email'));
        }        
    }
}


