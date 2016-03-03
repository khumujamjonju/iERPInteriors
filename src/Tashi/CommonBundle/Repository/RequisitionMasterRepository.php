<?php
namespace Tashi\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
 
class RequisitionMasterRepository extends EntityRepository
{
    
    
    
    
    public function findRequisitionAll()
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT reqmaster  
                             
                          FROM TashiCommonBundle:RequisitionMaster reqmaster
                          
                          INNER JOIN TashiCommonBundle:RequisitionProductDetails reqproduct
                          WITH reqmaster.pkid = reqproduct.requisitionFk
                          
                          INNER JOIN TashiCommonBundle:RequisitionStatusMaster status
                          WITH reqmaster.reqstatusFk = status.pkid and reqmaster.recordActiveFlag=1");
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
    
     public function findRequisitionProduct($id)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                    " SELECT rpro   
                             
                      FROM TashiCommonBundle:RequisitionProductDetails rpro 
                          
                      INNER JOIN TashiCommonBundle:PrdProductMaster prdmaster
                      
                      WITH rpro.productFk = prdmaster.pkid
                      
                      INNER JOIN TashiCommonBundle:ProductUnitTxn unit
                      WITH unit.productFk = prdmaster.pkid 
                      AND rpro.unitFk=unit.pkid
                      WHERE  rpro.recordActiveFlag=1 and rpro.requisitionFk=".$id);
           
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
     public function findbyRequisitionDate($sdate,$endate)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT reqmaster   
                             
                          FROM TashiCommonBundle:RequisitionMaster reqmaster
                          
                          INNER JOIN TashiCommonBundle:RequisitionStatusMaster status
                          WITH reqmaster.reqstatusFk = status.pkid
                          
                          where reqmaster.requisitionDate between '$sdate' and '$endate' " );
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
     public function findResultbyStatus($statusid)
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT reqmaster   
                             
                          FROM TashiCommonBundle:RequisitionMaster reqmaster
                          
                          INNER JOIN TashiCommonBundle:RequisitionStatusMaster status
                          WITH reqmaster.reqstatusFk = status.pkid
                          
                          where reqmaster.reqstatusFk='$statusid'" );
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    
    
     public function findRequisitionforApproval()
    {  
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT reqmaster   
                             
                          FROM TashiCommonBundle:RequisitionMaster reqmaster
                          
                          INNER JOIN TashiCommonBundle:RequisitionStatusMaster status
                          WITH reqmaster.reqstatusFk = status.pkid
        
                          WHERE reqmaster.recordActiveFlag=1 and status.isCompleted = 1 ");
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
     public function findStockResult($reqid)
    {  
        try{
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT  sum(stock.quantity) q   , product.pkid pid ,product.productName name, reqproduct.dueQuantity rq
                            , product.productCode code ,unit.unitName uname , unit.pkid uid
                             
                          FROM TashiCommonBundle:RequisitionProductDetails reqproduct
         
                          INNER JOIN TashiCommonBundle:PrdProductMaster product
                          WITH reqproduct.productFk = product.pkid
                          
                          INNER JOIN TashiCommonBundle:StockMaster stock
                          WITH stock.productFk = product.pkid
        
                          INNER JOIN TashiCommonBundle:RequisitionMaster requisition
                          WITH reqproduct.requisitionFk = requisition.pkid 
                          
                          INNER JOIN TashiCommonBundle:ProductUnitTxn unit
                          WITH reqproduct.unitFk = unit.pkid 
                          
                          WHERE reqproduct.requisitionFk = :reqid 
                          group by stock.productFk "
                           )
                    ->setParameter('reqid', $reqid);
                 $result = $query->getResult();
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $result;
    }
    
    
     public function findRequisitionByReqNo($reqno)
    {  
        try
         {
            $em = $this->getEntityManager(); 
            $query = $em->createQuery
                    (
                        " SELECT rproduct   
                          FROM  TashiCommonBundle:RequisitionProductDetailsHistory rproduct
                          INNER JOIN  rproduct.requisitionFk   reqmaster
                          
                          WHERE reqmaster.recordActiveFlag=1 and reqmaster.approvalflag = 1 and reqmaster.uiReqId='$reqno' ");
                    }
        catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
} 
    
    
 
 