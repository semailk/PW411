<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn(
            [
                'name' => 'avatar', // The db column name
                'label' => 'Аватар', // Table column heading
                'type' => 'image',
                'prefix' => 'storage/',
                // image from a different disk (like s3 bucket)
                // 'disk'   => 'disk-name',
                // optional width/height if 25px is not ok with you
                'height' => '200px',
                'width' => '300px',
            ],
        );
        CRUD::setFromDb();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb();

        CRUD::field([   // select_from_array
            'name' => 'role',
            'label' => "Роль",
            'type' => 'select_from_array',
            'options' => ['user' => 'Пользлователь', 'admin' => 'Админ'],
            'allows_null' => false,
            'default' => 'user',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        CRUD::field([
            'name' => 'avatar',
            'label' => 'Аватар',
            'type' => 'upload',
            'withFiles' => true
        ]);
    }

    protected function setupUpdateOperation()
    {
//        $this->setupCreateOperation();

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => "ФИО",
                'type' => 'text',
            ], [
                'name' => 'email',
                'label' => 'Имейл',
                'type' => 'email'
            ],
            [
                'name' => 'role',
                'label' => "Роль",
                'type' => 'select_from_array',
                'options' => ['user' => 'Пользлователь', 'admin' => 'Админ'],
                'allows_null' => false,
                'default' => 'user',
            ],
            [
                'name' => 'current_image',
                'label' => 'Текущие изображения',
                'type' => 'view',
                'view' => 'admin.image-preview',
                'tab' => 'Основное',
            ],
            [
                'name' => 'avatar',
                'label' => 'Аватар',
                'type' => 'upload',
                'withFiles' => true,
            ]
        ]);

        CRUD::field([  // Select
            'label'     => "Телефон",
            'type'      => 'select',
            'name'      => 'phone_id', // the db column for the foreign key

            // optional
            // 'entity' should point to the method that defines the relationship in your Model
            // defining entity will make Backpack guess 'model' and 'attribute'
            'entity'    => 'phone',

            // optional - manually specify the related model and attribute
            'model'     => "App\Models\Phone", // related model
            'attribute' => 'phone', // foreign key attribute that is shown to user

            // optional - force the related options to be a custom query, instead of all();
            'options'   => (function ($query) {
                return $query->orderBy('phone', 'ASC')->get();
            }), //  you can use this to filter the results show in the select
        ]);
    }
}
