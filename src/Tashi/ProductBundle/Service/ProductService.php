<?php

namespace Tashi\ProductBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\PrdProductCategoryMaster;
use Tashi\CommonBundle\Entity\ProjectAreaProdCategoryTxn;
use Tashi\CommonBundle\Entity\ProductUnitTxn;
use Tashi\CommonBundle\Entity\PrdProductPriceTxn;
use Tashi\CommonBundle\Entity\PrdProductMaster;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\PrdServiceTxn;
use Tashi\CommonBundle\Entity\SupplierProductTxn;
use Tashi\SupplierBundle\Helper\SupplierConstant;
class ProductService 
{
    protected $em;
    protected $session;
    protected $commonService;
    protected $webRoot;
    public function __construct(EntityManager $em,Session $session,$rootDir,$cmnService) 
    {
        $this->em = $em;
        $this->session = $session;  
        $this->webRoot = str_replace('app', '', $rootDir);
        $this->commonService=$cmnService;
    }   
    public function AddProductCategory($request){
        $dataUI=  json_decode($request->getContent());
        $catName=$dataUI->txtCategory;
        $desc=$dataUI->txtDescription;
        $areas=$dataUI->inputarea;
        //$services=$dataUI->txtServicename;
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $checkCat=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('categoryName'=>$catName,'recordActiveFlag'=>1));
            if($checkCat){
                return array('code'=>0,'msg'=>'Category Name already exist.');
            }             
            //INSERT PRODUCT CATEGORY
            $category=new PrdProductCategoryMaster();
            $category->setCategoryName($catName);
            $category->setCategoryDesc($desc);
            $category->setStatusFlag(1);
            $category->setRecordActiveFlag(1);
            $category->setRecordInsertDate(new \DateTime("NOW"));
            $category->setApplicationUserId($this->session->get('EMPID'));
            $category->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($category);
            $this->em->flush();
            //INSERT INTO CAT AREA TXN
            if(is_array($areas)){
                foreach($areas as $area){
                    if($area!=''){
                        $areaObj=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($area);
                        $catareatxn=new ProjectAreaProdCategoryTxn();
                        $catareatxn->setProjectAreaFk($areaObj);
                        $catareatxn->setProdCategoryFk($category);
                        $catareatxn->setRecordActiveFlag(1);
                        $catareatxn->setRecordInsertDate(new \DateTime("NOW"));
                        $catareatxn->setApplicationUserId($this->session->get('EMPID'));
                        $catareatxn->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($catareatxn);
                        $this->em->flush();
                    }                        
                }
            }else{
                if($areas!=''){
                    $areaObj=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($areas);
                    $catareatxn=new ProjectAreaProdCategoryTxn();
                    $catareatxn->setProjectAreaFk($areaObj);
                    $catareatxn->setProdCategoryFk($category);
                    $catareatxn->setRecordActiveFlag(1);
                    $catareatxn->setRecordInsertDate(new \DateTime("NOW"));
                    $catareatxn->setApplicationUserId($this->session->get('EMPID'));
                    $catareatxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($catareatxn);
                    $this->em->flush();
                }
            }
            //INSERT INTO PRD_CAT_SERVICES
//            if(is_array($services)){
//                foreach($services as $sname){
//                    if($sname!=''){
//                        $serviceObj=new PrdCatServices();
//                        $serviceObj->setCatFk($category);
//                        $serviceObj->setServiceName($sname);
//                        $serviceObj->setRecordActiveFlag(1);
//                        $serviceObj->setRecordInsertDate(new \DateTime("NOW"));
//                        $this->em->persist($serviceObj);
//                        $this->em->flush($serviceObj);
//                    }
//                }
//            }
//            else{
//                if($services!=''){
//                    $serviceObj=new PrdCatServices();
//                    $serviceObj->setCatFk($category);
//                    $serviceObj->setServiceName($services);
//                    $serviceObj->setRecordActiveFlag(1);
//                    $serviceObj->setRecordInsertDate(new \DateTime("NOW"));
//                    $this->em->persist($serviceObj);
//                    $this->em->flush($serviceObj);
//                }
//            }  
                
