<?php

namespace Tashi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\UserBundle\Helper\UserConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
/**
 * @Route("/usermgt")
 */
class UserController extends Controller
{
    protected $erpMessage;
    protected $session;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
        $this->session=$this->getRequest()->getSession();
    }
    /**
     * @Route ("/userdashboard", name="_userdashboard")
     */
    public function userDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('userDashboardAction');
	if($accessRight==1){
            try{    
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_USER_DASHBOARD));
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
     * @Route ("/managegrouppage", name="_gotoaddusergroup")
     */
    public function GotoManageGroupAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $groupArr=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1),array('groupName'=>'asc'));
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_GROUP_ADD,array('groupArr'=>$groupArr)));
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
     * @Route ("/insertgroup", name="_insertgroup")
     */
    public function InsertGroupAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();       
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        $result=$this->get(UserConstant::SERVICE_USER)->insertGroup($request);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $groupArr=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1),array('groupName'=>'asc'));
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_GROUP_ADD,array('groupArr'=>$groupArr)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                    $this->erpMessage->setSuccess(false);
            }
        }else{
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
     * @Route ("/editgrouppage/{groupid}", name="_gotoeditgroup")
     */
    public function GotoEditGroupAction($groupid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
            try{
                $em=$this->getDoctrine()->getManager();
                $group=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($groupid);
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_GROUP_EDIT,array('group'=>$group)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
    }
    /**
     * @Route ("/updategroup", name="_updategroup")
     */
    public function UpdateGroupAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        $result=$this->get(UserConstant::SERVICE_USER)->updateGroup($request);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $groupArr=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1),array('groupName'=>'asc'));
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_GROUP_LIST,array('groupArr'=>$groupArr)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                    $this->erpMessage->setSuccess(false);
            }
        }else{
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
     * @Route ("/deletegroup/{groupid}", name="_deletegroup")
     */
    public function DeleteGroupAction($groupid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
            $result=$this->get(UserConstant::SERVICE_USER)->deleteGroup($groupid);
            if($result['code']==1){
                try{
                    $em=$this->getDoctrine()->getManager();
                    $groupArr=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1),array('groupName'=>'asc'));
                    $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_GROUP_ADD,array('groupArr'=>$groupArr)));
                    $this->erpMessage->setSuccess(true);
                }
                catch (\Exception $ex) {
                        $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                        $this->erpMessage->setSuccess(false);
                }
            }else{
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
    
    ////////////////////////////////////////////////////
    ////////////////      USER ACCOUNT     ////////////
    ////////////////////////////////////////////////////
    /**
     * @Route ("/createaccountpage", name="_createaccountpage")
     */
    public function GotoSearchEmployee()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            try{                               
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_SEARCH_EMPLOYEE));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                    $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
    }
    /**
     * @Route ("/searchemployee", name="_searchemployee")
     */
    public function SearchEmployee(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
        try{
            $em=$this->getDoctrine()->getManager();
            $dataUI=  json_decode($request->getContent());
            $criteria=$dataUI->selCriteria;
            $keyword=$dataUI->txtuidname;
            $empArr=$em->getRepository(CommonConstant::ENT_USER_TABLE)->SearchEmployee($criteria,$keyword);
            if($empArr){
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_EMP_LIST,array('empArr'=>$empArr)));
                $this->erpMessage->setSuccess(true);
            }else{
                $this->erpMessage->setMessage('No matching record found.');
                $this->erpMessage->setSuccess(false);
            }
        }
        catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/createaccount/{employeeId}", name="_createaccount")
     */
    public function GotoCreateAccountAction($employeeId)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();            
            $emp=$em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($employeeId);
            //$groupArr=$em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1),array('groupName'=>'ASC'));
            $randPass=$this->get(CommonConstant::SERVICE_COMMON)->RandomAlphaNumeric(8);           
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_CREATE_ACCOUNT,array('emp'=>$emp,'rand'=>$randPass)));
            $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage());
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
     * @Route ("/insuseraccount", name="_insuseraccount")
     */
    public function InsertUserAccountAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        $result=$this->get(UserConstant::SERVICE_USER)->insertAccount($request);        
        if($result['code']==1){            
            $this->erpMessage->setSuccess(true);
        }else{
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
     * @Route ("/searchaccountpage", name="_gotosearchaccount")
     */
    public function GotoSearchAccountAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
        try{            
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_SEARCH_ACCOUNT));
            $this->erpMessage->setSuccess(true);
        }catch(\Exception $ex){
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/searchaccount", name="_searchaccount")
     */
    public function SearchAccountAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
        try{
            $em=$this->getDoctrine()->getManager();
            $dataUI=  json_decode($request->getContent());
            $criteria=$dataUI->selCriteria;
            $keyword=$dataUI->txtkeyword;
            $groupArr=$em->getRepository(CommonConstant::ENT_USER_GROUP_TXN)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1));
            $accArr=$em->getRepository(CommonConstant::ENT_USER_TABLE)->SearchAccount($criteria,$keyword);
             if($accArr){
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ACCOUNT_LIST,array('accArr'=>$accArr,'groupArr'=>$groupArr)));
                $this->erpMessage->setSuccess(true);
             }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Sorry!! No matching record found.');
            }
        }catch(\Exception $ex){
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/blockaccountpage/{accountid}", name="_gotoblockaccount")
     */
    public function GotoBlockAccountAction($accountid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
        try{
            $em=$this->getDoctrine()->getManager();
            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);
            $emp=$account->getUserFk();
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_BLOCK_ACCOUNT,array('emp'=>$emp,'account'=>$account)));
            $this->erpMessage->setSuccess(true);
        }catch(\Exception $ex){
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/blockaccount", name="_blockaccount")
     */
    public function BlockAccountAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        $result=$this->get(UserConstant::SERVICE_USER)->BlockAccount($request);        
        if($result['code']==1){
            $this->erpMessage->setSuccess(true);
        }else{
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
     * @Route ("/reactivateaccountpage/{accountid}", name="_gotoreactivate")
     */
    public function GotoReactivateAccountAction($accountid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        try{
            $em=$this->getDoctrine()->getManager();
            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);            
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_REACTIVATE_ACCOUNT,array('account'=>$account)));
            $this->erpMessage->setSuccess(true);
        }catch(\Exception $ex){
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/reactivateaccount", name="_reactivateaccount")
     */
    public function ReactivateAccountAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        $result=$this->get(UserConstant::SERVICE_USER)->ReactivateAccount($request);        
        if($result['code']==1){
            $this->erpMessage->setSuccess(true);
        }else{
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
     * @Route ("/activateaccount", name="_activateaccount")
     */
    public function ActivateAccountAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $dataUI=json_decode($request->getContent());
        $newpassword=$dataUI->txtpass;
        if(md5($newpassword)==$this->session->get('PASS')){
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Your new password cannot be same as default password.');
        }else{
            $result=$this->get(UserConstant::SERVICE_USER)->ActivateAccount($request);        
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/forgotpassword", name="_forgotpassword")
     */
    public function ForgotPasswordAction()
    { 
        return $this->render(UserConstant::TWIG_FORGOT_PASS);
    }
    /**
     * @Route ("/sendlink", name="_sendlink")
     */
    public function SendPasswordLinkAction(Request $request)
    { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $dataUI=  json_decode($request->getContent());
            $uname=$dataUI->txtuname;
            $email=$dataUI->txtemail;            
            $em=$this->getDoctrine()->getManager();            
            if(trim($uname)!=''){
                $user=$em->getRepository(CommonConstant::ENT_USER_TABLE)->findOneBy(array('userName'=>$uname,'recordActiveFlag'=>1));                
                $officeEmail=$user->getUserFk()->getPersonFk()->getEmailIdOffice();
                $personalEmail=$user->getUserFk()->getPersonFk()->getEmailId();
                if(!$officeEmail && !$personalEmail){
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('You have not provided any Email Id yet. Please contact your administrator to register your Email Id!!');
                    $jsondata = $serializer->serialize($this->erpMessage, 'json');
                    return new Response($jsondata);
                }else{
                    $check=true;
                }
            }
            elseif(trim($email)!=''){
                $check=$em->getRepository(CommonConstant::ENT_USER_TABLE)->FindUserByEmail($email);
            }
            else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Please enter your User Name or registered Email Id!!');
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            if($check){
                $result=$this->get(UserConstant::SERVICE_USER)->SendLink($request);
                if($result['code']==1){
                    $this->erpMessage->setSuccess(true);                    
                }
                else{
                    $this->erpMessage->setSuccess(false);                    
                    $this->erpMessage->setMessage($result['msg']);
                }
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('User Name or Email Id is not registered!!');
            }
        } catch (Exception $ex) {
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }   
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/resetpassword/{link}", name="_gotoresetpassword")
     */
    public function GotoResetPasswordAction($link)
    {
        $result=$this->get(UserConstant::SERVICE_USER)->EraseLink($link);
        if($result['code']==1){
            return $this->render(UserConstant::TWIG_RESET_PASS,array('account'=>$result['account']));
        }else{
            return $this->render(UserConstant::TWIG_RESET_PASS);
        } 
    }
    /**
     * @Route ("/resetchangepassword}", name="_resetpassword")
     */
    public function ResetPasswordAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();        
        $result=$this->get(UserConstant::SERVICE_USER)->ChangePassword($request,'Reset Password');        
        if($result['code']==1){
            $this->erpMessage->setSuccess(true);
        }else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/accounthistory/{accountid}", name="_accounthistory")
     */
    public function ViewAccountHistoryAction($accountid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);  
            $accHistory=$em->getRepository(CommonConstant::ENT_USER_STATUS_TXN)->
                    findBy(array('userFk'=>$accountid,'recordActiveFlag'=>1),array('pkid'=>'ASC')); 
//            if($accHistory){
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ACCOUNT_HISTORY,array('account'=>$account,'historyArr'=>$accHistory)));
                $this->erpMessage->setSuccess(true);
//            }else{
//                $this->erpMessage->setSuccess(false);
//                $this->erpMessage->setMessage('There are no history for this account');
//            }
        }catch(\Exception $ex){
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
     * @Route ("/activitylog/{accountid}", name="_activitylog")
     */
    public function ViewActivityLogAction($accountid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);  
            $actArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_LOG)->
                    findBy(array('userFk'=>$accountid,'recordActiveFlag'=>1),array('pkid'=>'ASC')); 
                $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ACTIVITY_LOG,array('account'=>$account,'actArr'=>$actArr)));
                $this->erpMessage->setSuccess(true);
