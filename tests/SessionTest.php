<?php

use Tests\Support\TestCase;

/**
 * @internal
 */
final class SessionTest extends TestCase
{
    public function testGetsDefault()
    {
        $this->assertSame('Apple', preference('Food.fruit'));
    }

    public function testGets()
    {
        session()->set('settings-Food.fruit', 'Pear');

        $this->assertSame('Pear', preference('Food.fruit'));
    }

    public function testSets()
    {
        preference('Food.fruit', 'Grapefruit');

        $this->assertSame('Grapefruit', session('settings-Food.fruit'));
    }

    public function testForgets()
    {
        session()->set('settings-Food.fruit', 'Pear');

        preference('Food.fruit', null);

        $this->assertFalse(session()->has('settings-Food.fruit'));
    }
}
