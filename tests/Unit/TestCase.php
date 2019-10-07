<?php

namespace Kavist\RajaOngkir\Tests\Unit;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Kavist\RajaOngkir\Contracts\HttpClientContract;
use Kavist\RajaOngkir\Contracts\SearchDriverContract;
use Kavist\RajaOngkir\HttpClients\BasicClient;
use Kavist\RajaOngkir\RajaOngkir;
use Kavist\RajaOngkir\SearchDrivers\BasicDriver;
use Kavist\RajaOngkir\SearchDrivers\FuseDriver;
use Mockery;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /** @var \Kavist\RajaOngkir\Contracts\HttpClientContract|\Mockery\Mock */
    protected $httpClient;

    /** @var \Kavist\RajaOngkir\Contracts\SearchDriverContract|\Mockery\Mock */
    protected $searchDriver;

    /** @var \Kavist\RajaOngkir\RajaOngkir */
    protected $rajaOngkir;

    public function setUp(): void
    {
        $this->httpClient = Mockery::mock(BasicClient::class, HttpClientContract::class)
            ->shouldIgnoreMissing();

        $this->searchDriver = Mockery::mock(BasicDriver::class, SearchDriverContract::class)
            ->shouldIgnoreMissing();

        $this->betterSearchDriver = Mockery::mock(FuseDriver::class, SearchDriverContract::class)
            ->shouldIgnoreMissing();

        $this->rajaOngkir = new RajaOngkir('d41d8cd98f00b204e9800998ecf8427e', 'starter');
        $this->rajaOngkir->setHttpClient($this->httpClient);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function mock(string $resourceName, int $id = null)
    {
        $mockdata = __DIR__.'/../mockdata/'.$resourceName.'.json';
        $data = json_decode(file_get_contents($mockdata), true);

        if (! null === $id) {
            foreach ($data as $row) {
                if ($row[$resourceName.'_id'] == $id) {
                    return $row;
                }
            }
        }

        return $data;
    }

    /**
     * @param string $resourceName
     * @param int $repeat
     * @param bool $strict
     * @return array
     */
    protected function fake(string $resourceName, int $repeat = 1): array
    {
        $faker = FakerFactory::create();
        $result = [];

        if (in_array($resourceName, ['ongkosKirim'])) {
            $result[] = $this->{'generate'.ucwords($resourceName)}($faker, $repeat);
        }

        return count($result) > 1 ? $result : $result[0];
    }

    protected function generateOngkosKirim(FakerGenerator $faker, int $repeat = 1): array
    {
        $code = $faker->word(1, true);
        $name = $faker->word(3);
        $costs = [];

        for ($i = 0; $i < $repeat; $i++) {
            $costs[] = [
                'service' => $faker->word(1, true),
                'description' => $faker->sentence,
                'cost' => [
                    'value' => $faker->numberBetween(5, 55) * 1000,
                    'etd' => $faker->numerify('#-#'),
                    'note' => '',
                ],
            ];
        }

        return compact('code', 'name', 'costs');
    }
}
