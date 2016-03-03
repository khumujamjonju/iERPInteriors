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
 * Description of StockRepository
 *
 * @author KHUMUPOKPAM
 */
class StockRepository extends EntityRepository{
    public function GetAllStock(){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stock')
                ->from('TashiCommonBundle:StockMaster', 'stock')
                ->join('stock.productFk','prod')
                ->where($qb->expr()->andX(
                        $qb->expr()->eq('stock.recordActiveFlag',1)                        
                        ))
                //->groupBy('prod.sku')
                ->orderBy('prod.sku','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockBySKU($sku){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.productFk', 'prd')
            ->where($qb->expr()->andX(
                    $qb->expr()->eq('prd.sku', '\''.$sku.'\''),
                    $qb->expr()->eq('stk.recordActiveFlag',1)
                    ))
            ->orderBy('prd.sku','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockByQty($from,$to){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.productFk', 'prd');            
                    if($to==''){
                        $qb->where($qb->expr()->eq('stk.quantity',$from));
                    }else{
                        $qb->where($qb->expr()->between('stk.quantity',$from,$to));
                    }
                    $qb->andWhere($qb->expr()->eq('stk.recordActiveFlag',1));
            $qb->orderBy('prd.sku','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockByValue($from,$to){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.productFk', 'prd')
            ->join('stk.priceFk','price');
        if($to==''){
            $qb->where($qb->expr()->eq('(stk.quantity*price.costPrice)',$from));
        }else{
            $qb->where($qb->expr()->andX(
                        $qb->expr()->gte('(stk.quantity*price.costPrice)',$from),
                        $qb->expr()->lte('(stk.quantity*price.costPrice)',$to)
                    ));
        }                    
        $qb->andWhere($qb->expr()->eq('stk.recordActiveFlag',1))
            ->orderBy('prd.sku','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockByReorderQty($from,$to){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.productFk', 'prd')
            ->where($qb->expr()->gt('stk.reorderQty','stk.quantity'));
                if($to==''){
                    $qb->andWhere($qb->expr()->eq('stk.reorderQty',$from));
                }else{
                    $qb->andWhere($qb->expr()->between('stk.reorderQty',$from,$to));
                } 
            $qb->andWhere($qb->expr()->eq('stk.recordActiveFlag',1))
            ->orderBy('prd.sku','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchRequireReorderStock(){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.productFk', 'prd')
            ->where($qb->expr()->andX(
                    $qb->expr()->gt('stk.reorderQty','stk.quantity'),
                    $qb->expr()->eq('stk.recordActiveFlag',1)))
            ->groupBy('prd.sku')
            ->orderBy('prd.sku','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    /*============================*/
    public function SearchProductByCodeBarCode($code){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('price')
            ->from('TashiCommonBundle:PrdProductPriceTxn', 'price')
            ->join('price.product', 'prd')
            ->where($qb->expr()->andX(
                    $qb->expr()->orX(
                            $qb->expr()->eq('prd.productCode', '\''.$code.'\''),
                            $qb->expr()->eq('prd.productBarcode', '\''.$code.'\'')
                            ),
                    $qb->expr()->eq('prd.recordActiveFlag',1),
                    $qb->expr()->eq('price.recordActiveFlag',1)
                    ))
            ->orderBy('prd.productName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockByProduct($prdCodeName){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.productFk', 'prd')
            ->where($qb->expr()->andX(
                    $qb->expr()->orX(
                            $qb->expr()->eq('prd.productCode', '\''.$prdCodeName.'\''),
                            $qb->expr()->like('prd.productName', '\'%'.$prdCodeName.'%\'')
                            ),
                    $qb->expr()->eq('stk.recordActiveFlag',1)
                    ))
            ->orderBy('prd.productName','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    
    public function SearchStockByPO($po){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')
            ->join('stk.purchaseorderFk', 'po')
            ->where($qb->expr()->andX(
                        $qb->expr()->eq('po.uiOrderId', '\''.$po.'\''),
                        $qb->expr()->eq('stk.recordActiveFlag',1)
                        ))
            ->orderBy('po.uiOrderId','ASC');
        $query=$qb->getQuery();
        return $query->getResult();
    }
    
    public function SearchStockByLocation($store,$building,$floor,$room,$rack){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk');         
        if($rack!=''){            
            $qb->join('stk.rackFk', 'rack')
                    ->where($qb->expr()->eq('rack.storeRackPk',$rack));
        }
        elseif($room!=''){
            $roomid=explode('&',$room)[1];
            $qb->join('stk.roomFk', 'room')
                    ->where($qb->expr()->eq('room.storeRoomPk',$roomid));
        }
        elseif($floor!=''){
            $floorid=explode('&',$floor)[1];
            $qb->join('stk.floorFk', 'floor')
                    ->where($qb->expr()->eq('floor.storeFloorPk',$floorid));
        } 
        elseif($building!=''){
            $bldgid=explode('&',$building)[1];
            $qb->join('stk.buildingFk', 'bldg')
                    ->where($qb->expr()->eq('bldg.storeBuildingPk',$bldgid));
        }
        else{
            $storeid=explode('&',$store)[1];
            $qb->join('stk.storeFk', 'store')
                    ->where($qb->expr()->eq('store.storeMasterPk',$storeid));
        }
        $qb->andWhere($qb->expr()->eq('stk.recordActiveFlag',1));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockByQuantity($value,$condition){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')   ;             
        switch($condition){
            case '=':
                $qb->where($qb->expr()->eq('stk.quantity',$value));
                break;
            case '>':
                $qb->where($qb->expr()->gt('stk.quantity',$value));
                break;
            case '<':
                $qb->where($qb->expr()->lt('stk.quantity',$value));
                break;
        }
        $qb->andWhere($qb->expr()->eq('stk.recordActiveFlag',1));
        $query=$qb->getQuery();
        return $query->getResult();
    }
    public function SearchStockByExpiryDate($date,$days,$condition){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $format='Y-m-d';
        $expdate=date_format($date, $format);
        
        
        $qb->select('stk')
            ->from('TashiCommonBundle:StockMaster', 'stk')   ; 
        
        if($days==''){
            $qb->where($qb->expr()->eq('stk.expiryDate', '\''.$expdate.'\''));
        }
        else{
            if($condition=='+'){
                $buffdate=$date->modify('+'.($days+1).' day');
                $qb->where($qb->expr()->between('stk.expiryDate', '\''.$expdate.'\'', '\''.date_format($buffdate,$format).'\''));
            }
            elseif($condition=='-'){
                $buffdate=$date->modify('-'.($days).' day');
                $qb->where($qb->expr()->between('stk.expiryDate', '\''.date_format($buffdate,$format).'\'','\''.date_format($expdate->modify('+1 day')).'\''));
            }
        }
        $qb->andWhere($qb->expr()->eq('stk.recordActiveFlag',1));
        $query=$qb->getQuery();
        return $query->getResult();
    }
}
