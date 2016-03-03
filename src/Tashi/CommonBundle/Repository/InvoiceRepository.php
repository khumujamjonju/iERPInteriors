<?php
namespace Tashi\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InvoiceRepository
 *
 * @author KHUMUPOKPAM
 */
class InvoiceRepository extends EntityRepository{
    public function SearchAllProjectCustomer(){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('cust')
                ->from('TashiCommonBundle:CusCustomer','cust') 
                ->join('TashiCommonBundle:ProjectMaster','proj',
                        Expr\Join::WITH,$qb->expr()->eq('cust.customerIdPk','proj.customerFk'))
                ->join('proj.status','status')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cust.recordActiveFlag',1),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                    ))
                ->orderBy('cust.customerName');
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function GetProjectByCustIdName($idname){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj') 
                ->join('proj.customerFk','cust')
                ->where($qb->expr()->orX(
                        $qb->expr()->eq('cust.customerId','\''.$idname.'\''),
                        $qb->expr()->like('cust.customerName','\'%'.trim($idname).'%\'')
                        ))                
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetAllAddressByCustId($custid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('add')
                ->from('TashiCommonBundle:CmnLocationAddressMaster','add') 
                ->join('TashiCommonBundle:CusAddressTxn','addtxn',
                        Expr\Join::WITH,$qb->expr()->eq('add.addressPk','addtxn.addressFk'))
                ->join('addtxn.customerFk','cust')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cust.customerIdPk',$custid),
                        $qb->expr()->eq('addtxn.recordActiveFlag',1),
                        $qb->expr()->eq('add.recordActiveFlag',1)
                        ))         
                ->orderBy('add.address1','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetUnbilledItems($projid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('item')
                ->from('TashiCommonBundle:ProjectItemTxn','item') 
                ->join('item.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.pkid',$projid),
                        $qb->expr()->neq('item.itemFk','\'NULL\''),
                        $qb->expr()->eq('item.isBilled',0),
                        $qb->expr()->eq('item.recordActiveFlag',1)
                        ))         
                ->orderBy('item.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetUnbilledServices($projid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('item')
                ->from('TashiCommonBundle:ProjectItemTxn','item') 
                ->join('item.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.pkid',$projid),
                        $qb->expr()->neq('item.serviceFk','\'NULL\''),
                        $qb->expr()->eq('item.isBilled',0),
                        $qb->expr()->eq('item.recordActiveFlag',1)
                        ))         
                ->orderBy('item.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoiceByProjectId($projid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('invoice')
                ->from('TashiCommonBundle:InvoiceMaster','invoice') 
                ->join('invoice.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.pkid',$projid),
                        $qb->expr()->eq('invoice.recordActiveFlag',1)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoiceByOrderNo($ordno){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('invoice')
                ->from('TashiCommonBundle:InvoiceMaster','invoice') 
                ->join('invoice.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.orderNo','\''.$ordno.'\''),
                        $qb->expr()->eq('proj.recordActiveFlag',1),
                        $qb->expr()->eq('invoice.recordActiveFlag',1)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoiceByCustomer($custnameid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('invoice')
                ->from('TashiCommonBundle:InvoiceMaster','invoice') 
                ->join('invoice.projectFk','proj')
                ->join('proj.customerFk','cust')
                ->where($qb->expr()->orX(
                        $qb->expr()->like('cust.customerName','\'%'.$custnameid.'%\''),
                        $qb->expr()->eq('cust.customerId','\''.$custnameid.'\'')
                        ))
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('proj.recordActiveFlag',1),
                        $qb->expr()->eq('invoice.recordActiveFlag',1),
                        $qb->expr()->eq('cust.recordActiveFlag',1)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoiceByDate($invdate){
        $em=$this->getEntityManager();     
        $date= (new \DateTime($invdate))->format('Y-m-d');
        $qb=$em->createQueryBuilder();
        $qb->select('invoice')
                ->from('TashiCommonBundle:InvoiceMaster','invoice') 
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('invoice.invoiceDate','\''.$date.'\''),
                        $qb->expr()->eq('invoice.recordActiveFlag',1)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoiceByStatus($status){
        $em=$this->getEntityManager();     
        $qb=$em->createQueryBuilder();
        $qb->select('invoice')
                ->from('TashiCommonBundle:InvoiceMaster','invoice') 
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('invoice.approvalFlag',$status)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoiceByCustId($custid){
        $em=$this->getEntityManager();     
        $qb=$em->createQueryBuilder();
        $qb->select('invoice')
                ->from('TashiCommonBundle:InvoiceMaster','invoice') 
                ->join('invoice.projectFk','proj')
                ->join('proj.customerFk','cust')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cust.customerIdPk',$custid),
                        $qb->expr()->eq('invoice.approvalFlag',1),
                        $qb->expr()->eq('invoice.recordActiveFlag',1),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetInvoicePaymentByCustId($custid){
        $em=$this->getEntityManager();     
        $qb=$em->createQueryBuilder();
        $qb->select('pay')
                ->from('TashiCommonBundle:InvoicePaymentTxn','pay') 
                ->join('pay.invoiceFk','invoice')
                ->join('invoice.projectFk','proj')
                ->join('proj.customerFk','cust')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cust.customerIdPk',$custid),
                        $qb->expr()->eq('pay.recordActiveFlag',1),
                        $qb->expr()->eq('invoice.approvalFlag',1),
                        $qb->expr()->eq('invoice.recordActiveFlag',1),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))         
                ->orderBy('invoice.invoiceDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
}
