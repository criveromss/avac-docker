<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class CibleTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'cibles') {
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
                'title' => RichText::asText($item->title),
                'link' => RichText::asText($item->link),
                'image' => $item->image->url ?? '',
                'alt' => $item->image->alt ?? '',
               ];
        }

        return $slices;
    }

}
