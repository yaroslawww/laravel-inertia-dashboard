<?php

namespace InertiaDashboardKit\Adapt\Columns;

abstract class Column
{
    protected string $component = '';

    protected bool $sortable = false;

    protected ?string $title = null;

    protected string $field;

    public function __construct(?string $title = null)
    {
        $this->title = $title ?? $this->title;
        if (is_null($this->title)) {
            $this->title = __(class_basename(static::class));
        }
        if (!$this->component) {
            $this->component = 'IndexColumn'.class_basename(static::class);
        }
    }

    public function setFieldsKeys(...$args): static
    {
        $this->field = $args[0] ?? '';

        return $this;
    }

    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'component' => $this->component,
            'sortable'  => $this->sortable,
            'title'     => $this->title,
            'field'     => $this->field,
        ];
    }
}
