<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGroupTxn
 *
 * @ORM\Table(name="user_group_txn", indexes={@ORM\Index(name="fk_group_usergrptxn_idx", columns={"Group_id_fk"}), @ORM\Index(name="fk_user_usergrptxn_idx", columns={"User_id_fk"})})
 * @ORM\Entity
 */
class UserGroupTxn
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
     * @var \Tashi\CommonBundle\Entity\UserTbl
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\UserTbl")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_id_fk", referencedColumnName="User_Id_Pk")
     * })
     */
    private $userFk;

    /**
     * @var \Tashi\CommonBundle\Entity\UserGroupMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\UserGroupMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Group_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $groupFk;



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
     * @return UserGroupTxn
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
     * @return UserGroupTxn
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
     * @return UserGroupTxn
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
     * @return UserGroupTxn
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
     * @return UserGroupTxn
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
     * @return UserGroupTxn
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
     * Set userFk
     *
     * @param \Tashi\CommonBundle\Entity\UserTbl $userFk
     *
     * @return UserGroupTxn
     */
    public function setUserFk(\Tashi\CommonBundle\Entity\UserTbl $userFk = null)
    {
        $this->userFk = $userFk;

        return $this;
    }

    /**
     * Get userFk
     *
     * @return \Tashi\CommonBundle\Entity\UserTbl
     */
    public function getUserFk()
    {
        return $this->userFk;
    }

    /**
     * Set groupFk
     *
     * @param \Tashi\CommonBundle\Entity\UserGroupMaster $groupFk
     *
     * @return UserGroupTxn
     */
    public function setGroupFk(\Tashi\CommonBundle\Entity\UserGroupMaster $groupFk = null)
    {
        $this->groupFk = $groupFk;

        return $this;
    }

    /**
     * Get groupFk
     *
     * @return \Tashi\CommonBundle\Entity\UserGroupMaster
     */
    public function getGroupFk()
    {
        return $this->groupFk;
    }
}
