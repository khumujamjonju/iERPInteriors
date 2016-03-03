<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnCommunicationTxn
 *
 * @ORM\Table(name="cmn_communication_txn", indexes={@ORM\Index(name="FK_commaster_comtxn_idx", columns={"Message_Id_Fk"}), @ORM\Index(name="FK_customer_comtxn_idx", columns={"Customer_Id_FK"}), @ORM\Index(name="FK_contact_comtxn_idx", columns={"Contact_Id_FK"})})
 * @ORM\Entity
 */
class CmnCommunicationTxn
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
     * @ORM\Column(name="Recipient_Type", type="string", length=60, nullable=true)
     */
    private $recipientType;

    /**
     * @var integer
     *
     * @ORM\Column(name="Employee_Id_FK", type="integer", nullable=true)
     */
    private $employeeIdFk;

    /**
     * @var string
     *
     * @ORM\Column(name="Contact_Address", type="string", length=1500, nullable=true)
     */
    private $contactAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Scheduled_Datetime", type="datetime", nullable=true)
     */
    private $scheduledDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Sent_Datetime", type="datetime", nullable=true)
     */
    private $sentDatetime;

    /**
     * @var string
     *
     * @ORM\Column(name="Unique_sms_id", type="string", length=200, nullable=true)
     */
    private $uniqueSmsId;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=125, nullable=true)
     */
    private $status = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_Flag", type="integer", nullable=true)
     */
    private $approvalFlag;

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
     * @ORM\Column(name="Application_User_Id", type="string", length=60, nullable=true)
     */
    private $applicationUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=15, nullable=true)
     */
    private $applicationUserIpAddress;

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
     * @var \Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Message_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $messageFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CusContactTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusContactTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Contact_Id_FK", referencedColumnName="Pkid")
     * })
     */
    private $contactFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CusCustomer
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Customer_Id_FK", referencedColumnName="Customer_Id_Pk")
     * })
     */
    private $customerFk;



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
     * Set recipientType
     *
     * @param string $recipientType
     *
     * @return CmnCommunicationTxn
     */
    public function setRecipientType($recipientType)
    {
        $this->recipientType = $recipientType;

        return $this;
    }

    /**
     * Get recipientType
     *
     * @return string
     */
    public function getRecipientType()
    {
        return $this->recipientType;
    }

    /**
     * Set employeeIdFk
     *
     * @param integer $employeeIdFk
     *
     * @return CmnCommunicationTxn
     */
    public function setEmployeeIdFk($employeeIdFk)
    {
        $this->employeeIdFk = $employeeIdFk;

        return $this;
    }

    /**
     * Get employeeIdFk
     *
     * @return integer
     */
    public function getEmployeeIdFk()
    {
        return $this->employeeIdFk;
    }

    /**
     * Set contactAddress
     *
     * @param string $contactAddress
     *
     * @return CmnCommunicationTxn
     */
    public function setContactAddress($contactAddress)
    {
        $this->contactAddress = $contactAddress;

        return $this;
    }

    /**
     * Get contactAddress
     *
     * @return string
     */
    public function getContactAddress()
    {
        return $this->contactAddress;
    }

    /**
     * Set scheduledDatetime
     *
     * @param \DateTime $scheduledDatetime
     *
     * @return CmnCommunicationTxn
     */
    public function setScheduledDatetime($scheduledDatetime)
    {
        $this->scheduledDatetime = $scheduledDatetime;

        return $this;
    }

    /**
     * Get scheduledDatetime
     *
     * @return \DateTime
     */
    public function getScheduledDatetime()
    {
        return $this->scheduledDatetime;
    }

    /**
     * Set sentDatetime
     *
     * @param \DateTime $sentDatetime
     *
     * @return CmnCommunicationTxn
     */
    public function setSentDatetime($sentDatetime)
    {
        $this->sentDatetime = $sentDatetime;

        return $this;
    }

    /**
     * Get sentDatetime
     *
     * @return \DateTime
     */
    public function getSentDatetime()
    {
        return $this->sentDatetime;
    }

    /**
     * Set uniqueSmsId
     *
     * @param string $uniqueSmsId
     *
     * @return CmnCommunicationTxn
     */
    public function setUniqueSmsId($uniqueSmsId)
    {
        $this->uniqueSmsId = $uniqueSmsId;

        return $this;
    }

    /**
     * Get uniqueSmsId
     *
     * @return string
     */
    public function getUniqueSmsId()
    {
        return $this->uniqueSmsId;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return CmnCommunicationTxn
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return CmnCommunicationTxn
     */
    public function setApprovalFlag($approvalFlag)
    {
        $this->approvalFlag = $approvalFlag;

        return $this;
    }

    /**
     * Get approvalFlag
     *
     * @return integer
     */
    public function getApprovalFlag()
    {
        return $this->approvalFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnCommunicationTxn
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
     * @return CmnCommunicationTxn
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
     * @return CmnCommunicationTxn
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
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return CmnCommunicationTxn
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
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return CmnCommunicationTxn
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return CmnCommunicationTxn
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
     * @return CmnCommunicationTxn
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
     * @return CmnCommunicationTxn
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
     * @return CmnCommunicationTxn
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
     * Set messageFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster $messageFk
     *
     * @return CmnCommunicationTxn
     */
    public function setMessageFk(\Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster $messageFk = null)
    {
        $this->messageFk = $messageFk;

        return $this;
    }

    /**
     * Get messageFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster
     */
    public function getMessageFk()
    {
        return $this->messageFk;
    }

    /**
     * Set contactFk
     *
     * @param \Tashi\CommonBundle\Entity\CusContactTxn $contactFk
     *
     * @return CmnCommunicationTxn
     */
    public function setContactFk(\Tashi\CommonBundle\Entity\CusContactTxn $contactFk = null)
    {
        $this->contactFk = $contactFk;

        return $this;
    }

    /**
     * Get contactFk
     *
     * @return \Tashi\CommonBundle\Entity\CusContactTxn
     */
    public function getContactFk()
    {
        return $this->contactFk;
    }

    /**
     * Set customerFk
     *
     * @param \Tashi\CommonBundle\Entity\CusCustomer $customerFk
     *
     * @return CmnCommunicationTxn
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
}
