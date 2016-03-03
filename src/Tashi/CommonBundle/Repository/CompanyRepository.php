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
 * Description of CompanyRepository
 *
 * @author KHUMUPOKPAM
 */
class CompanyRepository extends EntityRepository{
    public function GetAllActiveMobileNo(){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('mob')
                ->from('TashiCommonBundle:CompanyContactMobileNoTxn','mob') 
                ->join('TashiCommonBundle:CompanyContactTxn','cont',
                        Expr\Join::WITH,$qb->expr()->eq('cont.pkid', 'mob.contactFk'))
                ->join('cont.companyFk','comp')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('comp.pkid',1),
                        $qb->expr()->eq('cont.recordActiveFlag',1),
                        $qb->expr()->eq('mob.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();        
    }
}
