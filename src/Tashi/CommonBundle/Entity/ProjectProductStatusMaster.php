<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectProductStatusMaster
 *
 * @ORM\Table(name="project_product_status_master")
 * @ORM\Entity
 */
class ProjectProductStatusMaster
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
     * @ORM\Column(name="Status_code", type="integer", nullable=true)
     */
    private $statusCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Status_Name", type="string", length=45, nullable=true)
     */
    private $statusName;

    /**
     * @var string
     *
     * @ORM\Column(name="Status_Color", type="string", length=20, nullable=true)
     */
    private $statusColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_Active_Flag", type="integer", nullable=true)
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
     * Set statusCode
     *
     * @param integer $statusCode
     *
     * @return ProjectProductStatusMaster
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get statusCode
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set statusName
     *
     * @param string $statusName
     *
     * @return ProjectProductStatusMaster
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;

        return $this;
    }

    /**
     * Get statusName
     *
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusName;
    }

    /**
     * Set statusColor
     *
     * @param string $statusColor
     *
     * @return ProjectProductStatusMaster
     */
    public function setStatusColor($statusColor)
    {
        $this->statusColor = $statusColor;

        return $this;
    }

    /**
     * Get statusColor
     *
     * @return string
     */
    public function getStatusColor()
    {
        return $this->statusColor;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ProjectProductStatusMaster
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
