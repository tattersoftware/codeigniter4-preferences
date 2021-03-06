# Tatter\Preferences
Persistent user-specific settings for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-preferences/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-preferences/actions/workflows/test.yml)
[![](https://github.com/tattersoftware/codeigniter4-preferences/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-preferences/actions/workflows/analyze.yml)
[![](https://github.com/tattersoftware/codeigniter4-preferences/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-preferences/actions/workflows/inspect.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-preferences/badge.svg?branch=develop)](https://coveralls.io/github/tattersoftware/codeigniter4-preferences?branch=develop)

## Quick Start

1. Install with Composer: `> composer require --dev tatter/preferences`
2. Load the helper: `helper('preferences');`
3. Use the function to get and set: `$theme = preference('theme'); preference('theme', 'dark');`

## Description

`Preferences` is a wrapper for [CodeIgniter Settings](https://github.com/codeigniter4/settings)
to provide user context to each setting. This allows you to get and set preferences on a
per-user basis with a single command.

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
```bash
composer require tatter/preferences
```

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

Once the files are downloaded and included in the autoload, run any library migrations
to ensure the database is set up correctly:
* `> php spark migrate -all`

`Preferences` suggests the Composer provision for `codeigniter4/authentication-implementation` as describe in the
[CodeIgniter authentication guidelines](https://codeigniter4.github.io/CodeIgniter4/extending/authentication.html).
Without this each preference will be limited to the session duration so it is highly recommended
you install and configure a [supported package](https://packagist.org/providers/codeigniter4/authentication-implementation).

## Usage

`Preferences` requires [CodeIgniter Settings](https://github.com/codeigniter4/settings) so
you may use all the same classes and functions described in its documentation as well. To
access the user-specific context settings call the `preference()` function anywhere you would
normally use `setting()`:
```php
class Home extends Controller
{
    public function index()
    {
        return view('welcome', [
            'icon' => preference('Users.avatar'),
        ];
    }

    public function update_avatar()
    {
        if ($icon = $this->request->getPost('icon')) {
            prefernece('Users.avatar', $icon);
        }

        return redirect()->back();
    }
}
```

> Note: Be sure to load the helper file (`helper('preferences')`) before using the helper function.

`preference()` will retrieve and store contextual settings for the current authenticated user.
If no user is authenticated then it will fall back on the `Session` class with semi-persistent
settings for as long as the session lasts.

### Placeholder Config

In most cases each setting should have a corresponding Config file. Sometimes these settings
will not fit under an existing logical grouping, so this library provides a "placeholder"
Config (`Tatter\Preferences\Config\Preferences`). You may add your own version in **app/* to
supply default values:
```php
<?php

namespace Config;

class Preferences extends \Tatter\Preferences\Config\Preferences
{
    /**
     * Slug for the current user theme.
     */
    public string $theme = 'midnight';
}
```

Any function calls with the class unspecified will reference the `Preferences` class:
```php
// Identical calls:
$theme = preference('Preferences.theme');
$theme = preference('theme');
```

> Hint: Don't forget that libraries and modules can provide Config properties via [Registrars](https://codeigniter.com/user_guide/general/configuration.html#registrars)

## Troubleshooting

`Preferences` is a very "thin" library conjoining `Settings` and your authentication library
of choice. Most likely any issues are related to one of the underlying libraries and should
be directed there, but if you believe there is a problem or a feature request appropriate to
this repository then feel free to open an Issue or Pull Request.
