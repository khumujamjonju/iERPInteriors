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
 * Description of UserRepository
 *
 * @author KHUMUPOKPAM
 */
class UserRepository extends EntityRepository{
    public function SearchEmployee($criteria,$keyword){
        $em=$this->getEntityManager();      
        $qb1=$em->createQueryBuilder();
        $qb1->select('e.employeePk')               
                ->from('TashiCommonBundle:EmpEmployeeMaster', 'e')
                ->join('TashiCommonBundle:UserTbl','user',
                        Expr\Join::WITH,$qb1->expr()->eq('e.employeePk','user.userFk'))
                ->where($qb1->expr()->andX(
                        $qb1->expr()->eq('e.recordActiveFlag',1),
                        $qb1->expr()->eq('user.recordActiveFlag',1)
                        ))
                ->orderBy('emp.employeePk','ASC');
        
        $qb=$em->createQueryBuilder();
        $qb->select('emp')
                ->from('TashiCommonBundle:EmpEmployeeMaster', 'emp')  
                ->join('emp.personFk','person') ;
        if($criteria=='idname'){
            $qb->where($qb->expr()->orX(
                    $qb->expr()->eq('emp.employeeId','\''.$keyword.'\''),
                    $qb->expr()->like('person.personName','\'%'.$keyword.'%\'')));
        }
        $qb->andWhere($qb->expr()->andX(
                $qb->expr()->eq('emp.recordActiveFlag',1),
                $qb->expr()->notIn('emp.employeePk', $qb1->getDQL())
                ))

        ->orderBy('person.personName','ASC');                
        $query=$qb->getQuery();
        return $query->getResult();        
    }
    public function SearchAccount($criteria,$keyword){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('acc')
                ->from('TashiCommonBundle:UserTbl','acc');
        if($criteria=='idname'){
            $qb->join('acc.userFk','emp')
                    ->join('emp.personFk','person')
                    ->where($qb->expr()->orX(
                            $qb->expr()->eq('emp.employeeId','\''.$keyword.'\''),
                            $qb->expr()->like('person.personName','\'%'.$keyword.'%\'')))
                    ->andWhere($qb->expr()->eq('emp.recordActiveFlag',1));
        }
        elseif($criteria=='uname'){
            $qb->where($qb->expr()->like('acc.userName','\'%'.$keyword.'%\''));
        }
        $qb->andWhere($qb->expr()->andX(
                $qb->expr()->eq('acc.recordActiveFlag',1)));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchAllActiveAccount(){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('acc')
                ->from('TashiCommonBundle:UserTbl','acc')      
                ->join('acc.userFk','emp')
                ->join('emp.personFk','person')
                ->where($qb->expr()->andX(                        
                        $qb->expr()->eq('emp.recordActiveFlag',1)),
                        $qb->expr()->eq('acc.recordActiveFlag',1));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function FindUserByEmail($email){
        $em=$this->getEntityManager();  
        $qb=$em->createQueryBuilder();
        $qb->select('account')
                ->from('TashiCommonBundle:UserTbl','account')
                ->join('account.userFk','emp')
                ->join('emp.personFk','person')
                ->join('account.statusFk','ustatus')
                ->where($qb->expr()->orX(
                        $qb->expr()->eq('person.emailId','\''.$email.'\''),
                        $qb->expr()->eq('person.emailIdOffice','\''.$email.'\'')
                        ))
                ->andWhere($qb->expr()->andX(
                        $qb->expr()->eq('emp.recordActiveFlag',1),
                        $qb->expr()->eq('account.recordActiveFlag',1),
                        $qb->expr()->eq('ustatus.isAccessible',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function GetUserRoleList($userid){
        $em=$this->getEntityManager();  
        $qb=$em->createQueryBuilder();
        $qb->select('act.functionName Role')
                ->from('TashiCommonBundle:SystemActivityMaster','act')
                ->join('TashiCommonBundle:SystemGroupActivityTxn','gatxn',
                        Expr\Join::WITH,$qb->expr()->eq('act.pkid','gatxn.activityFk'))                
                ->join('gatxn.userGroupFk','grp')
                ->join('TashiCommonBundle:UserGroupTxn','ugtxn',
                        Expr\Join::WITH,$qb->expr()->eq('grp.pkid','ugtxn.groupFk'))
                ->join('ugtxn.userFk','user')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('user.userIdPk',$userid),
                        $qb->expr()->eq('ugtxn.recordActiveFlag',1),
                        $qb->expr()->eq('grp.recordActiveFlag',1),
                        $qb->expr()->eq('gatxn.recordActiveFlag',1),
                        $qb->expr()->eq('act.recordActiveFlag',1)
                        ));
        $query=$qb->getQuery();
        return $query->getResult();
    }
}
