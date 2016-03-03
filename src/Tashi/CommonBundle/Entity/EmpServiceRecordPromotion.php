<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpServiceRecordPromotion
 *
 * @ORM\Table(name="emp_service_record_promotion", indexes={@ORM\Index(name="fk_employee_promo", columns={"employee_id_fk"}), @ORM\Index(name="fk_designation_promo", columns={"designation_id_fk"})})
 * @ORM\Entity
 */
class EmpServiceRecordPromotion
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
     * @var \DateTime
     *
     * @ORM\Column(name="joining_date", type="date", nullable=true)
     */
    private $joiningDate;

    /**
     * @var string
     *
     * @ORM\Column(name="promotion_flag", type="string", length=20, nullable=true)
     */
    private $promotionFlag;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpJobTitleMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpJobTitleMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="designation_id_fk", referencedColumnName="Job_Title_Pk")
     * })
     */
    private $designationFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_id_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $employeeFk;



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
     * Set joiningDate
     *
     * @param \DateTime $joiningDate
     *
     * @return EmpServiceRecordPromotion
     */
    public function setJoiningDate($joiningDate)
    {
        $this->joiningDate = $joiningDate;

        return $this;
    }

    /**
     * Get joiningDate
     *
     * @return \DateTime
     */
    public function getJoiningDate()
    {
        return $this->joiningDate;
    }

    /**
     * Set promotionFlag
     *
     * @param string $promotionFlag
     *
     * @return EmpServiceRecordPromotion
     */
    public function setPromotionFlag($promotionFlag)
    {
        $this->promotionFlag = $promotionFlag;

        return $this;
    }

    /**
     * Get promotionFlag
     *
     * @return string
     */
    public function getPromotionFlag()
    {
        return $this->promotionFlag;
    }

    /**
     * Set designationFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpJobTitleMaster $designationFk
     *
     * @return EmpServiceRecordPromotion
     */
    public function setDesignationFk(\Tashi\CommonBundle\Entity\EmpJobTitleMaster $designationFk = null)
    {
        $this->designationFk = $designationFk;

        return $this;
    }

    /**
     * Get designationFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpJobTitleMaster
     */
    public function getDesignationFk()
    {
        return $this->designationFk;
    }

    /**
     * Set employeeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk
     *
     * @return EmpServiceRecordPromotion
     */
    public function setEmployeeFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk = null)
    {
        $this->employeeFk = $employeeFk;

        return $this;
    }

    /**
     * Get employeeFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getEmployeeFk()
    {
        return $this->employeeFk;
    }
}
