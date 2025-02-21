<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class SophieTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'sophie') {
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
            'description' => RichText::asHtml($data->data->description) ?? '',
            'image1' => $data->data->image1->url ?? '',
            'alt1' => $data->data->image2->alt ?? '',
            'image2' => $data->data->image2->url ?? '',
            'alt2' => $data->data->image2->alt ?? '',
        ];
    }

    private function sliceTransformItems($items): array
    {
        $slices = [];

        foreach ($items as $item) {

            $slices[] = [

               ];
        }

        return $slices;
    }

}
