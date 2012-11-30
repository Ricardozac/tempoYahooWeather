<?php
//informações do tempo Yahoo


    function tradutor($nome){
         $arrEN = array("Rain Late","tornado","tropical storm","hurricane","severe thunderstorms","thunderstorms","mixed rain and snow","mixed rain and sleet","mixed snow and sleet","freezing drizzle","drizzle","freezing rain","showers","showers","snow flurries","light snow showers","blowing snow","snow","hail","sleet","dust","foggy","haze","smoky","blustery","windy","cold","cloudy","mostly cloudy (night)","mostly cloudy","partly cloudy (night)","partly cloudy","clear (night)","sunny","fair (night)","fair","mixed rain and hail","hot","isolated thunderstorms","scattered thunderstorms","scattered thunderstorms","scattered showers","heavy snow","scattered snow showers","heavy snow","partly cloudy","thundershowers","snow showers","isolated thundershowers","not available");





    $arrBR = array("chuva posterior","tornado","tempestade tropical","furacão","tempestades severas","trovoadas","ombrófila mista e neve","ombrófila mista e granizo","neve e granizo mista","garoa congelante","garoa","chuva gelada","chuveiros","chuveiros","flocos de neve","luz aguaceiros de neve","soprando neve","neve","granizo","chuva com neve","poeira","nebuloso","neblina","enfumaçado","blustery","ventoso","frio","nublado","muito nublado (noite)","muito nublado","parcialmente nublado (noite)","parcialmente nublado","limpo (noite)","ensolarado","céu limpo (noite)","céu limpo","ombrófila mista e granizo","quente","trovoadas isoladas","Trovoadas","Trovoadas","chuvas esparsas","neve","Neve esparsa","neve","parcialmente nublado","trovoadas","aguaceiros de neve","trovoadas isoladas","não disponível");

    $resultado = count($arrEN);

        for($i= 0; $i < $resultado; $i++){
            if($nome == $arrEN[$i]){

                return $arrBR[$i];
                break;
            }
        }
    }

    function retrieveYahooWeather()
    {
        //URL do yahoo
        $yahooUrl = "http://weather.yahooapis.com/forecastrss";
        //Região d consulta. No caso, Salvador/BA
        $yahooZip = "?w=457033&u=c"; //codigo da cidade o u=c significa em celsius
        //Montando a URL
        $yahooFullUrl = $yahooUrl . $yahooZip;
        //Gerando o objeto utilizando a função do PHP curl_init() e passando a url montada

        $curlObject = curl_init();

        curl_setopt($curlObject,CURLOPT_URL,$yahooFullUrl);
        curl_setopt($curlObject,CURLOPT_HEADER,false);
        curl_setopt($curlObject,CURLOPT_RETURNTRANSFER,true);
        //Executando a função
        $returnYahooWeather = curl_exec($curlObject);
        curl_close($curlObject);
        //Retornando o objeto contendo as informações do tempo
        return $returnYahooWeather;
    }

    try
    {
        //Aqui está a chamada da função
        $weatherXmlString1 = retrieveYahooWeather();
        //Criando o elemento XML de retorno
        $weatherXmlObject1 = new SimpleXMLElement($weatherXmlString1);
        //Capturando condições do tempo
        $currentCondition = $weatherXmlObject1->xpath("//yweather:forecast");
        $currentCondition2 = $weatherXmlObject1->xpath("//yweather:condition");
        $currentCondition3 = $weatherXmlObject1->xpath("//yweather:atmosphere");
        $currentCondition4 = $weatherXmlObject1->xpath("//yweather:location");


        //Capturando a temperatura mínima
        $minima = $currentCondition[0]["low"];
        //Capturando a temperatura máxima
        $maxima = $currentCondition[0]["high"];
        //Capturando a temperatura máxima
        $dia = $currentCondition[0]["day"];
        //Capturando a temperatura máxima
        $data = $currentCondition[0]["date"];
        //Capturando a temperatura máxima
        $texto = tradutor(strtolower($currentCondition2[0]["text"]));
        //Capturando o código da imagem
        $codeImage = $currentCondition2[0]["code"];
        //capturando humidade
        $umidade = $currentCondition3[0]["humidity"];

        //capturando a cidade e o estado
        $cidade = $currentCondition4[0]["city"];
        $estado = $currentCondition4[0]["region"];
    }
    catch(Exception $e)
    {
        //Realizar alguma coisa... provavelmente o reload
    
}


?>
<html>
<?=$maxima ?>ºC
<?=$minima ?>ºC
<img src="http://l.yimg.com/a/i/us/we/52/<?=$codeImage;?>.gif" border="0" />
</html>
