# User


## Get a specified User

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/17" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users/17"
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
    'https://api.multicrew.co.uk/v1/users/17',
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

url = 'https://api.multicrew.co.uk/v1/users/17'
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
    "username": "user1"
}
```
> Example response (200, when using the email scope):

```json
{
    "id": 1,
    "username": "user1",
    "email": "user1@example.com"
}
```
<div id="execution-results-GETv1-users--user-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-users--user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-users--user-"></code></pre>
</div>
<div id="execution-error-GETv1-users--user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-users--user-"></code></pre>
</div>
<form id="form-GETv1-users--user-" data-method="GET" data-path="v1/users/{user}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-users--user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/users/{user}</code></b>
</p>
<p>
<label id="auth-GETv1-users--user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-users--user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>user</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="user" data-endpoint="GETv1-users--user-" data-component="url" required  hidden>
<br>
The ID of the user</p>
</form>


## Get the authenticated User

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/me" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users/me"
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
    'https://api.multicrew.co.uk/v1/users/me',
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

url = 'https://api.multicrew.co.uk/v1/users/me'
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
    "username": "user1"
}
```
> Example response (200, when using the email scope):

```json
{
    "id": 1,
    "username": "user1",
    "email": "user1@example.com"
}
```
<div id="execution-results-GETv1-users-me" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-users-me"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-users-me"></code></pre>
</div>
<div id="execution-error-GETv1-users-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-users-me"></code></pre>
</div>
<form id="form-GETv1-users-me" data-method="GET" data-path="v1/users/me" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-users-me', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/users/me</code></b>
</p>
<p>
<label id="auth-GETv1-users-me" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-users-me" data-component="header"></label>
</p>
</form>


## Update the authenticated User

<small class="badge badge-darkred">requires authentication</small>

*Requires `user.manage` and `user.email` scope*

> Example request:

```bash
curl -X PUT \
    "https://api.multicrew.co.uk/v1/users/me" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"user@example.com"}'

```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users/me"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "user@example.com"
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
    'https://api.multicrew.co.uk/v1/users/me',
    [
        'headers' => [
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'user@example.com',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'https://api.multicrew.co.uk/v1/users/me'
payload = {
    "email": "user@example.com"
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
    "username": "user1"
}
```
> Example response (200, when using the email scope):

```json
{
    "id": 1,
    "username": "user1",
    "email": "user1@example.com"
}
```
<div id="execution-results-PUTv1-users-me" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTv1-users-me"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTv1-users-me"></code></pre>
</div>
<div id="execution-error-PUTv1-users-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTv1-users-me"></code></pre>
</div>
<form id="form-PUTv1-users-me" data-method="PUT" data-path="v1/users/me" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTv1-users-me', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>v1/users/me</code></b>
</p>
<p>
<label id="auth-PUTv1-users-me" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTv1-users-me" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="PUTv1-users-me" data-component="body"  hidden>
<br>
The updated email of the User.</p>

</form>


## Get all the User&#039;s Requests

Returns 3 arrays containing the User&#039;s `open` (unaccepted), `accepted` and `archived` Requests

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/me/requests" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users/me/requests"
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
    'https://api.multicrew.co.uk/v1/users/me/requests',
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

url = 'https://api.multicrew.co.uk/v1/users/me/requests'
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
    "open": [],
    "accepted": [],
    "archived": []
}
```
<div id="execution-results-GETv1-users-me-requests" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-users-me-requests"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-users-me-requests"></code></pre>
</div>
<div id="execution-error-GETv1-users-me-requests" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-users-me-requests"></code></pre>
</div>
<form id="form-GETv1-users-me-requests" data-method="GET" data-path="v1/users/me/requests" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-users-me-requests', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/users/me/requests</code></b>
</p>
<p>
<label id="auth-GETv1-users-me-requests" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-users-me-requests" data-component="header"></label>
</p>
</form>



