<?php

namespace Tests\Support;

use CodeIgniter\Settings\Handlers\ArrayHandler;
use CodeIgniter\Settings\Settings;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;
use Nexus\PHPUnit\Extension\Expeditable;

abstract class TestCase extends CIUnitTestCase
{
    use Expeditable;

    protected $namespace = 'CodeIgniter\Settings';
    protected $refresh   = true;

    /**
     * @var string
     */
    protected $table;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        helper(['auth', 'preferences']);
    }

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * Sets up the ArrayHandler for faster & easier tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config           = config('Settings');
        $config->handlers = ['array'];
        $this->settings   = new Settings($config);

        Services::injectMock('settings', $this->settings);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->resetServices();
    }
}
