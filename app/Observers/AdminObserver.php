<?php

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        $admin->givePermissionTo('admin');
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Admin $admin
     * @return void
     */
    public function updated(Admin $admin)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\Admin $admin
     * @return void
     */
    public function deleted(Admin $admin)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\Admin $admin
     * @return void
     */
    public function restored(Admin $admin)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\Admin $admin
     * @return void
     */
    public function forceDeleted(Admin $admin)
    {
        //
    }
}
