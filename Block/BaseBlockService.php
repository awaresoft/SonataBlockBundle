<?php

namespace Awaresoft\Sonata\BlockBundle\Block;

use Sonata\BlockBundle\Block\BaseBlockService as SonataBaseBlockService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * BaseBlockService extension
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
abstract class BaseBlockService extends SonataBaseBlockService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }
}
