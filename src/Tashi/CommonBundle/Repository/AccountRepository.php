<?php

namespace Tashi\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Description of AccountRepository
 *
 * @author Sarat
 */
class AccountRepository extends EntityRepository{
    public function GetTotalNoOfPendingApproveSalarySlip(){
        $em=$this->getEntityManager();    
        $query = "SELECT COUNT(p.salarySlipPk) pendingApprovalSalarySlip
                  FROM TashiCommonBundle:PayrolSalarySlip p
                  WHERE p.status = 'C' AND p.recordActiveFlag = 1";
        $createQuery = $em->createQuery($query);
        return $createQuery->getSingleResult();          
    }
    
    public function GetTotalNoOfSalarySanction(){
        $em=$this->getEntityManager();    
        $query = "SELECT COUNT(s.pkid) totalSanctionSalary
                  FROM TashiCommonBundle:PayrolSanctionSalaryId s
                  WHERE s.isSanction = 0 AND s.recordActiveFlag = 1";
        $createQuery = $em->createQuery($query);
        return $createQuery->getSingleResult();          
    }
    
    public function GetTotalNoOfSalarySlipToBeSanction(){
        $em=$this->getEntityManager();    
        $query = "SELECT d.pkid pkid, COUNT(s.pkid) noOfSalarySlip, SUM(slip.netSalary) totalBalance
                FROM TashiCommonBundle:PayrolSanctionSalarySlip s
                JOIN s.sanctionKeyFk d
                JOIN s.salarySlipFk slip
                WHERE d.isSanction = 0 
                AND d.recordActiveFlag = 1                   
                AND s.recordActiveFlag = 1
                GROUP BY d.pkid";
        $createQuery = $em->createQuery($query);
        return $createQuery->getResult();  
        
    }
    public function GetRecentContraTransaction(){
        $em=$this->getEntityManager();    
        $qb=$em->createQueryBuilder();
        $qb->select('contra')
            ->from('TashiCommonBundle:ContraTransactionMaster','contra')
            ->where($qb->expr()->andX(
                    $qb->expr()->eq('contra.recordActiveFlag',1)
                    ))
            ->orderBy('contra.pkid','DESC')
            ->setMaxResults(10);
        $query=$qb->getQuery();
        return $query->getResult();                
    }
    
    
}