//            }else{
//                $this->erpMessage->setSuccess(false);
//                $this->erpMessage->setMessage('There are no history for this account');
//            }
        }catch(\Exception $ex){
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
     * @Route ("/changepasswordpage", name="_gotochangepassword")
     */
    public function GotoChangePasswordAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        //try{
//            $em=$this->getDoctrine()->getManager();            
//            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($this->get('session')->get('UPKID'));      
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_CHANGE_PASSWORD));
            $this->erpMessage->setSuccess(true);
//        }catch(\Exception $ex){
//            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
//            $this->erpMessage->setSuccess(false);
//        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/changepassword", name="_changepassword")
     */
    public function ChangePasswordAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $dataUI=  json_decode($request->getContent());
        $currpass=$this->get('session')->get('PASS');
        $oldpass=$dataUI->txtopass;
        $newpass=$dataUI->txtpass;
        if($currpass!=  md5($oldpass)){
            $this->erpMessage->setMessage('Your old password is incorrect!!');
            $this->erpMessage->setSuccess(false);
        }elseif($currpass==  md5($newpass)){
            $this->erpMessage->setMessage('Your new password cannot be same as old password!!');
            $this->erpMessage->setSuccess(false);
        }else{
            $result=$this->get(UserConstant::SERVICE_USER)->ChangePassword($request,'Password Change');
            if($result['code']==1){            
                $this->erpMessage->setSuccess(true);
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($result['msg']);
            }
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    /**
     * @Route ("/activity_assign", name="_activityassign")
     */
    public function AssignActivityAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();   
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
              $em=$this->getDoctrine()->getManager();
              $result = $em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1));  
              $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ASSIGNACTIVITY,array('usergroup'=>$result)));
              $this->erpMessage->setSuccess(true);
            }catch(\Exception $ex){
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
     * @Route ("/showactivitylist/{aid}", name="_showactivitylist")
     */
    public function showActivityListAction($aid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        try{
              $em=$this->getDoctrine()->getManager();
              //$result = $em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('recordActiveFlag'=>1)); 
              //$result1 = $em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1));  
             
              $result1 = $em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('recordActiveFlag'=>1)); 
              $result2 = $em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1));  
              $group = $em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($aid);  
              $result3 = $em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->findBy(array('recordActiveFlag'=>1,'userGroupFk'=>$aid));
              $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_DISPLAY_ACTIVITY,
              array('display'=>$result3,'module'=>$result2,'activity'=>$result1,'id'=>$aid,'group'=>$group)));
              
              
              
              
              //$this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_USERACTIVITY,array('activity'=>$result,'module'=>$result1,'id'=>$aid)));
              $this->erpMessage->setSuccess(true);
            }catch(\Exception $ex){
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    /**
     * @Route ("/showGroupuser/{aid}", name="_showGroupuser")
     */
    public function showUserforGroupAction($aid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        try{
              $em=$this->getDoctrine()->getManager();
              $group = $em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($aid);
              $accArr=$em->getRepository(CommonConstant::ENT_USER_TABLE)->SearchAllActiveAccount();
              $userGroupTxn = $em->getRepository(CommonConstant::ENT_USER_GROUP_TXN)->findBy(array('groupFk'=>$aid,'recordActiveFlag'=>1));
              $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ASSIGN_GROUP,
                      array('group'=>$group,'accArr'=>$accArr,'userGroupTxn'=>$userGroupTxn)));
              $this->erpMessage->setSuccess(true);
            }catch(\Exception $ex){
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    
    /**
     * @Route ("/saveactivity", name="_saveactivity")
     */
    public function SaveActivityListAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();   
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
              $em=$this->getDoctrine()->getManager();
              $result=$this->get(UserConstant::SERVICE_USER)->AssignActivity($request);
              if ($result['code'] == 1) {
                $this->erpMessage->setSuccess(true);
                } else {
                $this->erpMessage->setSuccess(false);
                }
               $this->erpMessage->setMessage($result['msg']);
           }catch(\Exception $ex){
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
     * @Route ("/updateassignactivity", name="_updateassignactivity")
     */
    public function UpdateActivityListAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();   
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
              $em=$this->getDoctrine()->getManager();
              $result=$this->get(UserConstant::SERVICE_USER)->UpdateAssignTXN($request);
              if ($result['code'] == 1) {
                $this->erpMessage->setSuccess(true);
                } else {
                $this->erpMessage->setSuccess(false);
                }
               $this->erpMessage->setMessage($result['msg']);
           }catch(\Exception $ex){
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
     * @Route ("/saveUserGrouptxn", name="_saveUserGrouptxn")
     */
    public function SaveUserGroupTxnAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
              $em=$this->getDoctrine()->getManager();
              $result=$this->get(UserConstant::SERVICE_USER)->SaveUserGruupTXN($request);
              if ($result['code'] == 1) {
                $this->erpMessage->setSuccess(true);
                } else {
                $this->erpMessage->setSuccess(false);
                }
               $this->erpMessage->setMessage($result['msg']);
           }catch(\Exception $ex){
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
     * @Route ("/searchactivity", name="_searchactivity")
     */
    public function SearchActivityListAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        try{
              $em=$this->getDoctrine()->getManager();
              $result = $em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1,'approvalFlag'=>1)); 
              //$result=$this->get(UserConstant::SERVICE_USER)->SearchAssingActivity($request);
              $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_SEARCHACTIVITY,array('group'=>$result)));
              $this->erpMessage->setSuccess(true); 
              
           }catch(\Exception $ex){
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    /**
     * @Route ("/searchactivitybygroup", name="_searchactivitybygroup")
     */
    public function SearchActivitybyGroupAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        try{ 
              $em=$this->getDoctrine()->getManager();
              $dataUI = json_decode($request->getContent());
              $keyword = $dataUI->selCriteria;
              $result1 = $em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('recordActiveFlag'=>1)); 
              $result2 = $em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1));  
              $result3 = $em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->findBy(array('recordActiveFlag'=>1,'userGroupFk'=>$keyword));
              $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_DISPLAY_ACTIVITY,array('display'=>$result3,'module'=>$result2,'activity'=>$result1,'id'=>$keyword)));
              $this->erpMessage->setSuccess(true); 
              
           }catch(\Exception $ex){
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/viewmyprofile", name="_viewmyprofile")
     */
    public function ViewMyProfileAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();                
        try{ 
              $em=$this->getDoctrine()->getManager();   
              $empid=$this->getRequest()->getSession()->get('EMPID');
              $employee=$em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employeeId'=>$empid));
              
              if($employee){
                    $employee=$employee[0];
                    $mobnoArr=$em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->findBy(array('personFk'=>$employee->getPersonFk(),'recordActiveFlag'=>1));
                    $addressType=$em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('addressTypePk'=>'asc'));
                    $addressArr=$em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->findBy(array('empMasterFk'=>$employee,'isPrimaryAddress'=>1,'recordActiveFlag'=>1));
                    $addArr=array('type'=>array(),'Address'=>array());
                    foreach($addressType as $atype){
                        array_push($addArr['type'],$atype->getAddressTypeName());
                        if($addressArr){
                            foreach($addressArr as $add){                            
                                if($atype->getAddressTypePk()==$add->getAddressMasterFk()->getAddressTypeFk()->getAddressTypePk()){                                
                                    array_push($addArr['Address'],
                                            $this->get(CommonConstant::SERVICE_COMMON)->
                                            AddressFormaterforDetail($add));
                                }else{
                                    array_push($addArr['Address'],'');
                                }
                            }
                        }else{
                            array_push($addArr['Address'],'');
                        }
                    }
                    $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_VIEW_PROFILE,
                            array('emp'=>$employee,'mobileArr'=>$mobnoArr,'addTypeArr'=>$addressType,'addArr'=>$addArr)));
                    $this->erpMessage->setSuccess(true);
              }else{
                    $this->erpMessage->setMessage('Could not load your profile. Please check you connection and make sure you are logged in.');
                    $this->erpMessage->setSuccess(false);
              }    
           }catch(\Exception $ex){
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.' '.$ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/assignusergroup", name="_assignusergroup")
     */
    public function AssignUserGroupAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
              $em=$this->getDoctrine()->getManager();
              $result = $em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('recordActiveFlag'=>1));  
              $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ASSIGN_USER_GROUP,array('usergroup'=>$result)));
              $this->erpMessage->setSuccess(true);
            }catch(\Exception $ex){
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
     * @Route ("/assignnewpassword/{accountid}", name="_assignnewpassword")
     */
    public function AssignNewPasswordAction($accountid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager(); 
            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);
            $emp=$account->getUserFk();            
            $randPass=$this->get(CommonConstant::SERVICE_COMMON)->RandomAlphaNumeric(8);
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_ASSIGN_PASSWORD,array('emp'=>$emp,'acc'=>$account,'rand'=>$randPass)));
            $this->erpMessage->setSuccess(true);            
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage());
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
     * @Route ("/passwordassignment", name="_passwordassignment")
     */
    public function PasswordAssignmentAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
            $result=$this->get(UserConstant::SERVICE_USER)->AssignPassword($request);        
            if($result['code']==1){            
                $this->erpMessage->setSuccess(true);
            }else{
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
     * @Route ("/changeexpirydate/{accountid}", name="_changeexpirydate")
     */
    public function ChangeExpiryDateAction($accountid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager(); 
            $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);
            $emp=$account->getUserFk();            
            $this->erpMessage->setHtml($this->renderView(UserConstant::TWIG_CHANGE_EXPIRY_DATE,array('emp'=>$emp,'acc'=>$account)));
            $this->erpMessage->setSuccess(true);            
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage());
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
     * @Route ("/updateexpirydate", name="_updateexpirydate")
     */
    public function UpdateExpiryDateAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();  
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageUser');
	if($accessRight==1){
            $result=$this->get(UserConstant::SERVICE_USER)->ChangeExpiryDate($request);        
            if($result['code']==1){            
                $this->erpMessage->setSuccess(true);
            }else{
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
}
