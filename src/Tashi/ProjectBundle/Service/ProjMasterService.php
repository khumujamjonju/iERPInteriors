<?php
namespace Tashi\ProjectBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\ProjectAreaMaster;
use Tashi\CommonBundle\Entity\IndustryTypeMaster;

class ProjMasterService {
    protected $em;
    protected $session;
    protected $commonService;

    public function __construct(EntityManager $em, Session $session,$cmnService) 
    {
        $this->em = $em;
        $this->session = $session;  
        $this->commonService=$cmnService;
    } 
   function InsertEditProjectArea($request,$mode)
    {   //Create Category    
        $dataUI = json_decode($request->getContent());
        $areaName=$dataUI->txtAreaName;
        $desc=$dataUI->txtDescription;
        $pkid=$dataUI->pkid;
        $statusflag=0;
        if($areaName==''){
            return array('code'=> 0,'msg'=>'Enter Area Name');
        }
        $checkArea=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(
               array('area'=>$areaName,'recordActiveFlag'=>1));
        if($checkArea)
        {
            if($mode=='INS'){
                return array('code'=> 0,'msg'=>'Category Name Already Exist!');
            }
            else{
                foreach($checkArea as $area)
                {
                    $newpkid=$area->getPkid();
                    if(($newpkid!=$pkid)&& strcmp($areaName,$area->getArea())==0)
                    $statusflag=1;
                }
            }           
            if($statusflag==1){
                return array('code'=> 0,'msg'=>'Fail to Update!! Category Name Already Exist!');
            }
        }
        try
        {
            if($mode=='INS')
            {
                $Area= new ProjectAreaMaster();  
                $Area->setRecordActiveFlag(1);
                $Area->setRecordInsertDate(new \Datetime());
            }
            else
            {
                $Area= $this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($pkid);   
                $Area->setRecordUpdateDate(new \Datetime());
            }
            $Area->setArea($areaName);
            $Area->setDescription($desc);
            if($mode=='INS')
            {
                $this->em->persist($Area);
            }
            $this->em->flush(); 
            if($mode=='INS')
            {
                return array('code'=> 1,'msg'=>'Project Area has been created successfully.');
            }else{
                return array('code'=> 1,'msg'=>'Project Area detail has been updated successfully.');
            }
        }
        catch(\Exception $ex)
        {
            return array('code'=> 0,'msg'=>'Unable to process due to an unexpected server error.');
        }    
    }
    public function deleteArea($areaid){
        try{
            $area=$this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($areaid);
            $area->setRecordActiveFlag(0);
            $area->setRecordUpdateDate(new \DateTime('now'));
            $this->em->flush();
            
            $returncode=1;
            $returnmsg='Project Area has been deleted successfully.';
        } catch (Exception $ex) {
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error.';
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    
    /********** INDUTRY TYPE***************/
    function InsertEditIndustryType($request,$mode)
    {   //Create Category    
        $dataUI = json_decode($request->getContent());
        $typename=$dataUI->txtname;
        $desc=$dataUI->txtDescription;
        $pkid=$dataUI->pkid;
        $statusflag=0;
        if($typename==''){
            return array('code'=> 0,'msg'=>'Enter Industry Type');
        }
        $check=$this->em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->findBy(
               array('industryType'=>$typename,'recordActiveFlag'=>1));
        if($check)
        {
            if($mode=='INS'){
                return array('code'=> 0,'msg'=>'Industry Type Already Exist!');
            }
            else{
                foreach($check as $industry)
                {
                    $newpkid=$industry->getPkid();
                    if(($newpkid!=$pkid)&& strcmp($typename,$industry->getArea())==0)
                    $statusflag=1;
                }
            }           
            if($statusflag==1){
                return array('code'=> 0,'msg'=>'Fail to Update!! Category Name Already Exist!');
            }
        }
        try
        {
            if($mode=='INS'){
                $industrytype= new IndustryTypeMaster();  
                $industrytype->setRecordActiveFlag(1);
                $industrytype->setRecordInsertDate(new \Datetime());
            }
            else{
                $industrytype= $this->em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->find($pkid);   
                $industrytype->setRecordUpdateDate(new \Datetime());
            }
            $industrytype->setIndustryType($typename);
            $industrytype->setDescription($desc);
            if($mode=='INS')
            {
                $this->em->persist($industrytype);
            }
            $this->em->flush($industrytype); 
            if($mode=='INS')
            {
                return array('code'=> 1,'msg'=>'Industry Type has been saved successfully.');
            }else{
                return array('code'=> 1,'msg'=>'Industry Type detail has been updated successfully.');
            }
        }
        catch(\Exception $ex)
        {
            return array('code'=> 0,'msg'=>'Unable to process due to an unexpected server error.');
        }    
    }
    public function deleteIndustry($industryid){
        try{
            $industry=$this->em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->find($industryid);
            $industry->setRecordActiveFlag(0);
            $industry->setRecordUpdateDate(new \DateTime('now'));
            $this->em->flush($industry);
            
            $returncode=1;
            $returnmsg='Industry type has been deleted successfully.';
        } catch (Exception $ex) {
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error.';
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
}
