<?php

namespace App\Services;

use App\Services\PrismicApiService;
use Prismic\Dom\RichText;

class CarTransformer
{
    public function transform($data): array
    {

        $articles = [];

        if (is_iterable($data)) {
            foreach ($data as $article) {
                $articles[] = $this->transformItem($article);
            }
            return $articles;
        }

        return [$this->transformItem($data)];
    }

    private function transformItem($article): array
    {
        $images = [];

        // Parcours du body pour récupérer les images si présentes
        if (!empty($article->data->body)) {
            foreach ($article->data->body as $slice) {
                if ($slice->slice_type === 'vignettes' && !empty($slice->items)) {
                    foreach ($slice->items as $item) {
                        if (isset($item->image)) {
                            $images[] = $item->image->url ?? null;  // Ajout de l'URL de l'image
                        }
                    }
                }
            }
        }

        return [
            'id' => $article->id,
            'slug' => $article->uid,
            'link' => RichText::asText($article->data->link) ?? [],
            'type' => RichText::asText($article->data->type) ?? [],
            'year' => RichText::asText($article->data->year) ?? [],
            'kilometers' => RichText::asText($article->data->kilometers) ?? [],
            'ch' => RichText::asText($article->data->hp) ?? [],
            'carbody' => RichText::asText($article->data->carbody) ?? [],
            'motor' => RichText::asText($article->data->motor) ?? [],
            'transmission' => RichText::asText($article->data->transmission) ?? [],
            'gearbox' => RichText::asText($article->data->gearbox) ?? [],
            'place' => RichText::asText($article->data->place) ?? [],
            'price' => RichText::asText($article->data->price) ?? [],
            'title' => RichText::asText($article->data->title) ?? [],
            'description' => RichText::asHtml($article->data->description) ?? [],
            'history' => RichText::asHtml($article->data->history) ?? [],
            'technic' => RichText::asHtml($article->data->technic) ?? [],
            'images' => array_filter($images),  // Ajout des images extraites
        ];
    }
}
