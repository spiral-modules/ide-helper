Spiral IDE Helper
=======================
[![Latest Stable Version](https://poser.pugx.org/spiral/ide-helper/v/stable)](https://packagist.org/packages/spiral/ide-helper) [![Total Downloads](https://poser.pugx.org/spiral/ide-helper/downloads)](https://packagist.org/packages/spiral/ide-helper) [![License](https://poser.pugx.org/spiral/ide-helper/license)](https://packagist.org/packages/spiral/ide-helper)

This module generate IDE help files for spiral framework components like Controllers, 
RequestsFilters, Records, Documents and etc.

## Install

```
composer require spiral/ide-helper
./spiral register spiral/ide-helper && ./spiral console:reload
```

## Usage

```
./spiral ide-helper
```

## Configuration and Terminology

The module is configured via `config/modules/ide-helper.php` file.

The config has 3 sections: `writers`, `locators`, `scopes`.

[TL;DR SHOW ME TEH CONFIG](resources/config.php)

`locators` section includes any Locators used by the module. Locator is a class that responsible for
searching classes and it's [magic] members.
 
`writers` section includes any Writers used by the modules. Writers are responsible to write the
stuff collected by locators to some destination.
 
Both locators and writers must be represented by associated array, where the key is any human 
reasonable name for locator or writer and the value is class string or 
`\Spiral\Core\Container\Autowire` instance (can be obtained by `bind` method). 
 
`scopes` section is also associated array, where the keys is any human reasonable name for the 
scope and the value is scope definition. Scope definition consists of number of locators and 
writers to execute, just check config above to understand the syntax. Each scope is executed
independently.

The package includes following locators and writers:
* `BindingsLocator` &mdash; find short bindings (SharedTrait)
* `ContainersLocator` &mdash; find container and it's bindings
* `DocumentsLocator` &mdash; find documents and it's fields
* `RecordsLocator` &mdash; find records and it's fields
* `FilePerClassWriter` &mdash; write every class to it's own file
* `SingleFileWriter` &mdash; write everything to one file
 
## Extending
 
### Custom Locators
 
To create your own locator you must implement `\Spiral\IdeHelper\Locators\LocatorInerface`:
```php
interface LocatorInterface
{
    /**
     * @return ClassDefinition[]
     */
    public function locate(): array;
}
 ```
and then register it in configuration file.
 
### Custom Writers
 
Same as custom locator but `\Spiral\IdeHelper\Writers\WriterInterface` interface:
```php
interface WriterInterface
{
    /**
     * @param ClassDefinition[] $classes
     */
    public function write(array $classes);
}
```

`FilePerClassWriter` and `SingleFileWriter` are using `\Spiral\IdeHelper\Rendere\RendererInterface`
for rendering content, so if you want only to change the way files are looks like you can create
your own implementation.

```php
interface RendererInterface
{
    /**
     * @param ClassDefinition[] $classes
     * @return string
     */
    public function render(array $classes): string;
}
```
