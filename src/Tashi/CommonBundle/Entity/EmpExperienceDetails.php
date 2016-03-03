<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpExperienceDetails
 *
 * @ORM\Table(name="emp_experience_details", indexes={@ORM\Index(name="fk_experience_emp_idx", columns={"Emp_Master_Fk"})})
 * @ORM\Entity
 */
class EmpExperienceDetails
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Experience_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $experiencePk;

    /**
     * @var string
     *
     * @ORM\Column(name="Experience_Details", type="string", length=1500, nullable=true)
     */
    private $experienceDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Start_Date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="End_Date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Year_Of_Experience", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $yearOfExperience;

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_Active_Flag", type="integer", nullable=false)
     */
    private $recordActiveFlag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Insert_Date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Update_Date", type="datetime", nullable=true)
     */
    private $recordUpdateDate;

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
     * @var integer
     *
     * @ORM\Column(name="Branch_Office_Code", type="integer", nullable=true)
     */
    private $branchOfficeCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_Master_Fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $empMasterFk;



    /**
     * Get experiencePk
     *
     * @return integer
     */
    public function getExperiencePk()
    {
        return $this->experiencePk;
    }

    /**
     * Set experienceDetails
     *
     * @param string $experienceDetails
     *
     * @return EmpExperienceDetails
     */
    public function setExperienceDetails($experienceDetails)
    {
        $this->experienceDetails = $experienceDetails;

        return $this;
    }

    /**
     * Get experienceDetails
     *
     * @return string
     */
    public function getExperienceDetails()
    {
        return $this->experienceDetails;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return EmpExperienceDetails
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return EmpExperienceDetails
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set yearOfExperience
     *
     * @param string $yearOfExperience
     *
     * @return EmpExperienceDetails
     */
    public function setYearOfExperience($yearOfExperience)
    {
        $this->yearOfExperience = $yearOfExperience;

        return $this;
    }

    /**
     * Get yearOfExperience
     *
     * @return string
     */
    public function getYearOfExperience()
    {
        return $this->yearOfExperience;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpExperienceDetails
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
     * @return EmpExperienceDetails
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
     * @return EmpExperienceDetails
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
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return EmpExperienceDetails
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
     * @return EmpExperienceDetails
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return EmpExperienceDetails
     */
    public function setBranchOfficeCode($branchOfficeCode)
    {
        $this->branchOfficeCode = $branchOfficeCode;

        return $this;
    }

    /**
     * Get branchOfficeCode
     *
     * @return integer
     */
    public function getBranchOfficeCode()
    {
        return $this->branchOfficeCode;
    }

    /**
     * Set companyCode
     *
     * @param integer $companyCode
     *
     * @return EmpExperienceDetails
     */
    public function setCompanyCode($companyCode)
    {
        $this->companyCode = $companyCode;

        return $this;
    }

    /**
     * Get companyCode
     *
     * @return integer
     */
    public function getCompanyCode()
    {
        return $this->companyCode;
    }

    /**
     * Set empMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk
     *
     * @return EmpExperienceDetails
     */
    public function setEmpMasterFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk = null)
    {
        $this->empMasterFk = $empMasterFk;

        return $this;
    }

    /**
     * Get empMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getEmpMasterFk()
    {
        return $this->empMasterFk;
    }
}
