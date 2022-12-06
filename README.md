# Einführung

Für Detaillierte Angaben zum API-Dokument verweisen

# Aufbau REST API

Beim Aufbau einer REST API abfrage, benötigt es einen URL, einen Payload (Body) und einen Custom Header.

#### URL

Der URL setzt sich aus dem Protocol, Host, Port und Endpoint zusammen.

![](https://lh6.googleusercontent.com/lfkIxyXlf2-1YT334HVlevufDthG_8MTLT1Z3Oe2_vgsDCac9gWBGuVaR7UwiK0wKAdS3mic7tRYYUZgqWskVJlN9bV4Jidun1FHslqAnewnHOXZZ0uebmXvbtHmJsygs2GOt6UgKWcwJPJFXH3ppY8CDq3U3fWjIzL5jpKSNwTbMTgQG7WBL2vy0WCVhQ)

Protocol: Standard ‘HTTP’ beim Port 9020

Host: IP-Adresse von ProMos NT

Port: Port, welcher bei den Verbindungseinstellungen im DMS gewählt wurde.

![](https://lh6.googleusercontent.com/SYDARxVdbJpavGxhHab2rqGUIp6CFA7tsKjgX2xtxmirg4-dzXTSBSayRUI8eOUswqZcdm6WsaS7X77ZGKdwqp414UX51LpEJcAlO7rTyrcbNT6dTgwS73xDX4weNpWXvk-LP3Bzw78no0HqMN7PUqEARFX1WXlt5gCpLyjTbyvQ7BoBU-Ttw3vPxwKmiQ)

#### Payload (Body)

Das sind die einzelnen Befehle, welche man ausführen möchte. Alle Befehle und die darauf erhaltene Antworten sind im JSON-Format. Diese werden im Kapitel Befehle genauer beschrieben.

#### Custom Header

Wird angegeben, um bei der Anfrage nach den korrekten Medientypen zu suchen. In diesem Dokument wird nur einer verwendet:

|              |                  |
| ------------ | ---------------- |
| Header Name  | Header Value     |
| Content-Type | application/json |

# Befehle

## Set

Mit Set können neue Datenelemente erstellt werden oder Werte ändern. 

Jeder Set-Befehl hat die Namenswerte Whois, User und Set. Im Set befindet sich dann ein Object Array 

Set hat folgende Inhalte:

| Feld          | Beschreibung                                                                                       | Typ                           | Optional |
| ------------- | -------------------------------------------------------------------------------------------------- | ----------------------------- | -------- |
| path          | Pfad vom Datenelement (DMS-Name)                                                                   | string                        | nein     |
| value         | Wert vom Datenelement                                                                              | number, string, boolean, null | nein     |
| type          | Typ vom Datenelement                                                                               | string                        | ja       |
| create        | Auf true setzen wenn ein neues Datenelement erstellt werden soll                                   | boolean                       | ja       |
| createDefault | Ein nicht vorhandenes Datenelement erstellen. Vorhandene Datenelemente werden nicht überschrieben. | boolean                       | ja       |

Beispiel:

```json
{
    "whois": "test_client",
    "user": "",
    "set": [
        {
            "path": "Test:NewValue",
            "value": "Hello World",
            "create": true
        },
        {
            "path": "Test:AnotherValue",
            "value": "Hello there",
            "create": true
        },
    ]
}
```

## Get

Mit Get können Werte von Datenelemente ausgelesen werden.

Jeder Get-Befehl hat die Namenswerte Tag und Get. Im Get befindet sich dann ein Object Array

Get hat folgende Inhalte:

| Feld  | Beschreibung                                                      | Typ    | Optional |
| ----- | ----------------------------------------------------------------- | ------ | -------- |
| path  | Pfad vom Datenelement (DMS-Name)                                  | string | nein     |
| query | Ein Query-Objekt (Inhalt ist unterhalb)                           | object | ja       |
| tag   | Alle Daten, die in der Rückmeldung wiedergegeben werden sollen.   | any    | ja       |

Query hat folgende Inhalte:

| Feld       | Beschreibung                                                   | Typ    | Optional |
| ---------- | -------------------------------------------------------------- | ------ | -------- |
| regExPath  | Regulärer Ausdruck (RegEx) vom Pfad. Standard ist leer.        | string | ja       |
| regExValue | Regulärer Ausdruck (RegEx) vom Wert. Standard ist leer.        | string | ja       |
| regExStamp | Regulärer Ausdruck (RegEx) vom Zeitstempel. Standard ist leer. | string | ja       |
| maxDepth   | Maximale Tiefe für rekursive Suchpfade. Standard ist 1 (aktueller Pfad). 0 bedeutet keine Einschränkungen, alle Unterpfade werden durchsucht.                                                            | number | ja       |

Beispiel:

```json
{
    "tag": "",
    "get": [
        {
            "path": "",
            "query": {
                "regExPath": "^(Test).*$",
                "maxDepth": "0"
            }
        }
    ]
}
```

## Rename

Mit Rename können Datenelemente umbenannt werden.

Jeder Rename-Befehl hat die Namenswerte Whois, User und Rename. Im Rename befindet sich dann ein Object Array 

Rename hat folgende Inhalte:

| Feld    | Beschreibung                           | Typ    | Optional |
| ------- | -------------------------------------- | ------ | -------- |
| path    | Pfad vom Datenelement (DMS-Name)       | string | nein     |
| newPath | Neuer Pfad vom Datenelement (DMS-Name) | string | nein     |

Beispiel:

```json
{
    "whois": "test_client",
    "user": "",
    "rename": [
        {
            "path": "Test:NewValue",
            "newPath": "Test:NewName"
        }
    ]
}
```

## Copy

Mit Copy können Datenelemente kopiert werden.

Jeder Copy-Befehl hat die Namenswerte Whois und Copy. Im Copy befindet sich dann ein Object Array 

Copy hat folgende Inhalte:

| Feld     | Beschreibung                           | Typ    | Optional |
| -------- | -------------------------------------- | ------ | -------- |
| path     | Pfad vom Datenelement (DMS-Name)       | string | nein     |
| destPath | Neuer Pfad vom Datenelement (DMS-Name) | string | nein     |

Beispiel:

```json
{
    "whois": "test_client",
    "user": "",
    "copy": [
        {
            "path": "Test:NewName",
            "destPath": "Test:CopyName"
        }
    ]
}
```

## Delete

Mit Delete können Datenelemente gelöscht werden.

Jeder Delete-Befehl hat die Namenswerte Whois und Delete. Im Delete befindet sich dann ein Object Array 

Delete hat folgenden Inhalt:

| Feld | Beschreibung                     | Typ    | Optional |
| ---- | -------------------------------- | ------ | -------- |
| path | Pfad vom Datenelement (DMS-Name) | string | nein     |

Beispiel:

```json
{
    "whois": "test_client",
    "user": "",
    "delete": [
        {
            "path": "Test:CopyName"
        }
    ]
}
```
