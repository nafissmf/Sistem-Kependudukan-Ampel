<?php

namespace App\Http\Requests;

class StoreHouseRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('rumah.create');
    }

    public function rules(): array
    {
        return [
            'house_number' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'village_id' => ['nullable', 'uuid', 'exists:villages,id'],
            'hamlet_id' => ['nullable', 'uuid', 'exists:hamlets,id'],
            'rt_rw_id' => ['nullable', 'uuid', 'exists:rt_rw,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'gps_accuracy' => ['nullable', 'numeric', 'min:0'],
            'land_area' => ['nullable', 'numeric', 'min:0'],
            'building_area' => ['nullable', 'numeric', 'min:0'],
            'roof_type_id' => ['nullable', 'uuid', 'exists:roof_types,id'],
            'wall_type_id' => ['nullable', 'uuid', 'exists:wall_types,id'],
            'floor_type_id' => ['nullable', 'uuid', 'exists:floor_types,id'],
            'bedroom_count' => ['nullable', 'integer', 'min:0', 'max:50'],
            'bathroom_count' => ['nullable', 'integer', 'min:0', 'max:50'],
            'house_status_id' => ['nullable', 'uuid', 'exists:house_statuses,id'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
