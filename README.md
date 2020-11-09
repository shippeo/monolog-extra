# monolog-extra
An extension to Monolog that adds handlers, formatters and processors. Includes integrations for Symfony.

## Cookbook symfony

### Processor

#### ApplicationName

Declaration of service `config/services.yaml` with tag `monolog.processor`

```
    Shippeo\Monolog\Processor\ApplicationNameProcessor:
        arguments:
            - '%env(APP_NAME)%'
        tags:
            - { name: 'monolog.processor' }
```

### Formatter

#### Gelf

Declaration of handler in `config/monolog.yaml`

```
monolog:
    handlers:
        graylog:
            type:   gelf
            level:  info
            publisher: {hostname: '%env(GRAYLOG_HOST)%', port: '%env(GRAYLOG_PORT)%', chunk_size: 0}
            formatter: App\Log\GelfMessageFormatter

```

Declaration of service in `config/services.yaml`

```
    Shippeo\Monolog\Formatter:
        - '%env(GRAYLOG_TOKEN)%'
```