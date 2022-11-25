#include "restclient-cpp/connection.h"
#include "restclient-cpp/restclient.h"
#include <iostream>

#include "nlohmann/json.hpp"

#include "Struct_API.h"
#include "ConsoleApplication1.h"

using json = nlohmann::json;
using namespace std;


int main()
{
     std::cout << "Start restclient" << endl;

    // initialize RestClient
    RestClient::init();

    // get a connection object
    RestClient::Connection* conn = new RestClient::Connection("http://127.0.0.1:9020");

    // set connection timeout to 5s
    conn->SetTimeout(5);

    // set custom user agent
    // (this will result in the UA "foo/cool restclient-cpp/VERSION")
    conn->SetUserAgent("Test");

    // set headers
    // conn->AppendHeader("Accept", "application/json");
    conn->AppendHeader("Content-Type", "application/json");

    // Set
    json j_Set;

    // Json
    j_Set["whois"] = "cpp_test_client";
    j_Set["user"] = "";
    j_Set["set"] = { {
        {"path", "Test:Datenelement"}, 
        {"value", "Inhalt"}, 
        {"create", true},
        {"CreateDefault", false}
    } };

    // Post
    string s_set = j_Set.dump();
    RestClient::Response responseSet = conn->post("/json_data", s_set);   

    // Output response
    json j_set_response = json::parse(responseSet.body);
    std::cout << j_set_response["set"][0]["value"] << endl;

    // Get
    json j_get;

    // Json
    j_get["get"] = { {
        {"path", "Test"},
        {"query", {
            {"regExPath", "^(Test).*$"},
            {"maxDepth", 0}
        }}
    } };
    
    // Post
    string s_get = j_get.dump();
    RestClient::Response responseGet = conn->post("/json_data", s_get);

    // Output response
    json j_get_response = json::parse(responseGet.body);

    for (size_t i = 0; i < j_get_response["get"].size(); i++)
    {
        std::cout << "Path: " << j_get_response["get"][i]["path"] << endl;
        std::cout << "Value: " << j_get_response["get"][i]["value"] << endl;
        std::cout << "------------------------------" << endl;
    }


    // Rename
    json j_rename;

    // Json
    j_rename["whois"] = "cpp_test_client";
    j_rename["rename"] = { {
        {"path", "Test:Datenelement"},
        {"newPath", "Test:Umbenannt"}
    } };

    // Post
    string s_rename = j_rename.dump();
    RestClient::Response responseRename = conn->post("/json_data", s_rename);

    // Output response
    json j_rename_response = json::parse(responseRename.body);
    
    std::cout << "Code: " << j_rename_response["rename"][0]["code"] << endl;

    // Copy
    json j_copy;

    j_copy["whois"] = "cpp_test_client";
    j_copy["copy"] = { {
        {"path", "Test:Umbenannt"},
        {"destPath", "Test:Kopiert"}
    } };

    // Post
    string s_copy = j_copy.dump();
    RestClient::Response responseCopy = conn->post("/json_data", s_copy);

    // Output response
    json j_copy_response = json::parse(responseCopy.body);

    std::cout << "Neues Datenelement: " << j_copy_response["copy"][0]["destPath"] << endl;
    
    // Delete
    json j_delete;

    j_delete["whois"] = "cpp_test_client";
    j_delete["delete"] = { {
        {"path", "Test:Kopiert"},
    } };

    // Post
    string s_delete = j_delete.dump();
    RestClient::Response responseDelete = conn->post("/json_data", s_delete);

    // Output response
    json j_delete_response = json::parse(responseDelete.body);

    std::cout << "Code: " << j_delete_response["delete"][0]["code"] << endl;

    // Tipps und Tricks
    json j_delete2;

    j_delete2["whois"] = "cpp_test_client";
    j_delete2["delete"] = { {
        {"path", "Test:NewValue"}
    } };

    // Post 
    string s_delete2 = j_delete2.dump();
    RestClient::Response responseDelete2 = conn->post("/json_data", s_delete2);

    // Output response
    json j_delete_response2 = json::parse(responseDelete2.body);

    if (j_delete_response2["delete"][0]["code"] != "ok") {
        std::cout << "Fehler bei der Ausfuehrung 'delete'" << endl;
        std::cout << j_delete_response2["delete"][0]["message"] << endl;
    }

    // deinit RestClient. After calling this you have to call RestClient::init()
    // again before you can use it
    RestClient::disable();

    delete conn;
}