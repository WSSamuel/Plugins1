<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteef42742fb35cbfdd31de048ebb4b436
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Jumpgroup\\Avacy\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Jumpgroup\\Avacy\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteef42742fb35cbfdd31de048ebb4b436::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteef42742fb35cbfdd31de048ebb4b436::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteef42742fb35cbfdd31de048ebb4b436::$classMap;

        }, null, ClassLoader::class);
    }
}
