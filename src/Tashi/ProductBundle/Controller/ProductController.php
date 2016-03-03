<?php
namespace Tashi\ProductBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\ProductBundle\Helper\ProductConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\SupplierBundle\Helper\SupplierConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * 
 * @Route("/Product")
 * 
 */
class ProductController extends Controller{
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    /**
     * Goto Product Dashboard
     * @Route ("/productdashboard", name="_productdashboard")
     */
    public function ProductDashboard(){
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProductDashboard');
	if($accessRight==1){
            
            try{                   
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_DASHBOARD));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * Action: Navigate to product master setting->add category
     * @Route(path="/productcategory", name="_productcategory")
     */
    public function ProductCategoryAction() {
            $em=$this->getDoctrine()->getManager();
            $projectAreaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
            $categoryArr= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));           
            $areacattxn=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('recordActiveFlag'=>1));
            //$serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('recordActiveFlag'=>1),array('serviceName'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_ADD_CATEGORY,
                    array('AreaArr'=>$projectAreaArr,'category'=>$categoryArr,'areacattxn'=>$areacattxn)));
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }    
    /**
     * Action: Add/Edit Product Category
     * @Route("/addproductcategory", name="_addproductcategory")
     */
    public function AddProductCategoryAction(Request $request){
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProductMasterSetting');
	if($accessRight==1){
            $result=$this->get(ProductConstant::SERVICE_PRODUCT)->AddProductCategory($request);
            if($result['code']==1){
                $em = $this->getDoctrine()->getManager();
                $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));                 
                $areacattxn=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('recordActiveFlag'=>1));
               // $serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('recordActiveFlag'=>1),array('serviceName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_CATEGORY_LIST,
                        array('categoryArr'=>$category,'areacattxn'=>$areacattxn)));
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);                 
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * Action: Navigate to Edit Product Category
     * @Route(path="/editproductcat/{catid}", name="_editproductcat")
     */
    public function GotoEditProductCategoryAction($catid) {
            $em=$this->getDoctrine()->getManager();
            $category=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($catid);
            $projectAreaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));               
            $areacattxn=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('prodCategoryFk'=>$catid,'recordActiveFlag'=>1));
            //$serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('catFk'=>$category,'recordActiveFlag'=>1),array('serviceName'=>'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_EDIT_CATEGORY,
                    array('AreaArr'=>$projectAreaArr,'category'=>$category,'areacattxn'=>$areacattxn)));
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }  
     /**
     * Action: Navigate to Edit Product Category
     * @Route(path="/cancelupdatecat", name="_cancelupdatecat")
     */
    public function CancelCategoryUpdate() {
        $em=$this->getDoctrine()->getManager();
        $projectAreaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
        $categoryArr= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                     (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));   
        $areacattxn=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('recordActiveFlag'=>1));
        //$serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('recordActiveFlag'=>1),array('serviceName'=>'ASC'));
        $this->erpMessage->setSuccess(true);
        $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_ADD_CATEGORY,
                array('AreaArr'=>$projectAreaArr,'category'=>$categoryArr,'areacattxn'=>$areacattxn)));
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * Action: Edit Product Category
     * @Route("/updateprodcategory", name="_updateprodcat")
     */
    public function UpdateProductCategoryAction(Request $request)
    {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProductMasterSetting');
	if($accessRight==1){
            $result=$this->get(ProductConstant::SERVICE_PRODUCT)->UpdateProductCategory($request);
            if($result['code']==1){
                $em = $this->getDoctrine()->getManager();
                $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));                 
                $areacattxn=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('recordActiveFlag'=>1));
                //$serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('recordActiveFlag'=>1),array('serviceName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_CATEGORY_LIST,
                        array('categoryArr'=>$category,'areacattxn'=>$areacattxn)));
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);               
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Edit Product Category
     * @Route("/deletecategory/{catid}", name="_deletecategory")
     */
    public function DeleteProdCategoryAction($catid)
    { 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProductMasterSetting');
	if($accessRight==1){
            $result=$this->get(ProductConstant::SERVICE_PRODUCT)->DeleteProductCategory($catid);
            if($result['code']==1){
                $em = $this->getDoctrine()->getManager();
                $projectAreaArr=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
                $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));                 
                $areacattxn=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findBy(array('recordActiveFlag'=>1));
                //$serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('recordActiveFlag'=>1),array('serviceName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_ADD_CATEGORY,
                        array('AreaArr'=>$projectAreaArr,'category'=>$category,'areacattxn'=>$areacattxn)));                
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 

    }
    /**
     * Action: Navigate to Product Home Page(Prd_Home.html)
     * @Route("/addproduct", name="_gotoaddproduct")
     */
    public function GoToAddNewProductAction()
    {
            try{
                $em = $this->getDoctrine()->getManager();
                $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));        
                $supplierArr=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->findBy
                         (array('recordActiveFlag'=>1),array('companyName'=>'ASC'));        
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_CREATE_NEW_PROD,
                        array('category'=>$category,'supplierArr'=>$supplierArr,'from'=>'null')));
            }
            catch(\Exception $ex){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }            
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);      
    }
    /**
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/prd_appendsubcat/{iscategory}/{mode}/{pkid}", name="_prd_appendsubcat")
     */
    public function PrdAppendSubCatAction($iscategory,$pkid,$mode)
    {
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            try{
                $em = $this->getDoctrine()->getManager();  
                $CatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($pkid);//Single parent category
                $MasterCatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('statusFlag' => 1, 'recordActiveFlag' => 1));//child category List
                $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('recordActiveFlag'=>1),array('unitName'=>'ASC'));
                $serviceArr=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->GetServicesByProductCategory($CatObj->getPkid());
                if($mode=='approve'){
                    $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(
                        array('statusFlag'=>2,'recordActiveFlag' => 1, 'productCategory'=>$pkid));
                }else{
                    $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(
                        array('recordActiveFlag' => 1, 'productCategory'=>$pkid));
                }
                $result = array();
                foreach ($CatProduct as $prod) 
                {
                    $prodpkid=$prod->getPkid();
                    $result[] = $em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->
                    findBy(array('statusFlag' => 1, 'recordActiveFlag' => 1, 'product'=>$prodpkid));
                }
                if($MasterCatObj){
                    if($mode=='insert')
                    {
                        $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_ITEM_APPEND,
                        array('catMaster'=>$MasterCatObj,'obj'=>$CatObj,'mode'=>$mode)));
                        $this->erpMessage->setSuccess(true);
                        $this->erpMessage->setMessage("success");
                        //if(!$iscategory){
                            $this->erpMessage->setSecondHtml($this->renderView(ProductConstant::TWIG_PRD_PRODLIST_APPEND,
                                                    array('obj'=>$result,'objcat'=>$CatObj,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>'new')));
                        //}
                    }
                    elseif($mode=='approve'){
                        $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_ITEM_APPEND,
                                                        array('catMaster'=>$MasterCatObj,'obj'=>$CatObj,'mode'=>$mode,'actionmode'=>$mode)));
                        $this->erpMessage->setSuccess(true);
                        $this->erpMessage->setMessage("success");
                        //if(!$iscategory){
                            $this->erpMessage->setSecondHtml($this->renderView(ProductConstant::TWIG_PRD_PRODLIST_APPEND,
                                                    array('obj'=>$result,'objcat'=>$CatObj,'actionmode'=>$mode,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>'new')));
                       // }
                    }
                    else
                    {
                        $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_EDIT_SUBCAT_APPEND,
                                                    array('catMaster'=>$MasterCatObj,'obj'=>$CatObj,'mode'=>$mode)));
                        $this->erpMessage->setPage("Update Product to ".$CatObj->getCategoryName());
                        $this->erpMessage->setSuccess(true);
                        $this->erpMessage->setMessage("success");
                    }
                }            
                else
                {
                    $this->erpMessage->setSuccess(true);
                    $subcatName = $CatObj->getCategoryName();
                    //$this->erpMessage->setMessage();
                    $this->erpMessage->setPage("Update Product to ".$subcatName);
                    if($mode=='approve'){
                        //if(!$iscategory){
                            $this->erpMessage->setSecondHtml($this->renderView(ProductConstant::TWIG_PRD_PRODLIST_APPEND,
                            array('obj'=>$result,'objcat'=>$CatObj,'actionmode'=>$mode,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>'new')));
                        //}
                    }
                    else{
                       // if(!$iscategory){
                            $this->erpMessage->setSecondHtml($this->renderView(ProductConstant::TWIG_PRD_PRODLIST_APPEND,
                            array('obj'=>$result,'objcat'=>$CatObj,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>'new')));                 
                       // }
                    }
                }
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }   
    
    /**
     * Action: Navigate to Create New Product Page() 
     * @Route ("/createnewproduct/{catid}", name="_gotonewproduct")
     */
    public function GotoNewProductAction($catid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();      
            try {
                $em = $this->getDoctrine()->getManager();  
                $CatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($catid);
                $CatAttrObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_ATTR_TXN)->findBy
                        (array('statusFlag' => 1, 'recordActiveFlag' => 1, 'categoryMaster' =>$catid));
                $unitList=array();
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_CREATE_NEW_PROD,
                       array('catobj'=>$CatObj,'result'=>'','from'=>'null')));
                $this->erpMessage->setSuccess(true);
                        //$erpMessage->setMessage("success");
                if($CatAttrObj) 
                {
                    foreach($CatAttrObj as $catAttr)
                    {
                       $attrpkid=$catAttr->getAttributeMaster()->getPkid();   
                       $AttrUnit=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_ATTR_UNIT_TXN)->findBy
                           (array('statusFlag' => 1, 'recordActiveFlag' => 1, 'attributeMaster' => $attrpkid));
                       $unitList=array_merge($unitList,$AttrUnit);
                    }
                    $this->erpMessage->setPage('true'); 
