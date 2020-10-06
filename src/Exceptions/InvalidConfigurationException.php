<?php

namespace Kavist\RajaOngkir\Exceptions;

class InvalidConfigurationException extends \Exception
{
    public static function apiKeyNotSpecified()
    {
        return new static('API key untuk RajaOngkir belum diatur.');
    }

    public static function invalidApiPackage()
    {
        return new static('Tipe akun RajaOngkir yang diatur tidak sesuai. Pilih salah satu: starter, basic, pro.');
    }

    public static function unsupportedApiPackage(string $package = 'basic')
    {
        return new static('API ini tidak tersedia untuk paket ' . $package);
    }
}
