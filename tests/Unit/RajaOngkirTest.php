<?php

namespace Kavist\RajaOngkir\Tests\Unit;

class RajaOngkirTest extends TestCase
{
    /** @var int */
    private $provinceId = 5;

    /** @var int */
    private $cityId = 80;

    /** @var string */
    private $provinceSearchTerm = 'ja t';

    /** @var string */
    private $citySearchTerm = 'su';

    /** @test */
    public function it_can_fetch_provinces()
    {
        $mock = $this->mock('provinsi');

        $this->httpClient
            ->expects()->request()
            ->andReturn($mock);

        $response = $this->rajaOngkir->provinsi()->all();

        $this->assertEquals($mock, $response);
    }

    /** @test */
    public function it_can_fetch_province_by_id()
    {
        $mock = $this->mock('provinsi', $this->provinceId);

        $this->httpClient
            ->expects()->request(['id' => $this->provinceId])
            ->andReturn($mock);

        $response = $this->rajaOngkir->provinsi()->find($this->provinceId);

        $this->assertEquals($mock, $response);
    }

    /** @test */
    public function it_can_search_provinces_by_name()
    {
        $mock = $this->mock('provinsi');
        $expectedSearchResult = [
            ['province_id' => '10', 'province' => 'Jawa Tengah'],
            ['province_id' => '11', 'province' => 'Jawa Timur'],
        ];

        $this->httpClient
            ->expects()->request()
            ->andReturn($mock);

        $response = $this->rajaOngkir->provinsi()->search($this->provinceSearchTerm)->get();

        $this->assertEquals($expectedSearchResult, $response);
    }

    /** @test */
    public function it_can_fetch_cities()
    {
        $mock = $this->mock('kota');

        $this->httpClient
            ->expects()->request()
            ->andReturn($mock);

        $response = $this->rajaOngkir->kota()->all();

        $this->assertEquals($mock, $response);
    }

    /** @test */
    public function it_can_fetch_city_by_id()
    {
        $mock = $this->mock('kota', $this->cityId);

        $this->httpClient
            ->expects()->request(['id' => $this->cityId])
            ->andReturn($mock);

        $response = $this->rajaOngkir->kota()->find($this->cityId);

        $this->assertEquals($mock, $response);
    }

    /** @test */
    public function it_can_fetch_cities_by_its_province()
    {
        $mock = $this->mock('kota', $this->cityId);

        $this->httpClient
            ->expects()->request(['province' => $this->provinceId])
            ->andReturn($mock);

        $response = $this->rajaOngkir->kota()->dariProvinsi($this->provinceId)->get();

        $this->assertEquals($mock, $response);
    }

    /** @test */
    public function it_can_search_cities_by_name()
    {
        $mock = $this->mock('kota');
        $expectedSearchResult = [
            [
                'city_id' => '441',
                'province_id' => '11',
                'province' => 'Jawa Timur',
                'type' => 'Kabupaten',
                'city_name' => 'Sumenep',
                'postal_code' => '69413',
            ],
            [
                'city_id' => '444',
                'province_id' => '11',
                'province' => 'Jawa Timur',
                'type' => 'Kota',
                'city_name' => 'Surabaya',
                'postal_code' => '60119',
            ],
        ];

        $this->httpClient
            ->expects()->request()
            ->andReturn($mock);

        $response = $this->rajaOngkir->kota()->search($this->citySearchTerm)->get();

        $this->assertEquals($expectedSearchResult, $response);
    }

    /** @test */
    public function it_can_fetch_delivery_cost()
    {
        $fake = $this->fake('ongkosKirim', 3);

        $expectedArguments = [
            'origin' => 42,
            'destination' => 43,
            'weight' => 1325,
            'courier' => 'jne',
        ];

        $this->httpClient
            ->expects()->request($expectedArguments)
            ->andReturn($fake);

        $response = $this->rajaOngkir->ongkosKirim($expectedArguments)->get();

        $this->assertEquals($fake, $response);
    }
}
