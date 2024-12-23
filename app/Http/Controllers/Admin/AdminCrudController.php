<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AdminCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud                                  
 */
class AdminCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Admin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin');
        CRUD::setEntityNameStrings('admin', 'admins');

        $this->crud->setTitle('職員管理');
        $this->crud->setHeading('職員管理');
        $this->crud->setSubheading('新規登録', 'create');
        $this->crud->setSubheading('編集', 'edit');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->data['breadcrumbs'] = [
            'ダッシュボード' => backpack_url('dashboard'),
            '職員管理' => backpack_url('admin'),
            '一覧' => false,
        ];

        CRUD::column('id')->label('職員番号');
        CRUD::column('name')->label('氏名');
        CRUD::column('category_id')
            ->label('診療科')
            ->type('select')
            ->entity('categories')
            ->attribute('name')
            ->model("App\Models\Category")
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('categories', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%'.$searchTerm.'%');
                });
            });
        CRUD::column('email')->label('email');

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->data['breadcrumbs'] = [
            'ダッシュボード' => backpack_url('dashboard'),
            '職員管理' => backpack_url('admin'),
            '新規登録' => false,
        ];

        CRUD::field('name')->label('職員氏名')->validationRules('required');
        CRUD::field('category_id')
            ->label('診療科')
            ->type('select')
            ->entity('categories')
            ->attribute('name')
            ->model("App\Models\Category")
            ->validationRules('required');
        CRUD::field('email')->label('email')->validationRules('required|email|unique:users,email');
        CRUD::field('password')->type('password')->label('パスワード')->validationRules('required');

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->data['breadcrumbs'] = [
            'ダッシュボード' => backpack_url('dashboard'),
            '職員管理' => backpack_url('user'),
            '編集' => false,
        ];

        $this->setupCreateOperation();
    }

    protected function autoSetupShowOperation()
    {
        $this->data['breadcrumbs'] = [
            'ダッシュボード' => backpack_url('dashboard'),
            '職員管理' => backpack_url('user'),
            '詳細' => false,
        ];

        $this->setupListOperation();
    }
}
