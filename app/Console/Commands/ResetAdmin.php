<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class ResetAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:resetadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      $users = new User();
      $adminUsers = $users::where('access_type', 'admin')->get();
      
      foreach($adminUsers as $item){

            $item->clinic_id = 0;
            
            $item->update();

      }
    }
}
