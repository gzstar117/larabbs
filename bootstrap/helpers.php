<?php
/*
 * 自定义的辅佐函数
 */

/*
 * 返回当前请求的路由名称, 用于转换为 CSS 类名称, 作用是允许我们针对某个页面做页面样式定制
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
