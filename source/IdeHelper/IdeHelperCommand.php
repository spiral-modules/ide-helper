<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper;

use Interop\Container\ContainerInterface;
use Spiral\Console\Command;
use Spiral\Core\FactoryInterface;
use Spiral\IdeHelper\Locators\LocatorInterface;
use Spiral\IdeHelper\Writers\WriterInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class IdeHelperCommand
 *
 * @package Spiral\IdeHelper
 */
class IdeHelperCommand extends Command
{
    const NAME        = 'spiral:ide-helper';
    const DESCRIPTION = 'Generate IDE help classes';

    const OPTIONS = [
        [
            'writers',
            'w',
            InputOption::VALUE_OPTIONAL,
            'Comma-separated writers to use',
            null
        ],
        [
            'locators',
            'l',
            InputOption::VALUE_OPTIONAL,
            'Comma-separated locators to use',
            null
        ],
    ];

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * IdeHelperCommand constructor.
     *
     * @param ContainerInterface $container
     * @param FactoryInterface   $factory
     */
    public function __construct(ContainerInterface $container, FactoryInterface $factory)
    {
        parent::__construct($container);

        $this->factory = $factory;
    }

    /**
     * @param IdeHelperConfig $config
     */
    public function perform(IdeHelperConfig $config)
    {
        $writers = $this->makeWriters($config->getWriters());
        $locators = $this->makeLocators($config->getLocators());

        if (null === $this->option('writers') && null === $this->option('locators')) {
            $scopes = $config->getScopes();
        } elseif (null !== $this->option('writers') && null !== $this->option('locators')) {
            $scopes = [
                'runtime' => [
                    'writers'  => explode(',', $this->option('writers')),
                    'locators' => explode(',', $this->option('locators')),
                ],
            ];
        } else {
            $this->writeln('<error>Both writers and locators options are required</error>');

            return;
        }

        $this->processScopes($scopes, $writers, $locators);
    }

    /**
     * @param array $scopes
     * @param array $writers
     * @param array $locators
     */
    private function processScopes(array $scopes, array $writers, array $locators)
    {
        foreach ($scopes as $scopeName => $scopeParams) {
            $this->writeln("<info>Processing scope '<comment>$scopeName</comment>':</info>");

            /** @var WriterInterface[] $scopeWriters */
            $scopeWriters = \array_intersect_key($writers, array_flip($scopeParams['writers']));

            /** @var LocatorInterface[] $scopeLocators */
            $scopeLocators = \array_intersect_key($locators, array_flip($scopeParams['locators']));

            $classes = [];
            foreach ($scopeLocators as $name => $locator) {
                $located = $locator->locate();
                $classes = array_merge($classes, $located);

                $countLocated = count($located);
                $this->writeln("<fg=cyan>Locating '<comment>$name</comment>', found "
                    . "<info>$countLocated</info> classes.</fg=cyan>");
            }

            foreach ($scopeWriters as $name => $writer) {
                $this->writeln(
                    "<fg=cyan>Generating docs using writer '<comment>$name</comment>'.</fg=cyan>"
                );
                $writer->write($classes);
            }

            $this->writeln("");
        }
    }

    /**
     * @param array $config
     *
     * @return WriterInterface[]
     */
    private function makeWriters(array $config): array
    {
        $writers = [];

        foreach ($config as $name => $binding) {
            $writers[$name] = $binding->resolve($this->factory);
        }

        return $writers;
    }

    /**
     * @param array $config
     *
     * @return LocatorInterface[]
     */
    private function makeLocators(array $config): array
    {
        $locators = [];

        foreach ($config as $name => $binding) {
            if (is_string($binding)) {
                $target = $this->factory->make($binding);
            } else {
                $target = $binding->resolve($this->factory);
            }

            $locators[$name] = $target;
        }

        return $locators;
    }
}