<?php

namespace Porygon\Echarts\Chart;

use Dcat\Admin\Widgets\Metrics\Card as MetricsCard;
use Porygon\Echarts\Chart;
use Porygon\Echarts\Option;

class Card extends MetricsCard
{
    /**
     * 是否启用loading
     */
    protected $load = true;
    /**
     * @var Chart
     */
    protected $chart;

    /**
     * 设置是否启用loading
     */
    public function load($load = null)
    {
        if ($load === null) {
            return $this->load;
        }
        $this->load = $load;
        return $this;
    }

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
        /**
         * 设置边距
         */
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
     * @return mixed
     */
    public function addScript()
    {
        if (!$this->allowBuildRequest()) {
            return;
        }

        $id = $this->id();


        $this->fetching(<<<JS
var \$card = $('#{$id}');
JS);
        if ($this->load) {
            // 开启loading效果
            $this->fetching(<<<JS
\$card.loading();
JS);
            $this->fetched(<<<'JS'
$card.loading(false);
JS);
        }

        $this->fetched(
            <<<'JS'
$card.loading(false);
$card.find('.metric-header').html(response.header);
$card.find('.metric-content').html(response.content);
JS
        );

        $clickable = "#{$id} .dropdown .select-option";

        $cardRequestScript = '';

        if ($this->chart) {
            // 有图表的情况下，直接使用图表的js代码.
            $this->chart->merge($this)->click($clickable);
        } else {
            // 没有图表，需要构建卡片数据请求js代码.
            $cardRequestScript = $this->click($clickable)->buildRequestScript();
        }

        // 按钮显示选中文本
        return $this->script = <<<JS
$('{$clickable}').on('click', function () {
    $(this).parents('.dropdown').find('.btn').html($(this).text());
});

{$cardRequestScript}
JS;
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
