<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
include(app_path() . '/Libraries/bca-finhacks-2017.phar');

class BcaBusinessController extends Controller
{
    private $config;

    public function initConfig() {
        $builder = new \Bca\Api\Sdk\BusinessBanking\BusinessBankingApiConfigBuilder();
        $builder->baseApiUri('https://api.finhacks.id/');
        $builder->baseOAuth2Uri('https://api.finhacks.id/');
        $builder->clientId('af4f556c-69e7-4d50-af4c-a0dad53cf60b');
        $builder->clientSecret(' 7616f8e9-4e10-4747-9fe8-d1d28bd67f37');
        $builder->apiKey('dac28d4b-b964-4262-890d-52721ea2d07e');
        $builder->apiSecret('3e35958f-6ab2-477a-9c3b-8d8275d972c8');
        $builder->origin('127.0.0.1');
        $builder->corporateID('finhacks14');

        $this->config = $builder->build();

    }

    public function getBalanceInfo() {

        $this->initConfig();
        $businessBankingApi = new \Bca\Api\Sdk\BusinessBanking\BusinessBankingApi($this->config);
        $response = $businessBankingApi->getBalance(['8220000258', '8220000355']);

        $data = array();
        foreach ($response->getAccountDetailDataSuccess() as $account) {
            $item = array();
            $item['acc_number'] = $account->getAccountNumber();
            $item['currency'] = $account->getCurrency();
            $item['balance'] = $account->getBalance();
            $item['available_balance'] = $account->getAvailableBalance();
            $item['float_amount'] = $account->getFloatAmount();
            $item['hold_amount'] = $account->getHoldAmount();
            $item['plafon'] = $account->getPlafon();
            array_push($data, $item);
        }

        return response()->json($data);

    }
}
