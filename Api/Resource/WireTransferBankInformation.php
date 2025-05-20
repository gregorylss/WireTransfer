<?php

namespace WireTransfer\Api\Resource;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Thelia\Api\Bridge\Propel\Filter\SearchFilter;
use Thelia\Api\Resource\Order;
use Thelia\Api\Resource\ResourceAddonInterface;
use Thelia\Api\Resource\ResourceAddonTrait;
use WireTransfer\Api\Provider\WireTransferProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/admin/wire-transfer-bank-information',
            name: 'api_wire_transfer_bank_information_get_collection_admin',
            provider: WireTransferProvider::class,
        ),
        new Get(
            uriTemplate: '/admin/wire-transfer-bank-information/{orderId}',
            name: 'api_wire_transfer_bank_information_get_item_admin',
            provider: WireTransferProvider::class,
        )
    ],
    normalizationContext: ['groups' => [self::GROUP_READ_ADMIN]]
)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/front/wire-transfer-bank-information',
            name: 'api_wire_transfer_bank_information_get_collection_front',
            provider: WireTransferProvider::class,
        ),
        new Get(
            uriTemplate: '/front/wire-transfer-bank-information/{orderId}',
            name: 'api_wire_transfer_bank_information_get_item_front',
            provider: WireTransferProvider::class,
        )
    ],
    normalizationContext: ['groups' => [self::GROUP_FRONT_READ]]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'orderId' => 'exact',
    ]
)]
class WireTransferBankInformation implements ResourceAddonInterface
{
    use ResourceAddonTrait;

    public const GROUP_READ_ADMIN = 'wire_transfer:admin:read';
    public const GROUP_FRONT_READ = 'wire_transfer:front:read';

    #[Groups([Order::GROUP_ADMIN_READ, Order::GROUP_ADMIN_WRITE, Order::GROUP_FRONT_READ, Order::GROUP_FRONT_READ_SINGLE])]
    public ?int $orderId = null;

    #[Groups([self::GROUP_READ_ADMIN, self::GROUP_FRONT_READ])]
    private ?string $bic = null;

    #[Groups([self::GROUP_READ_ADMIN, self::GROUP_FRONT_READ])]
    private ?string $iban = null;

    #[Groups([self::GROUP_READ_ADMIN, self::GROUP_FRONT_READ])]
    private ?string $accountHolderName = null;

    #[Groups([self::GROUP_READ_ADMIN, self::GROUP_FRONT_READ])]
    private ?string $message = null;

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(?string $bic): self
    {
        $this->bic = $bic;
        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): self
    {
        $this->iban = $iban;
        return $this;
    }

    public function getAccountHolderName(): ?string
    {
        return $this->accountHolderName;
    }

    public function setAccountHolderName(?string $accountHolderName): self
    {
        $this->accountHolderName = $accountHolderName;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    #[Ignore] public static function getResourceParent(): string
    {
        return Order::class;
    }
}
