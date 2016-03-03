<?php
namespace Tashi\SupplierBundle\Service;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\SupplierBundle\Helper\SupplierConstant;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Entity\SupplierMaster;
use Tashi\CommonBundle\Entity\SupplierAddressTxn;
use Tashi\CommonBundle\Entity\CmnPerson;
use Tashi\CommonBundle\Entity\SupplierContactTxn;
use Tashi\CommonBundle\Entity\CmnLocationAddressMaster;
use Tashi\CommonBundle\Entity\SupplierContactMobileNoTxn;
use Tashi\CommonBundle\Entity\CmnMobileNoMaster;
use Tashi\CommonBundle\Entity\SupplierBankTxn;
use Tashi\CommonBundle\Entity\CmnBankDetailsMaster;
use Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster;
use Tashi\CommonBundle\Entity\TransporterMaster;
use Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster;
use Tashi\CommonBundle\Entity\CmnSupplierCommunicationTxn;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\SupplierProductCategoryTxn;
use Tashi\CommonBundle\Entity\SupplierProductTxn;
use Tashi\CommonBundle\Entity\TransporterMobileTxn;

class SupplierService {
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;
    protected $mailer;

    public function __construct(EntityManager $em, Session $session, $rootDir,$commonService,$mailer) 
    {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService=$commonService; 
        $this->mailer=$mailer;
    }
    
    //------------------------------RECORD INSERTION SECTION----------------------------------
    
     public function displayAllResult($tbl_name) {
        try {
            return $this->commonService->activeList($tbl_name);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    
    public function addSupplierMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            $dataUI=$request->request;
            //$dataUI = json_decode($request->getContent());
           
            //inserting record for supplier master
            $comName = $dataUI->get('txt_pur_companyname');
            $regNo=$dataUI->get('txt_Registration');
            $remarks=$dataUI->get('txt_remarks');
            //$website=  $dataUI->Website; 
            $Fname=  $dataUI->get('txt_pur_firstname'); 
            $Mname  =  $dataUI->get('txt_pur_middlename');       
            $Lname=  $dataUI->get('txt_pur_lastname'); 
            $supcode=  $dataUI->get('txt_sup_codename'); 
            //$designation =  $dataUI->get('txt_occupation');        
            $dob  =  $dataUI->get('dob');       
            $gender  =  $dataUI->get('gender'); 
            //$email=$dataUI->email; 
            
            $fileupload=$request->files->get('txt_logo');
            $uploadedFiles=array();
            $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
            //inserting record into document master
            if(isset($fileupload)){ $path='upload/SUP/LOGO/'   ;
                           $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0.5,$validFileTypes);
                           if($fuploadresult['code']==1){
                               $uploadedFiles[]=$fuploadresult['fullpath'];
                               //save image in document master
                               $document=new CmnDocumentMaster();
                               $document->setPath($path.$fuploadresult['newname']);
                               $document->setOriginalName($fuploadresult['oriname']);
                               $document->setSystemName($fuploadresult['newname']);
                               $document->setDocType($fuploadresult['ext']);
                               $document->setRecordActiveFlag(1);
                               $document->setRecordInsertDate(new \DateTime("NOW"));
                               $document->setApplicationUserId($this->session->get('EMPID'));
                               $document->setApplicationUserIpAddress($this->session->get('IP'));
                               $this->em->persist($document);
                               $this->em->flush();
                               }else{
                               $conn->rollBack();
                               foreach($uploadedFiles as $file){
                                   if(file_exists($file)){
                                       unlink($file);
                                   }
                               }
                               return array('code'=>0,'msg'=>$fuploadresult['msg']);
            }
            
            
                                   }
            //ends here
                           
            //inserting into supplier master               
            $SupplierObj = new SupplierMaster();
            $SupplierObj->setCompanyName($comName);
            $SupplierObj->setCompanyId($supcode);
            $SupplierObj->setRegistrationNo($regNo);
            $SupplierObj->setRemarks($remarks);
            if(isset($document))
            {
            $SupplierObj->setDocfk($document);
            }
            $SupplierObj->setRecordInsertDate(new \Datetime());
            $SupplierObj->setApplicationUserId($this->session->get('EMPID'));
            $SupplierObj->setApplicationUserIpAddress($this->session->get('IP'));
            $SupplierObj->setRecordActiveFlag(1);
            $this->em->persist($SupplierObj);
            $this->em->flush();
            //ends here
            
            
            //inserting record for common person
            $CommonpersonObj=new CmnPerson();
            $CommonpersonObj->setFirstName($Fname);
            $CommonpersonObj->setMiddleName($Mname);
            $CommonpersonObj->setLastName($Lname);
            $CommonpersonObj->setGender($gender);
            //$CommonpersonObj->setDesignation($designation);
            $CommonpersonObj->setDateOfBirth(new \Datetime($dob));
           // $CommonpersonObj->setEmailId($email);
            $CommonpersonObj->setRecordActiveFlag(1); 
            $CommonpersonObj->setRecordInsertDate(new \Datetime());
            $CommonpersonObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonpersonObj->setApplicationUserIpAddress($this->session->get('IP'));
            
            $this->em->persist($CommonpersonObj);
            $this->em->flush();
            //ends here
            
            //inserting record for supplier contact txn
           
            
            $suppcontacttxnObj=new SupplierContactTxn();
            $suppcontacttxnObj->setSupplierFk($SupplierObj);
            $suppcontacttxnObj->setPersonFk($CommonpersonObj);
            
            $suppcontacttxnObj->setRecordActiveFlag(1); 
            $suppcontacttxnObj->setRecordInsertDate(new \Datetime());
            $suppcontacttxnObj->setApplicationUserId($this->session->get('EMPID'));
            $suppcontacttxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($suppcontacttxnObj);
            $this->em->flush();
            
            
            //ends here
            
            //inserting record into SupplierProductCategoryTxn
//             $sup_pro_cat = array(); 
//            //$sup_pro_cat_txn = $dataUI->get('category');
//             if (is_string($dataUI->get('category'))) {
//                $sup_pro_cat[0] = $dataUI->get('category'); //for only one 
//              } else {
//                $sup_pro_cat = $dataUI->get('category');     //for more than one       
//              }
//            foreach($sup_pro_cat as $SupCat)
//            {
//            
//            $SupProCatTxnObj = new SupplierProductCategoryTxn();
//            $SupCatObj=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($SupCat); 
//            $SupProCatTxnObj->setProcatFk($SupCatObj);
//            $SupProCatTxnObj->setSupFk($SupplierObj);
//            $SupProCatTxnObj->setRecordActiveFlag(1); 
//            $SupProCatTxnObj->setRecordInsertDate(new \Datetime());
//            $SupProCatTxnObj->setApplicationUserId($this->session->get('EMPID'));
//            $SupProCatTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
//            $this->em->persist($SupProCatTxnObj);
//            $this->em->flush();
//                
//            }
            //inserting record into SupplierProductCategoryTxn ends here
            //ends here
             $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
        
      //  echo StockConstant::PROJECT_PATH.'stock/update_supplier/'.$SupplierObj->getSupplierPk();die();
        return array('msg' => 'Record Save Sucessfully',
            'result'=>$this->commonService->activeList('SupplierMaster'),
            //'result' => $this->commonService->getRecordsByArray(StockConstant::ENT_STOCK_SUPPLIER_MASTER,array('recordActiveFlag' => 1)),
            'supplier_id' => $SupplierObj->getSupplierPk(),
         //   'supplierUpdateURL'=> StockConstant::PROJECT_PATH.'stock/update_supplier/'.$SupplierObj->getSupplierPk()
                
        );
        
        
    }
       
    //---------------------------inserting record for supplier mobile details--------------------------
        
