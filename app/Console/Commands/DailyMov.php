<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Fundo;
use App\Movimentacao;

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

        $ultimo_dia_mes = date('Y-m-t');
        $ultimo_dia_ano = date('Y-12-t');

        //verifica se é ultimo dia do mes e do ano
        if($data_atual == $ultimo_dia_ano){
          $data_posterior = date('Y-01-01', strtotime('+1 year'));
        }
        //verifica se é ultimo dia do mes
        elseif($data_atual == $ultimo_dia_mes){
          $data_posterior = date('Y-m-01', strtotime('+1 mounth'));
        }
        //se não, taca ficha
        else{
          $data_posterior = date('Y-m-d', strtotime('+1 days'));
        }

        foreach ($Fundos as $Fundo) {
          //todo pegar saldo anterior
           $mov_antiga = Movimentacao::where('data', $data_atual)->where('idFundo', $Fundo->id)->first();

           if($mov_antiga != "[]"){
             $mov_nova = new Movimentacao();

             //verifica se é ultimo dia do mes
             if($data_atual == $ultimo_dia_mes){
               $mov_nova['inicial'] = $mov_antiga->final;
             }else{
               $mov_nova['inicial'] = $mov_antiga['inicial'];
             }

             $mov_nova['idFundo'] = $Fundo['id'];
             $mov_nova['resgate'] = 0;
             $mov_nova['aplicacao'] = 0;
             $mov_nova['final'] = 0;
             $mov_nova['data'] = $data_posterior;

             $mov_nova->save();
           }

        }
    }
}
