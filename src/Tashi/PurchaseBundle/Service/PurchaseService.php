<?php

namespace Tashi\PurchaseBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\PurchaseBundle\Helper\PurchaseConstant;
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\CompanyMaster;
use Tashi\CommonBundle\Entity\PoMaster;
use Tashi\CommonBundle\Entity\PoStatusTxn;
use Tashi\CommonBundle\Entity\PoProductDetails;
use Tashi\CommonBundle\Entity\CompanyAddressTxn;
use Tashi\CommonBundle\Entity\CmnPerson;
use Tashi\CommonBundle\Entity\SupplierMaster;
use Tashi\CommonBundle\Entity\SupplierAddressTxn;
use Tashi\CommonBundle\Entity\SupplierContactTxn;
use Tashi\CommonBundle\Entity\CompanyContactTxn;
use Tashi\CommonBundle\Entity\CmnLocationAddressMaster;
use Tashi\CommonBundle\Entity\CompanyContactMobileNoTxn;
use Tashi\CommonBundle\Entity\CmnMobileNoMaster;
use Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster;
use Tashi\CommonBundle\Entity\PoPaymentTxn;
use Tashi\CommonBundle\Entity\PoTransportTxn;
use Tashi\CommonBundle\Entity\TransporterMaster;
use Tashi\CommonBundle\Entity\TransportModeMaster;
use Tashi\CommonBundle\Entity\ProjectStatusTxn;
use Tashi\CommonBundle\Entity\AccountCashDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountCashCurrentBalance;
use Tashi\CommonBundle\Entity\AccountBankDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountDetailsMaster;

//use Tashi\CommonBundle\Entity\AssetCategoryMaster;
//use Tashi\CommonBundle\Entity\AssetRegister;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchaseService
 *
 * @author SANATOMBA
 */
class PurchaseService {

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

    public function searchAllShippingCompany() {
        try {

            //$address_txn = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_ADDRESS_TXN)->findBy(array('recordActiveFlag'=>1 ,'isPrimaryAddress'=>1));
            $address_txn = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_ADDRESS_TXN)->findBy(array('recordActiveFlag' => 1));
            //$contact_txn = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_MOBILE_TXN)->findByrecordActiveFlag(1);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('result' => $address_txn);
        //return array('result'=>$address_txn,'result1'=>$contact_txn);
    }

