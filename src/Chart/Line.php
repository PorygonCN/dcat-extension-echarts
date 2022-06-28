<?php

namespace Porygon\Echarts\Chart;

use Illuminate\Http\Request;

class Line extends Card
{
    /**
     * 初始化.
     */
    protected function init()
    {
        parent::init();

        // 使用图表
        $this->useChart();
    }

    public function smooth($smooth, $index = null)
    {

        return $this;
    }
}
