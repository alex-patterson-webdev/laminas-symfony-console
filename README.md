
# Arp\LaminasSymfonyConsole

## About

A component module that integrates the [Symfony Console](https://github.com/symfony/console) with the [Laminas Framework](https://github.com/laminas).

## Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/laminas-symfony-console ^0.1
    
In order integrate with Laminas MVC, please add the module namespace to the `modules.config.php` of your laminas application.
    
    // moudle.config.php
    return [    
        // .... other module namespaces
        
        'Arp\\LaminasConsole',
    ];
