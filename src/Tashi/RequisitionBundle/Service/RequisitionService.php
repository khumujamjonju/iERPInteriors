<?php
namespace Tashi\RequisitionBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\RequisitionBundle\Helper\RequisitionConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\RequisitionMaster;
use Tashi\CommonBundle\Entity\RequisitionStatusTxn;
use Tashi\CommonBundle\Entity\RequisitionProductDetails;
use Tashi\CommonBundle\Entity\RequisitionProductDetailsHistory;
use Tashi\CommonBundle\Entity\StockReturn;
use Tashi\CommonBundle\Entity\StockReturnPurpose;
 

class RequisitionService {
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
    
    
    //------------------------------searching record for requisition-------------------------------------
    
    public function displayAllResult($tbl_name) {
        try {
            return $this->commonService->activeList($tbl_name);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    
    
     public function SearchAllRequisiton()
    {
        
        try
         {
          $details = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->findRequisitionAll();
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('allresult'=>$details,'msg'=>'Record found');
        
    }
    
    
    
    
     public function getRequisitionProductUnit($request)
    {
        try
         {
         $dataUI = json_decode($request->getContent());
         $id = $dataUI->rid;
         $details = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findRequisitionProduct($id);
//          echo $details[0]->getPkid();
//            die();
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('result'=>$details);
           
    }
    
     public function getAllRequisitionDetails($POCode)
    {
        
        try
         {
         
          $details1 = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
          $details2 = $this->em->getRepository(PurchaseConstant::ENT_POStatus_txn)->findOneByPoFk($POCode);
          $details3 = $this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
          //$details4 = $this->em->getRepository(PurchaseConstant::ENT_POProduct)->findByPoFk($POCode);
         
//          echo $proid=$details4[0]->getProductFk()->getPkid();
//          die();
          
          $potransport= $details1->getTransporterFk()->getPkid();
          $transmode= $details1->getTransportModeFk()->getPkid();
          $status=$details2->getStatusFk()->getPkid();
          $paymode=$details3->getPaymentModeFk()->getPkid();
          $cost=$details1->getTransportCost();
          $Emp=$details1->getPoFk()->getEmployeeFk()->getEmployeePk();
          $amount=$details3->getAmount();
        
          
          
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('msg'=>'Record found','t'=>$potransport,'tm'=>$transmode,'st'=>$status,'pay'=>$paymode,'cost'=>$cost,'eid'=>$Emp,'rs'=>$amount);
        
    }
    
     public function SearchByRequisitionDate($request)
    {
        
        try
         {
          $dataUI=json_decode($request->getContent());
          $sdate=$dataUI->txtfrom;
          $endate=$dataUI->todate;
            
          $details = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->findbyRequisitionDate($sdate,$endate);
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('allresult'=>$details,'msg'=>'Record found');
        
    }
    
    
     public function SearchResultByStatus($request)
    {
        try
         {
          $dataUI=json_decode($request->getContent());
          $statusid=$dataUI->selPurStatus;
          $details = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->findResultbyStatus($statusid);
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('allresult'=>$details,'msg'=>'Record found');
        
    }
    
    
    
     public function getRequisitionforApproval()
    {
        try
         {
         $podetails = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->findRequisitionforApproval();
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('result'=>$podetails);
           
    }
    
    
     public function getstockresult($reqid)
    {
        try
         {
         $stock = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findStockResult($reqid);
        // print_r($stock);
         //die();
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('result'=>$stock);
           
    } 
    
    
     public function SearchRequisitionbyReqNo($reqno)
    {
        
        try
         { 
          $details = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->findRequisitionByReqNo($reqno);
          
         }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array('result'=>$details);
        
    }
    
    
      //------------------------------inserting Requisitondetails master------------------------------
    function AddRequisitondetails($request)
   {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try 
            { 
          
            $dataUI = json_decode($request->getContent());
            
            $productid = array();
            if (is_string($dataUI->pid)) {
                $productid[0] = $dataUI->pid; //for only one               
            } else {
                $productid = $dataUI->pid;     //for more than one       
            }
            //$empid = $dataUI->selectedEMp;
            $empid = $this->session->get('EMPID');
            $reqdate = $dataUI->reqdate;
            $description = $dataUI->description;
            //setting foreign key object for supplier contact txn and supplier object
            //$EmployeeObj=$this->em->getRepository(RequisitionConstant::ENT_EMP)->find($empid);
            $EmployeeObj=$this->em->getRepository(RequisitionConstant::ENT_EMP)->findOneByEmployeeId($empid);
            //setting foreign key object for postatus master
            $ReqStatusMasterObj = $this->em->getRepository(RequisitionConstant::ENT_REQSTATUS)->find(1);
            //
            
            $RequisitionMasterObj = new RequisitionMaster();
            //----for generating requisition orderno
            $queryString = " SELECT  ro.uiReqId uiID
                             FROM TashiCommonBundle:RequisitionMaster ro  
                             where ro.pkid =( SELECT MAX(r.pkid) FROM TashiCommonBundle:RequisitionMaster r) ";
                 
            $query = $this->em->createQuery($queryString);
            $result = $query->getResult();
//                echo $result[0]['uiID'];
//                die();
                if ($result){
                    $ro = $result[0]['uiID'];
                   
                    $generate_ID= (int)substr($ro,3,strlen($ro)) + 1;
                } else {
                    $generate_ID = 1;                   
                }
                $req_ID = 'REQ00'.$generate_ID;
                
                 
                    $RequisitionMasterObj->setUiReqId($req_ID);
                    $RequisitionMasterObj->setReqstatusFk($ReqStatusMasterObj);
                    $RequisitionMasterObj->setEmployeeFk($EmployeeObj);
                    $RequisitionMasterObj->setRequisitionDetails($description);
                    $RequisitionMasterObj->setRecordActiveFlag(1);
                    $RequisitionMasterObj->setApprovalflag(0);
                    $RequisitionMasterObj->setRequisitionDate(new \Datetime($reqdate));
                    $RequisitionMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                    $RequisitionMasterObj->setApplicationUserId($this->session->get('EMPID'));
                    $RequisitionMasterObj->setApplicationUserIpAddress($this->session->get('IP'));

                    $this->em->persist($RequisitionMasterObj);
                    $this->em->flush();
            
            
//-------------------------------for inserting record into po_product_details table----------------------------------------------------
          
//               // $check=0;
                foreach($productid as $val) 
                {
                    
                $q = 'quantity'.$val;
                $u = 'unitid'.$val;
                $r = 'remarks'.$val;
                $p = 'purpose'.$val;
                $pc = 'txt_code'.$val;       
                
                
                $proid=$val;
                $quantity = $dataUI->$q;
                $remarks = $dataUI->$r;
                $unit = $dataUI->$u;
                $purpose=$dataUI->$p;
                $purposecode=$dataUI->$pc;
                if($purpose==1)
                {
                    
                    
                }
                
                switch($purpose)
                {
                    case '1':
                    $CODE = $this->em->getRepository(RequisitionConstant::ENT_BRANCHMASTER)->findOneBy(array('branchCode'=>$purposecode));
                    if($CODE)
                    {  
                        $purposecode=$dataUI->$pc;  
                        
                    }
                    else{ 
                        $returncode = 0;
                        return  array('code'=>$returncode,'msg'=>'Invalid branch code');  }
                    break;
                    case '2':
                    $CODE = $this->em->getRepository(RequisitionConstant::ENT_PROJECTMASTER)->findOneBy(array('orderNo'=>$purposecode));
                    if($CODE)
                    {  
                        $purposecode=$dataUI->$pc;  
                    }
                    else{ 
                        $returncode = 0;
                        return  array('code'=>$returncode,'msg'=>'Invalid project order no');  }
                    break;
                    case '3':
                    $CODE = $this->em->getRepository(RequisitionConstant::ENT_EMPLOYEEMASTER)->findOneBy(array('employeeId'=>$purposecode));
                    if($CODE)
                    {  
                        $purposecode=$dataUI->$pc;  
                    }
                    else{ 
                        $returncode = 0;
                        return  array('code'=>$returncode,'msg'=>'Invalid employee code');  }
                    break;
                }
                
                    
                
                $ProObj=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                $UnitObj=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);
                $PurposeObj=$this->em->getRepository(RequisitionConstant::ENT_REQ)->find($purpose);
                $RequisitionProductDetailsObj = new RequisitionProductDetails();
                $RequisitionProductDetailsObj->setRequisitionFk($RequisitionMasterObj);
                $RequisitionProductDetailsObj->setUnitFk($UnitObj);
                $RequisitionProductDetailsObj->setProductFk($ProObj);
                $RequisitionProductDetailsObj->setRemarks($remarks);
                $RequisitionProductDetailsObj->setQuantity($quantity);
                $RequisitionProductDetailsObj->setDueQuantity($quantity);
                $RequisitionProductDetailsObj->setPurposeCode($purposecode);
                $RequisitionProductDetailsObj->setPurposeFk($PurposeObj);
                $RequisitionProductDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                $RequisitionProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                $RequisitionProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                $RequisitionProductDetailsObj->setRecordActiveFlag(1);
                $RequisitionProductDetailsObj->setApprovalflag(0);
                $this->em->persist($RequisitionProductDetailsObj);
                $this->em->flush(); 
                $returncode = 1;
                 }
//-------------------------------for inserting record into requisitionstatus master txn--------------------------------------------------------
              
            $RequisitionStatusTxnObj = new RequisitionStatusTxn();
            
            $RequisitionStatusTxnObj->setStatusDate(new\Datetime('NOW'));
            $RequisitionStatusTxnObj->setRemarks('Created'); 
            $RequisitionStatusTxnObj->setRecordActiveFlag(1);
            $RequisitionStatusTxnObj->setRecordInsertDate(new \ Datetime('NOW'));
            $RequisitionStatusTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $RequisitionStatusTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $RequisitionStatusTxnObj->setRequisitionFk($RequisitionMasterObj);
            $RequisitionStatusTxnObj->setStatusFk($ReqStatusMasterObj);
            $this->em->persist($RequisitionStatusTxnObj);
            $this->em->flush();
            $returncode = 1; 
            
            $conn->commit();
            } 
            catch (\Exception $ex) 
            { 
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());

             }
            return array('code'=>$returncode,'msg' => 'Record Saved Sucessfully');
        
    }
    //------------------------------inserting po master ends here
     
     
     //------------------------------updating po master----------------------------------------------------
    
    
    function updateRequisitionDetails($request)
   {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try 
            { 
            $dataUI = json_decode($request->getContent());
            $productid = array();
             
            if(is_string($dataUI->pid)) {
                 $productid[0] = $dataUI->pid; //for only one    
                       
            } else 
            {
                 $productid = $dataUI->pid;     //for more than one       
            }
            $empid = $dataUI->eid;
            $rid = $dataUI->rid;
            $reqdate = $dataUI->reqdate;
            $description = $dataUI->description;
            //
            
            //setting foreign key object for postatus master
            $EmployeeObj=$this->em->getRepository(RequisitionConstant::ENT_EMP)->find($empid);
            //setting foreign key object for postatus master
            $ReqStatusMasterObj = $this->em->getRepository(RequisitionConstant::ENT_REQSTATUS)->find(1);
            //
            $RequisitionMasterObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($rid);   
            
//-------------------------------for updating and inserting new items record into po_product_details table----------------------------------------------------
//                print_r($productid);
//                die();
                        foreach($productid as $val) 
                        {
                            $q = 'quantity' . $val;
                            $u = 'unitid' . $val;
                            $r = 'remarks' . $val;
                            $p = 'purpose' . $val;
                            $pc = 'txt_code' . $val;
                            $pro = 'productid'.$val;
                            $id = 'prodetailid'.$val;
                            
                            $proid = $val;
                            $quantity = $dataUI->$q;
                            $remarks = $dataUI->$r;
                            $unit = $dataUI->$u;
                            $purpose = $dataUI->$p;
                            $purposecode = $dataUI->$pc;
                            $pid = $dataUI->$pro;
                            $pkid = $dataUI->$id;
                        
                       $ProObj=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                       $UnitObj=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);
                       $PurposeObj=$this->em->getRepository(RequisitionConstant::ENT_REQ)->find($purpose);
             
                    if ($pid == 1) {

                           switch($purpose)
                           {
                               case '1':
                               $CODE = $this->em->getRepository(RequisitionConstant::ENT_BRANCHMASTER)->findOneBy(array('branchCode'=>$purposecode));
                               if($CODE)
                               {  
                                   $purposecode=$dataUI->$pc;  
                               }
                               else{ 
                                   $returncode = 0; 
                                   return  array('code'=>$returncode,'msg'=>'Invalid branch code');  }
                               break;
                               case '2':
                               $CODE = $this->em->getRepository(RequisitionConstant::ENT_PROJECTMASTER)->findOneBy(array('orderNo'=>$purposecode));
                               if($CODE)
                               {  
                                   $purposecode=$dataUI->$pc;  
                               }
                               else{ 
                                     $returncode = 0; 
                                     return  array('code'=>$returncode,'msg'=>'Invalid project order no');  }
                               break;
                               case '3':
                               $CODE = $this->em->getRepository(RequisitionConstant::ENT_EMPLOYEEMASTER)->findOneBy(array('employeeId'=>$purposecode));
                               if($CODE)
                               {  
                                   $purposecode=$dataUI->$pc;  
                               }
                               else{ 
                                   $returncode = 0;
                                   return  array('code'=>$returncode,'msg'=>'Invalid employee code');  }
                               break;
                           }

                        $ProObj=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                        $UnitObj=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);
                        $PurposeObj=$this->em->getRepository(RequisitionConstant::ENT_REQ)->find($purpose);
                        $RequisitionProductDetailsObj = new RequisitionProductDetails();
                        $RequisitionProductDetailsObj->setRequisitionFk($RequisitionMasterObj);
                        $RequisitionProductDetailsObj->setUnitFk($UnitObj);
                        $RequisitionProductDetailsObj->setProductFk($ProObj);
                        $RequisitionProductDetailsObj->setRemarks($remarks);
                        $RequisitionProductDetailsObj->setQuantity($quantity);
                        $RequisitionProductDetailsObj->setDueQuantity($quantity);
                        $RequisitionProductDetailsObj->setPurposeCode($purposecode);
                        $RequisitionProductDetailsObj->setPurposeFk($PurposeObj);
                        $RequisitionProductDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                        $RequisitionProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                        $RequisitionProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $RequisitionProductDetailsObj->setRecordActiveFlag(1);
                        $RequisitionProductDetailsObj->setApprovalflag(0);
                        $this->em->persist($RequisitionProductDetailsObj);
                        $this->em->flush();
                        $returncode = 1;
                 
                    
                } 
                else 
                    {
                        switch($purpose)
                           {
                               case '1':
                               $CODE = $this->em->getRepository(RequisitionConstant::ENT_BRANCHMASTER)->findOneBy(array('branchCode'=>$purposecode));
                               if($CODE)
                               {  
                                   $purposecode=$dataUI->$pc;  
                               }
                               else{  
                                   $returncode = 0;
                                   return  array('code'=>$returncode,'msg'=>'Invalid branch code');  }
                               break;
                               case '2':
                               $CODE = $this->em->getRepository(RequisitionConstant::ENT_PROJECTMASTER)->findOneBy(array('orderNo'=>$purposecode));
                               if($CODE)
                               {  
                                   $purposecode=$dataUI->$pc;  
                               }
                               else{ 
                                   $returncode = 0; 
                                   return  array('code'=>$returncode,'msg'=>'Invalid project order no');  }
                               break;
                               case '3':
                               $CODE = $this->em->getRepository(RequisitionConstant::ENT_EMPLOYEEMASTER)->findOneBy(array('employeeId'=>$purposecode));
                               if($CODE)
                               {  
                                   $purposecode=$dataUI->$pc;  
                               }
                               else{
                                   $returncode = 0; 
                                   return  array('code'=>$returncode,'msg'=>'Invalid employee code');  }
                               break;
                           }
                       
                        $ProObj = $this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                        $UnitObj = $this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);
                        $ReqProDetailsObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findOneByrequisitionFk($rid);
                        $reqPkid = $ReqProDetailsObj->getPkid();
                        $RequisitionProductDetailsObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->find($reqPkid);
                        $RequisitionProductDetailsObj->setRequisitionFk($RequisitionMasterObj);
                        $RequisitionProductDetailsObj->setUnitFk($UnitObj);
                        $RequisitionProductDetailsObj->setProductFk($ProObj);
                        $RequisitionProductDetailsObj->setRemarks($remarks);
                        $RequisitionProductDetailsObj->setQuantity($quantity);
                        $RequisitionProductDetailsObj->setDueQuantity($quantity);
                        $RequisitionProductDetailsObj->setPurposeCode($purposecode);
                        $RequisitionProductDetailsObj->setPurposeFk($PurposeObj);
                        $RequisitionProductDetailsObj->setRecordUpdateDate(new \Datetime('NOW'));
                        $RequisitionProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                        $RequisitionProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $RequisitionProductDetailsObj->setRecordActiveFlag(1);
                        $RequisitionProductDetailsObj->setApprovalflag(0);
                        $this->em->flush();
                        $returncode = 1;
                  }
                      //---------------------------------------Purchae order Master Updating Part---------------------------
                    //$POMasterObj=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POid); 
                    $RequisitionMasterObj->setReqstatusFk($ReqStatusMasterObj);
                    $RequisitionMasterObj->setEmployeeFk($EmployeeObj);
                    $RequisitionMasterObj->setRequisitionDetails($description);
                    $RequisitionMasterObj->setRecordActiveFlag(1);
                    $RequisitionMasterObj->setApprovalflag(0);
                    $RequisitionMasterObj->setRequisitionDate(new \Datetime($reqdate));
                    $RequisitionMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                    $RequisitionMasterObj->setApplicationUserId($this->session->get('EMPID'));
                    $RequisitionMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush();
                    $returncode = 1;
                    //--------------------------------------------------Ends here------------------------------------------
                    
                     
            //---------------------------------for updating status txn------------------------------------        
            //$StatusTxn=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION_Status_txn)->findOneByRequisitionFk($rid);
            //$statusid=$StatusTxn->getPkid();       
            //$POStatusTxn = $this->em->getRepository(PurchaseConstant::ENT_POStatus_txn)->find($statusid);
            
            //$RequisitionStatusTxnObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_Status_txn)->find($statusid);
           }
           
            $RequisitionStatusTxnObj = new RequisitionStatusTxn();
            $RequisitionStatusTxnObj->setStatusDate(new\Datetime('NOW'));
            $RequisitionStatusTxnObj->setRemarks('Changes made to status'); 
            $RequisitionStatusTxnObj->setRecordActiveFlag(1);
            $RequisitionStatusTxnObj->setRecordUpdateDate(new \ Datetime('NOW'));
            $RequisitionStatusTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $RequisitionStatusTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $RequisitionStatusTxnObj->setRequisitionFk($RequisitionMasterObj);
            $RequisitionStatusTxnObj->setStatusFk($ReqStatusMasterObj);
            $this->em->persist($RequisitionStatusTxnObj);
            $this->em->flush();
            $returncode = 1;
           $conn->commit();
           } 
            catch (\Exception $ex) 
            { 
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());

             }
            return array('code'=>$returncode,'msg' => 'Record Updated Sucessfully');
        
    }
    
    //-------------------------------updating po master ends here--------------------------------------------------------------------
    
    
     //Insert record aapprove requisition master
    
     function ApproveRequisitionDetails($request)
     {
         
          $conn = $this->em->getConnection();
          $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try 
            { 
            $dataUI = json_decode($request->getContent());
            $Req_id = $dataUI->rid;
            $remarks = $dataUI->description;
            
            //creating status flag object
            $ReqStatusMasterObj = $this->em->getRepository(RequisitionConstant::ENT_REQSTATUS)->find(2);
           
            //creating po_product_details object
            //$Pro_Obj=$this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk(array('poFk'=>$POCode)); 
            $POProductObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findBy(array('requisitionFk'=>$Req_id));
            //updating po master
            $Req_Obj=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($Req_id); 
            $Req_Obj->setRecordUpdateDate(new\Datetime('NOW'));
            $Req_Obj->setApplicationUserId($this->session->get('EMPID'));
            $Req_Obj->setApplicationUserIpAddress($this->session->get('IP'));
            $Req_Obj->setApprovalflag(1);
            $Req_Obj->setReqstatusFk($ReqStatusMasterObj);
            $this->em->flush();
            //
            
            //inserting status master txn
            $STATUS_TXNObj = new RequisitionStatusTxn();
            $STATUS_TXNObj->setStatusDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setRemarks($remarks);
            $STATUS_TXNObj->setRecordActiveFlag(1);
            $STATUS_TXNObj->setRecordInsertDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setApplicationUserId($this->session->get('EMPID'));
            $STATUS_TXNObj->setApplicationUserIpAddress($this->session->get('IP'));
            $STATUS_TXNObj->setRequisitionFk($Req_Obj);
            $STATUS_TXNObj->setStatusFk($ReqStatusMasterObj);
            $this->em->persist($STATUS_TXNObj);
            $this->em->flush();
            //ends here
            
            
            //updating record for po order product details
            foreach($POProductObj as $p)
            {
                $p->setApprovalflag(1);
                $p->setRecordUpdateDate(new\Datetime('NOW'));
                $p->setApplicationUserId($this->session->get('EMPID'));
                $p->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }
           //ends here
     
            
            $conn->commit();
            
     }
            
            catch (\Exception $ex) 
            { 
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());

             }
            return array('msg' => 'Approved Sucessfully');
     }
    
    
    
    //cancelling requisition 
     
      function CancelRequisitionDetails($request)
     {
         
          $conn = $this->em->getConnection();
          $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try 
            { 
            $dataUI = json_decode($request->getContent());
            $Req_id = $dataUI->rid;
            $remarks = $dataUI->description;
            //creating purchase order object
            
            //creating status flag object
            //$POStatusMasterObj=$this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(5);
            $ReqStatusMasterObj = $this->em->getRepository(RequisitionConstant::ENT_REQSTATUS)->find(4);
            //creating po_product_details object
            //$Pro_Obj=$this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk(array('poFk'=>$POCode)); 
            $POProductObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findBy(array('requisitionFk'=>$Req_id));
            //updating po master
            $Req_Obj=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($Req_id); 
            $Req_Obj->setRecordUpdateDate(new\Datetime('NOW'));
            $Req_Obj->setApplicationUserId($this->session->get('EMPID'));
            $Req_Obj->setApplicationUserIpAddress($this->session->get('IP'));
            $Req_Obj->setApprovalflag(0);
            $Req_Obj->setRecordActiveFlag(0);
            $Req_Obj->setReqstatusFk($ReqStatusMasterObj);
            $this->em->flush();
            //
            
            //inserting status master txn
            $STATUS_TXNObj = new RequisitionStatusTxn();
            $STATUS_TXNObj->setStatusDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setRemarks($remarks);
            $STATUS_TXNObj->setRecordActiveFlag(0);
            $STATUS_TXNObj->setRecordInsertDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setApplicationUserId($this->session->get('EMPID'));
            $STATUS_TXNObj->setApplicationUserIpAddress($this->session->get('IP'));
            $STATUS_TXNObj->setRequisitionFk($Req_Obj);
            $STATUS_TXNObj->setStatusFk($ReqStatusMasterObj);
            $this->em->persist($STATUS_TXNObj);
            $this->em->flush();
            //ends here
            
            //updating record for Requisition product details
            foreach($POProductObj as $p)
            {
                $p->setApprovalflag(0);
                $p->setRecordActiveFlag(0);
                $p->setRecordUpdateDate(new\Datetime('NOW'));
                $p->setApplicationUserId($this->session->get('EMPID'));
                $p->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }
           //ends here
     
            $conn->commit();
            
     }
            
            catch (\Exception $ex) 
            { 
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());

             }
            return array('msg' => 'Requisition Cancelled Sucessfully');
     }
     

     
     
     
     //dispatch stock requisition 
     
      function DispatchStockRequisitionDetails($rid,$request)
     {
         
          $conn = $this->em->getConnection();
          $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try 
            { 
            $dataUI = json_decode($request->getContent());
            $requsitionid = $dataUI->requisitionID;
            $employeeid = $dataUI->selectedEMp;
             
            
            $proid=$rid;
            $productid = array();
             
            if(is_string($dataUI->productID)) {
                 $productid[0] = $dataUI->productID; //for only one    
                       
            } else 
            {
                 $productid = $dataUI->productID;     //for more than one       
            }
            
            foreach($productid as $val) 
                        {
                            $prid = $val;
                            $pro = 'proID'.$val;
                            $pid = $dataUI->$pro; 
                            
                            if ($pid == $proid) 
                                {
                                    $q = 'requisitionquantity' . $val;
                                    $sq = 'Stockquantity' . $val;
                                    $u = 'UnitID' . $val;

                                    $requiredquantity = $dataUI->$q;
                                    $stockquantity = $dataUI->$sq;
                                    $unit = $dataUI->$u;
                                    
                                    $Stock=$this->em->getRepository(RequisitionConstant::ENT_STOCK)->findBy(array('productFk'=>$proid));
                                    $sqnty = 0;
                                   //----------------assingning variable for storing requisition quantity 
                                    $req = $requiredquantity;
                                   //-----------------ends here----------- 
                                    
                                    foreach($Stock as $s)
                                    {  //-----------retreiving value from stock
                                       $sid = $s->getPkid();
                                       $existingstock = $s->getQuantity();
                                       //-----------ends here------------
                                      if($req>0)
                                      {
                                       //updating stock
                                          //---------if requistion greater than stock
                                        if($req>$existingstock)
                                        {
                                            $newquantity = $existingstock;
                                            $req = $req - $existingstock ;
                                            $proquantity = $req;
                                            $stock = $req - $existingstock;
                                            
                                             //-----stock updating part---------------
                                        $StockObj = $this->em->getRepository(RequisitionConstant::ENT_STOCK)->find($sid);
                                        $StockObj->setQuantity($stock);
                                        $StockObj->setRecordUpdateDate(new\Datetime('NOW'));
                                        $StockObj->setApplicationUserId($this->session->get('EMPID'));
                                        $StockObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->flush();
                                        //----stock updating ends here
                                        
                                        $RequisitionObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($requsitionid);
                                        $EmployeeObj = $this->em->getRepository(RequisitionConstant::ENT_EMP)->find($employeeid);
                                        $ProductObj = $this->em->getRepository(RequisitionConstant::ENT_PRODUCT)->find($proid);
                                        $UnitObj = $this->em->getRepository(RequisitionConstant::ENT_PRODUCT_UNIT)->find($unit);
                                         //for inserting new stock requistion history details
                                                    $StockHitoryObj = new RequisitionProductDetailsHistory();
                                                    //--------------- setting quantity zero
                                                    $StockHitoryObj->setQuantity($req);
                                                    $StockHitoryObj->setDueQuantity($req);
                                                    $StockHitoryObj->setRecordActiveFlag(1);
                                                    $StockHitoryObj->setDispatchDate(new\Datetime('NOW'));
                                                    $StockHitoryObj->setRequisitionFk($RequisitionObj);
                                                    $StockHitoryObj->setDispatchbyfk($EmployeeObj);
                                                    $StockHitoryObj->setProductFk($ProductObj);
                                                    $StockHitoryObj->setUnitFk($UnitObj);
                                                    $StockHitoryObj->setStockFk($StockObj);
                                                    $this->em->persist($StockHitoryObj);
                                                    $this->em->flush();
                                         //stock requisition history ends here 
                                            
                                        }
                                        //--------------- else if requisition less than stock
                                        else if($req < $existingstock)
                                        {
                                            $newquantity = $req;
                                            $req =  $existingstock - $req  ;
                                            $proquantity = $req;
                                            $stock = $req;
                                            //-----stock updating part---------------
                                        $StockObj = $this->em->getRepository(RequisitionConstant::ENT_STOCK)->find($sid);
                                        
                                        $StockObj->setQuantity($stock);
                                        $StockObj->setRecordUpdateDate(new\Datetime('NOW'));
                                        $StockObj->setApplicationUserId($this->session->get('EMPID'));
                                        $StockObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->flush();
                                        
                                        //----stock updating ends here
                                        
                                        $RequisitionObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($requsitionid);
                                        $EmployeeObj = $this->em->getRepository(RequisitionConstant::ENT_EMP)->find($employeeid);
                                        $ProductObj = $this->em->getRepository(RequisitionConstant::ENT_PRODUCT)->find($proid);
                                        $UnitObj = $this->em->getRepository(RequisitionConstant::ENT_PRODUCT_UNIT)->find($unit);
                                         //for inserting new stock requistion history details
                                                    $StockHitoryObj = new RequisitionProductDetailsHistory();
                                                    //--------------- setting quantity zero
                                                    $StockHitoryObj->setQuantity($newquantity);
                                                    $StockHitoryObj->setDueQuantity($newquantity);
                                                    $StockHitoryObj->setRecordActiveFlag(1);
                                                    $StockHitoryObj->setDispatchDate(new\Datetime('NOW'));
                                                    $StockHitoryObj->setRequisitionFk($RequisitionObj);
                                                    $StockHitoryObj->setDispatchbyfk($EmployeeObj);
                                                    $StockHitoryObj->setProductFk($ProductObj);
                                                    $StockHitoryObj->setUnitFk($UnitObj);
                                                    $StockHitoryObj->setStockFk($StockObj);
                                                    $this->em->persist($StockHitoryObj);
                                                    $this->em->flush();
                                         //stock requisition history ends here 
                                            
                                           break;
                                        } 
                                        else
                                            //--------------- setting quantity zero
                                        {
                                            $newquantity = 0;
                                            $proquantity = 0;
                                        }                                  
                                       } 
                                   }
                                   
                                 //for updating requesition product
                                       $Product = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->
                                       findOneBy(array('productFk' => $proid, 'requisitionFk' => $requsitionid));

                                       $reqpro = $Product->getPkid();
                                       $qn = $Product->getDueQuantity();

                                       $RequisitionProductObj = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->find($reqpro);
                                       
                                       if($requiredquantity>$qn)
                                       {   $due = $requiredquantity - $qn;
                                           
                                           $RequisitionProductObj->setDueQuantity($due);
                                           $RequisitionProductObj->setDeliveredQuantity($qn);
                                       }
                                       else
                                       {
                                           $due = $qn - $requiredquantity;
                                           $RequisitionProductObj->setDueQuantity($due);
                                           $RequisitionProductObj->setDeliveredQuantity($requiredquantity);
                                       }
                                        
                                       $RequisitionProductObj->setRecordUpdateDate(new\Datetime('NOW'));
                                       $RequisitionProductObj->setApplicationUserId($this->session->get('EMPID'));
                                       $RequisitionProductObj->setApplicationUserIpAddress($this->session->get('IP'));
                                       $this->em->flush();
                                        //requesition product ends here   
                                    
                                }
                            
                                
                                //----else part if product is not equal
                            else
                            
                                {
                                
                                }
                        }
            
              
            
           
            $conn->commit();
            
     }
            
            catch (\Exception $ex) 
            { 
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());

             }
            return array('msg' => 'Dispatch Sucessfully');
     }
     
     
     
     
      function StockReturnQuantityDetails($sid,$request)
     {
         
          $conn = $this->em->getConnection();
          $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try 
            { 
            $dataUI = json_decode($request->getContent());
            $reqhistoryid = $sid;
            $requistionhistoryid = array();
             
            if(is_string($dataUI->ID)) {
                 $requistionhistoryid[0] = $dataUI->ID; //for only one    
                       
            } else 
            {
                 $requistionhistoryid = $dataUI->ID;     //for more than one       
            }
            
            foreach($requistionhistoryid as $val) 
                        {
                            $pro = 'proID'.$val;
                            $pid = $dataUI->$pro; 
                            
                            if ($pid == $reqhistoryid) 
                                {
                                    $q = 'requisitionquantity' . $val;
                                    $rq = 'returnquantity' . $val;
                                    $s = 'stockid' . $val;
                                    $r = 'remark' . $val;
                                    $p = 'purpose' . $val;
                                    
                                    $requiredquantity = $dataUI->$q;
                                    $returnquantity = $dataUI->$rq;
                                    $remark = $dataUI->$r;;
                                    $prohistoryid = $pid;
                                    $stockid = $dataUI->$s;
                                    $purpose = $dataUI->$p;
                                    
                                   
                                    if($returnquantity>$requiredquantity)
                                    {   $returncode = 0;
                                        $returnmsg='Return quantity cannot be greater than current displayed quantity';
                                        return array('code'=>$returncode ,'msg' =>$returnmsg);
                                    }
                                    else
                                    {
                                        $StockObj=$this->em->getRepository(RequisitionConstant::ENT_STOCK)->find($stockid);
                                        $RequistionProductHistoryObj=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT_HISTORY)->find($prohistoryid);
                                        $stockquantity = $StockObj->getQuantity();
                                         
                                        $newstock = $stockquantity + $returnquantity;
                                        //----------stock update starts here-------------- 
                                        $StockObj->setQuantity($newstock);
                                        $StockObj->setRecordUpdateDate(new\Datetime('NOW'));
                                        $StockObj->setApplicationUserId($this->session->get('EMPID'));
                                        $StockObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->flush();
                                       
                                        //----------stock update ends here--------------
                                        
                                        //-----------stock return starts from here------
                                        $StockReturnObj = $this->em->getRepository(RequisitionConstant::ENT_STOCKRETURN)->findby(array('reqProFk'=>$prohistoryid));
                                        //$StockReturnObj = $this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchProHistoryID($prohistoryid); 
                                        $StockReturn = new StockReturn();
                                        //---------for checking whether a return quanity exist or not if exist,
                                        // to check from requisition as well as stock  return when button is click
                                        $ret = $requiredquantity;
                                        $PurposeObj=$this->em->getRepository(RequisitionConstant::ENT_STOCKRETURNPURPOSE)->find($purpose);
                                        foreach($StockReturnObj as $stock)
                                        {
                                            $current = $stock->getReturnquantity();
                                            $ret = $requiredquantity - $current;
                                            if($returnquantity<=$ret)
                                            {
                                                $StockReturn->setReturnquantity($returnquantity);
                                            }else
                                            {   $returncode = 0;
                                                $returnmsg = 'A return quantity exist! Please view return history';
                                                return array('code'=>$returncode ,'msg' =>$returnmsg);
                                            }
                                        }
                                        //-----checking ends here-----------------
                                         $StockReturn->setReturnquantity($returnquantity);
                                         $StockReturn->setReturnDate(new\Datetime('NOW'));
                                         $StockReturn->setRemarks($remark);
                                         $StockReturn->setReqPurFk($PurposeObj);
                                         $StockReturn->setRecordActiveFlag(1);
                                         $StockReturn->setRecordInsertDate(new\Datetime('NOW'));
                                         $StockReturn->setApplicationUserId($this->session->get('EMPID'));
                                         $StockReturn->setApplicationUserIpAddress($this->session->get('IP'));
                                         $StockReturn->setReqProFk($RequistionProductHistoryObj);
                                         $this->em->persist($StockReturn);
                                         $this->em->flush();
                                         $returncode = 1;
                                    }
                                        //----------stock return update ends here-------  
                               }
                            //----else part if product is not equal
                            else
                            
                                {
                                
                                }
                                
                               
                        }
                        
                        $returnmsg ="Quantity return to stock";
            $conn->commit();
    }
            catch (\Exception $ex) 
            { 
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            return array('code'=>$returncode ,'msg' =>$returnmsg);
     }
     
