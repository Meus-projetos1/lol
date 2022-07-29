<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c38bf11ebd9ce3e6bf82c3324d33c85
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Simplon\\Postgres\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Simplon\\Postgres\\' => 
        array (
            0 => __DIR__ . '/..' . '/simplon/postgres/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c38bf11ebd9ce3e6bf82c3324d33c85::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c38bf11ebd9ce3e6bf82c3324d33c85::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c38bf11ebd9ce3e6bf82c3324d33c85::$classMap;

        }, null, ClassLoader::class);
    }
}
