#!/bin/bash

php bin/console.php licitacao:captura
php bin/console.php licitacao:processa
php bin/console.php licitacao:sincroniza