# Sendlane PHP SDK

This is a quick SDK for the Sendlane API (www.sendlane.com). Method names match the API endpoints to help
keep things consistent and hopefully a bit easier to integrate with Sendlane. 

Some Notes:
* This library throws exceptions, which should be handled by your application
* You can use this library as an instantiated object or statically
* Please see Sendlane's API documentation for more information on how their API works:
https://help.sendlane.com/article/83-api-docs
* I have a few instantiation tests in place, but will likely not have time to get around to writing more anytime soon 

# Examples
## Instantiation
<b>Basic Instantiation</b>
```
try {
    
    // Create Sendlane object
    $sendlane = new Sendlane('subdomain', 'key', 'hash');
    
} catch (\Exception $e) {

    // Echo error message
    echo $e->getMessage();
}
```

<b>Configuration After Instantiation</b>

Allows the possibility of switching accounts without destroying and re-creating the Sendlane class (untested). 
The `configure()` method is also chain-able. 
```
try {
    
    // Create Sendlane object
    $sendlane = new Sendlane();
    
    // Configure 
    $sendlane->configure('subdomain', 'key', 'hash');
    
} catch (\Exception $e) {

    // Echo error message
    echo $e->getMessage();
}
```

## Add subscriber to a list

<b>Object oriented call</b>
```
try {
    
    // Create Sendlane object
    $sendlane = new Sendlane('subdomain', 'key', 'hash');
    
    // Add subscriber to a list
    $result = $sendlane->list_subscriber_add([
        'email' => 'test@test.com',
        'list_id' => 1
    ]);
    
} catch (\Exception $e) {

    // Echo error message
    echo $e->getMessage();
}
```

<b>Static call</b>
```
try {
    
    // Make static API call
    SendlaneClient::api(
        'subdomain',
        'list-subscriber-add',
        [
            'key' => 'your-api-key',
            'hash' => 'your-api-hash',
            'email' => 'user@domain.com',
            'list_id' => 1
        ]
    );
    
} catch (\Exception $e) {

    // Echo error message
    echo $e->getMessage();
}
```

## Get user details
Note that this method has required arguments. For endpoints where all properties are required, the properties
are enforced as method arguments to help prevent missing data. Please refer to API documentation to see what properties
can be sent to which endpoint.
```
try {
    
    // Create Sendlane object
    $sendlane = new Sendlane('subdomain', 'key', 'hash');
    
    // Add subscriber to a list
    $result = $sendlane->user_details('test@test.com', 'password');
    
} catch (\Exception $e) {

    // Echo error message
    echo $e->getMessage();
}
```

## General API information
<b>Example API call (POST method for all calls)</b>

https://SUBDOMAIN.sendlane.com/api/v1/METHOD?api=APIKEY&hash=HASHKEY

<b>List of API Calls (POST method for all calls)</b>

```
/api/v1/user-details
/api/v1/list-subscribers-add
/api/v1/list-subscriber-add
/api/v1/subscribers-delete
/api/v1/unsubscribe
/api/v1/list-create
/api/v1/list-update
/api/v1/list-delete
/api/v1/lists
/api/v1/opt-in-form
/api/v1/opt-in-create
/api/v1/subscriber-export
/api/v1/tags
/api/v1/tag-create
/api/v1/tag-subscriber-add
/api/v1/tag-subscriber-remove
/api/v1/subscriber-exists
```
