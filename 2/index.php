<?php
$request = $_SERVER["REQUEST_URI"];
$ruta = explode("/",$request);

$formato = $ruta[2];

if($ruta[3]=="random"){
  //$ip_ori = rand(0, 255). "." . rand(0, 255). "." . rand(0, 255). "." . rand(0, 255);	
 $ip_ori = rand(0, 10).rand(0,255).rand(0,255).rand(0,255);
}else{
  $ip_ori = $ruta[3];
}

$ip = str_replace(".","",$ip_ori);

$con = mysql_connect("localhost","root","blablabla");
if(!$con){
  header('X-PHP-Response-Code: 500', true, 500);
}else{
  echo "Conexion establecida"; 
}
mysql_select_db("ip2location");

//$query = "SELECT ".$ip." AS ip,country_code,country_name,region_name,city_name,latitude,longitude,zip_code,time_zone FROM ip2location_db11 WHERE ip_from<=".$ip."  AND ip_to>=".$ip. "";
$query = "SELECT ".$ip." AS ip,country_code,country_name,region_name,city_name,latitude,longitude,zip_code,time_zone FROM ip2location_db11 WHERE ip_from >= ".$ip." limit 1";
$result = mysql_query($query) or die("Consulta Fallida");

$linea;
$resultado = array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $linea = $line;
    foreach ($line as $col_value) {
	array_push($resultado,$col_value);
    }
}
mysql_close($con);
if (is_null($linea)){
	echo "IP no valida";
}else{

switch($formato){
	case 'json':
		echo "Formato Json<br>";
		$json = json_encode($linea);
		echo $json; 
	break;
	case 'csv':
		echo "Formato CSV<br>";
		for( $x = 0; $x<count($resultado);$x++){
		if($x == count($resultado)-1)
			echo $resultado[$x];   
		else
			echo "" .$resultado[$x]. ",";
		}				
	break;
	case 'xml':
		echo "Formato XML<br>";		
		$x = "&ltResponse>&ltIP>".$ip_ori."&lt/IP>&ltCountryCode>".$resultado[1]."&lt/CountryCode>&ltCountryName>".$resultado[2]."&lt/CountryName>&ltRegionName>".$resultado[3]."&lt/RegionName>&ltCity>".$resultado[4]."&lt/City>&ltZipCode>".$resultado[7]."&lt/ZipCode>&ltTimeZone>".$resultado[8]."&lt/TimeZone>&ltLatitude>".$resultado[5]."&lt/Latitude>&ltLongitude>".$resultado[6]."&lt/Longitude>&lt/Response>";
		print $x;
	break;
}
}
?>
