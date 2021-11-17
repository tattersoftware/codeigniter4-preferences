<?php

if (! function_exists('preference')) {
    /**
     * Provides a wrapper for user contextual Settings.
     *
     * @param mixed|null $value
     *
     * @throws RuntimeException if attempting to set a preference witohut an active user
     *
     * @return mixed
     */
    function preference(string $key, $value = null)
    {
        /** @var \CodeIgniter\Settings\Settings $setting */
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

        // Bogus coverage comment
    }
}
