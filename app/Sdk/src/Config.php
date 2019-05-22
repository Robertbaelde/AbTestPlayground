<?php


namespace App\Sdk\src;


class Config
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getFeature(string $key): Feature
    {
        if(!array_key_exists($key, $this->config['features'])){
            return null;
        }

        return new Feature($key, $this->config['features'][$key]);
    }

}