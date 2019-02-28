# Nette Config Finder

Automatically search for configuration (neon) files across application.

Usage
-----
The configuration files must be set up in the configuration container before the application is initialized. This means connecting the configuration files to the container in `bootstrap.php` (`app/bootstrap.php`).

Instead of using static linking of configuration files:
```php
...
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');
...
```

We can use dynamic linking of the searched configuration files:
```php
...
foreach (getNetteConfigs() as $path) {
	$configurator->addConfig($path);
}
...
		
function getNetteConfigs(): array
{
	$cachePath = '..' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'cache';
	$storage = new \Nette\Caching\Storages\FileStorage($cachePath);
	$config = (new \Hladpe\NetteConfigFinder\Configuration())
		->addPath(__DIR__);
	
	$finder = new \Hladpe\NetteConfigFinder\Finder($config, $storage);
	return $finder->find();
}
```

The second parameter of the `\Hladpe\NetteConfigFinder\Finder` is an optional instance of IStorage used to store searched files into cache. We can use Finder without the second parameter of course:
```php
...
foreach (getNetteConfigs() as $path) {
	$configurator->addConfig($path);
}
...
		
function getNetteConfigs(): array
{
	$config = (new \Hladpe\NetteConfigFinder\Configuration())
		->addPath(__DIR__);
	
	$finder = new \Hladpe\NetteConfigFinder\Finder($config);
	return $finder->find();
}
```

We can specify multiple search directories, such as search for configuration files in `vendor` packages:
```php
...
foreach (getNetteConfigs() as $path) {
	$configurator->addConfig($path);
}
...
		
function getNetteConfigs(): array
{
	$config = (new \Hladpe\NetteConfigFinder\Configuration())
		->addPath(__DIR__);
		->addPath('..' . DIRECTORY_SEPARATOR . 'vendor');
	
	$finder = new \Hladpe\NetteConfigFinder\Finder($config);
	return $finder->find();
}
```
