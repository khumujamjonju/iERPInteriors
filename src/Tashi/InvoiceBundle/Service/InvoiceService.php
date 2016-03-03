<?php
namespace Tashi\InvoiceBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\InvoiceMaster;
use Tashi\CommonBundle\Entity\InvoiceItemTxn;
use Tashi\CommonBundle\Entity\InvoicePaymentTerms;
/**
 * Description of InvoiceService
 *
 * @author Administrator
 */
class InvoiceService {
    //put your code here
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;

    public function __construct(EntityManager $em, Session $session, $rootDir,$commonService) 
    {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService=$commonService;
        
    }
    function CreateInvoice($request){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try
        {
            $projid=$dataUI->inputprojid;
            $billAddid=$dataUI->selBillAddress;
            $invoicedate=$dataUI->txtInvDate;
            $salesRepid=$dataUI->selSalesRep;
            $shipdate=$dataUI->txtShipDate;
            $shipterm=$dataUI->txtShipTerm;
            $payterm=$dataUI->chkboxPay;
            $includeFlags=$dataUI->inputItemChk;
            $itemIds=$dataUI->inputItemId;
            $itemType=$dataUI->inputItemType;
            $descriptions=$dataUI->txtDesc;
            $units=$dataUI->inputUnit;
            $unitPrices=$dataUI->txtunitPrice;
            $quantities=$dataUI->txtQty;
            $mPrices=$dataUI->txtmPrice;            
            $taxpcs=$dataUI->txtTaxpc;
            $taxamts=$dataUI->txtTaxamt;
            $itemtotals=$dataUI->txtitemTotal;            
            $discountFlags=$dataUI->inputisDiscounted;
            $subtotal=$dataUI->txtSubtotal;
            $totalTax=$dataUI->txtTaxtotal;
            $deposit=$dataUI->txtDeposit;
            $totDiscount=$dataUI->txtDiscount;;
            $total=$dataUI->txtGrandTotal;            
            $balance=$dataUI->txtBalance;
            $notes=$dataUI->txtNote;
            
            $conn->beginTransaction();            
            $project=$this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($projid);            
            $shipAdd=$project->getCustomerAddressFk();
            $billAdd=$this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($billAddid);
            $salesrep=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($salesRepid);
            
            //INVOICE MASTER
            $invoice=new InvoiceMaster();
            $invoiceNo=$this->commonService->AutoGenerate('',7,'InvoiceMaster','pkid');
            $invoice->setInvoiceNo($invoiceNo);
            $invoice->setProjectFk($project);
            $invoice->setBillingAddressFk($billAdd);
            $invoice->setShippingAddressFk($shipAdd);
            $invoice->setInvoiceDate(new \DateTime($invoicedate));
            $invoice->setSalesRepFk($salesrep);
            $invoice->setShippingDate(new \DateTime($shipdate));
            $invoice->setShippingTerm($shipterm);
            $invoice->setSubTotal($subtotal);
            $invoice->setTaxAmt($totalTax);
            $invoice->setDiscount($totDiscount);
            $invoice->setTotal($total);
            $invoice->setDeposit($deposit);
            $invoice->setBalance($balance);
            $invoice->setIsDue(1);
            $invoice->setNotes($notes);
            $invoice->setApprovalFlag(0);
            $invoice->setRecordActiveFlag(1);
            $invoice->setRecordInsertDate(new \DateTime("NOW"));
            $invoice->setApplicationUserId($this->session->get('EMPID'));
            $invoice->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($invoice);
            $this->em->flush($invoice);
            //INVOICE PAYMENT TERM TXN
            if(is_array($payterm)){
                foreach($payterm as $paymodeid){
                    $paytermtxn=new InvoicePaymentTerms();
                    $paytermtxn->setInvoiceFk($invoice);
                    $paytermtxn->setPaymodeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($paymodeid));
                    $paytermtxn->setRecordActiveFlag(1);
                    $paytermtxn->setRecordInsertDate(new \DateTime("NOW"));
                    $paytermtxn->setApplicationUserId($this->session->get('EMPID'));
                    $paytermtxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($paytermtxn);
                    $this->em->flush($paytermtxn);
                }
            }else{
                $paytermtxn=new InvoicePaymentTerms();
                $paytermtxn->setInvoiceFk($invoice);
                $paytermtxn->setPaymodeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payterm));
                $paytermtxn->setRecordActiveFlag(1);
                $paytermtxn->setRecordInsertDate(new \DateTime("NOW"));
                $paytermtxn->setApplicationUserId($this->session->get('EMPID'));
                $paytermtxn->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($paytermtxn);
                $this->em->flush($paytermtxn);
            }

             //INVOICE ITEM TXN
            if(is_array($includeFlags)){
                for($i=0;$i<count($includeFlags);$i++){
                    $flag=$includeFlags[$i];
                    if($flag=='1'){ 
                        $itemtxn=new InvoiceItemTxn();
                        if($itemType[$i]=='is'){//if item is from project_item_txn
                            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemIds[$i]);
                            $itemtxn->setItemFk($item);
                        }elseif($itemType[$i]=='expense'){//if item is from project_expense
                            $item=$this->em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)->find($itemIds[$i]);
                            $itemtxn->setExpenseFk($item);
                        }                        
                        $itemtxn->setInvoiceFk($invoice);                        
                        $itemtxn->setDescription($descriptions[$i]);
                        $itemtxn->setUnit($units[$i]);
                        $itemtxn->setUnitPrice($unitPrices[$i]);
                        $itemtxn->setMarkupPrice($mPrices[$i]);
                        $itemtxn->setQuantity($quantities[$i]);
                        $itemtxn->setTaxPc($taxpcs[$i]);
                        $itemtxn->setTaxAmt($taxamts[$i]);
                        $itemtxn->setTotal($itemtotals[$i]);
                        $itemtxn->setIsDiscounted($discountFlags[$i]);
                        $itemtxn->setRecordActiveFlag(1);
                        $itemtxn->setRecordInsertDate(new \DateTime("NOW"));
                        $itemtxn->setApplicationUserId($this->session->get('EMPID'));
                        $itemtxn->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($itemtxn);
                        $this->em->flush($itemtxn);
                        
                        $item->setIsBilled(1);
                        $this->em->flush($item);
                    }
                }
            }else{
                if($includeFlags=='1'){     
                    $itemtxn=new InvoiceItemTxn();
                    if($itemType=='is'){
                        $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemIds);
                        $itemtxn->setItemFk($item);
                    }elseif($itemType=='expense'){
                        $item=$this->em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)->find($itemIds);
                        $itemtxn->setExpenseFk($item);
                    }
                    $itemtxn->setUnit($units);
                    $itemtxn->setDescription($descriptions);
                    $itemtxn->setUnitPrice($unitPrices);
                    $itemtxn->setMarkupPrice($mPrices);
                    $itemtxn->setQuantity($quantities);
                    $itemtxn->setTaxPc($taxpcs);
                    $itemtxn->setTaxAmt($taxamts);
                    $itemtxn->setTotal($itemtotals);
                    $itemtxn->setIsDiscounted($discountFlags);
                    $itemtxn->setRecordActiveFlag(1);
                    $itemtxn->setRecordInsertDate(new \DateTime("NOW"));
                    $itemtxn->setApplicationUserId($this->session->get('EMPID'));
                    $itemtxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($itemtxn);
                    $this->em->flush($itemtxn);                    

                    $item->setIsBilled(1);                   
                    $this->em->flush($item);
                }
            }
            $returnCode=1;
            $returnMsg='Invoice has been created successfully.';
            $conn->commit();                    
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnMsg=$this->commonService->CommonError($ex,'db');
            
        }
        return array('code'=>$returnCode,'msg'=>$returnMsg,'invoice'=>$invoice);
    }
    public function ApproveInvoice($invoiceid){
       try{
            $invoice=$this->em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($invoiceid);
            $invoice->setApprovalFlag(1);
            $invoice->setRecordUpdateDate(new \DateTime("NOW"));
            $invoice->setApplicationUserId($this->session->get('EMPID'));
            $invoice->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($invoice);
            $returnCode=1;
            $returnMsg='Approval Successful.';
       } catch (Exception $ex) {
            $returnCode=0;
            $returnMsg=$this->commonService->CommonError($ex,'db');
       } 
       return array('code'=>$returnCode,'msg'=>$returnMsg);
    }
    public function DeleteInvoice($invoiceid){
        $conn=$this->em->getConnection();
       try{
           $conn->beginTransaction();
            $invoice=$this->em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($invoiceid);
            $invoiceitem=$this->em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            $payterm=$this->em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            foreach($invoiceitem as $iItem){
                $invoiceitem=$iItem->getItemFk(); //project_item_txn
                $expense=$iItem->getExpenseFk(); //project_expenses
                //reset is_billed attribute to 0 to avail for next invoice
                if($invoiceitem){
                    $invoiceitem->setIsBilled(0);
                    $invoiceitem->setRecordUpdateDate(new \DateTime("NOW"));
                    $invoiceitem->setApplicationUserId($this->session->get('EMPID'));
                    $invoiceitem->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($invoiceitem);
                }
                if($expense){
                    $expense->setIsBilled(0);
                    $expense->setRecordUpdateDate(new \DateTime("NOW"));
                    $expense->setApplicationUserId($this->session->get('EMPID'));
                    $expense->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($expense);
                }
                
                $iItem->setRecordActiveFlag(0);
                $iItem->setRecordUpdateDate(new \DateTime("NOW"));
                $iItem->setApplicationUserId($this->session->get('EMPID'));
                $iItem->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush($iItem);               
            }
            foreach($payterm as $pay){
                $pay->setRecordActiveFlag(0);
                $pay->setRecordUpdateDate(new \DateTime("NOW"));
                $pay->setApplicationUserId($this->session->get('EMPID'));
                $pay->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush($pay);
            }
            $invoice->setRecordActiveFlag(0);
            $invoice->setRecordUpdateDate(new \DateTime("NOW"));
            $invoice->setApplicationUserId($this->session->get('EMPID'));
            $invoice->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($invoice);
            $conn->commit();
            $returnCode=1;
            $returnMsg='Invoice deleted.';
       } catch (Exception $ex) {
           $conn->rollBack();
            $returnCode=0;
            $returnMsg=$this->commonService->CommonError($ex,'db');
       } 
       return array('code'=>$returnCode,'msg'=>$returnMsg,'invoice'=>$invoice);
    }
    
    function UpdateInvoice($request,$invoiceid){
        $dataUI=  json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try
        {            
            //$projid=$dataUI->inputprojid;
            $billAddid=$dataUI->selBillAddress;
            $invoicedate=$dataUI->txtInvDate;
            $salesRepid=$dataUI->selSalesRep;
            $shipdate=$dataUI->txtShipDate;
            $shipterm=$dataUI->txtShipTerm;
            $payterms=$dataUI->chkboxPay;
            $includeFlags=$dataUI->inputItemChk;
            $itemIds=$dataUI->inputItemId;
            $invItemIds=$dataUI->inputInvItemPkid;
            $itemType=$dataUI->inputItemType;
            $descriptions=$dataUI->txtDesc;
            $units=$dataUI->inputUnit;
            $unitPrices=$dataUI->txtunitPrice;
            $quantities=$dataUI->txtQty;
            $mPrices=$dataUI->txtmPrice;            
            $taxpcs=$dataUI->txtTaxpc;
            $taxamts=$dataUI->txtTaxamt;
            $itemtotals=$dataUI->txtitemTotal;            
            $discountFlags=$dataUI->inputisDiscounted;
            $subtotal=$dataUI->txtSubtotal;
            $totalTax=$dataUI->txtTaxtotal;
            $deposit=$dataUI->txtDeposit;
            $totDiscount=$dataUI->txtDiscount;
            $total=$dataUI->txtGrandTotal;            
            $balance=$dataUI->txtBalance;
            $notes=$dataUI->txtNote;
            
            $conn->beginTransaction();    
            $invoice=$this->em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($invoiceid);        
            $project=$invoice->getProjectFk();
            $shipAdd=$project->getCustomerAddressFk();
            $billAdd=$this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($billAddid);
            $salesrep=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($salesRepid);
            
            //INVOICE MASTER
            //$invoice=new InvoiceMaster();           

            $invoice->setBillingAddressFk($billAdd);
            $invoice->setInvoiceDate(new \DateTime($invoicedate));
            $invoice->setSalesRepFk($salesrep);
            $invoice->setShippingDate(new \DateTime($shipdate));
            $invoice->setShippingTerm($shipterm);
            $invoice->setSubTotal($subtotal);
            $invoice->setTaxAmt($totalTax);
            $invoice->setDiscount($totDiscount);
            $invoice->setTotal($total);
            $invoice->setDeposit($deposit);
            $invoice->setBalance($balance);
            $invoice->setIsDue(1);
            $invoice->setNotes($notes);
            $invoice->setApprovalFlag(0);
            $invoice->setRecordActiveFlag(1);
            $invoice->setRecordInsertDate(new \DateTime("NOW"));
            $invoice->setApplicationUserId($this->session->get('EMPID'));
            $invoice->setApplicationUserIpAddress($this->session->get('IP'));
            //$this->em->persist($invoice);
            $this->em->flush($invoice);
            //INVOICE PAYMENT TERM TXN
            $existingPayTerms=$this->em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('invoiceFk'=>$invoice,'recordActiveFlag'=>1));
            if($existingPayTerms){
                foreach($existingPayTerms as $payterm){
                    $payterm->setRecordActiveFlag(0);
                    $payterm->setRecordUpdateDate(new \DateTime("NOW"));
                    $payterm->setApplicationUserId($this->session->get('EMPID'));
                    $payterm->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($payterm);
                }
            }
            if(is_array($payterms)){
                foreach($payterms as $paymodeid){
                    $ePayTerm=$this->em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findBy(array('paymodeFk'=>$paymodeid,'invoiceFk'=>$invoice));
                    if($ePayTerm){
                        $ePayTerm[0]->setRecordActiveFlag(1); 
                        $ePayTerm[0]->setRecordUpdateDate(new \DateTime("NOW"));
                        $ePayTerm->setApplicationUserId($this->session->get('EMPID'));
                        $ePayTerm->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush($ePayTerm[0]);
                    }else{
                        $paytermtxn=new InvoicePaymentTerms();
                        $paytermtxn->setInvoiceFk($invoice);
                        $paytermtxn->setPaymodeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($paymodeid));
                        $paytermtxn->setRecordInsertDate(new \DateTime("NOW"));
                        $paytermtxn->setApplicationUserId($this->session->get('EMPID'));
                        $paytermtxn->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($paytermtxn);
                        $this->em->flush($paytermtxn);
                    }                                
                }
            }else{
                $ePayTerm=$this->em->getRepository(CommonConstant::ENT_INVOICE_PAY_TERM)->findOneBy(array('paymodeFk'=>$payterms,'invoiceFk'=>$invoice));
                if($ePayTerm){
                    $ePayTerm->setRecordActiveFlag(1);
                    $ePayTerm->setRecordUpdateDate(new \DateTime("NOW"));
                    $ePayTerm->setApplicationUserId($this->session->get('EMPID'));
                    $ePayTerm->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($ePayTerm);
                }else{
                    $paytermtxn=new InvoicePaymentTerms();
                    $paytermtxn->setInvoiceFk($invoice);
                    $paytermtxn->setPaymodeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payterms));
                    $paytermtxn->setRecordInsertDate(new \DateTime("NOW"));
                    $paytermtxn->setRecordActiveFlag(1);   
                    $paytermtxn->setApplicationUserId($this->session->get('EMPID'));
                    $paytermtxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($paytermtxn);
                    $this->em->flush($paytermtxn);
                }                
            }

             //INVOICE ITEM TXN
            if(is_array($includeFlags)){
                for($i=0;$i<count($includeFlags);$i++){
                    $flag=$includeFlags[$i];
                    if($flag=='1'){
                        if($invItemIds[$i]!=''){ //if existing item
                            $itemtxn=$this->em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->find($invItemIds[$i]);
                            $itemtxn->setRecordUpdateDate(new \DateTime("NOW"));
                            $itemtxn->setApplicationUserId($this->session->get('EMPID'));
                            $itemtxn->setApplicationUserIpAddress($this->session->get('IP'));
                        }else{ //if item is new
                            $itemtxn=new InvoiceItemTxn();
                            if($itemType[$i]=='is'){//if item is from project_item_txn
                                $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemIds[$i]);
                                $itemtxn->setItemFk($item);
                            }elseif($itemType[$i]=='expense'){//if item is from project_expense
                                $item=$this->em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)->find($itemIds[$i]);
                                $itemtxn->setExpenseFk($item);
                            }
                            $itemtxn->setInvoiceFk($invoice);
                            $itemtxn->setUnit($units[$i]);
                            $itemtxn->setUnitPrice($unitPrices[$i]);
                            $itemtxn->setQuantity($quantities[$i]);                            
                            $itemtxn->setRecordInsertDate(new \DateTime("NOW")); 
                            $itemtxn->setApplicationUserId($this->session->get('EMPID'));
                            $itemtxn->setApplicationUserIpAddress($this->session->get('IP'));
                        }                                              
                                                
                        $itemtxn->setDescription($descriptions[$i]);                        
                        $itemtxn->setMarkupPrice($mPrices[$i]);                        
                        $itemtxn->setTaxPc($taxpcs[$i]);
                        $itemtxn->setTaxAmt($taxamts[$i]);
                        $itemtxn->setTotal($itemtotals[$i]);
                        $itemtxn->setIsDiscounted($discountFlags[$i]);
                        $itemtxn->setRecordActiveFlag(1);
                        if($invItemIds[$i]==''){
                            $item->setIsBilled(1);
                            $this->em->flush($item);
                            $this->em->persist($itemtxn);
                        }
                        $this->em->flush($itemtxn);               
                    }
                    elseif($invItemIds[$i]!=''){ //if existing item and unselected then removed item from invoice
                        $invitem=$this->em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->find($invItemIds[$i]);
                        $invitem->setRecordActiveFlag(0);
                        $invitem->setRecordUpdateDate(new \DateTime("NOW"));
                        $invitem->setApplicationUserId($this->session->get('EMPID'));
                        $invitem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush($invitem);
                        //Make Item available for billing next time
                        $projitem=$invitem->getItemFk();
                        $projitem->setIsBilled(0);
                        $projitem->setRecordUpdateDate(new \DateTime("NOW"));
                        $projitem->setApplicationUserId($this->session->get('EMPID'));
                        $projitem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush($projitem);
                    }
                }
            }else{

                    if($includeFlags=='1'){
                        if($invItemIds=''){ //if existing item
                            $itemtxn=$this->em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->find($invItemIds);
                            $itemtxn->setRecordUpdateDate(new \DateTime("NOW"));
                            $itemtxn->setApplicationUserId($this->session->get('EMPID'));
                            $itemtxn->setApplicationUserIpAddress($this->session->get('IP'));
                        }else{ //if item is new
                            $itemtxn=new InvoiceItemTxn();
                            if($itemType[$i]=='is'){//if item is from project_item_txn
                                $item=$this->em->getRepository(CommonConstant::ENT_PROJ_ITEM_TXN)->find($itemIds);
                                $itemtxn->setItemFk($item);
                            }elseif($itemType[$i]=='expense'){//if item is from project_expense
                                $item=$this->em->getRepository(CommonConstant::ENT_PROJ_EXPENSE)->find($itemIds);
                                $itemtxn->setExpenseFk($item);
                            }
                            $itemtxn->setInvoiceFk($invoice);
                            $itemtxn->setUnit($units);
                            $itemtxn->setUnitPrice($unitPrices);
                            $itemtxn->setQuantity($quantities);                            
                            $itemtxn->setRecordInsertDate(new \DateTime("NOW"));
                            $itemtxn->setApplicationUserId($this->session->get('EMPID'));
                            $itemtxn->setApplicationUserIpAddress($this->session->get('IP'));
                        }                                              
                                                
                        $itemtxn->setDescription($descriptions);                        
                        $itemtxn->setMarkupPrice($mPrices);                        
                        $itemtxn->setTaxPc($taxpcs);
                        $itemtxn->setTaxAmt($taxamts);
                        $itemtxn->setTotal($itemtotals);
                        $itemtxn->setIsDiscounted($discountFlags);
                        $itemtxn->setRecordActiveFlag(1);
                        if($invItemIds==''){
                            $item->setIsBilled(1);
                            $this->em->flush($item);
                            $this->em->persist($itemtxn);
                        }
                        $this->em->flush($itemtxn);               
                    }
                    elseif($invItemIds!=''){ //if existing item and unselected then removed item from invoice
                        $invitem=$this->em->getRepository(CommonConstant::ENT_INVOICE_ITEM_TXN)->find($invItemIds);
                        $invitem->setRecordActiveFlag(0);
                        $invitem->setRecordUpdateDate(new \DateTime("NOW"));
                        $invitem->setApplicationUserId($this->session->get('EMPID'));
                        $invitem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush($invitem);
                        //Make Item available for billing next time
                        $projitem=$invitem->getItemFk();
                        $projitem->setIsBilled(0);
                        $projitem->setRecordUpdateDate(new \DateTime("NOW"));
                        $projitem->setApplicationUserId($this->session->get('EMPID'));
                        $projitem->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush($projitem);
                    }
            }
            $conn->commit();
            $returnCode=1;
            $returnMsg='Invoice detail has been updated successfully.';
                                
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode=0;
            $returnMsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returnCode,'msg'=>$returnMsg,'invoice'=>$invoice);
    }
}

