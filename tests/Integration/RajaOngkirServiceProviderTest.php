<?php

namespace Kavist\RajaOngkir\Tests\Integration;

use Kavist\RajaOngkir\Exceptions\BasicHttpClientException;
use Kavist\RajaOngkir\Exceptions\InvalidConfigurationException;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class RajaOngkirServiceProviderTest extends TestCase
{
    /** @test */
    public function it_has_config_file()
    {
        $this->assertTrue(is_array(config('rajaongkir')));
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_api_key_is_not_set()
    {
        $this->app['config']->set('rajaongkir.api_key', '');

        $this->expectException(InvalidConfigurationException::class);

        RajaOngkir::provinsi()->all();
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_api_key_is_incorrect()
    {
        $this->app['config']->set('rajaongkir.api_key', 'wrongapikey');

        $this->expectException(BasicHttpClientException::class);

        RajaOngkir::provinsi()->all();
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_package_is_incorrect()
    {
        $this->app['config']->set('rajaongkir.package', 'a');

        $this->expectException(InvalidConfigurationException::class);

        RajaOngkir::provinsi()->all();
    }
}
