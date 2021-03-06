<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9d5e4914278e3df4666f27b39c3cb9f1
{
    public static $files = array (
        '841780ea2e1d6545ea3a253239d59c05' => __DIR__ . '/..' . '/qiniu/php-sdk/src/Qiniu/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Q' => 
        array (
            'Qiniu\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Qiniu\\' => 
        array (
            0 => __DIR__ . '/..' . '/qiniu/php-sdk/src/Qiniu',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9d5e4914278e3df4666f27b39c3cb9f1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9d5e4914278e3df4666f27b39c3cb9f1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
