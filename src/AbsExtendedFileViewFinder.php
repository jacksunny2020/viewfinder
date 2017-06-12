<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ViewFinder;

use Illuminate\View\FileViewFinder;
use InvalidArgumentException;
use Illuminate\Filesystem\Filesystem;
use Auth;

/**
 * Description of ExtendedFileViewFinder
 *
 * @author 施朝阳
 * @date 2017-5-23 17:34:28
 */
abstract class AbsExtendedFileViewFinder extends FileViewFinder {

    public function __construct(Filesystem $files, array $paths, array $extensions = null) {
        parent::__construct($files, $paths, $extensions);
    }

    /**
     * Get the fully qualified location of the view.
     *
     * @param  string  $name
     * @return string
     */
    public function find($name) {
        if (isset($this->views[$name])) {
            return $this->views[$name];
        }

        if ($this->hasHintInformation($name = trim($name))) {
            return $this->views[$name] = $this->findNamespacedView($name);
        }

        return $this->views[$name] = $this->findInPaths($name, $this->paths);
    }

    abstract function findNeededFilesInPath($name,$path,$user);

    protected function findInPaths($name, $paths) {
//        foreach ((array) $paths as $path) {
//            foreach ($this->getPossibleViewFiles($name) as $file) {
//                $find_filename = $viewPath = $path . '/' . $file;
//                if ($this->files->exists($find_filename)) {
//                    return $viewPath;
//                }
//            }
//        }

        $not_found_filenames = "";
        foreach ((array) $paths as $path) {

//            $user_id = Auth::user()->id ?? 0;
            $user = Auth::user();
            $files = $this->findNeededFilesInPath($name,$path,$user);


            foreach ($files as $file) {
                $find_filename = $viewPath = $path . '/' . $file;
                if ($this->files->exists($find_filename)) {
                    return $viewPath;
                } else {
                    $not_found_filenames .= "," . $find_filename;
                }
            }
        }


        throw new InvalidArgumentException("View [$name] Of File[$not_found_filenames] not found.");
    }

    /**
     * Get an array of possible view files.
     *
     * @param  string  $name
     * @return array
     */
    protected function getPossibleViewFiles($name) {
        $user_id = Auth::user()->id ?? 0;
        //var_dump($user_id);
        return array_map(function ($extension) use ($name, $user_id) {
            return str_replace('.', '/', $name) . '.' . $extension;
            $segments = explode(".", $name);
            if (strstr($extension, 'blade.php') && count($segments) > 1 && $user_id > 0) {
                //entity_type/user_role/node_type/node_id/viewtype 比如 /waybill/admin/company/1/card
                //todo 应该获取指定的用户对应的角色和对应的各个节点类型节点编号对应的视图，并且在该方法内通过循环确定正确的视图文件名
                $entity_type = $segments[0];
                $view_type = $segments[1];
                $user_role = 1;
                $node_type = 10;
                $node_id = 1;
                $name = "$entity_type.$user_role.$node_type.$node_id.$view_type";
            }
            $filename = str_replace('.', '/', $name) . '.' . $extension;
            return $filename;
        }, $this->extensions);
    }

}
