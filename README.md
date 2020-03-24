ILIAS Data Table UI Component

### Usage

#### Composer
First add the following to your `composer.json` file:
```json
"require": {
  "srag/datatable": ">=0.1.0"
},
```
And run a `composer install`.

If you deliver your plugin, the plugin has it's own copy of this library and the user doesn't need to install the library.

Tip: Because of multiple autoloaders of plugins, it could be, that different versions of this library exists and suddenly your plugin use an older or a newer version of an other plugin!

So I recommand to use [srag/librariesnamespacechanger](https://packagist.org/packages/srag/librariesnamespacechanger) in your plugin.

#### PHP 7.0
You can use this library with PHP 7.0 by using the `PHP72Backport` from [srag/librariesnamespacechanger](https://packagist.org/packages/srag/librariesnamespacechanger)

#### Using trait
Your class in this you want to use DataTable needs to use the trait `DataTableTrait`
```php
...
use srag\DataTable\x\Utils\DataTableTrait;
...
class x {
...
use DataTableTrait;
...
```

#### Languages
Expand you plugin class for installing languages of the library to your plugin
```php
...
	/**
     * @inheritDoc
     */
    public function updateLanguages(/*?array*/ $a_lang_keys = null)/*:void*/ {
		parent::updateLanguages($a_lang_keys);

		self::dataTable()->installLanguages(self::plugin());
	}
...
```

#### Use
In your code
```php
...
self::dataTable()->table(...)->withPlugin(self::plugin());
...
```

Get selected action row id
```php
$table->getBrowserFormat()->getActionRowId($table->getTableId());
```

Get multiple selected action row ids
```php
$table->getBrowserFormat()->getMultipleActionRowIds($table->getTableId());
```

### Limitations
In ILIAS 5.4 a default container form ui is used for the filter, in ILIAS 6, the new filter ui is used

### Requirements
* ILIAS 5.4 or ILIAS 6.0
* PHP >=7.2

### Adjustment suggestions
* External users can report suggestions and bugs at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_LTABLEUI
* Adjustment suggestions by pull requests via github
* Customer of studer + raimann ag: 
	* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/LTABLEUI
	* Bug reports under https://jira.studer-raimann.ch/projects/LTABLEUI
