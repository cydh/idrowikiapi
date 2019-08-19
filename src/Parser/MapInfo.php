<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class MapInfo extends DataTemplate
{
    public function __construct()
    {
        $this->type = "map/info";
        $this->key_entry = "map";
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $str .= sprintf("**Map**: %s / %s", $this->content['map']['desc'], $this->content['map']['name']);

        if (empty($this->content['moblist'])) {
            $str .= "\n**Monster**: None";
        } else {
            $str .= sprintf("\n**Monster**: %d", count($this->content['moblist']));
            foreach ($this->content['moblist'] as $i => &$mob) {
                $str .= sprintf("\n%dx %s (%d / Lv. %d / %s / EXP: %s/%s)", $mob['count'], $mob['Name'], $mob['ID'], $mob['LV'], $mob['mobscale'], number_format($mob['EXP'], 0, ',', '.'), number_format($mob['JEXP'], 0, ',', '.'));
            }
        }

        $str .= sprintf("\n**Shop NPC**: %d", count($this->content['shop']));

        return $this->parsed_content;
    }
}
