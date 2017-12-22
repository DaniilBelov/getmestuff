<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Wish;

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
        $this->wish->where('completed', 0)->update(['completed' => 1]);
    }
}