    public function addSupplierMobileMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            $dataUI = json_decode($request->getContent());
            $supid=$dataUI->supid;
            $SupplierObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid); 
            $SuppliercontactObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid)); 
            $sup_contact_id=$SuppliercontactObj->getSuppContactPk();
            
             
            //---------------------------add multiple mobile no-------------------------------------
              $mobile_no = array();
              if (is_string($dataUI->txt_supplier_mobile)) {
                $mobile_no[0] = $dataUI->txt_supplier_mobile; //for only one 
              } else {
                $mobile_no = $dataUI->txt_supplier_mobile;     //for more than one       
              }
              foreach ($mobile_no as $val) {   // for inserting array value
                    $CommonMobileObj = new CmnMobileNoMaster();
                    $CommonMobileObj->setMobileNo($val);
                    $CommonMobileObj->setRecordActiveFlag(1);
                    $CommonMobileObj->setRecordInsertDate(new \Datetime('NOW'));
                    $CommonMobileObj->setApplicationUserId($this->session->get('EMPID'));
                    $CommonMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($CommonMobileObj);
                    $this->em->flush();
                    //---------------for inserting mutiple mobile transaction---------------------
                    $contact_no_mobiletxnObj=new SupplierContactMobileNoTxn();
                    $contact_no_mobiletxnObj->setContactType('M');
                    $contact_no_mobiletxnObj->setMobileMasterFk($CommonMobileObj);
                    
                    $contact_no_mobiletxnObj->setSupContactFk($this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->find($sup_contact_id));
                    $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                    $contact_no_mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                    $contact_no_mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $contact_no_mobiletxnObj->setRecordActiveFlag(1);
                    $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                    $contact_no_mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                    $contact_no_mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($contact_no_mobiletxnObj);
                    $this->em->flush();
                    //-------------------------ends here-----------------------------
              }  
            //ends here 
             
            //-------------------updating record for supplier website----------------------------------  
            $website=$dataUI->Website;
            $SupplierObj->setWebsite($website);
            $this->em->flush();
            //ends here
              
            //-------------------updating record for common person email-------------------------------  
            $email=$dataUI->email;
            $phone_no = $dataUI->txt_supplier_phone;    
            $suppliercontact_pkObj = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid,'recordActiveFlag'=>1));
            $common_person_pk = $suppliercontact_pkObj->getPersonFk()->getPersonPk();
            $CommonpersonObj=$this->commonService->getRecordById(SupplierConstant::ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS,$common_person_pk);
            $CommonpersonObj->setEmailId($email);
            $CommonpersonObj->setTelephoneNo($phone_no);
            $this->em->flush();
            //-------------------common person email ends here----------------------------------------- 
            
            
            $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
       }
        
        return array('msg' => 'Contact Details Save Sucessfully',
            'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1)),
            'id' => $CommonMobileObj->getPkid()
        );
        
        
    }
   //------------------------------supplier mobile insert completed ----------------------------------    
    
   //inserting record for supplier bank details
        
     public function addSupplierBankDetailsMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            $dataUI = json_decode($request->getContent());
            
            //inserting record for supplier master
            $Supid = $dataUI->supid;
           
            $Bankname=$dataUI->txt_bank_name;
            $Branch=$dataUI->txt_branch;
            $BranchCOde=$dataUI->txt_branchcode;
            $IFSC=$dataUI->txt_ifsc;
            $MICR=$dataUI->txt_micr;
            $Contact=  $dataUI->txt_contact; 
            $address = $dataUI->location;
            $accountype=$dataUI->account_type;
            $accountno=$dataUI->txt_accountno;
            
            //inserting record for supplier bank details
            $CommonBankObj=new CmnBankDetailsMaster();
            $CommonBankObj->setBankName($Bankname);
            $CommonBankObj->setAccountNumber($accountno);
            $CommonBankObj->setBranchName($Branch);
            $CommonBankObj->setContactNumber($Contact);
            $CommonBankObj->setIfscCode($IFSC);
            $CommonBankObj->setMicrCode($MICR);
            $CommonBankObj->setBranchCode($BranchCOde);
            $CommonBankObj->setLocation($address);
            $AccountTypeObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_COMMON_BANK_ACCOUNTTYPE)->find($accountype);
            $CommonBankObj->setAccountTypeMasterFk($AccountTypeObj);
            $CommonBankObj->setRecordActiveFlag(1); 
            $CommonBankObj->setRecordInsertDate(new \Datetime()); 
            $CommonBankObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonBankObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($CommonBankObj);
            $this->em->flush();
            //ends here
            
            //inserting record for supplier bank txn
            $SupllierBanktxnObj=new SupplierBankTxn();
            
            $SupplierObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($Supid);
            $SupllierBanktxnObj->setSupplierFk($SupplierObj);
            $SupllierBanktxnObj->setBankFk($CommonBankObj);
            $SupllierBanktxnObj->setRecordActiveFlag(1); 
            $SupllierBanktxnObj->setRecordInsertDate(new \Datetime()); 
            $SupllierBanktxnObj->setApplicationUserId($this->session->get('EMPID'));
            $SupllierBanktxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($SupllierBanktxnObj);
            $this->em->flush();
            //ends here
              
           
            
            
            
            
             $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
      
        return array('msg' => 'Record Save Sucessfully',
            
            'result' => $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->
            findBy(array('supplierFk' => $Supid, 'recordActiveFlag' => 1)),
            'bankid' => $CommonBankObj->getBankPk()
        );
        
        
    }
        
    //supplier bank details record insertion ends here
    
    
    
    //---------------------------------RECORD INSERTION SECTION ENDS HERE------------------------------
    
    
    
    
    //---------------------------------RECORD UPDATE SECTION----------------------------------------------
    
     //------------------------------updating supplier mobile master------------------------------
    public function UpdateSupplierMobileDetailsMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            $dataUI = json_decode($request->getContent());
            
            //retriving pk from entity
            
            $supid=$dataUI->supid;
            $SupplierObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid); 
            $CommonSupMobile_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid)); 
            $sup_contact_pk=$CommonSupMobile_txnObj->getSuppContactPk();
           
             //---------------------------add multiple mobile no-------------------------------------
            
            $mobile_no = array();
            if($dataUI->txt_supplier_mobile=='')
            {
                
                //do nothing
            }
            else
            {
               if (is_string($dataUI->txt_supplier_mobile)) {
                $mobile_no[0] = $dataUI->txt_supplier_mobile; //for only one 
              } else {
                $mobile_no = $dataUI->txt_supplier_mobile;     //for more than one       
              }
              foreach ($mobile_no as $val) {   // for inserting array value
                    $CommonMobileObj = new CmnMobileNoMaster();
                    $CommonMobileObj->setMobileNo($val);
                    $CommonMobileObj->setRecordActiveFlag(1);
                    $CommonMobileObj->setRecordInsertDate(new \Datetime('NOW'));
                    $CommonMobileObj->setApplicationUserId($this->session->get('EMPID'));
                    $CommonMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($CommonMobileObj);
                    $this->em->flush();
                    //---------------for inserting mutiple mobile transaction---------------------
                    $contact_no_mobiletxnObj=new SupplierContactMobileNoTxn();
                    $contact_no_mobiletxnObj->setContactType('M');
                    $contact_no_mobiletxnObj->setMobileMasterFk($CommonMobileObj);
                    
                    $contact_no_mobiletxnObj->setSupContactFk($this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->find($sup_contact_pk));
                    $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                    $contact_no_mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                    $contact_no_mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $contact_no_mobiletxnObj->setRecordActiveFlag(1);
                    $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                    $contact_no_mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                    $contact_no_mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($contact_no_mobiletxnObj);
                    $this->em->flush();
                   
              } 
                
            }
              
           //------------------------------ends here--------------------------------------------------- 
            
           //-------------------updating record for supplier website----------------------------------  
            $website=$dataUI->Website;
            $SupplierObj->setWebsite($website);
            $this->em->flush();
            //ends here
              
            //-------------------updating record for common person email-------------------------------  
            $email=$dataUI->email;
            $phone_no = $dataUI->txt_supplier_phone;    
            $suppliercontact_pkObj = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid,'recordActiveFlag'=>1));
            $common_person_pk = $suppliercontact_pkObj->getPersonFk()->getPersonPk();
            $CommonpersonObj=$this->commonService->getRecordById(SupplierConstant::ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS,$common_person_pk);
            $CommonpersonObj->setEmailId($email);
            $CommonpersonObj->setTelephoneNo($phone_no);
            $this->em->flush();
            //-------------------common person email ends here----------------------------------------- 
            
            
            $conn->commit();
             
             
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
        return array('msg' => 'Contact Details Updated Sucessfully',
            'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1))
        );
        
                 
    }
    //------------------------------updating supplier mobile master ends here
        
  
    //------------------------------updating supplier mobile master------------------------------
    public function UpdateSupplierMobileListDetailsMaster($request,$mob_id) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            
            $dataUI = json_decode($request->getContent());
            $mobile = $dataUI->mobileno;
            $CommonMobile=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT)->findOneBy(array('pkid'=>$mob_id)); 
            $CommonMobile->setMobileNo($mobile);
            $CommonMobile->setRecordActiveFlag(1);
            $CommonMobile->setRecordInsertDate(new \Datetime('NOW'));
            $CommonMobile->setApplicationUserId($this->session->get('EMPID'));
            $CommonMobile->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            $conn->commit();
             
             
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
      
        return array('msg' => 'Mobile Details Updated Sucessfully',
           'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1)),
            'id' => $CommonMobile->getPkid()
        );
        
        
    }
    //------------------------------updating supplier mobile master ends here
        
    
    //------------------------------updating supplier mobile master------------------------------
    public function UpdateTransportMobileListDetailsMaster($request,$mob_id) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $mobile = $dataUI->mobileno;
            $CommonMobile = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT)->findOneBy(array('pkid'=>$mob_id)); 
            $CommonMobile->setMobileNo($mobile);
            $CommonMobile->setRecordActiveFlag(1);
            $CommonMobile->setRecordInsertDate(new \Datetime('NOW'));
            $CommonMobile->setApplicationUserId($this->session->get('EMPID'));
            $CommonMobile->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit();
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
      
        return array('msg' => 'Particular Mobile No Updated Sucessfully',
           'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1)),
            'id' => $CommonMobile->getPkid()
        );
        
        
    }
    //------------------------------updating supplier mobile master ends here
        
    
     //Delete Mobile No List only
     public function DeleteTransportMobileMaster($request,$mob_id) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
             
            //deleting record for supplier mobile list master
            $dataUI = json_decode($request->getContent());
            $id=$dataUI->id;
            
            $trasnport_txn=$this->em->getRepository(SupplierConstant::ENT_TransportMobileTxn)->findOneBy(array('mobileFk'=>$mob_id,'recordActiveFlag'=>1)); 
            $mobiletxnpk=$trasnport_txn->getPkid();
            
            $CommonMobile_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT)->find($mob_id); 
            
            $mobiletxnObj=$this->em->getRepository(SupplierConstant::ENT_TransportMobileTxn)->find($mobiletxnpk); 
            
            //deleting record for supplier contact_txn details master
            $CommonMobile_txnObj->setRecordActiveFlag(0); 
            $CommonMobile_txnObj->setRecordInsertDate(new \Datetime());
            $CommonMobile_txnObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonMobile_txnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            
            
            $mobiletxnObj->setRecordActiveFlag(0); 
            $mobiletxnObj->setRecordInsertDate(new \Datetime());
            $mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
            $mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
       }
        return array('msg' => 'Particular Mobile No Deleted Sucessfully',
            'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1))
        );
        
        
    }
    
    //Mobile No List Section ends here
    
    //---------------------updating supplier master record------------------------
        
    public function updateSupplierMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            //$dataUI = json_decode($request->getContent());
            $dataUI=$request->request;
            //--------------------------updating record for supplier master--------------------------

            $comName = $dataUI->get('txt_pur_companyname');
            $regNo=$dataUI->get('txt_Registration');
            $remarks=$dataUI->get('txt_remarks');
            $Fname=  $dataUI->get('txt_pur_firstname'); 
            $Mname  =  $dataUI->get('txt_pur_middlename');       
            $Lname=  $dataUI->get('txt_pur_lastname'); 
            $designation =  $dataUI->get('txt_occupation');        
            $sup_id=$dataUI->get('supid');
            $supcode=  $dataUI->get('txt_sup_codename'); 
            $SupplierObj= $this->commonService->getRecordById(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER,$sup_id);
            $allsup=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($sup_id);
            
            if(is_null($allsup->getDocfk()))
            {
                
            }
            else
            {
                $documentid = $allsup->getDocfk()->getPkid();
                $document = $this->em->getRepository(SupplierConstant::ENT_COMMONDOCUMENT)->find($documentid);
                 $prevfilepath='';
                 if($document){
                    $prevfilepath = $document->getPath();
                 }
            }
            
            
            
                 
            $isDocNew=false;
            $fileupload=$request->files->get('txt_logo');
            $uploadedFiles=array();
            $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
            //inserting record into document master
             if(isset($fileupload)){                
                 $path='upload/SUP/LOGO/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0.5,$validFileTypes);
                if($fuploadresult['code']==1){
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //save image in document master
                    if(!$document){
                        $document=new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew=true;
                    }else{
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }                   
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if($isDocNew){
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if(file_exists($prevfilepath)){
                        unlink($prevfilepath);
                    }
                }
                else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                }
            }
            // Supplier MASTER              
            if($isDocNew){
                if(isset($document)){
                    $SupplierObj->setDocfk($document);
                }
            }
            //ends here      
            $SupplierObj->setCompanyName($comName);
            $SupplierObj->setCompanyId($supcode);
            $SupplierObj->setRegistrationNo($regNo);
            $SupplierObj->setRemarks($remarks);
            $SupplierObj->setRecordInsertDate(new \Datetime());
            $SupplierObj->setApplicationUserId($this->session->get('EMPID'));
            $SupplierObj->setApplicationUserIpAddress($this->session->get('IP'));
            $SupplierObj->setRecordActiveFlag(1);
            $this->em->flush();
            //-----------------------------ends here--------------------------------------
            
            
            //-------------------------------retriving record from supplier contact txn--------------------------
           
            $suppliercontact_pkObj = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$sup_id,'recordActiveFlag'=>1));
            $common_person_pk = $suppliercontact_pkObj->getPersonFk()->getPersonPk();
            $CommonpersonObj=$this->commonService->getRecordById(SupplierConstant::ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS,$common_person_pk);

            
            //-------------------------------------ends here----------------------------------------------
            
            //-----------------------updating record for common person----------------------------------
            //$CommonpersonObj=$this->commonService->getRecordById(StockConstant::ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS,$common_person_pk);
            $CommonpersonObj->setFirstName($Fname);
            $CommonpersonObj->setMiddleName($Mname);
            $CommonpersonObj->setLastName($Lname);
           // $CommonpersonObj->setGender($gender);
            $CommonpersonObj->setDesignation($designation);
            //$CommonpersonObj->setDateOfBirth(new \Datetime($dob));
            $CommonpersonObj->setRecordActiveFlag(1); 
            $CommonpersonObj->setRecordInsertDate(new \Datetime()); 
            $CommonpersonObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonpersonObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //------------------------------ends here---------------------------------
            
            
            //updating record for SupplierProductCategoryTxn
            $ProCategory = $this->em->getRepository(SupplierConstant::ENT_SUP_Pro_Category_Txn)->findBy(array('recordActiveFlag'=>1,'supFk'=>$sup_id));
            foreach($ProCategory as $val1)
            {   $pkid = $val1->getPkid();
                $SubProCatTxn = $this->em->getRepository(SupplierConstant::ENT_SUP_Pro_Category_Txn)->find($pkid);
                $SubProCatTxn->setRecordActiveFlag(0);
                $this->em->flush($SubProCatTxn);
            }
            
            
             //inserting record into SupplierProductCategoryTxn
