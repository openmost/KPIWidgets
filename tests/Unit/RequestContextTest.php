<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KPIWidgets\tests\Unit;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\KPIWidgets\Services\MetricsService;

/**
 * @group KPIWidgets
 * @group Unit
 */
class RequestContextTest extends TestCase
{
    private $backupGet;
    private $backupPost;

    public function setUp(): void
    {
        parent::setUp();
        $this->backupGet = $_GET;
        $this->backupPost = $_POST;
        $_GET = [];
        $_POST = [];
    }

    public function tearDown(): void
    {
        $_GET = $this->backupGet;
        $_POST = $this->backupPost;
        parent::tearDown();
    }

    public function testDefaultsWhenParametersAreMissing()
    {
        $this->assertSame(['idSite' => 1, 'period' => 'day', 'date' => 'today'], MetricsService::getRequestContext());
    }

    public function testEmptyParametersFallBackToDefaults()
    {
        $_GET = ['idSite' => '', 'period' => '', 'date' => ''];

        $this->assertSame(['idSite' => 1, 'period' => 'day', 'date' => 'today'], MetricsService::getRequestContext());
    }

    public function testReadsGetThenPost()
    {
        $_GET = ['idSite' => '3', 'period' => 'range'];
        $_POST = ['idSite' => '9', 'date' => '2026-01-01,2026-01-31'];

        $this->assertSame(
            ['idSite' => 3, 'period' => 'range', 'date' => '2026-01-01,2026-01-31'],
            MetricsService::getRequestContext()
        );
    }

    public function testInvalidTypesFallBackToDefaults()
    {
        $_GET = ['idSite' => 'abc', 'period' => ['week'], 'date' => ['yesterday']];

        $this->assertSame(['idSite' => 1, 'period' => 'day', 'date' => 'today'], MetricsService::getRequestContext());
    }
}
