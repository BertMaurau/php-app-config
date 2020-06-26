
# PHP App Config
A simple module to handle configuration for your application.

## Installation

### Installation with Composer

    curl -s http://getcomposer.org/installer | php
    php composer.phar require "bertmaurau/php-app-config"

Make sure to block any requests to your configuration file if you are deploying to a public directory.
Add this to your server configuration or your .htaccess file.

    <Files "my-config-file.json">  
      Order Allow,Deny
      Deny from all
    </Files>

For Apache 2.4+, you'd use:

    <Files "my-config-file.json">  
      Require all denied
    </Files>

## Settings configuration

```json
"[setting-key-name]" : {
     "description": "[optional but might be useful for documentation].",
     "type":        "[optional but might be useful for documentation]",
     "value":       "[the setting's value (any type)]"
 },
 ```
            
The 'nodes' have no nesting limit and the value can be accessed via 'node.node. .. .node'. 

```php
// get a nested setting (nodes are case sensitive)
echo AppConfig::setting('server.database.host'); // = localhost
```

Example file `config.json`.
```json
{
    "server": {
        "database": {
            "host" : {
                "description": "The hostname for the database connection.",
                "type": "string",
                "value": "localhost"
            },
            "database" : {
                "description": "The database name.",
                "type": "string",
                "value": "example_database"
            },
            "username" : {
                "description": "The username for the database connection.",
                "type": "string",
                "value": "username"
            },
            "password" : {
                "description": "The password for the database connection.",
                "type": "string",
                "value": "password"
            },
            "port" : {
                "description": "The port for the database connection.",
                "type": "integer",
                "value": 1234
            }
        }
    }
}
