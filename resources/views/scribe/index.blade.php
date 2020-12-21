<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>MultiCrew Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/style.css") }}" media="screen" />
        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/print.css") }}" media="print" />
        <script src="{{ asset("vendor/scribe/js/all.js") }}"></script>

        <link rel="stylesheet" href="{{ asset("vendor/scribe/css/highlight-darcula.css") }}" media="" />
        <script src="{{ asset("vendor/scribe/js/highlight.pack.js") }}"></script>
    <script>hljs.initHighlightingOnLoad();</script>

</head>

<body class="" data-languages="[&quot;bash&quot;,&quot;javascript&quot;,&quot;php&quot;]">
<a href="#" id="nav-button">
      <span>
        NAV
            <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="-image" class=""/>
      </span>
</a>
<div class="tocify-wrapper">
        <img src="img/logo_long_light.png" alt="logo" class="logo" style="padding-top: 10px;" width="230px"/>
                <div class="lang-selector">
                            <a href="#" data-language-name="bash">bash</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                            <a href="#" data-language-name="php">php</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href='http://github.com/knuckleswtf/scribe'>Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: December 21 2020</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>This documentation aims to provide all the information you need to use the MultiCrew API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://api.multicrew.co.uk/</code></pre><h1>Webhook Calls</h1>
<h2>Webhook Signing</h2>
<p>All Webhook Calls are signed using the sha256 hash, combining the Webhook payload with your client <code>secret</code></p>
<blockquote>
<p>Example Response</p>
</blockquote>
<pre><code class="language-json">{
    "type": "Accepted",
    "request": {
        "id": 1,
        "plan_id": null,
        "code": "7Ag5h0lYC0",
        "public": 0,
        "departure": [
            "EGKK"
        ],
        "arrival": [
            "EGPD"
        ],
        "created_at": "2020-01-01 00:00:00",
        "updated_at": "2020-01-01 00:00:00",
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
            "username": "user2",
            "email": "user@test.com"
        }
    }
}</code></pre><h1>Authenticating Requests</h1>
<p>This API is secured using the OAuth2 authorization flow.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<h2>Authenticating Your Application</h2>
<p>The steps below will detail how to setup your application in order to perform authorized requests to this API.</p>
<ol>
<li>
<p>Create a client on the <a href="http://localhost:8000/account#api">MultiCrew API Page</a>.</p>
</li>
<li>
<p>Copy the <code>Client ID</code> and <code>Client Secret</code>, these are what will be used to create access tokens.</p>
</li>
<li>
<p>Create/implement an OAuth2 Client in your chosen language, below are some recommended ones with their respective languages/frameworks:</p>
<ol>
<li>Laravel: <a href="https://github.com/laravel/socialite">laravel/socialite</a></li>
<li>PHP: <a href="https://github.com/thephpleague/oauth2-client">thephpleague/oauth2-client</a></li>
<li>Node: <a href="https://github.com/panva/node-openid-client">panva/node-openid-client</a></li>
</ol>
<p>More can be found on the <a href="https://oauth.net/code/">official OAuth website</a></p>
</li>
<li>
<p>When implementing your client, use the <code>/oauth/authorize</code> endpoint for user authorization and <code>/oauth/tokens</code> endpoint to get all the authorized tokens for a user.</p>
</li>
<li>
<p>Once your client is setup you will need to send a request containing the header <code>Authorization: Bearer access_token</code> where <code>access_token</code> is the user specific token you have received using the OAuth2 flow.</p>
</li>
</ol>
<h2>Query Scopes</h2>
<table>
<thead>
<tr>
<th>Name</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>user.email</td>
<td>Adds the authenticated User's email to the User object</td>
</tr>
<tr>
<td>user.manage</td>
<td>Update the authenticated User</td>
</tr>
<tr>
<td>request.create</td>
<td>Create Flight Requests on behalf of the User</td>
</tr>
<tr>
<td>request.manage</td>
<td>Manage Flight Requests on behalf of the User</td>
</tr>
</tbody>
</table><h1>Flight Requests</h1>
<p>Endpoints for managing flight requests</p>
<h2>Search Requests</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Search for all flight requests or narrow down the search using the optional paramaters</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://api.multicrew.co.uk/v1/requests?aircraft[]=A318&amp;airport[]=EGKK" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://api.multicrew.co.uk/v1/requests"
);

