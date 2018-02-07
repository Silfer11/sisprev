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
    protected $signature = 'mov:manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criacao inicial da movimentacao financeira do fundo manualmente';

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

        $data_atual = '2018-02-06';
        $data_posterior = '2018-02-07';

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
