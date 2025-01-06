<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
        $this->crud->setTitle('生徒管理');
        $this->crud->setHeading('生徒管理');
    }

    protected function setupListOperation()
    {

        CRUD::column('student_id')->label('生徒番号');
        CRUD::column('name')->label('生徒名');
        // CRUD::column('created_at')->label('作成日');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation([
            'student_id' => 'required|integer',
            'name' => 'required|string',
            'password' => 'required',
        ]);

        CRUD::field('student_id')->label('生徒番号')->type('number');
        CRUD::field('name')->label('生徒名');
        CRUD::field('password')->label('パスワード')->type('password');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
    {
        request()->merge(['password' => bcrypt(request('password'))]);
        return $this->traitStore();
    }

    public function update()
    {
        if (request('password')) {
            request()->merge(['password' => bcrypt(request('password'))]);
        } else {
            request()->request->remove('password');
        }
        return $this->traitUpdate();
    }
}