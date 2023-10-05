<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0cec689723638e0e8100a385ba8cba94
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0cec689723638e0e8100a385ba8cba94::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0cec689723638e0e8100a385ba8cba94::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0cec689723638e0e8100a385ba8cba94::$classMap;

        }, null, ClassLoader::class);
    }
}