<?php

namespace Dxtrasia\DatabaseSwitch;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseSwitchMiddleware
{
    /**
     * Request country
     *
     * @var string
     */
    protected $country;

    /**
     * Country configurations
     *
     * @var array
     */
    protected $configurations;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function Handle(Request $request, Closure $next)
    {
        if ($this->shouldBeReconfiguration($request)) {
            $this->newConfiguration();
        }

        return $next($request);
    }

    /**
     * Determine that request should be reconfiguration
     *
     * @param Request $request
     * @return boolean
     */
    protected function shouldBeReconfiguration(Request $request): bool
    {
        $this->country = $request->header('Request-Country','ID');

        return ($this->country != 'ID') && $this->countryHasConfiguration() ? true : false;
    }

    /**
     * Determine that country has configuration
     *
     * @return boolean
     */
    protected function countryHasConfiguration(): bool
    {
        $countryConfigurations = Config::get('database.country');;

        if (!is_null($countryConfigurations) && key_exists($this->country, $countryConfigurations)) {
            $this->configurations = $countryConfigurations[$this->country];

            return true;
        }

        return false;
    }

    /**
     * Set new configurations
     *
     * @return void
     */
    protected function newConfiguration(): void
    {
        foreach ($this->configurations as $connection => $connectionConfig) {
            Config::set("database.connections.{$connection}", $connectionConfig);
        DB::purge($connection);
        }
    }
}
