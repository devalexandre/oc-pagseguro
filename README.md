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

## How To

``` php 
function onStart(){
 $this['dados'] =   ['id'=>1,'name'=>'indev web teste','price'=>1.00]; 
}
```

``` html

<a href="#"
data-request='Pagseguro::onAdd' 
data-request-data="item: ' {{ dados | json_encode }}'"
data-request-success='console.log(data)'
>Add Item</a>
</br>
<a href="#"
data-request='Pagseguro::onCheckout'
data-request-success='console.log(data.result)'
>checkout</a>
</br>
<a href="#"
data-request='Pagseguro::onClear'
data-request-success='console.log(data)'
>onClear</a>

```
