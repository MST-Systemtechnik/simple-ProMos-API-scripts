# Python

Python muss zuerst installiert werden. Dafür gibt es auf der Webseite [https://www.python.org/](https://www.python.org/) die entsprechenden Anleitungen und Dateien.

Um mit dieser Anleitung eine API-Abfrage zu machen, muss man sich auf dem gleichen Netzwerk befinden, auf dem das ProMos NT läuft.

Es müssen keine Änderungen gemacht werden an der Datei python_api.py.

## Vorbereitung

Es muss ein Projektordner erstellt werden und in diesem müssen die Dateien python_api.py und constant.py kopiert werden und ein neues Dokument erstellt mit dem Namen main.py.

In der Datei muss folgendes eingegeben werden:

```python
from python_api import dp_copy, dp_delete, dp_get, dp_rename, dp_set
from constant import HOST, PORT, PROTOCOL, ENDPOINT
```

Die Konstanten kann man entsprechend den Anforderungen in der Datei constant.py anpassen.

### def dp_set

```python
def dp_set(data_points, host, port, protocol, endpoint):
```

Den Body kann man mit der Klasse JsonSet erstellen. Dies kann im main.py so aussehen:

```python
setBody = JsonSet(
    path='Test:Datenelement',
    value='Inhalt',
    type='string',
    create=True,
    createDefault=False,
    )

responseSet = dp_set(data_points=setBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)
```

Die Rückgabe von responseSet:

```json
{
    "whois" : "python_test_client",
    "set" : [
        {
            "path" : "Test:Datenelement",
            "code" : "ok",
            "type" : "string",
            "value" : "Inhalt",
            "stamp" : "2022-10-05T08:15:55,805+02:00"
        }
    ]
}
```

Die einzelnen Werte der Rückgabe kann man folgendermassen machen:

```python
print(responseSet['set'][0]['value'])
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Inhalt
```

### def dp_get

```python
def dp_get(data_points, host, port, protocol, endpoint, tag: str = None):
```

Den Body kann man mit der Klasse JsonGet erstellen. Dies kann im main.py so aussehen:

```python
getBody = JsonGet(
    path='',
    query=JsonQuery(
        regExPath='^(Test).*$',
        maxDepth='0'
        )
    )

responseGet = dp_get(data_points=getBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT, tag="")
```

Die Rückgabe von responseGet:

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
            "stamp": "2022-10-05T08:43:29,341+02:00"
        }
    ]
}
```

Man kann die Werte von mehreren Rückgaben ausgeben mit einem for-Iteration:

```python
for response in responseGet['get']:
    print('Path: ' + response['path'])
    if response['value'] != None:
        print('Value: ' + response['value'])
    else:
        print('Value: None')
    print('------------------------------')
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Path: Test
Value: None
------------------------------
Path: Test:Datenelement
Value: Inhalt
------------------------------
```

### def dp_rename

```python
def dp_rename(data_points, host, port, protocol, endpoint):
```

Den Body kann man mit der Klasse JsonRename erstellen. Dies kann im main.py so aussehen:

```python
renameBody = JsonRename(
    path='Test:Datenelement',
    newPath='Test:Umbenannt'
)

responseRename = dp_rename(data_points=renameBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)
```

Die Rückgabe von responseRename:

```json
{
    "whois": "python_test_client",
    "rename": [
        {
            "path": "Test:Datenelement",
            "newPath": "Test:Umbenannt",
            "code": "ok"
        }
    ]
}
```

Man kann den Code auslesen um zu kontrollieren ob das Datenelement erfolgreich umbenannte wurde:

```python
print('Code: ' + responseRename['rename'][0]['code'])
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Code: ok
```

### def dp_copy

```python
def dp_copy(data_points, host, port, protocol, endpoint):
```

Den Body kann man mit der Klasse JsonCopy erstellen. Dies kann im main.py so aussehen:

```python
copyBody = JsonCopy(
    path='Test:Umbenannt',
    destPath='Test:Kopiert'
)

responseCopy = dp_copy(data_points=copyBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)
```

Die Rückgabe von responseCopy:

```json
{
    "whois": "python_test_client",
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

```python
print('Neues Datenelement: ' + responseCopy['copy'][0]['destPath'])
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Neues Datenelement: Test:Kopiert
```

### def dp_delete

```python
def dp_delete(data_points, host, port, protocol, endpoint):
```

Den Body kann man mit der Klasse JsonDelete erstellen. Dies kann im main.py so aussehen:

```python
deleteBody = JsonDelete(
    path='Test:Kopiert'
)

responseDelete = dp_delete(data_points=deleteBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)
```

Die Rückgabe von responseDelete:

```json
{
    "whois": "python_test_client",
    "delete": [
        {
            "path": "Test:Kopiert",
            "code": "ok"
        }
    ]
}
```

Man kann den Code auslesen um zu kontrollieren dass das Datenelement erfolgreich gelöscht wurde:

```python
print('Code: ' + responseDelete['delete'][0]['code'])
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Code: ok
```

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

```python
if response['delete'][0]['code'] != 'ok':
    print('Fehler bei der Ausführung dp_delete:')
    print(response['delete'][0]['message'])
```

Wenn nun die Anfrage nicht ok ist, kann folgende Meldung im Terminal angezeigt werden:

```shell
Fehler bei der Ausführung dp_delete:
Data point doesn't exist
```