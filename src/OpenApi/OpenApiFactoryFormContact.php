<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\Operation;

class OpenApiFactoryFormContact implements OpenApiFactoryInterface 
{

    public function __construct(private OpenApiFactoryInterface $decorated)
    {
      
    }
    
    public function __invoke(array $context =[]): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        /** @var PathItem $path */
        // chemin pour le formulaire de contact
        $openApi->getPaths()->addPath('/api/form_contact', new PathItem(null, 'Formulaire de contact', null, new Operation('Form-Contact', ['Formulaire de contact'], [], 'Envoi les infos entrées dans le formulaire de contact')));
        return $openApi;
    }
}