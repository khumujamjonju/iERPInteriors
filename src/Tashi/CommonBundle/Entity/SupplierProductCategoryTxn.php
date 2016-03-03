<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierProductCategoryTxn
 *
 * @ORM\Table(name="supplier_product_category_txn", indexes={@ORM\Index(name="FK_Cat_idx", columns={"ProCat_Fk"}), @ORM\Index(name="FK_SUP_idx", columns={"Sup_Fk"})})
 * @ORM\Entity
 */
class SupplierProductCategoryTxn
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
     * @var \Tashi\CommonBundle\Entity\SupplierMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SupplierMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Sup_Fk", referencedColumnName="Supplier_Pk")
     * })
     */
    private $supFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductCategoryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductCategoryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ProCat_Fk", referencedColumnName="Pkid")
     * })
     */
    private $procatFk;



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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * @return SupplierProductCategoryTxn
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
     * Set supFk
     *
     * @param \Tashi\CommonBundle\Entity\SupplierMaster $supFk
     *
     * @return SupplierProductCategoryTxn
     */
    public function setSupFk(\Tashi\CommonBundle\Entity\SupplierMaster $supFk = null)
    {
        $this->supFk = $supFk;

        return $this;
    }

    /**
     * Get supFk
     *
     * @return \Tashi\CommonBundle\Entity\SupplierMaster
     */
    public function getSupFk()
    {
        return $this->supFk;
    }

    /**
     * Set procatFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductCategoryMaster $procatFk
     *
     * @return SupplierProductCategoryTxn
     */
    public function setProcatFk(\Tashi\CommonBundle\Entity\PrdProductCategoryMaster $procatFk = null)
    {
        $this->procatFk = $procatFk;

        return $this;
    }

    /**
     * Get procatFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductCategoryMaster
     */
    public function getProcatFk()
    {
        return $this->procatFk;
    }
}
