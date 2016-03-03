<?php

namespace Tashi\AssetBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\AssetBundle\Helper\AssetConstant;
use Tashi\CommonBundle\Entity\AssetCategoryMaster;
use Tashi\CommonBundle\Entity\AssetMaster;
use Tashi\CommonBundle\Entity\EmpAssetAssignTxn;
use Tashi\CommonBundle\Entity\AssetStatusMaster;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\AssetStatusTxn;

class AssetService {

    protected $em;
    protected $session;
    protected $commonService;
    protected $webRoot;

    public function __construct(EntityManager $em, Session $session, $rootDir, $commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->commonService = $commonService;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
    }

    public function displayRecordsByemp($entityName, $employeePk) {

        $EmpAss = $this->em->getRepository('TashiCommonBundle:' . $entityName)->findBy(array('empMasterFk' => $employeePk, 'recordActiveFlag' => 1));
        //echo $EmpAss[0]->getAssetRegisterFk()->getAssetName(); die();
        //$assetStatus=$EmpAss[0]->getAssetRegisterFk()->getStatus()->getStatusName();
        //echo $assetStatus; die();
        return $EmpAss;
    }

    //-------------------------------------------------------------------------------
    public function searchAsset($request) {

        try {
            // echo "ok service search"; die();
            $dataUI = json_decode($request->getContent());

            $assName = $dataUI->assetname;
//            $assModelNo = $dataUI->asset_modelno;
//            $assProdSerial = $dataUI->asset_prod_serial;
//            $assManufacturer = $dataUI->assetmaker;
//            $assPurchaseOrderNo = $dataUI->txt_asset_po_no;
//            $assBarCode = $dataUI->txt_asset_BarCode;
//
//            $queryString = "SELECT ass 
//                             FROM TashiCommonBundle:AssetMaster ass 
//                             
//                             WHERE ass.recordActiveFlag=:activFlag";
//            $parameters = array();
//
//            $parameters['activFlag'] = 1;
//
            if (!empty($assName) & !is_null($assName)) {
                $queryString .= " AND ass.assetName LIKE :assName ";
                $parameters['assName'] = $assName . '%';
            }
//            if (!empty($assModelNo) & !is_null($assModelNo)) {
//                $queryString .= " AND ass.modelNo = :assModelNo ";
//                $parameters['assModelNo'] = $assModelNo;
//            }
//            if (!empty($assProdSerial) & !is_null($assProdSerial)) {
//                $queryString .= " AND ass.serialNo = :assProdSerial ";
//                $parameters['assProdSerial'] = $assProdSerial;
//            }
//            if (!empty($assManufacturer) & !is_null($assManufacturer)) {
//                $queryString .= " AND ass.manufacturer LIKE :assManufacturer ";
//                $parameters['assManufacturer'] = $assManufacturer . '%';
//            }
//            if (!empty($assPurchaseOrderNo) & !is_null($assPurchaseOrderNo)) {
//                $queryString .= " AND ass.purchaseOrderNo = :assPurchaseOrderNo ";
//                $parameters['assPurchaseOrderNo'] = $assPurchaseOrderNo;
//            }
//            if (!empty($assBarCode) & !is_null($assBarCode)) {
//                $queryString .= " AND ass.barcodeNo = :assBarCode ";
//                $parameters['assBarCode'] = $assBarCode;
//            }
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('searchResultasset' => $resultSearch);
    }

//    ----------------------------------------------------------------------------------------------
    function UpdateAssetStatus($request, $asetid) {
        $dataUI = json_decode($request->getContent());
        $conn = $this->em->getConnection();
        try {
            $statusid = $dataUI->SelItemStatus;
//            $sdate=$dataUI->txtstatusDate;
            $remarks = $dataUI->txtRemarks;
            $item = $this->em->getRepository(AssetConstant::ASS_MASTER)->find($asetid);
            if ($item->getStatus()->getPkid() == $statusid) {
                return array('code' => 0, 'msg' => 'Asset is already in \'' . $item->getStatus()->getStatusName() . '\' status');
            }
            $conn->beginTransaction();
            $status = $this->em->getRepository(AssetConstant::ASS_STATUS_MASTER)->find($statusid);

            //UPDATE STATUS IN ASSET MASTER
            $item->setStatus($status);
            $item->setRecordUpdateDate(new \DateTime("NOW"));
            $item->setApplicationUserId($this->session->get('EMPID'));
            $item->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($item);
            //INSERT IN ASSET STATUS TXN
            $itemstatus = new AssetStatusTxn();
            $itemstatus->setAsset($item);
            $itemstatus->setStatus($status);
//            $itemstatus->setStatusDate(new \DateTime($sdate));
            $itemstatus->setRemarks($remarks);
            $itemstatus->setRecordActiveFlag(1);
            $itemstatus->setRecordInsertDate(new \DateTime("NOW"));
            $itemstatus->setApplicationUserId($this->session->get('EMPID'));
            $itemstatus->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($itemstatus);
            $this->em->flush($itemstatus);
            $conn->commit();
            $returnCode = 1;
            $returnMsg = 'Status updated successfully.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnCode = 0;
            $returnMsg = 'Unable to process due to an unexpected server error. Error:' . $ex->getMessage();
        }
        return array('code' => $returnCode, 'msg' => $returnMsg);
    }

    //--------------------------------------------------------------------------------

    public function displayAllResult($tbl_name) {
        try {
            return $this->commonService->activeList($tbl_name);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function displayAllRecords($entityName) {
        return $this->em->getRepository('TashiCommonBundle:' . $entityName)->findAll(); //findAll(array('activeFlag'=>1));
    }

    public function displayRecordsByCatAss($entityName, $request) {

        $AssCategoryId = $request->request->get('AssCategoryId');
        $ass = $this->em->getRepository('TashiCommonBundle:' . $entityName)->findBy(array('assetCategoryMasterFk' => $AssCategoryId, 'recordActiveFlag' => 1, 'status' => 2));
        return $ass;
    }

    public function displayAsset($entityName, $request, $empPk) {
        $AssCategoryId = $request->request->get('AssCategoryId');

        $parameters = array();
        $queryString = "SELECT ass 
                             FROM TashiCommonBundle:AssetMaster ass 
                             WHERE ass.recordActiveFlag=:activFlag and ass.status=:available 
                             and ass.assetCategoryMasterFk=:AssCategoryId";

        $parameters['activFlag'] = 1;
        $parameters['available'] = 2;
        $parameters['AssCategoryId'] = $AssCategoryId;

        $query = $this->em->createQuery($queryString);
        $query->setParameters($parameters);
        $resultSearch = $query->getResult();
        return $resultSearch;
    }

    public function searchAssetByName($request, $employeePk) {

        try {

            $dataUI = json_decode($request->getContent());

            $assName = $dataUI->searchByAsset;


            $parameters = array();
//            $queryString = "SELECT ass 
//                             FROM TashiCommonBundle:AssetMaster ass 
//                             WHERE ass.recordActiveFlag=:activFlag and ass.status=:available ";
            $queryString = "SELECT ass 
                             FROM TashiCommonBundle:AssetMaster ass 
                             WHERE ass.recordActiveFlag=:activFlag and ass.status=:available ass.assetRegisterPk not in
                             (SELECT aae 
                             FROM TashiCommonBundle:EmpAssetAssignTxn aae where aae.empMasterFk=:empPk ) ";


            $parameters['activFlag'] = 1;
            $parameters['available'] = 2;
            $parameters['empPk'] = $empPk;
            if (!empty($assName) & !is_null($assName)) {
                $queryString .= " AND ass.assetName LIKE :assName ";
                $parameters['assName'] = $assName . '%';
            }


            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function retreiveAssetDetailIndexMaster($asetid) {
        // echo $asetid; die();
        try {
            $AssetObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($asetid);
            $assetStatusId = $AssetObj->getStatus()->getPkid();
            $expiry_date = $AssetObj->getExpiryDate();
            if ($expiry_date) {
                $expiry_date = date_format($expiry_date, 'Y-m-d');
            }
            $waranty_date = $AssetObj->getWarranty();
            if ($waranty_date) {
                $waranty_date = date_format($waranty_date, 'Y-m-d');
            }
            $manufacture_date = $AssetObj->getManufacturingDate();
            if ($manufacture_date) {
                $manufacture_date = date_format($manufacture_date, 'Y-m-d');
            }
            $purchase_date = $AssetObj->getPurchaseDate();
            if ($purchase_date) {
                $purchase_date = date_format($purchase_date, 'Y-m-d');
            }

            $return = array('ARid' => $asetid,
                'assetName' => $AssetObj->getAssetName(),
                'categoryId' => $AssetObj->getAssetCategoryMasterFk()->getAssetMasterPk(),
                'assetmaker' => $AssetObj->getManufacturer(),
                'assetmodelno' => $AssetObj->getModelNo(),
                'assetexpiry' => $expiry_date,
                'assetwaranty' => $waranty_date,
                'assetpono' => $AssetObj->getPurchaseOrderNo(),
                'assetlocation' => $AssetObj->getLocation(),
                'assetdescription' => $AssetObj->getAssetDescription(),
                'assetstatus' => $assetStatusId,
                'assProductSerial' => $AssetObj->getSerialNo(),
                'assManufDate' => $manufacture_date,
                'assBarCode' => $AssetObj->getBarcodeNo(),
                'assPurchasePrice' => $AssetObj->getPurchasePrice(),
                'assetPurchaseDate' => $purchase_date,
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    //---------------- delete portions-----------------------//
    public function deleteAssetCategoryMaster($ACid) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:AssetCategoryMaster')->find($ACid);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('AssetCategoryMaster') ;
            $id=$ACidObj->getAssetMasterPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Sucessfully',
//            'result' => $this->commonService->activeList('AssetCategoryMaster'),
//            'id' => $ACidObj->getAssetMasterPk());
//    }

    public function deleteAssetRegisterMaster($ARid) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($ARid);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('AssetMaster') ;
            $id=$ACidObj->getAssetRegisterPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Sucessfully',
//            'result' => $this->commonService->activeList('AssetMaster'),
//            'id' => $ACidObj->getAssetRegisterPk());
//    }

    public function deleteAssetAssignMaster($AssetAssignPk, $empPk) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpAssetAssignTxn')->find($AssetAssignPk);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg='Deleted Sucessfully';
            $result=$this->commonService->activeList('EmpAssetAssignTxn') ;
            $id=$ACidObj->getAssetAssignPk();
        }catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'id' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => 'Deleted Sucessfully',
//            'result' => $this->commonService->activeList('EmpAssetAssignTxn'),
//            'id' => $ACidObj->getAssetAssignPk());
//    }

    //----------------- delete portins ends -----------------//
//--------------------ASSET ASSIGN--------------------------------------//
    public function saveAssetAssignMaster($request, $empId, $employeePk) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //it suspends auto-commit in order to enable redo for sometime
        try {

            $dataUI = json_decode($request->getContent());

            $assCheckArr = array();
            if (is_string($dataUI->checkAsset)) {
                $assCheckArr[0] = $dataUI->checkAsset; //for only one 
            } else {
                $assCheckArr = $dataUI->checkAsset;     //for more than one       
            }

            //print_r($assCheckArr) ; die();
            $assetStartDate = $dataUI->txt_start_date;
            $assetEndDate = $dataUI->txt_end_date;
            $AssignedAssAftrSrchId = $dataUI->AssignedAssAftrSrchId;

            foreach ($assCheckArr as $value) {
                // echo $value; die();
                $AssetObj = new EmpAssetAssignTxn();
                $AssetObj->setStartDate(new \DateTime($assetStartDate));
                $AssetObj->setEndDate(new \Datetime($assetEndDate));
                $AssetObj->setRecordActiveFlag(1);
                $AssetObj->setRecordInsertDate(new \Datetime());
                $AssetObj->setApplicationUserId($this->session->get('EMPID'));
                $AssetObj->setApplicationUserIpAddress($this->session->get('IP'));

                $assMasterObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($value);
                $assCatId = $assMasterObj->getAssetCategoryMasterFk()->getAssetMasterPk();

                $AssetObj->setAssetRegisterFk($this->em->getRepository('TashiCommonBundle:AssetMaster')->find($value));
                $AssetObj->setAssetCategoryFk($this->em->getRepository('TashiCommonBundle:AssetCategoryMaster')->find($assCatId));
                $AssetObj->setEmpMasterFk($this->em->getRepository('TashiCommonBundle:EmpEmployeeMaster')->find($employeePk));


                $this->em->persist($AssetObj);
                $this->em->flush();

                $Obj = $this->em->getRepository('TashiCommonBundle:EmpEmployeeMaster')->find($employeePk);
                $empName = $Obj->getPersonFk()->getPersonName();
                $assignedAssForEmp = $this->em->getRepository('TashiCommonBundle:EmpAssetAssignTxn')->findBy(array('empMasterFk' => $employeePk));


                //------------------------------ UPDATE ASSET MASTER-----------------
                $AssetMasterObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($value);
                $AssetMasterObj->setStatus($this->em->getRepository('TashiCommonBundle:AssetStatusMaster')->find(3));
                $AssetMasterObj->setRecordUpdateDate(new \DateTime("NOW"));
                $AssetMasterObj->setApplicationUserId($this->session->get('EMPID'));
                //------------------------------ END UPDATE ASSET MASTER-----------------
                //------------------------------ INSERT ASSET STATUS TXN-----------------
                $AssetstatusObj = new AssetStatusTxn();
                $AssetstatusObj->setAsset($AssetMasterObj);
                $assetRemark1 = "Assign to " . $employeePk;
                $AssetstatusObj->setStatus($this->em->getRepository('TashiCommonBundle:AssetStatusMaster')->find(3));
                $AssetstatusObj->setRemarks($assetRemark1);

                $AssetstatusObj->setRecordActiveFlag(1);

                $AssetstatusObj->setRecordInsertDate(new \Datetime());
                $AssetstatusObj->setStatusDate(new \Datetime());
                $AssetstatusObj->setApplicationUserId($this->session->get('EMPID'));
                $AssetstatusObj->setApplicationUserIpAddress($this->session->get('IP'));

                $this->em->persist($AssetstatusObj);
                $this->em->flush();
                //------------------------------ END ASSET STATUS TXN----------------- 
            }
            $conn->commit();


            $msg = 'Asset Assigned Sucessfully To  ' . $empName;
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $assignedAssForEmp,
            'AssignedAssAftrSrchId' => $AssetObj->getAssetAssignPk()
        );
    }

    public function retreiveAssetAssignMaster($assetAssignPk, $empPk) {
        // echo $assetAssignPk; die();
        try {
            $AssetObj = $this->em->getRepository('TashiCommonBundle:EmpAssetAssignTxn')->find($assetAssignPk);

            $return = array('assetAssignPk' => $assetAssignPk,
                'assetcategory' => $AssetObj->getAssetCategoryFk()->getAssetMasterPk(),
                'assetList' => $AssetObj->getAssetRegisterFk()->getAssetRegisterPk(),
                'start_date' => date_format($AssetObj->getStartDate(), 'Y-m-d'),
                'end_date' => date_format($AssetObj->getEndDate(), 'Y-m-d')
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

//----------------------ASSET ASSIGN ENDS -----------------------------------//

    /*     * ***********this service is mainly for AssetCategory(Adding, Updating , Retrieving ,Deleting) master*********** */
    public function saveAssetCategoryMaster($request, $assetCateID) {
        try {

            $dataUI = json_decode($request->getContent());
            $assetCategory = $dataUI->assetcategory;
            $assetCategoryDescription = $dataUI->assetcategorydescription;
            $AssetCategoryId = $dataUI->AssetCategoryId;
            if ($AssetCategoryId == "") {
                $AssetObj = new AssetCategoryMaster();
            } else {
                $AssetObj = $this->em->getRepository('TashiCommonBundle:AssetCategoryMaster')->find($AssetCategoryId);
            }
            $AssetObj->setAssetCategoryName($assetCategory);
            $AssetObj->setAssetDescription($assetCategoryDescription);
            $AssetObj->setRecordActiveFlag(1);

            if ($AssetCategoryId == "") {
                $AssetObj->setRecordInsertDate(new \Datetime());
                $AssetObj->setApplicationUserId($this->session->get('EMPID'));
                $AssetObj->setApplicationUserIpAddress($this->session->get('IP'));
            } else {
                $AssetObj->setRecordUpdateDate(new \Datetime());
                $AssetObj->setApplicationUserId($this->session->get('EMPID'));
                $AssetObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            //Auto generate  $assetCategory_ID
            $assetCategory_ID = '';
            $queryString = "SELECT MAX(ass.assetCategoryId) assetCateID
                               FROM TashiCommonBundle:AssetCategoryMaster ass ";
            $query = $this->em->createQuery($queryString);
            $result = $query->getSingleResult();

            if ($result) {
                $assetCategory_ID = $result['assetCateID'] + 1;
            } else {
                $assetCategory_ID = 1; // first generated no.
            }


            $AssetObj->setAssetCategoryId($assetCategory_ID);
            $this->em->persist($AssetObj);
            $this->em->flush();
            if ($AssetCategoryId == "") {
                $returnmsg = 'Record Save Sucessfully';
            } else {
                $returnmsg = 'Record Updated Sucessfully';
            }
                $result=$this->commonService->activeList('AssetCategoryMaster') ;
                $id=$AssetObj->getAssetMasterPk();
            } catch (\Exception $ex) {
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('msg' => $returnmsg,
                                'result' => $result,
                                'AssetCategoryId' => $id
                            );
    }
//        } catch (\Exception $ex) {
//            throw new \Exception($ex->getMessage());
//        }
//        return array('msg' => $msg,
//            'result' => $this->commonService->activeList('AssetCategoryMaster'),
//            'AssetCategoryId' => $AssetObj->getAssetMasterPk()
//        );
//    }

    public function retreiveAssetCategoryMaster($ACid) {

        try {
            $AssetObj = $this->em->getRepository('TashiCommonBundle:AssetCategoryMaster')->find($ACid);
            $return = array('ACid' => $ACid,
                'assetName' => $AssetObj->getAssetCategoryName(),
                'assetDescription' => $AssetObj->getAssetDescription(),
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    /*     * ***********this service is mainly for AssetRegister(Adding, Updating , Retrieving ,Deleting) master*********** */

    public function saveAssetRegisterMaster($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        try {
//            $dataUI = json_decode($request->getContent());
            $assetRegisterId = $request->request->get('assetRegisterId');
            $assetCategory = $request->request->get('assetCategory');
            $assetname = $request->request->get('assetname');
            $assetmaker = $request->request->get('assetmaker');

            $assetmodelno = $request->request->get('txt_asset_modelno');
            $assetexpiry = $request->request->get('txt_asset_expiry');
            $assetwaranty = $request->request->get('txt_asset_waranty');

            $assetpono = $request->request->get('txt_asset_po_no');
            $assetlocation = $request->request->get('txt_asset_locatioin');
            $assetdescription = $request->request->get('txt_asset_description');

            $assetProdSerial = $request->request->get('asset_prod_serial');
            $assManufDate = $request->request->get('txt_asset_Manuf_date');
            $assBarCode = $request->request->get('txt_asset_BarCode');
            $assPurchasePrice = $request->request->get('txt_asset_purPrice');
            $assetPurchaseDate = $request->request->get('txt_asset_purDate');
            $fileupload = $request->files->get('txt_emp_pro_pic');
            $uploadedFiles = array();
            $validFileTypes = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');
            $newfilepathname = '';

            // $assetStatus = $dataUI->assetStatus;

            $assetCategoryId = $this->em->getRepository('TashiCommonBundle:AssetCategoryMaster')->find($assetCategory);


            if ($assetRegisterId == "") {
                $AssetObj = new AssetMaster();
            } else {
                $AssetObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($assetRegisterId);
            }
            if ($assetRegisterId == "") {
                $AssetObj->setStatus($this->em->getRepository('TashiCommonBundle:AssetStatusMaster')->find(2));
            }

            if ($assetRegisterId == '') {
                $isDocNew = true;
                $prevfilepath = '';
                $document = '';
            } else { //update part
                $AssetObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($assetRegisterId);
                $isDocNew = false;
                $document = $AssetObj->getAssetPhotofk();
            }
            //upload profile picture        
            if ($document) {
                $prevfilepath = $document->getPath();
            }
            //echo '4'; die();      
            if (isset($fileupload)) {      //echo '3'; die();          
                $path = 'upload/ASSET/REGISTER/';
                $fuploadresult = $this->commonService->UploadFile($fileupload, $path, 1, $validFileTypes);
                if ($fuploadresult['code'] == 1) {
                    $uploadedFiles[] = $fuploadresult['fullpath'];
                    //save image in document master
                    if (!$document) {
                        //echo '1'; die();
                        $document = new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew = true;
                    } else {
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }
                    //echo '2'; die();
                    $document->setPath($path . $fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if ($isDocNew) {
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if (file_exists($prevfilepath)) {
                        unlink($prevfilepath);
                    }
                } else {
                    $conn->rollBack();
                    foreach ($uploadedFiles as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    return array('code' => 0, 'msg' => $fuploadresult['msg']);
                }
            }
            //end upload profile picture
            if ($isDocNew) {
                if ($document !== '') {
                    $AssetObj->setAssetPhotofk($document);
                }
            }

            $AssetObj->setAssetName($assetname);
            $AssetObj->setManufacturer($assetmaker);
            $AssetObj->setAssetCategoryMasterFk($assetCategoryId);
            $AssetObj->setModelNo($assetmodelno);
            if ($assetexpiry == '') {
                $AssetObj->setExpiryDate(NULL);
            } else {
                $AssetObj->setExpiryDate(new \Datetime($assetexpiry));
            }
            if ($assetwaranty == '') {
                $AssetObj->setWarranty(NULL);
            } else {
                $AssetObj->setWarranty(new \Datetime($assetwaranty));
            }

//            $AssetObj->setWarranty(new \Datetime($assetwaranty));

            $AssetObj->setPurchaseOrderNo($assetpono);
            $AssetObj->setLocation($assetlocation);
            $AssetObj->setAssetDescription($assetdescription);

            $AssetObj->setSerialNo($assetProdSerial);
            if ($assManufDate == '') {
                $AssetObj->setManufacturingDate(NULL);
            } else {
                $AssetObj->setManufacturingDate(new \Datetime($assManufDate));
            }
//            $AssetObj->setManufacturingDate(new \Datetime($assManufDate));
            $AssetObj->setPurchasePrice($assPurchasePrice);
            $AssetObj->setBarcodeNo($assBarCode);
            if ($assetPurchaseDate == '') {
                $AssetObj->setPurchaseDate(NULL);
            } else {
                $AssetObj->setPurchaseDate(new \Datetime($assetPurchaseDate));
            }
//            $AssetObj->setPurchaseDate(new \Datetime($assetPurchaseDate));

            $AssetObj->setRecordActiveFlag(1);
            if ($assetRegisterId == "") {
                $AssetObj->setRecordInsertDate(new \Datetime());
                $AssetObj->setRegistrationDate(new \Datetime());
            } else {
                $AssetObj->setRecordUpdateDate(new \Datetime());
            }

            //Auto generate  $asset_ID
            $asset_ID = '';
            $queryString = "SELECT MAX(ass.assetId) assetID
                               FROM TashiCommonBundle:AssetMaster ass ";
            $query = $this->em->createQuery($queryString);
            $result = $query->getSingleResult();
            if ($result) {
                $asset_ID = $result['assetID'] + 1;
            } else {
                $asset_ID = 1; // first generated no.
            }

            $AssetObj->setAssetId($asset_ID);
            if ($assetRegisterId == '') {
                $this->em->persist($AssetObj);
            }
            $this->em->flush();
            $assetMasterPk = $AssetObj->getAssetRegisterPk();

            // to insert in AssetStatusTxn table
            if ($assetRegisterId == "") {
                $AssetstatusObj = new AssetStatusTxn();
                $AssetstatusObj->setAsset($AssetObj);
                $assetRemark1 = "Asset Record Created.";
                if ($assetRegisterId == "") {
                    $AssetstatusObj->setStatus($this->em->getRepository('TashiCommonBundle:AssetStatusMaster')->find(2));
                    $AssetstatusObj->setRemarks($assetRemark1);
                } else {
                    $AssetstatusObj->setStatus($this->em->getRepository('TashiCommonBundle:AssetStatusMaster')->find($assetStatus));
                }
                $AssetstatusObj->setRecordActiveFlag(1);
                $AssetstatusObj->setRecordInsertDate(new \Datetime());
                $AssetstatusObj->setStatusDate(new \Datetime());
                $AssetstatusObj->setApplicationUserId($this->session->get('EMPID'));
                $AssetstatusObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($AssetstatusObj);
                $this->em->flush();
            }
            //-------- --------------------------//
            $this->em->commit();
            if ($assetRegisterId == "") {
                $msg = 'Record Save Sucessfully';
            } else {
                $msg = 'Record Updated Sucessfully';
            }
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('AssetMaster'),
            'assetRegisterId' => $AssetObj->getAssetRegisterPk()
            , 'statusPk' => $AssetObj->getStatus()->getPkid()
        );
    }

    public function retreiveAssetRegisterMaster($ARid) {

        try {
            $AssetObj = $this->em->getRepository('TashiCommonBundle:AssetMaster')->find($ARid);

//            $assetStatusId = $AssetObj->getStatus()->getPkid();
            $expiry_date = $AssetObj->getExpiryDate();
            if ($expiry_date) {
                $expiry_date = date_format($expiry_date, 'Y-m-d');
            }
            $waranty_date = $AssetObj->getWarranty();
            if ($waranty_date) {
                $waranty_date = date_format($waranty_date, 'Y-m-d');
            }
            $manufacture_date = $AssetObj->getManufacturingDate();
            if ($manufacture_date) {
                $manufacture_date = date_format($manufacture_date, 'Y-m-d');
            }
            $purchase_date = $AssetObj->getPurchaseDate();
            if ($purchase_date) {
                $purchase_date = date_format($purchase_date, 'Y-m-d');
            }

            if ($AssetObj->getAssetPhotofk()) {
                $asset_pic = $AssetObj->getAssetPhotofk()->getPath();
            } else {
                $asset_pic = 'bundles/common/images/unk.jpg';
            }
            //echo $asset_pic; die();
            $return = array('ARid' => $ARid,
                'assetName' => $AssetObj->getAssetName(),
                'categoryId' => $AssetObj->getAssetCategoryMasterFk()->getAssetMasterPk(),
                'assetmaker' => $AssetObj->getManufacturer(),
                'assetmodelno' => $AssetObj->getModelNo(),
                'assetexpiry' => $expiry_date,
                'assetwaranty' => $waranty_date,
                'assetpono' => $AssetObj->getPurchaseOrderNo(),
                'assetlocation' => $AssetObj->getLocation(),
                'assetdescription' => $AssetObj->getAssetDescription(),
                'assProductSerial' => $AssetObj->getSerialNo(),
                'assManufDate' => $manufacture_date,
                'assBarCode' => $AssetObj->getBarcodeNo(),
                'assPurchasePrice' => $AssetObj->getPurchasePrice(),
                'assetPurchaseDate' => $purchase_date,
                'assetPicture' => $asset_pic,
//                'assetPurchaseDate' => date_format($AssetObj->getPurchaseDate(), 'Y-m-d'),
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }

}
