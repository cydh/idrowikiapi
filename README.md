# IdrowikiAPI

> PHP API library for DB.IDROWIKI.org

[Renewal API Doc](https://db.idrowiki.org/renewal/doc/API.html) | [Klasik API Doc](https://db.idrowiki.org/klasik/doc/API.html)
----- | -----

## Requirements

  * PHP 5.6 or newer
  * [Composer](https://getcomposer.org/download/)

## Installation

If you willing to use this as component,

```
composer require cydh/idrowikiapi
```

or download [latest version](https://github.com/cydh/idrowikiapi/releases) then install it by using composer

```
composer install
```

## Usage

Then include autoload in PHP file (example: whodrops.php)

```php
require_once './vendor/autoload.php';

use Cydh\IdrowikiAPI;

$db = new IdrowikiAPI\IdrowikiAPI(IdrowikiAPI\ApiType::ITEM_DROPLIST, 608); // Yggdrasil Berry
$db->setEndpoint("https://db.idrowiki.org/renewal/api/");
$db->setAuthKey("IDROWIKIAPIKEY");
$db->execute();
if ($db->isSuccess()) {
    var_dump($db->simplePrint());
    var_dump($db->getLink());
} else {
    print "Error with code '".$db->getErrorCode()."'. Message: ".$db->getErrorMessage().PHP_EOL;
}
```

## Available API Types

See inside file `src/ApiType.php` there are constants

Type | For what
----- | -----
ITEM_INFO | Get item info
ITEM_SEARCH | Search items based on item name
ITEM_DROPLIST | Get item "dropped by", either normal drop and MVP reward if exists
MONSTER_INFO | Get monster info
MONSTER_DROPLIST | Get monster's normal drop and MVP reward
MONSTER_MAPLIST | Get monster's spawn map
MONSTER_SEARCH | Search monsters based on monster name
MAP_INFO | Get map info
MAP_SEARCH | Search maps based on map name

```php
use Cydh\IdrowikiAPI\ApiType;
```
