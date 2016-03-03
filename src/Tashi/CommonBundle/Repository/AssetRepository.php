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
 * Description of AssetRepository
 *
 * @author chingkhei
 */
class AssetRepository extends EntityRepository{
    //put your code here
    public function SearchAssetDetails($assetSearch){
        $em=$this->getEntityManager();      
        $query = $em->createQuery("select asset from TashiCommonBundle:AssetMaster asset where asset.assetName='".$assetSearch."' AND asset.recordActiveFlag=1");
        
        return $query->getResult();        
    }
    
    public function SearchCategoryDetails($catSearch){
        $em=$this->getEntityManager();      
        $query = $em->createQuery("select cat from TashiCommonBundle:AssetCategoryMaster cat where cat.assetCategoryName='".$catSearch."' AND cat.recordActiveFlag=1");
        
        return $query->getResult();        
    }
    
    public function SearchAllAsset(){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:AssetMaster','proj')
                ->where($qb->expr()->andX(                        
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.assetName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    
    public function SearchAssettByCategory($cat){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:AssetMaster','proj')
                ->join('proj.assetCategoryMasterFk','cat')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('cat.assetMasterPk',$cat),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.assetName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    
        public function SearchEmpAssettByCategory($cat){
        $em=$this->getEntityManager();      
        $qb=$em->createQueryBuilder();
        $qb->select('proj')
                ->from('TashiCommonBundle:AssetMaster','proj')
                ->join('proj.assetCategoryMasterFk','cat')
                ->where($qb->expr()->andX(        
                        $qb->expr()->eq('cat.assetMasterPk',$cat),
                        $qb->expr()->eq('proj.recordActiveFlag',1)
                        ))
                ->orderBy('proj.assetName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    

}
