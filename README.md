# Matomo UpdateExposedFqdnList Plugin

## Description

This plugin upates the redis cache when a FQDN is added or updated in Matomo

## Installation

Refer to [this Matomo FAQ](https://matomo.org/faq/plugins/faq_21/).

## Usage

Add the following section to your `config.ini.php`:

```ini
[UpdateExposedFqdnList]
redis_ip = '127.20.0.0'
redis_port = 6379
db_index = 0

```

**Make sure you have direct access to the `config.ini.php` file before using this plugin**

