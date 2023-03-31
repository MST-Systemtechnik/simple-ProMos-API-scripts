<style>

</style>

<?php
include 'php_api.php';

define("HOST", "192.168.30.1"); // Muss die eigene IP-Adresse sein
define("PORT", "9020");
define("ENDPOINT", "json_data");
define("PROTOCOL", "HTTP");
?>
<h1>REST API Anwendungen PHP</h1>
<hr>

<!--------------- dp_set --------------->
<?php

$body = '{"path":"Test:Datenelement", "value":"Inhalt", "create": true}';
$return_set =  dp_set(HOST, PORT, PROTOCOL, ENDPOINT, $body);

echo "Erstelltes Datenelement Value: " . $return_set["set"][0]["value"];
echo "<hr>";

?>


<!--------------- dp_get --------------->
<?php

$body = '{"path":"","query":{"regExPath":"Test.*","maxDepth":"0"}}';
$return_get = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, $body);

foreach ($return_get["get"] as $get) {
    echo "Path: " . json_encode($get["path"]) . "<br>";
    echo "Value: " . json_encode($get["value"]) . "<br>";
    echo "------------------------------<br>";
}
echo "<hr>";
?>

<!--------------- dp_get 2 --------------->
<?php

$body = '{"path":"System:Date:DateLong"}, {"path":"System:Time:Hours"}';
$return_get = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, $body);

foreach ($return_get["get"] as $get) {
    echo "Path: " . json_encode($get["path"]) . "<br>";
    echo "Value: " . json_encode($get["value"]) . "<br>";
    echo "------------------------------<br>";
}
echo "<hr>";
?>


<!--------------- dp_rename --------------->
<?php

$body = '{"path":"Test:Datenelement","newPath":"Test:Umbenannt"}';
$return_rename = dp_rename(HOST, PORT, PROTOCOL, ENDPOINT, $body);

echo "Code: " . $return_rename["rename"][0]["code"];
echo "<hr>";
?>



<!--------------- dp_copy --------------->
<?php

$body = '{"path":"Test:Umbenannt","destPath":"Test:Kopiert"}';
$return_copy = dp_copy(HOST, PORT, PROTOCOL, ENDPOINT, $body);

echo "Neues Datenelement: " . $return_copy["copy"][0]["destPath"];
echo "<hr>";
?>


<!--------------- dp_delete --------------->
<?php

$body = '{"path":"Test:Kopiert"}';
$return_delete = dp_delete(HOST, PORT, PROTOCOL, ENDPOINT, $body);

echo "Code: " . $return_delete["delete"][0]["code"];
echo "<hr>";
?>


<!--------------- Tipps und Tricks --------------->
<?php

$body = '{"path":"Test:NewValue"}';
$response = dp_delete(HOST, PORT, PROTOCOL, ENDPOINT, $body);

if ($response["delete"][0]["code"] != "ok") {
    echo "Fehler bei der Ausführung dp_delete:<br>";
    echo $response["delete"][0]["message"];
}
?>