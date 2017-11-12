<?php

namespace Awaresoft\Sonata\BlockBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * BaseBlockService extension
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
abstract class BaseBlockService extends AbstractBlockService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Extended contructor
     *
     * @param string $name
     * @param EngineInterface $templating
     * @param ContainerInterface $container
     */
    public function __construct($name, EngineInterface $templating, ContainerInterface $container)
    {
        parent::__construct($name, $templating);

        $this->container = $container;
        $this->request = $container->get('request_stack')->getCurrentRequest();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }

    /**
     * Return template which initialize lazy loading
     *
     * @param BlockContextInterface $blockContext
     * @param array $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function lazyLoadBlock(BlockContextInterface $blockContext, array $parameters = null)
    {
        return $this->renderResponse('AwaresoftSonataBlockBundle:Block:lazyload_block.html.twig', [
            'block' => $blockContext->getBlock(),
            'parameters' => json_encode($parameters),
        ]);
    }
}
