//

#include "restclient-cpp/connection.h"
#include "restclient-cpp/restclient.h"
#include <iostream>

#include "nlohmann/json.hpp"
using json = nlohmann::json;

#include "Struct_API.h"
#include "ConsoleApplication1.h"


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

    j_Set["whois"] = "cpp_test_client";
    j_Set["user"] = "";
    j_Set["set"] = { {
        {"path", "Test:Datenelement"}, 
        {"value", "Inhalt"}, 
        {"create", true},
        {"CreateDefault", false}
    } };

    string s_set = j_Set.dump();

    RestClient::Response responseSet = conn->post("/json_data", s_set);   


    std::cout << "Code: " << responseSet.code << endl;
    std::cout << "Body: " << responseSet.body << endl;

    // Get
    json j_get;

    j_get["get"] = { {
        {"path", "Test"},
        {"query", {
            {"regExPath", "^(Test).*$"},
            {"maxDepth", 0}
        }}
    } };
    
    string s_get = j_get.dump();
    std::cout << s_get << endl;

    RestClient::Response responseGet = conn->post("/json_data", s_get);

    
    std::cout << "Code: " << responseGet.code << endl;
    std::cout << "Body: " << responseGet.body << endl;

    // Rename
    json j_rename;

    j_rename["whois"] = "cpp_test_client";
    j_rename["rename"] = { {
        {"path", "Test:Datenelement"},
        {"newPath", "Test:Umbenannt"}
    } };

    string s_rename = j_rename.dump();
    std::cout << s_rename << endl;

    RestClient::Response responseRename = conn->post("/json_data", s_rename);

    std::cout << "Code: " << responseRename.code << endl;
    std::cout << "Body: " << responseRename.body << endl;

    // Copy
    json j_copy;

    j_copy["whois"] = "cpp_test_client";
    j_copy["copy"] = { {
        {"path", "Test:Umbenannt"},
        {"destPath", "Test:CopyName"}
} };

    string s_copy = j_copy.dump();
    std::cout << s_copy << endl;

    RestClient::Response responseCopy = conn->post("/json_data", s_copy);

    std::cout << "Code: " << responseCopy.code << endl;
    std::cout << "Body: " << responseCopy.body << endl;
    
    // Delete
    json j_delete;

    j_delete["whois"] = "cpp_test_client";
    j_delete["delete"] = { {
        {"path", "Test:CopyName"},
    } };

    string s_delete = j_delete.dump();
    std::cout << s_delete << endl;

    RestClient::Response responseDelete = conn->post("/json_data", s_delete);

    std::cout << "Code: " << responseDelete.code << endl;
    std::cout << "Body: " << responseDelete.body << endl;

    // deinit RestClient. After calling this you have to call RestClient::init()
    // again before you can use it
    RestClient::disable();

    delete conn;
}