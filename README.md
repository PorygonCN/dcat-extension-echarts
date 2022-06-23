# Dcat Admin Extension Echarts 图表扩展

## 用法

有两种用法,一是原生调用,二是封装卡片

```php
// 原生调用
// Chart::make() 后链式调用option设置
// 也可以使用 ->setChartOption("grid",[...]);
// 具体可以直接查看源码
// 原生创建的是一个单纯的图表
use Porygon\Echarts\Chart;

Chart::make()->grid([
    "containLabel" => false,
    "left"         => "0%",
    "right"        => "0%",
    "top"          => "0%",
    "bottom"       => "0%",
])->xAxis([
    "type" => 'category',
    "boundaryGap" => false,
    "data" => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    "show" => false,
])->yAxis([
    "type" => "value", "show" => false
])->tooltip([
    "trigger" => 'axis',
])->serie([
    "data"       => [1, 5, 74, 15, 63, 75, 91],
    "type"       => "line",
    "smooth"     => true,
    "areaStyle"  => [],
    "showSymbol" => false
]);

// 封装调用
// 这个是与封装的demo
use Porygon\Ecahrts\Chart\Line\NewUser;

// 封装创建的是一个卡片
NewUser::make();

```
