<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SpiderService;

class GetDailyHoroscopes extends Command
{
    private $spider;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyHoroscopes:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取每日星座運勢';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpiderService $spider)
    {
        parent::__construct();

        $this->spider = $spider;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i = 0; $i < 12; $i++) {
            sleep(1);
            $this->spider->get($i);
        }
    }
}
