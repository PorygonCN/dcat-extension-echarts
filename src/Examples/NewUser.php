<?php

namespace Porygon\Echarts\Examples;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Porygon\Echarts\Chart\Card;

/**
 * 这是一个图表卡片的示例demo
 * 本身用法跟dcat提供的默认的差不多
 * 只是将使用的图表从ApexChart换成了Echarts
 */
class NewUser extends Card
{
    /**
     * 初始化.
     */
    protected function init()
    {
        parent::init();

        // 标题
        $this->title('New Users');
        // 图表的高度
        $this->chartHeight(160);
        // 图表设置
        $this->grid([ // 直角坐标系
            "containLabel" => false,
            "left"         => "0%",
            "right"        => "0%",
            "top"          => "0%",
            "bottom"       => "0%",
        ])->yAxis([ // Y轴设置
            "type" => "value",
            "show" => false
        ])->xAxis([ // X轴设置
            "type"        => 'category',
            "boundaryGap" => false,
            "show"        => false,
        ])->tooltip([ // 提示设置
            "trigger" => 'axis',
            "axisPointer" => [
                // "type" => 'cross'
            ]
        ]);
        // 下拉选项
        $this->dropdown([
            '7'   => 'Last 7 Days',
            '28'  => 'Last 28 Days',
            '30'  => 'Last Month',
            '365' => 'Last Year',
        ]);
        // 是否设置loading效果
        // $this->load(false);
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
        // 数据生成器
        $serieGenerator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };
        // 坐标生成器
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
