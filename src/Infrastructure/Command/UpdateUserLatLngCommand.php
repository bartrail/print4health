<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Domain\Exception\User\UserByIdNotFoundException;
use App\Domain\User\Entity\Maker;
use App\Domain\User\Entity\Requester;
use App\Domain\User\Repository\MakerRepository;
use App\Domain\User\Repository\RequesterRepository;
use App\Domain\User\UserInterface;
use App\Domain\User\UserInterfaceRepository;
use App\Infrastructure\Exception\Coordinates\CoordinatesRequestException;
use App\Infrastructure\Services\GeoCoder;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUserLatLngCommand extends Command
{
    private UserInterfaceRepository $userInterfaceRepository;

    private MakerRepository $makerRepository;

    private RequesterRepository $requesterRepository;

    private GeoCoder $geoCoder;

    public function __construct(
        UserInterfaceRepository $userInterfaceRepository,
        MakerRepository $makerRepository,
        RequesterRepository $requesterRepository,
        GeoCoder $geoCoder
    ) {
        parent::__construct();
        $this->userInterfaceRepository = $userInterfaceRepository;
        $this->makerRepository = $makerRepository;
        $this->requesterRepository = $requesterRepository;
        $this->geoCoder = $geoCoder;
    }

    protected function configure()
    {
        $this->setName('app:user:update-latlng');
        $this->setDescription('Uses the geocoding service to update the User\'s LatLng Coordinates');
        $this->addArgument('user-ids', InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
            'Update only those users (separate uuids by space). (optional)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string[] $userIds */
        $userIds = $input->getArgument('user-ids');

        if (count($userIds) > 0) {
            $users = $this->fetchUsersByIds($userIds, $output);
        } else {
            $users = $this->findAllUsers();
        }

        foreach ($users as $user) {
            $this->updateUserGeoCoordinates($user, $output);
        }

        $output->writeln('done.');
        return 0;
    }

    private function updateUserGeoCoordinates(UserInterface $user, OutputInterface $output): void
    {
        if ($user->isEnabled() === false) {
            if ($output->isVerbose()) {
                $output->writeln(sprintf('Skipping User [%s] as he is not enabled', $user->getId()));
            }
            return;
        }
        try {
            if ($user instanceof Maker) {
                $latLng = $this->geoCoder->geoEncodePostalCountry($user->getPostalCode(), $user->getAddressState());
            } elseif ($user instanceof Requester) {
                $latLng = $this->geoCoder->geoEncodeByAddress(
                    $user->getAddressStreet(),
                    $user->getPostalCode(),
                    $user->getAddressCity(),
                    $user->getAddressState()
                );
            } else {
                throw new \RuntimeException(sprintf('User of class [%s] is not supported yet', get_class($user)));
            }
            $user->setLatitude($latLng->getLatitude());
            $user->setLongitude($latLng->getLongitude());

            $this->userInterfaceRepository->save($user);
            $output->writeln(sprintf('Updated User [%s:%s]', $user->getName(), $user->getId()));

        } catch (CoordinatesRequestException $exception) {
            $output->writeln(
                sprintf('<error>Could not get LatLng of User [%s:%s]</error>',
                    $user->getName(),
                    $user->getId()
                )
            );
            if ($output->isVerbose()) {
                $output->writeln($exception->getMessage());
                $output->writeln($exception->getTraceAsString());
            }
            if ($output->isVeryVerbose()) {
                throw $exception;
            }
        }
    }

    /**
     * @param string[] $userIds
     * @return UserInterface[]
     */
    private function fetchUsersByIds(array $userIds, OutputInterface $output): array
    {
        /** @var UserInterface[] $users */
        $users = [];
        foreach ($userIds as $userId) {
            try {
                $uuid = Uuid::fromString($userId);
                $users[] = $this->userInterfaceRepository->find($uuid);
            } catch (UserByIdNotFoundException $exception) {
                $output->writeln(sprintf('<error>User with id [%s] not found</error>', $userId));
            } catch (InvalidUuidStringException $exception) {
                $output->writeln(sprintf('<error>User Id [%s] is invalid Uuid</error>', $userId));
            }
        }

        return $users;
    }

    /**
     * @return UserInterface[]
     */
    private function findAllUsers(): array
    {
        /** @var UserInterface[] $users */
        $users = [];
        $users = array_merge($users, $this->makerRepository->findAll());
        $users = array_merge($users, $this->requesterRepository->findAll());
        return $users;
    }
}
