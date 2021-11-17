<?php

use CodeIgniter\I18n\Time;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class HelperTest extends TestCase
{
    use DatabaseTestTrait;

/*
    function preference(string $key, $value = null)
    {
        $setting = service('settings');

		// Check for an active user
		if (null === $userId = user_id()) {
	        // Allow anonymous gets
    	    if (count(func_get_args()) === 1) {
        	    return $setting->get($key);
	        }

			throw new RuntimeException('You cannot set a preference without an active user.');
		}

		// Getting the contextual value
		$context = 'user:' . $userId;
		if (count(func_get_args()) === 1) {
			return $setting->get($key, $context);
		}

        // Setting the contextual value
        return $setting->set($key, $value, $context);
    }
}
*/

    public function testAnonymousGets()
    {
        $this->assertSame('Apple', preference('Food.fruit'));
    }

    public function testAnonymousThrowsOnSet()
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('You cannot set a preference without an active user.');

        preference('Food.fruit', 'Banana');
    }

    public function testSets()
    {
    	service('auth')->login(1);

		preference('Food.fruit', 'Pineapple');

        $this->seeInDatabase($this->table, [
            'class'   => 'Tests\Support\Config\Food',
            'key'     => 'fruit',
            'value'   => 'Pineapple',
            'type'    => 'string',
            'context' => 'user:1',
        ]);
    }

    public function testGets()
    {
    	service('auth')->login(1);

        $this->hasInDatabase($this->table, [
            'class'      => 'Tests\Support\Config\Food',
            'key'        => 'fruit',
            'value'      => 'Orange',
            'created_at' => Time::now()->toDateTimeString(),
            'updated_at' => Time::now()->toDateTimeString(),
        ]);

		$this->assertSame('Orange', preference('Food.fruit'));
	}
/*
    public function testReturnsValueDotArray()
    {
        $this->hasInDatabase($this->table, [
            'class'      => 'Foo',
            'key'        => 'bar',
            'value'      => 'baz',
            'type'       => 'string',
            'created_at' => Time::now()->toDateTimeString(),
            'updated_at' => Time::now()->toDateTimeString(),
        ]);

        $this->assertSame('baz', setting('Foo.bar'));
    }

    public function testSettingValueDotArray()
    {
        $this->hasInDatabase($this->table, [
            'class'      => 'Foo',
            'key'        => 'bar',
            'value'      => 'baz',
            'type'       => 'string',
            'created_at' => Time::now()->toDateTimeString(),
            'updated_at' => Time::now()->toDateTimeString(),
        ]);

        setting('Foo.bar', false);

        $this->seeInDatabase($this->table, [
            'class' => 'Foo',
            'key'   => 'bar',
            'value' => '0',
            'type'  => 'boolean',
        ]);

        $this->assertFalse(setting('Foo.bar'));
    }
*/
}
