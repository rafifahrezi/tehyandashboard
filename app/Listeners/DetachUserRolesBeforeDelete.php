<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DetachUserRolesBeforeDelete
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $model = $event->model;

        if ($model instanceof User) {
            $model->syncRoles([]);
            $model->syncPermissions([]);
        }
    }
}
