# PHP

Docker und Docker-compose müssen installiert werden. Dafür gibt es folgende Anleitung: [https://docs.docker.com/](https://docs.docker.com/).

Um mit dieser Anleitung eine API-Abfrage zu machen, muss man sich auf dem gleichen Netzwerk befinden, auf dem das ProMos läuft.

Es müssen keine Änderungen gemacht werden an der Datei php_api.php.

## Vorbereitung

Es muss ein Projektordner erstellt werden und in diesem müssen die Dateien php_api.php, dockerfile und docker-compose.yaml kopiert werden. Erstelle ein neues Dokument mit dem Namen index.php.

In der Datei muss folgendes eingegeben werden:

```php
<?php

include 'php_api.php';

define("HOST", "192.168.56.1");
define("PORT", "9020");
define("ENDPOINT", "json_data");
define("PROTOCOL", "HTTP");
?>

<h1>REST API Anwendungen PHP</h1>
<hr>
```

Navigiere im Terminal in den Projektordner und führe folgenden Befehl aus:

```shell
docker-compose up
```

Nun kann man im Browser localhost:8000 eingeben und die zu erstellende Seite index.php wird angezeigt.

![](img/pasted%20image%200%20(1).png)

### function dp_set

```php
function dp_set($host, $port, $protocol, $endpoint, $body)
```

Den Body kann man mit einem einfachen String erstellen. Dies kann im index.php so aussehen:

```php
$body = '{"path":"Test:Datenelement", "value":"Inhalt", "create": true}';
$return_set =  dp_set(HOST, PORT, PROTOCOL, ENDPOINT, $body);
```

Die Rückgabe von $return_set:

```json
{
    "whois": "php_test_client",
    "set": [
        {
            "path": "Test:Datenelement",
            "code": "ok",
            "type": "string",
            "value": "Inhalt",
            "stamp": "2022-10-07T10:20:35,419+02:00"
        }
    ]
}
```

Die einzelnen Werte der Rückgabe kann man folgendermassen machen:

```php
echo "Erstelltes Datenelement Value: " . $return_set["set"][0]["value"];
echo "<hr>";
```

Im Browser wird beim neuladen folgendes angezeigt:

![](img/pasted%20image%200.png)

### function dp_get

```php
function dp_get($host, $port, $tag, $protocol, $endpoint, $body)
```

Den Body kann man mit einem einfachen String erstellen. Dies kann im index.php so aussehen:

```php
$body = '{"path":"","query":{"regExPath":"^(Test).*$","maxDepth":"0"}}';
$return_get = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, $body);
```

Die Rückgabe von $return_get:

```json
{
    "tag": "",
    "get": [
        {
            "code": "ok",
            "path": "Test",
            "type": "none",
            "value": null,
            "stamp": null,
            "hasChild": true
        },
        {
            "code": "ok",
            "path": "Test:Datenelement",
            "type": "string",
            "value": "Inhalt",
            "stamp": "2022-10-07T10:36:59,006+02:00"
        }
    ]
}
```

Man kann die Werte von mehreren Rückgaben ausgeben mit einem for-Iteration:

```php
foreach ($return_get["get"] as $get) {
    echo "Path: " . json_encode($get["path"]) . "<br>";
    echo "Value: " . json_encode($get["value"]) . "<br>";
    echo "------------------------------<br>";
}

echo "<hr>";
```

Im Browser wird beim neuladen folgendes angezeigt:

![](img/pasted%20image%200%20(2).png)

### function dp_rename

```php
function dp_rename($host, $port, $protocol, $endpoint, $body)
```

Den Body kann man mit einem einfachen String erstellen. Dies kann im index.php so aussehen:

```php
$body = '{"path":"Test:Datenelement","newPath":"Test:Umbenannt"}';
$return_rename = dp_rename(HOST, PORT, PROTOCOL, ENDPOINT, $body);
```

Die Rückgabe von $return_rename:

```json
{
    "whois": "php_test_client",
    "rename": [
        {
            "path": "Test:Datenelement",
            "newPath": "Test:Umbenannt",
            "code": "ok"
        }
    ]
}
```

Man kann den Code auslesen um zu kontrollieren ob das Datenelement erfolgreich umbenannt wurde:

```php
echo "Code: " . $return_rename["rename"][0]["code"];
echo "<hr>";
```

Im Browser wird beim neuladen folgendes angezeigt:

![](img/pasted%20image%200%20(3).png)

### function dp_copy

```php
function dp_copy($host, $port, $protocol, $endpoint, $body)
```

Den Body kann man mit einem einfachen String erstellen. Dies kann im index.php so aussehen:

```php
$body = '{"path":"Test:Umbenannt","destPath":"Test:Kopiert"}';
$return_copy = dp_copy(HOST, PORT, PROTOCOL, ENDPOINT, $body);
```

Die Rückgabe von $return_copy:

```json
{
    "whois": "php_test_client",
    "copy": [
        {
            "path": "Test:Umbenannt",
            "destPath": "Test:Kopiert",
            "code": "ok"
        }
    ]
}
```

Man kann den Pfad vom neuen Datenelement auslesen:

```php
echo "Neues Datenelement: " . $return_copy["copy"][0]["destPath"];
echo "<hr>"
```

Im Browser wird beim neuladen folgendes angezeigt:

![](img/pasted%20image%200%20(4).png)

### function dp_delete

```php
function dp_delete($host, $port, $protocol, $endpoint, $body)
```

Den Body kann man mit einem einfachen String erstellen. Dies kann im index.php so aussehen:

```php
$body = '{"path":"Test:Kopiert"}';
$return_delete = dp_delete(HOST, PORT, PROTOCOL, ENDPOINT, $body);
```

Die Rückgabe von $return_delete:

```json
{
    "whois": "php_test_client",
    "delete": [
        {
            "path": "Test:Kopiert",
            "code": "ok"
        }
    ]
}
```

Man kann den Code auslesen um zu kontrollieren dass das Datenelement erfolgreich gelöscht wurde:

```php
echo "Code: " . $return_delete["delete"][0]["code"];
echo "<hr>";
```

Im Browser wird beim neuladen folgendes angezeigt:

![](img/pasted%20image%200%20(5).png)

### Tipps und Tricks

Wenn eine Ausführung nicht erfolgreich war, sieht man dies indem der Code nicht “ok” ausgibt, sondern einen anderen Wert. (z.B. “not found”)

```json
{
    "whois": "python_test_client",
    "delete": [
        {
            "path": "Test:NewValue",
            "code": "not found",
            "message": "Data point doesn't exist"
        }
    ]
}
```

Dies kann man abfragen und anzeigen, damit man immer Feedback hat, ob die Anfrage erfolgreich ausgeführt worden ist.

```php
if ($response["delete"][0]["code"] != "ok") {
    echo "Fehler bei der Ausführung dp_delete:<br>";
    echo $response["delete"][0]["message"];
}
```

Wenn nun die Anfrage nicht ok ist, wird folgendes im Browser angezeigt:

![](img/pasted%20image%200%20(6).png)
