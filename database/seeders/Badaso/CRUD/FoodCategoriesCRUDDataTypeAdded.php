<?php

namespace Database\Seeders\Badaso\CRUD;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Facades\Badaso;
use Uasoft\Badaso\Models\MenuItem;

class FoodCategoriesCRUDDataTypeAdded extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        \DB::beginTransaction();

        try {

            $data_type = Badaso::model('DataType')->where('name', 'food_categories')->first();

            if ($data_type) {
                Badaso::model('DataType')->where('name', 'food_categories')->delete();
            }

            \DB::table('badaso_data_types')->insert(array (
                'name' => 'food_categories',
                'slug' => 'food-categories',
                'display_name_singular' => 'Food Categories',
                'display_name_plural' => 'Food Categories',
                'icon' => 'menu_book',
                'model_name' => NULL,
                'policy_name' => NULL,
                'controller' => NULL,
                'order_column' => NULL,
                'order_display_column' => NULL,
                'order_direction' => NULL,
                'generate_permissions' => true,
                'server_side' => false,
                'description' => NULL,
                'details' => NULL,
                'notification' => '[]',
                'is_soft_delete' => false,
                'updated_at' => '2023-06-28T06:32:45.000000Z',
                'created_at' => '2023-06-28T06:32:45.000000Z',
                'id' => 4,
            ));

            Badaso::model('Permission')->generateFor('food_categories');

            $menu = Badaso::model('Menu')->where('key', config('badaso.default_menu'))->firstOrFail();

            $menu_item = Badaso::model('MenuItem')
                ->where('menu_id', $menu->id)
                ->where('url', '/general/food-categories')
                ->first();

            $order = Badaso::model('MenuItem')->highestOrderMenuItem($menu->id);

            if (!is_null($menu_item)) {
                $menu_item->fill([
                    'title' => 'Food Categories',
                    'target' => '_self',
                    'icon_class' => 'menu_book',
                    'color' => null,
                    'parent_id' => null,
                    'permissions' => 'browse_food_categories',
                    'order' => $order,
                ])->save();
            } else {
                $menu_item = new MenuItem();
                $menu_item->menu_id = $menu->id;
                $menu_item->url = '/general/food-categories';
                $menu_item->title = 'Food Categories';
                $menu_item->target = '_self';
                $menu_item->icon_class = 'menu_book';
                $menu_item->color = null;
                $menu_item->parent_id = null;
                $menu_item->permissions = 'browse_food_categories';
                $menu_item->order = $order;
                $menu_item->save();
            }

            \DB::commit();
        } catch(Exception $e) {
            \DB::rollBack();

           throw new Exception('Exception occur ' . $e);
        }
    }
}
