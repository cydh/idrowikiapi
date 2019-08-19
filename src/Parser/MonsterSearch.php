<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class MonsterSearch extends DataTemplate
{
    public function __construct()
    {
        $this->type = "monster/search";
        $this->key_entry = "moblist";
        $this->is_search = true;
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $str .= "Matched monsters:";

        foreach ($this->content['moblist'] as $i => $entry) {
            $str .= sprintf("\n%d. %s (%d / Lv. %d / %s / %s)", $i+1, $entry['Name'], $entry['ID'], $entry['LV'], $entry['Sprite_Name'], $entry['mobscale']);
        }

        return $this->parsed_content;
    }
}
