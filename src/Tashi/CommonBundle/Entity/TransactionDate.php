<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TransactionDate
 *
 * @ORM\Table(name="transaction_date")
 * @ORM\Entity
 */
class TransactionDate
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
     * @ORM\Column(name="Employee_Id", type="integer", nullable=true)
     */
    private $employeeId;

    /**
     * @var string
     *
     * @ORM\Column(name="Module_Id", type="string", length=11, nullable=true)
     */
    private $moduleId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Last_Selected_date", type="date", nullable=true)
     */
    private $lastSelectedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_insert_date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_update_date", type="datetime", nullable=true)
     */
    private $recordUpdateDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_active_flag", type="integer", nullable=true)
     */
    private $recordActiveFlag;



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
     * Set employeeId
     *
     * @param integer $employeeId
     *
     * @return TransactionDate
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    /**
     * Get employeeId
     *
     * @return integer
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Set moduleId
     *
     * @param string $moduleId
     *
     * @return TransactionDate
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;

        return $this;
    }

    /**
     * Get moduleId
     *
     * @return string
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * Set lastSelectedDate
     *
     * @param \DateTime $lastSelectedDate
     *
     * @return TransactionDate
     */
    public function setLastSelectedDate($lastSelectedDate)
    {
        $this->lastSelectedDate = $lastSelectedDate;

        return $this;
    }

    /**
     * Get lastSelectedDate
     *
     * @return \DateTime
     */
    public function getLastSelectedDate()
    {
        return $this->lastSelectedDate;
    }

    /**
     * Set recordInsertDate
     *
     * @param \DateTime $recordInsertDate
     *
     * @return TransactionDate
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
     * @return TransactionDate
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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return TransactionDate
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
}
