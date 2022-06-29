<?php

namespace Porygon\Echarts\Chart\Line;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Porygon\Echarts\Chart\Line;

class NewUser extends Line
{
    /**
     * 初始化.
     */
    protected function init()
    {
        parent::init();

        $this->title('New Users');
        $this->chartHeight(160);

        $this->grid([
            "containLabel" => false,
            "left"         => "0%",
            "right"        => "0%",
            "top"          => "0%",
            "bottom"       => "0%",
        ])->yAxis(["type" => "value", "show" => false]);

        $this->dropdown([
            '7'   => 'Last 7 Days',
            '28'  => 'Last 28 Days',
            '30'  => 'Last Month',
            '365' => 'Last Year',
        ]);
        $this->tooltip([
            "trigger" => 'axis',
            "axisPointer" => [
                // "type" => 'cross'
            ]
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $serieGenerator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };
        $xGenerator = function ($len) {
            for ($i = 0; $i <= $len; $i++) {
                yield Carbon::today()->subDays(mt_rand(0 - $len, $len))->format("m-d");
            }
        };
        switch ($request->get('option')) {
            case '365':
            case '30':
            case '28':
            case '7':
            default:
                // 卡片内容
                $this->withContent(mt_rand(400, 1000) . 'k');

                $this->chart->serie([
                    "data"       => collect($serieGenerator($request->get('option', 7)))->toArray(),
                    "type"       => "line",
                    "smooth"     => true,
                    "areaStyle"  => [],
                    "showSymbol" => false
                ])->xAxis("data", collect($xGenerator($request->get('option', 7)))->toArray());
        }
    }
}
