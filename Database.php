<?php

namespace Migrate;

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

    }
}
