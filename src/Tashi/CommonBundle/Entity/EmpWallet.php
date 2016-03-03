<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpWallet
 *
 * @ORM\Table(name="emp_wallet", indexes={@ORM\Index(name="hr_emp_type_id_idx", columns={"Emp_Fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\WalletRepository")
 */
class EmpWallet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Emp_Wallet_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $empWalletPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Wallet_Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $walletAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Assign_Date", type="date", nullable=true)
     */
    private $assignDate;

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
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_Fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $empFk;



    /**
     * Get empWalletPk
     *
     * @return integer
     */
    public function getEmpWalletPk()
    {
        return $this->empWalletPk;
    }

    /**
     * Set walletAmount
     *
     * @param string $walletAmount
     *
     * @return EmpWallet
     */
    public function setWalletAmount($walletAmount)
    {
        $this->walletAmount = $walletAmount;

        return $this;
    }

    /**
     * Get walletAmount
     *
     * @return string
     */
    public function getWalletAmount()
    {
        return $this->walletAmount;
    }

    /**
     * Set assignDate
     *
     * @param \DateTime $assignDate
     *
     * @return EmpWallet
     */
    public function setAssignDate($assignDate)
    {
        $this->assignDate = $assignDate;

        return $this;
    }

    /**
     * Get assignDate
     *
     * @return \DateTime
     */
    public function getAssignDate()
    {
        return $this->assignDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpWallet
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
     * @return EmpWallet
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
     * @return EmpWallet
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
     * @return EmpWallet
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
     * @return EmpWallet
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
     * @return EmpWallet
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
     * @return EmpWallet
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
     * Set empFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empFk
     *
     * @return EmpWallet
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
}
