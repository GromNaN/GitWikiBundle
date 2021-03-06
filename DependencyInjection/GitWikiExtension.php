<?php

namespace Bundle\GitWikiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class GitWikiExtension extends Extension
{

    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('wiki.xml');
        $loader->load('git.xml');
        $loader->load('views.xml');

        $config = $config[0];

        // Git Repository
        if (!empty($config['dir'])) {
            $container->setParameter('gitwiki.repository.dir', $config['dir']);
        }
        if (!empty($config['debug'])) {
            $container->setParameter('gitwiki.repository.debug', $config['debug']);
        }
        if (!empty($config['executable'])) {
            $container->setParameter('gitwiki.repository.executable', $config['executable']);
        }

        // Views
        if (!empty($config['views'])) {
            foreach ($config['views'] as $key => $value) {
                $container->setParameter('gitwiki.views.'.$key, $value);
            }
        }
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://www.symfony-project.org/shemas/dic/symfony/gitwiki';
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
