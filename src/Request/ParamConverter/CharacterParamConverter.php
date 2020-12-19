<?php

namespace App\Request\ParamConverter;

use App\Entity\Character;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CharacterParamConverter implements ParamConverterInterface
{

    private $registry;

    /**
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry = null)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     *
     * Check, if object supported by our converter
     */
    public function supports(ParamConverter $configuration)
    {
        return Character::class == $configuration->getClass();
    }

    /**
     * {@inheritdoc}
     *
     * Applies converting
     *
     * @throws \InvalidArgumentException When route attributes are missing
     * @throws NotFoundHttpException     When object not found
     * @throws Exception
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $params = $request->attributes->get('_route_params');

//        if (isset($params['characterId']) && ($characterId = $request->attributes->get('characterId')))

        $characterId = $request->attributes->get('characterId');
        if ($characterId === 'undefined') {
            throw new Exception("Invalid characterId " . $characterId);
        }

        // Check, if route attributes exists
        if (null === $characterId ) {
            if (!isset($params['characterId'])) {
                return false; // no characterId in the route, so leave.  Could throw an exception.
            }
        }

        // Get actual entity manager for class.  We can also pass it in, but that won't work for the doctrine tree extension.
        $em = $this->registry->getManagerForClass($configuration->getClass());
        $repository = $em->getRepository($configuration->getClass());

        // Try to find character by its Id
        $character = $repository->findOneBy(['id' => $characterId]);

        if (null === $character || !($character instanceof Character)) {
            throw new NotFoundHttpException(sprintf('%s %s object not found.', $characterId, $configuration->getClass()));
        }

        // Map found character to the route's parameter
        $request->attributes->set($configuration->getName(), $character);

        return true;
    }

}
