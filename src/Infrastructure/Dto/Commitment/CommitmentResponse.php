<?php

declare(strict_types=1);

namespace App\Infrastructure\Dto\Commitment;

use App\Domain\Commitment\Entity\Commitment;
use App\Infrastructure\Dto\Order\OrderResponse;
use DateTimeImmutable;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class CommitmentResponse
{
    /** @SWG\Property(type="string") */
    public string $id;

    /** @SWG\Property(ref=@Model(type=OrderResponse::class)) */
    public OrderResponse $order;

    /** @SWG\Property(type="integer") */
    public int $quantity;

    /** @SWG\Property(type="string", example="Y-m-d\TH:i:sP") */
    public string $createdDate;

    public static function createFromCommitment(Commitment $commitment): self
    {
        $self = new self();

        $self->id = $commitment->getId();
        $self->order = OrderResponse::createFromOrder($commitment->getOrder());
        $self->quantity = $commitment->getQuantity();
        $self->createdDate = $commitment->getCreatedDate()->format(DateTimeImmutable::ATOM);

        return $self;
    }
}
