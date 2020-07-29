<?php

declare(strict_types=1);

namespace Bolt\Redactor;

use Bolt\Extension\ExtensionRegistry;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class RedactorConfig
{
    /** @var ExtensionRegistry */
    private $registry;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var CsrfTokenManagerInterface */
    private $csrfTokenManager;

    public function __construct(ExtensionRegistry $registry, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->registry = $registry;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function getConfig(): array
    {
        $extension = $this->registry->getExtension(Extension::class);

        return array_merge($this->getDefaults(), $extension->getConfig()['default']);
    }

    public function getDefaults()
    {
        return [
            'imageUpload' => $this->urlGenerator->generate('bolt_redactor_upload', ['location' => 'files']),
            'imageUploadParam' => 'file',
            'multipleUpload' => 'false',
            'imageData' => [
                '_csrf_token' => $this->csrfTokenManager->getToken('bolt_redactor')->getValue(),
            ],
            'minHeight' => '200px',
            'maxHeight' => '700px',
            'structure' => true,
            'pasteClean' => true,
            'source' => [
                'codemirror' => [
                    'lineNumbers' => true
                ]
            ],
            'buttonsTextLabeled' => false
        ];
    }
}
