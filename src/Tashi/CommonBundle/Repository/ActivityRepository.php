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
 * Description of ActivityRepository
 *
 * @author KHUMUPOKPAM
 */
class ActivityRepository extends EntityRepository{
    public function GetAllActiveActivity(){
        $em=$this->getEntityManager();    
        $qb=$em->createQueryBuilder();
        $qb->select('activity')
                ->from('TashiCommonBundle:SystemActivityMaster', 'activity')
                ->join('activity.moduleFk','module')
                ->where($qb->expr()->eq('activity.recordActiveFlag',1))
                ->orderBy('module.pkid','ASC')
                ->orderBy('activity.activityName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();        
    }
}
