<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ViewFinder;

use Jacksunny\ViewFinder\AbsExtendedFileViewFinder;

/**
 * Description of DefaultNeededFileFinder
 *
 * @author 施朝阳
 * @date 2017-6-9 19:08:11
 */
class DefaultExtendedFileViewFinder extends AbsExtendedFileViewFinder {

    public function findNeededFilesInPath($name, $path, $user) {
        $files = $this->getPossibleViewFiles($name);
        return $files;
    }

}