    public function searchAllSupplier() {
        try {
            $address_txn = $this->em->getRepository(PurchaseConstant::ENT_SUPPLIER_ADDRESS_TXN)->findBy(array('recordActiveFlag' => 1, 'isPrimaryAddress' => 1));
            $contact_txn = $this->em->getRepository(PurchaseConstant::ENT_SUPPLIER_MOBILE_TXN)->findByrecordActiveFlag(1);

            //  $id= $address_txn[0]->getSupplierFk()->getSupplierPk();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('result' => $address_txn, 'result1' => $contact_txn);
    }

    public function searchEMmployee() {
        try {
            $queryString = " SELECT emp   
                             
                          FROM TashiCommonBundle:EmpEmployeeMaster emp
                          
                          INNER JOIN TashiCommonBundle:CmnPerson person
                          WITH emp.personFk = person.personPk ";


            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('result' => $resultSearch);
    }

    public function getPOforApproval() {
        try {
            $podetails = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findPurchaseforApproval();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('result' => $podetails);
    }

    public function getProductDetailsCategory() {
        try {
            $podetails = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findPurchaseforApproval();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('result' => $podetails);
    }

    public function getProductUnit($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $PO = $dataUI->poid;

            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findProduct($PO);
//          echo $details[0]->getPkid();
//            die();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('result' => $details);
    }

    public function SearchAllPurchase() {

        try {
            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findPurchaseAll();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('allresult' => $details, 'msg' => 'Record found');
    }

    public function SearchByOrderNO($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $OrderNO = $dataUI->txtCriteria;


            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findbyOrderNO($OrderNO);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('allresult' => $details, 'msg' => 'Record found');
    }

    public function SearchByDate($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $sdate = $dataUI->txtfrom;
            $endate = $dataUI->todate;

            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findbyPODate($sdate, $endate);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('allresult' => $details, 'msg' => 'Record found');
    }

    public function SearchByExpDate($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $sdate = $dataUI->txtfrom;
            $endate = $dataUI->todate;

            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findbyExpDate($sdate, $endate);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('allresult' => $details, 'msg' => 'Record found');
    }

    public function SearchByStatus($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $statusid = $dataUI->selPurStatus;

            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findbyStatus($statusid);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('allresult' => $details, 'msg' => 'Record found');
    }
    
    
    public function SearchGroupByPurchaseOrderID() {

       try {
            $queryString = " SELECT sum(popayment.amount) amount , po.poPk poPk
                             FROM TashiCommonBundle:PoPaymentTxn popayment
                             JOIN  popayment.poFk po where po.dueFlag=0
                             GROUP BY popayment.poFk ";
            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }
    
    
    

    public function getAllDetails($POCode) {

        try {

            $details1 = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
            $details2 = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findPurchaseTxnbyID($POCode);


            // $details4 = $this->em->getRepository(PurchaseConstant::ENT_POProduct)->findByPoFk($POCode);
//          echo $proid=$details4[0]->getProductFk()->getPkid();
//          die();

            $potransport = $details1->getTransporterFk()->getPkid();
            $transmode = $details1->getTransportModeFk()->getPkid();
            $status = $details2[0]['s'];
            //$paymode=$details3->getPaymentModeFk()->getPkid();
            $cost = $details1->getTransportCost();
            $Emp = $details1->getPoFk()->getEmployeeFk()->getEmployeePk();
            //$amount=$details3->getAmount();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('msg' => 'Record found', 't' => $potransport, 'tm' => $transmode, 'st' => $status, 'cost' => $cost, 'eid' => $Emp);
    }

    public function searchbyPurchaseORderforproductdetails($poidpk) {
        try {
            $queryString = " SELECT sum(pro.amount)  amount
                            FROM TashiCommonBundle:PoPaymentTxn pro
                            Where pro.recordActiveFlag=1 and pro.poFk= $poidpk";
            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

     public function searchTotalAmount() {
        try {
            $queryString = " SELECT sum(pomaster.grandTotal)  amount
                            FROM TashiCommonBundle:PoMaster pomaster";
            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }
    
     public function searchTotalAmountfromPoPaymentTxn() {
        try {
            $queryString = " SELECT sum(popaymenttxn.amount) amount
                            FROM TashiCommonBundle:PoPaymentTxn popaymenttxn";
            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }
    
    public function findAllPOstatusMaster() {

        try {
            $queryString = " SELECT status 
                            FROM TashiCommonBundle:PoStatusMaster status 
                            WHERE status.pkid not in ('2','5') ";
            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    //------------------------------inserting POdetails master------------------------------
    function addPODetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            $productid = array();
            if (is_string($dataUI->pid)) {
                $productid[0] = $dataUI->pid; //for only one               
            } else {
                $productid = $dataUI->pid;     //for more than one       
            }
            $podate = $dataUI->podate;
            $expDelivereddate = $dataUI->expdeliverdate;
            $description = $dataUI->description;
            $subtotal = $dataUI->total;
            $taxamount = $dataUI->taxamount;
            $grandamount = $dataUI->grandtotal;
            $purby = $dataUI->purby;

            //getting supplier id and shipping id from javascript
            $supid = $dataUI->supid;
            $shippingid = $dataUI->comid;

            //
            //setting foreign key object for supplier contact txn and supplier object
            $SupplierObj = $this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
            $EmployeeObj = $this->em->getRepository(PurchaseConstant::ENT_EMP)->find($purby);
            $SuppliercontactObj = $this->em->getRepository(PurchaseConstant::ENT_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk' => $supid, 'recordActiveFlag' => 1));
            //
            //setting foreign key object for shipping contact txn and shiiping address obj
            //$ShippingContactObj=$this->em->getRepository(PurchaseConstant::ENT_COMPANY_MASTER)->findOneBy(array('companyFk'=>$shippingid));
            $ShippingAdreesObj = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_ADDRESS_TXN)->findOneBy(array('companyFk' => $shippingid, 'recordActiveFlag' => 1));
            $apkid = $ShippingAdreesObj->getPkid();
            $AdreesObj = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_ADDRESS_TXN)->find($apkid);
            //
            //setting foreign key object for postatus master

            $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(1);
            //
            //--------------------------inserting record into POMaster------------------------------------
            $POMasterObj = new PoMaster();
            $POMasterObj->setVendorMasterFk($SupplierObj);
            $POMasterObj->setVendorContactFk($SuppliercontactObj);
            //$POMasterObj->setContactFk($ShippingContactObj);
            $POMasterObj->setCompanyAddressFk($AdreesObj);
            $POMasterObj->setStatusFk($POStatusMasterObj);
            $POMasterObj->setEmployeeFk($EmployeeObj);

            //Auto generate  UI_PO-NO
            $queryString = "SELECT  po.uiOrderId uiID
                               FROM TashiCommonBundle:PoMaster po  
                               where po.poPk=(SELECT MAX(p.poPk) FROM TashiCommonBundle:PoMaster p) ";

            $query = $this->em->createQuery($queryString);
            $result = $query->getResult();
            if ($result) {
                $po = $result[0]['uiID'];

                $po_generate_ID = (int) substr($po, 2, strlen($po)) + 1;
            } else {
                $po_generate_ID = 1;
            }
            $po_ID = 'PO' . $po_generate_ID;

            $POMasterObj->setUiOrderId($po_ID);


            $POMasterObj->setRecordActiveFlag(1);
            $POMasterObj->setExpectedDelivery(new \Datetime($expDelivereddate));
            $POMasterObj->setOrderDate(new \Datetime($podate));
            $POMasterObj->setOrderDetails($description);
            $POMasterObj->setSubTotal($subtotal);
            $POMasterObj->setGrandTotal($grandamount);
            $POMasterObj->setTaxAmt($taxamount);
            $POMasterObj->setApprovalflag(0);
            $POMasterObj->setDueFlag(0);
            $POMasterObj->setRecordInsertDate(new \Datetime('NOW'));
            $POMasterObj->setRecordInsertDate(new \Datetime('NOW'));
            $POMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $POMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($POMasterObj);
            $this->em->flush();


//-------------------------------for inserting record into po_product_details table----------------------------------------------------
            // $check=0;
            foreach ($productid as $val) {

                $q = 'quantity' . $val;
                //$dq = 'deliverquantity' . $val;
                $p = 'totalprice' . $val;
                $u = 'unitid' . $val;
                $t = 'tax' . $val;
                $r = 'remarks' . $val;
                $c = 'txt_isrelated' . $val;
                $project = 'project' . $val;

                $proid = $val;
                $quoted = $dataUI->$p;
                $quantity = $dataUI->$q;
                $tax = $dataUI->$t;
                $remarks = $dataUI->$r;
                //$deliverquantity = $dataUI->$dq;
                $unit = $dataUI->$u;
                $check = $dataUI->$c;
                $projectpkid = $dataUI->$project;


//                if ($quantity >= $deliverquantity) {
//                    
//                } else {
//                    $returncode = 0;
//                    $returnmsg = "Delvery quantity must be equal or less than actual quantinty!";
//                    return array('msg' => $returnmsg, 'code' => $returncode);
//                }


                $ProObj = $this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                $UnitObj = $this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);
                $ProjectObj = $this->em->getRepository(PurchaseConstant::ENTITY_PROJECT)->find($projectpkid);
               
                $POProductDetailsObj = new PoProductDetails();
                $POProductDetailsObj->setPoFk($POMasterObj);
                $POProductDetailsObj->setUnitFk($UnitObj);
                $POProductDetailsObj->setProductFk($ProObj);
                $POProductDetailsObj->setExpectedDeliveryDate(new \Datetime($expDelivereddate));
                $POProductDetailsObj->setRemarks($remarks);
                $POProductDetailsObj->setQuantity($quantity);
                $POProductDetailsObj->setDeliveredQuantity(0);
                $POProductDetailsObj->setQuotedPrice($quoted);
                $POProductDetailsObj->setTax($tax);
                 if($ProjectObj)
                {
                    $POProductDetailsObj->setProjectFk($ProjectObj);
                }
                $POProductDetailsObj->setIsProjectRelated($check);
                $POProductDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                $POProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                $POProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                $POProductDetailsObj->setRecordActiveFlag(1);
                $POProductDetailsObj->setApprovalflag(0);
                
                $this->em->persist($POProductDetailsObj);
                $this->em->flush();
                $returncode = 1;
            }
//-------------------------------for inserting record into po status master txn--------------------------------------------------------

            $POStatusTxn = new PoStatusTxn();

            $POStatusTxn->setStatusDate(new\Datetime('NOW'));
            $POStatusTxn->setRemarks('Created');
            $POStatusTxn->setRecordActiveFlag(1);
            $POStatusTxn->setRecordInsertDate(new \ Datetime('NOW'));
            $POStatusTxn->setApplicationUserId($this->session->get('EMPID'));
            $POStatusTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $POStatusTxn->setPoFk($POMasterObj);
            $POStatusTxn->setStatusFk($POStatusMasterObj);
            $this->em->persist($POStatusTxn);
            $this->em->flush();

            //------------------------------for inserting record into po_transport txn----------------------------             

            $transporter = $dataUI->transport;
            $transmode = $dataUI->transmode;
            $tcost = $dataUI->trcost;

            $TransObj = $this->em->getRepository(PurchaseConstant::ENT_TRANSPORT)->find($transporter);
            $TransMODEObj = $this->em->getRepository(PurchaseConstant::ENT_TransMODE)->find($transmode);
            $POTransportTxn = new PoTransportTxn();

            $POTransportTxn->setTransporterFk($TransObj);
            $POTransportTxn->setTransportModeFk($TransMODEObj);
            $POTransportTxn->setTransportCost($tcost);

            $POTransportTxn->setPoFk($POMasterObj);
            $POTransportTxn->setStatusDate(new\Datetime('NOW'));
            $POTransportTxn->setRecordActiveFlag(1);
            $POTransportTxn->setRecordInsertDate(new \ Datetime('NOW'));
            $POTransportTxn->setApplicationUserId($this->session->get('EMPID'));
            $POTransportTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($POTransportTxn);
            $this->em->flush();
            $returncode = 1;
            $returnmsg = 'Purchased Sucessfully';
            $conn->commit();


            //$CommonMobile=$this->em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_CONTACT)->findOneBy(array('pkid'=>$mob_id)); 
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('code' => $returncode, 'msg' => $returnmsg);
    }

    //------------------------------inserting po master ends here
    //------------------------------updating po master----------------------------------------------------


    function updatePODetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $productid = array();

            if (is_string($dataUI->pid)) {
                $productid[0] = $dataUI->pid; //for only one    
            } else {
                $productid = $dataUI->pid;     //for more than one       
            }
            $podate = $dataUI->podate;
            $expDelivereddate = $dataUI->expdeliverdate;
            $description = $dataUI->description;
            $subtotal = $dataUI->total;
            $taxamount = $dataUI->taxamount;
            $grandamount = $dataUI->grandtotal;
            $purby = $dataUI->purby;
            //$pkid = $dataUI->postatus;
            //getting supplier id and shipping id from javascript
            $supid = $dataUI->supid;
            $shippingid = $dataUI->comid;
            $POid = $dataUI->poid;
            //
            //setting foreign key object for postatus master
            $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(1);
            $SupplierObj = $this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
            $SuppliercontactObj = $this->em->getRepository(PurchaseConstant::ENT_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk' => $supid, 'recordActiveFlag' => 1));
            $ShippingAdreesObj = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_ADDRESS_TXN)->findOneBy(array('companyFk' => $shippingid, 'recordActiveFlag' => 1));
            $apkid = $ShippingAdreesObj->getPkid();
            $AdreesObj = $this->em->getRepository(PurchaseConstant::ENT_COMPANY_ADDRESS_TXN)->find($apkid);
            $POMasterObj = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POid);
            $EmpMasterObj = $this->em->getRepository(PurchaseConstant::ENT_EMP)->find($purby);
//-------------------------------for updating and inserting new items record into po_product_details table----------------------------------------------------
//                print_r($productid);
//                die();
            foreach ($productid as $val) {
                $q = 'quantity' . $val;
                $dq = 'deliverquantity' . $val;
                $p = 'totalprice' . $val;
                $u = 'unitid' . $val;
                $t = 'tax' . $val;
                $r = 'remarks' . $val;
                $pro = 'productid' . $val;
                $c = 'txt_isrelated' . $val;
                $project = 'project' . $val;


                $proid = $val;
                $check = $dataUI->$c;
                $projectpkid = $dataUI->$project;
                $quoted = $dataUI->$p;
                $quantity = $dataUI->$q;
                $tax = $dataUI->$t;
                $remarks = $dataUI->$r;
                $deliverquantity = $dataUI->$dq;
                $unit = $dataUI->$u;
                $pid = $dataUI->$pro;


                $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(1);
                $ProjectObj = $this->em->getRepository(PurchaseConstant::ENTITY_PROJECT)->find($projectpkid);

                if ($quantity >= $deliverquantity) {
                    
                } else {
                    $returncode = 0;
                    $returnmsg = "Delvery quantity must be equal or less than actual quantinty!";
                    return array('msg' => $returnmsg, 'code' => $returncode);
                }




                if ($pid == 1) {

                    $ProObj = $this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                    $UnitObj = $this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);


                    $POProductDetailsObj = new PoProductDetails();
                    $POProductDetailsObj->setPoFk($POMasterObj);
                    $POProductDetailsObj->setUnitFk($UnitObj);
                    $POProductDetailsObj->setProductFk($ProObj);
                    $POProductDetailsObj->setExpectedDeliveryDate(new \Datetime($expDelivereddate));
                    $POProductDetailsObj->setRemarks($remarks);
                    $POProductDetailsObj->setQuantity($quantity);
                    $POProductDetailsObj->setDeliveredQuantity($deliverquantity);
                    $POProductDetailsObj->setQuotedPrice($quoted);
                    $POProductDetailsObj->setTax($tax);
                    $POProductDetailsObj->setProjectFk($ProjectObj);
                    $POProductDetailsObj->setIsProjectRelated($check);
                    $POProductDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                    $POProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                    $POProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $POProductDetailsObj->setRecordActiveFlag(1);
                    $POProductDetailsObj->setApprovalflag(0);
                    $returncode = 1;
                    $this->em->persist($POProductDetailsObj);
                    $this->em->flush();
                } else {

                    $ProObj = $this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                    $UnitObj = $this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unit);
                    $POProductObj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findOneByProductFk($proid);
                    $purchaseorder = $POProductObj->getPkid();

                    $POProDetailsObj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findOneBypoFk($POid);
                    $poproductpkid = $POProDetailsObj->getPkid();
                    $POProductDetailsObj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->find($poproductpkid);


                    $POProductDetailsObj->setPoFk($POMasterObj);
                    $POProductDetailsObj->setUnitFk($UnitObj);
                    $POProductDetailsObj->setProductFk($ProObj);
                    $POProductDetailsObj->setExpectedDeliveryDate(new \Datetime($expDelivereddate));
                    $POProductDetailsObj->setRemarks($remarks);
                    $POProductDetailsObj->setQuantity($quantity);
                    $POProductDetailsObj->setDeliveredQuantity($deliverquantity);
                    $POProductDetailsObj->setQuotedPrice($quoted);
                    $POProductDetailsObj->setTax($tax);
                    $POProductDetailsObj->setRecordUpdateDate(new \Datetime('NOW'));
                    $POProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                    $POProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $POProductDetailsObj->setRecordActiveFlag(1);
                    $POProductDetailsObj->setApprovalflag(0);
                    $returncode = 1;
                    // $this->em->persist($POProductDetailsObj);
                    $this->em->flush();
                }
                //------------------------for updating payment mode-------------------------------
//                     
//                     $paymode = $dataUI->selpayMode;
//            
//                    $IspaymentNo=$this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->find($paymode);
//                    $payid=$IspaymentNo->getIspaymentNoRequired();
//            
//                    if($payid==0)
//                    {
//                        $payno = '';
//                        $bank = '';
//                    }
//                    else
//                    {
//                        $payno = $dataUI->paymentno; 
//                         $bank = $dataUI->bankname;
//                    }
//           
//                    if(!isset($payno)){
//                            $payno='';
//                        }
//                   if(!isset($bank)){
//                            $bank='';
//                        }
//
//            $amount = $dataUI->amount;
//            $date = $dataUI->paydate;
//            $PaymentObj=$this->em->getRepository(PurchaseConstant::ENT_Paymode)->find($paymode);
//            
//            $PaymentTxn=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POid);
//            $payid=$PaymentTxn->getPkid();
//            
//            $POPaymentTxn=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->find($payid);
//            
//            $POPaymentTxn->setAmount($amount); 
//            $POPaymentTxn->setPaymentNo($payno);
//            $POPaymentTxn->setBankName($bank);
//            $POPaymentTxn->setPoFk($POMasterObj);
//            $POPaymentTxn->setPaymentModeFk($PaymentObj);
//            $POPaymentTxn->setRecordActiveFlag(1);
//            $POPaymentTxn->setRecordUpdateDate(new \ Datetime('NOW'));
//            $POPaymentTxn->setPaymentDate(new \ Datetime($date)); 
//          
//            $this->em->flush();
            }

            //---------------------------------------Purchae order Master Updating Part---------------------------
            //$POMasterObj=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POid); 
            $POMasterObj->setVendorMasterFk($SupplierObj);
            $POMasterObj->setVendorContactFk($SuppliercontactObj);
            $POMasterObj->setCompanyAddressFk($AdreesObj);
            $POMasterObj->setStatusFk($POStatusMasterObj);
            $POMasterObj->setSubTotal($subtotal);
            $POMasterObj->setTaxAmt($taxamount);
            $POMasterObj->setGrandTotal($grandamount);
            $POMasterObj->setExpectedDelivery(new \Datetime($expDelivereddate));
            $POMasterObj->setOrderDetails($description);
            $POMasterObj->setEmployeeFk($EmpMasterObj);
            $POMasterObj->setOrderDate(new \DateTime($podate));
            $POMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
            $POMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $POMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            //$this->em->persist($POMasterObj);
            $this->em->flush();
            //--------------------------------------------------Ends here------------------------------------------
            //-----------------------------------------for updating purchase order transport details-----------------


            $transporter = $dataUI->transport;
            $transmode = $dataUI->transmode;
            $tcost = $dataUI->trcost;

            $TransObj = $this->em->getRepository(PurchaseConstant::ENT_TRANSPORT)->find($transporter);
            $TransMODEObj = $this->em->getRepository(PurchaseConstant::ENT_TransMODE)->find($transmode);
            $TransportTxn = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POid);
            $pk = $TransportTxn->getPkid();

            $POTransportTxn = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->find($pk);

            $POTransportTxn->setTransporterFk($TransObj);
            $POTransportTxn->setTransportModeFk($TransMODEObj);
            $POTransportTxn->setTransportCost($tcost);

            $POTransportTxn->setPoFk($POMasterObj);
            $POTransportTxn->setStatusDate(new\Datetime('NOW'));
            $POTransportTxn->setRecordActiveFlag(1);
            $POTransportTxn->setRecordUpdateDate(new \ Datetime('NOW'));
            $POTransportTxn->setApplicationUserId($this->session->get('EMPID'));
            $POTransportTxn->setApplicationUserIpAddress($this->session->get('IP'));

            $this->em->flush();


            //---------------------------------for updating status txn------------------------------------        
            //$StatusTxn=$this->em->getRepository(PurchaseConstant::ENT_POStatus_txn)->findOneByPoFk($POid);

            $POStatusTxn = new PoStatusTxn();
            $POStatusTxn->setStatusDate(new\Datetime('NOW'));
            $POStatusTxn->setRemarks('Changes made to status');
            $POStatusTxn->setRecordActiveFlag(1);
            $POStatusTxn->setRecordUpdateDate(new \ Datetime('NOW'));
            $POStatusTxn->setApplicationUserId($this->session->get('EMPID'));
            $POStatusTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $POStatusTxn->setPoFk($POMasterObj);
            $POStatusTxn->setStatusFk($POStatusMasterObj);
            $this->em->persist($POStatusTxn);
            $this->em->flush();
            $returncode = 1;
            $returnmsg = 'Purchase record updated sucessfully';
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $returnmsg, 'code' => $returncode);
    }

    //-------------------------------updating po master ends here--------------------------------------------------------------------



    function updatePurchaseQuantityPODetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $productid = array();

            if (is_string($dataUI->pid)) {
                $productid[0] = $dataUI->pid; //for only one    
            } else {
                $productid = $dataUI->pid;     //for more than one       
            }

            //$shippingid=$dataUI->comid;
            $POid = $dataUI->poid;
            //setting foreign key object for postatus master
            $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(1);
            $POMasterObj = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POid);
            // $EmpMasterObj = $this->em->getRepository(PurchaseConstant::ENT_EMP)->find($purby);  
//-------------------------------for updating and inserting new items record into po_product_details table----------------------------------------------------
            $isparDeliver = 0;
            $isDeliver = 1;

            foreach ($productid as $val) {
                $q = 'quantity' . $val;
                $dq = 'deliverquantity' . $val;

                $proid = $val;
                $quantity = $dataUI->$q;
                $deliverquantity = $dataUI->$dq;


                $ProObj = $this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($proid);
                $POProductObj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findOneByProductFk($proid);
                $purchaseorder = $POProductObj->getPkid();

                if ($quantity >= $deliverquantity) {
                    
                } else {
                    $returncode = 0;
                    $returnmsg = "Delvery quantity must be equal or less than actual quantinty!";
                    return array('msg' => $returnmsg, 'code' => $returncode);
                }


                if ($quantity != $deliverquantity) {
                    $isDeliver = 0;
                }
                if ($quantity > $deliverquantity) {
                    $isparDeliver = 1;
                }

                $POProductDetailsObj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->find($purchaseorder);
                $POProductDetailsObj->setDeliveredQuantity($deliverquantity);
                $POProductDetailsObj->setRecordUpdateDate(new \Datetime('NOW'));
                $POProductDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                $POProductDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                $POProductDetailsObj->setRecordActiveFlag(1);
                $POProductDetailsObj->setApprovalflag(1);
                $this->em->flush();
                $returncode = 1;
            }
            //----------------------for checking postatus---------------------------------------
            if ($isDeliver == 1) {
                $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(4);
            }

            if ($isparDeliver == 1) {
                $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(3);
            }
            //--------------------------------------Ends here-----------------------------------------
            //---------------------------------------Purchae order Master Updating Part---------------------------
            $POMasterObj->setStatusFk($POStatusMasterObj);
            //$POMasterObj->setEmployeeFk($EmpMasterObj);
            $POMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
            $POMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $POMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //--------------------------------------------------Ends here------------------------------------------
            //---------------------------------for updating status txn------------------------------------        
            $POStatusTxn = new PoStatusTxn();
            $POStatusTxn->setStatusDate(new\Datetime('NOW'));
            $POStatusTxn->setRemarks('Changes made to status');
            $POStatusTxn->setRecordActiveFlag(1);
            $POStatusTxn->setRecordUpdateDate(new \ Datetime('NOW'));
            $POStatusTxn->setApplicationUserId($this->session->get('EMPID'));
            $POStatusTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $POStatusTxn->setPoFk($POMasterObj);
            $POStatusTxn->setStatusFk($POStatusMasterObj);
            $this->em->persist($POStatusTxn);
            $this->em->flush();
            $returncode = 1;
            $returnmsg = 'Quantity updated sucessfully';
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $returnmsg, 'code' => $returncode);
    }

    //Insert record aapprove po order

    function ApprovePODetails($request) {

        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $POCode = $dataUI->poid;
            $remarks = $dataUI->description;
            //creating purchase order object

            $pkid = 2;
            //creating status flag object
            $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find($pkid);

            //creating po_product_details object
            $Pro_Obj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk(array('poFk' => $POCode));

            //updating po master
            $PO_Obj = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POCode);
            $PO_Obj->setRecordUpdateDate(new\Datetime('NOW'));
            $PO_Obj->setApplicationUserId($this->session->get('EMPID'));
            $PO_Obj->setApplicationUserIpAddress($this->session->get('IP'));
            $PO_Obj->setApprovalflag(1);
            $PO_Obj->setStatusFk($POStatusMasterObj);
            $this->em->flush();
            //
            //inserting status master txn
            $STATUS_TXNObj = new PoStatusTxn();
            $STATUS_TXNObj->setStatusDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setRemarks($remarks);
            $STATUS_TXNObj->setRecordActiveFlag(1);
            $STATUS_TXNObj->setRecordInsertDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setApplicationUserId($this->session->get('EMPID'));
            $STATUS_TXNObj->setApplicationUserIpAddress($this->session->get('IP'));
            $STATUS_TXNObj->setPoFk($PO_Obj);
            $STATUS_TXNObj->setStatusFk($POStatusMasterObj);
            $this->em->persist($STATUS_TXNObj);
            $this->em->flush();
            //ends here
            //updating record for po order product details
            foreach ($Pro_Obj as $p) {
                $p->setApprovalflag(1);
                $p->setRecordUpdateDate(new\Datetime('NOW'));
                $p->setApplicationUserId($this->session->get('EMPID'));
                $p->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }
            //ends here
//            //-------------------------updating po_payment_txn------------------------------
//            
//            $PaymentTxn=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
//            $payid=$PaymentTxn->getPkid();
//            
//            $POPaymentTxn=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->find($payid);
//            $POPaymentTxn->setRecordActiveFlag(0);
//            $this->em->flush();
//            
//            
//            
//            //----------------ends here-----------------------------
            //------------------------updating po_transport_txn---------------------------------

            $TransportTxn = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
            $pk = $TransportTxn->getPkid();

            $POTransportTxn = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->find($pk);
            $POTransportTxn->setRecordActiveFlag(1);
            $this->em->flush();

            //-----------------------ends here---------------------

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Purchase order approved sucessfully');
    }

