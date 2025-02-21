<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class TestimonialTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'avis') {
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
            'subtitle' => RichText::asText($data->data->subtitle) ?? '',

        ];
    }

    private function sliceTransformItems($items): array
    {
        $slices = [];

        foreach ($items as $item) {

            $slices[] = [
               'image' => $item->image->url ?? '',
                'alt' => $item->image->alt ?? '',
                'name' => RichText::asText($item->name),
                'description' => RichText::asText($item->description),
               ];
        }

        return $slices;
    }

}
