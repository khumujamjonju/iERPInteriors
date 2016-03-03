<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserActivityLog
 *
 * @ORM\Table(name="user_activity_log", indexes={@ORM\Index(name="fk_user_activity_idx", columns={"User_id_fk"})})
 * @ORM\Entity
 */
class UserActivityLog
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
     * @ORM\Column(name="Activity", type="string", length=500, nullable=true)
     */
    private $activity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Activity_date", type="datetime", nullable=true)
     */
    private $activityDate;

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
     * Get pkid
     *
     * @return integer
     */
    public function getPkid()
    {
        return $this->pkid;
    }

    /**
     * Set activity
     *
     * @param string $activity
     *
     * @return UserActivityLog
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set activityDate
     *
     * @param \DateTime $activityDate
     *
     * @return UserActivityLog
     */
    public function setActivityDate($activityDate)
    {
        $this->activityDate = $activityDate;

        return $this;
    }

    /**
     * Get activityDate
     *
     * @return \DateTime
     */
    public function getActivityDate()
    {
        return $this->activityDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return UserActivityLog
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
     * @return UserActivityLog
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
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return UserActivityLog
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
     * @return UserActivityLog
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
     * @return UserActivityLog
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
}
