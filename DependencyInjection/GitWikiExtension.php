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

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Loads wiki configuration.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class GitWikiExtension extends Extension
{

    public function load(array $config, ContainerBuilder $configuration)
    {
        $loader = new XmlFileLoader($configuration, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('wiki.xml');
        $loader->load('git.xml');
        $loader->load('views.xml');
        $loader->load('form.xml');

        // Views
        if (!empty($config['views'])) {
            foreach ($config['views'] as $key => $value) {
                $container->setParameter('git_wiki.views.'.$key, $value);
            }
        }

        foreach($config as $env_config) {
            $this->loadConfig($env_config, $configuration);
            $this->loadFilter($env_config, $configuration);
        }
    }

    protected function loadConfig(array $config, ContainerBuilder $configuration)
    {
        // Git Repository
        if (!empty($config['dir'])) {
            $configuration->setParameter('git_wiki.repository.dir', $config['dir']);
        }
        if (!empty($config['debug'])) {
            $configuration->setParameter('git_wiki.repository.debug', $config['debug']);
        }
        if (!empty($config['executable'])) {
            $configuration->setParameter('git_wiki.repository.executable', $config['executable']);
        }
        if (!empty($config['index'])) {
            $configuration->setParameter('git_wiki.page.index', $config['index']);
        }
    }

    public function loadFilter($config, ContainerBuilder $configuration)
    {
        if(empty($config['filter'])) return;

        $loader = new XmlFileLoader($configuration, new FileLocator(__DIR__.'/../Resources/config/filter'));

        foreach($config['filter'] as $name => $options) {
            if(!$configuration->hasDefinition('git_wiki.filter.'.$name)) {
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
        return 'https://www.symfony-project.org/shemas/dic/symfony/git_wiki';
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
