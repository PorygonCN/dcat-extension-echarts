# Dcat Admin Extension Echarts 图表扩展

## 安装

- 下载安装 直接将仓库下载或者克隆到项目的 dcat 扩展文件夹中 然后去扩展页面中启用
- composer 安装 `composer require porygon/echarts` 然后去扩展页面中启用
- Dcat 扩展市场安装(暂未开放)

## 用法

有两种用法,一是原生调用,二是封装卡片

```php
// 原生调用
// Chart::make() 后链式调用option设置
// 也可以使用 ->setChartOption("grid",[...]);
// 具体方法可以直接查看源码
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
use Porygon\Echarts\Chart\Line\NewUser;

// 封装创建的是一个卡片
NewUser::make();
// 也可以继续设置图表属性
NewUser::make()->->xAxis([
    "type" => 'category',
    "boundaryGap" => false,
    "data" => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    "show" => false,
])->yAxis([
    "type" => "value", "show" => false
])->tooltip([
    "trigger" => 'axis',
]);
```

- 原生调用效果

![image](https://user-images.githubusercontent.com/31176914/176086461-e08e9480-5fd0-422c-a16a-f206b7a9043c.png)

- 卡片效果

![image](https://user-images.githubusercontent.com/31176914/176086367-80e18d7d-b1d9-4305-a564-502cd4e4f4f0.png)
