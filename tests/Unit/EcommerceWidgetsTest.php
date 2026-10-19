<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KPIWidgets\tests\Unit;

use Piwik\Plugin\Manager as PluginManager;
use Piwik\Plugins\KPIWidgets\Services\MetricsService;
use Piwik\Plugins\KPIWidgets\Widgets\Base;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsAbandonedCartRevenue;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsAbandonedCarts;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsAverageOrderValue;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsAverageRevenuePerPayingUser;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsAverageRevenuePerUser;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsEcommerceConversionRate;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsEcommerceOrders;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsEcommerceRevenue;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsFirstTimePurchasers;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsNetRevenue;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsProductsLeftInCarts;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsProductsSold;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsPurchasers;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsRefundedRevenue;
use Piwik\Plugins\KPIWidgets\Widgets\KPIWidgetsVisitsWithAnOrder;
use Piwik\Site;
use Piwik\Tests\Framework\TestCase\UnitTestCase;
use Piwik\Widget\WidgetConfig;

/**
 * @group KPIWidgets
 * @group Unit
 */
class EcommerceWidgetsTest extends UnitTestCase
{
    private const ECOMMERCE_SITE = 7;
    private const NON_ECOMMERCE_SITE = 8;

    private const NATIVE = [
        KPIWidgetsEcommerceOrders::class,
        KPIWidgetsEcommerceRevenue::class,
        KPIWidgetsAverageOrderValue::class,
        KPIWidgetsEcommerceConversionRate::class,
        KPIWidgetsProductsSold::class,
        KPIWidgetsVisitsWithAnOrder::class,
        KPIWidgetsAbandonedCarts::class,
        KPIWidgetsAbandonedCartRevenue::class,
        KPIWidgetsProductsLeftInCarts::class,
    ];

    private const ENHANCED = [
        KPIWidgetsPurchasers::class,
        KPIWidgetsFirstTimePurchasers::class,
        KPIWidgetsAverageRevenuePerUser::class,
        KPIWidgetsAverageRevenuePerPayingUser::class,
    ];

    private const PREMIUM = [
        KPIWidgetsRefundedRevenue::class,
        KPIWidgetsNetRevenue::class,
    ];

    /** @var string[] */
    private $activePlugins = [];

    private $backupGet;
    private $backupPost;

    public function setUp(): void
    {
        parent::setUp();

        $this->backupGet = $_GET;
        $this->backupPost = $_POST;
        $_GET = ['idSite' => (string) self::ECOMMERCE_SITE, 'period' => 'month', 'date' => '2026-09-01'];
        $_POST = [];

        $this->activePlugins = ['Goals', 'Ecommerce', 'EcommerceEnhanced', 'EcommerceEnhancedPremium'];

        Site::setSiteFromArray(self::ECOMMERCE_SITE, ['idsite' => self::ECOMMERCE_SITE, 'ecommerce' => 1, 'currency' => 'EUR', 'timezone' => 'UTC']);
        Site::setSiteFromArray(self::NON_ECOMMERCE_SITE, ['idsite' => self::NON_ECOMMERCE_SITE, 'ecommerce' => 0, 'currency' => 'EUR', 'timezone' => 'UTC']);
        MetricsService::clearCache();
    }

    public function tearDown(): void
    {
        $_GET = $this->backupGet;
        $_POST = $this->backupPost;
        Site::clearCache();
        MetricsService::clearCache();

        parent::tearDown();
    }

    protected function provideContainerConfig()
    {
        $pluginManager = $this->createMock(PluginManager::class);
        $pluginManager->method('isPluginActivated')->willReturnCallback(function ($plugin) {
            return in_array($plugin, $this->activePlugins, true);
        });
        $pluginManager->method('getPluginsLoadedAndActivated')->willReturn([]);
        $pluginManager->method('getLoadedPlugins')->willReturn([]);
        $pluginManager->method('getActivatedPlugins')->willReturn([]);
        $pluginManager->method('getLoadedPluginsName')->willReturn([]);

        return [PluginManager::class => $pluginManager];
    }

