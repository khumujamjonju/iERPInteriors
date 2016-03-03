<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonRepository
 *
 * @author KHUMUPOKPAM
 */
class CommonRepository {
    //put your code here
    public function getLatestNumber($tbname,$autoColName){
        $em=  $this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $qb->select('max(tb.'.$autoColName.') as number')
                ->from('TashiCommonBundle:'+$tbname,'tb');
        $query=$qb->getQuery();
        $result=$query->getResult();
        if($result){
            return $result;
        }
        else{
            return 1;
        }
    }
}