//             $sup_pro_cat = array(); 
//            //$sup_pro_cat_txn = $dataUI->get('category');
//             if (is_string($dataUI->get('category'))) {
//                $sup_pro_cat[0] = $dataUI->get('category'); //for only one 
//              } else {
//                $sup_pro_cat = $dataUI->get('category');     //for more than one       
//              }
//            foreach($sup_pro_cat as $SupCat)
//            {
//            $SubProCategoryPkid = $this->em->getRepository(SupplierConstant::ENT_SUP_Pro_Category_Txn)->findOneBy(array('supFk'=>$sup_id,'procatFk'=>$SupCat));
//                                    if($SubProCategoryPkid)
//                                        {
//                                    $id = $SubProCategoryPkid->getPkid();
//                                    $SupProCatTxnObj = $this->em->getRepository(SupplierConstant::ENT_SUP_Pro_Category_Txn)->find($id);
//                                    $SupProCatTxnObj->setRecordActiveFlag(1);
//                                    $SupProCatTxnObj->setRecordUpdateDate(new \DateTime("NOW"));
//                                    $SupProCatTxnObj->setApplicationUserId($this->session->get('EMPID'));
//                                    $SupProCatTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
//                                    $this->em->flush($SupProCatTxnObj);
//                                        }
//                                    else
//                                            {
//                                                $SupProCatTxnObj = new SupplierProductCategoryTxn();
//                                                $SupCatObj=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($SupCat); 
//                                                $SupProCatTxnObj->setProcatFk($SupCatObj);
//                                                $SupProCatTxnObj->setSupFk($SupplierObj);
//                                                $SupProCatTxnObj->setRecordActiveFlag(1); 
//                                                $SupProCatTxnObj->setRecordInsertDate(new \Datetime());
//                                                $SupProCatTxnObj->setApplicationUserId($this->session->get('EMPID'));
//                                                $SupProCatTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
//                                                $this->em->persist($SupProCatTxnObj);
//                                                $this->em->flush();
//                                            }
//            
//           }
            
             $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        return array('msg' => 'Supplier updated sucessfully',
            'result'=>$this->commonService->activeList('SupplierMaster'),'supplier_id' => $SupplierObj->getSupplierPk(),);
        
        
    }
        
    //--------------------------------ends here--------------------------------------------
        
    
    
    //update supplier bank details section
    public function UpdateSupplierBankDetailsMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            $dataUI = json_decode($request->getContent());
            
            //inserting record for supplier master
            $Supid = $dataUI->supid;
            $bankid=$dataUI->bid;
            $Bankname=$dataUI->txt_bank_name;
            $Branch=$dataUI->txt_branch;
            $BranchCOde=$dataUI->txt_branchcode;
            $IFSC=$dataUI->txt_ifsc;
            $MICR=$dataUI->txt_micr;
            $Contact=  $dataUI->txt_contact; 
            $address = $dataUI->location;
            $accountype=$dataUI->account_type;
            $accountno=$dataUI->txt_accountno;
            //$SupplierObj= $this->commonService->getRecordById(StockConstant::ENT_STOCK_SUPPLIER_MASTER,$Supid);
            
            //retriving pk from entity
            //$SupllierBanktxn_pk_Obj = $this->em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->findBy(array('supplierFk'=>$Supid,'recordActiveFlag'=>1));
            //$common_bank_pk = $SupllierBanktxn_pk_Obj->getBankFk()->getBankPk();
            
            
            //updating record for supplier bank details
            $CommonBankObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANKDETAIL_MASTER)->findOneBy(array('bankPk'=>$bankid,'recordActiveFlag'=>1));
            
            $CommonBankObj->setAccountNumber($accountno);
            $CommonBankObj->setBankName($Bankname);
            $CommonBankObj->setBranchName($Branch);
            $CommonBankObj->setContactNumber($Contact);
            $CommonBankObj->setIfscCode($IFSC);
            $CommonBankObj->setMicrCode($MICR);
            $CommonBankObj->setBranchCode($BranchCOde);
            $CommonBankObj->setLocation($address);
            $AccountTypeObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_COMMON_BANK_ACCOUNTTYPE)->find($accountype);
            $CommonBankObj->setAccountTypeMasterFk($AccountTypeObj);
            
            //setAccountTypeMasterFk
            
            $CommonBankObj->setRecordActiveFlag(1); 
            $CommonBankObj->setRecordInsertDate(new \Datetime()); 
            $CommonBankObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonBankObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            
           
              
            
             $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
      
        return array('msg' => 'Bank Details Updated Sucessfully',
            'result' => $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->
            findBy(array('supplierFk' => $Supid, 'recordActiveFlag' => 1)),
            'bankid' => $CommonBankObj->getBankPk()
        );
        
        
    }
    
    
    //supplier bank details section ends here
    
    
    //-------------------------------UPDATE SECTION ENDS HERE-------------------------------
    
    
    
    //------------------------------DELETE SECTION --------------------------
     //Delete supplier bank details section
    public function DeleteSupplierBankDetailsMaster($request,$bankid) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
             $dataUI = json_decode($request->getContent());
            
            //inserting record for supplier master
            $Supid = $dataUI->supid;
           
            //deleting record for supplier bank-txn details master
            $common_bank_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->findOneBy(array('bankFk'=>$bankid));
            $common_bank_txnObj->setRecordActiveFlag(0); 
            $common_bank_txnObj->setRecordInsertDate(new \Datetime());
            $common_bank_txnObj->setApplicationUserId($this->session->get('EMPID'));
            $common_bank_txnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            
            
            //deleting record for supplier bank details master
            $CommonBankObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANKDETAIL_MASTER)->find($bankid);
            $CommonBankObj->setRecordActiveFlag(0); 
            $CommonBankObj->setRecordInsertDate(new \Datetime()); 
            $CommonBankObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonBankObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            
           $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
       }
       return array('msg' => 'Bank Details Deleted Sucessfully',
            'result' => $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->
            findBy(array('supplierFk' => $Supid, 'recordActiveFlag' => 1)),
            'bankid' => $CommonBankObj->getBankPk()
        );
        
        
    }
    
    //Delete supplier bank details section ends here
    
    
    //Delete supplier contact details section
    public function DeleteSupplierContactDetailsMaster($request,$supid) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
             $dataUI = json_decode($request->getContent());
            
            //inserting record for supplier master
            $supid=$dataUI->supid;
            $CommonSupMobile_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid)); 
            $supcontact_pk=$CommonSupMobile_txnObj->getSuppContactPk();
            
            $supplier_cmn_mb_txn_Obj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->
                    findBy(array('supContactFk'=>$supcontact_pk,'recordActiveFlag'=>1)); 
            
            //$CommonSupMobile_txnObj->getPersonFk();
            $Cmn_person_pk= $CommonSupMobile_txnObj->getPersonFk()->getPersonPk();
            
            $CommonPersonObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS)->find($Cmn_person_pk); 
           
            //deleting record for common persong table
             $CommonPersonObj->setEmailId('');
             $CommonPersonObj->setTelephoneNo('');
             $this->em->flush();
            //deleting record ends here
            
            //deleting record for supplier website 
             
            $SupplierObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid); 
            $SupplierObj->setWebsite('');
            $this->em->flush();
           
            //ends here
        
            //deleting record for supplier contact_txn details master
            //$CommonSupMobile_txnObj->setRecordActiveFlag(0); 
            // $CommonSupMobile_txnObj->setRecordInsertDate(new \Datetime());
            //$this->em->flush();
            //ends here
            
            //deleting record for supplier_mobile_contact_txn details
            
            foreach($supplier_cmn_mb_txn_Obj as $val)
            {
            $val->setRecordActiveFlag(0); 
            $val->setRecordInsertDate(new \Datetime());
            $val->setApplicationUserId($this->session->get('EMPID'));
            $val->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
                
            }
           //ends here     
           $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
       }
        return array('msg' => 'Contact Details Deleted Sucessfully',
            'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1))
        );       
    }
    
    //Delete supplier contact details section ends here
    
    
    //Delete Mobile No List only
     public function DeleteSupplierMobileMaster($request,$mob_id) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
             
            //deleting record for supplier mobile list master
            $dataUI = json_decode($request->getContent());
            $supid=$dataUI->supid;
            
            $CommonSupContact_person_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid)); 
            $sup_contact_pk=$CommonSupContact_person_txnObj->getSuppContactPk();
            
            $CommonMobile_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT)->find($mob_id); 
            
            $supplier_cmn_mb_txn_Obj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->findOneByMobileMasterFk($mob_id); 
            
            //deleting record for supplier contact_txn details master
            $CommonMobile_txnObj->setRecordActiveFlag(0); 
            $CommonMobile_txnObj->setRecordInsertDate(new \Datetime());
            $CommonMobile_txnObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonMobile_txnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            
            
            $supplier_cmn_mb_txn_Obj->setRecordActiveFlag(0); 
            $supplier_cmn_mb_txn_Obj->setRecordInsertDate(new \Datetime());
            $supplier_cmn_mb_txn_Obj->setApplicationUserId($this->session->get('EMPID'));
            $supplier_cmn_mb_txn_Obj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
             
            $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
       }
        return array('msg' => 'Contact Details Deleted Sucessfully',
            'result' => $this->commonService->getRecordsByArray
            (SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT,array('recordActiveFlag' => 1))
        );
        
        
    }
    
    //Mobile No List Section ends here
    
    
     //Delete supplier bank details section
    public function DeleteSupplierDetailsMaster($request,$supid) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
