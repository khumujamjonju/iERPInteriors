<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectAreaProdCategoryTxn
 *
 * @ORM\Table(name="project_area_prod_category_txn", indexes={@ORM\Index(name="fk_projectarea_txn_idx", columns={"Project_area_fk"}), @ORM\Index(name="fk_prodcategory_txn_idx", columns={"Prod_category_fk"})})
 * @ORM\Entity
 */
class ProjectAreaProdCategoryTxn
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
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductCategoryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductCategoryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Prod_category_fk", referencedColumnName="Pkid")
     * })
     */
    private $prodCategoryFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectAreaMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectAreaMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_area_fk", referencedColumnName="Pkid")
     * })
     */
    private $projectAreaFk;



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
     * @return ProjectAreaProdCategoryTxn
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
     * @return ProjectAreaProdCategoryTxn
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
     * @return ProjectAreaProdCategoryTxn
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
     * @return ProjectAreaProdCategoryTxn
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
     * @return ProjectAreaProdCategoryTxn
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
     * Set companyCode
     *
     * @param integer $companyCode
     *
     * @return ProjectAreaProdCategoryTxn
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
     * Set prodCategoryFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductCategoryMaster $prodCategoryFk
     *
     * @return ProjectAreaProdCategoryTxn
     */
    public function setProdCategoryFk(\Tashi\CommonBundle\Entity\PrdProductCategoryMaster $prodCategoryFk = null)
    {
        $this->prodCategoryFk = $prodCategoryFk;

        return $this;
    }

    /**
     * Get prodCategoryFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductCategoryMaster
     */
    public function getProdCategoryFk()
    {
        return $this->prodCategoryFk;
    }

    /**
     * Set projectAreaFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectAreaMaster $projectAreaFk
     *
     * @return ProjectAreaProdCategoryTxn
     */
    public function setProjectAreaFk(\Tashi\CommonBundle\Entity\ProjectAreaMaster $projectAreaFk = null)
    {
        $this->projectAreaFk = $projectAreaFk;

        return $this;
    }

    /**
     * Get projectAreaFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectAreaMaster
     */
    public function getProjectAreaFk()
    {
        return $this->projectAreaFk;
    }
}
