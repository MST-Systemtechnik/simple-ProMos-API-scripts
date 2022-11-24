function dp_set(host, port, protocol, endpoint, body) {
  url = protocol.toLowerCase() + "://" + host + ":" + port + "/" + endpoint


  var xhr = new XMLHttpRequest();
  xhr.open("POST", url);

  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      dp_set_rsp(xhr.responseText);
    }
  };

  jsonData = {
    "whois": WHOIS,
    "user": USER,
    "set": []
  };

  jsonData.set.push(body);
  
  xhr.send(JSON.stringify(jsonData));
}

function dp_get(host, port, tag, protocol, endpoint, body) {
  url = protocol.toLowerCase() + "://" + host + ":" + port + "/" + endpoint


  var xhr = new XMLHttpRequest();
  xhr.open("POST", url);

  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      dp_get_rsp(xhr.responseText);
    }
  };

  jsonData = {
    "tag": tag,
    "get": []
  };
  

    jsonData.get.push(body);


  xhr.send(JSON.stringify(jsonData));
}


function dp_rename(host, port, protocol, endpoint, body) {
  url = protocol.toLowerCase() + "://" + host + ":" + port + "/" + endpoint


  var xhr = new XMLHttpRequest();
  xhr.open("POST", url);

  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      dp_rename_rsp(xhr.responseText);
    }
  };

  jsonData = {
    "whois": WHOIS,
    "user": USER,
    "rename": []
  };

  jsonData.rename.push(body);
  
  xhr.send(JSON.stringify(jsonData));
}


function dp_copy(host, port, protocol, endpoint, body) {
  url = protocol.toLowerCase() + "://" + host + ":" + port + "/" + endpoint


  var xhr = new XMLHttpRequest();
  xhr.open("POST", url);

  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      dp_copy_rsp(xhr.responseText);
    }
  };

  jsonData = {
    "whois": WHOIS,
    "copy": []
  };

  jsonData.copy.push(body);
  
  xhr.send(JSON.stringify(jsonData));
}


function dp_delete(host, port, protocol, endpoint, body) {
  url = protocol.toLowerCase() + "://" + host + ":" + port + "/" + endpoint


  var xhr = new XMLHttpRequest();
  xhr.open("POST", url);

  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      dp_delete_rsp(xhr.responseText);
    }
  };

  jsonData = {
    "whois": WHOIS,
    "delete": []
  };

  jsonData.delete.push(body);
  
  xhr.send(JSON.stringify(jsonData));
}