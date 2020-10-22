# Prokerala Astrology API Demo

This repository contains the source code for the [demo section](https://api.prokerala.com/demo/) of api.prokerala.com. You can use this as a starting point for developing your own web application. To use this demo, you need to have an account at api.prokerala.com. If you do not already have an account, you can [sign up](https://api.prokerala.com/register) for a free account.

## Prerequisite

To run this demo you need to have the following dependencies installed
 
 - PHP
 - Composer

## Usage

### Download the project

If you have `git` installed on your computer, you can clone the repository using the following command. 

```sh
git clone https://github.com/prokerala/astrology-api-demo
```

If you do not have `git` installed, then you may download a [ZIP archive](https://github.com/prokerala/astrology-api-demo/archive/master.zip) of the repository, and extract it.


#### Install dependencies

Switch to the newly created directory and run 

```
composer install
```

#### Start the built-in PHP server

Open your terminal (PowerShell on Windows) and run

```
DEMO_CLIENT_ID=<YOUR_CLIENT_ID> DEMO_CLIENT_SECRET=<YOUR_CLIENT_SECRET> php -S localhost:8000 -t public

```

In the above command, replace `<YOUR_CLIENT_ID>` and `<YOUR_CLIENT_SECRET>` with your actual client id and secret.

