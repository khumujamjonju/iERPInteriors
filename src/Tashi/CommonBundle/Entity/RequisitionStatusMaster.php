<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequisitionStatusMaster
 *
 * @ORM\Table(name="requisition_status_master")
 * @ORM\Entity
 */
class RequisitionStatusMaster
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
     * @ORM\Column(name="status_msg", type="string", length=45, nullable=true)
     */
    private $statusMsg;

    /**
     * @var string
     *
     * @ORM\Column(name="status_color", type="string", length=45, nullable=true)
     */
    private $statusColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_completed", type="integer", nullable=true)
     */
    private $isCompleted;



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
     * Set statusMsg
     *
     * @param string $statusMsg
     *
     * @return RequisitionStatusMaster
     */
    public function setStatusMsg($statusMsg)
    {
        $this->statusMsg = $statusMsg;

        return $this;
    }

    /**
     * Get statusMsg
     *
     * @return string
     */
    public function getStatusMsg()
    {
        return $this->statusMsg;
    }

    /**
     * Set statusColor
     *
     * @param string $statusColor
     *
     * @return RequisitionStatusMaster
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
     * Set isCompleted
     *
     * @param integer $isCompleted
     *
     * @return RequisitionStatusMaster
     */
    public function setIsCompleted($isCompleted)
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * Get isCompleted
     *
     * @return integer
     */
    public function getIsCompleted()
    {
        return $this->isCompleted;
    }
}