//                    $this->erpMessage->setSecondHtml($this->renderView(ProductConstant::TWIG_PRD_SHOW_ATTR_UNIT,
//                                                array('CatAttrObj'=>$CatAttrObj,'result'=>'','unitObj'=>$unitList)));
               }
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
    
    /**
     * Action: Insert/Update New/Existing product
     * @Route("/insnewproduct/{from}", name="_insnewproduct")
     * 
     */
    public function InsertNewProductAction(Request $request,$from)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('InsertNewProductAction');
        if($accessRight==1){
                           
            try{           
                $dataUI = $request->request;
                $prodcat=$dataUI->get('CatIns'); 
                $result = $this->get(ProductConstant::SERVICE_PRODUCT)->InsertNewProduct($request);         
                if ($result['code'] == 1){
                    $this->erpMessage->setSuccess(true);  
                    $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_CONFIRMED));
                }
                else{
                    $this->erpMessage->setSuccess(false);  
                }
                $this->erpMessage->setMessage($result['msg']);  
            }
            catch (\Exception $ex) 
            {
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
     * Action: Display Product detail and allow edit.
     * @Route("/vieweditproduct/{prodID}/{from}", name="_vieweditproduct")
     * 
     */
    public function ViewEditProductAction($prodID,$from)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchProduct');
	if($accessRight==1){
            
            try{
                $em = $this->getDoctrine()->getManager();
                //$product= $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prodID);
                $result= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findOneBy
                        (array('statusFlag' => 1, 'recordActiveFlag' => 1, 'product' => $prodID)); 
                $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('productFk'=>$prodID,'recordActiveFlag'=>1),array('unitName'=>'ASC'));
                $serviceArr=$em->getRepository(CommonConstant::ENT_PRD_SERVICES)->findBy(array('productFk'=>$prodID,'recordActiveFlag'=>1),array('serviceName'=>'ASC'));
                $supplierArr=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->findBy(array('recordActiveFlag'=>1),array('companyName'=>'ASC'));
                $exSupplierArr=$em->getRepository(CommonConstant::ENT_SUPPLIER_PRODUCT_TXN)->findBy(array('productFk'=>$prodID,'recordActiveFlag'=>1));
                $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_EDIT_PROD, 
                               array('result' => $result,'from'=>$from,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,
                                   'category'=>$category,'supplierArr'=>$supplierArr,'exsupplier'=>$exSupplierArr,'from'=>$from)));                 
                $this->erpMessage->setPage('true');    
            }
            catch(\exception $ex)
            {
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
     * Action: Update product detail
     * @Route("/updateproduct/{prdId}/{from}", name="_updateproduct")
     * 
     */
     public function UpdateProductAction(Request $request,$prdId,$from){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('UpdateProductAction');
	if($accessRight==1){
            
            try{           
                $result = $this->get(ProductConstant::SERVICE_PRODUCT)->UpdateProduct($request,$prdId);         
                if ($result['code'] == 1){
                    $this->erpMessage->setSuccess(true);  
                    $em = $this->getDoctrine()->getManager();
                    $prod=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prdId);
                    $prodcat=$prod->getProductCategory()->getPkid();
                    $CatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($prodcat);
                    $CatProduct = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy
                            (array('recordActiveFlag' => 1, 'productCategory' => $prodcat));
                    $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('recordActiveFlag'=>1),array('unitName'=>'ASC'));
                    $serviceArr=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->GetServicesByProductCategory($CatObj->getPkid());
                    $Arr = array();
                        foreach ($CatProduct as $prod) {
                            $prodpkid = $prod->getPkid();
                            //  echo "pkid ".$prodpkid;
                            $Arr[] = $em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->
                                    findBy(array('statusFlag' => 1, 'recordActiveFlag' => 1, 'product' => $prodpkid));
                        }
                        $this->erpMessage->setSuccess(true);
                        $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_PRODLIST_APPEND,
                                                                    array('obj'=>$Arr,'objcat'=>$CatObj,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>$from)));
                }
                else{
                    $this->erpMessage->setSuccess(false);  
                }
                $this->erpMessage->setMessage($result['msg']);  
            }
            catch (\Exception $ex) 
            {
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
     * Action: Delete a product(set active flag to 0)
     * @Route("/delproduct/{prodid}/{from}", name="_delproduct")
     * 
     */
    public function DeleteProductAction($prodid,$from){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteProductAction');
        if($accessRight==1){
            $result = $this->get(ProductConstant::SERVICE_PRODUCT)->DeleteProduct($prodid);
            if ($result['code'] == 1){
                $this->erpMessage->setSuccess(true);  
                $em = $this->getDoctrine()->getManager();
                $product= $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($prodid);                            
                $categorypkid=$product->getProductCategory()->getPkid();           
                $CatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->find($categorypkid);
                $CatProduct = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy
                        (array('recordActiveFlag' => 1, 'productCategory' => $CatObj));
                $unitArr=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findBy(array('recordActiveFlag'=>1),array('unitName'=>'ASC'));
                $serviceArr=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->GetServicesByProductCategory($CatObj->getPkid());
                $Arr = array();
                    foreach ($CatProduct as $prod) {
                        $prodpkid = $prod->getPkid();
                        //  echo "pkid ".$prodpkid;
                        $Arr[] = $em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->
                                findBy(array('statusFlag' => 1, 'recordActiveFlag' => 1, 'product' => $prodpkid));
                    }
                    $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_PRODLIST_APPEND,
                                                array('obj'=>$Arr,'objcat'=>$CatObj,'unitArr'=>$unitArr,'serviceArr'=>$serviceArr,'from'=>$from)));
                }
                else{
                    $this->erpMessage->setSuccess(false);  
                }
                $this->erpMessage->setMessage($result['msg']); 
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Navigate to Search Product Page(Prd_SearchProduct.html.twig)
     * @Route("/searchprodpage", name="_gotosearchprod")
     */
    public function GotoSearchProdAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchProduct');
	if($accessRight==1){            
            $em = $this->getDoctrine()->getManager();
            $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                         (array('recordActiveFlag'=>1,'statusFlag'=>1),array('categoryName'=>'ASC'));
            $supplierArr= $em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->findBy(array('recordActiveFlag'=>1),array('companyName'=>'ASC'));
            $this->erpMessage->setSuccess(true);   
            $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_SEARCH_PRODUCT,array('category'=>$category,'supplierArr'=>$supplierArr)));
            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }    
    /**
     * Action: Search product by various criteria
     * used in Prd_SearchProduct.html.twig
     * @Route ("/searchproduct", name="_searchproduct")
     */
    public function SearchProductAction(Request $request){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $dataUI=  json_decode($request->getContent());
        $searchby=$dataUI->selSearchProdCriteria;
        $inputCriteria=$dataUI->txtCriteria;
        $category=$dataUI->selSearchCategory;
        $supplierid=$dataUI->selSupplier;
        $date=$dataUI->txtdate;
        $em=$this->getDoctrine()->getManager();
        try{
            switch($searchby){
                case 'all': //search by product category                                           
                    $prodArr = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->SearchAllProduct();                         
                break;
                case 'cat': //search by product category                                           
                    $prodArr = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->SearchProductByCategory($category);
                break;
                case 'sup': //search by product supplier                                           
                    $prodArr = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->SearchProductBySupplier($supplierid);
                break;
                case 'codename': //search by product category                      
                    $prodArr = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->SearchProductByCodeName($inputCriteria);                            
                break;
                case 'brand': //search by product category                     
                    $prodArr = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->SearchProductByManufacturer($inputCriteria);          
                break;                
                case 'date': //search by product category                    
                        $prodArr = $em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->SearchProductsByEntryDate($date);
                break;
            }
            if($prodArr){                
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(ProductConstant::TWIG_PRD_SEARCH_RESULT,
                                                array('prodArr'=>$prodArr)));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No matching Product found');
            }
        }catch(\Exception $ex){
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Error while searching for matching products.Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }  
    ////////////////////////////////////////////////
    ///////////    UNIT  //////////////////////
    ////////////////////////////////////////////////
    
    /**
     * Action: Navigate to UnitMaster.html.twig
     * @Route("/unitmaster", name="_gotounitmaster")
     * 
     */
    public function GoToUnitMasterPageAction()
    {
         $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();         
            $this->erpMessage->setSuccess(true);
            $em = $this->getDoctrine()->getManager();
            $unit= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->findBy
                 ((array('recordActiveFlag'=>1))); 
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_UNIT_MASTER,
                                                                array('unit'=>$unit)));                
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: This method is used to Create New Unit Master
     * @Route("/createunitmaster", name="_createunitmaster")
     */
        
    public function CreateUniMasterAction(Request $request)
    {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
                $result=$this->get(StockConstant::SERVICE_PRODUCT)->InsertUnitMaster($request);
                if($result['code']==1)
                {
                    $em=$this->getDoctrine()->getManager();
                    $this->erpMessage->setSuccess(true);
                    $unit= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->findBy
                                                                    ((array('recordActiveFlag'=>1))); 
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_UNIT_MASTER_LIST, 
                                                       array('unit' => $unit)));
                }
                else
                {
                    $em = $this->getDoctrine()->getManager();                    
                    $this->erpMessage->setSuccess(false);
                }     
                $this->erpMessage->setMessage($result['msg']);
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);                            
    } 
    /**
     * Action: Navigate to UnitMasterUpdate.html.twig
     * @Route("/editunitmaster/{pkid}", name="_gotoeditunitmaster")
     * 
     */
    public function GoToUpdateUnitMasterPageAction($pkid)
    {
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();         
            $this->erpMessage->setSuccess(true);
            $em = $this->getDoctrine()->getManager();
            $unit= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->find($pkid); 
            $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_UNIT_UPDATE,array('unit'=>$unit)));                
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
    /**
     * Action: Update Master Unit table
     * @Route("/updateunit}", name="_updateunit")
     * 
     */
    public function UpdateUnitMasterAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();         
            $result=$this->get(StockConstant::SERVICE_PRODUCT)->UpdateUnitMaster($request);
                if($result['code']==1)
                {
                    $em=$this->getDoctrine()->getManager();
                    $this->erpMessage->setSuccess(true);
                    $unit= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->findBy
                                                                    ((array('recordActiveFlag'=>1))); 
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_UNIT_MASTER_LIST, 
                                                       array('unit' => $unit)));
                }
                else
                {
                    $em = $this->getDoctrine()->getManager();                    
                    $this->erpMessage->setSuccess(false);
                }     
                $this->erpMessage->setMessage($result['msg']);
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);                 
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Delete Unit Master(set recordActiveFlag to 0(zero)
     * @Route("/deleteunit/{pkid}", name="_deleteunit")
     * 
     */
    public function DeleteUnitMasterAction($pkid)
    {
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();       
            $result=$this->get(StockConstant::SERVICE_PRODUCT)->DeleteUnitMaster($pkid);
                if($result['code']==1)
                {
                    $em=$this->getDoctrine()->getManager();
                    $this->erpMessage->setSuccess(true);
                    $unit= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->findBy
                                                                    ((array('recordActiveFlag'=>1))); 
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_UNIT_MASTER, 
                                                       array('unit' => $unit)));
                }
                else
                {
                    $em = $this->getDoctrine()->getManager();                    
                    $this->erpMessage->setSuccess(false);
                }     
                $this->erpMessage->setMessage($result['msg']);              
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
    }
    
    /**
     * Action: Navigate to AssignAttrUnit.html.twig
     * @Route ("/assignattrunitpage", name="_gotoassignattrunit")
     */
    public function GoToAssignAttrUnitPageAction()
    {
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            try{   
                $em = $this->getDoctrine()->getManager();
                $attr= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_ATTR_MASTER)->findBy
                     (array('recordActiveFlag'=>1),array('attributeName'=>'ASC')); 
                $unit= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->findBy
                    (array('recordActiveFlag'=>1),array('unitName'=>'ASC')); 
                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_ASSIGN_ATTR_UNIT,
                     array('attr'=>$attr,'unit'=>$unit)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);  
    }
    /**
     * Action: Load all active Attributes
     * @Route ("/loadunit/{pkid}", name="_loadunit")
     */
    public function loadAttrAction($pkid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $em = $this->getDoctrine()->getManager();  
            $attrObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_ATTR_MASTER)->find($pkid);
            try 
            {                 
                $unitObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_ATTR_UNIT_TXN)->findBy
                         ((array('attributeMaster'=>$pkid,'statusFlag'=>1,'recordActiveFlag'=>1)));
                if($unitObj)
                {
                    $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_APPEND_ROW,
                    array('unit'=>$unitObj)));
                    $this->erpMessage->setSecondHtml('true');
                }
                $attrname=$attrObj->getAttributeName();
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage("success");
                $this->erpMessage->setPage("Select Unit For '".$attrname."' :");                      
            } 
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**
     * Action: This method is used to append selected unit to UI for assigning it to the selected Attribute
     * @Route ("/appendunit/{pkid}", name="_appendunit")
     */
    public function AppendSelectedUnitAction($pkid)
    {
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $em = $this->getDoctrine()->getManager();  
            $UnitObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_UNIT_MASTER)->find($pkid);
            try 
            {           
                $this->erpMessage->setHtml($this->renderView(StockConstant::TWIG_PRD_ADD_SEL_UNIT,
                array('unit'=>$UnitObj)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage("success");                 
            } 
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**
     * Action: Insert unit for selected Attribute in database
     * @Route ("/insertattrunit", name="_insertattrunit")
     */
    public function InsertAttrUnitAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $result=$this->get(StockConstant::SERVICE_PRODUCT)->insertAttrUnit($request);
        if($result['code']==1)
        {
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage("success");
        }
        else
        {
            $this->erpMessage->setSuccess(false);               
        }                  
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
}