    function CancelPODetails($request) {

        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $POCode = $dataUI->poid;
            $remarks = $dataUI->description;

            //creating purchase order object
            //creating status flag object
            $POStatusMasterObj = $this->em->getRepository(PurchaseConstant::ENT_POSTATUS)->find(5);

            //creating po_product_details object
            $Pro_Obj = $this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk(array('poFk' => $POCode));

            //updating po master
            $PO_Obj = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POCode);
            $PO_Obj->setRecordUpdateDate(new\Datetime('NOW'));
            $PO_Obj->setApplicationUserId($this->session->get('EMPID'));
            $PO_Obj->setApplicationUserIpAddress($this->session->get('IP'));
            $PO_Obj->setApprovalflag(0);
            $PO_Obj->setRecordActiveFlag(0);
            $PO_Obj->setStatusFk($POStatusMasterObj);
            $this->em->flush();
            //
            //inserting status master txn
            $STATUS_TXNObj = new PoStatusTxn();
            $STATUS_TXNObj->setStatusDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setRemarks($remarks);
            $STATUS_TXNObj->setRecordActiveFlag(0);
            $STATUS_TXNObj->setRecordInsertDate(new\Datetime('NOW'));
            $STATUS_TXNObj->setApplicationUserId($this->session->get('EMPID'));
            $STATUS_TXNObj->setApplicationUserIpAddress($this->session->get('IP'));
            $STATUS_TXNObj->setPoFk($PO_Obj);
            $STATUS_TXNObj->setStatusFk($POStatusMasterObj);
            $this->em->persist($STATUS_TXNObj);
            $this->em->flush();
            //ends here
            //updating record for po order product details
            foreach ($Pro_Obj as $p) {
                $p->setApprovalflag(0);
                $p->setRecordActiveFlag(0);
                $p->setRecordUpdateDate(new\Datetime('NOW'));
                $p->setApplicationUserId($this->session->get('EMPID'));
                $p->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }
            //ends here
            //-------------------------updating po_payment_txn------------------------------
//            $PaymentTxn=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
//            $payid=$PaymentTxn->getPkid();
//            
//            $POPaymentTxn=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->find($payid);
//            $POPaymentTxn->setRecordActiveFlag(0);
//            $this->em->flush();
            //----------------ends here-----------------------------
            //------------------------updating po_transport_txn---------------------------------

