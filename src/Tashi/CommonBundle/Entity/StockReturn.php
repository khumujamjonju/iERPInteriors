<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockReturn
 *
 * @ORM\Table(name="stock_return", indexes={@ORM\Index(name="fk_product_history_idx", columns={"Req_Pro_Fk"}), @ORM\Index(name="fk_return_purpose_idx", columns={"Req_Pur_Fk"})})
 * @ORM\Entity
 */
class StockReturn
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
     * @ORM\Column(name="ReturnQuantity", type="integer", nullable=true)
     */
    private $returnquantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date", type="datetime", nullable=true)
     */
    private $returnDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
     */
    private $remarks;

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
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Branch_Office_Code", type="integer", nullable=true)
     */
    private $branchOfficeCode;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Req_Pro_Fk", referencedColumnName="Pkid")
     * })
     */
    private $reqProFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StockReturnPurpose
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StockReturnPurpose")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Req_Pur_Fk", referencedColumnName="Pkid")
     * })
     */
    private $reqPurFk;



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
     * Set returnquantity
     *
     * @param integer $returnquantity
     *
     * @return StockReturn
     */
    public function setReturnquantity($returnquantity)
    {
        $this->returnquantity = $returnquantity;

        return $this;
    }

    /**
     * Get returnquantity
     *
     * @return integer
     */
    public function getReturnquantity()
    {
        return $this->returnquantity;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     *
     * @return StockReturn
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return StockReturn
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
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return StockReturn
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
     * @return StockReturn
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
     * @return StockReturn
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
     * @return StockReturn
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
     * @return StockReturn
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
     * @return StockReturn
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
     * @return StockReturn
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return StockReturn
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
     * Set reqProFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $reqProFk
     *
     * @return StockReturn
     */
    public function setReqProFk(\Tashi\CommonBundle\Entity\PrdProductMaster $reqProFk = null)
    {
        $this->reqProFk = $reqProFk;

        return $this;
    }

    /**
     * Get reqProFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductMaster
     */
    public function getReqProFk()
    {
        return $this->reqProFk;
    }

    /**
     * Set reqPurFk
     *
     * @param \Tashi\CommonBundle\Entity\StockReturnPurpose $reqPurFk
     *
     * @return StockReturn
     */
    public function setReqPurFk(\Tashi\CommonBundle\Entity\StockReturnPurpose $reqPurFk = null)
    {
        $this->reqPurFk = $reqPurFk;

        return $this;
    }

    /**
     * Get reqPurFk
     *
     * @return \Tashi\CommonBundle\Entity\StockReturnPurpose
     */
    public function getReqPurFk()
    {
        return $this->reqPurFk;
    }
}