let params = {
    "aircraft[]": "A318",
    "airport[]": "EGKK",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.multicrew.co.uk/v1/requests',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'aircraft[]'=&gt; 'A318',
            'airport[]'=&gt; 'EGKK',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">[
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
]</code></pre>
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
<h2>Create a Request</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Create a new public or private Flight Request.</p>
<p>Include the optional <code>callback</code> parameter to get notified when the request is accepted.</p>
<p>Note: Either <code>departure</code> or <code>arrival</code> must have at least 1 ICAO code for the request to be stored.</p>
<p><em>Requires <code>request.create</code> scope</em></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "https://api.multicrew.co.uk/v1/requests" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"departure":["EGLL","EGKK"],"aircraft":"A320","public":true,"callback":"example.com"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.multicrew.co.uk/v1/requests',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'departure' =&gt; [
                'EGLL',
                'EGKK',
            ],
            'aircraft' =&gt; 'A320',
            'public' =&gt; true,
            'callback' =&gt; 'example.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
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
<h2>Get a specific Request</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://api.multicrew.co.uk/v1/requests/9" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/9"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.multicrew.co.uk/v1/requests/9',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
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
<h2>Update a Request</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Update a public or private Flight Request.</p>
<p>Include the optional callback parameter to get notified when the request is accepted.</p>
<p>Note: Either departure or arrival must have at least 1 ICAO code for the request to be stored.</p>
<p><em>Requires <code>request.manage</code> scope</em></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "https://api.multicrew.co.uk/v1/requests/17" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"departure":["EGLL","EGKK"],"aircraft":"A320","public":true,"callback":"example.com"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/17"
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
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;put(
    'https://api.multicrew.co.uk/v1/requests/17',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'departure' =&gt; [
                'EGLL',
                'EGKK',
            ],
            'aircraft' =&gt; 'A320',
            'public' =&gt; true,
            'callback' =&gt; 'example.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
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
<h2>Remove a Request</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p><em>Requires <code>request.manage</code> scope</em></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "https://api.multicrew.co.uk/v1/requests/11" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/11"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://api.multicrew.co.uk/v1/requests/11',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Resource deleted"
}</code></pre>
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
<h2>Accept a Request</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p>Accept a public or private Request.</p>
<p>Note: To accept a private Request, a valid <code>code</code> must be passed with the request.</p>
<p><em>Requires <code>request.manage</code> scope</em></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://api.multicrew.co.uk/v1/requests/17/accept/quia" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://api.multicrew.co.uk/v1/requests/17/accept/quia"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.multicrew.co.uk/v1/requests/17/accept/quia',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
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
</form><h1>User</h1>
<h2>Get a specified User</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/12" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "https://api.multicrew.co.uk/v1/users/12"
);

let headers = {
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.multicrew.co.uk/v1/users/12',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "username": "user1"
}</code></pre>
<blockquote>
<p>Example response (200, when using the email scope):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "username": "user1",
    "email": "user1@example.com"
}</code></pre>
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
<h2>Get the authenticated User</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/me" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.multicrew.co.uk/v1/users/me',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "username": "user1"
}</code></pre>
<blockquote>
<p>Example response (200, when using the email scope):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "username": "user1",
    "email": "user1@example.com"
}</code></pre>
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
<h2>Update the authenticated User</h2>
<p><small class="badge badge-darkred">requires authentication</small></p>
<p><em>Requires <code>user.manage</code> and <code>user.email</code> scope</em></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "https://api.multicrew.co.uk/v1/users/me" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"user@example.com"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;put(
    'https://api.multicrew.co.uk/v1/users/me',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'user@example.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "username": "user1"
}</code></pre>
<blockquote>
<p>Example response (200, when using the email scope):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "username": "user1",
    "email": "user1@example.com"
}</code></pre>
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
<h2>Get all the User&#039;s Requests</h2>
<p>Returns 3 arrays containing the User&#039;s <code>open</code> (unaccepted), <code>accepted</code> and <code>archived</code> Requests</p>
<p><small class="badge badge-darkred">requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "https://api.multicrew.co.uk/v1/users/me/requests" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
}).then(response =&gt; response.json());</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.multicrew.co.uk/v1/users/me/requests',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "open": [],
    "accepted": [],
    "archived": []
}</code></pre>
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
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                                    <a href="#" data-language-name="php">php</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var languages = ["bash","javascript","php"];
        setupLanguages(languages);
    });
</script>
</body>
</html>