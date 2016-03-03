<?php

namespace Tashi\StockBundle\Service;
use Tashi\StockBundle\Helper\StockConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager; 
use Tashi\CommonBundle\Entity\StockMaster;
use Tashi\CommonBundle\Entity\StockTaxTxn;

/**
 * Description of StockService
 *
 * @author Administrator
 */
class StockService {
    //put your code here
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;

    public function __construct(EntityManager $em, Session $session, $rootDir,$commonService) 
    {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService=$commonService;        
    }
    function InsertStock($request){
        $dataUI=json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            $productid=$dataUI->inputprodId;
            $priceid=$dataUI->inputppriceId;
            $unitid=$dataUI->selUnit;
            $storeid=  explode('&', $dataUI->selstkStore)[1];
            if($dataUI->selStkBldg!=''){
                $buildingid=explode('&', $dataUI->selStkBldg)[1];
            }else{
                $buildingid='';
            }
            if($dataUI->selStkFloor!=''){
                $floorid=explode('&', $dataUI->selStkFloor)[1];
            }else{
                $floorid='';
            }
            if($dataUI->selStkRoom!=''){
                $roomid=explode('&', $dataUI->selStkRoom)[1];
            }else{
                $roomid='';
            }
            if($dataUI->selStkRack!=''){
                $rackid=explode('&', $dataUI->selStkRack)[1];
            }else{
                $rackid='';
            }
            $binid=$dataUI->selStkBin;
            //$batchno=$dataUI->stkBatchNo;
//            $warranty=$dataUI->stkwarranty;
//            $mfgdate=$dataUI->stkMfgDate;
//            $expdate=$dataUI->stkExpDate;
            $quantity=$dataUI->stkQty;
            $lowquantity=$dataUI->stklowqty;
            if($lowquantity==''){
                $lowquantity=0;
            }
            $desc=$dataUI->txtStockDesc;
            //$taxIds=$dataUI->inputTaxId;
            //$taxes=$dataUI->txtTaxVal;
            if(isset($dataUI->inputPoid)){
                $poid=$dataUI->inputPoid;
            }
            else{
                $poid='';
            }
            $conn->beginTransaction();
            $product=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($productid);
            $price=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->find($priceid);
            $store=$this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storeid);
            $building=$this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($buildingid);
            $floor=$this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($floorid);
            $room=$this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($roomid);
            $rack=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($rackid);
            $bin=$this->em->getRepository(CommonConstant::ENT_BIN_MASTER)->find($binid);
            $po=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($poid);
            $unit=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unitid);
            $stock=new StockMaster();
            $stock->setStoreFk($store);
            if($building){
                $stock->setBuildingFk($building);
            }
            if($floor){
                $stock->setFloorFk($floor);
            }
            if($room){
                $stock->setRoomFk($room);
            }
            if($rack){
                $stock->setRackFk($rack);
            }
            if($bin){
                $stock->setBinFk($bin);
            }
            if($unit){
                $stock->setUnitFk($unit);
            }
            $stock->setProductFk($product);
            $stock->setPriceFk($price);
            if($po){
                $stock->setPurchaseorderFk($po);
            }
            $stock->setQuantity($quantity);
            $stock->setReorderQty($lowquantity);
            $stock->setDescription($desc);
