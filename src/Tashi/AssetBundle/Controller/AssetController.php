<?php

namespace Tashi\AssetBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tashi\AssetBundle\Helper\AssetConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * 
 * @Route("/asset")
 * 
 */
class AssetController extends Controller {
    private $em;
    protected  $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        // $this->CustomerMessage = new CustomerMessage();
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage = new ERPMessage();
    }

    /**
     * @Route ("/asset/assignAssetOfEmployeeList/", name="_assignAssetOfEmployeeList")
     */
    public function assignAssetOfEmployeeListAction() {   
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assignedAssetListToPartEmpDisplay.html.twig'));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/asset/SearchAssetToAssignToEmp/", name="_SearchAssetToAssignToEmp")
     */
    public function SearchAssetToAssignToEmpAction() {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:afterAssignButtonAssetSearch.html.twig'));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //-----------------------------------------------------------------------------
    /**
     * @Route ("/asset/_SearchAssetStatus", name="_SearchAssetStatus")
     */
    public function SearchAssetStatusAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchAsset');
        if($accessRight==1){
            
           
            try {
                $em = $this->getDoctrine()->getManager();
                $catArr = $em->getRepository(AssetConstant::ASS_CATEGORY_MASTER)->findBy(array('recordActiveFlag' => 1), array('assetCategoryName' => 'ASC'));
                $statusArr = $em->getRepository(AssetConstant::ASS_STATUS_MASTER)->findAll(array('statusName' => 'ASC'));
    //            $this->erpMessage->setSuccess(true);
    //           $result = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetMaster');

                $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_SEARCH_ASSET, array('catArr' => $catArr, 'statusArr' => $statusArr)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/asset/SearchempAssetStatus/{employeePk}/{empId}", name="_SearchempAssetStatus")
     */
    public function SearchEmpAssetStatusAction($employeePk, $empId) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $catArr = $em->getRepository(AssetConstant::ASS_CATEGORY_MASTER)->findBy(array('recordActiveFlag' => 1), array('assetCategoryName' => 'ASC'));
//            $this->erpMessage->setSuccess(true);
//           $result = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetMaster');

            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_ASSET_EMP_ASSIGN, array('catArr' => $catArr, 'employeePk' => $employeePk, 'empId' => $empId)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * Action: Search project
     * @Route ("/searchasset", name="_searchasset")
     */
    public function SearchAssetAction(Request $request) {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchAsset');
	if($accessRight==1){
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->selSearchProjCriteria;
            try {
                $em = $this->getDoctrine()->getManager();
                switch ($criteria) {
                    case 'all':
                        $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->SearchAllAsset();
                        break;
                    case 'cat':
                        $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->SearchAssettByCategory($dataUI->selProjCategory);
                        break;
                    case 'date':
                        $assetSearch = $dataUI->assetname;
                        $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->SearchAssetDetails($assetSearch);
                        break;
                    case 'status':
                        $statusid = $dataUI->selProjStatus;
                        $criteria = array('status' => $statusid, 'recordActiveFlag' => 1);
                        $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->findBy($criteria, array('assetName' => 'ASC'));
                        break;
                }
                if ($projArr) {
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_SEARCH_ASSET_RESULT, array('projArr' => $projArr)));
                } else {
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No Matching Record Found!!!');
                }
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: ' . $ex->getMessage());
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
    }

    /**
     * @Route ("/asset/displayCategoryAsset/{employeePk}/{empId}", name="_displayCategoryAsset")
     */
    public function DisplayCategoryAssetAction(Request $request, $employeePk, $empId) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            // $asset = $this->get(AssetConstant::SERVICE_ASSET)->displayRecordsByCatAss('AssetMaster',$request);
            $asset = $this->get(AssetConstant::SERVICE_ASSET)->displayAsset('AssetMaster', $request, $employeePk);
            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSET, array('asset' => $asset, 'employeePk' => $employeePk, 'empId' => $empId)));

            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * Action: Search project
     * @Route ("/searchempasset/{employeePk}/{empId}", name="_searchempasset")
     */
    public function SearchEmpAssetAction(Request $request, $employeePk, $empId) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $dataUI = json_decode($request->getContent());
        $criteria = $dataUI->selSearchProjCriteria;
        try {
            $em = $this->getDoctrine()->getManager();
            switch ($criteria) {
                case 'all':
                    $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->findBy(array('recordActiveFlag' => 1, 'status' => '2'));
//                    $projArr=$em->getRepository(AssetConstant::ASS_MASTER)->SearchAllAsset();
                    break;
                case 'cat':
                    $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->SearchEmpAssettByCategory($dataUI->selProjCategory);
                    break;
                case 'date':
                    $assetSearch = $dataUI->assetname;
                    $projArr = $em->getRepository(AssetConstant::ASS_MASTER)->findBy(array('recordActiveFlag' => 1, 'status' => '2', 'assetName' => $assetSearch));
                    break;
            }
            if ($projArr) {
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSET, array('projArr' => $projArr, 'employeePk' => $employeePk, 'empId' => $empId)));
            } else {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Matching Record Found!!!');
            }
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: ' . $ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * Action: Load Status log of a particular Project Item and display
     * @Route(path="/assetstatus/{asetid}", name="_assetstatus")
     */
    public function AsetStatusAction($asetid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('UpdateAssetStatus');
	if($accessRight==1){
            try {
                $em = $this->getDoctrine()->getManager();
                $item = $em->getRepository(AssetConstant::ASS_MASTER)->find($asetid);
                $masterStatusArr = $em->getRepository(AssetConstant::ASS_STATUS_MASTER)->findAll(array('pkid' => 'ASC'));
    //            $itemStatusArr=$em->getRepository(AssetConstant::ASS_MASTER_TXN)->
    //                    findBy(array('itemFk'=>$asetid,'recordActiveFlag'=>1),array('statusDate'=>'ASC'));
    //            $this->erpMessage->setSuccess(true);
    //            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_STATUS_UPDATE_ASSET,
    //                    array('item'=>$item,'statusArr'=>$masterStatusArr,'itemstatusArr'=>$itemStatusArr)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_STATUS_UPDATE_ASSET, array('item' => $item, 'statusArr' => $masterStatusArr)));
            } catch (Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: ' . $ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * Action: Update Status  of a particular Project Item and display the status log
     * @Route(path="/updateassetstatus/{itemid}", name="_updateassetstatus")
     */
    public function UpdateAssetStatusAction(Request $request, $itemid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('UpdateAssetStatus');
	if($accessRight==1){
            $result = $this->get(AssetConstant::SERVICE_ASSET)->UpdateAssetStatus($request, $itemid);
            if ($result['code'] == 1) {
                try {
                    $em = $this->getDoctrine()->getManager();
                    $item = $em->getRepository(AssetConstant::ASS_MASTER)->find($itemid);
                    $masterStatusArr = $em->getRepository(AssetConstant::ASS_STATUS_MASTER)->findAll(array('pkid' => 'ASC'));
                    $itemStatusArr = $em->getRepository(AssetConstant::ASS_MASTER_TXN)->
                            findBy(array('asset' => $itemid, 'recordActiveFlag' => 1), array('statusDate' => 'ASC'));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_STATUS_UPDATE_ASSET, array('item' => $item, 'statusArr' => $masterStatusArr, 'itemstatusArr' => $itemStatusArr)));
                } catch (Exception $ex) {
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: ' . $ex->getMessage());
                }
            } else {
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * @Route("/searchAssetByVariousfields",  name="_searchAssetByVariousfields")
     *    
     */
    public function searchAssetByVariousfieldsAction(Request $request) {
        // echo $request; die();
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $dataUI = json_decode($request->getContent());
        $assetSearch = $dataUI->assetname;
//       $catSearch=$dataUI->catname;
        //echo $assetSearch;die();
        try {
            //          $queryResult=$this->em->getRepository(AssetConstant::ASS_CATEGORY_MASTER)->SearchCategoryDetails($catSearch);
            $queryResult = $this->em->getRepository(AssetConstant::ASS_MASTER)->SearchAssetDetails($assetSearch);
            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_SEARCH_ASSET_RESULT, array('asset' => $queryResult)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * @Route ("/assetdetail/{asetid}", name="_assetdetail")
     */
    public function GotoAssetDetail($asetid) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $assetresult = $this->get(AssetConstant::SERVICE_ASSET)->retreiveAssetDetailIndexMaster($asetid);
            $queryResult = $this->em->getRepository(AssetConstant::ASS_MASTER)->find($asetid);
            //$this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetDetailIndex.html.twig',array('asetId'=>$asetid)));
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetDetail.html.twig', array('asetId' => $queryResult)));
            $this->erpMessage->setSuccess(true);

            $this->erpMessage->setJsonData($assetresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * @Route ("/assetempdetail/{employeePk}", name="_assetempdetail")
     */
    public function GotoAssetEmpDetail($employeePk) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empAssignedasset = $this->get(AssetConstant::SERVICE_ASSET)->displayRecordsByemp('EmpAssetAssignTxn', $employeePk);
            //  echo $employeePk; die();
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetEmpDetail.html.twig', array('empAssignedasset' => $empAssignedasset)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/asset/assethistory/{asetid}", name="_asset_history")
     */
    public function assetHistoryAction($asetid) {
        //  echo '$asetid';die();
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $criteria = array('asset' => $asetid, 'recordActiveFlag' => 1);
            $sort = array('pkid' => 'ASC');
            $queryResult = $this->em->getRepository(AssetConstant::ASS_MASTER_TXN)->findBy($criteria, $sort);
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetHistory.html.twig', array('asetId' => $queryResult)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/Asset/retrieveAssetIndex/{ARid}", name="_retrieveAssetIndex")
     */
    public function retreiveAssetDetailAction($ARid) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {

            $assetresult = $this->get(AssetConstant::SERVICE_ASSET)->retreiveAssetDetailIndexMaster($ARid);
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:displayAssetRegister.html.twig'));

            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($assetresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**

     * 
     * @Route("/asset_searchDetails", name="_asset_searchDetails")
     *    
     */
    public function searchAssetDisplayAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {


            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:displayAssetRegister.html.twig'));


            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**

     * 
     * @Route("/SearchAssetStatusDisplay", name="_SearchAssetStatusDisplay")
     *    
     */
    public function searchAssetstatusDisplayAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {


            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:searchAssetStatusResultdisplay.html.twig'));


            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //---------------------date 30-apr-2015-------------------------//

    /**
     * @Route ("/asset/displayssCategoryAsset/{employeePk}/{empId}", name="_displayssCategoryAsset")
     */
    public function DisplayssCategoryAssetAction(Request $request, $employeePk, $empId) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            // $asset = $this->get(AssetConstant::SERVICE_ASSET)->displayRecordsByCatAss('AssetMaster',$request);
            $asset = $this->get(AssetConstant::SERVICE_ASSET)->displayAsset('AssetMaster', $request, $employeePk);
            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSET, array('asset' => $asset, 'employeePk' => $employeePk, 'empId' => $empId)));

            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //------------------------------------------------------------------//
    //---------------------- delete portions-----------------------------//

    /**
     * @Route ("/Asset/deleteAssetCategory/{ACid}", name="_deleteAssetCategory")
     * 
     */
    public function deleteAssetCategoryAction($ACid) { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteAssetRecord');
	if($accessRight==1){       
            try {
                $result = $this->get(AssetConstant::SERVICE_ASSET)->deleteAssetCategoryMaster($ACid);
                //  echo "ok controller"; die();
                $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSETCATEGORY, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/Asset/deleteAssetRegister/{ARid}", name="_deleteAssetRegister")
     * 
     */
    public function deleteAssetRegisterAction($ARid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteAssetRecord');
	if($accessRight==1){     
            try {
                $result = $this->get(AssetConstant::SERVICE_ASSET)->deleteAssetRegisterMaster($ARid);
                $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSETREGISTER, array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/Asset/deleteAssetAssign/{assetAssignPk}/{empPk}", name="_deleteAssetAssign")
     * 
     */
    public function deleteAssetAssignAction($assetAssignPk, $empPk) {
        // echo $assetAssignPk; die();
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(AssetConstant::SERVICE_ASSET)->deleteAssetAssignMaster($assetAssignPk, $empPk);
            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSETASSIGN, array('record' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //---------------------delete portions ends-------------------------//
    //----------------asset assign save, update, edit, retrieve---------------//
    /**
     * @Route ("/Asset/saveAssetAssignMaster/{empId}/{employeePk}", name="_saveAssetAssignMaster")
     */
    public function saveAssetAssignAction(Request $request, $empId, $employeePk) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('saveAssetAssignAction');
	if($accessRight==1){
            
            
            try {
                $result = $this->get(AssetConstant::SERVICE_ASSET)->saveAssetAssignMaster($request, $empId, $employeePk);
                $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assignAssetPageAfterInsert.html.twig', array('record' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/Asset/retrieveAssetAssign/{assetAssignPk}/{empPk}", name="_retrieveAssetAssign")
     */
    public function retreiveAssetAssignAction($assetAssignPk, $empPk) {
        // echo $assetAssignPk; die();
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $assetresult = $this->get(AssetConstant::SERVICE_ASSET)->retreiveAssetAssignMaster($assetAssignPk, $empPk);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($assetresult);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //----------------asset assign save, update, edit, retrieve---------------//

    /**
     * @Route ("/asset/dashboard", name="_asset_dashboard")
     */
    public function assetDashboardAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetDashboard.html.twig'));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/asset/asset_assignment", name="_asset_assignment")
     */
    public function addAssignAssetAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empjobtitle = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('EmpJobTitleMaster');
            $empjobprofile = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('EmpJobProfileMaster');
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:employeeMasterAssignAsset.html.twig'
                            , array('empjobtitle' => $empjobtitle, 'empjobprofile' => $empjobprofile)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * @Route ("/assetdetailindex/{asetid}", name="_assetdetailindex")
     */
    public function GotoAssetDetailIndex($asetid) {
        //echo $asetid; die();
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $assetresult = $this->get(AssetConstant::SERVICE_ASSET)->retreiveAssetDetailIndexMaster($asetid);
            $queryResult = $this->em->getRepository(AssetConstant::ASS_MASTER)->find($asetid);
            $category = $this->em->getRepository(AssetConstant::ASS_CATEGORY_MASTER)->findByRecordActiveFlag(1);

            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetDetailIndex.html.twig', array('asetId' => $asetid)));
            $this->erpMessage->setSecondHtml($this->renderView('TashiAssetBundle:Asset:assetDetail.html.twig', array('asetId' => $queryResult, 'assetCategory' => $category)));
            $this->erpMessage->setSuccess(true);

            $this->erpMessage->setJsonData($assetresult);
        } catch (\Exception $ex) {
            //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/asset/assignAssetToEmployee/{empName}/{empId}/{employeePk}", name="_assignAssetToEmployee")
     */
    public function AssignAssetToEmployeeAction($empName, $empId, $employeePk) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $catArr = $em->getRepository(AssetConstant::ASS_CATEGORY_MASTER)->findBy(array('recordActiveFlag' => 1), array('assetCategoryName' => 'ASC'));
            $result = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('EmpAssetAssignTxn');
            $assetcategory = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetCategoryMaster');
            $assetList = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetMaster');

            $empAssignedasset = $this->get(AssetConstant::SERVICE_ASSET)->displayRecordsByemp('EmpAssetAssignTxn', $employeePk);
            //  echo $employeePk; die();
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetEmpDetailIndex.html.twig', array('catArr' => $catArr, 'record' => $result, 'empAssignedasset' => $empAssignedasset, 'assetcategory' => $assetcategory, 'assetList' => $assetList, 'empName' => $empName, 'empId' => $empId, 'employeePk' => $employeePk)));
            $this->erpMessage->setSecondHtml($this->renderView('TashiAssetBundle:Asset:assetEmpDetail.html.twig', array('empAssignedasset' => $empAssignedasset)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/asset/asset_category", name="_asset_category")
     */
    public function addAssetCategoryAction() {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetCategoryMaster');
            $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:assetCategory.html.twig'
                            , array('record' => $result)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/Asset/saveAssetCategory/{assetCateID}", name="_saveAssetCategory")
     */
    public function saveAssetCategoryAction(Request $request, $assetCateID) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        if($assetCateID=='0'){ //for restricting insert
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddAssetRecord');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED)); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }else{
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditAssetRecord');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));  
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }   
        try {
            $result = $this->get(AssetConstant::SERVICE_ASSET)->saveAssetCategoryMaster($request, $assetCateID);
            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSETCATEGORY
                            , array('record' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/Asset/retrieveAssetCategory/{ACid}", name="_retrieveAssetCategory")
     */
    public function retreiveAssetCategoryAction($ACid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditAssetRecord');
	if($accessRight==1){
            
            try {
                $assetresult = $this->get(AssetConstant::SERVICE_ASSET)->retreiveAssetCategoryMaster($ACid);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($assetresult);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //------------- assign asset register starts here---------------------------------//
    /**
     * @Route ("/asset/asset_register", name="_asset_register")
     */
    public function addAssetRegisterAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddAssetRecord');
	if($accessRight==1){
            // echo " ok asset reg con"; die();
            
            
            try {
                $assetCategory = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetCategoryMaster');
                $assetStatus = $this->get(AssetConstant::SERVICE_ASSET)->displayAllRecords('AssetStatusMaster');
                $result = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetMaster');

                $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:employeeMasterRegisterAsset.html.twig'
                                , array('record' => $result, 'assetCategory' => $assetCategory, 'assetStatus' => $assetStatus)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/Asset/saveAssetRegister", name="_saveAssetRegister")
     */
    public function saveAssetRegisterAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $assetRegisterId = $request->request->get('assetRegisterId');
        if($assetRegisterId==''){
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AddAssetRecord');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }else{
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditAssetRecord');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
        }
        try {
            $result = $this->get(AssetConstant::SERVICE_ASSET)->saveAssetRegisterMaster($request);
            $this->erpMessage->setHtml($this->renderView(AssetConstant::TWIG_DISPLAY_ASSETREGISTER, array('record' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/Asset/retrieveAssetRegister/{ARid}", name="_retrieveAssetRegister")
     */
    public function retreiveAssetRegisterAction($ARid) {    
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditAssetRecord');
	if($accessRight==1){
            try {
                $result = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('AssetMaster');
                $assetStatus = $this->get(AssetConstant::SERVICE_ASSET)->displayAllRecords('AssetStatusMaster');

                $assetresult = $this->get(AssetConstant::SERVICE_ASSET)->retreiveAssetRegisterMaster($ARid);
                $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:employeeMasterRegisterAsset.html.twig'
                                , array('record' => $result, 'assetStatus' => $assetStatus)));

                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($assetresult);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/asset/asset_assignment", name="_asset_search")
     */
    public function addSearchAssetAction() { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AssignAsset');
	if($accessRight==1){
            
           
            try {
                $empjobtitle = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('EmpJobTitleMaster');
                $empjobprofile = $this->get(AssetConstant::SERVICE_ASSET)->displayAllResult('EmpJobProfileMaster');
                $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:employeeMasterAssignAsset.html.twig'
                                , array('empjobtitle' => $empjobtitle, 'empjobprofile' => $empjobprofile)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

}
