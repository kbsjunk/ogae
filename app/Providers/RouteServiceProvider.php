<?php

namespace Ogae\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Ogae\Song;
use Ogae\Post;
use Ogae\Comment;
use Ogae\User;

class RouteServiceProvider extends ServiceProvider
{
  /**
  * This namespace is applied to your controller routes.
  *
  * In addition, it is set as the URL generator's root namespace.
  *
  * @var string
  */
  protected $namespace = 'Ogae\Http\Controllers';

  /**
  * Define your route model bindings, pattern filters, etc.
  *
  * @param  \Illuminate\Routing\Router  $router
  * @return void
  */
  public function boot(Router $router)
  {

    $this->model('users', User::class);
    $this->model('posts', Post::class);
    $this->model('songs', Song::class);
    $this->model('comments', Comment::class);

    parent::boot($router);
  }

  /**
  * Define the routes for the application.
  *
  * @param  \Illuminate\Routing\Router  $router
  * @return void
  */
  public function map(Router $router)
  {
    $this->mapWebRoutes($router);
  }

  /**
  * Define the "web" routes for the application.
  *
  * These routes all receive session state, CSRF protection, etc.
  *
  * @param  \Illuminate\Routing\Router  $router
  * @return void
  */
  protected function mapWebRoutes(Router $router)
  {
    $router->group([
      'namespace' => $this->namespace, 'middleware' => 'web',
    ], function ($router) {
      require app_path('Http/routes.php');
    });
  }
}
