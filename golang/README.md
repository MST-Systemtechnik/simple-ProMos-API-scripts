# Golang

Golang muss zuerst installiert werden. Dafür kann man die Anleitung bei [Download and install - The Go Programming Language](https://go.dev/doc/install) verwenden.

Um mit dieser Anleitung eine API-Abfrage zu machen, muss man sich auf dem gleichen Netzwerk befinden, auf dem das ProMos NT läuft.

Es müssen keine Änderungen gemacht werden an der Datei golang_api.go sofern man mit dem “package main” arbeitet.

## Vorbereitung

Es muss ein Projektordner erstellt werden und in diesem muss die Datei golang_api.go kopiert werden und ein neues Dokument erstellt mit dem Namen main.go.

In der Datei muss folgendes eingegeben werden:

```go
package main

import (
    "fmt"
)

const HOST = "127.0.0.1"
const PORT = "9020"
const PROTOCOL = "HTTP"
const ENDPOINT = "json_data"
const WHOIS = "golang_test_client"
const USER = ""

func main() {
}
```

Die Konstanten muss man entsprechend den Anforderungen anpassen.

### func dp_set

```go
func dp_set(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {...}
```

Den Body kann man mit dem struct JsonPost_ erstellen. Dies kann im main.go so aussehen:

```go
var postSetReturn JsonPost

setBody := &JsonPost_{
    Path:          "Test:Datenelement",
    Value:         "Inhalt",
    Type:          "string",
    Create:        true,
    CreateDefault: false,
}

postSetReturn = dp_set(HOST, PORT, "", PROTOCOL, ENDPOINT, *setBody)
```

Rückgabe von postSetReturn:

```json
{
    "whois": "golang_test_client",
    "set": [
        {
            "path": "Test:Datenelement",
            "code": "ok",
            "type": "string",
            "value": "Inhalt",
            "stamp": "2022-10-03T14:14:38,392+02:00"
        }
    ]
}
```

Die einzelnen Werte der Rückgabe kann man mit Hilfe von struct JsonPost machen.

```go
fmt.Println(postSetReturn.Set[0].Value)
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Inhalt
```

### func dp_get

```go
func dp_get(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {...}
```

Den Body kann man mit dem struct JsonPost_ erstellen. Dies kann im main.go so aussehen:

```go
var postGetReturn JsonPost

getBody := &JsonPost_{
    Path: "",
    Query: JsonQuery{
        RegExPath: "^(Test).*$",
        RegExValue: ".*",
        RegExStamp: ".*",
        MaxDepth:  0,
    },
}

postGetReturn = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, *getBody)
```

Rückgabe von postGetReturn:

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
            "stamp": "2022-10-04T09:20:11,024+02:00"
        }
    ]
}
```

Man die Werte von mehreren Rückgaben ausgeben mit einer for-Iteration:

```go
    for i := range postGetReturn.Get {
        fmt.Print("Path: ")
        fmt.Println(postGetReturn.Get[i].Path)
        fmt.Print("Value: ")
        fmt.Println(postGetReturn.Get[i].Value)
        fmt.Println("------------------------------")
    }
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Path: Test
Value: <nil>
------------------------------
Path: Test:Datenelement
Value: Inhalt
------------------------------
```

### func dp_rename

```go
func dp_rename(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {...}
```

Den Body kann man mit dem struct JsonPost_ erstellen. Dies kann im main.go so aussehen:

```go
var postRenameReturn JsonPost

renameBody := &JsonPost_{
    Path:    "Test:Datenelement",
    NewPath: "Test:Umbenannt",
}

postRenameReturn = dp_rename(HOST, PORT, "", PROTOCOL, ENDPOINT, *renameBody)
```

Rückgabe von postRenameReturn:

```json
{
    "whois": "test_client",
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

```go
fmt.Println("Code: " + postRenameReturn.Rename[0].Code)
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Code: ok
```

### func dp_copy

```go
func dp_copy(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {...}
```

Den Body kann man mit dem struct JsonPost_ erstellen. Dies kann im main.go so aussehen:

```go
var postCopyReturn JsonPost

copyBody := &JsonPost_{
Path:     "Test:Umbenannt",
DestPath: "Test:Kopiert",
}

postCopyReturn = dp_copy(HOST, PORT, "", PROTOCOL, ENDPOINT, *copyBody)
```

Rückgabe von postCopyReturn:

```json
{
    "whois": "python_test_client",
    "rename": [
        {
            "path": "Test:Umbenannt",
            "newPath": "Test:Kopiert",
            "code": "ok"
        }
    ]
}
```

Man kann den Pfad vom neuen Datenelement auslesen:

```go
fmt.Println("Neues Datenelement: " + postCopyReturn.Copy[0].DestPath)
```

Im Terminal wird nun folgendes ausgegeben:

```shell
Neues Datenelement: Test:Kopiert
```

### func dp_delete

```go
func dp_delete(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {...}
```

Den Body kann man mit dem struct JsonPost_ erstellen. Dies kann im main.go so aussehen:

```go
var postDeleteReturn JsonPost

deleteBody := &JsonPost_{
    Path: "Test:Kopiert",
}

postDeleteReturn = dp_delete(HOST, PORT, "", PROTOCOL, ENDPOINT, *deleteBody)
```

Rückgabe von postDeleteReturn:

```json
{
    "whois": "test_client",
    "delete": [
        {
            "path": "Test:Kopiert",
            "code": "ok"
        }
    ]
}
```

Man kann den Code auslesen um zu kontrollieren das Datenelement erfolgreich gelöscht wurde:

```go
println("Code: " + postDeleteReturn.Delete[0].Code)
```

Im Terminal wird nun folgendes ausgegeben:

```shell
code: ok
```

### Tipps und Tricks

Wenn eine Ausführung nicht erfolgreich war, sieht man dies indem der Code nicht “ok” ausgibt, sondern einen anderen Wert. (z.B. “not found”)

```json
{
    "whois": "test_client",
    "delete": [
        {
            "path": "Test:NewValue",
            "code": "not found",
            "message": "Data point doesn't exist"
        }
    ]
}
```

Diese kann man abfragen und anzeigen, damit man immer Feedback hat, ob die Anfrage erfolgreich ausgeführt worden ist.

```go
if postDeleteReturn2.Delete[0].Code != "ok" {
    println("Fehler bei der Ausführung dp_delete:")
    println(postDeleteReturn2.Delete[0].Message)
}
```

Wenn nun die Anfrage nicht ok ist, kann folgende Meldung im Terminal angezeigt werden:

```shell
Fehler bei der Ausführung dp_delete:
Data point doesn’t exist
```