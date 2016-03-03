<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStatusMaster
 *
 * @ORM\Table(name="user_status_master")
 * @ORM\Entity
 */
class UserStatusMaster
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
     * @ORM\Column(name="Status_Name", type="string", length=45, nullable=true)
     */
    private $statusName;

    /**
     * @var string
     *
     * @ORM\Column(name="Status_color", type="string", length=45, nullable=true)
     */
    private $statusColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_accessible", type="integer", nullable=true)
     */
    private $isAccessible;



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
     * @return UserStatusMaster
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
     * @return UserStatusMaster
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
     * Set isAccessible
     *
     * @param integer $isAccessible
     *
     * @return UserStatusMaster
     */
    public function setIsAccessible($isAccessible)
    {
        $this->isAccessible = $isAccessible;

        return $this;
    }

    /**
     * Get isAccessible
     *
     * @return integer
     */
    public function getIsAccessible()
    {
        return $this->isAccessible;
    }
}
