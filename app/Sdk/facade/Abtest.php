<?php


namespace App\Sdk\facade;


use Illuminate\Support\Facades\Facade;

class Abtest extends Facade
{
    protected static function getFacadeAccessor()
    {
       return 'AbTest';
    }
}