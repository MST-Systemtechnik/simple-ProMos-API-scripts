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

	//------------- Ausführung "func dp_set" -------------//
	var postSetReturn JsonPost

	setBody := &JsonPost_{
		Path:          "Test:Datenelement",
		Value:         "Inhalt",
		Type:          "string",
		Create:        true,
		CreateDefault: false,
	}

	postSetReturn = dp_set(HOST, PORT, "", PROTOCOL, ENDPOINT, *setBody)

	// Ausgabe:
	fmt.Println(postSetReturn.Set[0].Code)
	// Terminal:
	// Inhalt

	//
	//
	//------------- Ausführung "func dp_get" -------------//
	var postGetReturn JsonPost

	getBody := &JsonPost_{
		Path: "",
		Query: JsonQuery{
			RegExPath: "^(Test).*$",
			MaxDepth:  0,
		},
	}

	postGetReturn = dp_get(HOST, PORT, "", PROTOCOL, ENDPOINT, *getBody)

	// Ausgabe:
	for i := range postGetReturn.Get {
		fmt.Print("Path: ")
		fmt.Println(postGetReturn.Get[i].Path)
		fmt.Print("Value: ")
		fmt.Println(postGetReturn.Get[i].Value)
		fmt.Println("------------------------------")
	}
	// Terminal:
	// Path: Test
	// Value: <nil>
	// ------------------------------
	// Path: Test:Datenelement
	// Value: Inhalt
	// ------------------------------

	//
	//
	//------------- Ausführung "func dp_rename" -------------//
	var postRenameReturn JsonPost

	renameBody := &JsonPost_{
		Path:    "Test:Datenelement",
		NewPath: "Test:Umbenannt",
	}

	postRenameReturn = dp_rename(HOST, PORT, "", PROTOCOL, ENDPOINT, *renameBody)

	// Ausgabe:
	fmt.Println("Code: " + postRenameReturn.Rename[0].Code)
	// Terminal:
	// Code: ok

	//
	//
	//------------- Ausführung "func dp_copy" -------------//
	var postCopyReturn JsonPost

	copyBody := &JsonPost_{
		Path:     "Test:Umbenannt",
		DestPath: "Test:Kopiert",
	}

	postCopyReturn = dp_copy(HOST, PORT, "", PROTOCOL, ENDPOINT, *copyBody)

	// Ausgabe:
	fmt.Println("Neues Datenelement: " + postCopyReturn.Copy[0].DestPath)
	// Terminal:
	// Neues Datenelememnt Test:Kopiert

	//
	//
	//------------- Ausführung "func dp_delete" -------------//
	var postDeleteReturn JsonPost

	deleteBody := &JsonPost_{
		Path: "Test:Kopiert",
	}

	postDeleteReturn = dp_delete(HOST, PORT, "", PROTOCOL, ENDPOINT, *deleteBody)

	// Ausgabe:
	println("Code: " + postDeleteReturn.Delete[0].Code)
	// Terminal:
	// Code: ok

	//------------- Tipps und Tricks -------------//

	// Codeabfrage:
	var postDeleteReturn2 JsonPost

	deleteBody2 := &JsonPost_{
		Path: "Test:NewValue",
	}

	postDeleteReturn2 = dp_delete(HOST, PORT, "", PROTOCOL, ENDPOINT, *deleteBody2)

	if postDeleteReturn2.Delete[0].Code != "ok" {
		println("Fehler bei der Ausführung dp_delete:")
		println(postDeleteReturn2.Delete[0].Message)
	}

	// Ausgabe im Terminal:
	// Fehler bei der Ausführung dp_delete
	// Data point doesn't exist

}
