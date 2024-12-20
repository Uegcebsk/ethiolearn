<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4da4c011d842bf4fb34b64bb1b79b7bc
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4da4c011d842bf4fb34b64bb1b79b7bc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4da4c011d842bf4fb34b64bb1b79b7bc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4da4c011d842bf4fb34b64bb1b79b7bc::$classMap;

        }, null, ClassLoader::class);
    }
}
