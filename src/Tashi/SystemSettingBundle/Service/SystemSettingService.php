<?php
namespace Tashi\SystemSettingBundle\Service;
use Tashi\CommonBundle\Helper\CommonConstant;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager; 
use Tashi\CommonBundle\Entity\SystemModuleMaster;
use Tashi\CommonBundle\Entity\SystemActivityMaster;
class SystemSettingService {
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;

    public function __construct(EntityManager $em, Session $session,$commonService) 
    {
        $this->em = $em;
        $this->session = $session;
        $this->commonService=$commonService;        
    }
    function insertModule($request){
        $dataUI=  json_decode($request->getContent());
        $modulename=$dataUI->txtModuleName;
        $desc=$dataUI->txtdesc;
        $moduleArr=$this->em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('moduleName'=>$modulename,'recordActiveFlag'=>1));
        if($moduleArr){
            return array('code'=>0,'msg'=>'Module Name already exist.');
        }
        try{
            $module=new SystemModuleMaster();
            $module->setModuleName($modulename);
            $module->setDescription($desc);
            $module->setStatusFlag(1);
            $module->setRecordActiveFlag(1);
            $module->setRecordInsertDate(new \DateTime("now"));
            $module->setApplicationUserId($this->session->get('EMPID'));
            $module->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($module);
            $this->em->flush($module);
            $returncode=1;
            $returnmsg='Module added successfully';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function updateModule($request){
        $dataUI=  json_decode($request->getContent());
        $moduleid=$dataUI->txtmoduleid;
        $modulename=$dataUI->txtModuleName;
        $desc=$dataUI->txtdesc;
        $moduleArr=$this->em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('moduleName'=>$modulename,'recordActiveFlag'=>1));
        if($moduleArr){
            foreach($moduleArr as $module){
                if($moduleid!=$module->getPkid()){
                    return array('code'=>0,'msg'=>'Module Name already exist.');
                }
            }            
        }
        try{
            $module=$this->em->getRepository(CommonConstant::ENT_MODULE_MASTER)->find($moduleid);
            $module->setModuleName($modulename);
            $module->setDescription($desc);
            $module->setRecordUpdateDate(new \DateTime("now"));
            $module->setApplicationUserId($this->session->get('EMPID'));
            $module->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($module);
            $returncode=1;
            $returnmsg='Module detail has been updated successfully';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function deleteModule($moduleid){
        try{
            $module=$this->em->getRepository(CommonConstant::ENT_MODULE_MASTER)->find($moduleid);
            $module->setRecordActiveFlag(0);
            $module->setRecordUpdateDate(new \DateTime("now"));
            $module->setApplicationUserId($this->session->get('EMPID'));
            $module->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($module);
            $returncode=1;
            $returnmsg='Module has been deleted';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
    ////////////////////////////////////////////////////
    ////////////////        ACTIVITY      //////////////
    ////////////////////////////////////////////////////
    function insertActivity($request){
        $dataUI=  json_decode($request->getContent());
        $moduleid=isset($dataUI->selModule)?explode('&', $dataUI->selModule)[1]:'';        
        $activityname=$dataUI->txtActivityName;
        $desc=$dataUI->txtdesc;
        $functionname=$dataUI->txtFunctionName;
        $path=$dataUI->txtPath;
        
        $activityArr=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('activityName'=>$activityname,'recordActiveFlag'=>1));
        if($activityArr){
            foreach($activityArr as $activity){
                if($activity->getModuleFk()->getPkid()==$moduleid){
                    return array('code'=>0,'msg'=>'Activity Name already exist.');
                }
            }
        }
        $activityArr=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('functionName'=>$functionname,'recordActiveFlag'=>1));
        if($activityArr){
            foreach($activityArr as $activity){
                if($activity->getModuleFk()->getPkid()==$moduleid){
                    return array('code'=>0,'msg'=>'Function Name already exist.');
                }
            }
        }
        $activityArr=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('controllerPath'=>$path,'recordActiveFlag'=>1));
        if($activityArr){
            foreach($activityArr as $activity){
                if($activity->getModuleFk()->getPkid()==$moduleid){
                    return array('code'=>0,'msg'=>'Controller Path already exist.');
                }
            }
        }
        try{
            $module=$this->em->getRepository(CommonConstant::ENT_MODULE_MASTER)->find($moduleid);
            $activity=new SystemActivityMaster();
            $activity->setModuleFk($module);
            $activity->setActivityName($activityname);
            $activity->setDescription($desc);
            $activity->setFunctionName($functionname);
            $activity->setControllerPath($path);
            $activity->setStatusFlag(1);
            $activity->setApprovalFlag(1);
            $activity->setRecordActiveFlag(1);
            $activity->setRecordInsertDate(new \DateTime("now"));
            $activity->setApplicationUserId($this->session->get('EMPID'));
            $activity->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($activity);
            $this->em->flush($activity);
            $returncode=1;
            $returnmsg='Activity has been added successfully';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function updateActivity($request){
        $dataUI=  json_decode($request->getContent());
        $actid=$dataUI->txtactid;
        $moduleid=isset($dataUI->selModule)?explode('&', $dataUI->selModule)[1]:''; 
        $activityname=$dataUI->txtActivityName;
        $desc=$dataUI->txtdesc;
        $functionname=$dataUI->txtFunctionName;
        $path=$dataUI->txtPath;
        
        $activityArr=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('activityName'=>$activityname,'recordActiveFlag'=>1));
        if($activityArr ){
            foreach($activityArr as $act){
                if($act->getPkid()!=$actid && $act->getModuleFk()->getPkid()==$moduleid){
                    return array('code'=>0,'msg'=>'Activity Name for the selected Module already exist.');
                }
            }            
        }
        $activityArr=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('functionName'=>$functionname,'recordActiveFlag'=>1));
        if($activityArr){
            foreach($activityArr as $act){
                if($act->getPkid()!=$actid && $act->getModuleFk()->getPkid()==$moduleid){
                    return array('code'=>0,'msg'=>'Function Name already exist.');
                }
            } 
            
        }
        $activityArr=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('controllerPath'=>$path,'recordActiveFlag'=>1));
        if($activityArr){
            foreach($activityArr as $act){
                if($act->getPkid()!=$actid && $act->getModuleFk()->getPkid()==$moduleid){
                    return array('code'=>0,'msg'=>'Controller Path already exist.');
                }
            }             
        }
        try{
            $module=$this->em->getRepository(CommonConstant::ENT_MODULE_MASTER)->find($moduleid);
            $activity=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->find($actid);
            $activity->setModuleFk($module);
            $activity->setActivityName($activityname);
            $activity->setDescription($desc);
            $activity->setFunctionName($functionname);
            $activity->setControllerPath($path);
            $activity->setRecordUpdateDate(new \DateTime("now"));
            $activity->setApplicationUserId($this->session->get('EMPID'));
            $activity->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($activity);
            $returncode=1;
            $returnmsg='Activity detail has been updated successfully';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    function deleteActivity($activityid){
        try{
            $activity=$this->em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->find($activityid);
            $activity->setRecordActiveFlag(0);
            $activity->setRecordUpdateDate(new \DateTime("now"));
            $activity->setApplicationUserId($this->session->get('EMPID'));
            $activity->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($activity);
            $returncode=1;
            $returnmsg='Activity has been deleted';
        }catch(\Exception $ex){
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
}
