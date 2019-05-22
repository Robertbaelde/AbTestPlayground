<?php


namespace App\Sdk\src;


class Segment
{
    private $config;
    public $endOfRange;
    public $key;

    /**
     * Segment constructor.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->endOfRange = $config['end_of_range'] ?? 0;
        $this->key = $config['key'] ?? '';
    }

}