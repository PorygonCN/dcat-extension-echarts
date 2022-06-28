<?php

namespace Porygon\Echarts\Chart;

use Dcat\Admin\Widgets\Metrics\Card as MetricsCard;
use Porygon\Echarts\Chart;
use Porygon\Echarts\Option;

class Card extends MetricsCard
{
    /**
     * @var Chart
     */
    protected $chart;

    /**
     * 启用图表.
     *
     * @return Chart
     */
    public function useChart()
    {
        return $this->chart ?: ($this->chart = Chart::make());
    }

    /**
     * 设置图表的title
     */
    public function chartTitle($title)
    {
        $this->chart->title($title);
        return $this;
    }

    public function __call($method, $params)
    {
        if (in_array($method, Option::OPTIONS) || method_exists(Chart::class, $method)) {
            $this->chart->__call($method, $params);
            return $this;
        }
        return parent::__call($method, $params);
    }

    /**
     * 设置图表.
     */
    protected function setUpChart()
    {
        if (!$chart = $this->chart) {
            return;
        }

        $this->setUpChartMargin();

        // 图表配置选项
        $chart->setChartOption($this->chartOptions);

        if ($callback = $this->chartCallback) {
            $callback($chart);
        }
    }

    /**
     * 设置图表高度.
     *
     * @param  int  $number
     * @return $this
     */
    public function chartHeight(int $number)
    {
        $this->useChart()->chartHeight($number);

        return $this;
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
HTML
        );
    }

    /**
     * 渲染内容，加上图表.
     *
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
{$content}
<div class="card-content">
    {$this->renderChart()}
</div>
HTML;
    }
}
