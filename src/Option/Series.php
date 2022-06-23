<?php

namespace Porygon\Ecahrts\Option;

use Illuminate\Contracts\Support\Arrayable;
use Porygon\Ecahrts\Option\Series\Serie;

class Series implements Arrayable
{
    protected $series = [];

    /**
     * 添加serie
     */
    public function serie(Serie $serie)
    {
        $this->series[] = $serie;
        return $this;
    }
    public function getSerie(int $index)
    {
        return $this->series[$index];
    }
    public function series()
    {
        return $this->series;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        $res = [];
        foreach ($this->series as $serie) {
            $res[] = $serie->toArray();
        }
        return $res;
    }
}
