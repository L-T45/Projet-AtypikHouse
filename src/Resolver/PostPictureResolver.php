<?php

namespace App\Resolver;

use ApiPlatform\Core\GraphQl\Resolver\MutationResolverInterface;
use App\Entity\Properties;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostPictureResolver implements MutationResolverInterface
{
   

    public function __invoke($data, array $context): Properties
    {
        $uploadedFile = $context['args']['input']['files'];

        $properties = new Properties();
        $properties->file = $uploadedFile;
        dd($properties);
        return $properties;
    }
}
