<?php

namespace App\Transformer;

    use Prismic\Dom\RichText;

class CategoriesTransformer
{
    public function transformCategory($category): array
    {
        return [
            'uid' => $category->uid ?? '',
            'name' => RichText::asText($category->data->name ?? []),
        ];
    }

    public function transformProduct($product): array
    {
        return [
            'title' => RichText::asText($product->data->title ?? []),
            'price' => RichText::asText($product->data->price ?? []),
            'image' => $product->data->image->url ?? '',
            'alt' => $product->data->image->alt ?? '',
            'categoryUid' => $product->data->category->uid ?? '', // Relation avec la catégorie
        ];
    }

    public function groupProductsByCategory(array $categories, array $products): array
    {
        $result = [];
        foreach ($categories as $category) {
            $result[$category['uid']] = [
                'category' => $category,
                'products' => array_filter(
                    $products,
                    fn($product) => $product['categoryUid'] === $category['uid']
                ),
            ];
        }
        return $result;
    }
}
