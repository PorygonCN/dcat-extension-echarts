<?php

namespace Porygon\Echarts\Option\Series;

use Illuminate\Contracts\Support\Arrayable;

class Serie implements Arrayable
{
    protected $options = [];

    public function option($key, $value = null)
    {
        if ($value != null) {
            $this->options[$key] = $value;
            return $this;
        } else {
            return $this->options[$key];
        }
    }

    public function toArray()
    {
        return $this->options;
    }
}
