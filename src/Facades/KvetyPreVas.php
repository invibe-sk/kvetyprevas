<?php

namespace Invibe\KvetyPreVas\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class KvetyPreVas
 * @author Adam Ondrejkovic
 * @package Invibe\KvetyPreVas\Facades
 */
class KvetyPreVas extends Facade
{
    /**
     * @return string
     * @author Adam Ondrejkovic
     */
    protected static function getFacadeAccessor()
    {
        return 'kvetyprevas';
    }
}
