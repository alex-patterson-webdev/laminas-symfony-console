![github workflow](https://github.com/alex-patterson-webdev/laminas-symfony-console/actions/workflows/workflow.yml/badge.svg)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/laminas-symfony-console/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/laminas-symfony-console)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-patterson-webdev/laminas-symfony-console/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-patterson-webdev/laminas-symfony-console/?branch=master)

# Arp\LaminasSymfonyConsole

## About

A component module that integrates the [Symfony Console](https://github.com/symfony/console) with the [Laminas Framework](https://github.com/laminas).

## Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/laminas-symfony-console ^0.1
    
In order integrate with Laminas MVC, please add the module namespace to the `modules.config.php` of your Laminas application.
    
    // moudle.config.php
    return [    
        // .... other module namespaces
        
        'Arp\\LaminasConsole',
    ];
