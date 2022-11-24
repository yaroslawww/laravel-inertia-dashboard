<?php

namespace InertiaDashboardKit\Adapt\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class InertiaPaginatedResource extends ResourceCollection
{
    protected array $mapOptions = [];

    public function __construct($resource, ?string $collects = null, array $mapOptions = [])
    {
        if ($collects) {
            $this->collects = $collects;
        }

        $this->mapOptions = $mapOptions;

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $meta = Arr::except($this->resource->toArray(), [
            'data',
        ]);
        $meta['links'] = array_slice($meta['links'], 1, -1);

        return [
            'data' => $this->collection->map->toArray($request, $this->mapOptions)->all(),
            'meta' => $meta,
        ];
    }
}
