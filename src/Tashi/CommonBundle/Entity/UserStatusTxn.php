<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStatusTxn
 *
 * @ORM\Table(name="user_status_txn", indexes={@ORM\Index(name="fk_user_userstatus_idx", columns={"User_id_fk"}), @ORM\Index(name="fk_status_userstatus_idx", columns={"Status_id_fk"})})
 * @ORM\Entity
 */
class UserStatusTxn
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
     * @var \DateTime
     *
     * @ORM\Column(name="Status_date", type="date", nullable=true)
     */
    private $statusDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
     */
    private $remarks;

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_active_flag", type="integer", nullable=true)
     */
    private $recordActiveFlag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_insert_date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \Tashi\CommonBundle\Entity\UserStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\UserStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $statusFk;

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
     * Set statusDate
     *
     * @param \DateTime $statusDate
     *
     * @return UserStatusTxn
     */
    public function setStatusDate($statusDate)
    {
        $this->statusDate = $statusDate;

        return $this;
    }

    /**
     * Get statusDate
     *
     * @return \DateTime
     */
    public function getStatusDate()
    {
        return $this->statusDate;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return UserStatusTxn
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return UserStatusTxn
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
     * @return UserStatusTxn
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
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\UserStatusMaster $statusFk
     *
     * @return UserStatusTxn
     */
    public function setStatusFk(\Tashi\CommonBundle\Entity\UserStatusMaster $statusFk = null)
    {
        $this->statusFk = $statusFk;

        return $this;
    }

    /**
     * Get statusFk
     *
     * @return \Tashi\CommonBundle\Entity\UserStatusMaster
     */
    public function getStatusFk()
    {
        return $this->statusFk;
    }

    /**
     * Set userFk
     *
     * @param \Tashi\CommonBundle\Entity\UserTbl $userFk
     *
     * @return UserStatusTxn
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
