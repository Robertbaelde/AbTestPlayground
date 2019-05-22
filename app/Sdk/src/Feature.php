<?php


namespace App\Sdk\src;


class Feature
{
    private $key;
    private $feature_config;

    public function __construct(string $key, array $feature_config)
    {

        $this->key = $key;
        $this->feature_config = $feature_config;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getSegmentsOrderedByRange(): array
    {
        if(!array_key_exists('segments', $this->feature_config)){
            return [];
        }

        $segments = array_map(function($config){
            return new Segment($config);
        }, $this->feature_config['segments'] );

        usort($segments, function($segment_a, $segment_b){
            return $segment_a->endOfRange < $segment_b->endOfRange;
        });

        return $segments;
    }
}