<?php
namespace Tashi\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
 
class PurchaseMasterRepository extends EntityRepository
{
   
   public function findPurchaseforApproval()
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT pomaster   
                             
                          FROM TashiCommonBundle:PoMaster pomaster
                          
                          INNER JOIN TashiCommonBundle:SupplierMaster sup
                          WITH pomaster.vendorMasterFk = sup.supplierPk
  
                          INNER JOIN TashiCommonBundle:PoStatusMaster status
                          WITH pomaster.statusFk = status.pkid 
        
                          WHERE pomaster.recordActiveFlag=1  and pomaster.approvalflag = 0 and status.pkid not in(2,3,4,5)");
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
     
     public function findPurchaseAll()
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT pomaster   
                             
                          FROM TashiCommonBundle:PoMaster pomaster
                          
                          INNER JOIN TashiCommonBundle:SupplierMaster sup
                          WITH pomaster.vendorMasterFk = sup.supplierPk
  
                          INNER JOIN TashiCommonBundle:PoStatusMaster status
                          WITH pomaster.statusFk = status.pkid ");
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
 
      public function findbyOrderNO($OrderNO)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT pomaster   
                             
                          FROM TashiCommonBundle:PoMaster pomaster
                          
                          INNER JOIN TashiCommonBundle:SupplierMaster sup
                          WITH pomaster.vendorMasterFk = sup.supplierPk
  
                          INNER JOIN TashiCommonBundle:PoStatusMaster status
                          WITH pomaster.statusFk = status.pkid
                          
                          where pomaster.uiOrderId='$OrderNO'" );
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
      public function findbyPODate($sdate,$endate)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT pomaster   
                             
                          FROM TashiCommonBundle:PoMaster pomaster
                          
                          INNER JOIN TashiCommonBundle:SupplierMaster sup
                          WITH pomaster.vendorMasterFk = sup.supplierPk
  
                          INNER JOIN TashiCommonBundle:PoStatusMaster status
                          WITH pomaster.statusFk = status.pkid
                          
                          where pomaster.orderDate between '$sdate' and '$endate' " );
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
        public function findbyExpDate($sdate,$endate)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT pomaster   
                             
                          FROM TashiCommonBundle:PoMaster pomaster
                          
                          INNER JOIN TashiCommonBundle:SupplierMaster sup
                          WITH pomaster.vendorMasterFk = sup.supplierPk
  
                          INNER JOIN TashiCommonBundle:PoStatusMaster status
                          WITH pomaster.statusFk = status.pkid
                          
                          where pomaster.expectedDelivery between '$sdate' and '$endate' " );
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
    
    
     public function findbyStatus($statusid)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT pomaster   
                             
                          FROM TashiCommonBundle:PoMaster pomaster
                          
                          INNER JOIN TashiCommonBundle:SupplierMaster sup
                          WITH pomaster.vendorMasterFk = sup.supplierPk
  
                          INNER JOIN TashiCommonBundle:PoStatusMaster status
                          WITH pomaster.statusFk = status.pkid
                          
                          where pomaster.statusFk='$statusid'" );
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
     public function findProduct($PO)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                    " SELECT pro   
                             
                      FROM TashiCommonBundle:PoProductDetails pro 
                          
                      INNER JOIN TashiCommonBundle:PrdProductMaster prdmaster
                      
                      WITH pro.productFk = prdmaster.pkid
                      
                      INNER JOIN TashiCommonBundle:ProductUnitTxn unit
                      WITH unit.productFk = prdmaster.pkid 
                      AND pro.unitFk=unit.pkid
                      WHERE  pro.recordActiveFlag=1 and pro.poFk=".$PO);
           
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
    public function DisplayProjectList()
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                    " SELECT prostatustxn  
                             
                      FROM TashiCommonBundle:ProjectStatusTxn prostatustxn 
                          
                      INNER JOIN TashiCommonBundle:ProjectMaster promaster
                      
                      WITH prostatustxn.projectFk = promaster.pkid
                      
                      INNER JOIN TashiCommonBundle:ProjectStatusMaster prostatus
                      WITH promaster.status = prostatus.pkid 
                      
                      AND prostatustxn.statusFk=prostatus.pkid
                      WHERE  prostatus.recordActiveFlag=1 AND prostatus.isPermanent= 0");
           
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
    //findPurchaseTxnbyID
    
    
    public function findPurchaseTxnbyID($POCode)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(" SELECT  statusmaster.pkid s, postatustxn.pkdi id
                       
                     FROM TashiCommonBundle:PoStatusTxn postatustxn   
                     join postatustxn.statusFk  statusmaster
                     
                      
                      WHERE postatustxn.pkdi= (SELECT MAX(postatus.pkdi) FROM TashiCommonBundle:PoStatusTxn postatus where postatus.poFk=:POCode)"
                     );
       
            $query->setParameters(array('POCode' => $POCode));
            
            $result = $query->getResult();
//            print_r($result);die();
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $result;
    }
    
    
    
    
    
    
    
} 
    
    
 
 