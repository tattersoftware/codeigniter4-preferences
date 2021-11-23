<?php

use Tests\Support\TestCase;

/**
 * @internal
 */
final class SettingsTest extends TestCase
{
    /**
     * Authenticates a fake user (via Imposter).
     */
    protected function setUp(): void
    {
        parent::setUp();

        service('auth')->login(1);
    }

    public function testSets()
    {
        preference('Food.fruit', 'Pineapple');

        $this->assertSame('Pineapple', $this->settings->get('Food.fruit', 'user:1'));
    }

    public function testGets()
    {
        $this->settings->set('Food.fruit', 'Orange', 'user:1');

        $this->assertSame('Orange', preference('Food.fruit'));
    }

    public function testForgets()
    {
        preference('Food.fruit', 'Celery');
        $this->assertSame('Celery', $this->settings->get('Food.fruit', 'user:1'));

        preference('Food.fruit', null);

        $this->assertSame('Apple', preference('Food.fruit'));
    }
}
