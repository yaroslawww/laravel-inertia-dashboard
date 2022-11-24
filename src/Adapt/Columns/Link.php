<?php

namespace InertiaDashboardKit\Adapt\Columns;

class Link extends Column
{
    protected ?string $fieldText;

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'fieldText'      => $this->fieldText,
        ]);
    }

    public function setFieldsKeys(...$args): static
    {
        parent::setFieldsKeys(...$args);

        $this->fieldText      = $args[1] ?? null;

        return $this;
    }
}
