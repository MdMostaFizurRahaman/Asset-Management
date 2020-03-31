<?php

namespace App\Observers;

use App\Asset;
use Illuminate\Support\Facades\Auth;

class AssetObserver
{
    /**
     * Handle the asset "created" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function created(Asset $asset)
    {
        $latestAssetNumber = Asset::where('client_id', Auth::user()->client_id)->
        where('asset_number', '>', 0)->orderBy('asset_number', 'desc')->withTrashed()->first();

        $input = [];

        if($latestAssetNumber) {
            $difference = Asset::where('client_id', Auth::user()->client_id)->
            where('id', '>', $latestAssetNumber->id)->where('id', '<=', $asset->getAttribute('id'))->count();

            $input['asset_number'] = $latestAssetNumber->asset_number + $difference;
        }
        else{
            $input['asset_number'] = 1;
        }

        $asset->update($input);
    }

    /**
     * Handle the asset "updated" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function updated(Asset $asset)
    {
        //
    }

    /**
     * Handle the asset "deleted" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function deleted(Asset $asset)
    {
        //
    }

    /**
     * Handle the asset "restored" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function restored(Asset $asset)
    {
        //
    }

    /**
     * Handle the asset "force deleted" event.
     *
     * @param  \App\Asset  $asset
     * @return void
     */
    public function forceDeleted(Asset $asset)
    {
        //
    }
}
