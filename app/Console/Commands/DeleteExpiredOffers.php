<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteExpiredOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired offers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredOffers = Offer::where("expire_date","<",Carbon::now())->get();

        $expiredOffers->each(function ($offer){

            $offer->delete();

        });

        $this->info("Expired offers deleted successfully");

        return Command::SUCCESS;
    }
}
