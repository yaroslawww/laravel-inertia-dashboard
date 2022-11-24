<?php

namespace InertiaDashboardKit\Adapt\Actions;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class AbstractAction
{
    protected string $label      = '';
    protected ?string $icon      = null;
    protected array $actionProps = [];

    abstract public static function name(): string;

    public function __construct()
    {
        $this->label = __(Str::ucfirst(static::name()));
    }

    public function allowedForRequest(Request $request): bool
    {
        return true;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function setIcon(?string $icon = null): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge([
            'name'      => static::name(),
            'label'     => $this->label,
            'icon'      => $this->icon,
            'component' => $this->component(),
        ], $this->actionProps());
    }

    public function handle(EloquentCollection|Collection $collection, Request $request): array|null
    {
        return null;
    }

    public static function responseSuccess(?string $message = null): array
    {
        return [
            'type'    => 'success',
            'message' => $message ?? __('Action executed'),
        ];
    }

    public static function responseWarning(?string $message = null): array
    {
        return [
            'type'    => 'warning',
            'message' => $message ?? __('Action executed'),
        ];
    }

    public static function responseError(?string $message = null): array
    {
        return [
            'type'    => 'error',
            'message' => $message ?? __('Action executed'),
        ];
    }

    public static function responseDownload(string $url, ?string $name = null): array
    {
        return [
            'type'  => 'download',
            'url'   => $url,
            'name'  => $name ?: Str::afterLast($url, '/'),
        ];
    }

    public static function responseInfo(?string $message = null): array
    {
        return [
            'type'    => 'info',
            'message' => $message ?? __('Action executed'),
        ];
    }

    protected function component(): array
    {
        return [
            'index' => 'IndexAction'.Str::ucfirst(Str::camel(static::name())),
        ];
    }

    protected function actionProps(): array
    {
        return $this->actionProps;
    }
}
