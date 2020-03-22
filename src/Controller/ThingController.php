<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ThingIn;
use App\Dto\ThingOut;
use App\Entity\Thing;
use App\Repository\ThingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class ThingController
{
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;
    private ThingRepository $thingRepository;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        ThingRepository $thingRepository
    ) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->thingRepository = $thingRepository;
    }

    /**
     * @Route(
     *     "/things",
     *     name="thing_list",
     *     methods={"GET"},
     *     format="json"
     * )
     */
    public function listAction(): JsonResponse
    {
        $things = $this->thingRepository->findAll();

        $response = ['things' => []];

        foreach ($things as $thing) {
            $response['things'][] = ThingOut::createFromThing($thing);
        }

        return new JsonResponse($response);
    }

    /**
     * @Route(
     *     "/things",
     *     name="thing_create",
     *     methods={"POST"},
     *     format="json"
     * )
     *
     * @IsGranted("ROLE_USER")
     */
    public function createAction(Request $request): JsonResponse
    {
        try {
            /** @var ThingIn $thingIn */
            $thingIn = $this->serializer->deserialize($request->getContent(), ThingIn::class, JsonEncoder::FORMAT);
        } catch (NotEncodableValueException $notEncodableValueException) {
            throw new BadRequestHttpException('No valid json', $notEncodableValueException);
        }

        $thing = new Thing($thingIn->name, $thingIn->imageUrl, $thingIn->url, $thingIn->description);

        $this->entityManager->persist($thing);
        $this->entityManager->flush();

        $thingOut = ThingOut::createFromThing($thing);

        return new JsonResponse(['thing' => $thingOut], 201);
    }

    /**
     * @Route(
     *     "/things/{uuid}",
     *     name="thing_show",
     *     methods={"GET"},
     *     format="json"
     * )
     */
    public function showAction(string $uuid): JsonResponse
    {
        $thing = $this->thingRepository->find($uuid);

        if (null === $thing) {
            throw new NotFoundHttpException('Thing not found');
        }

        $thingOut = ThingOut::createFromThing($thing);

        return new JsonResponse(['thing' => $thingOut]);
    }
}
