<form class="flex flex-col space-y-4" wire:submit.prevent="submit">
    <div class="sm:divide-y divide-solid divide-gray-200 dark:divide-gray-700">
        @foreach($this->fields as $field)
            <div>
                <x-lean::field-group :field="$field" :errors="$errors->get($field->name)">
                    <x-lean::field
                        :field="$field"
                        :wire:model.lazy='"fieldMetadata.{$field->name}.value"'
                    />
                </x-lean::field-group>
            </div>
        @endforeach
    </div>

    <div class="flex justify-end">
        <x-lean::button class="flex justify-center w-full sm:w-auto" design="outline" type="submit">
            {{ $this->resource()::trans('bulk_edit.submit') }}
        </x-lean::button>
    </div>
</form>
