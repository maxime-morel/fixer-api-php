# PHP wrapper for Fixer API

This API wrapper provide a simple way to access to [fixer.io API](https://fixer.io/documentation) in order to easily consume Fixer endpoints.

---

- [Installation](#installation): Retrieve the list of currencies supported by Fixer
- [QuickStart](#quick-start): Retrieve the list of currencies supported by Fixer


We are supporting multiple endpoints

- [/symbols](#symbols): Retrieve the list of currencies supported by Fixer
- [/latest (Rates)](#rates): Return real-time exchange rate data
- [/convert](#convert): Return real-time exchange rate data

---

### Installation

The package can be included with composer:

    composer require infiniweb/fixer-api-php

### Quick Start

You need to get your free API Key [here https://fixer.io/product](https://fixer.io/product)

Once included to your project, instanciate the Fixer class:

    $fixer = new \InfiniWeb\FixerAPI\Fixer();

And provide the Fixer API Key:

    $fixer->setAccessKey($apiKey);

You are now ready to consume the API!

### Symbols

To get the list of Symbols, simply use the following:

    $symbols = $fixer->symbols->get();

This will return a list of symbols (ISO 4217 Currency Code) as a simple array:

    Array
    (
        [AED] => United Arab Emirates Dirham
        [AFN] => Afghan Afghani
        [ALL] => Albanian Lek
        ...

### Rates

You can get the latest rates for all or for specific currencies:

    $baseCurrency = "EUR";
    $symbols = array("USD", "GBP");
    $return = $fixer->rates->get($baseCurrency, $symbols);

This will return the rates of provided currencies compared to the base currency.

    Array
    (
        [timestamp] => 1528014248
        [base] => EUR
        [rates] => stdClass Object
            (
                [USD] => 1.166583
                [GBP] => 0.874168
            )
    )


### Convert

You can request the conversion from a currency to another. If you provide a date, it will return an historical rate.

    $from = "EUR";
    $to = "USD";
    $amount = "25";
    $date = "2018-01-19";
    $return = $fixer->convert->get($from, $to, $amount, $date);

You will receive the following array:

    Array
    (
        [timestamp] => 1516406399
        [rate] => 1.222637
        [result] => 30.565925
    )

