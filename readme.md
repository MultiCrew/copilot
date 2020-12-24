We're all about bringing people from the aviation industry and the flight simulation community together to enjoy flight simulators. We are a community-driven organisation, which specialises in shared cockpit flying, training and support.

# MultiCrew Copilot

![[License](https://github.com/MultiCrew/copilot/blob/master/LICENSE)](https://img.shields.io/github/license/multicrew/copilot)
![Deployment](https://github.com/MultiCrew/copilot/workflows/.github/workflows/deploy-master.yml/badge.svg)
![GitHub Issues](https://img.shields.io/github/issues/multicrew/copilot)
![Discord](https://img.shields.io/discord/440545668168286249)

Copilot, is a tool to help you organise and dispatch shared cockpit flights. It will help you find a copilot for your sim and aircraft with similar addons and preferences. The tool also helps you manage your flight planning, and we have a Discord server you can use for VoIP comms.

At the moment, Copilot is in closed beta, which means that it is only accessible by a select group of people - our "beta testers" - to check over the software, how easy it is to use and how good it looks. Once we're all happy with it, we will release it to the public (you!).
If you're interested in becoming a part of the beta team, simply create an account and apply to join from there.

## Installation

Follow these steps to get Copilot up and running locally:
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan import:airport
php artisan import:aircraft
npm install
npm run prod
```
You can run our tests with:
```bash
vendor/bin/phpunit
```
If you want some sample data in your database, use:
```bash
php artisan db:seed
```
The official version of MultiCrew copilot (reflecting the `master` branch) is available at https://multicrew.co.uk, and the development version (reflecting the `dev` branch) is available at https://dev.multicrew.co.uk.

## Community

All of our software is open source and right here on GitHub, meaning anyone can contribute! For help on getting stuck in to our code, read our [Contributing Guide](https://github.com/MultiCrew/copilot/blob/master/.github/CONTRIBUTING.md), paying close attention to the [Code of Conduct](https://github.com/MultiCrew/copilot/blob/master/.github/CODE_OF_CONDUCT.md).

You can follow the progress of MultiCrew's software development in the [Project Management guide](https://github.com/MultiCrew/copilot/blob/master/.github/PROJECT_MANAGEMENT.md).

## Support

Support for Copilot and its associated software is available on our [Discord Server][https://discord.gg/3jHRAkE].

# API

MultiCrew Copilot provides an API to allow authorised third-party applications to access certain Copilot features, for example creating and managing flight requests, viewing user profiles and more. The API is secured using an implementation of OAuth2 making it easily accessible for most applications. More information can be found at the API documentation https://multicrew.co.uk/docs (or https://dev.multicrew.co.uk/docs for feature previews).
