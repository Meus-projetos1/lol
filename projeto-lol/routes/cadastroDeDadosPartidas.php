<?php
include_once('../DAO/invocador.php');
include_once('../DAO/consultaToken.php');
include_once('../DAO/consultaApiRiot.php');
include_once('../DAO/partidasDAO.php');


// class DadosPartidas
// {

dataPartidasLoop();

function dataPartidasLoop()
{

    //data da ultima partida disponivel
    $data = new DateTime();
    $data->setDate(2021, 6, 01);

    $dataAtual = date('Y-m-d');

    $dataInicio = date_create($data->format('Y-m-d'));
    $dataFim = date_create($dataAtual);



    $condicaoData =  true;
    $datas = [];
    while ($condicaoData) {

        $interval = date_diff($dataInicio, $dataFim);
        $anosDeDiferenca = $interval->format('%y');
        $mesesDeDiferenca = $interval->format('%m');

        array_push($datas, $dataInicio->format('Y-m-d'));

        $dataInicio->add(new DateInterval("P1M"));


        if ($anosDeDiferenca == "0" && $mesesDeDiferenca == "0") {


            consultaPartidas($datas);
            $condicaoData = false;
        }
    }
}


function consultaPartidas($datas)
{

    $resultInvocador = (new Invocador())->consultaInvocador();
    $token = (new ConsultaToken())->consulta();

    $token = $token[0]['token'];

    foreach ($resultInvocador as $key => &$val) {


        foreach ($datas as &$valor) {

            $primeiraDiaMes = $valor;
            $metadadeMesIncio = date("Y-m-d", strtotime($valor . '+ 14 days'));
            $metadadeMesFim = date("Y-m-d", strtotime($valor . '+ 15 days'));
            $fimMes = date("Y-m-t", strtotime($valor));

            $datasRequest = [
                'primeiraDiaMes' => $primeiraDiaMes,
                'metadadeMesIncio' => $metadadeMesIncio,
                'metadadeMesFim' => $metadadeMesFim,
                'fimMes' => $fimMes
            ];
            //var_dump($datasRequest);
            ConsultaSoloDuo($datasRequest, $val['puuid'], $token);
        }
    }
}

function ConsultaSoloDuo($datasRequest, $puuid, $token)
{

    foreach ($datasRequest as $key => &$valor) {
        if ($key == 'primeiraDiaMes') {

            $dataInicio = strtotime($datasRequest['primeiraDiaMes']);
            $dataFim = strtotime($datasRequest['metadadeMesIncio']);

            $partidas = (new ConsultaApiRiot())->ConsultaApiPartidas($puuid, $token, $dataInicio, $dataFim, "420");

            SalvaDadosPartidas($partidas, $token, $puuid, "420");
        } else if ($key == 'fimMes') {

            $dataInicio =  strtotime($datasRequest['metadadeMesFim']);
            $dataFim = strtotime($datasRequest['fimMes']);

            $partidas = (new ConsultaApiRiot())->ConsultaApiPartidas($puuid, $token, $dataInicio, $dataFim, "420");

            SalvaDadosPartidas($partidas, $token, $puuid, "420");
        }
    }
}

