Requirements
============

- Git >= 1.5


Installation
============

Download source and dependencies:

::

    git submodule add git://github.com/GromNaN/GitWikiBundle.git src/Git/WikiBundle
    git submodule add git://github.com/GromNaN/GitCore.git src/Git/Core

Enable the bundle in your application kernel.

::

    # app/AppKernel.php

    public function registerBundles()
    {
        return array(
            # ...
            new Git\WikiBundle\GitWikiBundle(),
            # ...
        );
    }


Add Git lib in the autoload file:

::

    # app/autoload.php - line 21

    $loader->registerNamespaces(array(
        # ...
        'Git' => __DIR__.'/../src',
        # ...
    ));


Configuration
=============

DI parameters
-------------

::

    # app/config/config.yml
    git_wiki:
        dir:        %kernel.root_dir%/wiki
        debug:      false
        executable: /usr/bin/git or "C:\Program Files\Git\git.exe"


Alternativement, for advanced configuration, the available parameters are:

::

    # app/config/config.yml
    git_wiki:
        dir:            %kernel.root_dir%/wiki
        debug:          false
        executable:     /usr/bin/git
        index:          index.rst
        views:
            view:       GitWikiBundle:Default:view.php.html
            edit:       GitWikiBundle:Default:edit.php.html
            history:    GitWikiBundle:Default:history.php.html
        filter:
            raw_text:   ~

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
        resource: @GitWikiBundle/Resources/config/routing.xml
        prefix:   /wiki


Contribute
==========

Project hosting on https://github.com/GromNaN/GitWikiBundle


Feel free to send pull requests !