            $conn->commit();
            $returncode=1;
            $returnmsg='Product Category has been created successfully';
        }catch (\Exception $ex) {
            $conn->rollBack();            
            $returncode=0;
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);        
    }
    public function UpdateProductCategory($request){
        $dataUI=  json_decode($request->getContent());
        $catName=$dataUI->txtCategory;
        $desc=$dataUI->txtDescription;
        $catid=$dataUI->inputcatid;
        $areas=$dataUI->inputarea;

        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $checkCat=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('categoryName'=>$catName,'recordActiveFlag'=>1));
            if($checkCat){
                foreach($checkCat as $cat){
                    if($cat->getPkid()!=$catid){
                        return array('code'=>0,'msg'=>'Category Name already exist.');
                    }
                }                
            }             
            //UPDATE PRODUCT CATEGORY
            $category=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($catid);
            $category->setCategoryName($catName);
            $category->setCategoryDesc($desc);
            $category->setRecordUpdateDate(new \DateTime("NOW"));
            $category->setApplicationUserId($this->session->get('EMPID'));
            $category->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            //CAT AREA TXN
            $existingCatTxn=$this->em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('prodCategoryFk'=>$category,'recordActiveFlag'=>1));
            foreach($existingCatTxn as $cattxn){
                $cattxn->setRecordActiveFlag(0);
                $cattxn->setRecordUpdateDate(new \DateTime("NOW"));
                $cattxn->setApplicationUserId($this->session->get('EMPID'));
                $cattxn->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush($cattxn);
            }
            if(is_array($areas)){
                foreach($areas as $area){
                    if($area!=''){
                        $areaObj=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($area);
                        $cattxnArr=$this->em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('projectAreaFk'=>$area,'prodCategoryFk'=>$category));
                        if($cattxnArr){
                            $catareatxn=$cattxnArr[0];
                            $catareatxn->setRecordUpdateDate(new \DateTime("NOW"));
                            $catareatxn->setApplicationUserId($this->session->get('EMPID'));
                            $catareatxn->setApplicationUserIpAddress($this->session->get('IP'));
                            $catareatxn->setRecordActiveFlag(1);
                        }else{
                            $catareatxn=new ProjectAreaProdCategoryTxn();
                            $catareatxn->setProjectAreaFk($areaObj);
                            $catareatxn->setProdCategoryFk($category);
                            $catareatxn->setRecordInsertDate(new \DateTime("NOW"));
                            $catareatxn->setApplicationUserId($this->session->get('EMPID'));
                            $catareatxn->setApplicationUserIpAddress($this->session->get('IP'));
                            $catareatxn->setRecordActiveFlag(1);
                            $this->em->persist($catareatxn);
                        }
                        $this->em->flush($catareatxn);
                    }                        
                }                
            }else{
                if($areas!=''){
                    $areaObj=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($areas);
                    $cattxnArr=$this->em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('projectAreaFk'=>$areas,'prodCategoryFk'=>$category));
                    if($cattxnArr){
                            $catareatxn=$catareatxn[0];
                            $catareatxn->setRecordUpdateDate(new \DateTime("NOW"));
                            $catareatxn->setApplicationUserId($this->session->get('EMPID'));
                            $catareatxn->setApplicationUserIpAddress($this->session->get('IP'));
                            $catareatxn->setRecordActiveFlag(1);
                    }else{
                        $catareatxn=new ProjectAreaProdCategoryTxn();
                        $catareatxn->setProjectAreaFk($areaObj);
                        $catareatxn->setProdCategoryFk($category);
                        $catareatxn->setRecordInsertDate(new \DateTime("NOW"));
                        $catareatxn->setApplicationUserId($this->session->get('EMPID'));
                        $catareatxn->setApplicationUserIpAddress($this->session->get('IP'));
                        $catareatxn->setRecordActiveFlag(1);
                        $this->em->persist($catareatxn);
                    }
                    $this->em->flush($catareatxn);
                    }
            }
            //CAT SERVICES
