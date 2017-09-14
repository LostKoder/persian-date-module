<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/13/17
 * Time: 2:11 AM
 */

namespace Drupal\persian_date;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\persian_date\DependencyInjection\Pass\PersianDatePass;

class PersianDateServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PersianDatePass());
    }

}