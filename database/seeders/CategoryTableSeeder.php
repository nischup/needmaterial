<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name_en' => 'STEEL', 'name_ar' => 'الحديد', 'name_ur' => '', 'slug' => 'steel', 'icon' => '']);
        Category::insert([
            ['name_en' => 'DEFORM BARS', 'name_ar' => '   حديد مجدول', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'deform-bars'],
            ['name_en' => 'EPOXY DEFORM BARS', 'name_ar' => '  حديد مجدول ايبوكسي ', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'epoxy-deform-bars'],
            ['name_en' => 'HR STEEL PIPE', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'hr-steel-pipe'],
            ['name_en' => 'HR STEEL SHEETS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'hr-steel-sheets'],
            ['name_en' => 'HEA, HEB& H-JIS BEAMS HEA,HEB & H-JIS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'hea-heb-and-h-jis-beams-hea-heb-and-h-jis'],
            ['name_en' => 'IPE, IJIS,IPEAA BEAMS IPE, IJIS, IPEAA', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'ipe-ijis-ipeaa-beams-ipe-ijis-ipeaa'],
            ['name_en' => 'PLAIN STEEL REBARS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'plain-steel-rebars']
        ]);

        $category = Category::create(['name_en' => 'TIMBER', 'name_ar' => '', 'name_ur' => '', 'slug' => 'timber', 'icon' => '']);
        Category::insert([
            ['name_en' => 'PLYWOODS ORDINARY', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'playwoods-ordinary'],
            ['name_en' => 'PLYWOODS FILM FACED', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'playwoods-film-faced'],
            ['name_en' => 'RED WOOD', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'red-wood'],
            ['name_en' => 'WHITE WOOD', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'white-wood'],
            ['name_en' => 'WHITE WOOD AUSTRIAN & ROMANIAN', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'white-wood-austrian-and-romanian'],
            ['name_en' => 'WHITE WOOD GERMAN', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'white-wood-german'],
        ]);

        $category = Category::create(['name_en' => 'ELECTRICAL', 'name_ar' => '', 'name_ur' => '', 'slug' => 'electrical', 'icon' => '']);
        Category::insert([
            ['name_en' => 'BREAKERS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'breakers'],
            ['name_en' => 'CONDUITS PVC/PIPES & FITINGS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'conduits-pvc-pipes-and-fittings'],
            ['name_en' => 'CONDUITS METAL FLEXIBLE', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'conduits-metal-flexible'],
            ['name_en' => 'CONDUITS FLEXIBLE CORRUGATED', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'conduits-flexible-corrugated'],
            ['name_en' => 'ELECTRICAL CONNECTORS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'electrical-connectors'],
            ['name_en' => 'ELECTRICAL FANS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'electrical-fans'],
            ['name_en' => 'LOAD CENTERS & ENCLOSED MCCB', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'load-centers-and-enclosed-mccb'],
            ['name_en' => 'METAL BOXES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'metal-boxes'],
            ['name_en' => 'PVC BOXES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'pvc-boxes'],
            ['name_en' => 'PVC TAPES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'pvc-tapes'],
            ['name_en' => 'SOCKETS & SWITCHES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'sockets-and-switches'],
            ['name_en' => 'THHN WIRES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'thhn-wires'],
        ]);

        $category = Category::create(['name_en' => 'PLUMBING', 'name_ar' => '', 'name_ur' => '', 'slug' => 'plumbing', 'icon' => '']);

        Category::insert([
            ['name_en' => 'SCH-40 PIPES & FITTINGS SCH-40', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'sch-40-pipes-and-fittings-sch-40'],
            ['name_en' => 'SCH-80 PIPES & FITTINGS SCH-80 ', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'sch-80-pipes-and-fittings-sch-80'],
            ['name_en' => 'UPVC PIPES & FITTING', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'upvc-pipes-and-fitting'],
            ['name_en' => 'PPR PIPES & FITTINGS PPR', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'ppr-pipes-fittings-ppr'],
            ['name_en' => 'FLEXIBLE HOSES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'flexible-hoses'],
            ['name_en' => 'WATER PUMPS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'water-pumps'],
            ['name_en' => 'WATER HEATER', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'water-heater']
        ]);

        $category = Category::create(['name_en' => 'TOOLS & HARDWARE', 'name_ar' => '', 'name_ur' => '','slug' => 'tools-and-hardware', 'icon' => '']);
        Category::insert([
            ['name_en' => 'HAND TOOLS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'hand-tools'],
            ['name_en' => 'CONSTRUCTION MACHINERY', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'construction-machinery'],
            ['name_en' => 'POWER TOOLS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'power-tools'],
            ['name_en' => 'CUTTING DISCS & BLADES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'cutting-discs-and-blades'],
            ['name_en' => 'SAFETY ITEMS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'safety-items'],
            ['name_en' => 'ELECTRIC WELDERS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'electric-welders'],
            ['name_en' => 'PAINT BRUSH & ROLLERS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'paint-brush-and-rollers']
        ]);

        $category = Category::create(['name_en' => 'CONSTRUCTION MATERIALS', 'name_ar' => '', 'name_ur' => '', 'slug' => 'construction-materials', 'icon' => '']);
        Category::insert([
            ['name_en' => 'SAND & AGGREGATES', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'sand-and-aggregates'],
            ['name_en' => 'CEMENTS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'cements'],
            ['name_en' => 'BITUMEN', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'bitumen'],
            ['name_en' => 'GRAVEL', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'gravel'],
            ['name_en' => 'INSULATION ROLL', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'insulation-roll'],
            ['name_en' => 'GYPSOM BOARD', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'gypsom-board'],
            ['name_en' => 'RED BRICKS', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'red-bricks'],
            ['name_en' => 'TIE WIRE', 'name_ar' => '', 'name_ur' => '', 'parent_id' => $category->id, 'slug' => 'tie-wire']
        ]);
    }
}
