<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/13/17
 * Time: 2:13 AM
 */

namespace Drupal\persian_date\DependencyInjection\Pass;


use Drupal\persian_date\Formatter\PersianDateFormatter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PersianDatePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('date.formatter');
        $definition->setClass(PersianDateFormatter::class);
    }

}