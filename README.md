# oc-pagseguro
component octobercms for pagseguro

## Dependencias 

Rainlab User plugin

## Install

```
cd plugins
mkdir indev
cd indev 
git clone https://github.com/devalexandre/oc-pagseguro.git

```

apos clonar o repositorio crie o arquivo pagseguro.php em seu config

``` php
<?php

return [
  'pemail' => '',
  'ptoken' => '',
  'ptype' => 'sandbox' //   sandbox ou production
];

```
