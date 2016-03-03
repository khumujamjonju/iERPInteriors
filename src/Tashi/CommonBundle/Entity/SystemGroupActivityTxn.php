<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SystemGroupActivityTxn
 *
 * @ORM\Table(name="system_group_activity_txn", indexes={@ORM\Index(name="fk_group_grpacttxn_idx", columns={"User_Group_Id_Fk"}), @ORM\Index(name="fk_activity_grpacttxn_idx", columns={"Activity_Id_Fk"})})
 * @ORM\Entity
 */
class SystemGroupActivityTxn
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
     * @var \Tashi\CommonBundle\Entity\SystemActivityMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SystemActivityMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Activity_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $activityFk;

    /**
     * @var \Tashi\CommonBundle\Entity\UserGroupMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\UserGroupMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_Group_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $userGroupFk;



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
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return SystemGroupActivityTxn
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
     * @return SystemGroupActivityTxn
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
     * @return SystemGroupActivityTxn
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
     * @return SystemGroupActivityTxn
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
     * @return SystemGroupActivityTxn
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
     * @return SystemGroupActivityTxn
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
     * Set activityFk
     *
     * @param \Tashi\CommonBundle\Entity\SystemActivityMaster $activityFk
     *
     * @return SystemGroupActivityTxn
     */
    public function setActivityFk(\Tashi\CommonBundle\Entity\SystemActivityMaster $activityFk = null)
    {
        $this->activityFk = $activityFk;

        return $this;
    }

    /**
     * Get activityFk
     *
     * @return \Tashi\CommonBundle\Entity\SystemActivityMaster
     */
    public function getActivityFk()
    {
        return $this->activityFk;
    }

    /**
     * Set userGroupFk
     *
     * @param \Tashi\CommonBundle\Entity\UserGroupMaster $userGroupFk
     *
     * @return SystemGroupActivityTxn
     */
    public function setUserGroupFk(\Tashi\CommonBundle\Entity\UserGroupMaster $userGroupFk = null)
    {
        $this->userGroupFk = $userGroupFk;

        return $this;
    }

    /**
     * Get userGroupFk
     *
     * @return \Tashi\CommonBundle\Entity\UserGroupMaster
     */
    public function getUserGroupFk()
    {
        return $this->userGroupFk;
    }
}
