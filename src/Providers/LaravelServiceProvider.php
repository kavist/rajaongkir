<?php

namespace Kavist\RajaOngkir\Providers;

use Illuminate\Support\ServiceProvider;
use Kavist\RajaOngkir\Exceptions\InvalidConfigurationException;
use Kavist\RajaOngkir\HttpClients\BasicClient;
use Kavist\RajaOngkir\RajaOngkir;
use Kavist\RajaOngkir\SearchDrivers\BasicDriver;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/rajaongkir.php' => config_path('rajaongkir.php'),
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/rajaongkir.php', 'rajaongkir');

        $this->app->bind(BasicClient::class, function () {
            return new BasicClient;
        });

        $this->app->bind(BasicDriver::class, function () {
            return new BasicDriver;
        });

        $this->app->bind(RajaOngkir::class, function () {
            $config = config('rajaongkir');

            $this->guardAgainstInvalidConfiguration($config);

            return new RajaOngkir($config['api_key'], $config['package']);
        });

        $this->app->alias(RajaOngkir::class, 'rajaongkir');
    }

    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        if (empty($config['api_key'] || 'some32charstring' === $config['api_key'])) {
            throw InvalidConfigurationException::apiKeyNotSpecified();
        }

        if (! in_array($config['package'], ['starter', 'basic', 'pro'])) {
            throw InvalidConfigurationException::invalidApiPackage();
        }
    }
}
