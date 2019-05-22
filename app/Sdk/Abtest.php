<?php


namespace App\Sdk;


use App\Sdk\src\Config;
use App\Sdk\src\Feature;
use lastguest\Murmur;

class Abtest
{

    public const DEFAULT_SEGMENT_KEY = 'default';
    public const MAX_HASH_VALUE = 0x100000000;
    public const MAX_TRAFFIC_VALUE = 10000;

    public function __construct($config)
    {
        $this->config = new Config($config);
    }

    public function getSegment(string $feature, string $user_id): string
    {
        $feature = $this->config->getFeature($feature);

        if($feature === null){
            return self::DEFAULT_SEGMENT_KEY;
        }


        $bucketNumber = $this->getNumberForFeature($user_id, $feature);
        $segment_key = self::DEFAULT_SEGMENT_KEY;
        foreach($feature->getSegmentsOrderedByRange() as $segment)
        {
            if($bucketNumber < $segment->endOfRange)
            {
                $segment_key = $segment->key;
            }
        }

        return $segment_key;
    }

    private function getNumberForFeature(string $user_id, Feature $feature): int
    {
        $hash = Murmur::hash3_int($user_id.$feature->getKey());
        $ratio = $hash / self::MAX_HASH_VALUE;
        $bucketVal = (int) floor($ratio * self::MAX_TRAFFIC_VALUE);

        if ($bucketVal < 0) {
            $bucketVal += 10000;
        }
        return $bucketVal;
    }


}