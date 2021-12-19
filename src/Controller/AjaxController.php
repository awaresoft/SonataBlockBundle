<?php

namespace Awaresoft\Sonata\BlockBundle\Controller;

use Awaresoft\Sonata\PageBundle\Entity\Block;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AjaxController
 *
 * @Route("ajax/block")
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
class AjaxController extends Controller
{
    /**
     * @Route("/render/{id}", options={"expose"=true})
     *
     * @param Request $request
     * @param Block $block
     *
     * @return JsonResponse
     */
    public function renderAction(Request $request, Block $block)
    {
        $translate = $this->get('translator');

        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse([
                'type' => 'error',
                'message' => $translate->trans('bad_request'),
            ], Response::HTTP_BAD_REQUEST);
        }

        /**
         * @var BlockServiceInterface $blockService
         */
        $blockService = $this->get($block->getType());
        $blockContextManager = $this->get('sonata.block.context_manager.default');
        $blockContext = $blockContextManager->get($block);
        $response = $blockService->execute($blockContext);

        return new JsonResponse([
            'type' => 'success',
            'html' => $response->getContent(),
        ]);
    }
}