//             $dataUI = json_decode($request->getContent());
//            
//            //delete record for bank master
//           
//            //ends here
//            
//             //delete record for address
//             
//             //ends here
//             
//             
//             
//            //deleting record for supplier bank-txn details master
//            $common_bank_txnObj=$this->em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->findOneBy(array('bankFk'=>$bankid));
//            $common_bank_txnObj->setRecordActiveFlag(0); 
//            $common_bank_txnObj->setRecordInsertDate(new \Datetime());
//            $this->em->flush();
//            //ends here
//            
//            
//            //deleting record for supplier bank details master
//            $CommonBankObj=$this->em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_BANKDETAIL_MASTER)->find($bankid);
//            $CommonBankObj->setRecordActiveFlag(0); 
//            $CommonBankObj->setRecordInsertDate(new \Datetime()); 
//            $this->em->flush();
//            //ends here
//            
//           $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
//           $conn->rollback();
//           $this->em->close();
//           throw new \Exception($ex->getMessage());
       }
//       return array('msg' => 'Bank Details Deleted Sucessfully',
//            'result' => $this->em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->
//            findBy(array('supplierFk' => $Supid, 'recordActiveFlag' => 1)),
//            'bankid' => $CommonBankObj->getBankPk()
//        );
        
        
    }
    
    //Delete supplier bank details section ends here
    
    
    
    
    
    
    //Searching Record from database
   
    public function getsupplierMobileNodetails($supid) {
      
        try 
        {   
                $CommonSupContact_person_txnObj = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk' => $supid));
                $sup_contact_pk = $CommonSupContact_person_txnObj->getSuppContactPk();

                $cmn_mb_Obj = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->findBy(array('supContactFk' => $sup_contact_pk, 'recordActiveFlag' => 1));
                
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
         
        return array('sup_contactperson'=>$CommonSupContact_person_txnObj,'cmn_mobile'=>$cmn_mb_Obj) ;
    }
    
    
    
    
     //Searching Record from database
   
    public function getsupplierMobiledetails($supid) {
      
        try 
        {  
         $CommonSupContact_person_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk'=>$supid)); 
         $sup_contact_pk=$CommonSupContact_person_txnObj->getSuppContactPk();
         
         
         $sup_email=$CommonSupContact_person_txnObj->getPersonFk()->getEmailId();
         $sup_website=$CommonSupContact_person_txnObj->getSupplierFk()->getWebsite();
         $cmn_person_phone=$CommonSupContact_person_txnObj->getPersonFk()->getTelephoneNo();
         
         
         
         $cmn_mb_Obj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->findBy(array('supContactFk'=>$sup_contact_pk,'recordActiveFlag'=>1));
           
           
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('sup_contactperson'=>$CommonSupContact_person_txnObj,
         'cmn_mobile'=>$cmn_mb_Obj,
         'telephone'=>$cmn_person_phone,       
         'email'=>$sup_email,       
         'website'=>$sup_website       
                
        );
    }
    
    
    
    
      public function getsupplierBankDetails($supid) {
      
        try 
        {   
            
            
            $CommonSupBank_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANK_TXN)->findBy(array('supplierFk'=>$supid,'recordActiveFlag'=>1)); 
           // $Sup_Bank_pk=$CommonSupBank_txnObj[0]->getSuppBankPk();
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
         
        return array('bankdetail'=>$CommonSupBank_txnObj);
    }
    
    
     public function getTransportdetails($tid) {
      
        try 
        {  
         $TransportObj=$this->em->getRepository(SupplierConstant::ENT_SUP_TRANSPORT)->findOneBy(array('pkid'=>$tid)); 
         $trans_pk=$TransportObj->getPkid();
         $trans=$TransportObj->getName();
         $description=$TransportObj->getDescription();
        }
        catch (\Exception $ex) 
        {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        ('id'=>$trans_pk,
         'trasn'=>$trans,
         'descrp'=>$description
        );
    }
    
     public function retrievesupplierBankDetails($bankid) {
      
        try 
        {   $CommonBank_Obj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_BANKDETAIL_MASTER)->findOneBy(array('bankPk'=>$bankid)); 
            
            $bankid=$CommonBank_Obj->getBankPk();
            $name=$CommonBank_Obj->getBankName();
            $branch=$CommonBank_Obj->getBranchName();
            $branch_code=$CommonBank_Obj->getBranchCode();
            $account_type=$CommonBank_Obj->getAccountTypeMasterFk()->getBankAccTypePk();
            $micr=$CommonBank_Obj->getMicrCode();
            $ifsc=$CommonBank_Obj->getIfscCode();
            $contact=$CommonBank_Obj->getContactNumber();
            $location=$CommonBank_Obj->getLocation();
            $accountno=$CommonBank_Obj->getAccountNumber();
           
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
         
        return array
        (
         'name'=>$name,
         'branch'=>$branch,
         'branch_code'=>$branch_code,       
         'account_type'=>$account_type,     
         'micr'=>$micr,     
         'ifsc'=>$ifsc,
         'contact'=>$contact,
         'location'=>$location ,
         'bankid'=>$bankid,
         'account_no'=>$accountno
        );
    }
    
    
    
    
      public function searchSupplierDetails($request) 
      {
      
        try 
        {  
           $dataUI = json_decode($request->getContent());
           $supname=$dataUI->supname;
           $person_name=$dataUI->person;
           $mobile_no=$dataUI->mobile;
           
           if($supname=='')
           {}
           else
           {
              $parameters = array();
              $queryString = " SELECT suptxn
                             FROM TashiCommonBundle:SupplierContactTxn suptxn 
                             
                             INNER JOIN TashiCommonBundle:SupplierMaster sup
                             WITH suptxn.supplierFk=sup.supplierPk
                             
                             INNER JOIN TashiCommonBundle:CmnPerson cmn
                             WITH suptxn.personFk=cmn.personPk
                              
                             WHERE sup.recordActiveFlag=:activFlag and sup.companyName = '$supname' ";
           
            $parameters['activFlag'] = 1;  
           }
           
           if($person_name=='')
           {
               
           }
           else
           {
              $parameters = array();
              $queryString = " SELECT suptxn
                             FROM TashiCommonBundle:SupplierContactTxn suptxn 
                             
                             INNER JOIN TashiCommonBundle:SupplierMaster sup
                             WITH suptxn.supplierFk=sup.supplierPk
                             
                             INNER JOIN TashiCommonBundle:CmnPerson cmn
                             WITH suptxn.personFk=cmn.personPk
                             
                             WHERE suptxn.recordActiveFlag=:activFlag and cmn.firstName = '$person_name' ";
           
            $parameters['activFlag'] = 1;   
           }
           
           if($mobile_no=='')
           {
               
           }
           else
           {
              $parameters = array();
              $queryString = "SELECT suptxn 
                             FROM TashiCommonBundle:SupplierContactTxn suptxn 
                             
                             INNER JOIN TashiCommonBundle:SupplierMaster sup
                             WITH suptxn.supplierFk=sup.supplierPk
                             
                             INNER JOIN TashiCommonBundle:SupplierContactMobileNoTxn sct
                             WITH sct.supContactFk=suptxn.suppContactPk
                             
                             INNER JOIN TashiCommonBundle:CmnMobileNoMaster mob
                             WITH sct.mobileMasterFk=mob.pkid
                             
                             WHERE suptxn.recordActiveFlag=:activFlag and mob.mobileNo='$mobile_no'";
           
            $parameters['activFlag'] = 1;   
           }
           
           if($supname =='' && $person_name =='' && $mobile_no =='')
           {
           $parameters = array();
           $queryString = "  SELECT suptxn  
                             FROM TashiCommonBundle:SupplierContactTxn suptxn  
                             
                             INNER JOIN TashiCommonBundle:SupplierMaster sup
                             WITH suptxn.supplierFk=sup.supplierPk
                             
                             INNER JOIN TashiCommonBundle:CmnPerson p
                             WITH suptxn.personFk=p.personPk
                             
                             WHERE suptxn.recordActiveFlag=:activFlag ";
           
           $parameters['activFlag'] = 1;  
          
           }
            $contact_txn = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->findByrecordActiveFlag(1);
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
       }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
         
        return array('result'=>$resultSearch,'result1'=>$contact_txn);
        
    }
    
    
    
     public function newsaveAddressDetails($request) {
        //$addressTypeId = $request->request->get('addressTypeId');
        
        $dataUI = json_decode($request->getContent());
        $supid=$dataUI->supid;
         
        $addmasterId=$dataUI->inputmasterAddId;
        $addtxnId= $dataUI->inputAddTxnId;
        //$custid=$dataUI->inputAddAddresscustId;
        $addCode=$dataUI->addCode;
        $primayStatus=$dataUI->inputisPrimaryAdd;
        $address1 = $dataUI->address1;
        $address2 = $dataUI->address2;
        $country =$dataUI->country;
        $state =$dataUI->state;
        $city =$dataUI->city;
        $district = $dataUI->district;
        //$route =$dataUI->route;
        //$locality =$dataUI->locality;
        $block = $dataUI->block;
        $postOffice =$dataUI->postOffice;
        $policeStation =$dataUI->policeStation;
        $zipcode = $dataUI->zipcode;
       // $landmark =$dataUI->landmark;
        //$gpsLatitude = $dataUI->gpsLatitude;
        //$gpsLongitude = $dataUI->gpsLongitude;
        
        
        
        
        //$recodeActiveFlag = $request->request->get('rec_status');
        $conn=$this->em->getConnection();
        try {
            $conn->beginTransaction();
            if ($addmasterId) {
                $address = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addmasterId);
                $address->setRecordUpdateDate(new \DateTime('now'));
                $address->setApplicationUserId($this->session->get('EMPID'));
                $address->setApplicationUserIpAddress($this->session->get('IP'));
            }
            else{
                $address = new CmnLocationAddressMaster();
                $address->setRecordInsertDate(new \DateTime('now'));
                $address->setApplicationUserId($this->session->get('EMPID'));
                $address->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $address->setAddressTypeFk($this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find(1));
            $address->setAddress1($address1);
            $address->setAddress2($address2);
            $address->setCityName($city);
            $address->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city));
            
            if ($state != '') {
                $address->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state));
            }
            if ($country != '') {
                $address->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country));
            }
            $address->setPinNumber($zipcode);
            $address->setPoliceStation($policeStation);
            $address->setPostOffice($postOffice);
            //$address->setGpsLatitude($gpsLatitude);
           // $address->setGpsLogitude($gpsLongitude);
            //$address->setLandmark($landmark);
            if ($district != '') {
                $address->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district));
            }
            //$address->setRoute($route);
            //$address->setLocality($locality);
            $address->setBlockVillage($block);
            $address->setRecordActiveFlag(1);
            if (!$addmasterId){
                $this->em->persist($address);
            }
            $this->em->flush();
            //address txn
            //if the new address is primary then set other existing address to value 0(non-primary)
            
            if($primayStatus==1){
                $exAddTxn=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBySupplierFk($supid);                
                foreach($exAddTxn as $addtxn){
                    $addtxn->setIsPrimaryAddress(0);
                    $this->em->flush();
                }
            }
            else{
                
            }
            //add/update the new/existing address
            if ($addtxnId) {
                $addressTxn = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->find($addtxnId);
                $addressTxn->setRecordUpdateDate(new \DateTime("now"));
                $addressTxn->setApplicationUserId($this->session->get('EMPID'));
                $addressTxn->setApplicationUserIpAddress($this->session->get('IP'));
            }
            else{
                $addressTxn = new SupplierAddressTxn();
                $addressTxn->setAddressFk($address);
                $addressTxn->setSupplierFk($this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid));
                $addressTxn->setRecordInsertDate(new \DateTime("now"));
                $addressTxn->setApplicationUserId($this->session->get('EMPID'));
                $addressTxn->setApplicationUserIpAddress($this->session->get('IP'));
            }   
            $addressTxn->setAddressCode($addCode);
            $addressTxn->setIsPrimaryAddress($primayStatus);
            $addressTxn->setApprovalFlag(1);
            $addressTxn->setRecordActiveFlag(1);
            if (!$addtxnId) {                
                $this->em->persist($addressTxn);
            }
            $this->em->flush();
            $returncode=1;//1 for successfull operation and O for failed orperation
            $returnmsg=$addressTxn;
            $conn->commit();
        }
        catch (\Doctrine\DBAL\DBALException $dbalex){
            $conn->rollBack();
            $returncode=0;
            $returnmsg='Duplicate Address Code';
            if($this->cmnservice->isDuplicateEntry($dbalex,'Unique_AddCode')){
                $returnmsg='Address Code is already in use by the same customer.';
            }            
        }
        catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg='Unable to complete action due to technical error. Error: '.$ex->getMessage();            
        }
        //$conn->close();
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
   
    
    
    public function SupDeleteAddress($addtxnid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $addtxn=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->find($addtxnid);
            $addmaster=$addtxn->getAddressFk();
            //update address master
            $addmaster->setRecordActiveFlag(0);
            $addmaster->setRecordUpdateDate(new \DateTime("now"));
            $addmaster->setApplicationUserId($this->session->get('EMPID'));
            $addmaster->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //update address txn
            $addtxn->setApprovalFlag(0);
            $addtxn->setRecordActiveFlag(0);
            $addtxn->setRecordUpdateDate(new \DateTime("now"));
            $addtxn->setApplicationUserId($this->session->get('EMPID'));
            $addtxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit();
            $returnmsg='Address has been removed successfully.';
            $returncode=1;
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
            $returncode=0;
        }
        $conn->close();
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
    
      public function DeleteSupplier($supid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $supplier=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid);
            $conTxn=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findBysupplierFk($supplier);
            $conmobTxn=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->findBysupContactFk($conTxn);
            $conadressTxn=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBysupplierFk($supplier);
            if($conTxn){
                //delete corresponding Contact Txn and Contact                
                foreach ($conTxn as $cont){
                    $cont->setApprovalFlag(0);
                    $cont->setRecordActiveFlag(0);
                    $person=$cont->getPersonFk();
                    $person->setRecordActiveFlag(0);
                }                
            }
            
            if($conadressTxn)
            {
                //delete corresponding address Txn and CommonLocationAddress                
                foreach ($conadressTxn as $conaddrs){
                    $conaddrs->setApprovalFlag(0);
                    $conaddrs->setRecordActiveFlag(0);
                    
                    $address=$conaddrs->getAddressFk();
                    $address->setRecordActiveFlag(0);
                }                
            }
            
            
            if($conmobTxn){
                //Delete Contact_Mobile_Txn and Mobile Number
                foreach($conmobTxn as $cmob){
                    $cmob->setApprovalFlag(0);
                    $cmob->setRecordActiveFlag(0);
                     
                    $mobile=$cmob->getMobileMasterFk() ;
                    
                    $mobile->setApprovalFlag(0);
                    $mobile->setRecordActiveFlag(0);
                }
                
            }
            //$supplier->setStatusFlag(0);
            $supplier->setRecordActiveFlag(0);
            
            $this->em->flush();
            $conn->commit();
            $returncode=1;
            $returnmsg='Supplier and other related detail has been deleted successfully';            
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
     
