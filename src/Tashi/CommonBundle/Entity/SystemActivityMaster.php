<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SystemActivityMaster
 *
 * @ORM\Table(name="system_activity_master", indexes={@ORM\Index(name="fk_module_activity_idx", columns={"Module_Id_Fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\ActivityRepository")
 */
class SystemActivityMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Pkid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkid;

    /**
     * @var string
     *
     * @ORM\Column(name="Activity_Name", type="string", length=250, nullable=true)
     */
    private $activityName;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1450, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Function_Name", type="string", length=250, nullable=true)
     */
    private $functionName;

    /**
     * @var string
     *
     * @ORM\Column(name="Controller_Path", type="string", length=300, nullable=true)
     */
    private $controllerPath;

    /**
     * @var integer
     *
     * @ORM\Column(name="Status_Flag", type="integer", nullable=true)
     */
    private $statusFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_Flag", type="integer", nullable=true)
     */
    private $approvalFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_Active_Flag", type="integer", nullable=true)
     */
    private $recordActiveFlag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Insert_Date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Update_Date", type="datetime", nullable=true)
     */
    private $recordUpdateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=15, nullable=true)
     */
    private $applicationUserIpAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Id", type="string", length=60, nullable=true)
     */
    private $applicationUserId;

    /**
     * @var \Tashi\CommonBundle\Entity\SystemModuleMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SystemModuleMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Module_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $moduleFk;



    /**
     * Get pkid
     *
     * @return integer
     */
    public function getPkid()
    {
        return $this->pkid;
    }

    /**
     * Set activityName
     *
     * @param string $activityName
     *
     * @return SystemActivityMaster
     */
    public function setActivityName($activityName)
    {
        $this->activityName = $activityName;

        return $this;
    }

    /**
     * Get activityName
     *
     * @return string
     */
    public function getActivityName()
    {
        return $this->activityName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SystemActivityMaster
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set functionName
     *
     * @param string $functionName
     *
     * @return SystemActivityMaster
     */
    public function setFunctionName($functionName)
    {
        $this->functionName = $functionName;

        return $this;
    }

    /**
     * Get functionName
     *
     * @return string
     */
    public function getFunctionName()
    {
        return $this->functionName;
    }

    /**
     * Set controllerPath
     *
     * @param string $controllerPath
     *
     * @return SystemActivityMaster
     */
    public function setControllerPath($controllerPath)
    {
        $this->controllerPath = $controllerPath;

        return $this;
    }

    /**
     * Get controllerPath
     *
     * @return string
     */
    public function getControllerPath()
    {
        return $this->controllerPath;
    }

    /**
     * Set statusFlag
     *
     * @param integer $statusFlag
     *
     * @return SystemActivityMaster
     */
    public function setStatusFlag($statusFlag)
    {
        $this->statusFlag = $statusFlag;

        return $this;
    }

    /**
     * Get statusFlag
     *
     * @return integer
     */
    public function getStatusFlag()
    {
        return $this->statusFlag;
    }

    /**
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return SystemActivityMaster
     */
    public function setApprovalFlag($approvalFlag)
    {
        $this->approvalFlag = $approvalFlag;

        return $this;
    }

    /**
     * Get approvalFlag
     *
     * @return integer
     */
    public function getApprovalFlag()
    {
        return $this->approvalFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return SystemActivityMaster
     */
    public function setRecordActiveFlag($recordActiveFlag)
    {
        $this->recordActiveFlag = $recordActiveFlag;

        return $this;
    }

    /**
     * Get recordActiveFlag
     *
     * @return integer
     */
    public function getRecordActiveFlag()
    {
        return $this->recordActiveFlag;
    }

    /**
     * Set recordInsertDate
     *
     * @param \DateTime $recordInsertDate
     *
     * @return SystemActivityMaster
     */
    public function setRecordInsertDate($recordInsertDate)
    {
        $this->recordInsertDate = $recordInsertDate;

        return $this;
    }

    /**
     * Get recordInsertDate
     *
     * @return \DateTime
     */
    public function getRecordInsertDate()
    {
        return $this->recordInsertDate;
    }

    /**
     * Set recordUpdateDate
     *
     * @param \DateTime $recordUpdateDate
     *
     * @return SystemActivityMaster
     */
    public function setRecordUpdateDate($recordUpdateDate)
    {
        $this->recordUpdateDate = $recordUpdateDate;

        return $this;
    }

    /**
     * Get recordUpdateDate
     *
     * @return \DateTime
     */
    public function getRecordUpdateDate()
    {
        return $this->recordUpdateDate;
    }

    /**
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return SystemActivityMaster
     */
    public function setApplicationUserIpAddress($applicationUserIpAddress)
    {
        $this->applicationUserIpAddress = $applicationUserIpAddress;

        return $this;
    }

    /**
     * Get applicationUserIpAddress
     *
     * @return string
     */
    public function getApplicationUserIpAddress()
    {
        return $this->applicationUserIpAddress;
    }

    /**
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return SystemActivityMaster
     */
    public function setApplicationUserId($applicationUserId)
    {
        $this->applicationUserId = $applicationUserId;

        return $this;
    }

    /**
     * Get applicationUserId
     *
     * @return string
     */
    public function getApplicationUserId()
    {
        return $this->applicationUserId;
    }

    /**
     * Set moduleFk
     *
     * @param \Tashi\CommonBundle\Entity\SystemModuleMaster $moduleFk
     *
     * @return SystemActivityMaster
     */
    public function setModuleFk(\Tashi\CommonBundle\Entity\SystemModuleMaster $moduleFk = null)
    {
        $this->moduleFk = $moduleFk;

        return $this;
    }

    /**
     * Get moduleFk
     *
     * @return \Tashi\CommonBundle\Entity\SystemModuleMaster
     */
    public function getModuleFk()
    {
        return $this->moduleFk;
    }
}
