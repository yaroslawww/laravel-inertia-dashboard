<?php

namespace InertiaDashboardKit\Adapt;

use Illuminate\Http\Request;
use InertiaDashboardKit\Adapt\Resources\InertiaPaginatedResource;

class IndexData
{
    protected ?string $useResource = null;
    protected array $mapOptions    = [];
    protected array $bulkActions   = [];
    protected ?int $perPage        = null;
    protected ?array $links        = null;
    protected ?array $columns      = [];

    protected bool $withoutFiltration = false;

    public function __construct(
        protected Request $request,
        protected string  $entityType,
        protected         $query,
        protected array   $options = []
    ) {
    }

    public static function make(...$args)
    {
        return new static(...$args);
    }

    public function toResponseArray(): array
    {
        return [
            'entityType' => $this->entityType,
            'entities'   => (new InertiaPaginatedResource(
                $this->preparedQuery()
                     ->paginate($this->perPage, page: ($this->withoutFiltration ? 1 : null))
                     ->appends($this->withoutFiltration ? [] : $this->request->all()),
                $this->useResource,
                $this->mapOptions,
            ))->toArray($this->request),
            'bulkActions' => collect($this->bulkActions)
                ->filter(fn ($action) => $action->allowedForRequest($this->request))
                ->mapWithKeys(fn ($action) => [$action::name() => $action->toArray()])
                ->toArray(),
            'links'      => $this->links,
            'columns'    => array_map(fn ($column) => $column->toArray(), $this->columns),
            'filtration' => http_build_query($this->withoutFiltration ? [] : $this->request->all()),
        ];
    }

    public function useResource(?string $class = null, array $mapOptions = []): static
    {
        $this->useResource = $class;
        $this->mapOptions  = $mapOptions;

        return $this;
    }

    public function bulkActions(array $bulkActions): static
    {
        $this->bulkActions = $bulkActions;

        return $this;
    }

    public function perPage(?int $perPage = null): static
    {
        $this->perPage = $perPage;

        return $this;
    }

    protected function preparedQuery()
    {
        if ($this->withoutFiltration) {
            return $this->query;
        }

        if (
            ($search = $this->request->input('search'))
            && $this->query->hasNamedScope('searchByText')
        ) {
            $this->query->searchByText($search, $this->options['search_tag'] ?? null);
        }

        if (
            ($order = (string) $this->request->input('order'))
            && ($orderDirection = (string) $this->request->input('order-direction'))
            && $this->query->hasNamedScope('orderIndex')
        ) {
            $this->query->orderIndex($order, $orderDirection);
        }

        return $this->query;
    }

    public function links(?array $links = null): static
    {
        $this->links = $links;

        return $this;
    }

    public function columns(array $columns = []): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function withoutFiltration(bool $withoutFiltration = true): static
    {
        $this->withoutFiltration = $withoutFiltration;

        return $this;
    }
}
