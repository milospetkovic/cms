<?php

namespace Photon\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Seed prerun and postrun events
        'Photon\Events\ModulesPrerun' => [
            'Photon\PhotonCms\Core\Handlers\Events\Module\BackupModulesToTemporaryTable',
        ],
        'Photon\Events\ModulesPostrun' => [
        ],
        'Photon\Events\FieldsPrerun' => [
        ],
        'Photon\Events\FieldsPostrun' => [
            'Photon\PhotonCms\Core\Handlers\Events\Module\MergeModulesFromBackupTable',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}