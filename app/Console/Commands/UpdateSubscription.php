<?php

namespace App\Console\Commands;

use App\Models\UserTariff;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class UpdateSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Subscriptions for Users';

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
     * @return int
     */
    public function handle()
    {

        try {
            $userSubs = UserTariff::all();

            foreach ($userSubs as $userSub){

                $diff = date_diff(new \DateTime(), $userSub->created_at)->days;
                $userSub->days_end_sub = $userSub->getSubscription->duration - $diff;

                if ($userSub->days_end_sub < 1){

                    $userSub->status = false;
                    $userSub->days_end_sub = 0;

                }

                $userSub->save();

            }
        } catch (QueryException $exception){

        }

        return 0;
    }
}
