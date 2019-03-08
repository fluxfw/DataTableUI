ILIAS 6.0 Table UI

# Installation
1.Add it as a submodule

Start at your ILIAS root directory

```bash
git submodule add -b develop git@git.studer-raimann.ch:ILIAS/Libraries/TableUI.git src/Services/TableUI
```

2.Add composer autoload to `Services/Init/classes/class.ilInitialisation.php` below `require_once("libs/composer/vendor/autoload.php");`
```php
require_once __DIR__. "/../../../src/Services/TableUI/vendor/autoload.php";
```
