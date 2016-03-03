<?php

namespace Tashi\AssetBundle\Helper;

/**
 * Description of CmsConstant
 *
 * @author 5066
 */
class AssetConstant {
    ///////////// Employee ID prefix String////////

    const ASSET_ID_PREFIX = 'ASSET-';

    ///////////// Fix Project Path////////
    const PROJECT_PATH = '/Tashi/web/app_dev.php/asset';

    /////////// Service Class Constant////////   
    const SERVICE_ASSET = 'tashi.asset.service';


    /////////// Twig File Constant///////////
    const TWIG_DISPLAY_ASSETCATEGORY = 'TashiAssetBundle:Asset:displayAssetCategory.html.twig';
    const TWIG_DISPLAY_ASSETREGISTER = 'TashiAssetBundle:Asset:displayAssetRegister.html.twig';
    const TWIG_DISPLAY_ASSETASSIGN = 'TashiAssetBundle:Asset:assignAssetPageAfterInsert.html.twig';
    const TWIG_DISPLAY_ASSET = 'TashiAssetBundle:Asset:displayAssetList.html.twig';
    const TWIG_SEARCH_ASSET_RESULT = 'TashiAssetBundle:Asset:searchAssetResult.html.twig';
    const TWIG_SEARCH_ASSET = 'TashiAssetBundle:Asset:searchAsset.html.twig';
    const TWIG_STATUS_UPDATE_ASSET = 'TashiAssetBundle:Asset:assetStatusUpdate.html.twig';
    const TWIG_ASSET_EMP_ASSIGN = 'TashiAssetBundle:Asset:assetEmpAssignSearch.html.twig';
    
   
    //////////////////////////////
    const ENT_EMPLOYMENT_MASTER = 'TashiCommonBundle:EmpEmployeeMaster';
    const ASS_CATEGORY_MASTER = 'TashiCommonBundle:AssetCategoryMaster';
    const ASS_MASTER = 'TashiCommonBundle:AssetMaster';
    const ASS_MASTER_TXN = 'TashiCommonBundle:AssetStatusTxn';
    const ASS_STATUS_MASTER = 'TashiCommonBundle:AssetStatusMaster';
    
  

}
