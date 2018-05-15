<?php

namespace Indev\Pagseguro\Components;

use Db;
use App;
use Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Environments\Production;
use PHPSC\PagSeguro\Environments\Sandbox;
use PHPSC\PagSeguro\Customer\Customer;
use PHPSC\PagSeguro\Items\Item;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;
use Redirect;
use Session;
use Indev\Pagseguro\Models\Pagseguro as PagseguroModel;
use PHPSC\PagSeguro\Purchases\Transactions\Locator;
use October\Rain\Auth\Manager;
use Auth;
use Config;


class Pagseguro extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'pagseguro',
            'description' => 'integration with pagseguro'
        ];
    }

    public function defineProperties()
    {
        return [


            'urlReturn' => [
                'title'       => 'url of return',
                'description' => 'url of return',
                'placeholder' => 'url of return',
                'default' =>   '/pagseguro/return'

            ],
            'urlNotification' => [
                'title'       => 'url for nodification',
                'description' => 'url for nodification',
                'placeholder' => 'url for nodification',
                'default' =>   '/pagseguro/notification'

            ],
        ];
    }

    protected  function  credentials(){

        $type = config('pagseguro.ptype');
        $email = config('pagseguro.pemail');
        $token = config('pagseguro.ptoken');
     

        if($type === 'sandbox')
        return  new Credentials($email, $token,  new Sandbox());

        if($type === 'production')
        return  new Credentials($email, $token);
    }


    public function onClear(){
        Session::put('items',[]);

    }
    public function onAdd(){
        $item = json_decode(input('item'),true);

if(Session::has('items'))
        $cart = Session::get('items');

      
       

        if (array_key_exists($item['id'], $cart)) {

            $product = $cart[$item['id']];          
            $product->quantity += 1;
           

        }else{
            $product = new \stdClass;
            $product->id =   $item['id']; 
            $product->name = $item['name']; 
            $product->price =$item['price']; 
            $product->quantity = 1;
        }
        $cart[$product->id] =  $product;

        Session::put('items',$cart);

        return json_encode($cart);

    }


    /**
     * param $items Array obj(id,name,price)
     * return Redirect for checkout
     */
    public function onCheckout(){

        try {

            
            $items = Session::get('items');

           $user  = Auth::getUser();
          $reference = md5($user->id.date('d/m/Y'));

            $urlReturn = $this->property('urlReturn');
            $urlNotification = $this->property('urlNotification');

            $service = new CheckoutService($this->credentials()); // cria instância do serviço de pagamentos
            
            $checkout = $service->createCheckoutBuilder();
            $total = 0;
            foreach ($items as $item ) {

                $checkout->addItem(new Item($item->id ,$item->name , $item->price, $item->quantity  ));
                $total += $item->price * $item->quantity;
            }
            $checkout->setReference($reference);

           $checkout =  $checkout->getCheckout();

            
            $response = $service->checkout($checkout);
            
            //Se você quer usar uma url de retorno
            $checkout->setRedirectTo( $urlReturn);
            
            //Se você quer usar uma url de notificação
            $checkout->setNotificationURL( $urlNotification);
       
           $pagseguro  = new  PagseguroModel;
           $pagseguro->user_id = $user->id;
           $pagseguro->transaction_id='';
           $pagseguro->items = Session::get('items');
           $pagseguro->total = $total;
           $pagseguro->reference = $reference;
           $pagseguro->save();

            return Redirect::to($response->getRedirectionUrl());

        } catch (\Exception $error) { // Caso ocorreu algum erro
            return  $error->getMessage(); // Exibe na tela a mensagem de erro
        }
    }

    public function onReturn(){
        $transaction = input('transaction');

        try {
            $service = new Locator($this->credentials()); // Cria instância do serviço de localização de transações
            
            $transaction = $service->getByCode($transaction );
        
            $data = $transaction->getDetails();
           
            $pagseguro  =  PagseguroModel::where('reference','=', $data->getReference())
            ->update([ 
            'transaction_id'=>$data->getCode(),
            'status' => $this->getStatus($data->getStatus()),
        ]);

        return Redirect::to('/');
            
        } catch (\Exception $error) { // Caso ocorreu algum erro
            echo $error->getMessage(); // Exibe na tela a mensagem de erro
        }
    }

        protected function getStatus($code){

            switch($code){
                case '1':
                return 'Aguardando pagamento';
                case '2':
                return 'Em análise';
                case '3':
                return 'Paga';
                case '4':
                return 'Disponível';
                case '5':
                return 'Em disputa';
                case '6':
                return 'Devolvida';
                case '7':
                return 'Cancelada';

            }
        }

    
}