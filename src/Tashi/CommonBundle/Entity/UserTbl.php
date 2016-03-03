<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTbl
 *
 * @ORM\Table(name="user_tbl", indexes={@ORM\Index(name="fk_employee_user_idx", columns={"User_id_fk"}), @ORM\Index(name="fk_user_role_tbl_idx_idx", columns={"User_Role_Fk"}), @ORM\Index(name="fk_status_user_idx", columns={"Status_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\UserRepository")
 */
class UserTbl
{
    /**
     * @var integer
     *
     * @ORM\Column(name="User_Id_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userIdPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="User_Role_Fk", type="integer", nullable=true)
     */
    private $userRoleFk;

    /**
     * @var string
     *
     * @ORM\Column(name="User_Name", type="string", length=100, nullable=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="User_Password", type="string", length=100, nullable=true)
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="User_Email", type="string", length=45, nullable=true)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="Privilege", type="string", length=2, nullable=true)
     */
    private $privilege;

    /**
     * @var string
     *
     * @ORM\Column(name="Reset_link", type="string", length=150, nullable=true)
     */
    private $resetLink;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="End_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
     */
    private $remarks;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Activate", type="integer", nullable=true)
     */
    private $isActivate;

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
     * @var integer
     *
     * @ORM\Column(name="Application_User_Id", type="integer", nullable=true)
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
     * @var \Tashi\CommonBundle\Entity\UserStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\UserStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_fk", referencedColumnName="Pkid")
     * })
     */
    private $statusFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_id_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $userFk;



    /**
     * Get userIdPk
     *
     * @return integer
     */
    public function getUserIdPk()
    {
        return $this->userIdPk;
    }

    /**
     * Set userRoleFk
     *
     * @param integer $userRoleFk
     *
     * @return UserTbl
     */
    public function setUserRoleFk($userRoleFk)
    {
        $this->userRoleFk = $userRoleFk;

        return $this;
    }

    /**
     * Get userRoleFk
     *
     * @return integer
     */
    public function getUserRoleFk()
    {
        return $this->userRoleFk;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return UserTbl
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     *
     * @return UserTbl
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return UserTbl
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set privilege
     *
     * @param string $privilege
     *
     * @return UserTbl
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * Get privilege
     *
     * @return string
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * Set resetLink
     *
     * @param string $resetLink
     *
     * @return UserTbl
     */
    public function setResetLink($resetLink)
    {
        $this->resetLink = $resetLink;

        return $this;
    }

    /**
     * Get resetLink
     *
     * @return string
     */
    public function getResetLink()
    {
        return $this->resetLink;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return UserTbl
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
     * @return UserTbl
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
     * Set remarks
     *
     * @param string $remarks
     *
     * @return UserTbl
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
     * Set isActivate
     *
     * @param integer $isActivate
     *
     * @return UserTbl
     */
    public function setIsActivate($isActivate)
    {
        $this->isActivate = $isActivate;

        return $this;
    }

    /**
     * Get isActivate
     *
     * @return integer
     */
    public function getIsActivate()
    {
        return $this->isActivate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return UserTbl
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
     * @return UserTbl
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
     * @return UserTbl
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
     * @return UserTbl
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
     * @param integer $applicationUserId
     *
     * @return UserTbl
     */
    public function setApplicationUserId($applicationUserId)
    {
        $this->applicationUserId = $applicationUserId;

        return $this;
    }

    /**
     * Get applicationUserId
     *
     * @return integer
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
     * @return UserTbl
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
     * @return UserTbl
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
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\UserStatusMaster $statusFk
     *
     * @return UserTbl
     */
    public function setStatusFk(\Tashi\CommonBundle\Entity\UserStatusMaster $statusFk = null)
    {
        $this->statusFk = $statusFk;

        return $this;
    }

    /**
     * Get statusFk
     *
     * @return \Tashi\CommonBundle\Entity\UserStatusMaster
     */
    public function getStatusFk()
    {
        return $this->statusFk;
    }

    /**
     * Set userFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $userFk
     *
     * @return UserTbl
     */
    public function setUserFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $userFk = null)
    {
        $this->userFk = $userFk;

        return $this;
    }

    /**
     * Get userFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getUserFk()
    {
        return $this->userFk;
    }
}
