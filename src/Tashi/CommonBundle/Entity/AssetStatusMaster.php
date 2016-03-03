<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetStatusMaster
 *
 * @ORM\Table(name="asset_status_master")
 * @ORM\Entity
 */
class AssetStatusMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkid;

    /**
     * @var integer
     *
     * @ORM\Column(name="status_code", type="integer", nullable=false)
     */
    private $statusCode;

    /**
     * @var string
     *
     * @ORM\Column(name="status_name", type="string", length=45, nullable=true)
     */
    private $statusName;

    /**
     * @var string
     *
     * @ORM\Column(name="status_color", type="string", length=10, nullable=true)
     */
    private $statusColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_manually_updatable", type="integer", nullable=true)
     */
    private $isManuallyUpdatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Recoverable", type="integer", nullable=true)
     */
    private $isRecoverable;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Returnable", type="integer", nullable=true)
     */
    private $isReturnable;



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
     * @return AssetStatusMaster
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
     * @return AssetStatusMaster
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
     * @return AssetStatusMaster
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
     * Set isManuallyUpdatable
     *
     * @param integer $isManuallyUpdatable
     *
     * @return AssetStatusMaster
     */
    public function setIsManuallyUpdatable($isManuallyUpdatable)
    {
        $this->isManuallyUpdatable = $isManuallyUpdatable;

        return $this;
    }

    /**
     * Get isManuallyUpdatable
     *
     * @return integer
     */
    public function getIsManuallyUpdatable()
    {
        return $this->isManuallyUpdatable;
    }

    /**
     * Set isRecoverable
     *
     * @param integer $isRecoverable
     *
     * @return AssetStatusMaster
     */
    public function setIsRecoverable($isRecoverable)
    {
        $this->isRecoverable = $isRecoverable;

        return $this;
    }

    /**
     * Get isRecoverable
     *
     * @return integer
     */
    public function getIsRecoverable()
    {
        return $this->isRecoverable;
    }

    /**
     * Set isReturnable
     *
     * @param integer $isReturnable
     *
     * @return AssetStatusMaster
     */
    public function setIsReturnable($isReturnable)
    {
        $this->isReturnable = $isReturnable;

        return $this;
    }

    /**
     * Get isReturnable
     *
     * @return integer
     */
    public function getIsReturnable()
    {
        return $this->isReturnable;
    }
}
