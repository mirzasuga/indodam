<?php

namespace App\Console\Commands\Minings;

use Illuminate\Console\Command;

use App\Mining;
use App\Events\Mining\GrabedIncomeDaily;
use App\Events\Mining\GrabedIncomeHalfmonth;
use DB;

class GrabDailyIncomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mining:grab-income {--period=daily}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk mengambil semua mining yang aktif dan hasil kalkulasi di input ke wallet:mining_income';

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
        
        $period = $this->option('period');
        
        switch ($period) {

            case 'half_month':
                $this->info('Grabing Half Month Income...');
                $this->halfMonth();
                break;

            case 'monthly':
                $this->info('Grabing Monthly Income...');
                $this->monthly();
                break;
                
            default:
                $this->info('Grabing Daily Income...');
                $this->daily();
                break;

        }

        
    }

    public function daily() {
        
        $minings = new Mining();
        $minings = $minings->activeMining()->get();
        $bar = $this->output->createProgressBar( count($minings) );

        DB::beginTransaction();

            foreach( $minings as $mining ) {

                $mining->grabIncomeDaily()->save();
                event( new GrabedIncomeDaily( $mining ) );
                $bar->advance();

            }

        DB::commit();
        $bar->finish();
    }

    public function halfMonth() {
        $minings = new Mining();
        $minings = $minings->activeMiningHalfMonth()->get();
        $bar = $this->output->createProgressBar( count($minings) );

        DB::beginTransaction();

            foreach($minings as $mining) {
                
                $incomeAmount = $mining->mining_income;
                $mining->grabIncomeHalfMonth()->save();
                $user = $mining->user()->first();
                $user->wallet = $mining->balance_dam;
                $user->save();
                event(new GrabedIncomeHalfmonth( $mining, $user, $incomeAmount ) );
                $bar->advance();

            }
        DB::commit();
        $bar->finish();
    }

    public function monthly() {

    }
}
