<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    // 页面标题
    public $title;


    /**
     * 初始化参数
     *
     * AppLayout constructor.
     * @param  string  $title 标题
     */
    public function __construct(string $title = '管理平台')
    {
        $this->title = $title;
    }
    
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
