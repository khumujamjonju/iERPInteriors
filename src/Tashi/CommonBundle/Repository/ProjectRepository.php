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
 * Description of ProjectRepository
 *
 * @author KHUMUPOKPAM
 */
class ProjectRepository extends EntityRepository{
    //put your code here
    public function SearchCustomerForProject($keyword){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('cust')
                ->from('TashiCommonBundle:CusCustomer','cust')               
                ->where($qb->expr()->orX(
                        $qb->expr()->eq('cust.customerId','\''.$keyword.'\''),
                        $qb->expr()->like('cust.customerName','\'%'.$keyword.'%\'')
                        ))     
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('cust.recordActiveFlag',1)
                        ))
                ->orderBy('cust.customerName');
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function SearchCustomerAddressesforProject($keyword){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('add')
                ->from('TashiCommonBundle:CusAddressTxn','add')
                ->join('add.customerFk', 'cust')
                ->join('add.addressFk','addmaster')
                ->where($qb->expr()->orX(
                        $qb->expr()->eq('cust.customerId','\''.$keyword.'\''),
                        $qb->expr()->like('cust.customerName','\'%'.$keyword.'%\'')
                        ))            
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('add.recordActiveFlag',1)
                        ))
                ->orderBy('addmaster.address1');
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function SearchCustomerContactsforProject($keyword){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('mob')
                ->from('TashiCommonBundle:CusContactMobileNoTxn','mob')
                ->join('mob.contact','cont')
                ->join('cont.customerFk', 'cust')                          
                ->join('mob.mobileNo','mobmaster')
                ->where($qb->expr()->orX(
                        $qb->expr()->eq('cust.customerId','\''.$keyword.'\''),
                        $qb->expr()->like('cust.customerName','\'%'.$keyword.'%\'')
                        ))            
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('cont.recordActiveFlag',1),
                        $qb->expr()->eq('mob.recordActiveFlag',1)
                        ))
                ->orderBy('mobmaster.mobileNo');
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function GetSortedProductCategoryByAreaId($areaid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('cattxn')
                ->from('TashiCommonBundle:ProjectAreaProdCategoryTxn','cattxn')
                ->join('cattxn.projectAreaFk','area')   
                ->join('cattxn.prodCategoryFk','cat')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('area.pkid',$areaid),
                        $qb->expr()->eq('cattxn.recordActiveFlag',1),
                        $qb->expr()->eq('cat.recordActiveFlag',1)
                        ))
                ->orderBy('cat.categoryName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectItemByAreaId($areaid){
        $em=$this->getEntityManager();      
//        $qb=$em->createQueryBuilder();
//        $qb->select('price')
//                ->from('TashiCommonBundle:PrdProductPriceTxn','price')
//                ->join('price.product','prod')
//                ->join('prod.productCategory','cat')
//                ->join('TashiCommonBundle:ProjectAreaProdCategoryTxn','cattxn',
//                        Expr\Join::WITH,$qb->expr()->eq('cattxn.prodCategoryFk','cat.pkid'))                
//                ->join('cattxn.projectAreaFk','area')
//                ->where($qb->expr()->andX(
//                        $qb->expr()->eq('area.pkid',$areaid),
//                        $qb->expr()->eq('cat.recordActiveFlag',1),
//                        $qb->expr()->eq('cattxn.recordActiveFlag',1),
//                        $qb->expr()->eq('prod.recordActiveFlag',1),
//                        $qb->expr()->eq('price.recordActiveFlag',1)
//                        ))
//                ->orderBy('cat.categoryName','ASC');
//        $query=$qb->getQuery();
//        return $query->getResult();
        $str='Select price from TashiCommonBundle:PrdProductPriceTxn price inner join price.product prod inner join prod.productCategory cat'
                . ' inner join TashiCommonBundle:ProjectAreaProdCategoryTxn cattxn with cat.pkid=cattxn.prodCategoryFk inner join cattxn.projectAreaFk area'
                . ' where area.pkid='.$areaid.' and area.recordActiveFlag=1 and cat.recordActiveFlag=1 and cattxn.recordActiveFlag=1 
                    and prod.recordActiveFlag=1  and price.recordActiveFlag=1 order by cat.categoryName ASC';
        $query=$em->createQuery($str);
        return $query->getResult();
        
        
    }
    public function GetPriceByCatId($catid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('price')
                ->from('TashiCommonBundle:PrdProductPriceTxn','price')
                ->join('price.product','prod')
                ->join('prod.productCategory','cat')                
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cat.pkid',$catid),
                        $qb->expr()->eq('cat.recordActiveFlag',1),                        
                        $qb->expr()->eq('prod.recordActiveFlag',1),
                        $qb->expr()->eq('price.recordActiveFlag',1)
                        ))
                ->orderBy('cat.categoryName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetItemUnitsByCatId($catid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('unit')
                ->from('TashiCommonBundle:ProductUnitTxn','unit')
                ->join('unit.productFk','prod')        
                ->join('prod.productCategory','cat')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cat.pkid',$catid),
                        $qb->expr()->eq('cat.recordActiveFlag',1),                       
                        $qb->expr()->eq('prod.recordActiveFlag',1),
                        $qb->expr()->eq('unit.recordActiveFlag',1)
                        ))
                ->orderBy('unit.unitName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetExistingServiceByCatId($catid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('service')
                ->from('TashiCommonBundle:PrdServiceTxn','service')
                ->join('service.productFk','prod')
                ->join('prod.productCategory','cat')                 
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('cat.pkid',$catid),
                        $qb->expr()->eq('service.recordActiveFlag',1),
                        $qb->expr()->eq('prod.recordActiveFlag',1),
                        $qb->expr()->eq('cat.recordActiveFlag',1)
                        ))
                ->orderBy('service.serviceName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
     public function GetItemUnitsByAreaId($areaid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('unit')
                ->from('TashiCommonBundle:ProductUnitTxn','unit')
                ->join('unit.productFk','prod')                
                ->join('TashiCommonBundle:ProjectAreaProdCategoryTxn','cattxn',
                        Expr\Join::WITH,$qb->expr()->eq('cattxn.prodCategoryFk','prod.productCategory'))
                ->join('prod.productCategory','cat')
                ->join('cattxn.projectAreaFk','area')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('area.pkid',$areaid),
                        $qb->expr()->eq('cat.recordActiveFlag',1),
                        $qb->expr()->eq('cattxn.recordActiveFlag',1),
                        $qb->expr()->eq('prod.recordActiveFlag',1),
                        $qb->expr()->eq('unit.recordActiveFlag',1)
                        ))
                ->orderBy('unit.unitName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetExistingServiceByAreaId($areaid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('service')
                ->from('TashiCommonBundle:PrdServiceTxn','service')
                ->join('service.productFk','prod')
                ->join('prod.productCategory','cat') 
                ->join('TashiCommonBundle:ProjectAreaProdCategoryTxn','cattxn',
                        Expr\Join::WITH,$qb->expr()->eq('cat.pkid','cattxn.prodCategoryFk'))
                ->join('cattxn.projectAreaFk','area')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('area.pkid',$areaid),
                        $qb->expr()->eq('service.recordActiveFlag',1),
                        $qb->expr()->eq('prod.recordActiveFlag',1),
                        $qb->expr()->eq('cat.recordActiveFlag',1),
                        $qb->expr()->eq('cattxn.recordActiveFlag',1)
                        ))
                ->orderBy('service.serviceName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function RetrieveItemandProductByCatId($masterCatId) {
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('prod')
                ->from('TashiCommonBundle:PrdProductMaster','prod')
                ->join('prod.productCategory','cat')                
                ->where($qb->expr()->orX(
                        $qb->expr()->eq('cat.parent',$masterCatId),
                        $qb->expr()->eq('cat.pkid',$masterCatId)
                        ))            
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('cat.recordActiveFlag',1),
                        $qb->expr()->eq('prod.recordActiveFlag',1)
                        ))
                ->orderBy('cat.pkid','ASC')
                ->addOrderBy( 'prod.productName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectItemsByProjectId($projectid) {
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('item')
                ->from('TashiCommonBundle:ProjectItemTxn','item')
                ->join('item.projectFk','project')                
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('project.pkid',$projectid),
                        $qb->expr()->neq('item.itemFk','\'NULL\''),
                        $qb->expr()->eq('item.recordActiveFlag',1)
                        ))
                ->orderBy('item.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }    
    public function RetrieveAllWorkers() {
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('emp')
                ->from('TashiCommonBundle:EmpEmployeeMaster','emp')
                ->join('emp.employementTypeFk','etype')   
                ->join('emp.personFk','person')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('etype.typeId','\'W\''),
                        $qb->expr()->eq('emp.recordActiveFlag',1)
                        ))
                ->orderBy('person.personName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function RetrieveAllEmployees() {
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('emp')
                ->from('TashiCommonBundle:EmpEmployeeMaster','emp')
                ->join('emp.employementTypeFk','etype')   
                ->join('emp.personFk','person')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('etype.typeId','\'O\''),
                        $qb->expr()->eq('emp.recordActiveFlag',1)
                        ))
                ->orderBy('person.personName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetAllWorkersByProjectId($projid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('emp')
                ->from('TashiCommonBundle:ProjectItemWorkerTxn','emp')
                ->join('emp.projectItemFk','item')   
                ->join('item.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.pkid',$projid),
                        $qb->expr()->eq('emp.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetAllWorkerAddress(){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('add')
                ->from('TashiCommonBundle:EmpAddressTxn','add')
                ->join('add.empMasterFk','emp')
                ->join('emp.employementTypeFk','emptype')
                ->where($qb->expr()->andX(  
                        $qb->expr()->eq('emptype.typeId','\'W\''),
                        $qb->expr()->eq('emp.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }

    public function SearchAllProject(){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->where($qb->expr()->andX(                        
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchProjectByOrdNo($ordno){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('proj.orderNo','\''.$ordno.'\''),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    } 
    public function SearchProjectByEmployee($keyword){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->join('proj.siteCoordinator','emp')
                ->join('emp.personFk','person')
                ->where($qb->expr()->orX(
                        $qb->expr()->like('person.personName','\'%'.$keyword.'%\''),
                        $qb->expr()->eq('emp.employeeId','\''.$keyword.'\'')
                        ))
                ->andWhere(
                            $qb->expr()->eq('proj.recordActiveFlag',1)
                            )
                ->orderBy('proj.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchProjectByCustName($custname){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->join('proj.customerFk','cust')
                ->where($qb->expr()->andX(        
                        $qb->expr()->like('cust.customerName','\'%'.$custname.'%\''),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('cust.customerName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchProjectByArea($area){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->join('proj.areaFk','area')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('area.pkid',$area),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchProjectByDate($sdate,$edate){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $startDate=new \DateTime($sdate);
        if($sdate!='' && $edate==''){
            $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('proj.startDate','\''.date_format($startDate,'Y-m-d').'\''),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        }
        elseif($sdate=='' && $edate!=''){
            $endDate=new \DateTime($edate);
            $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('proj.expectedCompletionDate','\''.date_format($endDate,'Y-m-d').'\''),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        }
        else{
            $endDate=new \DateTime($edate);
            $qb->select('proj')
                ->from('TashiCommonBundle:ProjectMaster','proj')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('proj.startDate','\''.date_format($startDate,'Y-m-d').'\''),
                        $qb->expr()->eq('proj.expectedCompletionDate','\''.date_format($endDate,'Y-m-d').'\''),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.startDate','ASC');
        }        
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectPaidAmount($projectid){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('sum(adv.amount) as amount')
                ->from('TashiCommonBundle:ProjectAdvancePayment','adv')
                ->join('adv.projectFk','proj')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('proj.pkid',$projectid),
                        $qb->expr()->eq('adv.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectItemService($itemid,$projectid) {
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('itemsrv')
                ->from('TashiCommonBundle:ProjectItemTxn','itemsrv')
                ->join('itemsrv.serviceFk','service')  
                ->join('service.productFk','prod')
                ->join('itemsrv.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('prod.pkid',$itemid),
                        $qb->expr()->eq('proj.pkid',$projectid),
                        //$qb->expr()->eq('itemsrv.itemFk','\'NULL\''),
                        $qb->expr()->eq('itemsrv.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectAdditionalService($projectid) {
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('itemtxn')
                ->from('TashiCommonBundle:ProjectItemTxn','itemtxn')
                ->join('itemtxn.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.pkid',$projectid),                        
                        $qb->expr()->eq('itemtxn.recordActiveFlag',1)
                        ))
                ->andWhere('itemtxn.itemFk is NULL AND itemtxn.serviceFk is Null')
            ->orderBy('itemtxn.recordInsertDate','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetTotalPaidAmount($projid){
        $em=$this->getEntityManager();      
        $query='Select sum(adv.amount) Amount From TashiCommonBundle:ProjectAdvancePayment adv
                INNER JOIN adv.projectFk proj 
                WHERE proj.pkid=:projid AND
                adv.recordActiveFlag=1';
        $qb=$em->createQuery($query)->setParameter('projid', $projid);
        return $qb->getResult();
    }
    public function GetTotalExpense($projid){
        $em=$this->getEntityManager();      
        $query='Select sum(exp.amount) Amount From TashiCommonBundle:ProjectExpenses exp
                INNER JOIN exp.projectFk proj 
                WHERE proj.pkid=:projid AND
                exp.recordActiveFlag=1 AND
                exp.approvalFlag=1';
        $qb=$em->createQuery($query)->setParameter('projid', $projid);
        return $qb->getResult();
    }
    public function GetLimitAmount($projid){
        $em=$this->getEntityManager();      
        $query='Select adv.alertPc Amount From TashiCommonBundle:ProjectAdvancePayment adv
                INNER JOIN adv.projectFk proj 
                WHERE proj.pkid=:projid AND
                adv.recordActiveFlag=1 AND
                adv.pkid=
                (Select max(a.pkid) from TashiCommonBundle:ProjectAdvancePayment a INNER JOIN a.projectFk p WHERE p.pkid=:projid AND a.recordActiveFlag=1 )';
        $qb=$em->createQuery($query)->setParameter('projid', $projid);
        return $qb->getResult();
    }
    public function GetProjectWiseAdvance(){
        $em=$this->getEntityManager();        
        $qb=$em->createQueryBuilder();
        $qb->select('proj.pkid projectid,sum(adv.amount) amount')
                ->from('TashiCommonBundle:ProjectAdvancePayment','adv')
                ->join('adv.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.recordActiveFlag',1),
                        $qb->expr()->eq('adv.recordActiveFlag',1)
                        ))
                ->groupBy('proj.pkid');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectWiseExpenses(){
        $em=$this->getEntityManager();        
        $qb=$em->createQueryBuilder();
        $qb->select('proj.pkid projectid,sum(exp.amount) amount')
                ->from('TashiCommonBundle:ProjectExpenses','exp')
                ->join('exp.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('proj.recordActiveFlag',1),
                        $qb->expr()->eq('exp.approvalFlag',1),
                        $qb->expr()->eq('exp.recordActiveFlag',1)
                        ))
                ->groupBy('proj.pkid');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetProjectWiseLimitAmount(){
        $em=$this->getEntityManager();      
        $qb1=$em->createQueryBuilder();
        $qb1->select('max(a.pkid)')               
                ->from('TashiCommonBundle:ProjectAdvancePayment', 'a')
                ->where($qb1->expr()->andX(
                        $qb1->expr()->eq('a.projectFk','proj.pkid'),
                        $qb1->expr()->eq('a.recordActiveFlag',1)
                ));
        
        $qb=$em->createQueryBuilder();
        $qb->select('proj.pkid projectid,adv.alertPc amount')
                ->from('TashiCommonBundle:ProjectAdvancePayment','adv')
                ->join('adv.projectFk','proj')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('adv.pkid','('.$qb1->getDQL().')'),
                        $qb->expr()->eq('proj.recordActiveFlag',1),
                        $qb->expr()->eq('adv.recordActiveFlag',1)
                        ));
 $query=$qb->getQuery();
//        $qb=$em->createQuery(
//                'SELECT proj.pkid projectid,adv.alertPc amount
//                 FROM TashiCommonBundle:ProjectAdvancePayment adv
//                 INNER JOIN adv.projectFk proj
//                 WHERE adv.pkid=
//                 (SELECT max(a.pkid) FROM TashiCommonBundle:ProjectAdvancePayment a WHERE a.projectFk=proj.pkid and a.recordActiveFlag=1)');
        return $query->getResult();
    }
    public function GetLastestModiLog($projectid){
        $em=$this->getEntityManager();      
        $query=$em->createQuery('SELECT pmlog FROM TashiCommonBundle:ProjectModificationLog pmlog
                                 INNER JOIN pmlog.projectFk proj
                                 WHERE proj.pkid='.$projectid.
                                 ' AND pmlog.pkid=
                                 (select max(pml.pkid) from TashiCommonBundle:ProjectModificationLog pml 
                                 INNER JOIN pml.projectFk p where p.pkid='.$projectid.' AND  pml.recordActiveFlag=1)');
        return $query->getResult();        
    }
    public function GetFieldOfExpertize(){
        $em=$this->getEntityManager();        
        $qb=$em->createQueryBuilder();
        $qb->select('exptxn')
                ->from('TashiCommonBundle:EmpWorkerExpertMasterTxn','exptxn')                
                ->join('exptxn.empMasterFk','emp')
                ->join('exptxn.expertTypeFk','exp')
                ->join('emp.employementTypeFk','etype')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('etype.typeId','\'W\''),
                        $qb->expr()->eq('exptxn.recordActiveFlag',1),
                        $qb->expr()->eq('emp.recordActiveFlag',1),
                        $qb->expr()->eq('exp.recordActiveFlag',1),
                        $qb->expr()->eq('etype.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }
}

