# FORSETI CARGA - ELIC-SC

Projeto de Carga no [portal Elic-SC](https://e-lic.sc.gov.br)


## Instalação
### Instalar dependencias do composer (informar credenciais do Satis)

### Instalar os requerimentos das bibliotecas


### Instalar as bibliotecas

```
composer install
```


### Exemplo de uso

**Captura:**

   - Captura todas as licitações do portal:
```
php bin/console.php licitacao:licitacoes 
```   

   - Captura licitação específica com base no código da licitação:
```
php bin/console.php licitacao:licitacoes 3143
```   

   - Captura outros dados das licitações que já estão no banco:
```
php bin/console.php licitacao:detalhe
php bin/console.php licitacao:itens
php bin/console.php licitacao:anexos
php bin/console.php licitacao:download
```   
   - Captura dado de licitação específica que necessita estar previamente no banco:
```
php bin/console.php licitacao:detalhe 3143
php bin/console.php licitacao:itens 3143
php bin/console.php licitacao:anexos 3143
php bin/console.php licitacao:download 3143
```   

