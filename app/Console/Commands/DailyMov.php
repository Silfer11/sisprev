<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Movimentacao;
use App\Fundo;

class DailyMov extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:mov';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criacao inicial da movimentacao financeira diaria do fundo';

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
        $Fundos = Fundo::all();

        foreach ($Fundos as $fundo) {
           $movimentacao_inicial = new Movimentacao();
           $movimentacao_inicial->idFundo = $fundo->id;
           $movimentacao_inicial->data = date('Y-m-d');

           $movimentacao_inicial->save();
        }
    }
}
