<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class CraftTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'atelier') {
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
            'title' => RichText::asText($data->data->title) ?? '',
            'title2' => RichText::asText($data->data->title2) ?? '',
            'image' => $data->data->image->url ?? '',
            'alt' => $data->data->image->alt ?? '',
        ];
    }

    private function sliceTransformItems($items): array
    {
        $slices = [];

        foreach ($items as $item) {

            $slices[] = [

                'title' => RichText::asText($item->title1),
                'description' => RichText::asText($item->description),
                'price' => RichText::asText($item->price),
                'icon' => $item->icon->url ?? '',
                'alt' => $item->icon->alt ?? '',
               ];
        }

        return $slices;
    }

}
