<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpAssetAssignTxn
 *
 * @ORM\Table(name="emp_asset_assign_txn", indexes={@ORM\Index(name="fk_emp_master_idx", columns={"Emp_Master_Fk"}), @ORM\Index(name="fk_worker_expert_idx", columns={"Asset_Register_Fk"}), @ORM\Index(name="fk_asser_category_fk_idx", columns={"Asset_Category_Fk"})})
 * @ORM\Entity
 */
class EmpAssetAssignTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Asset_Assign_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $assetAssignPk;

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
     * @var \Tashi\CommonBundle\Entity\AssetMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AssetMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Asset_Register_Fk", referencedColumnName="Asset_Register_Pk")
     * })
     */
    private $assetRegisterFk;

    /**
     * @var \Tashi\CommonBundle\Entity\AssetCategoryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AssetCategoryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Asset_Category_Fk", referencedColumnName="Asset_Master_Pk")
     * })
     */
    private $assetCategoryFk;

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
     * Get assetAssignPk
     *
     * @return integer
     */
    public function getAssetAssignPk()
    {
        return $this->assetAssignPk;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * @return EmpAssetAssignTxn
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
     * Set assetRegisterFk
     *
     * @param \Tashi\CommonBundle\Entity\AssetMaster $assetRegisterFk
     *
     * @return EmpAssetAssignTxn
     */
    public function setAssetRegisterFk(\Tashi\CommonBundle\Entity\AssetMaster $assetRegisterFk = null)
    {
        $this->assetRegisterFk = $assetRegisterFk;

        return $this;
    }

    /**
     * Get assetRegisterFk
     *
     * @return \Tashi\CommonBundle\Entity\AssetMaster
     */
    public function getAssetRegisterFk()
    {
        return $this->assetRegisterFk;
    }

    /**
     * Set assetCategoryFk
     *
     * @param \Tashi\CommonBundle\Entity\AssetCategoryMaster $assetCategoryFk
     *
     * @return EmpAssetAssignTxn
     */
    public function setAssetCategoryFk(\Tashi\CommonBundle\Entity\AssetCategoryMaster $assetCategoryFk = null)
    {
        $this->assetCategoryFk = $assetCategoryFk;

        return $this;
    }

    /**
     * Get assetCategoryFk
     *
     * @return \Tashi\CommonBundle\Entity\AssetCategoryMaster
     */
    public function getAssetCategoryFk()
    {
        return $this->assetCategoryFk;
    }

    /**
     * Set empMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk
     *
     * @return EmpAssetAssignTxn
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
