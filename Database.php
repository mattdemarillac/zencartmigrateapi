<?php

namespace Migrate;

// _dbauth.php needs to be created as such.
//trait dbauth
//{
//    private function setConnection()
//    {
//        $username = "admin";
//        $password = "addddmin";
//        $host = "127.0.0.1";
//        $db = 'zencartdb';
//
//        $this->db = new Database([
//            'driver' => 'mysql',
//            'hostname' => $host,
//            'username' => $username,
//            'password' => $password,
//            'database' => $db,
//            'timeout' => 999999999
//        ]);
//    }
//}
include "_dbauth.php";

use PicoDb\Database;

use Mapper\Mapper;
use Mapper\Definition;

class DatabaseMap
{
    use dbauth;
    /**
     * @var Database
     */
    public $db = null;

    /**
     * @var Mapper
     */
    private $mapper;

    public function __construct()
    {
        $this->setConnection();
        $this->mapper = new Mapper($this->db);
    }
    
    /**
     * NOTE: mysql in oob IS currently accepting all incoming connections !!!!!
     */
    public function productsMapper()
    {
        $tbl_products_description = (new Definition(
            'tbl_products_description',
            ['products_id']
        ))->withColumns(
            'products_id',
            'language_id',
            'products_name',
            'products_description',
            'products_url',
            'products_viewed'
        );

        $products = (new Definition(
            'tbl_products',
            ['products_id'])
        )->withOne($tbl_products_description, 'description', 'products_id', 'products_id'
        )->withColumns(
            'products_price',
            'products_quantity',
            'products_image'
        );

        return $this->mapper
            ->mapping($products);
    }

    public function categoriesMapper()
    {
        //Structure
        //tbl_categories

        $tbl_categories_description = (new Definition(
            'tbl_categories_description',
            ['categories_id']
        ))->withColumns(
            'categories_name',
            'categories_description'
        );

        $categories = (new Definition(
            'tbl_categories',
            ['categories_id'])
        )->withOne($tbl_categories_description, 'description', 'categories_id', 'categories_id'
        )->withColumns(
            'categories_id',
            'parent_id',
            'sort_order',
            'parent_id'
        );

        return $this->mapper
            ->mapping($categories)
            ->eq('categories_status', 1);
    }

    public function attributes_global () {
        $attribute_terms =  $tbl_categories_description = (new Definition(
            'tbl_products_options_values',
            ['products_options_values_id']
        ))->withColumns(
            'products_options_values_name'
        );

        $attributes_to_terms =  (new Definition(
            'tbl_products_options_values_to_products_options',
            ['products_options_values_to_products_options_id'])
        )->withMany($attribute_terms, 'terms', 'products_options_values_id', 'products_options_values_id'
        )->withColumns(
            'products_options_id',
            'products_options_values_id'
        );

        $attributes = (new Definition(
            'tbl_products_options',
            ['products_options_id'])
        )->withMany($attributes_to_terms, 'to_terms', 'products_options_id', 'products_options_id'
        )->withColumns(
            'products_options_id',
            'products_options_name'
        );

        return $this->mapper
            ->mapping($attributes);
    }

    /**
     * @param $text
     * @return false|string|string[]|null
     */
    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
