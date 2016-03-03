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
 * Description of WalletRepository
 *
 * @author Sanatomba
 */
class WalletRepository extends EntityRepository{
    //put your code here
    
    
    public function getDepositsumamount($empid) {
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT sum(deposit.amount) s 
                          FROM TashiCommonBundle:EmpAccountDeposit deposit
                          INNER JOIN TashiCommonBundle:EmpEmployeeMaster emp
                          WITH deposit.empFk = emp.employeePk
                          WHERE deposit.recordActiveFlag=1 and emp.employeePk = $empid");
          
            
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
     public function getExpensesumamount($empid) {
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT sum(empense.amount) s 
                          FROM TashiCommonBundle:EmpAccountExpenses empense
                          INNER JOIN TashiCommonBundle:EmpEmployeeMaster emp
                          WITH empense.empFk = emp.employeePk
                          WHERE empense.recordActiveFlag = 1 and empense.status = 1 and emp.employeePk = $empid");
            }
            catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    
    public function getexpensesbystatus() {        
        try{
        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT empense  
                          FROM TashiCommonBundle:EmpAccountExpenses empense
                          WHERE empense.recordActiveFlag = 1 and empense.status = 0 ");
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    public function GetBalanceByEmpID($empid) {        
        try{        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT bal.balanceAmount 
                          FROM TashiCommonBundle:EmpAccountBalance bal INNER JOIN bal.empFk emp
                          WHERE emp.employeeId='".$empid."' AND bal.recordActiveFlag = 1 AND emp.recordActiveFlag = 1");
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    public function GetTopTenDeposit($empid) {        
        try{        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT deposit   
                          FROM TashiCommonBundle:EmpAccountDeposit deposit INNER JOIN deposit.empFk emp
                          WHERE emp.employeeId='".$empid."' AND deposit.recordActiveFlag = 1 AND emp.recordActiveFlag = 1 ORDER BY deposit.pkid ")
                ->setMaxResults(10);
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    public function GetTopTenExpense($empid) {        
        try{        
            $em = $this->getEntityManager(); 
            $query = $em->createQuery(
                        " SELECT expense   
                          FROM TashiCommonBundle:EmpAccountExpenses expense INNER JOIN expense.empFk emp
                          WHERE emp.employeeId='".$empid."' AND expense.recordActiveFlag = 1 AND emp.recordActiveFlag = 1 ORDER BY expense.pkid DESC")
                ->setMaxResults(10);
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        return $query->getResult();
    }
    public function SearchMyDeposits($empid,$fdate,$tdate) {              
        $em = $this->getEntityManager(); 
        $qb = $em->createQueryBuilder();
        $qb->select('dep')                    
            ->from('TashiCommonBundle:EmpAccountDeposit','dep')
            ->join('dep.empFk','emp')
            ->where($qb->expr()->andX(
                    $qb->expr()->eq('emp.employeeId', '\''.$empid.'\''),
                    $qb->expr()->eq('dep.recordActiveFlag', 1)
                    )); 
        if($fdate!='' && $tdate==''){            
            $temp=new \DateTime($fdate);
            date_modify($temp, '+1 day');
            date_modify($temp, '-1 second');
            $fromdate=new \DateTime($fdate);
            $qb->andWhere($qb->expr()->between('dep.recordInsertDate', '\''.date_format($fromdate,'Y-m-d H:i:s').'\'','\''.date_format($temp,'Y-m-d H:i:s').'\''));
        }elseif($fdate!='' && $tdate!=''){
            $fromdate=new \DateTime($fdate);
            $todate=new \DateTime($tdate);
            date_modify($todate, '+1 day');
            date_modify($todate, '-1 second');
            $qb->andWhere($qb->expr()->between('dep.recordInsertDate', '\''.date_format($fromdate,'Y-m-d H:i:s').'\'','\''.date_format($todate,'Y-m-d H:i:s').'\''));
        }        
            
        $qb->orderBy('dep.pkid');
        $query=$qb->getQuery();    
        return $query->getResult();
    }
    public function SearchMyExpenses($empid,$fdate,$tdate,$status) {              
        $em = $this->getEntityManager(); 
        $qb = $em->createQueryBuilder();
        $qb->select('exp')                    
            ->from('TashiCommonBundle:EmpAccountExpenses','exp')
            ->join('exp.empFk','emp')
            ->where($qb->expr()->andX(
                    $qb->expr()->eq('emp.employeeId', '\''.$empid.'\''),
                    $qb->expr()->eq('exp.recordActiveFlag', 1)
                    )); 
        if($fdate!='' && $tdate==''){
           $temp=new \DateTime($fdate);
            date_modify($temp, '+1 day');
            date_modify($temp, '-1 second');
            $fromdate=new \DateTime($fdate);
            $qb->andWhere($qb->expr()->between('exp.expensesDate', '\''.date_format($fromdate,'Y-m-d H:i:s').'\'','\''.date_format($temp,'Y-m-d H:i:s').'\''));
        }elseif($fdate!='' && $tdate!=''){
            $fromdate=new \DateTime($fdate);
            $todate=new \DateTime($tdate);
            date_modify($todate, '+1 day');
            date_modify($todate, '-1 second');
            $qb->andWhere($qb->expr()->between('exp.expensesDate', '\''.date_format($fromdate,'Y-m-d H:i:s').'\'','\''.date_format($todate,'Y-m-d H:i:s').'\''));
        }
        if($status!=''){
            $qb->andWhere($qb->expr()->eq('exp.status',$status));
        }
        $qb->orderBy('exp.pkid');
        $query=$qb->getQuery();    
        return $query->getResult();
    }
}