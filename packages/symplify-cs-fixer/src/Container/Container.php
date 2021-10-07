<?php

declare(strict_types=1);

namespace SymplifyCsFixer\Container;

use PhpCsFixer\Fixer\DefinedFixerInterface;
use Psr\Container\ContainerInterface;
use Symplify\EasyCodingStandard\DependencyInjection\ContainerFactory;
use Symplify\EasyCodingStandard\DependencyInjection\EasyCodingStandardContainerFactory;
use PhpCsFixer\Fixer\FixerInterface;
use ECSPrefix20211002\Symfony\Component\Console\Input\Input;
use ECSPrefix20211002\Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Container
{
    private const CONFIG_FILE = __DIR__ . '/../../config/services.yml';

    /**
     * @var ContainerInterface
     */
    private $container;

    private function __construct()
    {
        $this->container = new ContainerBuilder();
        $loader= new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yml');
        $this->container->compile();
    }

    public static function get(string $fixerClass): FixerInterface
    {
        return self::getInstance()->getFixer($fixerClass);
    }

    private static function getInstance(): self
    {
        static $instance;
        return $instance ?? $instance = new self();
    }

    private function getFixer(string $fixerClass): FixerInterface
    {
        return $this->container->get($fixerClass);
    }
}
