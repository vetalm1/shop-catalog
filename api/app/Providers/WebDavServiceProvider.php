<?php

namespace App\Providers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use League\Flysystem\PathPrefixing\PathPrefixedAdapter;
use Sabre\DAV\Client;

class WebDavServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('webdav', function ($app, $config) {
            $adapter = new WebDAVAdapter(
                new Client($config)
            );

            $adapter = new PathPrefixedAdapter($adapter, 'backups');

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}

