<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class ItemSearch extends DataTemplate
{
    public function __construct()
    {
        $this->type = "item/search";
        $this->key_entry = "itemlist";
        $this->is_search = true;
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $str .= "Matched items:";

        foreach ($this->content['itemlist'] as $i => &$item) {
            $typestr = $item['typestr']['type'];

            if ($item['typestr']['subtype']) {
                $typestr .= ", ".$item['typestr']['subtype'];
            }

            if ($item['typestr']['loc']) {
                $typestr .= ", ".$item['typestr']['loc'];
            }

            $str .= sprintf("\n>%d. %s (%d/%s)", $i+1, $item['DisplayName'], $item['id'], $typestr);
        }

        return $this->parsed_content;
    }
}
