# Flight Requests

Endpoints for managing flight requests

## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://multicrew.co.uk/api/v1/requests?aircraft[]=quia&airport[]=reprehenderit" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/*"
```

```javascript
const url = new URL(
    "https://multicrew.co.uk/api/v1/requests"
);

let params = {
    "aircraft[]": "quia",
    "airport[]": "reprehenderit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/*",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://multicrew.co.uk/api/v1/requests',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/*',
        ],
        'query' => [
            'aircraft[]'=> 'quia',
            'airport[]'=> 'reprehenderit',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
[
    {
        "id": 2,
        "plan_id": null,
        "public": 1,
        "departure": [
            "EGKK"
        ],
        "arrival": [
            "EHAM"
        ],
        "created_at": "2020-01-01 00:00:00",
        "updated_at": "2020-01-01 01:00:00",
        "expiry": null,
        "aircraft": {
            "id": 2,
            "icao": "A320",
            "name": "FlightFactor A320 Ultimate",
            "sim": "X-Plane 11"
        },
        "requestee": {
            "id": 1,
            "username": "user1"
        },
        "acceptee": {
            "id": 2,
            "username": "user2"
        }
    },
    {
        "id": 3,
        "plan_id": null,
        "public": 1,
        "departure": [
            "EGKK"
        ],
        "arrival": null,
        "created_at": "2020-01-01 00:00:00",
        "updated_at": "2020-01-01 00:00:00",
        "expiry": null,
        "aircraft": {
            "id": 3,
            "icao": "A318",
            "name": "Aerosoft Airbus A318 Professional",
            "sim": "P3D v4"
        },
        "requestee": {
            "id": 2,
            "username": "user2"
        },
        "acceptee": null
    }
]
```
<div id="execution-results-GETapi-v1-requests" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-v1-requests"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-requests"></code></pre>
</div>
<div id="execution-error-GETapi-v1-requests" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-requests"></code></pre>
</div>
<form id="form-GETapi-v1-requests" data-method="GET" data-path="api/v1/requests" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/*"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-requests', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/v1/requests</code></b>
</p>
<p>
<label id="auth-GETapi-v1-requests" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-v1-requests" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>aircraft[]</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="aircraft.0" data-endpoint="GETapi-v1-requests" data-component="query"  hidden>
<br>
array An array of aircraft ICAO codes</p>
<p>
<b><code>airport[]</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="airport.0" data-endpoint="GETapi-v1-requests" data-component="query"  hidden>
<br>
array An array of airport ICAO codes</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "https://multicrew.co.uk/api/v1/requests" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/*" \
    -d '{"departure":["omnis","magni"],"arrival":["eaque","sit"],"aircraft":"cupiditate","public":false,"callback":"http:\/\/crooks.com\/"}'

```

```javascript
const url = new URL(
    "https://multicrew.co.uk/api/v1/requests"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/*",
};

let body = {
    "departure": [
        "omnis",
        "magni"
    ],
    "arrival": [
        "eaque",
        "sit"
    ],
    "aircraft": "cupiditate",
    "public": false,
    "callback": "http:\/\/crooks.com\/"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://multicrew.co.uk/api/v1/requests',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/*',
        ],
        'json' => [
            'departure' => [
                'omnis',
                'magni',
            ],
            'arrival' => [
                'eaque',
                'sit',
            ],
            'aircraft' => 'cupiditate',
            'public' => false,
            'callback' => 'http://crooks.com/',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


<div id="execution-results-POSTapi-v1-requests" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-v1-requests"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-requests"></code></pre>
</div>
<div id="execution-error-POSTapi-v1-requests" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-requests"></code></pre>
</div>
<form id="form-POSTapi-v1-requests" data-method="POST" data-path="api/v1/requests" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/*"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-requests', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/v1/requests</code></b>
</p>
<p>
<label id="auth-POSTapi-v1-requests" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-v1-requests" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>departure</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="departure.0" data-endpoint="POSTapi-v1-requests" data-component="body" required  hidden>
<input type="text" name="departure.1" data-endpoint="POSTapi-v1-requests" data-component="body" hidden>
<br>
</p>
<p>
<b><code>arrival</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="arrival.0" data-endpoint="POSTapi-v1-requests" data-component="body" required  hidden>
<input type="text" name="arrival.1" data-endpoint="POSTapi-v1-requests" data-component="body" hidden>
<br>
</p>
<p>
<b><code>aircraft</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="aircraft" data-endpoint="POSTapi-v1-requests" data-component="body" required  hidden>
<br>
</p>
<p>
<b><code>public</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-v1-requests" hidden><input type="radio" name="public" value="true" data-endpoint="POSTapi-v1-requests" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-v1-requests" hidden><input type="radio" name="public" value="false" data-endpoint="POSTapi-v1-requests" data-component="body" required ><code>false</code></label>
<br>
</p>
<p>
<b><code>callback</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="callback" data-endpoint="POSTapi-v1-requests" data-component="body"  hidden>
<br>
The value must be a valid URL.</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://multicrew.co.uk/api/v1/requests/vel" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/*"
```

```javascript
const url = new URL(
    "https://multicrew.co.uk/api/v1/requests/vel"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/*",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://multicrew.co.uk/api/v1/requests/vel',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/*',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url='http://multicrew.co.uk/login'" />

        <title>Redirecting to http://multicrew.co.uk/login</title>
    </head>
    <body>
        Redirecting to <a href="http://multicrew.co.uk/login">http://multicrew.co.uk/login</a>.
    </body>
</html>
```
<div id="execution-results-GETapi-v1-requests--request-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-v1-requests--request-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-requests--request-"></code></pre>
</div>
<div id="execution-error-GETapi-v1-requests--request-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-requests--request-"></code></pre>
</div>
<form id="form-GETapi-v1-requests--request-" data-method="GET" data-path="api/v1/requests/{request}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/*"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-requests--request-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/v1/requests/{request}</code></b>
</p>
<p>
<label id="auth-GETapi-v1-requests--request-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-v1-requests--request-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="request" data-endpoint="GETapi-v1-requests--request-" data-component="url" required  hidden>
<br>
</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "https://multicrew.co.uk/api/v1/requests/accusamus" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/*" \
    -d '{"departure":["nesciunt","voluptatem"],"arrival":["et","sequi"],"aircraft":"porro","public":false,"callback":"http:\/\/www.mclaughlin.com\/quidem-nisi-doloremque-illum-mollitia-voluptatem"}'

```

```javascript
const url = new URL(
    "https://multicrew.co.uk/api/v1/requests/accusamus"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/*",
};

let body = {
    "departure": [
        "nesciunt",
        "voluptatem"
    ],
    "arrival": [
        "et",
        "sequi"
    ],
    "aircraft": "porro",
    "public": false,
    "callback": "http:\/\/www.mclaughlin.com\/quidem-nisi-doloremque-illum-mollitia-voluptatem"
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://multicrew.co.uk/api/v1/requests/accusamus',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/*',
        ],
        'json' => [
            'departure' => [
                'nesciunt',
                'voluptatem',
            ],
            'arrival' => [
                'et',
                'sequi',
            ],
            'aircraft' => 'porro',
            'public' => false,
            'callback' => 'http://www.mclaughlin.com/quidem-nisi-doloremque-illum-mollitia-voluptatem',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


<div id="execution-results-PUTapi-v1-requests--request-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-v1-requests--request-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-requests--request-"></code></pre>
</div>
<div id="execution-error-PUTapi-v1-requests--request-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-requests--request-"></code></pre>
</div>
<form id="form-PUTapi-v1-requests--request-" data-method="PUT" data-path="api/v1/requests/{request}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/*"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-requests--request-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/v1/requests/{request}</code></b>
</p>
<p>
<small class="badge badge-purple">PATCH</small>
 <b><code>api/v1/requests/{request}</code></b>
</p>
<p>
<label id="auth-PUTapi-v1-requests--request-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-v1-requests--request-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="request" data-endpoint="PUTapi-v1-requests--request-" data-component="url" required  hidden>
<br>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>departure</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="departure.0" data-endpoint="PUTapi-v1-requests--request-" data-component="body" required  hidden>
<input type="text" name="departure.1" data-endpoint="PUTapi-v1-requests--request-" data-component="body" hidden>
<br>
</p>
<p>
<b><code>arrival</code></b>&nbsp;&nbsp;<small>string[]</small>  &nbsp;
<input type="text" name="arrival.0" data-endpoint="PUTapi-v1-requests--request-" data-component="body" required  hidden>
<input type="text" name="arrival.1" data-endpoint="PUTapi-v1-requests--request-" data-component="body" hidden>
<br>
</p>
<p>
<b><code>aircraft</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="aircraft" data-endpoint="PUTapi-v1-requests--request-" data-component="body" required  hidden>
<br>
</p>
<p>
<b><code>public</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="PUTapi-v1-requests--request-" hidden><input type="radio" name="public" value="true" data-endpoint="PUTapi-v1-requests--request-" data-component="body" required ><code>true</code></label>
<label data-endpoint="PUTapi-v1-requests--request-" hidden><input type="radio" name="public" value="false" data-endpoint="PUTapi-v1-requests--request-" data-component="body" required ><code>false</code></label>
<br>
</p>
<p>
<b><code>callback</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="callback" data-endpoint="PUTapi-v1-requests--request-" data-component="body"  hidden>
<br>
The value must be a valid URL.</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "https://multicrew.co.uk/api/v1/requests/nemo" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/*"
```

```javascript
const url = new URL(
    "https://multicrew.co.uk/api/v1/requests/nemo"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/*",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://multicrew.co.uk/api/v1/requests/nemo',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/*',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


<div id="execution-results-DELETEapi-v1-requests--request-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-v1-requests--request-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-requests--request-"></code></pre>
</div>
<div id="execution-error-DELETEapi-v1-requests--request-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-requests--request-"></code></pre>
</div>
<form id="form-DELETEapi-v1-requests--request-" data-method="DELETE" data-path="api/v1/requests/{request}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/*"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-requests--request-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/v1/requests/{request}</code></b>
</p>
<p>
<label id="auth-DELETEapi-v1-requests--request-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-v1-requests--request-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="request" data-endpoint="DELETEapi-v1-requests--request-" data-component="url" required  hidden>
<br>
</p>
</form>


## Accept a speficied request

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://multicrew.co.uk/api/v1/requests/modi/accept/occaecati" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/*"
```

```javascript
const url = new URL(
    "https://multicrew.co.uk/api/v1/requests/modi/accept/occaecati"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/*",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://multicrew.co.uk/api/v1/requests/modi/accept/occaecati',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/*',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (302):

```json

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url='http://multicrew.co.uk/login'" />

        <title>Redirecting to http://multicrew.co.uk/login</title>
    </head>
    <body>
        Redirecting to <a href="http://multicrew.co.uk/login">http://multicrew.co.uk/login</a>.
    </body>
</html>
```
<div id="execution-results-GETapi-v1-requests--id--accept--code--" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-v1-requests--id--accept--code--"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-requests--id--accept--code--"></code></pre>
</div>
<div id="execution-error-GETapi-v1-requests--id--accept--code--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-requests--id--accept--code--"></code></pre>
</div>
<form id="form-GETapi-v1-requests--id--accept--code--" data-method="GET" data-path="api/v1/requests/{id}/accept/{code?}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/*"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-requests--id--accept--code--', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/v1/requests/{id}/accept/{code?}</code></b>
</p>
<p>
<label id="auth-GETapi-v1-requests--id--accept--code--" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-v1-requests--id--accept--code--" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-v1-requests--id--accept--code--" data-component="url" required  hidden>
<br>
</p>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="code" data-endpoint="GETapi-v1-requests--id--accept--code--" data-component="url"  hidden>
<br>
</p>
</form>



