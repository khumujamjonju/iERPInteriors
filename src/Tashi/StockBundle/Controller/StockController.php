<?php

namespace Tashi\StockBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\StockBundle\Helper\StockConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @Route("/Stock")
 */
class StockController extends Controller{
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    /**
     * @Route ("/stock_dashboard", name="_stock_dashboard")
     */
    public function stockDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('stockDashboardAction');
	if($accessRight==1){
            try{                   
                 $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_DASHBOARD));
                 $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
    //                $this->erpMessage->setMessage($ex->getMessage());
                    $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
      * Action: Navigate to Stock Entry Page(StockEntry.html.twig)
     * @Route ("/stockentry", name="_gotostockentry")
     */
    public function GoToStockEntryAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('StockEntry');
//	if($accessRight==1){
            try{    
                $em=$this->getDoctrine()->getManager();
                $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                        (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_ENTRY,array('category'=>$category)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
//        }else{
//            $this->erpMessage->setJsonData('AD');
//            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);   
    }
    /**
      * Action: Load all active buildings by store id
     * @Route ("/loadbuildinglist/{storeid}", name="_loadbuildingbystoreid")
     */
    public function LoadBuildingByStoreIdAction($storeid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $buildingArr=$em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->
                    findBy(array('storeMasterFk'=>$storeid,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_BLDG,array('buildingArr'=>$buildingArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Floor in a Building by Building ID
     * @Route ("/laodfloorbybldg/{bldgid}", name="_loadfloorbybldgid")
     */
    public function LoadFloorByBldgIdAction($bldgid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $floorArr=$em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->
                    findBy(array('storeBuildingMasterFk'=>$bldgid,'recordActiveFlag'=>1),array('storeFloorNo'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_FLOOR,array('floorArr'=>$floorArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Room in a Floor by Floor ID
     * @Route ("/loadroombyfloorid/{floorid}", name="_loadroombyfloorid")
     */
    public function LoadRoomByFloorIdAction($floorid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $roomArr=$em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->
                    findBy(array('storeFloorMasterFk'=>$floorid,'recordActiveFlag'=>1),array('storeRoomNo'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_ROOM,array('roomArr'=>$roomArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Rack in a Room by Room ID
     * @Route ("/loadrackbyroomid/{roomid}", name="_loadrackbyroomid")
     */
    public function LoadRackByRoomIdAction($roomid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $rackArr=$em->getRepository(CommonConstant::ENT_BUILDING_RACK)->
                    findBy(array('storeRoomMasterFk'=>$roomid,'recordActiveFlag'=>1),array('rackName'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_RACK,array('rackArr'=>$rackArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Floor in a Building by Building ID
     * @Route ("/laodbinbyrack/{rackid}", name="_laodbinbyrack")
     */
    public function LoadBinByRackIdAction($rackid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $binArr=$em->getRepository(CommonConstant::ENT_BIN_MASTER)->
                    findBy(array('rackFk'=>$rackid,'recordActiveFlag'=>1),array('binNo'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_BIN,array('binArr'=>$binArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
      * Action: Load all active buildings by store id(for use in stock search)
     * @Route ("/loadbuildinglistsearch/{storeid}", name="_loadbuildingbystoreidsearch")
     */
    public function LoadBuildingByStoreIdSearchAction($storeid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $buildingArr=$em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->
                    findBy(array('storeMasterFk'=>$storeid,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_BLDG_SEARCH,array('buildingArr'=>$buildingArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Floor in a Building by Building ID(for use in stock search)
     * @Route ("/laodfloorbybldgsearch/{bldgid}", name="_loadfloorbybldgidsearch")
     */
    public function LoadFloorByBldgIdSearchAction($bldgid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $floorArr=$em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->
                    findBy(array('storeBuildingMasterFk'=>$bldgid,'recordActiveFlag'=>1),array('storeFloorNo'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_FLOOR_SEARCH,array('floorArr'=>$floorArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Room in a Floor by Floor ID(for use in stock search)
     * @Route ("/loadroombyflooridsearch/{floorid}", name="_loadroombyflooridsearch")
     */
    public function LoadRoomByFloorIdSearchAction($floorid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $roomArr=$em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->
                    findBy(array('storeFloorMasterFk'=>$floorid,'recordActiveFlag'=>1),array('storeRoomNo'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_ROOM_SEARCH,array('roomArr'=>$roomArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Load all active Rack in a Room by Room ID(for use in stock search)
     * @Route ("/loadrackbyroomidsearch/{roomid}", name="_loadrackbyroomidsearch")
     */
    public function LoadRackByRoomIdSearchAction($roomid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                
            $em=$this->getDoctrine()->getManager();
            $rackArr=$em->getRepository(CommonConstant::ENT_BUILDING_RACK)->
                    findBy(array('storeRoomMasterFk'=>$roomid,'recordActiveFlag'=>1),array('rackName'=>'ASC'));                
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_RACK_SEARCH,array('rackArr'=>$rackArr)));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }        
    }
    /**
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/stkappendprdsubcat/{pkid}", name="_stk_appendprdsubcat")
     */
    public function StockAppendSubCatAction($pkid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em = $this->getDoctrine()->getManager();  
            $CatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($pkid);//Single parent category
            //$MasterCatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('parent'=>$pkid,'statusFlag' => 1, 'recordActiveFlag' => 1));//child category List
            $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(
                    array('statusFlag'=>1,'recordActiveFlag' => 1, 'productCategory'=>$pkid),array('productName'=>'ASC'));

//            if($MasterCatObj){
//                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_SUB_CATEGORY,
//                                    array('catMaster'=>$MasterCatObj,'obj'=>$CatObj)));                            
//            }       
            $this->erpMessage->setSecondHtml($this->renderView(StockConstant::TWIG_APPEND_PRODUCTS,
                                    array('productArr'=>$CatProduct)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**
     * Action: Load selected product detail and display in Stock detail entry page(StockEntryDetail.html.twig). 
     * @Route ("/stkstockentrydetail/", name="_gotostkstockentrydetail")
     */
    public function GotoStockEntryDetailAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

            try{
                $dataUI=  json_decode($request->getContent());
                $prdCode=$dataUI->inputProductCode;
                $em = $this->getDoctrine()->getManager();  
                $prd=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->SearchProductByCodeBarCode($prdCode);
                if($prd){
//                    $prdPrice=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findBy(
//                        array('statusFlag'=>1,'recordActiveFlag' => 1, 'product'=>$prd[0]));      
                    $storeArr=$em->getRepository(CommonConstant::ENT_ADD_STORE)->findBy(
                            array('recordActiveFlag'=>1),array('storeName'=>'ASC'));
                    $taxArr=$em->getRepository(CommonConstant::ENT_TAX_MASTER)->findBy(
                            array('recordActiveFlag'=>1),array('taxName'=>'ASC'));
                    $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('productFk'=>$prd[0]->getProduct(),'recordActiveFlag'=>1),array('unitName'=>'ASC'));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_ENTRY_DETAIL,
                                        array('prdprice'=>$prd[0],'storeArr'=>$storeArr,'taxArr'=>$taxArr,'unitArr'=>$unitArr)));
                }   
                else{
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('Product Code/Bar Code does not exist.');
                }              
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    }
    /**
     * Action: Insert Stock Detail 
     * @Route ("/insertstock/", name="_insertstock")
     */
    public function InsertStockAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('StockEntry');
	if($accessRight==1){
            $result=$this->get(StockConstant::SERVICE_STOCK)->InsertStock($request);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);                
            }
            else{
                $this->erpMessage->setSuccess(false);                
            }
            $this->erpMessage->setMessage($result['msg']);
        }
        else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to Stock Search Page(SearchStock.html.twig)
     * @Route ("/searchstockpage/", name="_gotosearchstock")
     */
    public function GotoSearchStockAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchViewStock');
	if($accessRight==1){
//            try{    
                $em=$this->getDoctrine()->getManager();
                $stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->GetAllStock();
                $storeArr=$em->getRepository(CommonConstant::ENT_ADD_STORE)->findBy(
                            array('recordActiveFlag'=>1),array('storeName'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_SEARCH,
                                            array('stockArr'=>$stockArr,'storeArr'=>$storeArr,'title'=>'Current Stock Status')));
//                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_SEARCH,array('storeArr'=>$storeArr)));
//                $this->erpMessage->setSecondHtml(
//                        array('html'=>$this->renderView(StockConstant::TWIG_STOCK_SEARCH_RESULT,
//                                            array('stockArr'=>$stockArr,'storeArr'=>$storeArr,'title'=>'Current Stock Status')),
//                            'appendid'=>'divStkSearchResult'));
                $this->erpMessage->setSuccess(true);
//            }
//            catch (\Exception $ex) {
//                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
//                $this->erpMessage->setSuccess(false);
//            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);  
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
    }
    
    /**
     * Action: Search stock base on various criteria and display the result
     * @Route ("/searchstock", name="_searchstock")
     */
    public function SearchStockAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchViewStock');
	if($accessRight==1){
            $dataUI=json_decode($request->getContent());
            $mainCriteria=$dataUI->selSearchStkBy;
            $keyword=$dataUI->txtProd;
            $from=$dataUI->txtFrom;
            $to=$dataUI->txtTo;
//            try{
                $em=$this->getDoctrine()->getManager();
                $priceArr=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findBy(array('recordActiveFlag'=>1));
                switch($mainCriteria){
                    case 'all':
                        $stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->GetAllStock();                        
                        break;
                    case 'sku':
                        $stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->SearchStockBySKU($keyword);                        
                        break;
                    case 'qty':
                        $stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->SearchStockByQty($from,$to);                        
                        break;
                    case 'val':
                        $stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->SearchStockByValue($from,$to);                        
                        break;
                    case 're':
                        //$stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->SearchStockByReorderQty($from,$to);
                        $stockArr=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->SearchRequireReorderStock();                        
                        break;
                }
                if($stockArr){
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_SEARCH_RESULT,array('stockArr'=>$stockArr,'priceArr'=>$priceArr,'title'=>'Filtered Result')));
                    $this->erpMessage->setSuccess(true);
                }
                else{
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No Record found!!');
                }
//            }
//            catch (\Exception $ex) {
//                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
//                $this->erpMessage->setSuccess(false);
//            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);   
    }
    /**
     * Action: Navigate to View & Edit Stock page
     * @Route ("/vieweditstockpage/{stockid}", name="_gotovieweditstock")
     */
    public function GotoViewEditStockAction($stockid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStock');
	if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $stock=$em->getRepository(CommonConstant::ENT_STOCK_MASTER)->find($stockid);
                $pomaster=$stock->getpurchaseorderFk();            
                $price=$stock->getPriceFk();
                $store=$stock->getStoreFk();                
                $bldg=$stock->getBuildingFk();
                $floor=$stock->getFloorFk();
                $room=$stock->getRoomFk();
                $rack=$stock->getRackFk();  
                $bin=$stock->getBinFk();
                $storeArr=$em->getRepository(CommonConstant::ENT_ADD_STORE)->findBy(
                                array('recordActiveFlag'=>1),array('storeName'=>'ASC'));
                if($store){                    
                    $bldgArr=$em->getRepository(CommonConstant::ENT_ADD_STORE_BUILDING)->
                            findBy(array('storeMasterFk'=>$store,'recordActiveFlag'=>1),array('buildingName'=>'ASC'));
                }else{
                    $bldgArr=array();
                }
                if($bldg){
                    $floorArr=$em->getRepository(CommonConstant::ENT_BUILDING_FLOOR)->
                            findBy(array('storeBuildingMasterFk'=>$bldg,'recordActiveFlag'=>1),array('storeFloorNo'=>'ASC'));
                }else{
                    $floorArr=array();
                }                    
                if($floor){
                    $roomArr=$em->getRepository(CommonConstant::ENT_BUILDING_ROOM)->
                        findBy(array('storeFloorMasterFk'=>$floor,'recordActiveFlag'=>1),array('storeRoomNo'=>'ASC'));
                }else{
                    //$floorid='';
                    $roomArr=array();
                }

                if($room){
                    $rackArr=$em->getRepository(CommonConstant::ENT_BUILDING_RACK)->
                        findBy(array('storeRoomMasterFk'=>$room,'recordActiveFlag'=>1),array('rackName'=>'ASC'));
                }else{
                    $rackArr=array();
                }
                if($rack){
                    $binArr=$em->getRepository(CommonConstant::ENT_BIN_MASTER)->
                        findBy(array('rackFk'=>$rack,'recordActiveFlag'=>1),array('binNo'=>'ASC'));
                }else{
                    $binArr=array();
                }
                $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('productFk'=>$stock->getProductFk()->getPkid(),'recordActiveFlag'=>1),array('unitName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_STOCK_VIEW_EDIT,
                        array('stock'=>$stock,'unitArr'=>$unitArr,'prdprice'=>$price,
                              'storeArr'=>$storeArr,'store'=>$store,'bldgArr'=>$bldgArr,'bldg'=>$bldg,
                              'floorArr'=>$floorArr,'floor'=>$floor,'roomArr'=>$roomArr,'room'=>$room,
                              'rackArr'=>$rackArr,'rack'=>$rack,'bin'=>$bin,'binArr'=>$binArr,'po'=>$pomaster)));

            } catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    
    /**
     * Action: Update Stock Detail 
     * @Route ("/updatestock/", name="_updatestock")
     */
    public function UpdateStockAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditStock');
	if($accessRight==1){
            $result=$this->get(StockConstant::SERVICE_STOCK)->UpdateStock($request);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);                
            }
            else{
                $this->erpMessage->setSuccess(false);                
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        
    }
    
    /**
     * Action: Delete Stock Detail 
     * @Route ("/deletestock/{stockid}", name="_deletestock")
     */
    public function DeleteStockAction($stockid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteStockAction');
	if($accessRight==1){
            $result=$this->get(StockConstant::SERVICE_STOCK)->DeleteStock($stockid);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);                
            }
            else{
                $this->erpMessage->setSuccess(false);                
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
      
    }
    /**
     * Action: Search all products related to given PO number and display
     * @Route ("/searchproductbypo}", name="_searchproductbypo")
     */
    public function SearchProductByPOAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();
            $dataUI=json_decode($request->getContent());            
            $poNumber=$dataUI->ponumber;
            $po=$em->getRepository(CommonConstant::ENT_PO_MASTER)->
                    findOneBy(array('uiOrderId'=>$poNumber,'recordActiveFlag'=>1));
            if($po){
                $poMaster=$po;
                if($poMaster->getApprovalFlag()==1){
                    $prdArr=$em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->
                            findBy(array('poFk'=>$po,'recordActiveFlag'=>1));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_PO_PRODUCT_LIST,
                            array('productArr'=>$prdArr,'po'=>$poMaster)));
                }
                else{
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('Purchase Order is not approved yet.');
                }
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Purchase Order with the given PO Number found');
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * Action: Display Inventory List
     * @Route ("/inventorylist}", name="_inventorylist")
     */
//    public function InventoryListAction() {
//        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        try{
//            $em=$this->getDoctrine()->getManager();            
//            $po=$em->getRepository(CommonConstant::ENT_PO_MASTER)->
//                    findOneBy(array('uiOrderId'=>$poNumber,'recordActiveFlag'=>1));
//            $prdArr=$em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->
//                            findBy(array('poFk'=>$po,'recordActiveFlag'=>1));
//            $this->erpMessage->setSuccess(true);
//            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_INVENTORY_LIST,
//                            array('productArr'=>$prdArr,'po'=>$poMaster)));                
//        } catch (\Exception $ex) {
//            $this->erpMessage->setSuccess(false);
//            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//        }
//        $jsondata = $serializer->serialize($this->erpMessage, 'json');
//        return new Response($jsondata); 
//    }
}

