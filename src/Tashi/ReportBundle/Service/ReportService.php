<?php
namespace Tashi\ReportBundle\Service;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportService
 *
 * @author KHUMUPOKPAM
 */
class ReportService {
    //put your code here
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;
            
    public function __construct(EntityManager $em, Session $session, $rootDir,$commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService = $commonService;
    }
}
