<?php

namespace WireTransfer\Api\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use WireTransfer\Service\WireTransferBankInformationService;

class WireTransferProvider implements ProviderInterface
{
    private WireTransferBankInformationService $bankInfoService;

    public function __construct(WireTransferBankInformationService $bankInfoService)
    {
        $this->bankInfoService = $bankInfoService;
    }

    /**
     * Fournit les infos bancaires pour une commande donnée, ou l’ensemble des infos si aucune commande spécifiée
     *
     * @param Operation $operation
     * @param array     $uriVariables ['orderId' => string|null]
     * @param array     $context
     *
     * @return object|array|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $orderId = $uriVariables['orderId'] ?? null;
        if (null === $orderId) {
            return $this->bankInfoService->getAllBankInformation();
        }

        $info = $this->bankInfoService->getBankInformation($orderId);

        if (!empty($info)) {
            return (object) $info;
        }

        return $this->bankInfoService->getAllBankInformation();
    }

}
