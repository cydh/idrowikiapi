<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class MapSearch extends DataTemplate
{
    public function __construct()
    {
        $this->type = "map/search";
        $this->key_entry = "maplist";
        $this->is_search = true;
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $str .= "Matched maps:";

        foreach ($this->content['maplist'] as $i => $entry) {
            $str .= "\n".($i+1).". ".$entry['desc']." / ".$entry['name']." (Mobs:".($entry['monster_num'] ? $entry['monster_num'] : "None").")";
        }

        return $this->parsed_content;
    }
}
