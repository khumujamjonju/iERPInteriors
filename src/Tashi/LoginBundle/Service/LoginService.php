<?php
namespace Tashi\LoginBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\UserActivityLog;
use Tashi\CommonBundle\Entity\UserTbl;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginClass
 *
 * @author Cobigent
 */
class LoginService{
    
    protected $em;
    protected $session;
    protected $commonService;        
    public function __construct(EntityManager $em, Session $session,$commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->commonService=$commonService;
    }
    //put your code here
    private $username;
    private $password;
    private $md5pass;
    private $flag = false;
    
    function authenticateUser($uid,$pwd)
	{
            $returnFlag = 0; // this variable controls multiple same user name in user_tbl
            $salt = $this->session->get('Salt');
            //$userObj = $this->em->getRepository('TashiCommonBundle:UserTbl')->findByUserName($uid);
            $userObj = $this->em->getRepository('TashiCommonBundle:UserTbl')->findOneBy(array('userName'=>$uid));
            if (!is_null($userObj) && isset($salt)) {
                $this->password = md5(trim($userObj->getUserPassword()) . $salt);
                if($userObj->getPrivilege()=='Su'){
                    if($this->password== trim($pwd)){
                        $this->session->invalidate();
                        $this->session->set('UID', $this->username);
                        $this->session->set('EMPID','');
                        //$this->session->set('RID', $userObj->getUserRoleFk()->getUserRoleName());
                        $this->session->set('PASS',$userObj->getUserPassword());
                        $this->session->set('ACTIVATE',1);
                        $this->session->set('UPKID',$userObj->getUserIdPk());    
                        $this->session->set('IP', $this->commonService->GetClientIP());    
                        $this->session->set('PRIVILEGE',$userObj->getPrivilege());
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    if($userObj->getRecordActiveFlag()==1){
                    if(!is_null($userObj->getEndDate())){
                        $sdate=$userObj->getStartDate();
                        $edate=$userObj->getEndDate();
                        $currDate=new \DateTime("NOW");
                        if($currDate<$sdate || $currDate>$edate){
                            return false;
                        }
                    }
                    if($userObj->getStatusFk()->getIsAccessible()==0){
                        return false;
                    }
                    //foreach($userObj as $thisUser) {
                        $this->username = $userObj->getUserName();
                        //$this->password = md5(trim($userObj->getUserPassword()) . $salt);
                        if ($this->password == trim($pwd)) {
                            $returnFlag = 0;                        
                            //ACTIVITY LOG
                            $log=new UserActivityLog();
                            $log->setUserFk($userObj);
                            $log->setActivity('Login');
                            $log->setActivityDate(new \DateTime("NOW"));
                            $log->setRecordActiveFlag(1);
                            $log->setApplicationUserIpAddress($this->commonService->GetClientIP());
                            $log->setApplicationUserId($userObj->getUserFk()->getEmployeePk());
                            $this->em->persist($log);
                            $this->em->flush($log);
                            $userpkid=$userObj->getUserIdPk();
                            $this->session->invalidate();
                            $this->session->set('UID', $this->username);
                            $this->session->set('EMPID', $userObj->getUserFk()->getEmployeeId());
                            //$this->session->set('RID', $userObj->getUserRoleFk()->getUserRoleName());
                            $this->session->set('PASS',$userObj->getUserPassword());
                            $this->session->set('ACTIVATE',$userObj->getIsActivate());
                            $this->session->set('UPKID',$userpkid);   
                            $this->session->set('PRIVILEGE',$userObj->getPrivilege());
                            $this->session->set('IP', $this->commonService->GetClientIP());
                            $roleList=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->GetUserRoleList($userpkid);  
                            $this->session->set('ROLELIST',$roleList);
                            return true;
                        } 
                        else{
                            $returnFlag = 1;
                        }
                    //}
                    if($returnFlag == 1)
                        return false;
                }
                else{
                    return false;
                }
                }
            }else{
                return false;
            }            
	}
    public function Logout()
    {
        $conn=$this->em->getConnection();
        try{           
            $accountid=$this->session->get('UPKID');
            $conn->beginTransaction();
            $account=$this->em->getRepository(CommonConstant::ENT_USER_TABLE)->find($accountid);
            $log=new UserActivityLog();
            $log->setActivity('Log Out');
            $log->setActivityDate(new \DateTime("NOW"));            
            $log->setUserFk($account);
            $log->setApplicationUserIpAddress($this->commonService->GetClientIP());
            $log->setRecordActiveFlag(1);
            $this->em->persist($log);
            $this->em->flush($log);
            $this->session->invalidate();
            $this->session->clear();
            $conn->commit();
            return array('code'=>1);            
        }catch (Exception $ex) {
            $conn->rollBack();
            return(array('code'=>0,'msg'=> CommonConstant::ERR_DB_OPERATION));
        }
    }    
}