//            if($mfgdate!=''){
//                $stock->setManufacturingDate(new \DateTime($mfgdate));
//            }
//            if($expdate){
//                $stock->setExpiryDate(new \DateTime($expdate));
//            }
//            if($warranty!=''){
//                $stock->setWarranty($warranty);
//            }
            //$stock->setBatchNo($batchno);
            $stock->setRecordActiveFlag(1);
            $stock->setRecordInsertDate(new \DateTime("NOW"));
            $stock->setApplicationUserId($this->session->get('EMPID'));
            $stock->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($stock);
            $this->em->flush();            
            $conn->commit();
            $returnmsg='Stock detail has been saved successfully.';
            $returncode=1;
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
            $returncode=0;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function UpdateStock($request){
        $dataUI=json_decode($request->getContent());
        $conn=$this->em->getConnection();
        try{
            $stockid=$dataUI->inputStockId;
            $storeid=  explode('&', $dataUI->selstkStore)[1];
            if($dataUI->selStkBldg!=''){
                $buildingid=explode('&', $dataUI->selStkBldg)[1];
            }else{
                $buildingid='';
            }
            if($dataUI->selStkFloor!=''){
                $floorid=explode('&', $dataUI->selStkFloor)[1];
            }else{
                $floorid='';
            }
            if($dataUI->selStkRoom!=''){
                $roomid=explode('&', $dataUI->selStkRoom)[1];
            }else{
                $roomid='';
            }
            if($dataUI->selStkRack!=''){
                $rackid=explode('&',$dataUI->selStkRack)[1];
            }else{
                $rackid='';
            }
            $binid=$dataUI->selStkBin;
            $unitid=$dataUI->selUnit;
//            $batchno=$dataUI->stkBatchNo;
//            $warranty=$dataUI->stkwarranty;
//            $mfgdate=$dataUI->stkMfgDate;
//            $expdate=$dataUI->stkExpDate;
            $quantity=$dataUI->stkQty;
            $reorderqty=$dataUI->stklowqty;    
            if($reorderqty==''){
                $reorderqty=0;
            }
            $desc=$dataUI->txtStockDesc;
            $conn->beginTransaction();
            $store=$this->em->getRepository(CommonConstant::ENT_ADD_STORE)->find($storeid);
            $building=$this->em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->find($buildingid);
            $floor=$this->em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->find($floorid);
            $room=$this->em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->find($roomid);
            $rack=$this->em->getRepository(CommonConstant::ENT_BUILDING_RACK)->find($rackid);
            $bin=$this->em->getRepository(CommonConstant::ENT_BIN_MASTER)->find($binid);
            $unit=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unitid);
            $stock=$this->em->getRepository(CommonConstant::ENT_STOCK_MASTER)->find($stockid);            

            $stock->setStoreFk($store);
            $stock->setBuildingFk($building);
            $stock->setFloorFk($floor);
            $stock->setRoomFk($room);
            $stock->setRackFk($rack);
            $stock->setBinFk($bin);
//          $stock->setPurchaseorderFk($po);
            $stock->setQuantity($quantity);
            $stock->setUnitFk($unit);
            $stock->setReorderQty($reorderqty);
            $stock->setDescription($desc);
//            if($mfgdate!=''){
//                $stock->setManufacturingDate(new \DateTime($mfgdate));
//            }
//            if($expdate){
//                $stock->setExpiryDate(new \DateTime($expdate));
//            }
//            if($warranty!=''){
//                $stock->setWarranty($warranty);
//            }
            //$stock->setDescription($desc);
            //$stock->setBatchNo($batchno);
            $stock->setRecordInsertDate(new \DateTime("NOW"));
            $stock->setApplicationUserId($this->session->get('EMPID'));
            $stock->setApplicationUserIpAddress($this->session->get('IP'));
            $stock->setRecordUpdateDate(new \DateTime("NOW"));
            $stock->setApplicationUserId($this->session->get('EMPID'));
            $stock->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();    
            $conn->commit();
            $returnmsg='Stock detail has been updated successfully.';
            $returncode=1;
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
            $returncode=0;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function DeleteStock($stockid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $stock=$this->em->getRepository(CommonConstant::ENT_STOCK_MASTER)->find($stockid); 
            $stock->setRecordActiveFlag(0);
            $stock->setRecordUpdateDate(new \DateTime("NOW"));
            $stock->setApplicationUserId($this->session->get('EMPID'));
            $stock->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();            
            $conn->commit();
            $returnmsg='Stock detail has been deleted successfully.';
            $returncode=1;
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg=$this->commonService->CommonError($ex,'dberror');
            $returncode=0;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
}

 
