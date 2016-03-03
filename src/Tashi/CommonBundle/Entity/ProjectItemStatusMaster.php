<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectItemStatusMaster
 *
 * @ORM\Table(name="project_item_status_master")
 * @ORM\Entity
 */
class ProjectItemStatusMaster
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
     * @var string
     *
     * @ORM\Column(name="status_name", type="string", length=45, nullable=true)
     */
    private $statusName;

    /**
     * @var string
     *
     * @ORM\Column(name="status_color", type="string", length=45, nullable=true)
     */
    private $statusColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_changeable", type="integer", nullable=true)
     */
    private $isChangeable;



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
     * Set statusName
     *
     * @param string $statusName
     *
     * @return ProjectItemStatusMaster
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
     * @return ProjectItemStatusMaster
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
     * Set isChangeable
     *
     * @param integer $isChangeable
     *
     * @return ProjectItemStatusMaster
     */
    public function setIsChangeable($isChangeable)
    {
        $this->isChangeable = $isChangeable;

        return $this;
    }

    /**
     * Get isChangeable
     *
     * @return integer
     */
    public function getIsChangeable()
    {
        return $this->isChangeable;
    }
}
