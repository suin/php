<?php

declare(strict_types=1);

namespace SymplifyCsFixer\Container;

use PhpCsFixer\Fixer\DefinedFixerInterface;
use Psr\Container\ContainerInterface;
use Symplify\EasyCodingStandard\DependencyInjection\ContainerFactory;
use Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel;
use Symplify\PackageBuilder\Console\Input\InputDetector;

/**
 * @param string[] $configs
 */
function computeConfigHash(array $configs): string
{
    $hash = '';
    foreach ($configs as $config) {
        $hash .= md5_file($config);
    }

    return $hash;
}

final class Container
{
    private const CONFIG_FILE = __DIR__ . '/../../config/services.yml';

    /**
     * @var ContainerInterface
     */
    private $container;

    private function __construct()
    {

        $configs = [self::CONFIG_FILE];


        $environment = 'prod' . computeConfigHash($configs) . random_int(1, 100000);
        $easyCodingStandardKernel = new EasyCodingStandardKernel($environment, InputDetector::isDebug());


        $easyCodingStandardKernel->setConfigs($configs);
        $easyCodingStandardKernel->boot();
//        $containerFactory = new ContainerFactory();
//        $this->container = $containerFactory->createWithConfigs(
//            [self::CONFIG_FILE]
//        );
        $this->container = $easyCodingStandardKernel->getContainer();
    }

    public static function get(string $fixerClass): DefinedFixerInterface
    {
        return self::getInstance()->getFixer($fixerClass);
    }

    private static function getInstance(): self
    {
        static $instance;
        return $instance ?? $instance = new self();
    }

    private function getFixer(string $fixerClass): DefinedFixerInterface
    {
        return $this->container->get($fixerClass);
    }
}
