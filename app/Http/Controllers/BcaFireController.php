<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
include(app_path() . '/Libraries/bca-finhacks-2017.phar');

class BcaFireController extends Controller
{
    private $config;

    public function initConfig() {
        $builder = new \Bca\Api\Sdk\Fire\FireApiConfigBuilder();
        $builder->baseApiUri('https://api.finhacks.id/');
        $builder->baseOAuth2Uri('https://api.finhacks.id/');
        $builder->clientId('af4f556c-69e7-4d50-af4c-a0dad53cf60b');
        $builder->clientSecret('7616f8e9-4e10-4747-9fe8-d1d28bd67f37');
        $builder->apiKey('dac28d4b-b964-4262-890d-52721ea2d07e');
        $builder->apiSecret('3e35958f-6ab2-477a-9c3b-8d8275d972c8');
        $builder->origin('127.0.0.1');
        $builder->corporateID('FHK4AE');
        $builder->accessCode('gCR8CnjPv6n4UWrP9Gmg');
        $builder->branchCode('FHK4AE01');
        $builder->userID('FHK4OPRB');
        $builder->localID('0405');

        $this->config = $builder->build();
    }

    public function doTeleTransfer(Request $request) {

        $this->initConfig();
        $fireApi = new \Bca\Api\Sdk\Fire\FireApi($this->config);

        $senderDetails = new \Bca\Api\Sdk\Fire\Models\Requests\TransferSenderDetailsPayload();
        $senderDetails->setFirstName('John');
        $senderDetails->setLastName('Doe');
        // $senderDetails->setDateOfBirth('2000-05-20');
        $senderDetails->setAddress1('HILLS STREET 1');
        $senderDetails->setAddress2('');
        $senderDetails->setCity('HOLLYWOOD');
        $senderDetails->setStateID('');
        $senderDetails->setPostalCode('');
        $senderDetails->setCountryID('US');
        $senderDetails->setMobile('');
        $senderDetails->setIdentificationType('');
        $senderDetails->setIdentificationNumber('');
        $senderDetails->setAccountNumber('8220002331');

        $beneficiaryDetails = new \Bca\Api\Sdk\Fire\Models\Requests\TransferBeneficiaryDetailsPayload();
        $beneficiaryDetails->setName('Sam');
        // $beneficiaryDetails->setDateOfBirth('2000-05-20');
        $beneficiaryDetails->setAddress1('HILLS STREET 1');
        $beneficiaryDetails->setAddress2('');
        $beneficiaryDetails->setCity('HOLLYWOOD');
        $beneficiaryDetails->setStateID('');
        $beneficiaryDetails->setPostalCode('');
        $beneficiaryDetails->setCountryID('ID');
        $beneficiaryDetails->setMobile('');
        $beneficiaryDetails->setIdentificationType('');
        $beneficiaryDetails->setIdentificationNumber('');
        $beneficiaryDetails->setNationalityID('');
        $beneficiaryDetails->setOccupation('');
        $beneficiaryDetails->setBankCodeType('BIC');
        $beneficiaryDetails->setBankCodeValue('CENAIDJAXXX');
        $beneficiaryDetails->setBankCountryID('ID');
        $beneficiaryDetails->setBankAddress('');
        $beneficiaryDetails->setBankCity('');
        $beneficiaryDetails->setAccountNumber('8220000355');

        $transactionDetails = new \Bca\Api\Sdk\Fire\Models\Requests\TransferTransactionDetailsPayload();
        $transactionDetails->setCurrencyID('IDR');
        $transactionDetails->setAmount($request->amount);
        $transactionDetails->setPurposeCode('011');
        $transactionDetails->setDescription1('');
        $transactionDetails->setDescription2('');
        $transactionDetails->setDetailOfCharges('SHA');
        $transactionDetails->setSourceOfFund('');
        $transactionDetails->setFormNumber(substr(md5(microtime()),rand(0,26),10));

        $payload = new \Bca\Api\Sdk\Fire\Models\Requests\TransferToAccountPayload();
        $payload->setSenderDetails($senderDetails);
        $payload->setBeneficiaryDetails($beneficiaryDetails);
        $payload->setTransactionDetails($transactionDetails);

        $response = $fireApi->transferToAccount($payload);

        $data = array();
        $data['statusTransaction'] = $response->getStatusTransaction();
        $data['statusMessage'] = $response->getStatusMessage();
        $transactionDetails = $response->getTransactionDetails();
        $data['transferAmount'] = $transactionDetails->getAmount();
        $data['referenceNumber'] = $transactionDetails->getReferenceNumber();
        $data['releaseDateTime'] = $transactionDetails->getReleaseDateTime();

        return response()->json($data);

    }
}
