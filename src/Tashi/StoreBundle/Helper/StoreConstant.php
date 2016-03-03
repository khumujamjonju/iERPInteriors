<?php
namespace Tashi\StoreBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreConstant
 *
 * @author Administrator
 */
class StoreConstant {
    //put your code here
    //SERVICE CONSTANT
    const SERVICE_STORE='tashi.store.service';
    
    //TWIG CONSTANT
    const TWIG_STORE_DASHBOARD='TashiStoreBundle:Store:storeDashboard.html.twig' ;
    const TWIG_STORE_ADD_STORE='TashiStoreBundle:Store:addStore.html.twig';
    const TWIG_STORE_ADD_BUILDING='TashiStoreBundle:Store:addStoreBuilding.html.twig';
    const TWIG_STORE_FLOOR='TashiStoreBundle:Store:storeFloor.html.twig';
    const TWIG_STORE_ROOM='TashiStoreBundle:Store:storeRoom.html.twig';
    const TWIG_STORE_RACK='TashiStoreBundle:Store:storeRack.html.twig';
    const TWIG_STORE_BIN='TashiStoreBundle:Store:addBin.html.twig';
    const TWIG_EDIT_BIN='TashiStoreBundle:Store:editBin.html.twig';
    const TWIG_addStore = 'TashiStoreBundle:Store:addStore.html.twig';
    const TWIG_Display_addStore = 'TashiStoreBundle:Store:displayAddStore.html.twig';
    const TWIG_Display_addStoreBuilding = 'TashiStoreBundle:Store:displayAddStoreBuilding.html.twig';
    const TWIG_Display_StoreFloor = 'TashiStoreBundle:Store:displayStoreFloor.html.twig';
    const TWIG_Display_StoreRoom = 'TashiStoreBundle:Store:displayStoreRoom.html.twig';
    const TWIG_Display_StoreRack = 'TashiStoreBundle:Store:displayStoreRack.html.twig';
    const TWIG_BIN_LIST = 'TashiStoreBundle:Store:displayBin.html.twig';
    const TWIG_STORE_LIST = 'TashiStoreBundle:Store:cmnStoreList.html.twig';
    
    
    const TWIG_BUILDING_LIST = 'TashiStoreBundle:Store:storeBuildingList.html.twig';
    const TWIG_FLOOR_LIST = 'TashiStoreBundle:Store:storeFloorList.html.twig';
    
    const TWIG_APPEND_BUILD = 'TashiStoreBundle:Store:appendBuilding.html.twig';
    const TWIG_APPEND_FLOOR = 'TashiStoreBundle:Store:appendFloor.html.twig';
    const TWIG_APPEND_ROOM = 'TashiStoreBundle:Store:appendRoom.html.twig';
    
    
    
    
    const TWIG_CIM_STATE_LIST = 'TashiStoreBundle:Store:storeStateList.html.twig';
    const TWIG_CIM_CITY_LIST = 'TashiStoreBundle:Store:storeCityList.html.twig';
    const TWIG_CUSTOMER_DISTRICT_LIST = 'TashiStoreBundle:Store:storeDistrictList.html.twig';
    const TWIG_LOCATION_LOAD = 'TashiStoreBundle:Store:storeLocationLoadList.html.twig';
}
