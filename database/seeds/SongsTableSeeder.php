<?php

use Illuminate\Database\Seeder;

use Ogae\Song;

class SongsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('songs')->truncate();

        $path = base_path('wk/songs.csv');
        $headers = [];

        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (empty($headers)) {
                  $headers = $data;
                }
                else {
                  $data = array_map('trim', $data);
                  $data = array_combine($headers, $data);
                  $data['semifinal'] = str_replace(['S', 'F'], '', $data['semifinal']) ?: null;
                  $data['semi_points'] = $data['semi_points'] ?: null;
                  $data['semi_place'] = $data['semi_place'] ?: null;
                  $data['semi_order'] = $data['semi_order'] ?: null;
                  $data['final_points'] = $data['final_points'] ?: null;
                  $data['final_place'] = $data['final_place'] ?: null;
                  $data['final_order'] = $data['final_order'] ?: null;
                  $song = Song::create($data);
                }
            }
            fclose($handle);
        }
    }
}
