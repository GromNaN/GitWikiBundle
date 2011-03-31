<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * Loads wiki configuration.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class GitWikiExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('wiki.xml');
        $loader->load('git.xml');
        $loader->load('views.xml');
        $loader->load('form.xml');

        // Views
        if (!empty($configs['views'])) {
            foreach ($configs['views'] as $key => $value) {
                $container->setParameter('git_wiki.views.'.$key, $value);
            }
        }

        foreach($configs as $env_configs) {
            $this->loadConfig($env_configs, $container);
            $this->loadFilter($env_configs, $container);
        }
    }

    protected function loadConfig(array $configs, ContainerBuilder $container)
    {
        // Git Repository
        if (!empty($configs['dir'])) {
            $container->setParameter('git_wiki.repository.dir', $configs['dir']);
        }
        if (!empty($configs['debug'])) {
            $container->setParameter('git_wiki.repository.debug', $configs['debug']);
        }
        if (!empty($configs['executable'])) {
            $container->setParameter('git_wiki.repository.executable', $configs['executable']);
        }
        if (!empty($configs['index'])) {
            $container->setParameter('git_wiki.page.index', $configs['index']);
        }
    }

    public function loadFilter($configs, ContainerBuilder $container)
    {
        if(empty($configs['filter'])) return;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/filter'));

        foreach($configs['filter'] as $name => $options) {
            if(!$container->hasDefinition('git_wiki.filter.'.$name)) {
                $loader->load($name.'.xml');
            }
            // @todo Load options.
        }
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return '';
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'git_wiki';
    }

}
