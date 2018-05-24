## Seja um apoiador do octobercms
[![patreon](https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSl-jfhjJPyaukslkx14sAUv7rJQHo4n26AXBuc4sjGMK6A-DWF)](https://www.patreon.com/bePatron?c=1683878&rid=2525719)

[![comunidade slack](https://octobercms.slack.com/messages/C382VS00Y)

# oc-pagseguro
component octobercms for pagseguro

## Dependencias 

Rainlab User plugin

## Install

```

git clone https://github.com/devalexandre/oc-pagseguro.git plugins/indev/pagseguro

php artisan october:up

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
esse formulario adciona itens em nosso plugin para assim poder fazer o checkou
``` html 
 <form data-request="Pagseguro::onAdd" data-request-redirect="/checkout">
                                        
                        <input class="form-control" type="hidden" name="item[id]" value="1" >
                        <input class="form-control" type="hidden" name="item[name]" value="ebook octobercms">


                                  <div class="form-group"><label>Valor</label><input class="form-control" type="text" name="item[price]" min="1000" max="10000" required placeholder="minimo 1000.00"></div>
                            <button class="btn btn-primary btn-sm ml-2" type="submit">investir</button></div>
                            <div class="card-footer"><button class="btn btn-danger mtl-4" type="button"><i class="fa fa-file-pdf-o"></i>&nbsp;<strong>Informações</strong></button></div>
                        </form>
```

apos ter os itens em seu "carrinho" basta gerar a url de checkout

/checkout
``` html

    <a href="#"
    data-request='Pagseguro::onCheckout'
    data-request-success='console.log(data.result)'
    >checkout</a>
    </br>
    </br>
    <a href="#"
    data-request='Pagseguro::onClear'
    data-request-success='console.log(data)'
    >onClear</a>

```