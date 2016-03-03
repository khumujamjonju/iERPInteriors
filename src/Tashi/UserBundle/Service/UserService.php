<?php

namespace Tashi\UserBundle\Service;
use Tashi\CommonBundle\Helper\CommonConstant;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager; 
use Tashi\CommonBundle\Entity\UserGroupMaster;
use Tashi\CommonBundle\Entity\UserGroupTxn;
use Tashi\CommonBundle\Entity\UserStatusTxn;
use Tashi\CommonBundle\Entity\UserTbl;
use Tashi\CommonBundle\Entity\SystemGroupActivityTxn;

class UserService {
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;
    protected $mailer;
    protected $twig;
    public function __construct(EntityManager $em, Session $session,$commonService,$mailer, $twig) 
    {
        $this->em = $em;
        $this->session = $session;
        $this->commonService=$commonService;       
        $this->mailer=$mailer;
        $this->twig=$twig;
    }
    function insertGroup($request){
        $dataUI=  json_decode($request->getContent());
        $groupName=$dataUI->txtGroupName;
        $desc=$dataUI->txtdesc;
        $groupArr=$this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('groupName'=>$groupName,'recordActiveFlag'=>1));
        if($groupArr){
            return array('code'=>0,'msg'=>'Group Name already exist.');
        }
        try{
            $group=new UserGroupMaster();
            $group->setGroupName($groupName);
            $group->setGroupDesc($desc);
            $group->setApprovalFlag(1);
            $group->setRecordActiveFlag(1);
            $group->setRecordInsertDate(new \DateTime("now"));
            $group->setApplicationUserId($this->session->get('EMPID'));
            $group->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($group);
            $this->em->flush($group);
            $returncode=1;
            $returnmsg='User Group has been added successfully';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function updateGroup($request){
        $dataUI=  json_decode($request->getContent());
        $groupid=$dataUI->txtgroupid;
        $groupName=$dataUI->txtGroupName;
        $desc=$dataUI->txtdesc;
        $groupArr=$this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->findBy(array('groupName'=>$groupName,'recordActiveFlag'=>1));
        if($groupArr){
            foreach($groupArr as $group){
                if($groupid!=$group->getPkid()){
                    return array('code'=>0,'msg'=>'Group Name already exist.');
                }
            }            
        }
        try{
            $group=$this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($groupid);
            $group->setGroupName($groupName);
            $group->setGroupDesc($desc);
            $group->setRecordUpdateDate(new \DateTime("now"));
            $group->setApplicationUserId($this->session->get('EMPID'));
            $group->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($group);
            $returncode=1;
            $returnmsg='User Group detail has been updated successfully';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function deleteGroup($groupid){
        try{
            $group=$this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($groupid);
            $group->setRecordActiveFlag(0);
            $group->setRecordUpdateDate(new \DateTime("now"));
            $group->setApplicationUserId($this->session->get('EMPID'));
            $group->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($group);
            $returncode=1;
            $returnmsg='User Group has been deleted';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function insertAccount($request){
        $dataUI=  json_decode($request->getContent());
        //$groups=$dataUI->chkGroup;
        $employeeId=$dataUI->inputEmpId;
        $username=$dataUI->txtuname;
        $password=$dataUI->txtpass;
        $wefDate=$dataUI->txtWef;
        $exDate=$dataUI->txtExpDate;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            $chkUserName=  $this->em->getRepository(CommonConstant::ENT_USER_TABLE)->findBy(array('userName'=>$username,'recordActiveFlag'=>1));
            if($chkUserName){
                return array('code'=>0,'msg'=>'User Name is not available. Please use a different User Name.');
            }            
            $user=new UserTbl();
            $employee= $this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->find($employeeId);
            $status=$this->em->getRepository(CommonConstant::ENT_USER_STATUS_MASTER)->find(1);
            
            $user->setUserFk($employee);
            $user->setUserName($username);
            $user->setUserPassword(md5($password));
            $user->setStartDate(new \DateTime($wefDate));
            if($exDate!=''){
                $user->setEndDate(new \DateTime($exDate));
            }
            $user->setStatusFk($status);
            $user->setRecordActiveFlag(1);
            $user->setIsActivate(0);
            $this->em->persist($user);
            $this->em->flush($user);
            //USER STATUS TXN
            $userstatus=new UserStatusTxn();
            $userstatus->setUserFk($user);
            $userstatus->setStatusFk($status);
            $userstatus->setStatusDate(new \DateTime("NOW"));
            $userstatus->setRemarks("Account Created");
            $userstatus->setRecordActiveFlag(1);
            $userstatus->setRecordInsertDate(new \DateTime("NOW"));
            $this->em->persist($userstatus);
            $this->em->flush($userstatus);
//            if(is_array($groups)){
//                foreach($groups as $groupid){
//                    $group=$this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($groupid);
//                    $grouptxn=new UserGroupTxn();
//                    $grouptxn->setGroupFk($group);
//                    $grouptxn->setUserFk($user);
//                    $grouptxn->setApprovalFlag(1);
//                    $grouptxn->setRecordActiveFlag(1);
//                    $grouptxn->setRecordInsertDate(new \DateTime("NOW"));
//                    $grouptxn->setApplicationUserId($this->session->get('EMPID'));
//                    $grouptxn->setApplicationUserIpAddress($this->session->get('IP'));
//                    $this->em->persist($grouptxn);
//                    $this->em->flush($grouptxn);
//                }
//            }else{
//                $group=$this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($groups);
//                    $grouptxn=new UserGroupTxn();
//                    $grouptxn->setGroupFk($group);
//                    $grouptxn->setUserFk($user);
//                    $grouptxn->setApprovalFlag(1);
//                    $grouptxn->setRecordActiveFlag(1);
//                    $grouptxn->setRecordInsertDate(new \DateTime("NOW"));
//                    $grouptxn->setApplicationUserId($this->session->get('EMPID'));
//                    $grouptxn->setApplicationUserIpAddress($this->session->get('IP'));
//                    $this->em->persist($grouptxn);
//                    $this->em->flush($grouptxn);
//            }
            $conn->commit();
            $returncode=1;
            $returnmsg='User Account has been created successfully.';
            
        } catch (Exception $ex) {
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function BlockAccount($request){
        $dataUI=  json_decode($request->getContent());
        $accId=$dataUI->inputAccId;
        $remark=$dataUI->txtRemark;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            $status=$this->em->getRepository(CommonConstant::ENT_USER_STATUS_MASTER)->find(2);//for block status
            
            $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accId);            
            $account->setStatusFk($status);
            $account->setRecordUpdateDate(new \DateTime("NOW"));
            $account->setApplicationUserId($this->session->get('EMPID'));
            $account->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($account);
            //USER STATUS TXN
            $statustxn=new UserStatusTxn();
            $statustxn->setUserFk($account);
            $statustxn->setStatusFk($status);
            $statustxn->setRemarks($remark);
            $statustxn->setRecordInsertDate(new \DateTime("NOW"));            
            $this->em->persist($statustxn);
            $this->em->flush($statustxn);
            $conn->commit();
            $returncode=1;
            $returnmsg='Account has been blocked.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);        
    }
    
    function ReactivateAccount($request){
        $dataUI=  json_decode($request->getContent());
        $accId=$dataUI->inputAccId;
        $expDate=$dataUI->txtExpDate;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            $status=$this->em->getRepository(CommonConstant::ENT_USER_STATUS_MASTER)->find(1);//for Active status
            
            $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accId);            
            $account->setStatusFk($status);
            if($expDate!=''){
                $account->setEndDate(new \DateTime($expDate));
            }else{
                $account->setEndDate(null);
            }
            $account->setRecordUpdateDate(new \DateTime("NOW"));
            $account->setApplicationUserId($this->session->get('EMPID'));
            $account->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($account);
            //USER STATUS TXN
            $statustxn=new UserStatusTxn();
            $statustxn->setUserFk($account);
            $statustxn->setStatusFk($status);
            $statustxn->setRemarks("Account Re-activated.");
            $statustxn->setRecordInsertDate(new \DateTime("NOW"));
            $this->em->persist($statustxn);
            $this->em->flush($statustxn);
            $conn->commit();
            $returncode=1;
            $returnmsg='Account has been Re-activated.';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }
    function ActivateAccount($request){
        $dataUI=  json_decode($request->getContent());
        $accId=$dataUI->inputAccId;
        $password=$dataUI->txtpass;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            $status=$this->em->getRepository(CommonConstant::ENT_USER_STATUS_MASTER)->find(1);//for Active status
            
            $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accId);            
            $account->setIsActivate(1);   
            $account->setUserPassword(md5($password));
            $account->setRecordUpdateDate(new \DateTime("NOW"));
             $account->setApplicationUserId($this->session->get('EMPID'));
             $account->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($account);
            //USER STATUS TXN
            $statustxn=new UserStatusTxn();
            $statustxn->setUserFk($account);
            $statustxn->setStatusFk($status);
            $statustxn->setRemarks("Account Re-activated.");
            $statustxn->setRecordInsertDate(new \DateTime("NOW"));             
            $this->em->persist($statustxn);
            $this->em->flush($statustxn);
            $conn->commit();
            $returncode=1;
            $returnmsg='';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=  CommonConstant::ERR_DB_OPERATION;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }    
    function SendLink($request){
        $dataUI=  json_decode($request->getContent());
        $uname=$dataUI->txtuname;
        $email=$dataUI->txtemail;
        $conn=  $this->em->getConnection();
        try{            
            $conn->beginTransaction();      
            if($email=='' && $uname!=''){
                $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->findBy(array('userName'=>$uname,'recordActiveFlag'=>1));
            }else{
                $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->FindUserByEmail($email);
            }
            if($account){
                $officeEmail=$account[0]->getUserFk()->getPersonFk()->getEmailIdOffice();
                $email=$account[0]->getUserFk()->getPersonFk()->getEmailId();
                $link=$this->commonService->RandomAlphaNumeric(rand(100, 150));
                //$twig = new \Twig_Environment(new \Twig_Loader_String());
                if($officeEmail){
                    $body=$this->twig->render('TashiUserBundle:User:ForgotPasswordTemplate.html.twig',array('link'=>$link,'email'=>$officeEmail));                
                }elseif($email){
                    $body=$this->twig->render('TashiUserBundle:User:ForgotPasswordTemplate.html.twig',array('link'=>$link,'email'=>$email));                
                }
                $message = \Swift_Message::newInstance()                
                ->setSubject('Reset Password')
                ->setFrom('itsupport@tashiinteriors.com','itsupport@tashiinteriors.com');
                if($officeEmail){
                    $message->setTo($officeEmail);
                }else{
                     $message->setTo($email);
                }
                $message->setBody($body,'text/html');
                $this->mailer->send($message);
                $account[0]->setResetLink($link);
                $account[0]->setRecordUpdateDate(new \DateTime("NOW"));
                $account[0]->setApplicationUserId($this->session->get('EMPID'));
                $account[0]->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush($account[0]);
                $conn->commit();
                $returncode=1;
                $returnmsg='';
            }else{
                return array('code'=>0,'msg'=>'User Name or Email Id is not registered!!');
            }
        }
        catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=  CommonConstant::ERR_DB_OPERATION;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function EraseLink($link){
        try{
            $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->findOneBy(array('resetLink'=>$link,'recordActiveFlag'=>1));
            if($account){
                $account->setResetLink('');
                $account->setRecordUpdateDate(new \DateTime("NOW"));
                $account->setApplicationUserId($this->session->get('EMPID'));
                $account->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush($account);
                return array('code'=>1,'account'=>$account);
            }else{
                return array('code'=>0);
            }           
            
        } catch (\Exception $ex) {
            return array('code'=>0);
        }
    }
    function ChangePassword($request,$logaction){
        $dataUI=  json_decode($request->getContent());
        $accId=$dataUI->inputAccId;
        $password=$dataUI->txtpass;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();       
            $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accId);            
            $account->setIsActivate(1);   
            $account->setUserPassword(md5($password));
            $account->setRecordUpdateDate(new \DateTime("NOW"));
            $account->setApplicationUserId($this->session->get('EMPID'));
            $account->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($account);
            //USER STATUS TXN
            $statustxn=new UserStatusTxn();
            $statustxn->setUserFk($account);
            $statustxn->setRemarks($logaction);
            $statustxn->setRecordInsertDate(new \DateTime("NOW"));
            $this->em->persist($statustxn);
            $this->em->flush($statustxn);
            $conn->commit();
            $this->session->set('PASS',md5($password));
            $returncode=1;
            $returnmsg='';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }
    function AssignActivity($request){
        $dataUI=  json_decode($request->getContent());
        
        $userGroup = $dataUI->txt_group;
        
        $activityid = array();
        $activityid = $dataUI->activity;
         
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            
            $UserGroup = $this->em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->findby(array(('userGroupFk')=>$userGroup));   
            if($UserGroup)
            {
              $returncode=0;
              $returnmsg='Activity already assign! please edit to add new activity.';
            }
            else
            {
            foreach ($activityid as $val)
            {
            $UserGroup = $this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($userGroup);
            $Activity = $this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->find($val);            
             
            $SystemGroupTxn=new SystemGroupActivityTxn();
            $SystemGroupTxn->setActivityFk($Activity);
            $SystemGroupTxn->setUserGroupFk($UserGroup);
            $SystemGroupTxn->setApprovalFlag(1);
            $SystemGroupTxn->setRecordActiveFlag(1);
            $SystemGroupTxn->setRecordInsertDate(new \DateTime("NOW"));
            $SystemGroupTxn->setApplicationUserId($this->session->get('EMPID'));
            $SystemGroupTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($SystemGroupTxn);
            $this->em->flush($SystemGroupTxn);
            }
            $conn->commit();
            $returncode=1;
            $returnmsg='Activity assign sucessfully.';}
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }
    
    
    
    function UpdateAssignTXN($request){
        $dataUI=  json_decode($request->getContent());
        
        $userGroup = $dataUI->txt_group;
        
        $activityid = array();
         
        if (is_string($dataUI->activity)) {
                $activityid[0] =  $dataUI->activity; //for only one               
            } else {
                $activityid = $dataUI->activity;     //for more than one       
            }
         
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            //for updating systemgroupactivitytxn
            $SystemGroup = $this->em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->findBy(array('recordActiveFlag'=>1,'userGroupFk'=>$userGroup));
            
            if($SystemGroup)
            {foreach($SystemGroup as $val1)
            {   $pkid = $val1->getPkid();
                $SystemGroupTxn = $this->em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->find($pkid);
                $SystemGroupTxn->setRecordActiveFlag(0);
                $this->em->flush($SystemGroupTxn);
                //for updating and inserting into system_group_activity_txn
                            
              //updating and insert section ends here
            }}
            foreach ($activityid as $val)
                            {       
                                $Systempkid = $this->em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->findOneBy(array('userGroupFk'=>$userGroup,'activityFk'=>$val));
                                    if($Systempkid)
                                    {
                                    $id = $Systempkid->getPkid();
                                    $SystemGroupTxn1 = $this->em->getRepository(CommonConstant::ENT_GROUP_ACTIVITY_TXN)->find($id);
                                    //for updating groupuseractivitytxn when activity list is found
                                    $SystemGroupTxn1->setRecordActiveFlag(1);
                                    $SystemGroupTxn1->setRecordUpdateDate(new \DateTime("NOW"));
                                    $SystemGroupTxn1->setApplicationUserId($this->session->get('EMPID'));
                                    $SystemGroupTxn1->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->flush($SystemGroupTxn1);
                                    }
                                     else
                                         {
                                            $UserGroup = $this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($userGroup);
                                            $Activity = $this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->find($val);            

                                            $SystemGroupTxn=new SystemGroupActivityTxn();
                                            $SystemGroupTxn->setActivityFk($Activity);
                                            $SystemGroupTxn->setUserGroupFk($UserGroup);
                                            $SystemGroupTxn->setApprovalFlag(1);
                                            $SystemGroupTxn->setRecordActiveFlag(1);
                                            $SystemGroupTxn->setRecordInsertDate(new \DateTime("NOW"));
                                            $SystemGroupTxn->setApplicationUserId($this->session->get('EMPID'));
                                            $SystemGroupTxn->setApplicationUserIpAddress($this->session->get('IP'));
                                            $this->em->persist($SystemGroupTxn);
                                            $this->em->flush($SystemGroupTxn);
                                         } 
                            }
            //updating section ends here
            $conn->commit();
            $returncode=1;
            $returnmsg='User activity saved sucessfully.'; 
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }
    
    
    
      function SaveUserGruupTXN($request){
        $dataUI=  json_decode($request->getContent());
        
        $Group = $dataUI->groupID;
        
        $userID = array();
        if (is_string($dataUI->userID)) {
                $userID[0] =  $dataUI->userID; //for only one               
            } else {
                $userID = $dataUI->userID;     //for more than one       
            }
        
         
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            //for updating systemgroupactivitytxn
           $SystemGroup = $this->em->getRepository(CommonConstant::ENT_USER_GROUP_TXN)->findBy(array('recordActiveFlag'=>1,'groupFk'=>$Group));
           
           if($SystemGroup)
           {
               foreach($SystemGroup as $val1)
            {   $pkid = $val1->getPkid();
                $SystemUserGroupTxn = $this->em->getRepository(CommonConstant::ENT_USER_GROUP_TXN)->find($pkid);
                $SystemUserGroupTxn->setRecordActiveFlag(0);
                $this->em->flush($SystemUserGroupTxn);
            } 
           }
           
           
           foreach ($userID as $val) {
                $Systempkid = $this->em->getRepository(CommonConstant::ENT_USER_GROUP_TXN)->findOneBy(array('groupFk' => $Group, 'userFk' => $val));
                if ($Systempkid) {
                    $id = $Systempkid->getPkid();
                    $SystemUserGroupTxn = $this->em->getRepository(CommonConstant::ENT_USER_GROUP_TXN)->find($id);
                    //for updating groupuseractivitytxn when activity list is found
                    $SystemUserGroupTxn->setRecordActiveFlag(1);
                    $SystemUserGroupTxn->setRecordUpdateDate(new \DateTime("NOW"));
                    $SystemUserGroupTxn->setApplicationUserId($this->session->get('EMPID'));
                    $SystemUserGroupTxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush($SystemUserGroupTxn);
                } else {
                    $Groupname = $this->em->getRepository(CommonConstant::ENT_GROUP_MASTER)->find($Group);
                    $User = $this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($val);

                    $SystemUserGroupTxn = new UserGroupTxn();
                    $SystemUserGroupTxn->setUserFk($User);
                    $SystemUserGroupTxn->setGroupFk($Groupname);
                    $SystemUserGroupTxn->setApprovalFlag(1);
                    $SystemUserGroupTxn->setRecordActiveFlag(1);
                    $SystemUserGroupTxn->setRecordInsertDate(new \DateTime("NOW"));                    
                    $this->em->persist($SystemUserGroupTxn);
                    $this->em->flush($SystemUserGroupTxn);
                }
            }
            //updating section ends here
            $conn->commit();
            $returncode=1;
            $returnmsg='User group saved sucessfully.'; 
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg); 
    }
    public function AssignPassword($request){
        $dataUI=  json_decode($request->getContent());
        $accountid=$dataUI->inputAccid;
        $password=$dataUI->txtpass;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            $user= $this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);
            $user->setUserPassword(md5($password));
            $user->setRecordUpdateDate(new \DateTime("NOW"));
            $this->em->flush($user);            
            $conn->commit();
            $returncode=1;
            $returnmsg='New Password has been assigned successfully.';
            
        } catch (Exception $ex) {
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function ChangeExpiryDate($request){
        $dataUI=  json_decode($request->getContent());
        $accountid=$dataUI->inputAccid;       
        $exDate=$dataUI->txtExpDate;
        $conn=  $this->em->getConnection();
        try{
            $conn->beginTransaction();
            $user= $this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);
            if($exDate!=''){
                $user->setEndDate(new \DateTime($exDate));
            }else{
                $user->setEndDate(null);
            }
            $user->setRecordUpdateDate(new \DateTime("NOW"));
            $this->em->flush($user);            
            $conn->commit();
            $returncode=1;
            $returnmsg='New Expiry date has been saved successfully.';
            
        } catch (Exception $ex) {
            $returncode=0;
            $returnmsg=$this->commonService->CommonError($ex,'db');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
}