    /**
     * @dataProvider getWidgetDefinitions
     */
    public function testWidgetDefinition(
        string $widgetClass,
        string $apiMethod,
        array $apiParameters,
        string $metricKey,
        string $format,
        bool $isLowerValueBetter
    ) {
        $this->assertSame($apiMethod, $this->callStatic($widgetClass, 'getApiMethod'));
        $this->assertSame($apiParameters, $this->callStatic($widgetClass, 'getApiParameters'));
        $this->assertSame($metricKey, $this->callStatic($widgetClass, 'getMetricKey'));
        $this->assertSame($format, $this->callStatic($widgetClass, 'getFormat'));
        $this->assertSame($isLowerValueBetter, $this->callStatic($widgetClass, 'isLowerValueBetter'));
        $this->assertTrue($this->callStatic($widgetClass, 'isMissingMetricUnavailable'));

        $config = $this->configure($widgetClass);
        $this->assertSame('KPIWidgets_KPI', $config->getCategoryId());
        $this->assertSame(Base::SUBCATEGORY_ECOMMERCE, $config->getSubcategoryId());
    }

    public function getWidgetDefinitions(): array
    {
        $order = ['idGoal' => 'ecommerceOrder'];
        $cart = ['idGoal' => 'ecommerceAbandonedCart'];

        return [
            [KPIWidgetsEcommerceOrders::class, 'Goals.get', $order, 'nb_conversions', Base::FORMAT_NUMBER, false],
            [KPIWidgetsEcommerceRevenue::class, 'Goals.get', $order, 'revenue', Base::FORMAT_MONEY, false],
            [KPIWidgetsAverageOrderValue::class, 'Goals.get', $order, 'avg_order_revenue', Base::FORMAT_MONEY, false],
            [KPIWidgetsEcommerceConversionRate::class, 'Goals.get', $order, 'conversion_rate', Base::FORMAT_RAW, false],
            [KPIWidgetsProductsSold::class, 'Goals.get', $order, 'items', Base::FORMAT_NUMBER, false],
            [KPIWidgetsVisitsWithAnOrder::class, 'Goals.get', $order, 'nb_visits_converted', Base::FORMAT_NUMBER, false],
            [KPIWidgetsAbandonedCarts::class, 'Goals.get', $cart, 'nb_conversions', Base::FORMAT_NUMBER, true],
            [KPIWidgetsAbandonedCartRevenue::class, 'Goals.get', $cart, 'revenue', Base::FORMAT_MONEY, true],
            [KPIWidgetsProductsLeftInCarts::class, 'Goals.get', $cart, 'items', Base::FORMAT_NUMBER, true],
            [KPIWidgetsPurchasers::class, 'EcommerceEnhanced.getBuyerKpis', [], 'ee_purchasers', Base::FORMAT_NUMBER, false],
            [KPIWidgetsFirstTimePurchasers::class, 'EcommerceEnhanced.getBuyerKpis', [], 'ee_first_time_purchasers', Base::FORMAT_NUMBER, false],
            [KPIWidgetsAverageRevenuePerUser::class, 'EcommerceEnhanced.getBuyerKpis', [], 'ee_arpu', Base::FORMAT_MONEY, false],
            [KPIWidgetsAverageRevenuePerPayingUser::class, 'EcommerceEnhanced.getBuyerKpis', [], 'ee_arppu', Base::FORMAT_MONEY, false],
            [KPIWidgetsRefundedRevenue::class, 'EcommerceEnhancedPremium.getRefunds', [], 'ee_refund_amount', Base::FORMAT_MONEY, true],
            [KPIWidgetsNetRevenue::class, 'EcommerceEnhancedPremium.getRefunds', [], 'ee_net_revenue', Base::FORMAT_MONEY, false],
        ];
    }

    public function testAllWidgetsListedOnEcommerceSiteWithEveryPluginActive()
    {
        $this->assertEnabled(array_merge(self::NATIVE, self::ENHANCED, self::PREMIUM), true);
    }

    public function testNoWidgetListedOnSiteWithoutEcommerce()
    {
        $_GET['idSite'] = (string) self::NON_ECOMMERCE_SITE;

        $this->assertEnabled(array_merge(self::NATIVE, self::ENHANCED, self::PREMIUM), false);
    }

    public function testNoWidgetListedWithoutSite()
    {
        unset($_GET['idSite']);

        $this->assertEnabled(array_merge(self::NATIVE, self::ENHANCED, self::PREMIUM), false);
    }

