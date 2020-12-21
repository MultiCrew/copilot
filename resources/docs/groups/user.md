# User


## Get the authenticated User

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users"
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
    'https://api.multicrew.co.uk/v1/users',
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
<div id="execution-results-GETv1-users" hidden>
    <blockquote>Received response<span id="execution-response-status-GETv1-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-users"></code></pre>
</div>
<div id="execution-error-GETv1-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-users"></code></pre>
</div>
<form id="form-GETv1-users" data-method="GET" data-path="v1/users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETv1-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>v1/users</code></b>
</p>
<p>
<label id="auth-GETv1-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETv1-users" data-component="header"></label>
</p>
</form>


## Get a specified User

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/2" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users/2"
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
    'https://api.multicrew.co.uk/v1/users/2',
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


## Update the specified User

<small class="badge badge-darkred">requires authentication</small>

TODO implement user updating along with add comments

> Example request:

```bash
curl -X PUT \
    "https://api.multicrew.co.uk/v1/users/3" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://api.multicrew.co.uk/v1/users/3"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'https://api.multicrew.co.uk/v1/users/3',
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
<div id="execution-results-PUTv1-users--user-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTv1-users--user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTv1-users--user-"></code></pre>
</div>
<div id="execution-error-PUTv1-users--user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTv1-users--user-"></code></pre>
</div>
<form id="form-PUTv1-users--user-" data-method="PUT" data-path="v1/users/{user}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {access_token}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTv1-users--user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>v1/users/{user}</code></b>
</p>
<p>
<small class="badge badge-purple">PATCH</small>
 <b><code>v1/users/{user}</code></b>
</p>
<p>
<label id="auth-PUTv1-users--user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTv1-users--user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>user</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="user" data-endpoint="PUTv1-users--user-" data-component="url" required  hidden>
<br>
The ID of the user</p>
</form>



