<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectContactDetails
 *
 * @ORM\Table(name="project_contact_details", uniqueConstraints={@ORM\UniqueConstraint(name="PO_Pk_UNIQUE", columns={"Pkid"})}, indexes={@ORM\Index(name="fk_project_master_idx", columns={"Project_id_fk"}), @ORM\Index(name="fk_location_address_idx", columns={"Contact_id_fk"})})
 * @ORM\Entity
 */
class ProjectContactDetails
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
     * @var integer
     *
     * @ORM\Column(name="is_primary_contact", type="integer", nullable=true)
     */
    private $isPrimaryContact;

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
     * @var \Tashi\CommonBundle\Entity\CusContactTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusContactTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Contact_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $contactFk;

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
     * Set isPrimaryContact
     *
     * @param integer $isPrimaryContact
     *
     * @return ProjectContactDetails
     */
    public function setIsPrimaryContact($isPrimaryContact)
    {
        $this->isPrimaryContact = $isPrimaryContact;

        return $this;
    }

    /**
     * Get isPrimaryContact
     *
     * @return integer
     */
    public function getIsPrimaryContact()
    {
        return $this->isPrimaryContact;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ProjectContactDetails
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
     * @return ProjectContactDetails
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
     * @return ProjectContactDetails
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
     * @return ProjectContactDetails
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
     * @return ProjectContactDetails
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
     * @return ProjectContactDetails
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
     * @return ProjectContactDetails
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
     * Set contactFk
     *
     * @param \Tashi\CommonBundle\Entity\CusContactTxn $contactFk
     *
     * @return ProjectContactDetails
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
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return ProjectContactDetails
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
