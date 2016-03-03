<?php

namespace Tashi\CompanyBundle\Service;

use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CompanyBundle\Helper\CompanyConstant;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Entity\ShippingMaster;
use Tashi\CommonBundle\Entity\CompanyMaster;
use Tashi\CommonBundle\Entity\CompanyAddressTxn;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\ShippingAddressTxn;
use Tashi\CommonBundle\Entity\CompanyContactTxn;
use Tashi\CommonBundle\Entity\CompanyEmailTxn;
use Tashi\CommonBundle\Entity\CompanyPhoneTxn;
use Tashi\CommonBundle\Entity\CompanyFaxnoTxn;
use Tashi\CommonBundle\Entity\CmnPerson;
use Tashi\CommonBundle\Entity\ShippingContactTxn;
use Tashi\CommonBundle\Entity\CmnLocationAddressMaster;
use Tashi\CommonBundle\Entity\ShippingContactMobileNoTxn;
use Tashi\CommonBundle\Entity\CmnMobileNoMaster;
use Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster;

class CompanyService {

    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;

    public function __construct(EntityManager $em, Session $session, $rootDir, $commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService = $commonService;
    }

    //------------------------------RECORD INSERTION SECTION----------------------------------
public function displayAllResult($tbl_name) {
        try {
            return $this->commonService->activeList($tbl_name);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    
    
    public function cmnLoadCompanyList($request, $key) {
        try {

            $load_location_key = $request->request->get('load_list_key');
            switch ($key) {
                case 'S': //load state, for the particular country
                    $result = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('countryCodeFk' => $load_location_key, 'recordActiveFlag' => 1),array('stateName'=>'asc'));
                    break;
                case 'D'://load district, for the particular state
                    $result = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('stateFk' => $load_location_key, 'recordActiveFlag' => 1),array('districtName'=>'asc'));
                    break;
                case 'C'://load city, for the particular district
                    $result = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('districtFk' => $load_location_key, 'recordActiveFlag' => 1),array('cityName'=>'asc'));
                    break;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('key' => $key, 'loadList' => $result);
    }

    /*     * ***********this service is mainly for add company(Adding, Updating , Retrieving ,Deleting) master*********** */

    public function saveCompanyAction($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        try {
//            $dataUI = json_decode($request->getContent());
            $CompanyID = $request->request->get('cpkid');
            $AddressID = $request->request->get('addpkid');
            $CompanyName = $request->request->get('CompanyName');
            $Slogan = $request->request->get('slogan');
            $webSite = $request->request->get('webSite');
            $RegdNumber = $request->request->get('Registration_number');
//            $TelNo = $request->request->get('TelNo');
//            $FaxNo = $request->request->get('FaxNo');
            $Tin = $request->request->get('Tin');
            $Tan = $request->request->get('Tan');
            $Vat = $request->request->get('Vat');
            $Cin = $request->request->get('Cin');
//            $CompanyCode = $request->request->get('CompCode');
//            $BranchOfficeCode = $request->request->get('BranchOficeCode');

            $address1 = $request->request->get('address1');
            $country = $request->request->get('selcountry');
            $state = $request->request->get('selstate');
            $district = $request->request->get('seldistrict');
            $city = $request->request->get('selcity');
            $pin = $request->request->get('zipcode');

            $fileupload = $request->files->get('txt_emp_pro_pic');
            $uploadedFiles = array();
            $validFileTypes = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');
            $prevfilepath = '';

            if ($CompanyID == '') {
                $CompanyMasterObj = new CompanyMaster();
                $isDocNew = true;
                $prevfilepath = '';
                $document = '';
            } else { //update part
                $CompanyMasterObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->find($CompanyID);
                $isDocNew = false;
                $document = $CompanyMasterObj->getLogoFk();
            }
            //upload profile picture        
            if ($document) {
                $prevfilepath = $document->getPath();
            }
            if (isset($fileupload)) {
                $path = 'upload/COMPANY/LOGO/';
                $fuploadresult = $this->commonService->UploadFile($fileupload, $path, 1, $validFileTypes);
                if ($fuploadresult['code'] == 1) {
                    $uploadedFiles[] = $fuploadresult['fullpath'];
                    //save image in document master
                    if (!$document) {
                        $document = new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew = true;
                    } else {
                        $document->setRecordUpdateDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }
                    $document->setPath($path . $fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if ($isDocNew) {
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if (file_exists($prevfilepath)) {
                        unlink($prevfilepath);
                    }
                } else {
                    $conn->rollBack();
                    foreach ($uploadedFiles as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    return array('code' => 0, 'msg' => $fuploadresult['msg']);
                }
            }
            //end upload profile picture
            if ($isDocNew) {
                if ($document !== '') {
                    $CompanyMasterObj->setLogoFk($document);
                }
            }
            // insert to CompanyMaster         
            $CompanyMasterObj->setCompanyName($CompanyName);
            $CompanyMasterObj->setSlogan($Slogan);
            $CompanyMasterObj->setWebsite($webSite);
            $CompanyMasterObj->setRegistrationNo($RegdNumber);
            $CompanyMasterObj->setTinNo($Tin);
            $CompanyMasterObj->setTanNo($Tan);
            $CompanyMasterObj->setVatNo($Vat);
            $CompanyMasterObj->setCinNo($Cin);            
            $CompanyMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $CompanyMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            if($CompanyID==''){
                $CompanyMasterObj->setRecordActiveFlag(1);
                $CompanyMasterObj->setRecordInsertDate(new \Datetime());
                $this->em->persist($CompanyMasterObj);
            }else{
                $CompanyMasterObj->setRecordUpdateDate(new \Datetime());
            }
            $this->em->flush();

            // insert to CmnLocationAddressMaster
            $CountryObj = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country);
            $StateObj = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state);
            $DistrictObj = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district);
            $CityObj = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city);
            if($AddressID==''){
                $CommonAddressObj = new CmnLocationAddressMaster();
                $CommonAddressObj->setRecordActiveFlag(1);
                $CommonAddressObj->setRecordInsertDate(new \Datetime()); 
            }else{
                $CommonAddressObj=$this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($AddressID);
                $CommonAddressObj->setRecordUpdateDate(new \Datetime());
            }       
            $CommonAddressObj->setCountryCodeFk($CountryObj);
            $CommonAddressObj->setStateCodeFk($StateObj);
            $CommonAddressObj->setDistrictFk($DistrictObj);
            $CommonAddressObj->setCityCodeFk($CityObj);
            $CommonAddressObj->setAddress1($address1);
            $CommonAddressObj->setPinNumber($pin);
            $CommonAddressObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonAddressObj->setApplicationUserIpAddress($this->session->get('IP'));
            if($AddressID==''){                  
                $this->em->persist($CommonAddressObj);
            }
            $this->em->flush($CommonAddressObj);
            // insert to CompanyAddressTxn
            if($CompanyID==''){
                $CompanyObj = new CompanyAddressTxn();
                $CompanyObj->setCompanyFk($CompanyMasterObj);
                $CompanyObj->setAddressFk($CommonAddressObj);
                $CompanyObj->setRecordInsertDate(new \Datetime());
                $CompanyObj->setRecordActiveFlag(1);
                $CompanyObj->setApplicationUserId($this->session->get('EMPID'));
                $CompanyObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($CompanyObj);
                $this->em->flush($CompanyObj);
            }
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollBack();
            throw new \Exception($ex->getMessage());
        }
        if($CompanyID==''){
            return array('msg' => 'Your Company Information has been saved successfully.');
        }else{
            return array('msg' => 'Changes has been saved successfully.');
        }
    }

