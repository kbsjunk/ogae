<?php

namespace Ogae\Providers;

use Illuminate\Support\ServiceProvider;
use Facebook\Facebook;

class FacebookServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap the application services.
  *
  * @return void
  */
  public function boot()
  {
    $this->app->singleton('facebook', function($app) {
      return new Facebook([
        'app_id' => config('services.facebook.client_id'),
        'app_secret' => config('services.facebook.client_secret'),
        'default_graph_version' => 'v2.7',
      ]);
    });
  }

  /**
  * Register the application services.
  *
  * @return void
  */
  public function register()
  {
    //
  }
}
