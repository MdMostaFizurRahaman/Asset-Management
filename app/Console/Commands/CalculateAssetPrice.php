<?php

namespace App\Console\Commands;

use App\Asset;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateAssetPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current:asset-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate current asset price command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $assets = Asset::where('is_depreciation', '1')->where('current_purchase_value', '<>', 0)->get();
        foreach ($assets as $asset) {

            $update_price = '';
            $purchase_value = $asset->purchase_value;
            $depreciation = $asset->depreciation_value;
            //Difference
            $day_difference = Carbon::parse(Carbon::today())->diffInDays($asset->created_at);
            // 0 => 'Percentage',1 => 'Fixed Amount'
            if ($asset->depreciation_type == 0) {
                //0 => 'Daily Basis',1 => 'Yearly Basis'
                if ($asset->depreciation_category == 0) {
                    $reduce_value = $purchase_value * ($depreciation / 100) * $day_difference;
                    $update_price = $purchase_value - $reduce_value;
                } elseif ($asset->depreciation_category === 1) {
                    $reduce_value = $purchase_value * ($depreciation / 100) * ($day_difference / 365);
                    $update_price = $purchase_value - $reduce_value;
                }

            } else if ($asset->depreciation_type == 1) {
                if ($asset->depreciation_category == 0) {
                    $reduce_value = $depreciation * $day_difference;
                    $update_price = $purchase_value - $reduce_value;
                } elseif ($asset->depreciation_category === 1) {
                    $reduce_value = $depreciation * ($day_difference / 365);
                    $update_price = $purchase_value - $reduce_value;
                }
            }
            $update_price = round($update_price, 2);

            if ($update_price < 0) {
                $update_price = 0;
            }

            $input['current_purchase_value'] = $update_price;

            $asset->update($input);

        }

    }
}
