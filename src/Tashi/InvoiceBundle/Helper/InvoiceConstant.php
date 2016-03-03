<?php
namespace Tashi\InvoiceBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InvoiceConstant
 *
 * @author Administrator
 */
class InvoiceConstant {
    //put your code here
    
    //SERVICE CONSTANT
    const SERVICE_INVOICE='tashi.invoice.service';
    
    //TWIG CONSTANT
    const TWIG_INV_DASHBOARD = 'TashiInvoiceBundle:Invoice:invoiceDashboard.html.twig';
    const TWIG_INV_APPROVE_INVOICE='TashiInvoiceBundle:Invoice:approveinvoice.html.twig';
    const TWIG_INV_MASTER_SALES='TashiInvoiceBundle:Invoice:invoiceMasteSales.html.twig' ;
    const TWIG_INV_SEARCH_INVOICE='TashiInvoiceBundle:Invoice:SearchInvoice.html.twig' ;
    const TWIG_NEW_INVOICE='TashiInvoiceBundle:Invoice:NewInvoiceMain.html.twig' ;
    const TWIG_CREATE_INVOICE='TashiInvoiceBundle:Invoice:CreateInvoice.html.twig' ;
    const TWIG_INVOICE_ITEM_SEL_LIST='TashiInvoiceBundle:Invoice:InvoiceItemSelectionList.html.twig' ;
    const TWIG_PROJECT_LIST='TashiInvoiceBundle:Invoice:ProjectList.html.twig' ;
    const TWIG_INVOICE_CONFIRMED='TashiInvoiceBundle:Invoice:InvoiceConfirmationPage.html.twig' ;
    const TWIG_PRINT_INVOICE='TashiInvoiceBundle:Invoice:InvoicePrintTemplate.html.twig' ;
    const TWIG_INVOICE_LIST='TashiInvoiceBundle:Invoice:InvoiceList.html.twig' ;
    const TWIG_INVOICE_DETAIL='TashiInvoiceBundle:Invoice:InvoiceDetail.html.twig' ;
    const TWIG_UNAPPROVE_INVOICE_DETAIL='TashiInvoiceBundle:Invoice:UnapproveInvoiceList.html.twig' ;
    const TWIG_SEARCH_INVOICE='TashiInvoiceBundle:Invoice:SearchInvoice.html.twig' ;
    const TWIG_INVOICE_PAYMENT_HISTORY='TashiInvoiceBundle:Invoice:InvoicePaymentHistory.html.twig' ;
    const TWIG_EDIT_INVOICE='TashiInvoiceBundle:Invoice:EditInvoice.html.twig' ;
    const TWIG_EDIT_INVOICE_ITEM_LIST='TashiInvoiceBundle:Invoice:EditInvoiceItemList.html.twig' ;
}

