<?php
namespace Tashi\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
class CustomerMasterRepository  extends EntityRepository{
   public function getCustomerList($searchName) {
       $condquery='';
        if(!(empty(trim($searchName)))){
          $condquery="AND cd.customerName like '$searchName%'";   
        }
        // $em instanceof EntityManager
        $em = $this->getEntityManager(); 
        $query = $em->createQuery(" 
                                SELECT
                                    cd.customerIdPk pkid,
                                    cd.customerId custId,
                                    cd.customerName customerName,
                                    ca.address1 address,
                                    ca.cityName city,
                                   
                                    cat.addressTypeName addressType
                                FROM 
                                    TashiCommonBundle:CusCustomer cd,
                                    TashiCommonBundle:CmnLocationAddressMaster ca,
                                    TashiCommonBundle:CusAddressTxn cda,
                                    TashiCommonBundle:CmnLocationAddressTypeMaster cat,
                                    
                                    WHERE 
                                    cd.customerIdPk = cda.customerFk
                                    AND
                                    cda.addressFk=ca.addressPk
                                    AND
                                    ca.addressTypeFk=cat.addressTypePk
                                    AND 
                                    cd.customerType = ct.customerTypePk
                                    AND
                                    cda.isPrimaryAddress=1
                                    AND 
                                    cda.approvalFlag=1
                                    AND
                                    cda.recordActiveFlag=1
                                    ".$condquery);
        return $query->getResult();
   }
   public function getCustomerDetails($customerId){
        // $em instanceof EntityManager
        $em = $this->getEntityManager(); 
        
        $query = $em->createQuery(" 
                                SELECT
                                    cd.customerIdPk pkid,
                                    cd.customerId custId,
                                    cd.customerName customerName,
                                    
                                    mnm.mobileNo mobileno
                                FROM 
                                    TashiCommonBundle:CusCustomer cd,
                                    
                                    TashiCommonBundle:TbCimContactTxn cct,
                                    TashiCommonBundle:CmnMobileNoMaster mnm,
                                    TashiCommonBundle:CimContactMobileNoTxn mnt
                                    WHERE                                     
                                    cd.customerType = ct.customerTypePk
                                    AND
                                    cd.customerIdPk = cct.customerFk
                                    AND
                                    mnt.contact = cct.pkid
                                    AND
                                    mnt.mobileNo = mnm.pkid
                                    AND
                                    cct.isPrimaryContact=1
                                    AND
                                    cd.customerId= ".$customerId);
        // Execute Query
        return $query->getSingleResult();
   }  
   
    public function findcustByAnyCondition($keyword, $parameterValues)
    {  
        try{
        // $em instanceof EntityManager
            $em = $this->getEntityManager();
            if(is_null($keyword) || empty($keyword)){
                $query = $em->createQuery(" 
                                        SELECT
                                            Mtxn,mobile,cu,customer
                                        FROM 
                                            TashiCommonBundle:CusContactMobileNoTxn Mtxn                              
                                        JOIN Mtxn.mobileNo mobile
                                        JOIN Mtxn.contact cu                                        
                                        JOIN cu.customerFk customer 
                                        where cu.isPrimaryContact=1 and customer.statusFlag=1 and customer.recordActiveFlag=1 order by customer.customerName");
            }
            else{
                $query = $em->createQuery(" 
                                        SELECT
                                            Mtxn,mobile,cu,customer
                                        FROM 
                                            TashiCommonBundle:CusContactMobileNoTxn Mtxn 
                                        JOIN Mtxn.mobileNo mobile
                                        JOIN Mtxn.contact cu
                                        JOIN cu.customerFk customer
                                        WHERE ".$keyword." and customer.statusFlag=1 and customer.recordActiveFlag=1 order by customer.customerName")->setParameters($parameterValues);
            }
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
      public function findpendingCust()
      {  
        
        // $em instanceof EntityManager
        $em = $this->getEntityManager();
        $query = $em->createQuery(" 
                                 SELECT
                                    cd.customerIdPk pkid,
                                    cd.customerId custId,
                                    cd.customerName customerName,
                                    ca.cityName city,
                                    ca.address1 address,
                                    Mtxn.pkid mobtxnpkid
                                   
                                FROM 
                                    TashiCommonBundle:CusCustomer cd,
                                    TashiCommonBundle:TbCmnAddress ca,
                                    TashiCommonBundle:CusAddressTxn cda,
                                    TashiCommonBundle:TbCimContactTxn Ctxn,
                                    TashiCommonBundle:CimContactMobileNoTxn Mtxn
                                   
                                  
                                WHERE 
                                    cd.customerIdPk = cda.customerFk
                                    AND
                                    cda.addressFk=ca.addressPk
                                    AND
                                    cd.customerIdPk=Ctxn.customerFk
                                    AND
                                    Ctxn.pkid=Mtxn.contact
                                    ");
        
    
        return $query->getResult();
     }
     
     public function findpendingCustQB()
      {  
        
        // $em instanceof EntityManager
        $fields = array('cda.pkid pkid',
                        'cd.custFullName custFullName', 'cd.pkid cdpkid');
       // $fields = 'partial cda.{pkid, cust}';
            //, partial o.{id}';  //if you want to get entity object

            $query = $this->getEntityManager()->createQueryBuilder();
            $query
                    ->select($fields)
                    ->from('TashiCommonBundle:TbCusCustomerAddressTxn', 'cda')
                    ->join('cda.cust', 'cd');
                    //->from('TashiCommonBundle:TbCusCustomerMobileNo', 'mobNo')
                    //->leftjoin('mobNo.cust= cd.pkid');
                    
        
    
        return $query->getQuery()->getResult();
     }
     
     
    //By JONJU for Getting Customer Detail for Creating New Order     
    public function findCustomerForOrder($criteria,$entity,$searchfield){
       $em=$this->getEntityManager();
       $qb=$em->createQueryBuilder();    
       switch($entity){
           case 'CUSTOMER':
               switch($criteria){
                   case 'id':
                       $qb->select('contxn')
                           ->from('TashiCommonBundle:TbCimContactTxn','contxn')
                           ->join('contxn.customerFk','cust')
                           ->where($qb->expr()->andX(
                                   $qb->expr()->eq('cust.customerId','\''.$searchfield.'\''),
                                   $qb->expr()->eq('cust.statusFlag',1)
                                   ))
                           ->groupBy('cust.customerIdPk')
                           ->orderBy('cust.customerName');
                       break;
                   case 'name':
                       $qb->select('contxn')
                           ->from('TashiCommonBundle:TbCimContactTxn','contxn')
                           ->join('contxn.customerFk','cust')
                           ->where($qb->expr()->andX(
                                   $qb->expr()->like('cust.customerName','\'%'.$searchfield.'%\''),
                                   $qb->expr()->eq('cust.statusFlag',1)
                                   ))
                           ->groupBy('cust.customerIdPk')
                           ->orderBy('cust.customerName');
                       break;
                   case 'mobno':
                       $qb->select('contxn')
                           ->from('TashiCommonBundle:TbCimContactTxn','contxn')
                           ->join('contxn.customerFk','cust')                           
                           ->join('TashiCommonBundle:CimContactMobileNoTxn','conmobtxn',
                                   Expr\Join::WITH,$qb->expr()->eq('contxn.pkid','conmobtxn.contact'))
                           ->join('conmobtxn.mobileNo','mob')//cmn_mobile_no_master
                           ->where($qb->expr()->andX(
                                   $qb->expr()->like('mob.mobileNo','\'%'.$searchfield.'\''),
                                   //$qb->expr()->eq('cust.statusFlag',1),
                                   $qb->expr()->eq('conmobtxn.approvalFlag', 1),
                                   $qb->expr()->eq('conmobtxn.recordActiveFlag', 1),
                                   $qb->expr()->eq('contxn.approvalFlag', 1),
                                   $qb->expr()->eq('contxn.recordActiveFlag', 1),
                                   $qb->expr()->eq('mob.approvalFlag', 1),
                                   $qb->expr()->eq('mob.recordActiveFlag', 1)                             
                               ))
                           ->groupBy('cust.customerIdPk')
                           ->orderBy('cust.customerName');                     
                   break;
               }   
               break;
           case 'ADDRESS':
               switch($criteria){
                   case 'id':
                       $qb->select('cimaddtxn')
                           ->from('TashiCommonBundle:CusAddressTxn','cimaddtxn')
                           ->join('cimaddtxn.customerFk','cust')
                           ->where($qb->expr()->andX(
                                   $qb->expr()->eq('cust.customerId','\''.$searchfield.'\''),
                                   $qb->expr()->eq('cust.statusFlag',1),
                                   $qb->expr()->eq('cimaddtxn.approvalFlag',1),
                                   $qb->expr()->eq('cimaddtxn.recordActiveFlag',1)
                                   ))
                           ->orderBy('cust.customerName');
                       break;
                   case 'name':
                       $qb->select('cimaddtxn')
                           ->from('TashiCommonBundle:CusAddressTxn','cimaddtxn')
                           ->join('cimaddtxn.customerFk','cust')
                           ->where($qb->expr()->andX(
                                   $qb->expr()->like('cust.customerName','\'%'.$searchfield.'%\''),
                                   $qb->expr()->eq('cust.statusFlag',1),
                                   $qb->expr()->eq('cimaddtxn.approvalFlag',1),
                                   $qb->expr()->eq('cimaddtxn.recordActiveFlag',1)
                                   ))
                           ->orderBy('cust.customerName');
                       break;
                   case 'mobno':
                       $qb->select('cimaddtxn')
                           ->from('TashiCommonBundle:CusAddressTxn','cimaddtxn')
                           ->join('cimaddtxn.customerFk','cust')
                           ->join('TashiCommonBundle:TbCimContactTxn','cimcon',
                                   Expr\Join::WITH,$qb->expr()->eq('cust.customerIdPk','cimcon.customerFk'))
                           ->join('TashiCommonBundle:CimContactMobileNoTxn','conmobtxn',
                                   Expr\Join::WITH,$qb->expr()->eq('cimcon.pkid','conmobtxn.contact'))
                           ->join('conmobtxn.mobileNo','mob')//cmn_mobile_no_master
                           ->where($qb->expr()->andX(
                                   $qb->expr()->like('mob.mobileNo','\'%'.$searchfield.'\''),
                                   $qb->expr()->eq('cimaddtxn.approvalFlag',1),
                                   $qb->expr()->eq('cimaddtxn.recordActiveFlag',1),
                                   $qb->expr()->eq('conmobtxn.approvalFlag', 1),
                                   $qb->expr()->eq('conmobtxn.recordActiveFlag', 1),
                                   $qb->expr()->eq('cimcon.approvalFlag', 1),
                                   $qb->expr()->eq('cimcon.recordActiveFlag', 1),
                                   $qb->expr()->eq('mob.approvalFlag', 1),
                                   $qb->expr()->eq('mob.recordActiveFlag', 1)                             
                               ));                     
                   break;
               }   
               break;
           case 'MOBILE':
               switch($criteria){
                   case 'id':
                       $qb->select('conmobtxn')
                           ->from('TashiCommonBundle:CimContactMobileNoTxn','conmobtxn')
                           ->join('conmobtxn.contact','cimcon') //tb_cim_contact_txn
                           ->join('cimcon.customerFk','cust') //tb_cim_customer
                           ->join('conmobtxn.mobileNo','mob')
                           ->where($qb->expr()->andX(
                                   $qb->expr()->eq('cust.customerId','\''.$searchfield.'\''),
                                   $qb->expr()->eq('conmobtxn.approvalFlag', 1),
                                   $qb->expr()->eq('conmobtxn.recordActiveFlag', 1),
                                   $qb->expr()->eq('cust.statusFlag',1),
                                   $qb->expr()->eq('cimcon.approvalFlag',1),
                                   $qb->expr()->eq('cimcon.recordActiveFlag',1),
                                   $qb->expr()->eq('mob.approvalFlag', 1),
                                   $qb->expr()->eq('mob.recordActiveFlag', 1)
                                   ))
                           ->orderBy('cust.customerName');
                       break;
                   case 'name':
                       $qb->select('conmobtxn')
                           ->from('TashiCommonBundle:CimContactMobileNoTxn','conmobtxn')
                           ->join('conmobtxn.contact','cimcon') //tb_cim_contact_txn
                           ->join('cimcon.customerFk','cust') //tb_cim_customer
                           ->join('conmobtxn.mobileNo','mob')
                           ->where($qb->expr()->andX(
                                   $qb->expr()->like('cust.customerName','\'%'.$searchfield.'%\''),
                                   $qb->expr()->eq('conmobtxn.approvalFlag', 1),
                                   $qb->expr()->eq('conmobtxn.recordActiveFlag', 1),
                                   $qb->expr()->eq('cust.statusFlag',1),
                                   $qb->expr()->eq('cimcon.approvalFlag',1),
                                   $qb->expr()->eq('cimcon.recordActiveFlag',1),
                                   $qb->expr()->eq('mob.approvalFlag', 1),
                                   $qb->expr()->eq('mob.recordActiveFlag', 1)
                                   ))
                           ->orderBy('cust.customerName');
                       break;
                   case 'mobno':
                       $qb->select('conmobtxn')
                           ->from('TashiCommonBundle:CimContactMobileNoTxn','conmobtxn')
                           ->join('conmobtxn.contact','cimcon') //tb_cim_contact_txn
                           ->join('conmobtxn.mobileNo','mob')//cmn_mobile_no_master
                           ->join('cimcon.customerFk','cust') //tb_cim_customer
                           ->where($qb->expr()->andX(
                                   $qb->expr()->like('mob.mobileNo','\'%'.$searchfield.'\''),
                                   $qb->expr()->eq('cust.statusFlag',1),                                  
                                   $qb->expr()->eq('conmobtxn.approvalFlag', 1),
                                   $qb->expr()->eq('conmobtxn.recordActiveFlag', 1),
                                   $qb->expr()->eq('cimcon.approvalFlag', 1),
                                   $qb->expr()->eq('cimcon.recordActiveFlag', 1),
                                   $qb->expr()->eq('mob.approvalFlag', 1),
                                   $qb->expr()->eq('mob.recordActiveFlag', 1)                             
                               ));                     
                   break;
               }   
               break;
       }
       $query=$qb->getQuery();
       return $query->getResult();
    }
    public function makeUpdateAddress($id,$addressTypeId,$TxnTableName) {         

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT count(r.address1) Num FROM TashiCommonBundle:CmnLocationAddressMaster r INNER JOIN '.$TxnTableName.' s 
            WHERE r.addressPk=s.addressFk and r.addressTypeFk='.$addressTypeId.' and s.customerFk='.$id);   
       
        return $query->getResult();
    }
     public function listAddressOrderByType($id,$TxnTableName) {         

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT s FROM TashiCommonBundle:CmnLocationAddressMaster r,'.$TxnTableName.' s, TashiCommonBundle:CmnLocationAddressTypeMaster cim
            WHERE r.addressPk=s.addressFk and s.customerFk='.$id.' and r.recordActiveFlag=1 and s.recordActiveFlag=1 order by s.isPrimaryAddress DESC,s.addressCode ASC');   
       
        return $query->getResult();
    }
    public function listOfCustomerLike($customerName,$contactName) {         

       $em = $this->getEntityManager();
       $query = $em->createQuery('SELECT r FROM TashiCommonBundle:CusCustomer r INNER JOIN TashiCommonBundle:CusContactTxn txn with r.customerIdPk=txn.customerFk
                                                                                INNER JOIN TashiCommonBundle:CmnPerson person with person.personPk=txn.personFk
                                                                                WHERE txn.isPrimaryContact=1 AND txn.recordActiveFlag=1 AND person.recordActiveFlag=1
                                                                                AND r.recordActiveFlag=1
                                                                                and (r.customerName LIKE :uiCustomerName or person.personName LIKE :uiContactName)')
         ->setParameters(array('uiCustomerName'=>($customerName.'%'),'uiContactName'=>($contactName.'%'))); 
       
        return $query->getResult();
    }
    public function findcustforComByAnyCondition($keyword, $parameterValues)
    {  
        try{
        // $em instanceof EntityManager
            $em = $this->getEntityManager();
            if(is_null($keyword) || empty($keyword)){
                $query = $em->createQuery(" 
                                        SELECT
                                            Mtxn
                                        FROM 
                                            TashiCommonBundle:CusContactMobileNoTxn Mtxn                              
                                        JOIN Mtxn.mobileNo mobile
                                        JOIN Mtxn.contact cu                                        
                                        JOIN cu.customerFk customer 
                                        WHERE cu.isPrimaryContact=1 AND cu.approvalFlag=1 AND cu.recordActiveFlag=1
                                        order by customer.customerName");
            }
            else{
                $query = $em->createQuery(" 
                                        SELECT
                                            Mtxn,mobile,cu,customer
                                        FROM 
                                            TashiCommonBundle:CusContactMobileNoTxn Mtxn 
                                        JOIN Mtxn.mobileNo mobile
                                        JOIN Mtxn.contact cu
                                        JOIN cu.customerFk customer
                                        WHERE ".$keyword." AND cu.isPrimaryContact=1 AND cu.approvalFlag=1 AND cu.recordActiveFlag=1
                                        order by customer.customerName")->setParameters($parameterValues);
            }
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    public function FindContactByCustId($custid){
        $em=$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('conmobtxn')
                ->from('TashiCommonBundle:CusContactMobileNoTxn', 'conmobtxn')
                ->join('conmobtxn.contact','cont')
                ->join('cont.customerFk','cust')
                ->join('cont.personFk','person')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cust.customerIdPk',$custid),
                        $qb->expr()->eq('cust.recordActiveFlag',1),
                        $qb->expr()->eq('cont.recordActiveFlag',1),
                        $qb->expr()->eq('conmobtxn.recordActiveFlag',1),
                        $qb->expr()->eq('person.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function FindOtherPrimaryContact($contactid,$custid){
        $em=$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('cont')
                ->from('TashiCommonBundle:CusContactTxn','cont')
                ->join('cont.customerFk','cust')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cust.customerIdPk',$custid),
                        $qb->expr()->neq('cont.pkid',$contactid),
                        $qb->expr()->eq('cont.isPrimaryContact',1),
                        $qb->expr()->eq('cust.recordActiveFlag',1),
                        $qb->expr()->eq('cont.recordActiveFlag',1)                  
                        ));
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function CheckOtherEmailExist($contactid,$email){
        $em=$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('cont')
                ->from('TashiCommonBundle:CusContactTxn','cont')
                ->join('cont.personFk','person')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('person.emailId','\''.$email.'\''),
                        $qb->expr()->neq('cont.pkid',$contactid),   
                        $qb->expr()->eq('person.recordActiveFlag',1)                  
                        ));
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function CheckOtherMobileExist($contactid,$mobileno){
        $em=$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('conmobtxn')
                ->from('TashiCommonBundle:CusContactMobileNoTxn', 'conmobtxn')
                ->join('conmobtxn.contact','cont')
                ->join('conmobtxn.mobileNo','mob')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('mob.mobileNo','\''.$mobileno.'\''),
                        $qb->expr()->neq('cont.pkid',$contactid),   
                        $qb->expr()->eq('mob.recordActiveFlag',1)                  
                        ));
        $query=$qb->getQuery();
        return $query->getResult();       
    } 
    public function GetPendingHodPaymentCount(){
        $em=$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('count(adv.advancePaymentPk)')
                ->from('TashiCommonBundle:CusAdvancePayment', 'adv')               
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('adv.paymentStatus','\'C\''),
                        $qb->expr()->eq('adv.hodApprove', 0),
                        $qb->expr()->eq('adv.recordActiveFlag',1)                  
                        ));
        $query=$qb->getQuery();
        return $query->getResult();       
    } 
    
    public function GetPendingPaymentCount(){
        $em=$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('count(adv.advancePaymentPk)')
                ->from('TashiCommonBundle:CusAdvancePayment', 'adv')               
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('adv.paymentStatus','\'C\''),
                        $qb->expr()->eq('adv.hodApprove', 1),
                        $qb->expr()->eq('adv.recordActiveFlag',1)                  
                        ));
        $query=$qb->getQuery();
        return $query->getResult();       
    } 
}

