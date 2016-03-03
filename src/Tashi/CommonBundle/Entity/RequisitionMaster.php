<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequisitionMaster
 *
 * @ORM\Table(name="requisition_master", uniqueConstraints={@ORM\UniqueConstraint(name="Pkid_UNIQUE", columns={"Pkid"})}, indexes={@ORM\Index(name="FK_Status_idx", columns={"ReqStatus_fk"}), @ORM\Index(name="FK_EMP_idx", columns={"Employee_id_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\RequisitionMasterRepository")
 */
class RequisitionMaster
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
     * @ORM\Column(name="UI_REQ_ID", type="string", length=45, nullable=true)
     */
    private $uiReqId;

    /**
     * @var string
     *
     * @ORM\Column(name="requisition_Details", type="string", length=400, nullable=true)
     */
    private $requisitionDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="requisition_Date", type="date", nullable=true)
     */
    private $requisitionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expected_Delivery", type="date", nullable=true)
     */
    private $expectedDelivery;

    /**
     * @var integer
     *
     * @ORM\Column(name="ApprovalFlag", type="integer", nullable=true)
     */
    private $approvalflag;

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
     * @var \Tashi\CommonBundle\Entity\RequisitionStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\RequisitionStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ReqStatus_fk", referencedColumnName="Pkid")
     * })
     */
    private $reqstatusFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Employee_id_fk", referencedColumnName="Employee_Pk")
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
     * Set uiReqId
     *
     * @param string $uiReqId
     *
     * @return RequisitionMaster
     */
    public function setUiReqId($uiReqId)
    {
        $this->uiReqId = $uiReqId;

        return $this;
    }

    /**
     * Get uiReqId
     *
     * @return string
     */
    public function getUiReqId()
    {
        return $this->uiReqId;
    }

    /**
     * Set requisitionDetails
     *
     * @param string $requisitionDetails
     *
     * @return RequisitionMaster
     */
    public function setRequisitionDetails($requisitionDetails)
    {
        $this->requisitionDetails = $requisitionDetails;

        return $this;
    }

    /**
     * Get requisitionDetails
     *
     * @return string
     */
    public function getRequisitionDetails()
    {
        return $this->requisitionDetails;
    }

    /**
     * Set requisitionDate
     *
     * @param \DateTime $requisitionDate
     *
     * @return RequisitionMaster
     */
    public function setRequisitionDate($requisitionDate)
    {
        $this->requisitionDate = $requisitionDate;

        return $this;
    }

    /**
     * Get requisitionDate
     *
     * @return \DateTime
     */
    public function getRequisitionDate()
    {
        return $this->requisitionDate;
    }

    /**
     * Set expectedDelivery
     *
     * @param \DateTime $expectedDelivery
     *
     * @return RequisitionMaster
     */
    public function setExpectedDelivery($expectedDelivery)
    {
        $this->expectedDelivery = $expectedDelivery;

        return $this;
    }

    /**
     * Get expectedDelivery
     *
     * @return \DateTime
     */
    public function getExpectedDelivery()
    {
        return $this->expectedDelivery;
    }

    /**
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return RequisitionMaster
     */
    public function setApprovalflag($approvalflag)
    {
        $this->approvalflag = $approvalflag;

        return $this;
    }

    /**
     * Get approvalflag
     *
     * @return integer
     */
    public function getApprovalflag()
    {
        return $this->approvalflag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return RequisitionMaster
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
     * @return RequisitionMaster
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
     * @return RequisitionMaster
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
     * @return RequisitionMaster
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
     * @return RequisitionMaster
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
     * @return RequisitionMaster
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
     * Set reqstatusFk
     *
     * @param \Tashi\CommonBundle\Entity\RequisitionStatusMaster $reqstatusFk
     *
     * @return RequisitionMaster
     */
    public function setReqstatusFk(\Tashi\CommonBundle\Entity\RequisitionStatusMaster $reqstatusFk = null)
    {
        $this->reqstatusFk = $reqstatusFk;

        return $this;
    }

    /**
     * Get reqstatusFk
     *
     * @return \Tashi\CommonBundle\Entity\RequisitionStatusMaster
     */
    public function getReqstatusFk()
    {
        return $this->reqstatusFk;
    }

    /**
     * Set employeeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk
     *
     * @return RequisitionMaster
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
