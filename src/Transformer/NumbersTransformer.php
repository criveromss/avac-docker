<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class NumbersTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }

        if ($data->type === 'numbers') {
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
                'numbers' => RichText::asText($item->numbers) ?? '',
                'text' => RichText::asText($item->text) ?? '',
               ];
        }

        return $slices;
    }

}
