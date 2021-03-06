<?php

namespace App\Request\ParamConverter;

use App\Entity\Chapter;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ChapterParamConverter implements ParamConverterInterface
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
        return Chapter::class == $configuration->getClass();
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

//        if (isset($params['chapterId']) && ($chapterId = $request->attributes->get('chapterId')))

        $chapterId = $request->attributes->get('chapterId');
        if ($chapterId === 'undefined') {
            throw new Exception("Invalid chapterId " . $chapterId);
        }

        // Check, if route attributes exists
        if (null === $chapterId ) {
            if (!isset($params['chapterId'])) {
                return false; // no chapterId in the route, so leave.  Could throw an exception.
            }
        }

        // Get actual entity manager for class.  We can also pass it in, but that won't work for the doctrine tree extension.
        $em = $this->registry->getManagerForClass($configuration->getClass());
        $repository = $em->getRepository($configuration->getClass());

        // Try to find chapter by its Id
        $chapter = $repository->findOneBy(['id' => $chapterId]);

        if (null === $chapter || !($chapter instanceof Chapter)) {
            throw new NotFoundHttpException(sprintf('%s %s object not found.', $chapterId, $configuration->getClass()));
        }

        // Map found chapter to the route's parameter
        $request->attributes->set($configuration->getName(), $chapter);

        return true;
    }

}
