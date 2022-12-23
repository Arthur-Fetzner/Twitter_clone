<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd147616f28070466d8821ad729376827
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MF\\' => 3,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MF\\' => 
        array (
            0 => __DIR__ . '/..' . '/MF',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd147616f28070466d8821ad729376827::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd147616f28070466d8821ad729376827::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd147616f28070466d8821ad729376827::$classMap;

        }, null, ClassLoader::class);
    }
}
