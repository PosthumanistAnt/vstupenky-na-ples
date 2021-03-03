@props([
    'field',
])

@livewire("lean::relations.hasmany.index", [
    'resultsPerPage' => $field->resultsPerPage,

    'parentRelation' => $field->name,
    'parentKey' => $field->value,

    'fieldGroup' => $field->fieldGroup,

    'resource' => $field->childResource,
    'parentResource' => $field->resource::alias(),
], key('lean-hasmany-' . $field->name))
