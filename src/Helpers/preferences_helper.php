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
    	// Authenticated
		if ($userId = user_id()) {
			$settings = service('settings');

			// Getting
			if (count(func_get_args()) === 1) {
				return $settings->get($key, 'user:' . $userId);
			}

			// Setting
			if ($value !== null) {
				$settings->set($key, $value, 'user:' . $userId);
			}

			// Forgetting (passed null value)
			else {
				$settings->forget($key, 'user:' . $userId);
			}

			return;
		}

		// Anonymous

		// Getting
		if (count(func_get_args()) === 1) {
			if (session()->has('settings-' . $key)) {
				return session('settings-' . $key);
			}

			return service('settings')->get($key);
		}

		// Setting
		if ($value !== null) {
	        session()->set('settings-' . $key, $value);

	        return;
		}

		// Forgetting (passed null value)
		session()->remove('settings-' . $key);
    }
}