//            $existingServices=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('catFk'=>$category,'recordActiveFlag'=>1));
//            foreach($existingServices as $service){
//                $service->setRecordActiveFlag(0);
//                $service->setRecordUpdateDate(new \DateTime("NOW"));
//                $this->em->flush($service);
//            }
//            if(is_array($serviceIds)){
//                for($i=0;$i<count($serviceIds);$i++){
//                    $serviceid=$serviceIds[$i];
//                    $servicename=$services[$i];
//                    if($servicename!=''){
//                        if($serviceid!=''){ //if existing then update
//                            $serviceObj=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->find($serviceid); 
//                            $serviceObj->setServiceName($servicename);
//                            $serviceObj->setRecordUpdateDate(new \DateTime("NOW"));
//                            $serviceObj->setRecordActiveFlag(1);
//                        }else{
//                            $serviceObj=new PrdCatServices();
//                            $serviceObj->setCatFk($category);
//                            $serviceObj->setServiceName($servicename);
//                            $serviceObj->setRecordActiveFlag(1);                            
//                            $serviceObj->setRecordInsertDate(new \DateTime("NOW"));                            
//                            $this->em->persist($serviceObj);
//                        }  
//                         $this->em->flush($serviceObj);
//                    }
//                }                
//            }else{
//                if($services!=''){
//                    if($serviceIds!=''){ //if existing then update
//                        $serviceObj=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->find($serviceIds); 
//                        $serviceObj->setServiceName($services);
//                        $serviceObj->setRecordUpdateDate(new \DateTime("NOW"));
//                        $serviceObj->setRecordActiveFlag(1);
//                    }else{
//                        $serviceObj=new PrdCatServices();
//                        $serviceObj->setCatFk($category);
//                        $serviceObj->setServiceName($services);
//                        $serviceObj->setRecordActiveFlag(1);                            
//                        $serviceObj->setRecordInsertDate(new \DateTime("NOW"));                            
//                        $this->em->persist($serviceObj);
//                    }  
//                     $this->em->flush($serviceObj);
//                }
//            }
            $conn->commit();
            $returncode=1;
            $returnmsg='Category detail updated successfully.';
        }catch (\Exception $ex) {
            $conn->rollBack();            
            $returncode=0;
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }
    
    public function DeleteProductCategory($catid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $category=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($catid);
            //Delete category
            $category->setRecordActiveFlag(0);
            $category->setRecordUpdateDate(new \DateTime("now"));
            $category->setApplicationUserId($this->session->get('EMPID'));
            $category->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($category);
            //Delete Related Products
            $productArr=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(array('productCategory'=>$category,'recordActiveFlag'=>1));
            if($productArr){
                foreach($productArr as $product){
                    $product->setRecordActiveFlag(0);
                    $product->setRecordUpdateDate(new \DateTime("now"));
                    $product->setApplicationUserId($this->session->get('EMPID'));
                    $product->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($product);
                }
            }
            //Delete Related Service
//            $serviceArr=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('catFk'=>$category,'recordActiveFlag'=>1));
//            if($serviceArr){
//                foreach($serviceArr as $service){
//                    $service->setRecordActiveFlag(0);
//                    $service->setRecordUpdateDate(new \DateTime("now"));
//                    $this->em->flush($service);
//                }
//            }
            //Delete Area Txn
            $areatxn=$this->em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('prodCategoryFk'=>$category,'recordActiveFlag'=>1));
            if($areatxn){
                foreach($areatxn as $area){
                    $area->setRecordActiveFlag(0);
                    $area->setRecordUpdateDate(new \DateTime("now"));
                    $area->setApplicationUserId($this->session->get('EMPID'));
                    $area->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($area);
                }
            }
            $conn->commit();
            $returncode=1;
            $returnmsg='Product Category has been delete.';
        }catch (\Exception $ex) {
            $conn->rollBack();            
            $returncode=0;
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function InsertNewProduct($request)
    {    
        //$dataUI = json_decode($request->getContent());
        $dataUI=$request->request;
        $pname=$dataUI->get('prodName');
        $pcode=$dataUI->get('prodCode');
        $sku=$dataUI->get('txtSKU');
        $cPrice=$dataUI->get('txtPurchasePrice');
        $sellPrice=$dataUI->get('txtSellingprice');
        $prodcat=$dataUI->get('selCategory');
        $manufacturer=$dataUI->get('txtManufacturer');
        $prodDesc=$dataUI->get('prodDescIns');
        $prodBarCode=$dataUI->get('prodBarCodeIns');        
        $unit=$dataUI->get('txtUnit');
        $serviceNames=$dataUI->get('txtServicename');
        $serviceCharges=$dataUI->get('txtServiceCharge');
        $supplierArr=$dataUI->get('chkSupplier');
        $fileupload=$request->files->get('fileProdImg');        
        $uploadedFiles=array();
        $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
        $conn=$this->em->getConnection();
        $prodcategory=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($prodcat);
        try
        {
            $conn->beginTransaction();
            $AllProd=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findByRecordActiveFlag(1);
            foreach($AllProd as $prod)
            {
                if($prod->getProductCode()==$pcode){
                   $returncode=0;
                   $returnmsg= 'Product code '.$pcode.' already Exist';
                   return array('code'=>$returncode,'msg'=>$returnmsg);
                }
            }   
            $checkSku=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findOneBy(array('sku'=>$sku,'recordActiveFlag'=>1));
            if($checkSku){
                return array('code'=>0,'msg'=>'SKU has already been assigned to another Product.');
            }
            if(isset($fileupload)){                
                $path='upload/PRODUCTS/'.strtoupper($prodcategory->getCategoryName()).'/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0.5,$validFileTypes);
                if($fuploadresult['code']==1){
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //array('code'=>1,'msg'=>'','fullpath'=>$pathwithfilename,'newname'=>$newfname,'oriname'=>$foriname,
             //'ext'=>$fext);
                    //save image in document master
                    $document=new CmnDocumentMaster();
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    $document->setRecordActiveFlag(1);
                    $document->setRecordInsertDate(new \DateTime("NOW"));
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($document);
                    $this->em->flush();
                    }else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                }
            }
            //INSERT PRODUCT MASTER
            $proMaster = new PrdProductMaster();
            $proMaster->setProductCode($pcode);
            $proMaster->setProductName($pname);
            if(isset($document)){
                $proMaster->setPictureFk($document);
            }
            $proMaster->setProductBarcode($prodBarCode);
            $proMaster->setSKU($sku);
            $proMaster->setManufacturer($manufacturer);
            $proMaster->setProductCategory($prodcategory);
            $proMaster->setProductDesc($prodDesc);              
            $proMaster->setStatusFlag(1);
            $proMaster->setRecordActiveFlag(1);
            $proMaster->setRecordInsertDate(new \Datetime());
            $proMaster->setApplicationUserId($this->session->get('EMPID'));
            $proMaster->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($proMaster);
            $this->em->flush($proMaster);            
            
            //INSERT PRODUCT PRICE
            $prodPrice = new PrdProductPriceTxn();       
            $prodPrice->setCostPrice($cPrice);
            $prodPrice->setMarkupPrice($sellPrice);
            $prodPrice->setProduct($proMaster);
            $prodPrice->setStatusFlag(1);
            $prodPrice->setRecordActiveFlag(1);
            $prodPrice->setRecordInsertDate(new \Datetime());
            $prodPrice->setApplicationUserId($this->session->get('EMPID'));
            $prodPrice->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($prodPrice);
            $this->em->flush();
            //INSERT PRODUCT UNIT              
            foreach($unit as $punit){
                if($punit!=''){
                    $produnit=new ProductUnitTxn();
                    $produnit->setProductFk($proMaster);
                    $produnit->setUnitName($punit);
                    $produnit->setRecordActiveFlag(1);
                    $produnit->setRecordInsertDate(new \DateTime());
                    $produnit->setApplicationUserId($this->session->get('EMPID'));
                    $produnit->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($produnit);
                    $this->em->flush();                         
                }     
            }
            //INSERT PRODUCT SERVICE
            for($i=0;$i<count($serviceNames);$i++){
                $service=$serviceNames[$i];
                $charge=$serviceCharges[$i];
                if($charge==''){
                    $charge=0;
                }
                if($service!=''){
                    $prdservice=new PrdServiceTxn();
                    $prdservice->setProductFk($proMaster);
                    $prdservice->setServiceName($service);
                    $prdservice->setCharge($charge);
                    $prdservice->setRecordActiveFlag(1);
                    $prdservice->setRecordInsertDate(new \DateTime("NOW"));
                    $prdservice->setApplicationUserId($this->session->get('EMPID'));
                    $prdservice->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($prdservice);
                    $this->em->flush($prdservice);
                }
            }
            //INSERT INTO PRODUCT SUPPLIER TXN
            foreach($supplierArr as $supplierid){
                $supplier=  $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supplierid);
                $supProdTxn=new SupplierProductTxn();
                $supProdTxn->setSupplierFk($supplier);
                $supProdTxn->setProductFk($proMaster);
                $supProdTxn->setRecordActiveFlag(1);
                $supProdTxn->setRecordInsertDate(new \DateTime("NOW"));
                $supProdTxn->setApplicationUserId($this->session->get('EMPID'));
                $this->em->persist($supProdTxn);
                $this->em->flush($supProdTxn);
            }
            $conn->commit();
            $returncode=1;
            $returnmsg='Product has been added successfully';
        } catch (\Exception $ex) {
            $conn->rollBack();
            foreach($uploadedFiles as $file){
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $returncode=0;
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
    function UpdateProduct($request,$prdId){
       // $dataUI = json_decode($request->getContent());
        $dataUI=$request->request;
        $catid=$dataUI->get('selCategory');
        $pname=$dataUI->get('prodName');
        $pcode=$dataUI->get('prodCode');
        $sku=$dataUI->get('txtSKU');
        $cPrice=$dataUI->get('txtPurchasePrice');
        $sellPrice=$dataUI->get('txtSellingprice');
        $prodDesc=$dataUI->get('prodDescIns');
        $prodBarCode=$dataUI->get('prodBarCodeIns');        
        $unitNames=$dataUI->get('txtUnit');
        $unitIds=$dataUI->get('txtUnitId');
        $serviceNames=$dataUI->get('txtServicename');
        $serviceCharges=$dataUI->get('txtServiceCharge');
        $serviceIds=$dataUI->get('txtServiceId');
        $supplierArr=$dataUI->get('chkSupplier');
        $fileupload=$request->files->get('fileProdImg');
        $uploadedFiles=array();
        $validFileTypes=array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
        $newfilepathname='';
        $conn=$this->em->getConnection();
        try
        {
            $conn->beginTransaction();
            $proMaster = $this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prdId);
            $category=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($catid);
            $AllProd=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findByRecordActiveFlag(1);
            $document=$proMaster->getPictureFk();
            $prevfilepath='';
            if($document){
                $prevfilepath=$document->getPath();
            }
            foreach($AllProd as $prod)
            {
                if($prod->getProductCode()==$pcode && $prod->getPkid()!=$prdId){
                   $returncode=0;
                   $returnmsg= 'Product code '.$pcode.' already Exist';
                   return array('code'=>$returncode,'msg'=>$returnmsg);
                }
            }
            $checkSku=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findOneBy(array('sku'=>$sku,'recordActiveFlag'=>1));
            if($checkSku && $checkSku->getPkid()!=$prdId){
                return array('code'=>0,'msg'=>'SKU has already been assigned to another Product.');
            }
            $isDocNew=false;
            if(isset($fileupload)){                
                $path='upload/PRODUCTS/'.strtoupper($category->getCategoryName()).'/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0.5,$validFileTypes);
                if($fuploadresult['code']==1){
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //save image in document master
                    if(!$document){
                        $document=new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew=true;
                    }else{
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }                   
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if($isDocNew){
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if(file_exists($prevfilepath)){
                        unlink($prevfilepath);
                    }
                }
                else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                }
            }
            // PRODUCT MASTER              
            if($isDocNew){
                if(isset($document)){
                    $proMaster->setPictureFk($document);
                }
            }
            $proMaster->setProductCode($pcode);
            $proMaster->setSKU($sku);
            $proMaster->setProductName($pname);
            $proMaster->setProductCategory($category);
            $proMaster->setProductBarcode($prodBarCode);                
            $proMaster->setProductDesc($prodDesc);              
            $proMaster->setStatusFlag(1);
            $proMaster->setRecordUpdateDate(new \Datetime());
            $proMaster->setApplicationUserId($this->session->get('EMPID'));
            $proMaster->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();   
            // PRODUCT PRICE
            $prodPriceArr=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findBy(array('product'=>$prdId,'recordActiveFlag'=>1));
            foreach($prodPriceArr as $price){
                $price->setRecordActiveFlag(0);
                $this->em->flush();
            }
            $prodPrice = new PrdProductPriceTxn();       
            $prodPrice->setCostPrice($cPrice);
            $prodPrice->setMarkupPrice($sellPrice);
            $prodPrice->setProduct($proMaster);
            $prodPrice->setStatusFlag(1);
            $prodPrice->setRecordActiveFlag(1);
            $prodPrice->setRecordInsertDate(new \Datetime());
            $prodPrice->setApplicationUserId($this->session->get('EMPID'));
            $prodPrice->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($prodPrice);
            $this->em->flush();
            // PRODUCT UNIT    
                //GET ALL EXISTING UNITs to compare
                $unitArr=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('productFk'=>$prdId));                
                foreach($unitArr as $unit){
                    $unit->setRecordActiveFlag(0);
                    $unit->setRecordUpdateDate(new \DateTime("NOW"));
                    $unit->setApplicationUserId($this->session->get('EMPID'));
                    $unit->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($unit);
                }
                for($i=0;$i<count($unitIds);$i++){
                    $unitid=$unitIds[$i];
                    $unitname=$unitNames[$i];
                    if(!empty($unitname)){
                        if(!empty($unitid)){ //if id found then it is an existing record.Therefore update
                            $unitObj=  $this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->find($unitid);
                            $unitObj->setUnitName($unitname);
                            $unitObj->setRecordActiveFlag(1);
                            $unitObj->setRecordUpdateDate(new \DateTime("NOW")); 
                            $unitObj->setApplicationUserId($this->session->get('EMPID'));
                            $unitObj->setApplicationUserIpAddress($this->session->get('IP'));
                        }else{ //no Id found.Record is new therefore insert
                            $unitObj=new ProductUnitTxn();
                            $unitObj->setProductFk($proMaster);
                            $unitObj->setUnitName($unitname);
                            $unitObj->setRecordActiveFlag(1);
                            $unitObj->setRecordInsertDate(new \DateTime("NOW"));
                            $unitObj->setApplicationUserId($this->session->get('EMPID'));
                            $unitObj->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($unitObj);
                        }
                        $this->em->flush($unitObj);
                    }
                }
                
            //UPDATE PRODUCT SERVICE
            $existingServices=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('productFk'=>$proMaster,'recordActiveFlag'=>1),array('serviceName'=>'ASC'));
            //RESET ALL SERVICE FIRST
            if($existingServices){
                foreach($existingServices as $service){
                    $service->setRecordActiveFlag(0);
                    $service->setRecordUpdateDate(new \DateTime("NOW"));
                    $service->setApplicationUserId($this->session->get('EMPID'));
                    $service->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($service);
                }
            }
            for($i=0;$i<count($serviceNames);$i++){
                $id=$serviceIds[$i];
                $service=$serviceNames[$i];
                $charge=$serviceCharges[$i];
                if($charge==''){
                    $charge=0;
                }
                if(!empty($service)){
                    if(!empty($id)){ //if existing service update
                        $prdservice=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->find($id);
                        $prdservice->setServiceName($service);
                        $prdservice->setCharge($charge);
                        $prdservice->setRecordActiveFlag(1);
                        $prdservice->setRecordUpdateDate(new \DateTime("NOW"));
                        $prdservice->setApplicationUserId($this->session->get('EMPID'));
                        $prdservice->setApplicationUserIpAddress($this->session->get('IP'));
                    }else{ //if new service insert
                        $prdservice=new PrdServiceTxn();
                        $prdservice->setProductFk($proMaster);
                        $prdservice->setServiceName($service);
                        $prdservice->setCharge($charge);
                        $prdservice->setRecordInsertDate(new \DateTime("NOW")); 
                        $prdservice->setApplicationUserId($this->session->get('EMPID'));
                        $prdservice->setApplicationUserIpAddress($this->session->get('IP'));
                        $prdservice->setRecordActiveFlag(1);
                        $this->em->persist($prdservice);
                    }          
                    $this->em->flush($prdservice);
                }
            }
            //UPDATE SUPPLIER PRODUCT LIST
            $exSupplierArr=$this->em->getRepository(CommonConstant::ENT_SUPPLIER_PRODUCT_TXN)->findBy(array('productFk'=>$prdId,'recordActiveFlag'=>1));
            foreach($exSupplierArr as $exsup){                
                $exsup->setRecordActiveFlag(0);
                $exsup->setRecordUpdateDate(new \DateTime("NOW"));
                $exsup->setApplicationUserId($this->session->get('EMPID'));
                $this->em->flush($exsup);
            }
            if(isset($supplierArr)){
                foreach($supplierArr as $supid){
                    $exsupProdTxn=$this->em->getRepository(CommonConstant::ENT_SUPPLIER_PRODUCT_TXN)->findOneBy(array('supplierFk'=>$supid,'productFk'=>$prdId));
                    if($exsupProdTxn){
                        $exsupProdTxn->setRecordActiveFlag(1);
                        $exsupProdTxn->setRecordUpdateDate(new \DateTime("NOW"));
                        $exsupProdTxn->setApplicationUserId($this->session->get('EMPID'));
                        $this->em->flush($exsupProdTxn);                    
                    }else{
                        $supplier=  $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid);
                        $supProdTxn=new SupplierProductTxn();
                        $supProdTxn->setSupplierFk($supplier);
                        $supProdTxn->setProductFk($proMaster);
                        $supProdTxn->setRecordActiveFlag(1);
                        $supProdTxn->setRecordInsertDate(new \DateTime("NOW"));
                        $supProdTxn->setApplicationUserId($this->session->get('EMPID'));
                        $this->em->persist($supProdTxn);
                        $this->em->flush($supProdTxn);
                    }

                }
            }
            $conn->commit();
            $returncode=1;
            $returnmsg='Product detail has been updated successfully.';
        } catch (\Exception $ex) {
            $conn->rollBack();
            if (file_exists($newfilepathname)) {
                unlink($newfilepathname);
            }
            $returncode=0;
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function DeleteProduct($prodid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $product=$this->em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prodid);
            $prdPriceTxn=$this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findByProduct($product);
            $unitArr=$this->em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findByProductFk($product);
            $serviceArr=$this->em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('productFk'=>$product,'recordActiveFlag'=>1));
            if($prdPriceTxn){
                //if(is_array($prdPriceTxn)){
                    foreach($prdPriceTxn as $price){
                        $price->setRecordActiveFlag(0);
                        $price->setRecordUpdateDate(new \DateTime("NOW"));
                        $price->setApplicationUserId($this->session->get('EMPID'));
                        $price->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush();
                    }
//                }
//                else{
//                    $prdPriceTxn->setRecordActiveFlag(0);
//                    $prdPriceTxn->setRecordUpdateDate(new \DateTime("NOW"));
//                    $this->em->flush();
//                }
            }
            if($unitArr){
                foreach($unitArr as $unit){
                    $unit->setRecordActiveFlag(0);
                    $unit->setRecordUpdateDate(new \DateTime("NOW"));
                    $unit->setApplicationUserId($this->session->get('EMPID'));
                    $unit->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush();
                }
            }            
            $product->setRecordActiveFlag(0);
            $product->setRecordUpdateDate(new \DateTime("NOW"));
            $product->setApplicationUserId($this->session->get('EMPID'));
            $product->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //DELETE RELATED SERVICES
            if($serviceArr){
                foreach ($serviceArr as $service){
                    $service->setRecordActiveFlag(0);
                    $service->setRecordUpdateDate(new \DateTime("NOW"));
                    $service->setApplicationUserId($this->session->get('EMPID'));
                    $service->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($service);
                }
            }
            $conn->commit();
            $returncode=1;
            $returnmsg='Product has been deleted successfully.';
        } 
        catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg= $this->commonService->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    } 
}

