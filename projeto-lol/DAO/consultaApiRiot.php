<?php

class ConsultaApiRiot
{


    function ConsultaApiInvocador($nome, $token)
    {

        $curl = curl_init();

        $url = 'https://br1.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $nome . '?api_key=' . $token . '';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $invocador = curl_exec($ch);
        curl_close($ch);

        return  $invocador;
    }


    function ConsultaApiMaestriaPorInvocador($idInvocador, $token)
    {

        $url = 'https://br1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/' . $idInvocador . '?api_key=' . $token . '';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $maestria = curl_exec($ch);
        curl_close($ch);

        return $maestria;
    }

    function ConsultaApiCampeoes(){
        $url = 'http://ddragon.leagueoflegends.com/cdn/12.14.1/data/pt_BR/champion.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $campeoes = curl_exec($ch);
        curl_close($ch);

        return $campeoes;
    }
    function ConsultaApiRaqueada($idInvocador, $token)
    {
       
        $url = 'https://br1.api.riotgames.com/lol/league/v4/entries/by-summoner/' . $idInvocador . '?api_key='.$token.'';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ranqueada = curl_exec($ch);
        curl_close($ch);

        return $ranqueada;
    }

   


    
}
