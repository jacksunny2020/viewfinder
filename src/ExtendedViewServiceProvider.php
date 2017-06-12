<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ViewFinder;

use \Illuminate\View\ViewServiceProvider;

/**
 * Description of ExtendedViewServiceProvider
 *
 * @author 施朝阳
 * @date 2017-5-23 17:44:59
 */
class ExtendedViewServiceProvider extends ViewServiceProvider {

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder() {
        $this->app->bind('view.finder', function ($app) {
            return new DefaultExtendedFileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }

}
