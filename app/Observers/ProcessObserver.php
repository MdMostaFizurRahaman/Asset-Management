<?php

namespace App\Observers;

use App\Process;
use App\ProcessLog;
use Illuminate\Support\Facades\Auth;

class ProcessObserver {

    /**
     * Handle the process "created" event.
     *
     * @param  \App\Process  $process
     * @return void
     */
    public function created(Process $process) {
        $process->process_id = $process->id;
        $process = $process->toArray();
        $process['action_user_id'] = Auth::user()->id;
        ProcessLog::create($process);
    }

    /**
     * Handle the process "updated" event.
     *
     * @param  \App\Process  $process
     * @return void
     */
    public function updated(Process $process) {
        $process->process_id = $process->id;
        $process = $process->toArray();
        $process['action_user_id'] = Auth::user()->id;
        ProcessLog::create($process);
    }

    /**
     * Handle the process "deleted" event.
     *
     * @param  \App\Process  $process
     * @return void
     */
    public function deleted(Process $process) {
        $process->process_id = $process->id;
        $process = $process->toArray();
        $process['action_user_id'] = Auth::user()->id;
        ProcessLog::create($process);
    }

    /**
     * Handle the process "restored" event.
     *
     * @param  \App\Process  $process
     * @return void
     */
    public function restored(Process $process) {
        //
    }

    /**
     * Handle the process "force deleted" event.
     *
     * @param  \App\Process  $process
     * @return void
     */
    public function forceDeleted(Process $process) {
        //
    }

}
