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

        $data_atual = date('Y-m-d');

        //verifica se é ultimo dia do mes
        if($data_atual == date('Y-m-t')){
          $data_posterior = date('Y-m-01', strtotime('+1 mounth'));
        }
        //verifica se é ultimo dia do mes e do ano
        elseif($data_atual == date('Y-12-t')){
          $data_posterior = date('Y-01-01', strtotime('+1 year'));
        }
        //se não, taca ficha
        else{
          $data_posterior = date('Y-m-d', strtotime('+1 days'));
        }

        foreach ($Fundos as $Fundo) {

          //todo pegar saldo anterior
           $mov_antiga = Movimentacao::where('data', $data_atual)->where('idFundo', $Fundo->id)->firstOrFail();

           $mov_nova = new Movimentacao();

           $mov_nova->idFundo = $Fundo->id;
           $mov_nova->inicial = $mov_antiga->final;
           $mov_nova->data = $data_posterior;

           $mov_nova->save();
        }
    }
}
