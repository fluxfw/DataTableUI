ILIAS 6.0 Table Data UI

### Usage

#### Composer
First add the following to your `composer.json` file:
```json
"require": {
  "srag/datatable": ">=0.1.0"
},
```
And run a `composer install`.

#### Use

Expand you plugin class for installing languages of the library to your plugin
```php
...
	/**
	 * @inheritdoc
	 */
	public function updateLanguages($a_lang_keys = null) {
		parent::updateLanguages($a_lang_keys);

		LibraryLanguageInstaller::getInstance()->withPlugin(self::plugin())->withLibraryLanguageDirectory(__DIR__ . "/../vendor/srag/datatable/lang")
			->updateLanguages($a_lang_keys);
	}
...
```

### Requirements
* ILIAS 6.0
* PHP >=7.2

### Adjustment suggestions
* Adjustment suggestions by pull requests
* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/LTABLEUI
* Bug reports under https://jira.studer-raimann.ch/projects/LTABLEUI
* For external users you can report it at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_LTABLEUI