    public function retreiveCompany($StBid) {

        try {
            $CompanyObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->find($StBid);
            $country = $CompanyObj->getAddressFk()->getCountryCodeFk();
            $stateArr = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->
                    findBy(array('countryCodeFk' => $country, 'recordActiveFlag' => 1), array('stateName' => 'ASC'));

            $stateIdArr = array();
            $stateNameArr = array();
            foreach ($stateArr as $state) {
                array_push($stateIdArr, $state->getStatePk());
                array_push($stateNameArr, $state->getStateName());
            }

            $districtArr = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->
                    findBy(array('countryFk' => $country, 'recordActiveFlag' => 1), array('districtName' => 'ASC'));

            $districtIdArr = array();
            $districtNameArr = array();
            foreach ($districtArr as $district) {
                array_push($districtIdArr, $district->getPkid());
                array_push($districtNameArr, $district->getDistrictName());
            }

            $cityArr = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->
                    findBy(array('countryFk' => $country, 'recordActiveFlag' => 1), array('cityName' => 'ASC'));

            $cityIdArr = array();
            $cityNameArr = array();
            foreach ($cityArr as $city) {
                array_push($cityIdArr, $city->getCityPk());
                array_push($cityNameArr, $city->getCityName());
            }

            if ($CompanyObj->getCompanyFk()->getLogoFk()) {
                $logo_pic = $CompanyObj->getCompanyFk()->getLogoFk()->getPath();
            } else {
                $logo_pic = 'bundles/common/images/unk.jpg';
            }

            $return = array('StBid' => $StBid,
                'companyName' => $CompanyObj->getCompanyFk()->getCompanyName(),
                'slogan' => $CompanyObj->getCompanyFk()->getSlogan(),
                'Website' => $CompanyObj->getCompanyFk()->getWebsite(),
                'Email' => $CompanyObj->getCompanyFk()->getEmail(),
                'Registration' => $CompanyObj->getCompanyFk()->getRegistrationNo(),
                'Telephone' => $CompanyObj->getCompanyFk()->getTelNo(),
                'Fax' => $CompanyObj->getCompanyFk()->getFaxNo(),
                'TinNo' => $CompanyObj->getCompanyFk()->getTinNo(),
                'TanNo' => $CompanyObj->getCompanyFk()->getTanNo(),
                'VatNo' => $CompanyObj->getCompanyFk()->getVatNo(),
                'CinNo' => $CompanyObj->getCompanyFk()->getCinNo(),
                'CompanyCode' => $CompanyObj->getCompanyFk()->getCompanyCode(),
                'BranchOfficeCode' => $CompanyObj->getCompanyFk()->getBranchOfficeCode(),
                'storeaddressId' => $CompanyObj->getAddressFk()->getAddress1(),
                'pin' => $CompanyObj->getAddressFk()->getPinNumber(),
//                            'countryID' => $StoreObj->getAddressMasterFk()->getCountryCodeFk()->getCountryPk(),
                'countryID' => $country->getCountryPk(),
                'stateIdArr' => $stateIdArr, 'stateNameArr' => $stateNameArr,
                'stateID' => $CompanyObj->getAddressFk()->getStateCodeFk()->getStatePk(),
                'districtIdArr' => $districtIdArr, 'districtNameArr' => $districtNameArr,
                'districtID' => $CompanyObj->getAddressFk()->getDistrictFk()->getPkid(),
                'cityIdArr' => $cityIdArr, 'cityNameArr' => $cityNameArr,
                'cityID' => $CompanyObj->getAddressFk()->getCityCodeFk()->getCityPk(),
                'logoPicture' => $logo_pic
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    public function updateCompanyAction($request, $StBid) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        try {
//            $dataUI = json_decode($request->getContent());
            $CompanyName = $request->request->get('CompanyName');
            $Slogan = $request->request->get('slogan');
            $webSite = $request->request->get('webSite');
            $Email = $request->request->get('Email');
            $RegdNumber = $request->request->get('Registration_number');
            $TelNo = $request->request->get('TelNo');
            $FaxNo = $request->request->get('FaxNo');
            $Tin = $request->request->get('Tin');
            $Tan = $request->request->get('Tan');
            $Vat = $request->request->get('Vat');
            $Cin = $request->request->get('Cin');
            $CompanyCode = $request->request->get('CompCode');
            $BranchOfficeCode = $request->request->get('BranchOficeCode');

            $address1 = $request->request->get('address1');
            $country = $request->request->get('txt_country');
            $state = $request->request->get('txt_state');
            $district = $request->request->get('txt_district');
            $city = $request->request->get('txt_city');
            $zipcode = $request->request->get('zipcode');
//                $conn=$this->em->getConnection();
//        try {
//            $conn->beginTransaction();
//            $dataUI = json_decode($request->getContent());            
//            $CompanyName = $dataUI->CompanyName;
//            $Slogan=$dataUI->slogan;
//            $webSite=$dataUI->webSite;
//            $Email=$dataUI->Email;
//            $RegdNumber=$dataUI->Registration_number;
//            $TelNo=$dataUI->TelNo;
//            $FaxNo=$dataUI->FaxNo;
//            $Tin=$dataUI->Tin;
//            $Tan=$dataUI->Tan;
//            $Vat=$dataUI->Vat;
//            $Cin=$dataUI->Cin;
//            $CompanyCode=$dataUI->CompCode;
//            $BranchOfficeCode=$dataUI->BranchOficeCode;
//            
//            $address1 = $dataUI->address1;
//            $country = $dataUI->txt_country;
//            $state = $dataUI->txt_state;
//            $district = $dataUI->txt_district;
//            $city = $dataUI->txt_city;
//            $zipcode = $dataUI->zipcode;

            $CompanyObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->find($StBid);
            //get Company master id
            $companyMasterID = $CompanyObj->getCompanyFk()->getPkid();
            $CompanyMasterObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->find($companyMasterID);

            //file upload start here
            $fileupload = $request->files->get('txt_emp_pro_pic');
            $uploadedFiles = array();
            $validFileTypes = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');
            $prevfilepath = '';
            $document = '';
            $isDocNew = true;

            if ($CompanyMasterObj->getLogoFk()) {
                $isDocNew = false;
                $document = $CompanyMasterObj->getLogoFk();
            } else {
                $isDocNew = true;
            }

            if ($document) {
                $prevfilepath = $document->getPath();
            }
//echo $fileupload->getClientOriginalName(); die();
            if (isset($fileupload)) {
                $path = 'upload/COMPANY/LOGO/';
                $fuploadresult = $this->commonService->UploadFile($fileupload, $path, 1, $validFileTypes);
                if ($fuploadresult['code'] == 1) {
                    $uploadedFiles[] = $fuploadresult['fullpath'];
                    //save image in document master
                    if (!$document) {
                        $document = new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew = true;
                    } else {
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }
                    $document->setPath($path . $fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if ($isDocNew) {
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if (file_exists($prevfilepath)) {
                        unlink($prevfilepath);
                    }
                } else {
                    $conn->rollBack();
                    foreach ($uploadedFiles as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    return array('code' => 0, 'msg' => $fuploadresult['msg']);
                }
            }
            //end upload profile picture            
            //  COMMON PERSON     

            if ($isDocNew) {
                if ($document !== '') {
                    $CompanyMasterObj->setLogoFk($document);
                }
            }


            //end file upload

            $CompanyMasterObj->setCompanyName($CompanyName);
            $CompanyMasterObj->setSlogan($Slogan);
            $CompanyMasterObj->setWebsite($webSite);
            $CompanyMasterObj->setEmail($Email);
            $CompanyMasterObj->setRegistrationNo($RegdNumber);
            $CompanyMasterObj->setTelNo($TelNo);
            $CompanyMasterObj->setFaxNo($FaxNo);
            $CompanyMasterObj->setTinNo($Tin);
            $CompanyMasterObj->setTanNo($Tan);
            $CompanyMasterObj->setVatNo($Vat);
            $CompanyMasterObj->setCinNo($Cin);
            $CompanyMasterObj->setCompanyCode($CompanyCode);
            $CompanyMasterObj->setBranchOfficeCode($BranchOfficeCode);
            $CompanyMasterObj->setRecordUpdateDate(new \Datetime());
            $CompanyMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $CompanyMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            //get address master id
            $addressMasterID = $CompanyObj->getAddressFk()->getAddressPk();
            $addressMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addressMasterID);
            $addressMasterObj->setAddress1($address1);
            $addressMasterObj->setPinNumber($zipcode);
            $addressMasterObj->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country));
            $addressMasterObj->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state));
            $addressMasterObj->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district));
            $addressMasterObj->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city));
            $addressMasterObj->setRecordUpdateDate(new \Datetime());
            $addressMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $addressMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $conn->commit();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Update Record Sucessfully',
            'result' => $this->commonService->activeList('CompanyAddressTxn'),
            'id' => $CompanyObj->getPkid());
    }

    public function deleteCompanyMaster($StBid) {

        try {
            $CompanyObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_ADDRESS_TXN)->find($StBid);
            $CompanyObj->setRecordInsertDate(new \Datetime());
            $CompanyObj->setRecordActiveFlag(0);
            $CompanyObj->setApplicationUserId($this->session->get('EMPID'));
            $CompanyObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($CompanyObj);
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Record Sucessfully',
            'result' => $this->commonService->activeList('CompanyAddressTxn'),
            'id' => $CompanyObj->getPkid());
    }
    
     public function addUpdateCompanyMobile($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $CompanyMobileNo = $dataUI->mobile_name;
            $comMobileId = $dataUI->comMobileId;
            if ($comMobileId == "") {
                $companyMobileObj = new CompanyContactTxn();
            } else {
                $companyMobileObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_MOBILE)->find($comMobileId);
            }

            $companyMobileObj->setNumber($CompanyMobileNo);
            $companyMobileObj->setRecordActiveFlag(1);
            
            if ($comMobileId == "") {
                $companyMobileObj->setRecordInsertDate(new \Datetime());
            } else {
                $companyMobileObj->setRecordUpdateDate(new \Datetime());
            }
            $companyMobileObj->setApplicationUserId($this->session->get('EMPID'));
            $companyMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($companyMobileObj);
            $this->em->flush();
            if ($comMobileId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('CompanyContactTxn')
        );
    }
    
    public function addUpdateCompanyEmail($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $CompanyEmail = $dataUI->Email_name;
            $comEmailId = $dataUI->comEmailId;
            if ($comEmailId == "") {
                $companyEmailObj = new CompanyEmailTxn();
            } else {
                $companyEmailObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_EMAIL)->find($comEmailId);
            }

            $companyEmailObj->setEmail($CompanyEmail);
            $companyEmailObj->setRecordActiveFlag(1);
            
            if ($comEmailId == "") {
                $companyEmailObj->setRecordInsertDate(new \Datetime());
            } else {
                $companyEmailObj->setRecordUpdateDate(new \Datetime());
            }
            $companyEmailObj->setApplicationUserId($this->session->get('EMPID'));
            $companyEmailObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($companyEmailObj);
            $this->em->flush();
            if ($comEmailId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('CompanyEmailTxn')
        );
    }
    
    public function addUpdateCompanyTelephone($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $CompanyTelephone = $dataUI->telephone_name;
            $comTeleId = $dataUI->comTeleId;
            if ($comTeleId == "") {
                $companyTelephoneObj = new CompanyPhoneTxn();
            } else {
                $companyTelephoneObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_PHONE)->find($comTeleId);
            }

            $companyTelephoneObj->setPhoneNo($CompanyTelephone);
            $companyTelephoneObj->setRecordActiveFlag(1);
            
            if ($comTeleId == "") {
                $companyTelephoneObj->setRecordInsertDate(new \Datetime());
            } else {
                $companyTelephoneObj->setRecordUpdateDate(new \Datetime());
            }
            $companyTelephoneObj->setApplicationUserId($this->session->get('EMPID'));
            $companyTelephoneObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($companyTelephoneObj);
            $this->em->flush();
            if ($comTeleId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('CompanyPhoneTxn')
        );
    }
    
    public function addUpdateCompanyFax($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $CompanyFax = $dataUI->fax_name;
            $comFaxId = $dataUI->comFaxId;
            if ($comFaxId == "") {
                $companyFaxObj = new CompanyFaxnoTxn();
            } else {
                $companyFaxObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_FAX)->find($comFaxId);
            }

            $companyFaxObj->setFaxno($CompanyFax);
            $companyFaxObj->setRecordActiveFlag(1);
            
            if ($comFaxId == "") {
                $companyFaxObj->setRecordInsertDate(new \Datetime());
            } else {
                $companyFaxObj->setRecordUpdateDate(new \Datetime());
            }
            $companyFaxObj->setApplicationUserId($this->session->get('EMPID'));
            $companyFaxObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($companyFaxObj);
            $this->em->flush();
            if ($comFaxId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('CompanyFaxnoTxn')
        );
    }
    
    
     public function retrieveCompanyMobile($comMobileId) {
        try {
            $companyMobileObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_MOBILE)->find($comMobileId);
            $return = array(
                'comMobileId' => $comMobileId,
                'mobile_name' => $companyMobileObj->getNumber());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
     public function retrieveCompanyEmail($comEmailId) {
        try {
            $companyEmailObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_EMAIL)->find($comEmailId);
            $return = array(
                'comEmailId' => $comEmailId,
                'Email_name' => $companyEmailObj->getEmail());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
     public function retrieveCompanyTelephone($comTeleId) {
        try {
            $companyTelephoneObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_PHONE)->find($comTeleId);
            $return = array(
                'comTeleId' => $comTeleId,
                'telephone_name' => $companyTelephoneObj->getPhoneNo());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
     public function retrieveCompanyFax($comFaxId) {
        try {
            $companyFaxObj = $this->em->getRepository(CommonConstant::ENT_COMPANY_FAX)->find($comFaxId);
            $return = array(
                'comFaxId' => $comFaxId,
                'Fax_name' => $companyFaxObj->getFaxno());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
     public function deleteCompanyMobileMasters($comMobileId) {

        try {
            $companyMobileObj = $this->em->getRepository('TashiCommonBundle:CompanyContactTxn')->find($comMobileId);
            $companyMobileObj->setRecordActiveFlag(0);
            $companyMobileObj->setRecordUpdateDate(new \DateTime("NOW"));
            $companyMobileObj->setApplicationUserId($this->session->get('EMPID'));
            $companyMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('CompanyContactTxn'),
            'id' => $companyMobileObj->getPkid());
    }
    
    public function deleteCompanyEmailMasters($comEmailId) {

        try {
            $companyEmailObj = $this->em->getRepository('TashiCommonBundle:CompanyEmailTxn')->find($comEmailId);
            $companyEmailObj->setRecordActiveFlag(0);
            $companyEmailObj->setRecordUpdateDate(new \DateTime("NOW"));
            $companyEmailObj->setApplicationUserId($this->session->get('EMPID'));
            $companyEmailObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('CompanyEmailTxn'),
            'id' => $companyEmailObj->getPkid());
    }
    
     public function deleteCompanyTelephoneMasters($comTeleId) {

        try {
            $companyTelephoneObj = $this->em->getRepository('TashiCommonBundle:CompanyPhoneTxn')->find($comTeleId);
            $companyTelephoneObj->setRecordActiveFlag(0);
            $companyTelephoneObj->setRecordUpdateDate(new \DateTime("NOW"));
            $companyTelephoneObj->setApplicationUserId($this->session->get('EMPID'));
            $companyTelephoneObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('CompanyPhoneTxn'),
            'id' => $companyTelephoneObj->getPkid());
    }
    
     public function deleteCompanyFaxMasters($comFaxId) {

        try {
            $companyFaxObj = $this->em->getRepository('TashiCommonBundle:CompanyFaxnoTxn')->find($comFaxId);
            $companyFaxObj->setRecordActiveFlag(0);
            $companyFaxObj->setRecordUpdateDate(new \DateTime("NOW"));
            $companyFaxObj->setApplicationUserId($this->session->get('EMPID'));
            $companyFaxObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('CompanyFaxnoTxn'),
            'id' => $companyFaxObj->getPkid());
    }

    public function addCompanyMaster($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //inserting record for supplier master
            $comName = $dataUI->txt_pur_companyname;
            $regNo = $dataUI->txt_Registration;
            $remarks = $dataUI->txt_remarks;
            $tin = $dataUI->txt_tin_no;
            $cin = $dataUI->txt_cin_no;



            //$website=  $dataUI->Website; 
            $Fname = $dataUI->txt_pur_firstname;
            $Mname = $dataUI->txt_pur_middlename;
            $Lname = $dataUI->txt_pur_lastname;
            $designation = $dataUI->txt_occupation;
            $dob = $dataUI->dob;
            $gender = $dataUI->gender;
            //$email=$dataUI->email; 

            $CompanyObj = new ShippingMaster();
            $CompanyObj->setCompanyName($comName);
            $CompanyObj->setRegistrationNo($regNo);
            $CompanyObj->setRemarks($remarks);
            $CompanyObj->setTin($tin);
            $CompanyObj->setCin($cin);

            $CompanyObj->setRecordInsertDate(new \Datetime());
            $CompanyObj->setRecordActiveFlag(1);
            $CompanyObj->setApplicationUserId($this->session->get('EMPID'));
            $CompanyObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($CompanyObj);
            $this->em->flush();

            //inserting record for common person
            $CommonpersonObj = new CmnPerson();
            $CommonpersonObj->setFirstName($Fname);
            $CommonpersonObj->setMiddleName($Mname);
            $CommonpersonObj->setLastName($Lname);
            $CommonpersonObj->setGender($gender);
            $CommonpersonObj->setDesignation($designation);
            $CommonpersonObj->setDateOfBirth(new \Datetime($dob));
            // $CommonpersonObj->setEmailId($email);
            $CommonpersonObj->setRecordActiveFlag(1);
            $CommonpersonObj->setRecordInsertDate(new \Datetime());
            $CommonpersonObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonpersonObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($CommonpersonObj);
            $this->em->flush();
            //ends here
            //inserting record for supplier contact txn


            $ComcontacttxnObj = new ShippingContactTxn();
            $ComcontacttxnObj->setShippingFk($CompanyObj);
            $ComcontacttxnObj->setPersonFk($CommonpersonObj);

            $ComcontacttxnObj->setRecordActiveFlag(1);
            $ComcontacttxnObj->setRecordInsertDate(new \Datetime());
            $ComcontacttxnObj->setApplicationUserId($this->session->get('EMPID'));
            $ComcontacttxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($ComcontacttxnObj);
            $this->em->flush();


            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'Record Save Sucessfully',
            'result' => $this->commonService->activeList('ShippingMaster'),
            'company_id' => $CompanyObj->getShippingPk(),
        );
    }

    //---------------------updating supplier master record------------------------

    public function updateCompanyMaster($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //--------------------------updating record for supplier master--------------------------
            $comName = $dataUI->txt_pur_companyname;
            $regNo = $dataUI->txt_Registration;
            $remarks = $dataUI->txt_remarks;
            $Fname = $dataUI->txt_pur_firstname;
            $Mname = $dataUI->txt_pur_middlename;
            $Lname = $dataUI->txt_pur_lastname;
            $designation = $dataUI->txt_occupation;
            $dob = $dataUI->dob;
            $gender = $dataUI->gender;
            $com_id = $dataUI->comid;
            $tin = $dataUI->txt_tin_no;
            $cin = $dataUI->txt_cin_no;

            $CompanyObj = $this->commonService->getRecordById(CompanyConstant::ENT_COMPANY_MASTER, $com_id);
            $CompanyObj->setCompanyName($comName);
            $CompanyObj->setRegistrationNo($regNo);
            $CompanyObj->setRemarks($remarks);
            $CompanyObj->setTin($tin);
            $CompanyObj->setCin($cin);
            $CompanyObj->setRecordInsertDate(new \Datetime());
            $CompanyObj->setApplicationUserId($this->session->get('EMPID'));
            $CompanyObj->setApplicationUserIpAddress($this->session->get('IP'));
            $CompanyObj->setRecordActiveFlag(1);
            $this->em->flush();
            //-----------------------------ends here--------------------------------------
            //-------------------------------retriving record from supplier contact txn--------------------------

            $companycontact_pkObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $com_id, 'recordActiveFlag' => 1));
            $common_person_pk = $companycontact_pkObj->getPersonFk()->getPersonPk();
            $CommonpersonObj = $this->commonService->getRecordById(CompanyConstant::ENT_COMPANY_COMMON_PERSON_ADDRESS, $common_person_pk);


            //-------------------------------------ends here----------------------------------------------
            //-----------------------updating record for common person----------------------------------
            //$CommonpersonObj=$this->commonService->getRecordById(StockConstant::ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS,$common_person_pk);
            $CommonpersonObj->setFirstName($Fname);
            $CommonpersonObj->setMiddleName($Mname);
            $CommonpersonObj->setLastName($Lname);
            $CommonpersonObj->setGender($gender);
            $CommonpersonObj->setDesignation($designation);
            $CommonpersonObj->setDateOfBirth(new \Datetime($dob));
            $CommonpersonObj->setRecordActiveFlag(1);
            $CommonpersonObj->setRecordInsertDate(new \Datetime());
            $CommonpersonObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonpersonObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //------------------------------ends here---------------------------------
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        //  echo StockConstant::PROJECT_PATH.'stock/update_supplier/'.$SupplierObj->getSupplierPk();die();
        return array('msg' => 'Company update Sucessfully',
            'result' => $this->commonService->activeList('ShippingMaster'),
            'shipping_id' => $CompanyObj->getShippingPk(),
        );
    }

    //--------------------------------ends here--------------------------------------------



    public function newCompanysaveAddressDetails($request) {
        //$addressTypeId = $request->request->get('addressTypeId');

        $dataUI = json_decode($request->getContent());
        $comid = $dataUI->comid;

        $addmasterId = $dataUI->inputmasterAddId;
        $addtxnId = $dataUI->inputAddTxnId;
        //$custid=$dataUI->inputAddAddresscustId;
        $addCode = $dataUI->addCode;
        $primayStatus = $dataUI->inputisPrimaryAdd;
        $address1 = $dataUI->address1;
        $address2 = $dataUI->address2;
        $country = $dataUI->country;
        $state = $dataUI->state;
        $city = $dataUI->city;
        $district = $dataUI->district;
        //$route =$dataUI->route;
        //$locality =$dataUI->locality;
        $block = $dataUI->block;
        $postOffice = $dataUI->postOffice;
        $policeStation = $dataUI->policeStation;
        $zipcode = $dataUI->zipcode;
        // $landmark =$dataUI->landmark;
        //$gpsLatitude = $dataUI->gpsLatitude;
        //$gpsLongitude = $dataUI->gpsLongitude;
        //$recodeActiveFlag = $request->request->get('rec_status');
        $conn = $this->em->getConnection();
        try {
            $conn->beginTransaction();
            if ($addmasterId) {
                $address = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addmasterId);
                $address->setRecordUpdateDate(new \DateTime('now'));
            } else {
                $address = new CmnLocationAddressMaster();
                $address->setRecordInsertDate(new \DateTime('now'));
            }
            $address->setAddressTypeFk($this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find(1));
            $address->setAddress1($address1);
            $address->setAddress2($address2);
            $address->setCityName($city);
            $address->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city));

            if ($state != '') {
                $address->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state));
            }
            if ($country != '') {
                $address->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country));
            }
            $address->setPinNumber($zipcode);
            $address->setPoliceStation($policeStation);
            $address->setPostOffice($postOffice);
            //$address->setGpsLatitude($gpsLatitude);
            // $address->setGpsLogitude($gpsLongitude);
            //$address->setLandmark($landmark);
            if ($district != '') {
                $address->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district));
            }
            //$address->setRoute($route);
            //$address->setLocality($locality);
            $address->setBlockVillage($block);
            $address->setRecordActiveFlag(1);
            if (!$addmasterId) {
                $this->em->persist($address);
            }
            $this->em->flush();
            //address txn
            //if the new address is primary then set other existing address to value 0(non-primary)

            if ($primayStatus == 1) {
                $exAddTxn = $this->em->getRepository(CompanyConstant::ENT_COMPANY_ADDRESS_MASTER_TXN)->findByShippingFk($comid);
                foreach ($exAddTxn as $addtxn) {
                    $addtxn->setIsPrimaryAddress(0);
                    $this->em->flush();
                }
            } else {
                
            }
            //add/update the new/existing address
            if ($addtxnId) {
                $addressTxn = $this->em->getRepository(CompanyConstant::ENT_COMPANY_ADDRESS_MASTER_TXN)->find($addtxnId);
                $addressTxn->setRecordUpdateDate(new \DateTime("now"));
                $addressTxn->setApplicationUserId($this->session->get('EMPID'));
                $addressTxn->setApplicationUserIpAddress($this->session->get('IP'));
            } else {
                $addressTxn = new ShippingAddressTxn();
                $addressTxn->setAddressFk($address);
                $addressTxn->setShippingFk($this->em->getRepository(CompanyConstant::ENT_COMPANY_MASTER)->find($comid));
                $addressTxn->setRecordInsertDate(new \DateTime("now"));
                $addressTxn->setApplicationUserId($this->session->get('EMPID'));
                $addressTxn->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $addressTxn->setAddressCode($addCode);
            $addressTxn->setIsPrimaryAddress($primayStatus);
            $addressTxn->setApprovalFlag(1);
            $addressTxn->setRecordActiveFlag(1);
            if (!$addtxnId) {
                $this->em->persist($addressTxn);
            }
            $this->em->flush();
            $returncode = 1; //1 for successfull operation and O for failed orperation
            $returnmsg = $addressTxn;
            $conn->commit();
        } catch (\Doctrine\DBAL\DBALException $dbalex) {
            $conn->rollBack();
            $returncode = 0;
            $returnmsg = 'Duplicate Address Code';
            if ($this->cmnservice->isDuplicateEntry($dbalex, 'Unique_AddCode')) {
                $returnmsg = 'Address Code is already in use by the same customer.';
            }
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode = 0;
            $returnmsg = 'Unable to complete action due to technical error. Error: ' . $ex->getMessage();
        }
        //$conn->close();
        return array('code' => $returncode, 'msg' => $returnmsg);
    }

    //------------------------------updating company mobile master------------------------------
    public function UpdateCompanyMobileDetailsMaster($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //retriving pk from entity

            $comid = $dataUI->comid;
            $CompanyObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MASTER)->find($comid);
            $CommonComMobile_txnObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid));
            $com_contact_pk = $CommonComMobile_txnObj->getShipContactPk();

            //---------------------------add multiple mobile no-------------------------------------

            $mobile_no = array();
            if ($dataUI->txt_supplier_mobile == '') {

                //do nothing
            } else {
                if (is_string($dataUI->txt_supplier_mobile)) {
                    $mobile_no[0] = $dataUI->txt_supplier_mobile; //for only one 
                } else {
                    $mobile_no = $dataUI->txt_supplier_mobile;     //for more than one       
                }
                foreach ($mobile_no as $val) {   // for inserting array value
                    $CommonMobileObj = new CmnMobileNoMaster();
                    $CommonMobileObj->setMobileNo($val);
                    $CommonMobileObj->setRecordActiveFlag(1);
                    $CommonMobileObj->setRecordInsertDate(new \Datetime('NOW'));
                    $CommonMobileObj->setApplicationUserId($this->session->get('EMPID'));
                    $CommonMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($CommonMobileObj);
                    $this->em->flush();
                    //---------------for inserting mutiple mobile transaction---------------------
                    $contact_no_mobiletxnObj = new ShippingContactMobileNoTxn();
                    $contact_no_mobiletxnObj->setContactType('M');
                    $contact_no_mobiletxnObj->setMobileMasterFk($CommonMobileObj);

                    $contact_no_mobiletxnObj->setShipContactFk($this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->find($com_contact_pk));
                    $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                    $contact_no_mobiletxnObj->setRecordActiveFlag(1);
                    $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                    $contact_no_mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                    $contact_no_mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($contact_no_mobiletxnObj);
                    $this->em->flush();
                }
            }

            //------------------------------ends here--------------------------------------------------- 
            //-------------------updating record for supplier website----------------------------------  
            $website = $dataUI->Website;
            $CompanyObj->setWebsite($website);
            $this->em->flush();
            //ends here
            //-------------------updating record for common person email-------------------------------  
            $email = $dataUI->email;
            $phone_no = $dataUI->txt_supplier_phone;
            $companycontact_pkObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid, 'recordActiveFlag' => 1));
            $common_person_pk = $companycontact_pkObj->getPersonFk()->getPersonPk();
            $CommonpersonObj = $this->commonService->getRecordById(CompanyConstant::ENT_COMPANY_COMMON_PERSON_ADDRESS, $common_person_pk);
            $CommonpersonObj->setEmailId($email);
            $CommonpersonObj->setTelephoneNo($phone_no);
            $this->em->flush();
            //-------------------common person email ends here----------------------------------------- 


            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'Contact Details Updated Sucessfully',
            'result' => $this->commonService->getRecordsByArray
                    (CompanyConstant::ENT_COMMON_CONTACT, array('recordActiveFlag' => 1))
        );
    }

    //------------------------------updating company mobile master ends here


    public function ComDeleteAddress($addtxnid) {
        $conn = $this->em->getConnection();
        try {
            $conn->beginTransaction();
            $addtxn = $this->em->getRepository(CompanyConstant::ENT_COMPANY_ADDRESS_MASTER_TXN)->find($addtxnid);
            $addmaster = $addtxn->getAddressFk();
            //update address master
            $addmaster->setRecordActiveFlag(0);
            $addmaster->setRecordUpdateDate(new \DateTime("now"));
            $addmaster->setApplicationUserId($this->session->get('EMPID'));
            $addmaster->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //update address txn
            $addtxn->setApprovalFlag(0);
            $addtxn->setRecordActiveFlag(0);
            $addtxn->setRecordUpdateDate(new \DateTime("now"));
            $addtxn->setApplicationUserId($this->session->get('EMPID'));
            $addtxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit();
            $returnmsg = 'Address has been removed successfully.';
            $returncode = 1;
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg = 'Unable to process due to an unexpected server error. Error:' . $ex->getMessage();
            $returncode = 0;
        }
        $conn->close();
        return array('code' => $returncode, 'msg' => $returnmsg);
    }

    public function getcompanyMobileNodetails($comid) {

        try {
            $CommonCompanyContact_person_txnObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid));
            $com_contact_pk = $CommonCompanyContact_person_txnObj->getShipContactPk();
            $cmn_mb_Obj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MOBILE_TXN)->
                    findBy(array('shipContactFk' => $com_contact_pk, 'recordActiveFlag' => 1));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('comp_contactperson' => $CommonCompanyContact_person_txnObj, 'cmn_mobile' => $cmn_mb_Obj);
    }

    public function getcompanyMobiledetails($comid) {

        try {
            $CommonComContact_person_txnObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid));
            $com_contact_pk = $CommonComContact_person_txnObj->getShipContactPk();


            $sup_email = $CommonComContact_person_txnObj->getPersonFk()->getEmailId();
            $sup_website = $CommonComContact_person_txnObj->getShippingFk()->getWebsite();
            $cmn_person_phone = $CommonComContact_person_txnObj->getPersonFk()->getTelephoneNo();

            $cmn_mb_Obj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MOBILE_TXN)->findBy(array('shipContactFk' => $com_contact_pk, 'recordActiveFlag' => 1));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('sup_contactperson' => $CommonComContact_person_txnObj,
            'cmn_mobile' => $cmn_mb_Obj,
            'telephone' => $cmn_person_phone,
            'email' => $sup_email,
            'website' => $sup_website
        );
    }

    public function searchCompanyDetails($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $compname = $dataUI->compname;
            $person_name = $dataUI->person;
            $mobile_no = $dataUI->mobile;

            if ($compname == '') {
                
            } else {
                $parameters = array();
                $queryString = " SELECT siptxn
                             FROM TashiCommonBundle:ShippingContactTxn siptxn 
                             
                             INNER JOIN TashiCommonBundle:ShippingMaster sip
                             WITH siptxn.shippingFk=sip.shippingPk
                             
                             INNER JOIN TashiCommonBundle:ShippingContactMobileNoTxn sicmtxn
                             WITH sicmtxn.shipContactFk=siptxn.shipContactPk
                             
                             INNER JOIN TashiCommonBundle:CmnMobileNoMaster mob
                             WITH sicmtxn.mobileMasterFk=mob.pkid
                              
                             WHERE sip.recordActiveFlag=:activFlag and sip.companyName = '$compname' ";

                $parameters['activFlag'] = 1;
            }

            if ($person_name == '') {
                
            } else {
                $parameters = array();
                $queryString = " SELECT siptxn
                              FROM TashiCommonBundle:ShippingContactTxn siptxn 
                             
                              INNER JOIN TashiCommonBundle:ShippingMaster sip
                             WITH siptxn.shippingFk=sip.shippingPk
                             
                             INNER JOIN TashiCommonBundle:CmnPerson cmn
                             WITH siptxn.personFk=cmn.personPk
                             
                              INNER JOIN TashiCommonBundle:ShippingContactMobileNoTxn sicmtxn
                             WITH sicmtxn.shipContactFk=siptxn.shipContactPk
                             
                             INNER JOIN TashiCommonBundle:CmnMobileNoMaster mob
                             WITH sicmtxn.mobileMasterFk=mob.pkid
                              
                              
                             
                             WHERE siptxn.recordActiveFlag=:activFlag and cmn.firstName = '$person_name' ";

                $parameters['activFlag'] = 1;
            }

            if ($mobile_no == '') {
                
            } else {
                $parameters = array();
                $queryString = " SELECT siptxn
                              FROM TashiCommonBundle:ShippingContactTxn siptxn 
                             
                              INNER JOIN TashiCommonBundle:ShippingMaster sip
                             WITH siptxn.shippingFk=sip.shippingPk
                             
                             INNER JOIN TashiCommonBundle:ShippingContactMobileNoTxn sicmtxn
                             WITH sicmtxn.shipContactFk=siptxn.shipContactPk
                             
                             INNER JOIN TashiCommonBundle:CmnMobileNoMaster mob
                             WITH sicmtxn.mobileMasterFk=mob.pkid
                             
                             WHERE siptxn.recordActiveFlag=:activFlag and mob.mobileNo='$mobile_no'";

                $parameters['activFlag'] = 1;
            }

            if ($compname == '' && $person_name == '' && $mobile_no == '') {
                $parameters = array();
                $queryString = " SELECT shiptxn
                             FROM TashiCommonBundle:ShippingContactTxn shiptxn 
                             
                             INNER JOIN TashiCommonBundle:ShippingMaster ship
                             WITH shiptxn.shippingFk=ship.shippingPk
                             
                             INNER JOIN TashiCommonBundle:CmnPerson p
                             WITH shiptxn.personFk=p.personPk
                             
                             INNER JOIN TashiCommonBundle:ShippingContactMobileNoTxn shct
                             WITH shiptxn.shipContactPk=shct.shipContactFk
                             
                             INNER JOIN TashiCommonBundle:CmnMobileNoMaster mob
                             WITH shct.mobileMasterFk=mob.pkid
                             
                             WHERE shiptxn.recordActiveFlag=:activFlag ";

                $parameters['activFlag'] = 1;
            }

            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('result' => $resultSearch);
    }

    public function DeleteCompany($comid) {
        $conn = $this->em->getConnection();
        try {
            $conn->beginTransaction();
            $company = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MASTER)->find($comid);
            $conTxn = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findByshippingFk($company);
            $conmobTxn = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MOBILE_TXN)->findByshipContactFk($conTxn);
            $conadressTxn = $this->em->getRepository(CompanyConstant::ENT_COMPANY_ADDRESS_MASTER_TXN)->findByshippingFk($company);
            if ($conTxn) {
                //delete corresponding Contact Txn and Contact                
                foreach ($conTxn as $cont) {
                    $cont->setApprovalFlag(0);
                    $cont->setRecordActiveFlag(0);
                    $person = $cont->getPersonFk();
                    $person->setRecordActiveFlag(0);
                }
            }
            if ($conadressTxn) {
                //delete corresponding address Txn and CommonLocationAddress                
                foreach ($conadressTxn as $conaddrs) {
                    $conaddrs->setApprovalFlag(0);
                    $conaddrs->setRecordActiveFlag(0);

                    $address = $conaddrs->getAddressFk();
                    $address->setRecordActiveFlag(0);
                }
            }
            if ($conmobTxn) {
                //Delete Contact_Mobile_Txn and Mobile Number
                foreach ($conmobTxn as $cmob) {
                    $cmob->setApprovalFlag(0);
                    $cmob->setRecordActiveFlag(0);

                    $mobile = $cmob->getMobileMasterFk();

                    $mobile->setApprovalFlag(0);
                    $mobile->setRecordActiveFlag(0);
                }
            }
            //$supplier->setStatusFlag(0);
            $company->setRecordActiveFlag(0);

            $this->em->flush();
            $conn->commit();
            $returncode = 1;
            $returnmsg = 'Company and other related detail has been deleted successfully';
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode = 0;
            $returnmsg = 'Unable to process due to an unexpected server error. Error:' . $ex->getMessage();
        }
        return array('code' => $returncode, 'msg' => $returnmsg);
    }

    //---------------------------inserting record for company mobile details--------------------------

    public function addCompanyMobileMaster($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());
            $comid = $dataUI->comid;
            $CompanyObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MASTER)->find($comid);
            $CompanycontactObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid));
            $com_contact_id = $CompanycontactObj->getShipContactPk();


            //---------------------------add multiple mobile no-------------------------------------
            $mobile_no = array();
            if (is_string($dataUI->txt_supplier_mobile)) {
                $mobile_no[0] = $dataUI->txt_supplier_mobile; //for only one 
            } else {
                $mobile_no = $dataUI->txt_supplier_mobile;     //for more than one       
            }
            foreach ($mobile_no as $val) {   // for inserting array value
                $CommonMobileObj = new CmnMobileNoMaster();
                $CommonMobileObj->setMobileNo($val);
                $CommonMobileObj->setRecordActiveFlag(1);
                $CommonMobileObj->setRecordInsertDate(new \Datetime('NOW'));
                $CommonMobileObj->setApplicationUserId($this->session->get('EMPID'));
                $CommonMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($CommonMobileObj);
                $this->em->flush();
                //---------------for inserting mutiple mobile transaction---------------------
                $contact_no_mobiletxnObj = new ShippingContactMobileNoTxn();
                $contact_no_mobiletxnObj->setContactType('M');
                $contact_no_mobiletxnObj->setMobileMasterFk($CommonMobileObj);

                $contact_no_mobiletxnObj->setShipContactFk($this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->find($com_contact_id));
                $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                $contact_no_mobiletxnObj->setRecordActiveFlag(1);
                $contact_no_mobiletxnObj->setRecordInsertDate(new \Datetime());
                $contact_no_mobiletxnObj->setApplicationUserId($this->session->get('EMPID'));
                $contact_no_mobiletxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($contact_no_mobiletxnObj);
                $this->em->flush();
                //-------------------------ends here-----------------------------
            }
            //ends here 
            //-------------------updating record for supplier website----------------------------------  
            $website = $dataUI->Website;
            $CompanyObj->setWebsite($website);
            $this->em->flush();
            //ends here
            //-------------------updating record for common person email-------------------------------  
            $email = $dataUI->email;
            $phone_no = $dataUI->txt_supplier_phone;
            $companycontact_pkObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid, 'recordActiveFlag' => 1));
            $common_person_pk = $companycontact_pkObj->getPersonFk()->getPersonPk();
            $CommonpersonObj = $this->commonService->getRecordById(CompanyConstant::ENT_COMPANY_COMMON_PERSON_ADDRESS, $common_person_pk);
            $CommonpersonObj->setEmailId($email);
            $CommonpersonObj->setTelephoneNo($phone_no);
            $this->em->flush();
            //-------------------common person email ends here----------------------------------------- 


            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'Contact Details Save Sucessfully',
            'result' => $this->commonService->getRecordsByArray
                    (CompanyConstant::ENT_COMMON_CONTACT, array('recordActiveFlag' => 1)),
            'id' => $CommonMobileObj->getPkid()
        );
    }

    //------------------------------company mobile insert completed ----------------------------------    
    //Delete company contact details section
    public function DeleteCompanyContactDetailsMaster($request, $comid) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());

            //inserting record for supplier master
            $comid = $dataUI->comid;
            $CommonCompanyMobile_txnObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid));
            $comcontact_pk = $CommonCompanyMobile_txnObj->getShipContactPk();

            $company_cmn_mb_txn_Obj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MOBILE_TXN)->
                    findBy(array('shipContactFk' => $comcontact_pk, 'recordActiveFlag' => 1));

            //$CommonSupMobile_txnObj->getPersonFk();
            $Cmn_person_pk = $CommonCompanyMobile_txnObj->getPersonFk()->getPersonPk();

            $CommonPersonObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_COMMON_PERSON_ADDRESS)->find($Cmn_person_pk);

            //deleting record for common persong table
            $CommonPersonObj->setEmailId('');
            $CommonPersonObj->setTelephoneNo('');
            $this->em->flush();
            //deleting record ends here
            //deleting record for supplier website 

            $CompanyObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MASTER)->find($comid);
            $CompanyObj->setWebsite('');
            $this->em->flush();

            //ends here
            //deleting record for supplier_mobile_contact_txn details

            foreach ($company_cmn_mb_txn_Obj as $val) {
                $val->setRecordActiveFlag(0);
                $val->setRecordInsertDate(new \Datetime());
                $val->setApplicationUserId($this->session->get('EMPID'));
                $val->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }
            //ends here
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Contact Details Deleted Sucessfully',
            'result' => $this->commonService->getRecordsByArray
                    (CompanyConstant::ENT_COMMON_CONTACT, array('recordActiveFlag' => 1))
        );
    }

    //Delete company contact details section ends here
    //------------------------------updating company mobile master------------------------------
    public function UpdateCompanyMobileListDetailsMaster($request, $mob_id) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {


            $dataUI = json_decode($request->getContent());
            $mobile = $dataUI->mobileno;
            $CommonMobile = $this->em->getRepository(CompanyConstant::ENT_COMMON_CONTACT)->findOneBy(array('pkid' => $mob_id));
            $CommonMobile->setMobileNo($mobile);
            $CommonMobile->setRecordActiveFlag(1);
            $CommonMobile->setRecordInsertDate(new \Datetime('NOW'));
            $CommonMobile->setApplicationUserId($this->session->get('EMPID'));
            $CommonMobile->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Mobile Details Updated Sucessfully', 'result' => $this->commonService->getRecordsByArray
                    (CompanyConstant::ENT_COMMON_CONTACT, array('recordActiveFlag' => 1)), 'id' => $CommonMobile->getPkid()
        );
    }

    //------------------------------updating supplier mobile master ends here
    //Delete Mobile No List only
    public function DeleteCompanyMobileMaster($request, $mob_id) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            //deleting record for supplier mobile list master
            $dataUI = json_decode($request->getContent());
            $comid = $dataUI->comid;

            $CommonComContact_person_txnObj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_CONTACT_TXN)->findOneBy(array('shippingFk' => $comid));
            $company_contact_pk = $CommonComContact_person_txnObj->getShipContactPk();

            $CommonMobile_txnObj = $this->em->getRepository(CompanyConstant::ENT_COMMON_CONTACT)->find($mob_id);

            $supplier_cmn_mb_txn_Obj = $this->em->getRepository(CompanyConstant::ENT_COMPANY_MOBILE_TXN)->findOneByMobileMasterFk($mob_id);

            //deleting record for supplier contact_txn details master
            $CommonMobile_txnObj->setRecordActiveFlag(0);
            $CommonMobile_txnObj->setRecordInsertDate(new \Datetime());
            $CommonMobile_txnObj->setApplicationUserId($this->session->get('EMPID'));
            $CommonMobile_txnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here


            $supplier_cmn_mb_txn_Obj->setRecordActiveFlag(0);
            $supplier_cmn_mb_txn_Obj->setRecordInsertDate(new \Datetime());
            $supplier_cmn_mb_txn_Obj->setApplicationUserId($this->session->get('EMPID'));
            $supplier_cmn_mb_txn_Obj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Contact Details Deleted Sucessfully',
            'result' => $this->commonService->getRecordsByArray
                    (CompanyConstant::ENT_COMMON_CONTACT, array('recordActiveFlag' => 1))
        );
    }

    //Mobile No List Section ends here
}

?>
