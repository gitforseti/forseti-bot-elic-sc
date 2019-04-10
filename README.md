# FORSETI CARGA - BOLSA DE LICITAÇÕES DO BRASIL - BLL

Projeto de Carga no [portal Bolsa de Licitacoes do Brasil](http://bll.org.br/)


## Instalação
### Instalar dependencias do composer (informar credenciais do Satis)

### Instalar os requerimentos das bibliotecas


### Instalar as bibliotecas

```
composer install
```


### Exemplo de uso

**Captura:**

   - Busca realizada por data, deve seguir o padrão: Y-m-d. Caso não tenha sido passada nenhuma, serão capturadas as licitações do dia.
 
```
php bin/console.php licitacao:captura

```   

- Exemplo com data 

```
php bin/console.php licitacao:captura 2019-02-01 2019-02-14


```   


**Processa:** 

   - Captura detalhes, lotes, itens e anexos
   - Parâmetro -c cancela o download dos anexos para fins de debug
   
```
php bin/console.php licitacao:processa 
php bin/console.php licitacao:processa -c

```   

    
**Sicroniza:**

   - Envia as licitações com status processada no banco de dados para o Mongo
    
   
```
php bin/console.php licitacao:sincroniza 

```   
