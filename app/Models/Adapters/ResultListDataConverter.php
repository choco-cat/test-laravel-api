<?php

namespace App\Models\Adapters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ResultListDataConverter
{
    /**
     * Adapt Top results list data for response
     *
     * @param Collection|Model $data
     * @return Collection
     */
    public function convert(Collection|Model $data): Collection
    {
        if ($data instanceof Model) {
            return collect([$this->mapResultsCollection($data)]);
        }

        return $data->map(fn($item, $key) => $this->mapResultsCollection($item));
    }

    /**
     * Callback for mapping Results Collection
     *
     * @param $item
     * @return array
     */
    private function mapResultsCollection($item): array
    {
        return [
            'email' => $this->halfEmailHide($item->member->email),
            'place' => $item->place,
            'milliseconds' => $item->milliseconds,
        ];
    }

    /**
     * Hides characters in email
     *
     * @param string $email
     * @return string
     */
    private function halfEmailHide(string $email): string
    {
        return preg_replace_callback(
            '/([^@]{2,})([^@]*)@/',
            fn($matches) => substr($matches[1], 0, floor(strlen($matches[1]) / 2))
                . str_repeat('*', ceil(strlen($matches[1]) / 2)) . '@',
            $email
        );
    }
}
