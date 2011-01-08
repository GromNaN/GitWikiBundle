Requirements
============

- Git >= 1.5


Installation
============

Download source and dependencies:

::

    git submodule add git://github.com/GromNaN/GitWikiBundle.git src/Bundle/GromNaN/GitWikiBundle
    git submodule add git://github.com/GromNaN/php-git-repo.git src/Bundle/GromNaN/php-git-repo

Enable the bundle in your application kernel.

::

    # app/AppKernel.php

    public function registerBundles()
    {
        return array(
            # ...
            new Bundle\GromNaN\GitWikiBundle\GitWikiBundle(),
            # ...
        );
    }


Add Git lib in the autoload file:

::

    # src/autoload.php - line 21

    $loader->registerNamespaces(array(
        # ...
        'Git' => $vendorDir.'/php-git-repo/src',
        # ...
    ));


Configuration
=============

DI parameters
-------------

::

    # app/config/config.yml
    gitwiki.config: ~

Alternativement, for advanced configuration, the available parameters are:

::

    # app/config/config.yml
    gitwiki.config: 
        dir:        %kernel.root_dir%/wiki
        debug:      false
        executable: /usr/bin/git
        views:
            view:       GromNaN\GitWikiBundle:Default:view.php
            edit:       GromNaN\GitWikiBundle:Default:edit.php
            history:    GromNaN\GitWikiBundle:Default:history.php

Git repository
--------------

The dir parameter is a full path to a Git repository. You must __init__ it before using the wiki.

::

    cd app/wiki
    git init

Routing
-------

::

    # app/config/routing.yml
    wiki:
        resource: GromNaN/GitWikiBundle/Resources/config/routing.xml
        prefix:   /wiki


Contribute
==========

Project hosting on https://github.com/GromNaN/GitWikiBundle
Feel free to send pull requests !