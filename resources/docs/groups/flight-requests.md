# Flight Requests

Endpoints for managing flight requests

## Search Requests

<small class="badge badge-darkred">requires authentication</small>

Search for all flight requests or narrow down the search using the optional paramaters

> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/requests?aircraft[]=A318&airport[]=EGKK" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/requests"
);

let params = {
    "aircraft[]": "A318",
    "airport[]": "EGKK",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://api.multicrew.co.uk/v1/requests',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'query' => [
            'aircraft[]'=> 'A318',
            'airport[]'=> 'EGKK',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/requests'
params = {
  'aircraft[]': 'A318',
  'airport[]': 'EGKK',
}
headers = {
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()
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
<div id="execution-results-GETv1-requests" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-requests"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-requests"></code></pre>
</div>
<div id="execution-error-GETv1-requests" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-requests"></code></pre>
</div>
<form id="form-GETv1-requests" data-method="GET" data-path="v1/requests" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-requests', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/requests</code></b>
</p>
<p>
<label id="auth-GETv1-requests" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-requests" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>aircraft</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="aircraft.0" data-endpoint="GETv1-requests" data-component="query"  hidden>
<input type="text" name="aircraft.1" data-endpoint="GETv1-requests" data-component="query" hidden>
<br>
An array of aircraft ICAO codes.</p>
<p>
<b><code>airport</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="airport.0" data-endpoint="GETv1-requests" data-component="query"  hidden>
<input type="text" name="airport.1" data-endpoint="GETv1-requests" data-component="query" hidden>
<br>
An array of airport ICAO codes.</p>
</form>


## Create a Request

<small class="badge badge-darkred">requires authentication</small>

Create a new public or private Flight Request.

Include the optional `callback` parameter to get notified when the request is accepted.

Note: Either `departure` or `arrival` must have at least 1 ICAO code for the request to be stored.

*Requires `request.create` scope*

> Example request:

```bash
curl -X POST \
    "https://api.multicrew.co.uk/v1/requests" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"departure":["EGLL","EGKK"],"aircraft":"A320","public":true,"callback":"example.com"}'

```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/requests"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "aircraft": "A320",
    "public": true,
    "callback": "example.com"
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
    'https://api.multicrew.co.uk/v1/requests',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'departure' => [
                'EGLL',
                'EGKK',
            ],
            'aircraft' => 'A320',
            'public' => true,
            'callback' => 'example.com',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/requests'
payload = {
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "aircraft": "A320",
    "public": true,
    "callback": "example.com"
}
headers = {
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "id": 1,
    "plan_id": null,
    "public": 1,
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "arrival": null,
    "created_at": "2020-01-01 00:00:00",
    "updated_at": "2020-01-01 00:00:00",
    "expiry": null,
    "callback": "example.com",
    "aircraft": {
        "id": 1,
        "icao": "A320",
        "name": "Aerosoft Airbus A320 Professional",
        "sim": "P3D v4"
    },
    "requestee": {
        "id": 1,
        "username": "user1"
    },
    "acceptee": null
}
```
<div id="execution-results-POSTv1-requests" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTv1-requests"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTv1-requests"></code></pre>
</div>
<div id="execution-error-POSTv1-requests" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTv1-requests"></code></pre>
</div>
<form id="form-POSTv1-requests" data-method="POST" data-path="v1/requests" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTv1-requests', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>v1/requests</code></b>
</p>
<p>
<label id="auth-POSTv1-requests" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTv1-requests" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>departure</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="departure.0" data-endpoint="POSTv1-requests" data-component="body"  hidden>
<input type="text" name="departure.1" data-endpoint="POSTv1-requests" data-component="body" hidden>
<br>
An array of all the departure ICAO codes, leave blank for no preference.</p>
<p>
<b><code>arrival</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="arrival.0" data-endpoint="POSTv1-requests" data-component="body"  hidden>
<input type="text" name="arrival.1" data-endpoint="POSTv1-requests" data-component="body" hidden>
<br>
An array of all the arrival ICAO codes, leave blank for no preference.</p>
<p>
<b><code>aircraft</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="aircraft" data-endpoint="POSTv1-requests" data-component="body" required  hidden>
<br>
An ICAO code for the requested aircraft.</p>
<p>
<b><code>public</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTv1-requests" hidden><input type="radio" name="public" value="true" data-endpoint="POSTv1-requests" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTv1-requests" hidden><input type="radio" name="public" value="false" data-endpoint="POSTv1-requests" data-component="body" required ><code>false</code></label>
<br>
Whether the request should be public or not.</p>
<p>
<b><code>callback</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="callback" data-endpoint="POSTv1-requests" data-component="body"  hidden>
<br>
The full URL to receive notifications for this request.</p>

</form>


## Get a specific Request

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/requests/6" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/6"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://api.multicrew.co.uk/v1/requests/6',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/requests/6'
headers = {
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "id": 1,
    "plan_id": null,
    "public": 1,
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "arrival": null,
    "created_at": "2020-01-01 00:00:00",
    "updated_at": "2020-01-01 00:00:00",
    "expiry": null,
    "callback": "example.com",
    "aircraft": {
        "id": 1,
        "icao": "A320",
        "name": "Aerosoft Airbus A320 Professional",
        "sim": "P3D v4"
    },
    "requestee": {
        "id": 1,
        "username": "user1"
    },
    "acceptee": null
}
```
<div id="execution-results-GETv1-requests--request-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-requests--request-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-requests--request-"></code></pre>
</div>
<div id="execution-error-GETv1-requests--request-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-requests--request-"></code></pre>
</div>
<form id="form-GETv1-requests--request-" data-method="GET" data-path="v1/requests/{request}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-requests--request-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/requests/{request}</code></b>
</p>
<p>
<label id="auth-GETv1-requests--request-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-requests--request-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="request" data-endpoint="GETv1-requests--request-" data-component="url" required  hidden>
<br>
The ID of the Request</p>
</form>


## Update a Request

<small class="badge badge-darkred">requires authentication</small>

Update a public or private Flight Request.

Include the optional callback parameter to get notified when the request is accepted.

Note: Either departure or arrival must have at least 1 ICAO code for the request to be stored.

*Requires `request.manage` scope*

> Example request:

```bash
curl -X PUT \
    "https://api.multicrew.co.uk/v1/requests/15" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"departure":["EGLL","EGKK"],"aircraft":"A320","public":true,"callback":"example.com"}'

```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/15"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "aircraft": "A320",
    "public": true,
    "callback": "example.com"
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
    'https://api.multicrew.co.uk/v1/requests/15',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'departure' => [
                'EGLL',
                'EGKK',
            ],
            'aircraft' => 'A320',
            'public' => true,
            'callback' => 'example.com',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/requests/15'
payload = {
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "aircraft": "A320",
    "public": true,
    "callback": "example.com"
}
headers = {
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "id": 1,
    "plan_id": null,
    "public": 1,
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "arrival": null,
    "created_at": "2020-01-01 00:00:00",
    "updated_at": "2020-01-01 00:00:00",
    "expiry": null,
    "callback": "example.com",
    "aircraft": {
        "id": 1,
        "icao": "A320",
        "name": "Aerosoft Airbus A320 Professional",
        "sim": "P3D v4"
    },
    "requestee": {
        "id": 1,
        "username": "user1"
    },
    "acceptee": null
}
```
<div id="execution-results-PUTv1-requests--request-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTv1-requests--request-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTv1-requests--request-"></code></pre>
</div>
<div id="execution-error-PUTv1-requests--request-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTv1-requests--request-"></code></pre>
</div>
<form id="form-PUTv1-requests--request-" data-method="PUT" data-path="v1/requests/{request}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTv1-requests--request-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>v1/requests/{request}</code></b>
</p>
<p>
<small class="badge badge-purple">PATCH</small>
 <b><code>v1/requests/{request}</code></b>
</p>
<p>
<label id="auth-PUTv1-requests--request-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTv1-requests--request-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="request" data-endpoint="PUTv1-requests--request-" data-component="url" required  hidden>
<br>
The ID of the Request</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>departure</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="departure.0" data-endpoint="PUTv1-requests--request-" data-component="body"  hidden>
<input type="text" name="departure.1" data-endpoint="PUTv1-requests--request-" data-component="body" hidden>
<br>
An array of all the departure ICAO codes, leave blank for no preference.</p>
<p>
<b><code>arrival</code></b>&nbsp;&nbsp;<small>string[]</small>     <i>optional</i> &nbsp;
<input type="text" name="arrival.0" data-endpoint="PUTv1-requests--request-" data-component="body"  hidden>
<input type="text" name="arrival.1" data-endpoint="PUTv1-requests--request-" data-component="body" hidden>
<br>
An array of all the arrival ICAO codes, leave blank for no preference.</p>
<p>
<b><code>aircraft</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="aircraft" data-endpoint="PUTv1-requests--request-" data-component="body" required  hidden>
<br>
An ICAO code for the requested aircraft.</p>
<p>
<b><code>public</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="PUTv1-requests--request-" hidden><input type="radio" name="public" value="true" data-endpoint="PUTv1-requests--request-" data-component="body" required ><code>true</code></label>
<label data-endpoint="PUTv1-requests--request-" hidden><input type="radio" name="public" value="false" data-endpoint="PUTv1-requests--request-" data-component="body" required ><code>false</code></label>
<br>
Whether the request should be public or not.</p>
<p>
<b><code>callback</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="callback" data-endpoint="PUTv1-requests--request-" data-component="body"  hidden>
<br>
The full URL to receive notifications for this request.</p>

</form>


## Remove a Request

<small class="badge badge-darkred">requires authentication</small>

*Requires `request.manage` scope*

> Example request:

```bash
curl -X DELETE \
    "https://api.multicrew.co.uk/v1/requests/19" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/19"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'https://api.multicrew.co.uk/v1/requests/19',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/requests/19'
headers = {
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "message": "Resource deleted"
}
```
<div id="execution-results-DELETEv1-requests--request-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEv1-requests--request-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEv1-requests--request-"></code></pre>
</div>
<div id="execution-error-DELETEv1-requests--request-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEv1-requests--request-"></code></pre>
</div>
<form id="form-DELETEv1-requests--request-" data-method="DELETE" data-path="v1/requests/{request}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEv1-requests--request-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>v1/requests/{request}</code></b>
</p>
<p>
<label id="auth-DELETEv1-requests--request-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEv1-requests--request-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="request" data-endpoint="DELETEv1-requests--request-" data-component="url" required  hidden>
<br>
The ID of the Request</p>
</form>


## Accept a Request

<small class="badge badge-darkred">requires authentication</small>

Accept a public or private Request.

Note: To accept a private Request, a valid `code` must be passed with the request.

*Requires `request.manage` scope*

> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/requests/19/accept/animi" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/19/accept/animi"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://api.multicrew.co.uk/v1/requests/19/accept/animi',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/requests/19/accept/animi'
headers = {
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "id": 1,
    "plan_id": null,
    "public": 1,
    "departure": [
        "EGLL",
        "EGKK"
    ],
    "arrival": null,
    "created_at": "2020-01-01 00:00:00",
    "updated_at": "2020-01-01 00:00:00",
    "expiry": null,
    "callback": "example.com",
    "aircraft": {
        "id": 1,
        "icao": "A320",
        "name": "Aerosoft Airbus A320 Professional",
        "sim": "P3D v4"
    },
    "requestee": {
        "id": 1,
        "username": "user1"
    },
    "acceptee": null
}
```
<div id="execution-results-GETv1-requests--request--accept--code--" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-requests--request--accept--code--"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-requests--request--accept--code--"></code></pre>
</div>
<div id="execution-error-GETv1-requests--request--accept--code--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-requests--request--accept--code--"></code></pre>
</div>
<form id="form-GETv1-requests--request--accept--code--" data-method="GET" data-path="v1/requests/{request}/accept/{code?}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-requests--request--accept--code--', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/requests/{request}/accept/{code?}</code></b>
</p>
<p>
<label id="auth-GETv1-requests--request--accept--code--" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-requests--request--accept--code--" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>request</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="request" data-endpoint="GETv1-requests--request--accept--code--" data-component="url" required  hidden>
<br>
The ID of the Request</p>
<p>
<b><code>code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="code" data-endpoint="GETv1-requests--request--accept--code--" data-component="url"  hidden>
<br>
The code required to accept a private Request</p>
</form>