    public function testOnlyNativeWidgetsListedWhenEcommerceEnhancedIsInactive()
    {
        $this->activePlugins = ['Goals', 'Ecommerce'];

        $this->assertEnabled(self::NATIVE, true);
        $this->assertEnabled(array_merge(self::ENHANCED, self::PREMIUM), false);
    }

    public function testPremiumWidgetsHiddenWhenOnlyFreeEcommerceEnhancedIsActive()
    {
        $this->activePlugins = ['Goals', 'Ecommerce', 'EcommerceEnhanced'];

        $this->assertEnabled(array_merge(self::NATIVE, self::ENHANCED), true);
        $this->assertEnabled(self::PREMIUM, false);
    }

    public function testPremiumWidgetsNeedTheFreePluginToo()
    {
        $this->activePlugins = ['Goals', 'Ecommerce', 'EcommerceEnhancedPremium'];

        $this->assertEnabled(self::NATIVE, true);
        $this->assertEnabled(array_merge(self::ENHANCED, self::PREMIUM), false);
    }

    public function testNoWidgetListedWhenGoalsIsInactive()
    {
        $this->activePlugins = ['Ecommerce', 'EcommerceEnhanced', 'EcommerceEnhancedPremium'];

        $this->assertEnabled(array_merge(self::NATIVE, self::ENHANCED, self::PREMIUM), false);
    }

    public function testApiMethodAvailabilityFollowsPluginActivation()
    {
        $this->activePlugins = ['Goals'];

        $this->assertTrue(MetricsService::isApiMethodAvailable('API.get'));
        $this->assertTrue(MetricsService::isApiMethodAvailable('Goals.get'));
        $this->assertFalse(MetricsService::isApiMethodAvailable('EcommerceEnhanced.getBuyerKpis'));
        $this->assertFalse(MetricsService::isApiMethodAvailable('EcommerceEnhancedPremium.getRefunds'));
        $this->assertFalse(MetricsService::isApiMethodAvailable('invalid'));
    }

    public function testInactiveSourceReturnsNullBeforeAnyCacheOrAccessCheck()
    {
        $this->activePlugins = ['Goals', 'Ecommerce'];

        $this->assertNull(MetricsService::getReportMetrics('EcommerceEnhanced.getBuyerKpis', self::ECOMMERCE_SITE, 'month', '2026-09-01'));
        $this->assertNull(MetricsService::getReportEvolution('EcommerceEnhanced.getBuyerKpis', self::ECOMMERCE_SITE, 'month', '2026-09-01', 'ee_purchasers'));
    }

    public function testWidgetOfDeactivatedPluginRendersUnavailableInsteadOfFailing()
    {
        $this->activePlugins = ['Goals', 'Ecommerce'];

        $html = (new KPIWidgetsPurchasers())->render();

        $this->assertStringContainsString('vue-entry="KPIWidgets.KPIWidget"', $html);
        $this->assertStringContainsString('value="&quot;-&quot;"', $html);
        $this->assertStringContainsString('evolution="null"', $html);
    }

    public function testFindMetricValue()
    {
        $this->assertNull(MetricsService::findMetricValue(null, 'ee_arpu'));
        $this->assertNull(MetricsService::findMetricValue((object) ['ee_arppu' => 12.5], 'ee_arpu'));
        $this->assertSame(0, MetricsService::findMetricValue((object) ['ee_arpu' => 0], 'ee_arpu'));
        $this->assertSame(3.2, MetricsService::findMetricValue((object) ['ee_arpu' => 3.2], 'ee_arpu'));
    }

    private function assertEnabled(array $widgetClasses, bool $expected): void
    {
        foreach ($widgetClasses as $widgetClass) {
            $this->assertSame($expected, $this->configure($widgetClass)->isEnabled(), $widgetClass);
        }
    }

    private function configure(string $widgetClass): WidgetConfig
    {
        $config = new WidgetConfig();
        $widgetClass::configure($config);

        return $config;
    }

    private function callStatic(string $widgetClass, string $method)
    {
        $reflection = new \ReflectionMethod($widgetClass, $method);
        $reflection->setAccessible(true);

        return $reflection->invoke(null);
    }
}
