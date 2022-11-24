from python_api import dp_copy, dp_delete, dp_get, dp_rename, dp_set
from python_api import JsonCopy, JsonGet, JsonQuery, JsonSet, JsonDelete, JsonRename
from constant import HOST, PORT, PROTOCOL, ENDPOINT

#--------------- dp_set ---------------#
setBody = JsonSet(
    path='Test:Datenelement',
    value='Inhalt',
    type='string',
    create=True,
    createDefault=False,
    )

responseSet = dp_set(data_points=setBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)

print(responseSet['set'][0]['value'])

#--------------- dp_get ---------------#
getBody = JsonGet(
    path='', 
    query=JsonQuery(
        regExPath='^(Test).*$',
        maxDepth='0'
        )
    )

responseGet = dp_get(data_points=getBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT, tag="")

for response in responseGet['get']:
    print('Path: ' + response['path'])
    if response['value'] != None:
        print('Value: ' + response['value'])
    else:
        print('Value: None')
    print('------------------------------')

#--------------- dp_rename ---------------#
renameBody = JsonRename(
    path='Test:Datenelement',
    newPath='Test:Umbenannt'
)

responseRename  = dp_rename(data_points=renameBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)

print('Code: ' + responseRename['rename'][0]['code'])


#--------------- dp_copy ---------------#
copyBody = JsonCopy(
    path='Test:Umbenannt',
    destPath='Test:Kopiert'
)

responseCopy = dp_copy(data_points=copyBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)

print('Neues Datenelement: ' + responseCopy['copy'][0]['destPath'])

#--------------- dp_delete ---------------#
deleteBody = JsonDelete(
    path='Test:Kopiert'
)

responseDelete = dp_delete(data_points=deleteBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)

print('Code: ' + responseDelete['delete'][0]['code'])


#--------------- Tipps und Tricks ---------------#
deleteBody = JsonDelete(
    path='Test:NewValue'
)

response = dp_delete(data_points=deleteBody.jsonStr, host=HOST, port=PORT, protocol=PROTOCOL, endpoint=ENDPOINT)

if response['delete'][0]['code'] != 'ok':
    print('Fehler bei der Ausführung dp_delete:')
    print(response['delete'][0]['message'])