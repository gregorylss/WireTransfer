<?php

namespace WireTransfer\Service;

use WireTransfer\WireTransfer;
use Thelia\Model\OrderQuery;

class WireTransferBankInformationService
{
    public function getBankInformation(?int $orderId): array
    {
        $order = OrderQuery::create()->findPk($orderId);

        if ($order !== null && $order->getPaymentModuleId() === WireTransfer::getModuleId()) {
            return [
                'bic' => WireTransfer::getConfigValue('bic'),
                'iban' => WireTransfer::getConfigValue('iban'),
                'account_holder_name' => WireTransfer::getConfigValue('name'),
                'message' => WireTransfer::getConfigValue('message'),
            ];
        }

        return [];
    }
    public function getAllBankInformation(): array
    {
        return [
            'bic' => WireTransfer::getConfigValue('bic'),
            'iban' => WireTransfer::getConfigValue('iban'),
            'account_holder_name' => WireTransfer::getConfigValue('name'),
            'message' => WireTransfer::getConfigValue('message'),
        ];
    }
}
