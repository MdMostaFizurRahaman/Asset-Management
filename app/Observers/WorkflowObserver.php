<?php

namespace App\Observers;

use App\Workflow;
use App\WorkflowLog;
use Illuminate\Support\Facades\Auth;

class WorkflowObserver {

    /**
     * Handle the workflow "created" event.
     *
     * @param  \App\Workflow  $workflow
     * @return void
     */
    public function created(Workflow $workflow) {
        $workflow->workflow_id = $workflow->id;
        $workflow = $workflow->toArray();
        $workflow['action_user_id'] = Auth::user()->id;
        WorkflowLog::create($workflow);
    }

    /**
     * Handle the workflow "updated" event.
     *
     * @param  \App\Workflow  $workflow
     * @return void
     */
    public function updated(Workflow $workflow) {
        $workflow->workflow_id = $workflow->id;
        $workflow = $workflow->toArray();
        $workflow['action_user_id'] = Auth::user()->id;
        WorkflowLog::create($workflow);
    }

    /**
     * Handle the workflow "deleted" event.
     *
     * @param  \App\Workflow  $workflow
     * @return void
     */
    public function deleted(Workflow $workflow) {
        $workflow->workflow_id = $workflow->id;
        $workflow = $workflow->toArray();
        $workflow['action_user_id'] = Auth::user()->id;
        WorkflowLog::create($workflow);
    }

    /**
     * Handle the workflow "restored" event.
     *
     * @param  \App\Workflow  $workflow
     * @return void
     */
    public function restored(Workflow $workflow) {
        //
    }

    /**
     * Handle the workflow "force deleted" event.
     *
     * @param  \App\Workflow  $workflow
     * @return void
     */
    public function forceDeleted(Workflow $workflow) {
        //
    }

}
