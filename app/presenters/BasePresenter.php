<?php

use Nette\Diagnostics\Debugger;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    public function injectEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        if ($this->em)
        {
            throw new \Nette\InvalidStateException('Entity manager has already been set');
        }

        /** @var $em \Doctrine\ORM\EntityManager */
        $platform = $em->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        $this->em = $em;
        return $this;
    }

    public function injectSerializer(JMS\Serializer\SerializerBuilder $sbldr)
    {
        if ($this->serializer)
        {
            throw new \Nette\InvalidStateException('Serializer manager has already been set');
        }
        $this->serializer = $sbldr::create()->build();
        return $this;
    }

    // Registrace vlastních latte maker
    public function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);
        $template->registerHelperLoader(callback(
                        $this->context->myTemplateHelpers, 'loader'
                ));
        return $template;
    }

    public function createComponentCss()
    {
        // připravíme seznam souborů
        // FileCollection v konstruktoru může dostat výchozí adresář, pak není potřeba psát absolutní cesty
        $files = new \WebLoader\FileCollection(WWW_DIR . '/css');

        // kompilátoru seznam předáme a určíme adresář, kam má kompilovat
        $compiler = \WebLoader\Compiler::createCssCompiler($files, WWW_DIR . '/webtemp');

        // nette komponenta pro výpis <link>ů přijímá kompilátor a cestu k adresáři na webu
        return new \WebLoader\Nette\CssLoader($compiler, $this->template->basePath . '/webtemp');
    }

    public function createComponentJs()
    {
        $files = new \WebLoader\FileCollection(WWW_DIR . '/js');
        $loadedData = iterator_to_array(Nette\Utils\Finder::findFiles('*.js')
                        ->exclude("angular*")
                        ->from(WWW_DIR . '/js'));

        ksort($loadedData);
        $files->addFiles($loadedData);

        $compiler = \WebLoader\Compiler::createJsCompiler($files, WWW_DIR . '/webtemp');


        // při development módu vypne spojování souborů
        $dev = $this->context->parameters['productionMode'];
        $compiler->setJoinFiles($dev);

        return new \WebLoader\Nette\JavaScriptLoader($compiler, $this->template->basePath . '/webtemp');
    }

}
