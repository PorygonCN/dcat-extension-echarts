<?php

namespace Porygon\Echarts;

use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;
use Dcat\Admin\Traits\InteractsWithApi;
use Dcat\Admin\Widgets\Widget;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Chart.
 *
 * @see [Echarts 配置项文档](https://echarts.apache.org/zh/option.html)
 *
 * @method Chart title(string|array $title)         设置标题
 * @method Chart series(array $series)              设置数据展示/展示方式
 * @method Chart legend(array $legend)              设置图例组件
 *
 * @method Chart grid(array $grid)                  直角坐标系属性
 * @method Chart xAxis(array $xAxis)                设置直角坐标系X坐标轴
 * @method Chart yAxis(array $yAxis)                设置直角坐标系Y坐标轴
 * @method Chart polar(array $polar)                极坐标系属性
 * @method Chart radiusAxis(array $radiusAxis)      设置极坐标系径向轴
 * @method Chart angleAxis(array $angleAxis)        设置极坐标系角度轴
 * @method Chart radar(array $radar)                雷达图坐标系属性
 * @method Chart geo(array $geo)                    地理坐标系
 * @method Chart parallel(array $parallel)          平行坐标系
 * @method Chart parallelAxis(array $parallel)      平行坐标系中的坐标轴
 * @method Chart singleAxis(array $singleAxis)      单轴
 * @method Chart calendar(array $calendar)          日历坐标系
 *
 * @method Chart dataZoom(array $dataZoom)          数据范围
 * @method Chart visualMap(array $visualMap)        视觉映射
 * @method Chart tooltip(array $tooltip)            全局提示框配置
 * @method Chart axisPointer(array $axisPointer)    全局坐标轴指示器配置
 * @method Chart toolbox(array $toolbox)            工具栏
 * @method Chart brush(array $brush)                区域选择器
 * @method Chart timeline(array $timeline)          时间轴
 * @method Chart options(array $options)            用于 timeline 的 option 数组
 * @method Chart graphic(array $graphic)            原生图形元素
 * @method Chart dataset(array $dataset)            数据集
 * @method Chart aria(array $aria)                  无障碍辅助
 * @method Chart darkMode(boolean $darkMode)        暗黑模式
 * @method Chart color(array $color)                调色盘颜色列表
 * @method Chart backgroundColor(array $bgc)        背景色
 * @method Chart textStyle(array $textStyle)        文本样式
 * @method Chart media(array $media)                移动端自适应
 * @method Chart hoverLayerThreshold(int $threshold)图形数量阈值
 * @method Chart blendMode(string $blendMode)       图形的混合模式
 * @method Chart useUTC(boolean $useUTC)            是否使用 UTC 时间
 *
 * @method Chart animation(boolean $animation)                          开启动画
 * @method Chart animationThreshold(int $threshold)                     是否开启动画的阈值 超过则关闭动画
 * @method Chart animationDuration(int|script $duration)                初始动画的时长
 * @method Chart animationDurationUpdate($int|script $duration)         数据更新动画的时长
 * @method Chart animationEasing(script $easing)                        初始动画缓动效果
 * @method Chart animationEasingUpdate(script $easing)                  数据更新动画缓动效果
 * @method Chart animationDelay(int|script $animationDelay)             初始动画的延迟
 * @method Chart animationDelayUpdate(int|script $animationDelay)       数据更新动画的延迟
 * @method Chart stateAnimation(array $stateAnimation)                  状态切换的动画配置
 *
 */
class Chart extends Widget
{
    use InteractsWithApi;

    /**
     * 默认容器高度(即图表组件的高度)
     */
    const DEFAULT_CONTAINER_HEIGHT = 200;

    protected $chartHeight = self::DEFAULT_CONTAINER_HEIGHT;

    public static $js = [
        '@echarts/echarts.min.js',
    ];

    protected $containerSelector;

    protected $series = [];

    protected $built = false;

    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method(...$parameters);
        } else if (in_array($method, Option::OPTIONS)) {
            $key   = $method;
            $value = $parameters[0];
            if (count($parameters) == 2) {
                $key   = $method . "." . $parameters[0];
                $value = $parameters[1];
                $this->setChartOption($key, $value);
            }
            return $this->setChartOption($key, $value);
        } else {
            parent::__call($method, $parameters);
        }
    }

    public function __construct($selector = null, $options = [])
    {
        if ($selector && !is_string($selector)) {
            $options  = $selector;
            $selector = null;
        }
        $this->initDefaultOption();

        $this->selector($selector);

        $this->options($options);
    }

    /**
     * 设置parameters
     */
    public function setParameters($key, $value = null)
    {
        if (is_array($key)) {
            $this->parameters = array_merge($this->parameters(), $key);
        } elseif (is_string($key)) {
            $this->parameters[$key] = $value;
        }
    }

    /**
     * 初始化默认Options
     */
    public function initDefaultOption(): Chart
    {
        return $this;
    }

    /**
     * 设置或获取图表高度
     */
    public function chartHeight(int $height = null)
    {
        if ($height !== null) {
            $this->chartHeight = $height;
            return $this;
        } else {
            return $this->chartHeight;
        }
    }

    /**
     * 设置图表的配置项
     * @param string $key 键
     * @param string $value 值
     * @return $this
     */
    public function setChartOption($key, $value = null)
    {
        if (!empty($key) && in_array($this->dot_key($key), Option::OPTIONS)) {
            $is_arr = in_array($key, Option::ARRAY_OPTIONS);
            $value  = $is_arr ? Helper::array($value) : $value;
            Arr::set($this->options, $key, $value);
        } else if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->setChartOption($k, $v);
            }
        }
        return $this;
    }

    /**
     * 获取点连接的键的指定层
     */
    public function dot_key($key, $deep = 0)
    {
        $arr = explode(".", $key);

        return count($arr) > $deep ? $arr[$deep] : null;
    }

    /**
     * 设置或获取图表容器选择器.
     *
     * @param  string|null  $selector
     * @return $this|string|null
     */
    public function selector(string $selector = null)
    {
        if ($selector === null) {
            return $this->containerSelector;
        }

        $this->containerSelector = $selector;

        if ($selector && !$this->built) {
            $this->autoRender();
        }

        return $this;
    }

    /**
     * 设置标题
     * @param  string|array  $title
     * @return $this
     */
    public function title($title)
    {
        if (is_string($title)) {
            $options = ['text' => $title];
        } else {
            $options = Helper::array($title);
        }

        $this->options['title'] = $options;

        return $this;
    }

    /**
     * 设置数据
     * @param array $data 数据
     * @param string $type 数据类型
     */
    public function serie($data, string $type = null)
    {
        if ($type == null) {
            if (is_string($data)) {
                $type = $data;
                $this->series[] = compact("type");
            } elseif (is_array($data)) {
                $this->series[] = Helper::array($data);
            }
        } else {
            $this->series[] = compact("data", "type");
        }
        return $this;
    }

    /**
     * 获取数据集
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * 渲染
     * @return string
     */
    public function render()
    {
        if ($this->built) {
            return;
        }
        $this->built = true;

        // 设置容器高度
        $this->style(["height:{$this->chartHeight}px"]);

        // 设置图表数据/样式
        $this->setChartOption("series", $this->series);

        return parent::render();
    }

    /**
     * 组装容器html
     */
    public function html()
    {
        $hasSelector = (bool)$this->containerSelector;

        if (!$hasSelector) {
            // 没有指定ID，需要自动生成
            $id = $this->generateId();

            $this->selector('#' . $id);
        }

        $this->addScript();

        if ($hasSelector) {
            return;
        }

        // 没有指定容器选择器，则需自动生成
        $this->setHtmlAttribute([
            'id' => $id,
        ]);

        return "<div {$this->formatHtmlAttributes()}></div>";
    }

    /**
     * 返回API请求结果.
     *
     * @return array
     */
    public function valueResult()
    {
        return [
            'status'   => 1,
            'selector' => $this->containerSelector,
            'options'  => $this->formatScriptOptions(),
        ];
    }

    /**
     * 配置选项转化为JS可执行代码.
     *
     * @return string
     */
    protected function formatScriptOptions()
    {
        $code = JavaScript::format($this->options);

        return "response.options = {$code}";
    }

    /**
     * 生成唯一ID.
     *
     * @return string
     */
    protected function generateId()
    {
        return 'echart-' . Str::random(8);
    }


    /**
     * 组装默认的script
     * @return string
     */
    protected function buildDefaultScript()
    {
        $options = JavaScript::format($this->options);
        return <<<JS
    var chart = echarts.init($("{$this->containerSelector}")[0]);
    chart.setOption({$options});
    $(window).bind('resize', function (){
        chart.resize();
    });
JS;
    }

    /**
     * 添加script
     * @return string
     */
    public function addScript()
    {
        if (!$this->allowBuildRequest()) {
            return $this->script = $this->buildDefaultScript();
        }

        $this->fetched(
            <<<JS
if (! response.status) {
    return Dcat.error(response.message || 'Server internal error.');
}

var chartBox = $(response.selector || '{$this->containerSelector}');

if (chartBox.length) {
    chartBox.html('');

    if (typeof response.options === 'string') {
        eval(response.options);
    }

    setTimeout(function () {
        var chart = echarts.init(chartBox[0]);
        chart.setOption(response.options);
        $(window).bind('resize', function (){
            chart.resize();
        });
    }, 50);
}
JS
        );

        return $this->script = $this->buildRequestScript();
    }
}