//      public function getSupplierPersonDetails($request) {
//      
//        try {
//           
//            $dataUI = json_decode($request->getContent());
//            $supid=$dataUI->supid; 
//            
//            $SupContactTxnObj=$this->em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->find($supid); 
//            }
//        catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//         
//        return array('supdetail'=>$SupContactTxnObj);
//    }
    
    
    
    
    
    
      public function addTransportMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            $dataUI = json_decode($request->getContent());
            
            //inserting record for supplier master
            $bank=$dataUI->transporter;
            $desc=$dataUI->description;
            
            //inserting record for supplier bank details
            $TransportObj=new TransporterMaster();
            $TransportObj->setName($bank);
            $TransportObj->setDescription($desc);
            $TransportObj->setRecordActiveFlag(1); 
            $TransportObj->setRecordInsertDate(new \Datetime()); 
            $TransportObj->setApplicationUserId($this->session->get('EMPID'));
            $TransportObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($TransportObj);
            $this->em->flush();
            //ends here
            
            $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        
      
        return array('msg' => 'Record Save Sucessfully',
            'result'=>$this->commonService->activeList('TransporterMaster'),
            'id' =>$TransportObj->getPkid()
        );
        
        
    }
    
    
    
     public function updateTransportMaster($request) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            $dataUI = json_decode($request->getContent());
            $bank=$dataUI->transporter;
            $desc=$dataUI->description;
            $tid = $dataUI->tid;
            $TransportObj=$this->em->getRepository(SupplierConstant::ENT_SUP_TRANSPORT)->findOneBy(array('pkid'=>$tid,'recordActiveFlag'=>1));
            //updating record for transport details
            $TransportObj->setName($bank);
            $TransportObj->setDescription($desc);
            $TransportObj->setRecordActiveFlag(1); 
            $TransportObj->setRecordUpdateDate(new \Datetime());
            $TransportObj->setApplicationUserId($this->session->get('EMPID'));
            $TransportObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            
            $conn->commit();
          } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
            
        }
        return array('msg' => 'Record Update Sucessfully',
                    'result'=>$this->commonService->activeList('TransporterMaster'),
                    'id' =>$TransportObj->getPkid()
                    );
        
        
    }
    
     public function deleteTransportMaster($tid) {
            $conn = $this->em->getConnection();
            $conn->beginTransaction(); //suspend auto-commit
            //auto-commit
        try {
            
            
            
            $TransportObj=$this->em->getRepository(SupplierConstant::ENT_SUP_TRANSPORT)->findOneBy(array('pkid'=>$tid,'recordActiveFlag'=>1));
            //deleting record for transport details
            $TransportObj->setRecordActiveFlag(0); 
            $TransportObj->setStatusDate(new \Datetime()); 
            $TransportObj->setApplicationUserId($this->session->get('EMPID'));
            $TransportObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            $conn->commit();
            
            
       } catch (\Exception $ex) 
       { 
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());            
        }      
        return array('msg' => 'Record Update Sucessfully',
                    'result'=>$this->commonService->activeList('TransporterMaster'),
                    'id' =>$TransportObj->getPkid()
                    );     
    }
    
    
     public function SendSupplierSMS($request){
        $dataUI=  json_decode($request->getContent());
        $mobnosui=$dataUI->inputMobNos;
        $custidui=$dataUI->inputSmscustid;
        $contidui=$dataUI->inputSmscontid;
        $subject=$dataUI->txtSubject;
        $message=$dataUI->txtSmsMessage;
        $uniquesmsids=array();
        $errCount=0;
        $successCount=0;
        if(is_array($mobnosui)){
            for($i=0;$i<count($mobnosui);$i++){
                $conn=$this->em->getConnection();
                $conn->beginTransaction();
                try{
                    $comMaster=new CmnCommunicationMessageMaster();
                    $comTxn=new CmnSupplierCommunicationTxn();
                    $comsupid=$this->em->getRepository('TashiCommonBundle:SupplierMaster')->find($custidui[$i]);
                    $contact=$this->em->getRepository('TashiCommonBundle:SupplierContactTxn')->find($contidui[$i]);
                    $comMaster->setCommunicationType('SMS');
                    $comMaster->setMessageContent($message);
                    $comMaster->setApprovalFlag(1);
                    $comMaster->setRecordActiveFlag(1);
                    $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                    $comMaster->setApplicationUserId($this->session->get('EMPID'));
                    $comMaster->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($comMaster);
                    $this->em->flush();

                    $comTxn->setMessageFk($comMaster);
                    $comTxn->setSupidFk($comsupid);
                    $comTxn->setContactFk($contact);
                    $comTxn->setSentDatetime(new \DateTime("NOW"));
                    $comTxn->setStatus(0);
                    $comTxn->setApprovalFlag(1);
                    $comTxn->setRecordActiveFlag(1);
                    $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                    $comTxn->setApplicationUserId($this->session->get('EMPID'));
                    $comTxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($comTxn);
                    $this->em->flush();
                    $smsid=$this->ReplyMessage($message,$mobnosui[$i]);
                    if($smsid!=null){
                        $comTxn->setUniqueSmsId($smsid);
                        $this->em->flush(); 
                        //array_push($uniquesmsids, $smsid);
                        $conn->commit();   
                        $successCount++;
                    }
                    else{    
                        $errCount++;
                    }

                } catch (Exception $ex) {
                    $conn->rollBack(); 
                    $errCount++;
                }                
            }
            if($successCount>0 && $errCount<=0){
                $returncode=1;
                $returnmsg='SMS has been sent to all the numbers successfully.';
            }
            elseif($successCount>0 && $errCount>0){
                $returncode=1;
                $returnmsg='Not all SMS were sent only few were sent.';
            }
            elseif($successCount<=0 && $errCount>0){
                $returncode=1;
                $returnmsg='Could not sent SMS. Please check your internet connectivity and try again.';
            }
        }
        else{
            $conn=$this->em->getConnection();
            $conn->beginTransaction();
            try{
                $comMaster=new CmnCommunicationMessageMaster();
                $comTxn=new CmnSupplierCommunicationTxn();
                $comsupid=$this->em->getRepository('TashiCommonBundle:SupplierMaster')->find($custidui);
                $contact=$this->em->getRepository('TashiCommonBundle:SupplierContactTxn')->find($contidui);
                $comMaster->setCommunicationType('SMS');
                $comMaster->setMessageSubject($subject);
                $comMaster->setMessageContent($message);
                $comMaster->setApprovalFlag(1);
                $comMaster->setRecordActiveFlag(1);
                $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                $comMaster->setApplicationUserId($this->session->get('EMPID'));
                $comMaster->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($comMaster);
                $this->em->flush();
                
                $comTxn->setMessageFk($comMaster);
                $comTxn->setSupidFk($comsupid);
                $comTxn->setContactFk($contact);
                $comTxn->setSentDatetime(new \DateTime("NOW"));
                $comTxn->setStatus(0);
                $comTxn->setApprovalFlag(1);
                $comTxn->setRecordActiveFlag(1);
                $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                $comTxn->setApplicationUserId($this->session->get('EMPID'));
                $comTxn->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($comTxn);
                $this->em->flush();
                $smsid=$this->ReplyMessage($message,$mobnosui);
                if($smsid!=null){
                    $comTxn->setUniqueSmsId($smsid);
                    $this->em->flush();
//                    if($this->CheckDelivery($smsid)){
//                        $comTxn->setStatus(1);
//                        $this->em->flush();
//                    }  
                    //array_push($uniquesmsids, $smsid);
                    $conn->commit();
                    $returncode=1;
                    $returnmsg='SMS has been sent successfully';
                }
                else{
                    $returncode=0;
                    $returnmsg='Could not sent SMS. Please make sure you are connected to internet and you have enough balance in your account and try again.';
                }
                
            } catch (Exception $ex) {
                $conn->rollBack();
                $returncode=0;
                $returnmsg='Could not sent SMS.Error: '.$ex->getMessage();
            }
            //UPDATE DELIVERY STATUS
//            if(count($uniquesmsids)>0){
//                foreach($uniquesmsids as $smsid){
//                    $comtxn=$this->em->getRepository('TashiCommonBundle:CmnCommunicationTxn')->findByUniqueSmsId($smsid)[0];
//                    if($comMaster){
//                     $comtxn->setStatus(1);
//                     $this->em->flush();
//                    }                        
//                }
//            }
        }
        return array('code'=>$returncode,'msg'=>$returnmsg,'smsid'=>$smsid);
    }
    
    
     public function ReplyMessage($msg,$sendto){
        try
        {
            $msg=  str_replace('.','%2E',$msg);
            $msg=  str_replace('\'','%27',$msg);
            $url='http://login.smsgatewayhub.com/smsapi/pushsms.aspx?user=kangla&pwd=kangla123&to='.$sendto.'&sid=NESDET&msg='.$msg.'&fl=0&gwid=2';
            $response = file_get_contents(str_replace(' ','%20',$url));                
            return $response; 
        }
        catch(\Exception $ex){
            return null;
        }
    }
    
     public function SendSupplierEmail($request)
   {
        $dataUI=  json_decode($request->getContent());
        $emailui=$dataUI->inputEmails;
        $supidui=$dataUI->inputSmscustid;
        $contidui=$dataUI->inputSmscontid;
        $subject=$dataUI->txtSubject;
        $actualMsg=$dataUI->txtareaEmail;
        
        $errCount=0;
        $successCount=0;
        if(is_array($emailui)){
            for($i=0;$i<count($emailui);$i++){
                $conn=$this->em->getConnection();
                $conn->beginTransaction();
                try{
                    $comMaster=new CmnCommunicationMessageMaster();
                    $comTxn=new CmnSupplierCommunicationTxn();
                    $supplier=$this->em->getRepository('TashiCommonBundle:SupplierMaster')->find($supidui[$i]);
                    $contact=$this->em->getRepository('TashiCommonBundle:SupplierContactTxn')->find($contidui[$i]);
                    $comMaster->setCommunicationType('EMAIL');
                    $comMaster->setMessageContent($actualMsg);
                    $comMaster->setApprovalFlag(1);
                    $comMaster->setRecordActiveFlag(1);
                    $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                    $comMaster->setApplicationUserId($this->session->get('EMPID'));
                    $comMaster->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($comMaster);
                    $this->em->flush();

                    $comTxn->setMessageFk($comMaster);
                    $comTxn->setSupidFk($supplier);
                    $comTxn->setContactFk($contact);
                    $comTxn->setSentDatetime(new \DateTime("NOW"));
                    $comTxn->setStatus(0);
                    $comTxn->setApprovalFlag(1);
                    $comTxn->setRecordActiveFlag(1);
                    $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                    $comTxn->setApplicationUserId($this->session->get('EMPID'));
                    $comTxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($comTxn);
                    $this->em->flush();
                    if($this->SendingMail($actualMsg,$subject,$emailui[$i])){
                        $comTxn->setStatus(1);
                        $this->em->flush(); 
                        //array_push($uniquesmsids, $smsid);
                        $conn->commit();   
                        $successCount++;
                    }
                    else{    
                        $errCount++;
                    }
                } catch (Exception $ex) {
                    $conn->rollBack(); 
                    $errCount++;
                }                
            }
            if($successCount>0 && $errCount<=0){
                $returncode=1;
                $returnmsg='Email has been sent successfully.';
            }
            elseif($successCount>0 && $errCount>0){
                $returncode=1;
                $returnmsg='Not all Email were sent only few were sent.';
            }
            elseif($successCount<=0 && $errCount>0){
                $returncode=1;
                $returnmsg='Could not sent Email. Please check your internet connectivity and try again.';
            }
        }
        else{
            $conn=$this->em->getConnection();
            $conn->beginTransaction();
            try{
                $comMaster=new CmnCommunicationMessageMaster();
                $comTxn=new CmnSupplierCommunicationTxn();
                $supplier=$this->em->getRepository('TashiCommonBundle:SupplierMaster')->find($supidui);
                $contact=$this->em->getRepository('TashiCommonBundle:SupplierContactTxn')->find($contidui);
                
                $comMaster->setCommunicationType('EMAIL');
                $comMaster->setMessageSubject($subject);
                $comMaster->setMessageContent($actualMsg);
                $comMaster->setApprovalFlag(1);
                $comMaster->setRecordActiveFlag(1);
                $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                $comMaster->setApplicationUserId($this->session->get('EMPID'));
                $comMaster->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($comMaster);
                $this->em->flush();
                
                $comTxn->setMessageFk($comMaster);
                $comTxn->setSupidFk($supplier);
                $comTxn->setContactFk($contact);
                $comTxn->setSentDatetime(new \DateTime("NOW"));
                $comTxn->setStatus(0);
                $comTxn->setApprovalFlag(1);
                $comTxn->setRecordActiveFlag(1);
                $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                $comTxn->setApplicationUserId($this->session->get('EMPID'));
                $comTxn->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($comTxn);
                $this->em->flush();                
                if($this->SendingMail($actualMsg,$subject,$emailui)){
                    $comTxn->setStatus(1);
                    $this->em->flush();
                    $conn->commit();
                    $returncode=1;
                    $returnmsg='Email has been sent successfully';
                }
                else{
                    $returncode=0;
                    $returnmsg='Email was not sent.';
                }
                
            } catch (Exception $ex) {
                $conn->rollBack();
                $returncode=0;
                $returnmsg='Could not sent Email.Error: '.$ex->getMessage();
            }
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
    
    public function SendingMail($msg,$subject,$recipient){
        try{
            $env = new \Twig_Environment(new \Twig_Loader_String());
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('apak@cobigent.com','KANGLA')
                ->setTo($recipient)
                ->setBody($env->render('{{msg}}',array('msg'=>$msg)));
            $send=$this->mailer->send($message);
            
            return true;
        }
        catch(\Swift_TransportException $se){
            return false;
        }
        catch (Exception $ex){
            return false;
        }        
    }
    
    public function UpdateBulkSmsStatus($supid){
        try{
            $comtxn=$this->em->getRepository('TashiCommonBundle:CmnSupplierCommunicationTxn')->
                        findBy(array('supidFk'=>$supid,'approvalFlag'=>1,'recordActiveFlag'=>1,'status'=>0));
            if($comtxn){
                foreach($comtxn as $com){
                    $smsuniqueid=$com->getUniqueSmsId();
                    if($this->CheckDeliveryStatus($smsuniqueid)){
                        $com->setStatus(1);
                        $this->em->flush();
                    }
                }
            } 
       }catch (Exception $ex) {           
       }
       //return $comtxn;
    }
    
    
    public function CheckDeliveryStatus($smsid){
        try{
            $url='https://api.smsgatewayhub.com/smsapi/checkdelivery.aspx?user=kangla&password=kangla123&messageid='.$smsid;    
            if(file_get_contents($url)=='#DELIVRD'){
                return true;
            }
            else{
                return false;
            }
        }catch(\Exception $ex){
            return false;
        }
    }
    
    
   public function addUpdateSupTransportor($request) {
       
       $conn=$this->em->getConnection();
            $conn->beginTransaction();
       try 
       { 
            $dataUI = json_decode($request->getContent());
            $tranportName = $dataUI->transport_name;
            $contactperson = $dataUI->contactperson;
            $address = $dataUI->address;
            $about = $dataUI->about;
            $pincode = $dataUI->pincode;
            $transportId = $dataUI->transportId;
            
            $mobile_no = array();
              if (is_string($dataUI->txt_mobile)) {
                $mobile_no[0] = $dataUI->txt_mobile; //for only one 
              } else {
                $mobile_no = $dataUI->txt_mobile;     //for more than one       
              }
              
            
              //inserting and updating new transport details record.
            if ($transportId == "") {
                $transportorObj = new TransporterMaster();
                
            } else {
                $transportorObj = $this->em->getRepository(SupplierConstant::ENT_SUP_TRANSPORT)->find($transportId);
            }
            
            $transportorObj->setName($tranportName);
            $transportorObj->setContactPerson($contactperson);
            $transportorObj->setAddress($address);
            $transportorObj->setAbout($about);
            $transportorObj->setPincode($pincode);
            $transportorObj->setRecordActiveFlag(1);
            
            if ($transportId == ""){
                $transportorObj->setRecordInsertDate(new \Datetime());
            } else {
                $transportorObj->setRecordUpdateDate(new \Datetime());
            }
            
            
            //for inserting ip address , user id
            $transportorObj->setApplicationUserId($this->session->get('EMPID'));
            $transportorObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($transportorObj);
            $this->em->flush();
            
            
            
            //for inserting new mobile master and transport mobile txn 
            if ($dataUI->txt_mobile == '') {
                //do nothing
            } else {
                    foreach ($mobile_no as $val) {   // for inserting array value
                    $CommonMobileObj = new CmnMobileNoMaster();
                    $CommonMobileObj->setMobileNo($val);
                    $CommonMobileObj->setRecordActiveFlag(1);
                    $CommonMobileObj->setRecordInsertDate(new \Datetime('NOW'));
                    $CommonMobileObj->setApplicationUserId($this->session->get('EMPID'));
                    $CommonMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($CommonMobileObj);
                    $this->em->flush();
                    //---------------for inserting mutiple mobile transaction---------------------
                    $transportmobiletxnObj = new TransporterMobileTxn();
                    $transportmobiletxnObj->setMobileFk($CommonMobileObj);
                    $transportmobiletxnObj->setTransporterFk($transportorObj);
                    $transportmobiletxnObj->setRecordInsertDate(new \Datetime());
                    $transportmobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                    $transportmobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $transportmobiletxnObj->setRecordActiveFlag(1);
                    $transportmobiletxnObj->setRecordInsertDate(new \Datetime());
                    $this->em->persist($transportmobiletxnObj);
                    $this->em->flush();
                    //-------------------------ends here-----------------------------
                }
            }
             //inserting into transporter txn and master ends here 
            
            if ($transportId == "") {
                $msg = 'Record Saved Sucessfully!';
            } else {
                $msg = 'Updated Record Sucessfully!';
            }
            //ends here
           $conn->commit();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('TransporterMaster')
        );
    }  
    
    
     public function retrieveTransportor($transportId) {
        try {
            $transportObj = $this->em->getRepository(SupplierConstant::ENT_SUP_TRANSPORT)->find($transportId);
            $return = array(
                'transportId' => $transportId,
                'transport_name' => $transportObj->getName(),
                'pincode' => $transportObj->getPincode() ,
                'address' => $transportObj->getAddress(),
                'person' => $transportObj->getContactPerson(),
                'about' => $transportObj->getAbout());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
    public function deleteTransportsMaster($transportId) {
            $conn=$this->em->getConnection();
            $conn->beginTransaction();
        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:TransporterMaster')->find($transportId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
             
            $trasnport_txn = $this->em->getRepository(SupplierConstant::ENT_TransportMobileTxn)->findBy(array('transporterFk'=>$transportId,'recordActiveFlag'=>1)); 
            
            foreach($trasnport_txn as $val)
            {
                 $mobiletxnpk=$val->getPkid();
                 // echo $mobiletxnpk;die();
                 $mobiletxnObj=$this->em->getRepository(SupplierConstant::ENT_TransportMobileTxn)->find($mobiletxnpk); 
                 
                 $mobiletxnObj->setRecordActiveFlag(0); 
                 $mobiletxnObj->setRecordInsertDate(new \Datetime());
                 $mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                 $mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                 $this->em->flush();
                 
                 $mob_id =  $val->getMobileFk()->getPkid();
               
                $CommonMobile_txnObj=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT)->find($mob_id); 
                //deleting record for supplier contact_txn details master
                $CommonMobile_txnObj->setRecordActiveFlag(0); 
                $CommonMobile_txnObj->setRecordInsertDate(new \Datetime());
                $CommonMobile_txnObj->setApplicationUserId($this->session->get('EMPID'));
                $CommonMobile_txnObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
             }
           //ends here
            
            $conn->commit();
            
            
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('TransporterMaster'),
            'id' => $ACidObj->getPkid());
    }
    
}
    
    

