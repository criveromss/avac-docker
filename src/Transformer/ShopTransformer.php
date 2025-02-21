<?php

namespace App\Transformer;

use App\Services\PrismicApiService;
use Prismic\Dom\RichText;

class ShopTransformer
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
        return [
            'id' => $article->id,
            'slug' => $article->uid,
            'title' => RichText::asText($article->data->title)  ?? [],
            'description' => RichText::asHtml($article->data->description) ?? [],
            'side_description' => RichText::asHtml($article->data->side_description),
            'format' => RichText::asText($article->data->format),
            'image' => $article->data->image->url ?? null,
            'altImage' => $article->data->image->alt ?? null,
            'publishedAt' => $article->first_publication_date ?? null,
            'date' => $article->data->date ?? null,
            'price' => RichText::asText($article->data->price) ?? [],
        ];
    }
}
