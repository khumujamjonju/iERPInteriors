<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolSanctionSalarySlip
 *
 * @ORM\Table(name="payrol_sanction_salary_slip", indexes={@ORM\Index(name="fk_sanction_salary_slip_idx", columns={"salary_slip_fk"}), @ORM\Index(name="fk_sanction_salary_id_idx", columns={"sanction_key_id_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\AccountRepository")
 */
class PayrolSanctionSalarySlip 
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
     * @ORM\Column(name="Record_Active_Flag", type="integer", nullable=true)
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
     * @var \Tashi\CommonBundle\Entity\PayrolSanctionSalaryId
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PayrolSanctionSalaryId")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sanction_key_id_fk", referencedColumnName="pkid")
     * })
     */
    private $sanctionKeyFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PayrolSalarySlip
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PayrolSalarySlip")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="salary_slip_fk", referencedColumnName="Salary_Slip_Pk")
     * })
     */
    private $salarySlipFk;



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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolSanctionSalarySlip
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
     * @return PayrolSanctionSalarySlip
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
     * @return PayrolSanctionSalarySlip
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
     * @return PayrolSanctionSalarySlip
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
     * @return PayrolSanctionSalarySlip
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
     * @return PayrolSanctionSalarySlip
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
     * @return PayrolSanctionSalarySlip
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
     * Set sanctionKeyFk
     *
     * @param \Tashi\CommonBundle\Entity\PayrolSanctionSalaryId $sanctionKeyFk
     *
     * @return PayrolSanctionSalarySlip
     */
    public function setSanctionKeyFk(\Tashi\CommonBundle\Entity\PayrolSanctionSalaryId $sanctionKeyFk = null)
    {
        $this->sanctionKeyFk = $sanctionKeyFk;

        return $this;
    }

    /**
     * Get sanctionKeyFk
     *
     * @return \Tashi\CommonBundle\Entity\PayrolSanctionSalaryId
     */
    public function getSanctionKeyFk()
    {
        return $this->sanctionKeyFk;
    }

    /**
     * Set salarySlipFk
     *
     * @param \Tashi\CommonBundle\Entity\PayrolSalarySlip $salarySlipFk
     *
     * @return PayrolSanctionSalarySlip
     */
    public function setSalarySlipFk(\Tashi\CommonBundle\Entity\PayrolSalarySlip $salarySlipFk = null)
    {
        $this->salarySlipFk = $salarySlipFk;

        return $this;
    }

    /**
     * Get salarySlipFk
     *
     * @return \Tashi\CommonBundle\Entity\PayrolSalarySlip
     */
    public function getSalarySlipFk()
    {
        return $this->salarySlipFk;
    }
}
