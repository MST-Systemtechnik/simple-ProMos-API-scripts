import requests
import json
from schema import Schema, Optional, Or
from constant import WHOIS, USER, CONTENT_TYPE

# Create a session for the http requests, speeds up tests by reusing connections
SESSION = requests.Session()


set_parameter_schema = Schema(
    [
        {
            'path': str,
            'value': Or(str, int, None, float, bool),
            Optional('create'): bool,
            Optional('createDefault'): bool,
            Optional('type'): Or("int", "double", "string", "bool", "none", "int32", "uint32", "int64"),
        }
    ]
)

def dp_set(data_points, host, port, protocol, endpoint):
    url = f"{protocol.lower()}://{host}:{port}/{endpoint}"
    headers = {"Content-type": CONTENT_TYPE}

    set_parameter_schema.validate([data_points])

    data = {
        "whois": WHOIS,
        "user": USER,
        "set": [data_points]
    }

    json_data = json.dumps(data)
    response = SESSION.post(url=url, headers=headers, data=json_data)
    response_data = response.json()
    return response_data

get_parameter_schema = Schema(
    [
        {
            'path': str,
            Optional('query'): object,
            Optional('tag'): object,
        }
    ]
)



def dp_get(data_points, host, port, protocol, endpoint, tag: str = None):
    url = f"{protocol.lower()}://{host}:{port}/{endpoint}"
    headers = {"Content-type": CONTENT_TYPE}

    get_parameter_schema.validate([data_points])

    data = {
        "get":[data_points]
    }
    if tag is not None:
        data["tag"] = tag

    json_data = json.dumps(data)
    response = SESSION.post(url=url, headers=headers, data=json_data)
    response_data = response.json()
    return response_data

rename_parameter_schema = Schema(
    [
        {
            'path': str,
            'newPath': str,
        }
    ]
)    

def dp_rename(data_points, host, port, protocol, endpoint):
    url = f"{protocol.lower()}://{host}:{port}/{endpoint}"
    headers = {"Content-type": CONTENT_TYPE}

    rename_parameter_schema.validate([data_points])

    data = {
        "whois": WHOIS,
        "user": USER,
        "rename": [data_points]
    }

    json_data = json.dumps(data)
    response = SESSION.post(url=url, headers=headers, data=json_data)
    response_data = response.json()
    return response_data

copy_parameter_schema = Schema(
    [
        {
            'path': str,
            'destPath': str,
        }
    ]
)

def dp_copy(data_points, host, port, protocol, endpoint):
    url = f"{protocol.lower()}://{host}:{port}/{endpoint}"
    headers = {"Content-type": CONTENT_TYPE}

    copy_parameter_schema.validate([data_points])

    data = {
        "whois": WHOIS,
        "copy": [data_points]
    }

    json_data = json.dumps(data)
    response = SESSION.post(url=url, headers=headers, data=json_data)
    response_data = response.json()
    return response_data

delete_parameter_schema = Schema(
    [
        {
            'path': str,
        }
    ]
)

def dp_delete(data_points, host, port, protocol, endpoint):
    url = f"{protocol.lower()}://{host}:{port}/{endpoint}"
    headers = {"Content-type": CONTENT_TYPE}

    delete_parameter_schema.validate([data_points])

    data = {
        "whois": WHOIS,
        "delete": [data_points]
    }

    json_data = json.dumps(data)
    response = SESSION.post(url=url, headers=headers, data=json_data)
    response_data = response.json()
    return response_data



class JsonSet():
    jsonStr = {}
    def __init__(self, path, value, type=None, create=None, createDefault=None):
        self.jsonStr['path'] = path
        self.jsonStr['value'] = value

        if type != None:
            self.jsonStr['type'] = type
        if create != None:
            self.jsonStr['create'] = create
        if createDefault != None:
            self.jsonStr['createDefault'] = createDefault

class JsonGet:
    jsonStr = {}
    def __init__(self, path, query=None):
        self.jsonStr['path'] = path

        if query != None:
            try:
                self.jsonStr['query'] = query.jsonStr
            except:
                self.jsonStr['query'] = query
        

class JsonQuery:
    jsonStr = {}
    def __init__(self, regExPath=None, regExValue=None, regExStamp=None, maxDepth=None):
        if regExPath != None:
            self.jsonStr['regExPath'] = regExPath
        if regExValue != None:
            self.jsonStr['regExValue'] = regExValue
        if regExStamp != None:
            self.jsonStr['regExStamp'] = regExStamp
        if maxDepth != None:
            self.jsonStr['maxDepth']  = maxDepth        

class JsonRename:
    jsonStr = {}
    def __init__(self, path, newPath):
        self.jsonStr['path'] = path
        self.jsonStr['newPath'] = newPath

class JsonCopy:
    jsonStr = {}
    def __init__(self, path, destPath):
        self.jsonStr['path'] = path
        self.jsonStr['destPath'] = destPath

class JsonDelete:
    jsonStr = {}
    def __init__(self, path):
        self.jsonStr['path'] = path