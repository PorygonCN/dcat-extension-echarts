<?php

namespace Porygon\Echarts;

class Option
{
    /**
     * ECharts 所有配置项
     */
    const OPTIONS = [
        "title", //设置标题
        "series", //设置数据展示/展示方式
        "legend", //设置图例组件
        "grid", //直角坐标系属性
        "xAxis", //设置直角坐标系X坐标轴
        "yAxis", //设置直角坐标系Y坐标轴
        "polar", //极坐标系属性
        "radiusAxis", //设置极坐标系径向轴
        "angleAxis", //设置极坐标系角度轴
        "radar", //雷达图坐标系属性
        "geo", //地理坐标系
        "parallel", //平行坐标系
        "parallelAxis", //平行坐标系中的坐标轴
        "singleAxis", //单轴
        "calendar", //日历坐标系
        "dataZoom", //数据范围
        "visualMap", //视觉映射
        "tooltip", //全局提示框配置
        "axisPointer", //全局坐标轴指示器配置
        "toolbox", //工具栏
        "brush", //区域选择器
        "timeline", //时间轴
        "options", //用于 timeline 的 option 数组
        "graphic", //原生图形元素
        "dataset", //数据集
        "aria", //无障碍辅助
        "darkMode", //暗黑模式
        "color", //调色盘颜色列表
        "backgroundColor", //背景色
        "textStyle", //文本样式
        "media", //移动端自适应
        "hoverLayerThreshold", //图形数量阈值
        "blendMode", //图形的混合模式
        "useUTC", //是否使用 UTC 时间
        "animation", //开启动画
        "animationThreshold", // 是否开启动画的阈值 超过则关闭动画
        "animationDuration", //初始动画的时长
        "animationDurationUpdate", //数据更新动画的时长
        "animationEasing", //初始动画缓动效果
        "animationEasingUpdate", //数据更新动画缓动效果
        "animationDelay", //初始动画的延迟
        "animationDelayUpdate", //数据更新动画的延迟
        "stateAnimation", //状态切换的动画配置
    ];

    /**
     * 配置项中值是数组的配置项
     */
    const ARRAY_OPTIONS = [
        "title",  //设置标题
        "series", //设置数据展示/展示方式
        "legend", //设置图例组件

        "grid",   //直角坐标系属性
        "xAxis",  //设置直角坐标系X坐标轴
        "yAxis",  //设置直角坐标系Y坐标轴
        "polar",  //极坐标系属性
        "radiusAxis", //设置极坐标系径向轴
        "angleAxis", //设置极坐标系角度轴
        "radar",  //雷达图坐标系属性
        "geo", //地理坐标系
        "parallel", //平行坐标系
        "parallelAxis", //平行坐标系中的坐标轴
        "singleAxis", //单轴
        "calendar", //日历坐标系

        "dataZoom", //数据范围
        "visualMap", //视觉映射
        "tooltip", //全局提示框配置
        "axisPointer", //全局坐标轴指示器配置
        "toolbox", //工具栏
        "brush", //区域选择器
        "timeline", //时间轴
        "options", //用于 timeline 的 option 数组
        "graphic", //原生图形元素
        "dataset", //数据集
        "aria", //无障碍辅助
        "color", //调色盘颜色列表
        "backgroundColor", //背景色
        "textStyle", //文本样式
        "media", //移动端自适应
        "stateAnimation", //状态切换的动画配置
    ];

    /**
     * 配置项中值不是数组的配置项
     */
    const NOT_ARRAY_OPTIONS = [
        "darkMode", //暗黑模式
        "useUTC", //是否使用 UTC 时间
        "hoverLayerThreshold", //图形数量阈值
        "blendMode", //图形的混合模式
        "animation", //开启动画
        "animationThreshold", // 是否开启动画的阈值 超过则关闭动画
        "animationDuration", //初始动画的时长
        "animationDurationUpdate", //数据更新动画的时长
        "animationEasing", //初始动画缓动效果
        "animationEasingUpdate", //数据更新动画缓动效果
        "animationDelay", //初始动画的延迟
        "animationDelayUpdate", //数据更新动画的延迟
    ];
}
