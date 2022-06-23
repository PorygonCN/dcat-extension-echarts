<?php

namespace Porygon\Ecahrts;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class EcahrtsServiceProvider extends ServiceProvider
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

        Admin::asset()->alias('@echarts', '/vendor/dcat-admin-extensions/porygon/ecahrts/js');
    }

    public function settingForm()
    {
        return new Setting($this);
    }
}
