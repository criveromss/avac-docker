<?php


namespace App\Services;

use Prismic\Api;
use Prismic\Predicates;

class PrismicApiService
{
    private Api $api;

    public function __construct()
    {
        $this->api = Api::get($_ENV['PRISMIC_API']);
    }

    public function getByType(
        string $type,
        int $pageSize = 100,
        int $page = 1
    )
    {
        return $this->api->query(
            Predicates::at('document.type', $type), [
            'pageSize' => $pageSize,
            'page' => $page,
            'orderings' => "[my.{$type}.date desc]"
        ]);
    }

    public function getBySingleType(string $type)
    {
        return $this->api->getSingle($type);
    }

    public function getBySingleTypeWithoutCache(string $type)
    {
        return $this->api->getSingle($type);
    }

    public function getById(string $id)
    {
        return $this->api->getByID($id);
    }

    public function getByUid(string $type, string $uid)
    {
        return $this->api->getByUID($type, $uid);
    }

    public function getByUidWithoutCache(string $type, string $uid)
    {
        return $this->api->getByUID($type, $uid);
    }

    public function getAllByType(string $type)
    {
        return $this->api->query(Predicates::any('document.type', [$type]));
    }

    public function getByField(string $type, string $title, string $field)
    {
        return $this->api->query(Predicates::any(
            "my.{$type}.$field",
            [$title]
        ));
    }
}
