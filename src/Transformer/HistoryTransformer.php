<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class HistoryTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'histoire') {
            $result = array_merge($result, $this->transformAccueil($data));
        }

        if (isset($data->data->body)) {
            foreach ($data->data->body as $bodyItem) {
                if ($bodyItem->slice_type === 'vignettes') {
                    $result['vignettes'] = $this->sliceTransformItems($bodyItem->items);
                }
            }
        }
        return $result;
    }


    private function transformAccueil($data): array
    {

        return [
            'subtitle' => RichText::asText($data->data->subtitle) ?? '',
            'description' => RichText::asText($data->data->description) ?? '',

        ];
    }

    private function sliceTransformItems($items): array
    {
        $slices = [];

        foreach ($items as $item) {

            $slices[] = [
                'image' => $item->image->url ?? '',
                'alt' => $item->image->alt ?? '',
                'title' => RichText::asText($item->title),
                'link' => RichText::asText($item->link),
               ];
        }

        return $slices;
    }

}
