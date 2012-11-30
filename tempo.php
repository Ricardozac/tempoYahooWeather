<?php
//informa��es do tempo Yahoo


    function tradutor($nome){
         $arrEN = array("Rain Late","tornado","tropical storm","hurricane","severe thunderstorms","thunderstorms","mixed rain and snow","mixed rain and sleet","mixed snow and sleet","freezing drizzle","drizzle","freezing rain","showers","showers","snow flurries","light snow showers","blowing snow","snow","hail","sleet","dust","foggy","haze","smoky","blustery","windy","cold","cloudy","mostly cloudy (night)","mostly cloudy","partly cloudy (night)","partly cloudy","clear (night)","sunny","fair (night)","fair","mixed rain and hail","hot","isolated thunderstorms","scattered thunderstorms","scattered thunderstorms","scattered showers","heavy snow","scattered snow showers","heavy snow","partly cloudy","thundershowers","snow showers","isolated thundershowers","not available");





    $arrBR = array("chuva posterior","tornado","tempestade tropical","furac�o","tempestades severas","trovoadas","ombr�fila mista e neve","ombr�fila mista e granizo","neve e granizo mista","garoa congelante","garoa","chuva gelada","chuveiros","chuveiros","flocos de neve","luz aguaceiros de neve","soprando neve","neve","granizo","chuva com neve","poeira","nebuloso","neblina","enfuma�ado","blustery","ventoso","frio","nublado","muito nublado (noite)","muito nublado","parcialmente nublado (noite)","parcialmente nublado","limpo (noite)","ensolarado","c�u limpo (noite)","c�u limpo","ombr�fila mista e granizo","quente","trovoadas isoladas","Trovoadas","Trovoadas","chuvas esparsas","neve","Neve esparsa","neve","parcialmente nublado","trovoadas","aguaceiros de neve","trovoadas isoladas","n�o dispon�vel");

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
        //Regi�o d consulta. No caso, Salvador/BA
        $yahooZip = "?w=457033&u=c"; //codigo da cidade o u=c significa em celsius
        //Montando a URL
        $yahooFullUrl = $yahooUrl . $yahooZip;
        //Gerando o objeto utilizando a fun��o do PHP curl_init() e passando a url montada

        $curlObject = curl_init();

        curl_setopt($curlObject,CURLOPT_URL,$yahooFullUrl);
        curl_setopt($curlObject,CURLOPT_HEADER,false);
        curl_setopt($curlObject,CURLOPT_RETURNTRANSFER,true);
        //Executando a fun��o
        $returnYahooWeather = curl_exec($curlObject);
        curl_close($curlObject);
        //Retornando o objeto contendo as informa��es do tempo
        return $returnYahooWeather;
    }

    try
    {
        //Aqui est� a chamada da fun��o
        $weatherXmlString1 = retrieveYahooWeather();
        //Criando o elemento XML de retorno
        $weatherXmlObject1 = new SimpleXMLElement($weatherXmlString1);
        //Capturando condi��es do tempo
        $currentCondition = $weatherXmlObject1->xpath("//yweather:forecast");
        $currentCondition2 = $weatherXmlObject1->xpath("//yweather:condition");
        $currentCondition3 = $weatherXmlObject1->xpath("//yweather:atmosphere");
        $currentCondition4 = $weatherXmlObject1->xpath("//yweather:location");


        //Capturando a temperatura m�nima
        $minima = $currentCondition[0]["low"];
        //Capturando a temperatura m�xima
        $maxima = $currentCondition[0]["high"];
        //Capturando a temperatura m�xima
        $dia = $currentCondition[0]["day"];
        //Capturando a temperatura m�xima
        $data = $currentCondition[0]["date"];
        //Capturando a temperatura m�xima
        $texto = tradutor(strtolower($currentCondition2[0]["text"]));
        //Capturando o c�digo da imagem
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
<?=$maxima ?>�C
<?=$minima ?>�C
<img src="http://l.yimg.com/a/i/us/we/52/<?=$codeImage;?>.gif" border="0" />
</html>