     public function addUpdateTransport($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $tranportorName = $dataUI->transportor_name;
            $description = $dataUI->transportor_des;
            $transportorId = $dataUI->transportorId;
            if ($transportorId == "") {
                $transportorObj = new StockReturnPurpose();
            } else {
                $transportorObj = $this->em->getRepository(RequisitionConstant::ENT_STOCKRETURNPURPOSE)->find($transportorId);
            }

            $transportorObj->setPurposeName($tranportorName);
            $transportorObj->setDescription($description);
            $transportorObj->setRecordActiveFlag(1);
            
            if ($transportorId == "") {
                $transportorObj->setRecordInsertDate(new \Datetime());
            } else {
                $transportorObj->setRecordUpdateDate(new \Datetime());
            }
            $transportorObj->setApplicationUserId($this->session->get('EMPID'));
            $transportorObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($transportorObj);
            $this->em->flush();
            if ($transportorId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('StockReturnPurpose')
        );
    }
    
    public function retrieveTransport($transportorId) {
        try {
            $transportorObj = $this->em->getRepository(RequisitionConstant::ENT_STOCKRETURNPURPOSE)->find($transportorId);
            $return = array(
                'transportorId' => $transportorId,
                'transportor_name' => $transportorObj->getPurposeName(),
                'transportor_des' => $transportorObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
    
     public function deleteTransportorMaster($transportorId) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:StockReturnPurpose')->find($transportorId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('StockReturnPurpose'),
            'id' => $ACidObj->getPkid());
    }
    
}