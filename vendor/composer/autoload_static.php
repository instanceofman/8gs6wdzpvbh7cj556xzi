<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf1c4d4a11e8d7feb3a9e7df826adc1c
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Intass\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Intass\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdf1c4d4a11e8d7feb3a9e7df826adc1c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdf1c4d4a11e8d7feb3a9e7df826adc1c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}