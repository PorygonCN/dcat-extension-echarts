<?php

namespace Porygon\Echarts;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class EchartsServiceProvider extends ServiceProvider
{
    protected $js = [
        'js/*',
    ];
    protected $css = [];

    public function register()
    {
        //
    }

    public function init()
    {
        parent::init();

        Admin::asset()->alias('@echarts', '/vendor/dcat-admin-extensions/porygon/dcat-extension-echarts/js');
    }

    public function settingForm()
    {
        return new Setting($this);
    }
}
