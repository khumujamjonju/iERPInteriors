<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectDailyReport
 *
 * @ORM\Table(name="project_daily_report", indexes={@ORM\Index(name="fk_proj_item_dailyrpt_idx", columns={"Project_item_id_fk"}), @ORM\Index(name="fk_status_dailyrpt_idx", columns={"Status_fk"}), @ORM\Index(name="fk_document_dailyrpt_idx", columns={"document_id_fk"})})
 * @ORM\Entity
 */
class ProjectDailyReport
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
     * @ORM\Column(name="Report", type="string", length=1000, nullable=true)
     */
    private $report;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Report_date", type="datetime", nullable=true)
     */
    private $reportDate;

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
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="document_id_fk", referencedColumnName="pkid")
     * })
     */
    private $documentFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectItemTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectItemTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_item_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $projectItemFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectItemStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectItemStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_fk", referencedColumnName="pkid")
     * })
     */
    private $statusFk;



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
     * Set report
     *
     * @param string $report
     *
     * @return ProjectDailyReport
     */
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return string
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set reportDate
     *
     * @param \DateTime $reportDate
     *
     * @return ProjectDailyReport
     */
    public function setReportDate($reportDate)
    {
        $this->reportDate = $reportDate;

        return $this;
    }

    /**
     * Get reportDate
     *
     * @return \DateTime
     */
    public function getReportDate()
    {
        return $this->reportDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * @return ProjectDailyReport
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
     * Set documentFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $documentFk
     *
     * @return ProjectDailyReport
     */
    public function setDocumentFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $documentFk = null)
    {
        $this->documentFk = $documentFk;

        return $this;
    }

    /**
     * Get documentFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getDocumentFk()
    {
        return $this->documentFk;
    }

    /**
     * Set projectItemFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectItemTxn $projectItemFk
     *
     * @return ProjectDailyReport
     */
    public function setProjectItemFk(\Tashi\CommonBundle\Entity\ProjectItemTxn $projectItemFk = null)
    {
        $this->projectItemFk = $projectItemFk;

        return $this;
    }

    /**
     * Get projectItemFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectItemTxn
     */
    public function getProjectItemFk()
    {
        return $this->projectItemFk;
    }

    /**
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectItemStatusMaster $statusFk
     *
     * @return ProjectDailyReport
     */
    public function setStatusFk(\Tashi\CommonBundle\Entity\ProjectItemStatusMaster $statusFk = null)
    {
        $this->statusFk = $statusFk;

        return $this;
    }

    /**
     * Get statusFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectItemStatusMaster
     */
    public function getStatusFk()
    {
        return $this->statusFk;
    }
}