function SalvaDadosPartidas($partida, $token, $puuid, $fila)
{


    foreach ($partida as $key => &$val) {

        $dadosPartida = (new ConsultaApiRiot())->ConsultaApiDadosPartida($val, $token);

        $dataCriacaoDaPartida = $dadosPartida->info->gameCreation / 1000;
        $duracaoDaPartida = $dadosPartida->info->gameDuration;
        //participantes
        $participantes = $dadosPartida->info->participants;
        if(strlen($duracaoDaPartida) >= 5){

            $duracaoDaPartida = $duracaoDaPartida / 1000;

        }


        foreach ($participantes as $key => &$val) {

            if ($puuid == $val->puuid) {
                $dados = array(

                    'idJogo' => $dadosPartida->info->gameId,
                    'dataCriacaoDojogo' => date('Y-m-d', intval($dataCriacaoDaPartida)),
                    'duracaoDoJogo' => gmdate('H:i:s', intval($duracaoDaPartida)),
                    'assistencias' => $val->assists,
                    'baroesEliminados' => $val->baronKills,
                    'nivelCampeao' => $val->champLevel,
                    'nomeCampeao' => $val->championName,
                    'danoObejtivos' => $val->damageDealtToObjectives,
                    'danoEdificios' => $val->damageDealtToBuildings,
                    'danoTorres' => $val->damageDealtToTurrets,
                    'danoMitigado' => $val->damageSelfMitigated,
                    'mortes' => $val->deaths,
                    'detectorWards' => $val->detectorWardsPlaced,
                    'doubleKills' => $val->doubleKills,
                    'dragaoElimininados' => $val->dragonKills,
                    'assistenciaPrimeiroAbate' => $val->firstBloodAssist,
                    'PrimeiroAbate' => $val->firstBloodKill == true ? 'Y' : 'N',
                    'assistenciaPrimeiraTorre' => $val->firstTowerAssist,
                    'abatePrimeiraTorre' => $val->firstTowerKill,
                    'jogoTerminouRendicaoAntecipada' => $val->gameEndedInEarlySurrender,
                    'jogoTerminouRendicao' => $val->gameEndedInEarlySurrender,
                    'ouroGanho' => $val->goldEarned,
                    'ouroGasto' => $val->goldSpent,
                    'posicaoIndividual' => $val->individualPosition,
                    'inibidorDestruidos' => $val->inhibitorKills,
                    'inibidorDestruidoEquipe' => $val->inhibitorTakedowns,
                    'inibidorPerdido' => $val->inhibitorsLost,
                    'item0' => $val->item0,
                    'item1' => $val->item1,
                    'item2' => $val->item2,
                    'item3' => $val->item3,
                    'item4' => $val->item4,
                    'item5' => $val->item5,
                    'item6' => $val->item6,
                    'killingSprees' => $val->killingSprees,
                    'abates' => $val->kills,
                    'lane' => $val->lane,
                    'maiorAcertoCritico' => $val->largestCriticalStrike,
                    'danoMagicoCausado' => $val->magicDamageDealt,
                    'danoMagicoCausadoCampeoes' => $val->magicDamageDealtToChampions,
                    'objetivosRoubados' => $val->objectivesStolen,
                    'pentaKills' => $val->pentaKills,
                    'DanoFisicoCausado' => $val->physicalDamageDealt,
                    'DanoFisicoCausadoCampeoes' => $val->physicalDamageDealtToChampions,
                    'puuid' => $val->puuid,
                    'quadraKills' => $val->quadraKills,
                    'role' => $val->role,
                    'pinksCompradas' => $val->sightWardsBoughtInGame,
                    'nivelInvocador' => $val->summonerLevel,
                    'nomeInvocador' => $val->summonerName,
                    'tempoCCoutros' => $val->timeCCingOthers,
                    'totalDanoCausado' => $val->totalDamageDealt,
                    'totalDanoCausadoCampeos' => $val->totalDamageDealtToChampions,
                    'totalDanoProtegidoEmAliano' => $val->totalDamageShieldedOnTeammates,
                    'totalDeDanoRecebido' => $val->totalDamageTaken,
                    'totalDeCurasRecebidas' => $val->totalHealsOnTeammates,
                    'totalMinionEliminados' => $val->totalMinionsKilled,
                    'totalCCcausado' => $val->totalTimeCCDealt,
                    'totalTempoMorto' => $val->totalTimeSpentDead,
                    'tripleKills' => $val->tripleKills,
                    'torreDestruidas' => $val->turretKills,
                    'torreAssistencia' => $val->turretTakedowns,
                    'mortesFordas' => $val->unrealKills,
                    'placarDeVisao' => $val->visionScore,
                    'visaoWardsCompradaNoJogo' => $val->visionWardsBoughtInGame,
                    'wardsColocadas' => $val->wardsPlaced,
                    'vitoria' => $val->win == true ? 'Y' : 'N',
                    'fila' => $fila == "420" ? 'SOLO' : 'FLEX',

                );

                $consultaInfoPartidas = (new Partidas())->consultaPartidaInfo($dadosPartida->info->gameId);

                if (!$consultaInfoPartidas) {

                    $resultInfoPartidas = (new Partidas())->salvaPartidaInfo($dados);
                    echo json_encode($resultInfoPartidas);
                }
            }
        }
    }
}
