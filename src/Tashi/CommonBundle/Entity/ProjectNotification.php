<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectNotification
 *
 * @ORM\Table(name="project_notification", indexes={@ORM\Index(name="fk_project_notification", columns={"Project_id_fk"}), @ORM\Index(name="fk_employee_notification", columns={"Emp_id_fk"})})
 * @ORM\Entity
 */
class ProjectNotification
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
     * @ORM\Column(name="Record_insert_date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_id_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $empFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $projectFk;



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
     * Set recordInsertDate
     *
     * @param \DateTime $recordInsertDate
     *
     * @return ProjectNotification
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
     * Set empFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empFk
     *
     * @return ProjectNotification
     */
    public function setEmpFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $empFk = null)
    {
        $this->empFk = $empFk;

        return $this;
    }

    /**
     * Get empFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getEmpFk()
    {
        return $this->empFk;
    }

    /**
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return ProjectNotification
     */
    public function setProjectFk(\Tashi\CommonBundle\Entity\ProjectMaster $projectFk = null)
    {
        $this->projectFk = $projectFk;

        return $this;
    }

    /**
     * Get projectFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectMaster
     */
    public function getProjectFk()
    {
        return $this->projectFk;
    }
}
