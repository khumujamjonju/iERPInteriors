<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectMaster
 *
 * @ORM\Table(name="project_master", indexes={@ORM\Index(name="fk_project_category_idx", columns={"Area_id_fk"}), @ORM\Index(name="fk_customer_project_idx", columns={"Customer_id_fk"}), @ORM\Index(name="fk_address_project_idx", columns={"Customer_address_fk"}), @ORM\Index(name="fk_coordinator_project_idx", columns={"Site_coordinator"}), @ORM\Index(name="fk_status_project_idx", columns={"Status"}), @ORM\Index(name="fk_industrytype_project_idx", columns={"industry_type_id_fk"}), @ORM\Index(name="fk_opportunity_project_idx", columns={"Opportunity_id_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\ProjectRepository")
 */
class ProjectMaster
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
     * @ORM\Column(name="Order_No", type="string", length=45, nullable=true)
     */
    private $orderNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expected_completion_date", type="date", nullable=true)
     */
    private $expectedCompletionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Completion_date", type="date", nullable=true)
     */
    private $completionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Balance_amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $balanceAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="Amt_limit", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amtLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="Dimension", type="string", length=100, nullable=true)
     */
    private $dimension;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
     */
    private $remarks;

    /**
     * @var string
     *
     * @ORM\Column(name="Total_estimated_cost", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalEstimatedCost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Modify_date", type="datetime", nullable=true)
     */
    private $modifyDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Referrer_name", type="string", length=45, nullable=true)
     */
    private $referrerName;

    /**
     * @var string
     *
     * @ORM\Column(name="Referrer_number", type="string", length=45, nullable=true)
     */
    private $referrerNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Referrer_About", type="string", length=500, nullable=true)
     */
    private $referrerAbout;

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
     * @var string
     *
     * @ORM\Column(name="Custom1", type="string", length=45, nullable=true)
     */
    private $custom1;

    /**
     * @var string
     *
     * @ORM\Column(name="Custom2", type="string", length=45, nullable=true)
     */
    private $custom2;

    /**
     * @var \Tashi\CommonBundle\Entity\CusAddressTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusAddressTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Customer_address_fk", referencedColumnName="Pkid")
     * })
     */
    private $customerAddressFk;

    /**
     * @var \Tashi\CommonBundle\Entity\OpportunityTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\OpportunityTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Opportunity_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $opportunityFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Site_coordinator", referencedColumnName="Employee_Pk")
     * })
     */
    private $siteCoordinator;

    /**
     * @var \Tashi\CommonBundle\Entity\CusCustomer
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Customer_id_fk", referencedColumnName="Customer_Id_Pk")
     * })
     */
    private $customerFk;

    /**
     * @var \Tashi\CommonBundle\Entity\IndustryTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\IndustryTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="industry_type_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $industryTypeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectAreaMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectAreaMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Area_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $areaFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status", referencedColumnName="pkid")
     * })
     */
    private $status;



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
     * Set orderNo
     *
     * @param string $orderNo
     *
     * @return ProjectMaster
     */
    public function setOrderNo($orderNo)
    {
        $this->orderNo = $orderNo;

        return $this;
    }

    /**
     * Get orderNo
     *
     * @return string
     */
    public function getOrderNo()
    {
        return $this->orderNo;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProjectMaster
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return ProjectMaster
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
     * Set expectedCompletionDate
     *
     * @param \DateTime $expectedCompletionDate
     *
     * @return ProjectMaster
     */
    public function setExpectedCompletionDate($expectedCompletionDate)
    {
        $this->expectedCompletionDate = $expectedCompletionDate;

        return $this;
    }

    /**
     * Get expectedCompletionDate
     *
     * @return \DateTime
     */
    public function getExpectedCompletionDate()
    {
        return $this->expectedCompletionDate;
    }

    /**
     * Set completionDate
     *
     * @param \DateTime $completionDate
     *
     * @return ProjectMaster
     */
    public function setCompletionDate($completionDate)
    {
        $this->completionDate = $completionDate;

        return $this;
    }

    /**
     * Get completionDate
     *
     * @return \DateTime
     */
    public function getCompletionDate()
    {
        return $this->completionDate;
    }

    /**
     * Set balanceAmount
     *
     * @param string $balanceAmount
     *
     * @return ProjectMaster
     */
    public function setBalanceAmount($balanceAmount)
    {
        $this->balanceAmount = $balanceAmount;

        return $this;
    }

    /**
     * Get balanceAmount
     *
     * @return string
     */
    public function getBalanceAmount()
    {
        return $this->balanceAmount;
    }

    /**
     * Set amtLimit
     *
     * @param string $amtLimit
     *
     * @return ProjectMaster
     */
    public function setAmtLimit($amtLimit)
    {
        $this->amtLimit = $amtLimit;

        return $this;
    }

    /**
     * Get amtLimit
     *
     * @return string
     */
    public function getAmtLimit()
    {
        return $this->amtLimit;
    }

    /**
     * Set dimension
     *
     * @param string $dimension
     *
     * @return ProjectMaster
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return string
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return ProjectMaster
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set totalEstimatedCost
     *
     * @param string $totalEstimatedCost
     *
     * @return ProjectMaster
     */
    public function setTotalEstimatedCost($totalEstimatedCost)
    {
        $this->totalEstimatedCost = $totalEstimatedCost;

        return $this;
    }

    /**
     * Get totalEstimatedCost
     *
     * @return string
     */
    public function getTotalEstimatedCost()
    {
        return $this->totalEstimatedCost;
    }

    /**
     * Set modifyDate
     *
     * @param \DateTime $modifyDate
     *
     * @return ProjectMaster
     */
    public function setModifyDate($modifyDate)
    {
        $this->modifyDate = $modifyDate;

        return $this;
    }

    /**
     * Get modifyDate
     *
     * @return \DateTime
     */
    public function getModifyDate()
    {
        return $this->modifyDate;
    }

    /**
     * Set referrerName
     *
     * @param string $referrerName
     *
     * @return ProjectMaster
     */
    public function setReferrerName($referrerName)
    {
        $this->referrerName = $referrerName;

        return $this;
    }

    /**
     * Get referrerName
     *
     * @return string
     */
    public function getReferrerName()
    {
        return $this->referrerName;
    }

    /**
     * Set referrerNumber
     *
     * @param string $referrerNumber
     *
     * @return ProjectMaster
     */
    public function setReferrerNumber($referrerNumber)
    {
        $this->referrerNumber = $referrerNumber;

        return $this;
    }

    /**
     * Get referrerNumber
     *
     * @return string
     */
    public function getReferrerNumber()
    {
        return $this->referrerNumber;
    }

    /**
     * Set referrerAbout
     *
     * @param string $referrerAbout
     *
     * @return ProjectMaster
     */
    public function setReferrerAbout($referrerAbout)
    {
        $this->referrerAbout = $referrerAbout;

        return $this;
    }

    /**
     * Get referrerAbout
     *
     * @return string
     */
    public function getReferrerAbout()
    {
        return $this->referrerAbout;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ProjectMaster
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
     * @return ProjectMaster
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
     * @return ProjectMaster
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
     * @return ProjectMaster
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
     * @return ProjectMaster
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
     * @return ProjectMaster
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
     * @return ProjectMaster
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
     * Set custom1
     *
     * @param string $custom1
     *
     * @return ProjectMaster
     */
    public function setCustom1($custom1)
    {
        $this->custom1 = $custom1;

        return $this;
    }

    /**
     * Get custom1
     *
     * @return string
     */
    public function getCustom1()
    {
        return $this->custom1;
    }

    /**
     * Set custom2
     *
     * @param string $custom2
     *
     * @return ProjectMaster
     */
    public function setCustom2($custom2)
    {
        $this->custom2 = $custom2;

        return $this;
    }

    /**
     * Get custom2
     *
     * @return string
     */
    public function getCustom2()
    {
        return $this->custom2;
    }

    /**
     * Set customerAddressFk
     *
     * @param \Tashi\CommonBundle\Entity\CusAddressTxn $customerAddressFk
     *
     * @return ProjectMaster
     */
    public function setCustomerAddressFk(\Tashi\CommonBundle\Entity\CusAddressTxn $customerAddressFk = null)
    {
        $this->customerAddressFk = $customerAddressFk;

        return $this;
    }

    /**
     * Get customerAddressFk
     *
     * @return \Tashi\CommonBundle\Entity\CusAddressTxn
     */
    public function getCustomerAddressFk()
    {
        return $this->customerAddressFk;
    }

    /**
     * Set opportunityFk
     *
     * @param \Tashi\CommonBundle\Entity\OpportunityTypeMaster $opportunityFk
     *
     * @return ProjectMaster
     */
    public function setOpportunityFk(\Tashi\CommonBundle\Entity\OpportunityTypeMaster $opportunityFk = null)
    {
        $this->opportunityFk = $opportunityFk;

        return $this;
    }

    /**
     * Get opportunityFk
     *
     * @return \Tashi\CommonBundle\Entity\OpportunityTypeMaster
     */
    public function getOpportunityFk()
    {
        return $this->opportunityFk;
    }

    /**
     * Set siteCoordinator
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $siteCoordinator
     *
     * @return ProjectMaster
     */
    public function setSiteCoordinator(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $siteCoordinator = null)
    {
        $this->siteCoordinator = $siteCoordinator;

        return $this;
    }

    /**
     * Get siteCoordinator
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getSiteCoordinator()
    {
        return $this->siteCoordinator;
    }

    /**
     * Set customerFk
     *
     * @param \Tashi\CommonBundle\Entity\CusCustomer $customerFk
     *
     * @return ProjectMaster
     */
    public function setCustomerFk(\Tashi\CommonBundle\Entity\CusCustomer $customerFk = null)
    {
        $this->customerFk = $customerFk;

        return $this;
    }

    /**
     * Get customerFk
     *
     * @return \Tashi\CommonBundle\Entity\CusCustomer
     */
    public function getCustomerFk()
    {
        return $this->customerFk;
    }

    /**
     * Set industryTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\IndustryTypeMaster $industryTypeFk
     *
     * @return ProjectMaster
     */
    public function setIndustryTypeFk(\Tashi\CommonBundle\Entity\IndustryTypeMaster $industryTypeFk = null)
    {
        $this->industryTypeFk = $industryTypeFk;

        return $this;
    }

    /**
     * Get industryTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\IndustryTypeMaster
     */
    public function getIndustryTypeFk()
    {
        return $this->industryTypeFk;
    }

    /**
     * Set areaFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectAreaMaster $areaFk
     *
     * @return ProjectMaster
     */
    public function setAreaFk(\Tashi\CommonBundle\Entity\ProjectAreaMaster $areaFk = null)
    {
        $this->areaFk = $areaFk;

        return $this;
    }

    /**
     * Get areaFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectAreaMaster
     */
    public function getAreaFk()
    {
        return $this->areaFk;
    }

    /**
     * Set status
     *
     * @param \Tashi\CommonBundle\Entity\ProjectStatusMaster $status
     *
     * @return ProjectMaster
     */
    public function setStatus(\Tashi\CommonBundle\Entity\ProjectStatusMaster $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Tashi\CommonBundle\Entity\ProjectStatusMaster
     */
    public function getStatus()
    {
        return $this->status;
    }
}
