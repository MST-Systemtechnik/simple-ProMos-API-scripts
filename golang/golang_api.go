package main

import (
	"bytes"
	"encoding/json"
	"net/http"
	"strings"
)

const CONTENT_TYPE = "application/json"

type JsonPost struct {
	Whois  string      `json:"whois"`
	User   string      `json:"user"`
	Tag    string      `json:"tag"`
	Set    []JsonPost_ `json:"set"`
	Get    []JsonPost_ `json:"get"`
	Copy   []JsonPost_ `json:"copy"`
	Rename []JsonPost_ `json:"rename"`
	Delete []JsonPost_ `json:"delete"`
}

type JsonPost_ struct {
	Path          string      `json:"path"`
	Value         interface{} `json:"value"`
	Code          string      `json:"code"`
	Type          string      `json:"type"`
	Create        bool        `json:"create"`
	CreateDefault bool        `json:"createDefault"`
	Query         JsonQuery   `json:"query"`
	Stamp         string      `json:"stamp"`
	Message       string      `json:"message"`
	NewPath       string      `json:"newPath"`
	DestPath      string      `json:"destPath"`
	Recursive     string      `json:"recursive"`
}

type JsonQuery struct {
	RegExPath  string `json:"regExPath"`
	RegExValue string `json:"regExValue"`
	RegExStamp string `json:"regExStamp"`
	MaxDepth   int    `json:"maxDepth"`
}

func dp_set(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {

	var url = strings.ToLower(protocol) + "://" + host + ":" + port + "/" + endpoint

	jsonData := JsonPost{
		Whois: WHOIS,
		User:  USER,
	}

	jsonData.Set = append(jsonData.Set, body)
	jsonData.Set = append(jsonData.Set, body)

	return post_cmd(url, jsonData)
}

func dp_get(host string, port string, tag string, protocol string, endpoint string, jsonData JsonPost) JsonPost {
	var url = strings.ToLower(protocol) + "://" + host + ":" + port + "/" + endpoint

	if tag != "" {
		jsonData.Tag = tag
	}

	return post_cmd(url, jsonData)
}

func dp_rename(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {
	var url = strings.ToLower(protocol) + "://" + host + ":" + port + "/" + endpoint

	jsonData := JsonPost{
		Whois: WHOIS,
		User:  USER,
	}

	jsonData.Rename = append(jsonData.Rename, body)

	return post_cmd(url, jsonData)
}

func dp_copy(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {
	var url = strings.ToLower(protocol) + "://" + host + ":" + port + "/" + endpoint

	jsonData := JsonPost{
		Whois: WHOIS,
	}

	jsonData.Copy = append(jsonData.Copy, body)

	return post_cmd(url, jsonData)
}

func dp_delete(host string, port string, tag string, protocol string, endpoint string, body JsonPost_) JsonPost {
	var url = strings.ToLower(protocol) + "://" + host + ":" + port + "/" + endpoint

	jsonData := JsonPost{
		Whois: WHOIS,
	}

	jsonData.Delete = append(jsonData.Delete, body)

	return post_cmd(url, jsonData)
}

// Post command:

func post_cmd(url string, jsonData JsonPost) JsonPost {

	js, _ := json.MarshalIndent(jsonData, "", " ")
	req, _ := http.NewRequest("POST", url, bytes.NewBuffer(js))
	req.Header.Set("Content-Type", CONTENT_TYPE)
	client := &http.Client{}

	resp, err := client.Do(req)
	if err != nil {
		panic(err)
	}

	var postReturn JsonPost
	json.NewDecoder(resp.Body).Decode(&postReturn)

	return postReturn
}
