<?php

namespace InertiaDashboardKit\Adapt\Actions;

class LinkAction extends AbstractAction
{
    public string $url;
    public string $target = '_self';

    public function __construct(?string $url = null)
    {
        $this->url = $url ?? url('/');
    }

    public static function name(): string
    {
        return 'link';
    }

    public function setTarget(string $target): static
    {
        $this->target = $target;

        return $this;
    }



    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type'    => 'link',
                'url'     => $this->url,
                'target'  => $this->target,
            ]
        );
    }
}
