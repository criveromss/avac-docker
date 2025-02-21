<?php

namespace App\Transformer;

use Prismic\Dom\RichText;

class ContactTransformer
{

    public function transform($data): array
    {
        $result = [];

        if ($data === null) {
            return $result;
        }


        if ($data->type === 'contact') {
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
            'title3' => RichText::asText($data->data->title3) ?? '',
            'subtitle2' => RichText::asText($data->data->subtitle2) ?? '',
            'description' => RichText::asText($data->data->description) ?? '',
            'span' => RichText::asText($data->data->span) ?? '',
            'phone' => RichText::asText($data->data->phone) ?? '',
            'span2' => RichText::asText($data->data->span2) ?? '',
            'mail' => RichText::asText($data->data->mail) ?? '',
            'span3' => RichText::asText($data->data->span3) ?? '',
            'hours' => RichText::asText($data->data->hours) ?? '',
            'image' => $data->data->image->url ?? '',

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
