<?php


namespace App\Observers;


use App\Models\Admin;

class AdminObserver
{
    /**
     * Handle the Admin "created" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        $admin->givePermissionTo('admin');
    }

    /**
     * Handle the Admin "updated" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function updated(Admin $admin)
    {
        //
    }

    /**
     * Handle the Admin "deleted" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function deleted(Admin $admin)
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function restored(Admin $admin)
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function forceDeleted(Admin $admin)
    {
        //
    }
}
