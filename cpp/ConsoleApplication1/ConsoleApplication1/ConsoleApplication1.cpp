//

#include "restclient-cpp/connection.h"
#include "restclient-cpp/restclient.h"
#include <iostream>

#include "nlohmann/json.hpp"
using json = nlohmann::json;

#include "Struct_API.h"


using namespace std;


int main()
{
    ns::person p = { "Ned Flanders", "744 Evergreen Terrace", 60 };

    json j1;
    j1["name"] = p.name;
    j1["address"] = p.address;
    j1["age"] = p.age;

    ns::person p2{
    j1["name"].get<std::string>(),
    j1["address"].get<std::string>(),
    j1["age"].get<int>()
    };

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
    json j;

    j["whois"] = "cpp_test_client";
    j["user"] = "";
    j["set"] = { {
        {"path", "Test:lululu"}, 
        {"value", "lululululululu"}, 
        {"create", true} 
    } };

    string s_set = j.dump();

    RestClient::Response responseSet = conn->post("/json_data", s_set);   


    std::cout << "Code: " << responseSet.code << endl;
    std::cout << "Body: " << responseSet.body << endl;

    // Get
    RestClient::Response responseGet = conn->post("/json_data", "{\"get\": [{\"path\":\"System:Time\"}]}");

    std::cout << "Code: " << responseGet.code << endl;
    std::cout << "Body: " << responseGet.body << endl;

    // deinit RestClient. After calling this you have to call RestClient::init()
    // again before you can use it
    RestClient::disable();

    delete conn;
}