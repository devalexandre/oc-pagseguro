<?php namespace Indev\Pagseguro;

use App;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;
use RainLab\User\Models\User as UserModel;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    public function pluginDetails()
    {
        return [
            'name' => 'Pagseguro Plugin',
            'description' => 'Integration with Pagseguro Payament',
            'author' => 'Indev Web',
            'icon' => 'icon-credit-card-alt'
        ];
    }

    public function registerComponents()
    {
        return [
            'Indev\Pagseguro\Components\Pagseguro' => 'Pagseguro'
        ];
    }



    public function boot(){
        $autoloader = require __DIR__.'/../../../vendor/autoload.php';

     \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$autoloader, 'loadClass']);

     UserModel::extend(function($model){
        $model->hasOne['pagseguro'] = 'Indev\Pagseguro\Models\Pagseguro';
    }) ;

    }
}
