<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnSearchParam
 *
 * @ORM\Table(name="cmn_search_param")
 * @ORM\Entity
 */
class CmnSearchParam
{
    /**
     * @var integer
     *
     * @ORM\Column(name="search_param_pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $searchParamPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Param_Desc", type="string", length=445, nullable=true)
     */
    private $paramDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="Param_field_name", type="string", length=65, nullable=true)
     */
    private $paramFieldName;

    /**
     * @var string
     *
     * @ORM\Column(name="Entity_Name", type="string", length=65, nullable=true)
     */
    private $entityName;

    /**
     * @var integer
     *
     * @ORM\Column(name="Search_For", type="integer", nullable=true)
     */
    private $searchFor;

    /**
     * @var string
     *
     * @ORM\Column(name="Search_For_Desc", type="string", length=245, nullable=true)
     */
    private $searchForDesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="Param_flag", type="integer", nullable=true)
     */
    private $paramFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="Module_flag", type="integer", nullable=true)
     */
    private $moduleFlag;

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
     * Get searchParamPk
     *
     * @return integer
     */
    public function getSearchParamPk()
    {
        return $this->searchParamPk;
    }

    /**
     * Set paramDesc
     *
     * @param string $paramDesc
     *
     * @return CmnSearchParam
     */
    public function setParamDesc($paramDesc)
    {
        $this->paramDesc = $paramDesc;

        return $this;
    }

    /**
     * Get paramDesc
     *
     * @return string
     */
    public function getParamDesc()
    {
        return $this->paramDesc;
    }

    /**
     * Set paramFieldName
     *
     * @param string $paramFieldName
     *
     * @return CmnSearchParam
     */
    public function setParamFieldName($paramFieldName)
    {
        $this->paramFieldName = $paramFieldName;

        return $this;
    }

    /**
     * Get paramFieldName
     *
     * @return string
     */
    public function getParamFieldName()
    {
        return $this->paramFieldName;
    }

    /**
     * Set entityName
     *
     * @param string $entityName
     *
     * @return CmnSearchParam
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * Get entityName
     *
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Set searchFor
     *
     * @param integer $searchFor
     *
     * @return CmnSearchParam
     */
    public function setSearchFor($searchFor)
    {
        $this->searchFor = $searchFor;

        return $this;
    }

    /**
     * Get searchFor
     *
     * @return integer
     */
    public function getSearchFor()
    {
        return $this->searchFor;
    }

    /**
     * Set searchForDesc
     *
     * @param string $searchForDesc
     *
     * @return CmnSearchParam
     */
    public function setSearchForDesc($searchForDesc)
    {
        $this->searchForDesc = $searchForDesc;

        return $this;
    }

    /**
     * Get searchForDesc
     *
     * @return string
     */
    public function getSearchForDesc()
    {
        return $this->searchForDesc;
    }

    /**
     * Set paramFlag
     *
     * @param integer $paramFlag
     *
     * @return CmnSearchParam
     */
    public function setParamFlag($paramFlag)
    {
        $this->paramFlag = $paramFlag;

        return $this;
    }

    /**
     * Get paramFlag
     *
     * @return integer
     */
    public function getParamFlag()
    {
        return $this->paramFlag;
    }

    /**
     * Set moduleFlag
     *
     * @param integer $moduleFlag
     *
     * @return CmnSearchParam
     */
    public function setModuleFlag($moduleFlag)
    {
        $this->moduleFlag = $moduleFlag;

        return $this;
    }

    /**
     * Get moduleFlag
     *
     * @return integer
     */
    public function getModuleFlag()
    {
        return $this->moduleFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
     * @return CmnSearchParam
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
}
