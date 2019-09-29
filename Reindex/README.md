# Magento2 reindex Pro

[![Latest Stable Version](https://poser.pugx.org/jundat95/magento-reindex/v/stable.svg)](https://packagist.org/packages/jundat95/magento-reindex)
[![Total Downloads](https://poser.pugx.org/jundat95/magento-reindex/downloads)](https://packagist.org/packages/jundat95/magento-reindex)
[![Latest Unstable Version](https://poser.pugx.org/jundat95/magento-reindex/v/unstable.svg)](https://packagist.org/packages/jundat95/magento-reindex)
[![License](https://poser.pugx.org/jundat95/magento-reindex/license.svg)](https://packagist.org/packages/jundat95/magento-reindex)

## Install

* Copy all code to folder: /app/code/Jundat/Reindex

Run command line in project:

```php

    php bin/magento setup:upgrade
    php bin/magento c:c
    php bin/magento c:f

```

## Use

* Go to the admin page

* Go to Stores -> Settings -> Configuration -> Jundat -> Reindex

* Select Reindex: Asynchronous / Synchronous -> save

* Go to System -> Tools -> Index Management

* Choose Action Reindex and select indexer if you want to reindex this


## Set ACL for new user, roles

* System -> Permissions -> User Roles -> Role Resources

* Select Jundat -> Reindex