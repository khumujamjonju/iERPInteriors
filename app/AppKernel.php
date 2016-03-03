<?php
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Tashi\AccountBundle\TashiAccountBundle(),
            new Tashi\AssetBundle\TashiAssetBundle(),
            new Tashi\CommonBundle\TashiCommonBundle(),
            new Tashi\CompanyBundle\TashiCompanyBundle(),
            new Tashi\CustomerBundle\TashiCustomerBundle(),
            new Tashi\DashboardBundle\TashiDashboardBundle(),
            new Tashi\EmployeeBundle\TashiEmployeeBundle(),
            new Tashi\InvoiceBundle\TashiInvoiceBundle(),
            new Tashi\LocationBundle\TashiLocationBundle(),
            new Tashi\PayrollBundle\TashiPayrollBundle(),
            new Tashi\LoginBundle\TashiLoginBundle(),
            new Tashi\ProductBundle\TashiProductBundle(),
            new Tashi\ProjectBundle\TashiProjectBundle(),
            new Tashi\PurchaseBundle\TashiPurchaseBundle(),
            new Tashi\ReportBundle\TashiReportBundle(),
           new Tashi\RequisitionBundle\RequisitionBundle(),
            new Tashi\StockBundle\TashiStockBundle(),
            new Tashi\StoreBundle\TashiStoreBundle(),
            new Tashi\SupplierBundle\TashiSupplierBundle(),
            new Tashi\SystemSettingBundle\TashiSystemSettingBundle(),
            new Tashi\UserBundle\TashiUserBundle(),
            new Tashi\WalletBundle\TashiWalletBundle(),
            new Tashi\KnpSnappyBundle\KnpSnappyBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
