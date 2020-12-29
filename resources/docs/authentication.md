# Authenticating Requests

This API is secured using the OAuth2 authorization flow.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

## Authenticating Your Application

The steps below will detail how to setup your application in order to perform authorized requests to this API.

1. Create a client on the [MultiCrew API Page](http://localhost:8000/account#api).
2. Copy the `Client ID` and `Client Secret`, these are what will be used to create access tokens.
3. Create/implement an OAuth2 Client in your chosen language, below are some recommended ones with their respective languages/frameworks:
   1. Laravel: [laravel/socialite](https://github.com/laravel/socialite)
   2. PHP: [thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client)
   3. Node: [panva/node-openid-client](https://github.com/panva/node-openid-client)

    More can be found on the [official OAuth website](https://oauth.net/code/)

4. When implementing your client, use the `/oauth/authorize` endpoint for user authorization and `/oauth/tokens` endpoint to get all the authorized tokens for a user.
5. Once your client is setup you will need to send a request containing the header `Authorization: Bearer access_token` where `access_token` is the user specific token you have received using the OAuth2 flow.

## Query Scopes

| Name | Description |
| -------|--------|
|user.email|Adds the authenticated User's email to the User object |
|user.manage|Update the authenticated User|
|request.create|Create Flight Requests on behalf of the User|
|request.manage|Manage Flight Requests on behalf of the User|
