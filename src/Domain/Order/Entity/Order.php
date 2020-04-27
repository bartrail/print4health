<?php

declare(strict_types=1);

namespace App\Domain\Order\Entity;

use App\Domain\Commitment\Entity\Commitment;
use App\Domain\DateHelper;
use App\Domain\Thing\Entity\Thing;
use App\Domain\User\Entity\Requester;
use App\Domain\User\UserInterface;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Order\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\User\Entity\Requester", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private Requester $requester;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Thing\Entity\Thing", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private Thing $thing;

    /**
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * @var Collection<int, Commitment>
     * @ORM\OneToMany(targetEntity="App\Domain\Commitment\Entity\Commitment", mappedBy="order")
     */
    private $commitments;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdDate;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $updatedDate;

    public function __construct(Requester $requester, Thing $thing, int $quantity)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->commitments = new ArrayCollection();
        $this->requester = $requester;
        $this->thing = $thing;
        $this->quantity = $quantity;
        $this->createdDate = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRequester(): Requester
    {
        return $this->requester;
    }

    public function setRequester(Requester $requester): self
    {
        $this->requester = $requester;

        return $this;
    }

    public function getThing(): Thing
    {
        return $this->thing;
    }

    public function setThing(Thing $thing): self
    {
        $this->thing = $thing;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function addQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    /**
     * @return Commitment[]
     */
    public function getCommitments(): array
    {
        return $this->commitments->toArray();
    }

    public function getRemaining(): int
    {
        $commitmentCounts = 0;
        foreach ($this->getCommitments() as $commitment) {
            $commitmentCounts += $commitment->getQuantity();
        }

        return $this->quantity - $commitmentCounts;
    }

    public function updateUpdatedDate(): void
    {
        $this->updatedDate = DateHelper::create();
    }

    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function getUpdatedDate(): ?DateTimeImmutable
    {
        return $this->updatedDate;
    }

    public function hasCommitmentByUser(UserInterface $user): bool
    {
        foreach ($this->getCommitments() as $commitment) {
            if ($commitment->getMaker()->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }

    public function isOrderByUser(UserInterface $user): bool
    {
        return $this->getRequester()->getId() === $user->getId();
    }
}