            $TransportTxn = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
            $pk = $TransportTxn->getPkid();

            $POTransportTxn = $this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->find($pk);
            $POTransportTxn->setRecordActiveFlag(0);
            $this->em->flush();

            //-----------------------ends here---------------------

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Purchase Order Canceled Sucessfully');
    }

    public function DisplayAllProjectRecord() {
        try {
            $details = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->DisplayProjectList();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Record found', 'detail' => $details);
    }

    //payment for purchase order
    function PoPurchasePaymentDetails($request) {

        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $selectedSupplier = $dataUI->supplierList;
            $remarks = $dataUI->remarks;

            //for inserting record into Payment Mode
            $paymode = $dataUI->selpayMode;

//            $POMasterObj = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POid);
            $IspaymentNo = $this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->find($paymode);
            $payid = $IspaymentNo->getIspaymentNoRequired();
            
            $queryString = "SELECT  popaymenttxn.paymentFormat paymentformatID
                            FROM TashiCommonBundle:PoPaymentTxn popaymenttxn 
                            where popaymenttxn.pkid=(SELECT MAX(popay.pkid) FROM TashiCommonBundle:PoPaymentTxn popay)";

            $query = $this->em->createQuery($queryString);
            $result = $query->getResult();
            if ($result) {
                $po = $result[0]['paymentformatID'];

                $pay_generate_ID = (int) substr($po, 1, strlen($po)) + 1;
            } else {
                $pay_generate_ID = 1;
            }
            $pay_ID = 'P' . $pay_generate_ID;
            
           // echo $pay_ID;die();
            

            if ($payid == 0) {
                $payno = '';
                $bank = '';
            } else {
                $payno = $dataUI->paymentno;
                $bank = $dataUI->bankname;
            }

            if (!isset($payno)) {
                $payno = '';
            }
            if (!isset($bank)) {
                $bank = '';
            }
            //$grand = $dataUI->grand;
            $amount = $dataUI->amount;
            
            
            //section for retreiving total sum of PoMaster and PoPaymentTxn
            $retrieve_total = $this->searchTotalAmount();
            $retrieve_sum = $this->searchTotalAmountfromPoPaymentTxn();
           // var_dump($retrieve_total);die();
           if (!is_null($retrieve_total[0]['amount'])) {
                $PoAmount = $retrieve_total[0]['amount'];
            }
            if (!is_null($retrieve_sum[0]['amount'])) {
                $PaymentAmount = $retrieve_sum[0]['amount'];
            } else {
                $PaymentAmount = 0;
            }
            $actualdueAmount = $PoAmount - $PaymentAmount;
            //section for retreiving total sum of PoMaster and PoPaymentTxn ends here
                                                           
            if($amount > $actualdueAmount)
            {   $code = 0;
                $returnmsg = 'Enter amount is greater than Purchase Order Payment amount.';
                return array('msg'=>$returnmsg,'code'=>$code);
               // break;
            }
            
            
            $date = $dataUI->paydate;
            $PaymentObj = $this->em->getRepository(PurchaseConstant::ENT_Paymode)->find($paymode);
            //searching for purchase order payment txn
//            $result = $this->searchbyPurchaseORderforproductdetails($POid);
//            //---------------result ends---------------------------
//            if ($result) {
//                $total = $result['total'][0]['amount'];
//                $sum = $grand;
//                $no = $amount + $total;
//            } else {
//                $total = 0;
//                $sum = $grand;
//                $no = $amount + $total;
//            }
//
//            if ($no > $sum) {
//                $code = 0;
//                $returnmsg = 'Payment failed! No due found for purchase payment.';
//            } else {

                if ($paymode == 1) {
                    $emp_id = $this->session->get('EMPID');
                    $branch_id = $this->commonService->getBranchIdByGivingEmpId($emp_id);

                    $AccountCashCurrent = $this->em->getRepository(PurchaseConstant::ENT_CASHACCOUNT)->findOneBy(array('recordActiveFlag' => 1, 'branchOfficeCode' => $branch_id));
                    if ($AccountCashCurrent) {
                        $currentamount = $AccountCashCurrent->getCurrentAmount();
                        $balance = $currentamount - $amount;
                        $pkid = $AccountCashCurrent->getPkid();
                        $AccountCashCurrentBalanceObj = $this->em->getRepository(PurchaseConstant::ENT_CASHACCOUNT)->find($pkid);
                        $AccountCashCurrentBalanceObj->setCurrentAmount($balance);
                        $AccountCashCurrentBalanceObj->setDescription($remarks);
                        $AccountCashCurrentBalanceObj->setRecordUpdateDate(new \Datetime());
                        $AccountCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                        $AccountCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush();
                    } else {
                        $currentamount = 0;
                        $balance = $currentamount - $amount;
                        $AccountCashCurrentBalanceObj = new AccountCashCurrentBalance();
                        $AccountCashCurrentBalanceObj->setCurrentAmount($balance);
                        $AccountCashCurrentBalanceObj->setBranchOfficeCode($branch_id);
                        $AccountCashCurrentBalanceObj->setDescription($remarks);
                        $AccountCashCurrentBalanceObj->setRecordInsertDate(new \Datetime());
                        $AccountCashCurrentBalanceObj->setCreatedDate(new \Datetime());
                        $AccountCashCurrentBalanceObj->setRecordActiveFlag(1);
                        $AccountCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                        $AccountCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($AccountCashCurrentBalanceObj);
                        $this->em->flush();
                    }
                    //for inserting into cash withdrawal history
                    $AccountCashDipositWithdrawalHistoryObj = new AccountCashDipositWithdrawalHistory();
                    $AccountCashDipositWithdrawalHistoryObj->setDepositWithdrawalKey('W');
                    $AccountCashDipositWithdrawalHistoryObj->setAmount($amount);
                    $AccountCashDipositWithdrawalHistoryObj->setDate(new \Datetime());
                    $AccountCashDipositWithdrawalHistoryObj->setDescription($remarks);
                    $AccountCashDipositWithdrawalHistoryObj->setRecordActiveFlag(1);
                    $AccountCashDipositWithdrawalHistoryObj->setRecordInsertDate(new \Datetime());
                    $AccountCashDipositWithdrawalHistoryObj->setCashAccountFk($AccountCashCurrentBalanceObj);
                    $AccountCashDipositWithdrawalHistoryObj->setApplicationUserId($this->session->get('EMPID'));
                    $EmpObj = $this->em->getRepository(PurchaseConstant::ENT_EMP)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                    $Empname = $EmpObj->getPersonFk()->getPersonName();
                    $AccountCashDipositWithdrawalHistoryObj->setDepositWithdrawalBy($Empname);
                    $AccountCashDipositWithdrawalHistoryObj->setBranchOfficeCode($branch_id);
                    $AccountCashDipositWithdrawalHistoryObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($AccountCashDipositWithdrawalHistoryObj);
                    $this->em->flush();
                    $code = 1;
                } else {
                    $mode = $dataUI->selpayMode;
                    $selectlist = $dataUI->selectlist;
                    //for bank account section
                    $BankCurrent = $this->em->getRepository(PurchaseConstant::ENT_BANKACCOUNT)->findOneBy(array('bankFk' => $selectlist, 'recordActiveFlag' => 1));

                    if ($BankCurrent) {
                        $currentamount = $BankCurrent->getCurrentAmount();
                        $pkid = $BankCurrent->getPkid();
                    } else {
                        $currentamount = 0;
                    }
                    //for checking bank current amount greater than deposit amount
//                    if ($amount > $currentamount) {
//                        $code = 0;
//                        $customMessage = 'Amount greater than current bank balance amount!';
//                        return array('msg' => $customMessage, 'code' => $code);
//                    } else {
                        $balance = $currentamount - $amount;
                        $Bank = $this->em->getRepository(PurchaseConstant::ENT_BANK)->find($selectlist);

                        $BankCashCurrentBalanceObj = $this->em->getRepository(PurchaseConstant::ENT_BANKACCOUNT)->find($pkid);
                        $BankCashCurrentBalanceObj->setCurrentAmount($balance);
                        //$BankCashCurrentBalanceObj->setDescription($description);
                        if ($Bank) {
                            $BankCashCurrentBalanceObj->setBankFk($Bank);
                        }
                        $BankCashCurrentBalanceObj->setRecordUpdateDate(new \Datetime());
                        $BankCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                        $BankCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush();
                        //$code = 1;
                    //}
                    //ends here
                    //for inserting into bank deposit withdrawal history
                    $AccountBankDipositWithdrawalHistoryObj = new AccountBankDipositWithdrawalHistory();
                    $AccountBankDipositWithdrawalHistoryObj->setDepositWithdrawalKey('W');
                    $AccountBankDipositWithdrawalHistoryObj->setAmount($amount);
                    $AccountBankDipositWithdrawalHistoryObj->setDate(new \Datetime());
                    $EmpObj = $this->em->getRepository(PurchaseConstant::ENT_EMP)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                    $Empname = $EmpObj->getPersonFk()->getPersonName();
                    $AccountBankDipositWithdrawalHistoryObj->setDepositWithdrawalBy($Empname);
                    $AccountBankDipositWithdrawalHistoryObj->setDescription($remarks);
                    if ($Bank) {
                        $AccountBankDipositWithdrawalHistoryObj->setBankFk($Bank);
                    }

                    if ($mode == 1) {
                        
                    } else {
                        $AccountBankDipositWithdrawalHistoryObj->setPaymentNo($payno);
                    }
                    $AccountBankDipositWithdrawalHistoryObj->setPaymentModeFk($this->em->getRepository(PurchaseConstant::ENT_Paymode)->find($mode));
                    $AccountBankDipositWithdrawalHistoryObj->setRecordActiveFlag(1);
                    $AccountBankDipositWithdrawalHistoryObj->setRecordInsertDate(new \Datetime());
                    // $AccountBankDipositWithdrawalHistoryObj->setCashAccountFk($BankCashCurrentBalanceObj);
                    $AccountBankDipositWithdrawalHistoryObj->setApplicationUserId($this->session->get('EMPID'));
                    $AccountBankDipositWithdrawalHistoryObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($AccountBankDipositWithdrawalHistoryObj);
                    $this->em->flush();
                    $code = 1;
                }

                //for inserting into account details table
                $accDetailsObj = new AccountDetailsMaster();
                //set to salary account head(fixed)
                $accDetailsObj->setAccountHeadFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find(4));
                $accDetailsObj->setAmount($amount);
                $accDetailsObj->setPrcFormat($pay_ID);
                $accDetailsObj->setDate(new \Datetime('NOW'));
                $accDetailsObj->setDescription($remarks);
                $accDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                $accDetailsObj->setRecordActiveFlag(1);
                $accDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                $accDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($accDetailsObj);
                $this->em->flush();
                //ends here 
                
               //for calculating current amount and due section
               // echo $selectedSupplier;die();
               
               //************section for checking selected supplier*************
               if ($selectedSupplier == 0) {
                $result = $this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findBy(array('dueFlag' => 0, 'recordActiveFlag' => 1, 'approvalflag' => 1), array('orderDate' => 'ASC'));
                } else {
                $result = $this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findBy(array('dueFlag' => 0, 'recordActiveFlag' => 1, 'approvalflag' => 1, 'vendorMasterFk' => $selectedSupplier), array('orderDate' => 'ASC'));
                }
                //************section for checking selected supplier ends here********
                $amountflag =0;
//                foreach($result as $pomaster){
//                   echo $pomaster->getPopk() .'--' .  $pomaster->getGrandTotal(); echo "<br/>";
//                   
//                }
//                die();
                foreach($result as $pomaster)
                {   $purchaseamount = $pomaster->getGrandTotal();
                    $pkid = $pomaster->getPopk();
                    
                    $POMasterObj = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($pkid);
                    $result = $this->searchbyPurchaseORderforproductdetails($pkid);
                    //---------------result ends---------------------------
                    $total = 0;
                    if (!is_null($result[0]['amount'])) {
                        
                        $total = $result[0]['amount'];
                        $dueamount = $purchaseamount - $total;
                         
                        if($dueamount>$amount)//if due amount is greater than purchase UI amount
                        {   //for inserting into popaymenttxn
                            $POPaymentTxn = new PoPaymentTxn();
                            $POPaymentTxn->setAmount($amount);
                            $POPaymentTxn->setPaymentNo($payno);
                            $POPaymentTxn->setBankName($bank);
                            $POPaymentTxn->setRemarks($remarks);
                            $POPaymentTxn->setPoFk($POMasterObj);
                            $POPaymentTxn->setPaymentModeFk($PaymentObj);
                            $POPaymentTxn->setPaymentFormat($pay_ID);
                            $POPaymentTxn->setRecordActiveFlag(1);
                            $POPaymentTxn->setRecordInsertDate(new \ Datetime('NOW'));
                            $POPaymentTxn->setApplicationUserId($this->session->get('EMPID'));
                            $POPaymentTxn->setApplicationUserIpAddress($this->session->get('IP'));
                            $POPaymentTxn->setPaymentDate(new \ Datetime($date));
                            $this->em->persist($POPaymentTxn);
                            $this->em->flush();
                            $code = 1;
                            $amount=$amount;
                            $result2 = $this->searchbyPurchaseORderforproductdetails($pkid);
                                    //---------------result ends---------------------------
                                    if (!is_null($result2[0]['amount'])) {
                                        $sumamountofPayment = $result2[0]['amount'];
                                        if ($purchaseamount == $sumamountofPayment) {
                                            //for updating due flag in PO Master
                                            $POMasterObj->setDueFlag(1);
                                            $this->em->flush();
                                            //PO Master updating ends here
                                            break;
                                        }
                                    }
                                    break;
                            
                        }else if($dueamount < $amount)//section when dueamount is less than UI amount 
                              { 
                                
                                 //echo $amount;die();
                                 $result2 = $this->searchbyPurchaseORderforproductdetails($pkid);
                                    //---------------result ends---------------------------
                                    if (!is_null($result2[0]['amount'])) {
                                        $sumamountofPayment = $result2[0]['amount'];
                                        //echo $sumamountofPayment;die();
                                        $amount = $amount - $dueamount;
                                        $POPaymentTxn = new PoPaymentTxn();
                                        $POPaymentTxn->setAmount($dueamount);
                                        $POPaymentTxn->setPaymentNo($payno);
                                        $POPaymentTxn->setBankName($bank);
                                        $POPaymentTxn->setRemarks($remarks);
                                        $POPaymentTxn->setPoFk($POMasterObj);
                                        $POPaymentTxn->setPaymentModeFk($PaymentObj);
                                         $POPaymentTxn->setPaymentFormat($pay_ID);
                                        $POPaymentTxn->setRecordActiveFlag(1);
                                        $POPaymentTxn->setRecordInsertDate(new \ Datetime('NOW'));
                                        $POPaymentTxn->setApplicationUserId($this->session->get('EMPID'));
                                        $POPaymentTxn->setApplicationUserIpAddress($this->session->get('IP'));
                                        $POPaymentTxn->setPaymentDate(new \ Datetime($date));
                                        $this->em->persist($POPaymentTxn);
                                        $this->em->flush();
                                        $code = 1;
                                        
                                        
                                        if ($purchaseamount == ($dueamount + $sumamountofPayment)) {
                                            //for updating due flag in PO Master
                                            $POMasterObj->setDueFlag(1);
                                            $this->em->flush();
                                            //PO Master updating ends here
                                            
                                        }
                                        
                                        
                                        
                                    }
                                    else
                                    {
                                        //$amount = $dueamount;
                                $POPaymentTxn = new PoPaymentTxn();
                                $POPaymentTxn->setAmount($dueamount);
                                $POPaymentTxn->setPaymentNo($payno);
                                $POPaymentTxn->setBankName($bank);
                                $POPaymentTxn->setRemarks($remarks);
                                $POPaymentTxn->setPoFk($POMasterObj);
                                $POPaymentTxn->setPaymentModeFk($PaymentObj);
                                 $POPaymentTxn->setPaymentFormat($pay_ID);
                                $POPaymentTxn->setRecordActiveFlag(1);
                                $POPaymentTxn->setRecordInsertDate(new \ Datetime('NOW'));
                                $POPaymentTxn->setApplicationUserId($this->session->get('EMPID'));
                                $POPaymentTxn->setApplicationUserIpAddress($this->session->get('IP'));
                                $POPaymentTxn->setPaymentDate(new \ Datetime($date));
                                $this->em->persist($POPaymentTxn);
                                $this->em->flush();
                                $code = 1;
                                $amount =    $amount - $dueamount;
                                        
                                    }
                               }
                               
                                    
                                      
                             //checking ends here
                       
                    }
                    
                    
                    
                    else//else part when there is no result in popayment_txn
                                            {               
                                                               if ($purchaseamount < $amount) {//for checking purchaseamount less than ui amount
                                                                    $amount =$amount - $purchaseamount ;   //inserting record when there is no single row in popayment_txn.
                                                                    $amountflag = $amount;
                                                                    //for inserting into popaymenttxn
                                                                    $POPaymentTxn = new PoPaymentTxn();
                                                                    $POPaymentTxn->setAmount($purchaseamount);
                                                                    $POPaymentTxn->setPaymentNo($payno);
                                                                    $POPaymentTxn->setBankName($bank);
                                                                    $POPaymentTxn->setRemarks($remarks);
                                                                    $POPaymentTxn->setPoFk($POMasterObj);
                                                                    $POPaymentTxn->setPaymentModeFk($PaymentObj);
                                                                    $POPaymentTxn->setPaymentFormat($pay_ID);
                                                                    $POPaymentTxn->setRecordActiveFlag(1);
                                                                    $POPaymentTxn->setRecordInsertDate(new \ Datetime('NOW'));
                                                                    $POPaymentTxn->setApplicationUserId($this->session->get('EMPID'));
                                                                    $POPaymentTxn->setApplicationUserIpAddress($this->session->get('IP'));
                                                                    $POPaymentTxn->setPaymentDate(new \ Datetime($date));
                                                                    $this->em->persist($POPaymentTxn);
                                                                    $this->em->flush();
                                                                    $code = 1;
                                                                    
                                                                    $result1 = $this->searchbyPurchaseORderforproductdetails($pkid);
//                                                                    //---------------result ends---------------------------
                                                                    if (!is_null($result1[0]['amount'])) {
                                                                        $sumamountofPayment = $result1[0]['amount'];
                                                                        if ($purchaseamount == $sumamountofPayment) {
                                                                            //for updating due flag in PO Master
                                                                            $POMasterObj->setDueFlag(1);
                                                                            $this->em->flush();
                                                                            //PO Master updating ends here
                                                                            
                                                                        }
                                                                    }
                                                                    //$amount = $purchasedue;
                                                                } else if ($purchaseamount > $amount)//for checking purchase amount greater than ui amount 
                                                                    {
                                                                    //for inserting into popaymenttxn
                                                                   
                                                                    $POPaymentTxn = new PoPaymentTxn();
                                                                    $POPaymentTxn->setAmount($amount);
                                                                    $POPaymentTxn->setPaymentNo($payno);
                                                                    $POPaymentTxn->setBankName($bank);
                                                                    $POPaymentTxn->setRemarks($remarks);
                                                                    $POPaymentTxn->setPoFk($POMasterObj);
                                                                    $POPaymentTxn->setPaymentModeFk($PaymentObj);
                                                                    $POPaymentTxn->setPaymentFormat($pay_ID);
                                                                    $POPaymentTxn->setRecordActiveFlag(1);
                                                                    $POPaymentTxn->setRecordInsertDate(new \ Datetime('NOW'));
                                                                    $POPaymentTxn->setApplicationUserId($this->session->get('EMPID'));
                                                                    $POPaymentTxn->setApplicationUserIpAddress($this->session->get('IP'));
                                                                    $POPaymentTxn->setPaymentDate(new \ Datetime($date));
                                                                    $this->em->persist($POPaymentTxn);
                                                                    $this->em->flush();
                                                                    $code = 1;
                                                                    
                                                                     //for updating record in purchase order
                                                                
                                                                    $result2 = $this->searchbyPurchaseORderforproductdetails($pkid);
                                                                    //---------------result ends---------------------------
                                                                    if (!is_null($result2[0]['amount'])) {
                                                                        $sumamountofPayment = $result2[0]['amount'];
                                                                        if ($purchaseamount == $sumamountofPayment) {
                                                                            //for updating due flag in PO Master
                                                                            $POMasterObj->setDueFlag(1);
                                                                            $this->em->flush();
                                                                            //PO Master updating ends here
                                                                            break;
                                                                        }
                                                                    }
                                                                    break;

                                                                }
                                                                else if($purchaseamount == $amount)//for checking purchase amount greater than ui amount
                                                                {
                                                                    $POPaymentTxn = new PoPaymentTxn();
                                                                    $POPaymentTxn->setAmount($amount);
                                                                    $POPaymentTxn->setPaymentNo($payno);
                                                                    $POPaymentTxn->setBankName($bank);
                                                                    $POPaymentTxn->setRemarks($remarks);
                                                                    $POPaymentTxn->setPoFk($POMasterObj);
                                                                    $POPaymentTxn->setPaymentModeFk($PaymentObj);
                                                                    $POPaymentTxn->setPaymentFormat($pay_ID);
                                                                    $POPaymentTxn->setRecordActiveFlag(1);
                                                                    $POPaymentTxn->setRecordInsertDate(new \ Datetime('NOW'));
                                                                    $POPaymentTxn->setApplicationUserId($this->session->get('EMPID'));
                                                                    $POPaymentTxn->setApplicationUserIpAddress($this->session->get('IP'));
                                                                    $POPaymentTxn->setPaymentDate(new \ Datetime($date));
                                                                    $this->em->persist($POPaymentTxn);
                                                                    $this->em->flush();
                                                                    $code = 1;
                                                                    
                                                                    
                                                                    $result2 = $this->searchbyPurchaseORderforproductdetails($pkid);
                                                                    //---------------result ends---------------------------
                                                                    if (!is_null($result2[0]['amount'])) {
                                                                        $sumamountofPayment = $result2[0]['amount'];
                                                                        if ($purchaseamount == $sumamountofPayment) {
                                                                            //for updating due flag in PO Master
                                                                            $POMasterObj->setDueFlag(1);
                                                                            $this->em->flush();
                                                                            //PO Master updating ends here
                                                                            break;
                                                                        }
                                                                    }
                                                                    break;
                                                                }
                                                               
                                                               
                                                                //popayment insertion ends here
                                                               
                                                            }
                       //else part section for calculation ends here
                }
                //section for calculating current amount and due ends here
                
                
           $returnmsg = 'Purchase payment sucessfull.';
            //}

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('code' => $code, 'msg' => $returnmsg);
    }

}

