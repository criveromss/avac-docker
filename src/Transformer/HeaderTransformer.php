<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class HeaderTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'header') {
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

        ];
    }

    private function sliceTransformItems($items): array
    {
        $slices = [];

        foreach ($items as $item) {

            $slices[] = [

                'subtitle' => RichText::asText($item->subtitle),
                'title' => RichText::asText($item->title),
                'image' => $item->image->url ?? '',
                'alt' => $item->image->alt ?? '',
               ];
        }

        return $slices;
    }

}
