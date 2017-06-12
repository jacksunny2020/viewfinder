# viewfinder
extended plugin on view file finder from view name for laravel framework

# How to install and configurate package

1. install the laravel package 
  composer require "jacksunny/viewfinder":"dev-master"
  
  please check exist line "minimum-stability": "dev" in composer.json if failed
  
2. append new service provider file line in the section providers of file app.config
  after appended,it should looks like
  <pre>
   'providers' => [
        Illuminate\Auth\AuthServiceProvider::class,
        ......
        Jacksunny\ViewFinder\ExtendedViewServiceProvider::class,  //only default view finder class
        App\Providers\MyExtendedViewServiceProvider::class,       //custom my view finder class
    ],
   </pre>
3.  add test code to check if it works
  <pre>
    Route::get("/{entity}/{type}",function($entity,$type){
      return view("$entity.$type");
  });
  </pre>
  
4. if wanna custom your ViewFinder you may create a class extends from AbsExtendedFileViewFinder,and a custom service provider extends from ExtendedViewServiceProvider
   <pre>
   class MyExtendedFileViewFinder extends AbsExtendedFileViewFinder {

    public function findNeededFilesInPath($name, $path, $user) {
      ...
    }
    
    class MyExtendedViewServiceProvider extends ExtendedViewServiceProvider {
    public function registerViewFinder() {
        $this->app->bind('view.finder', function ($app) {
            return new MyExtendedFileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }
    </pre>
5. please notify me if you got any problem or error on it,thank you!
