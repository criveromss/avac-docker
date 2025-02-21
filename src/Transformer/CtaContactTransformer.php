<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class CtaContactTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'cta-contact') {
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
            'description' => RichText::asHtml($data->data->description ?? ''),
            'image' => $data->data->logo->url ?? '',
            'alt' => $data->data->logo->alt ?? '',
            'link' => RichText::asText($data->data->link ?? ''),
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
