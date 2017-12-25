<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Wish;
use Carbon\Carbon;
use App\Jobs\OneMonth;

class CheckWishes extends Command
{
    protected $signature = 'check:wishes';
    protected $description = 'Check for old incomplete wishes';
    protected $wish;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Wish $wish)
    {
        parent::__construct();

        $this->wish = $wish;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $priority = rand(5, 15);
        $data = $this->wish->where([
            ['completed', 0],
            ['created_at', '<=', Carbon::now()->subMonth()],
            ['priority', '<', 5]
        ])->get();

        $data->each(function ($item) use ($priority) {
            $item->increment('priority', $priority);
            dispatch(new OneMonth($item, $priority));
        });
    }
}
