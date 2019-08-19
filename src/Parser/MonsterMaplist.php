<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class MonsterMaplist extends DataTemplate
{
    public function __construct()
    {
        $this->type = "monster/maplist";
        $this->key_entry = "monster";
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $mob = &$this->content['monster'];
        $str .= sprintf("**Monster**: %s / %s / ID:%d", $mob['Name'], $mob['Sprite_Name'], $mob['ID']);
        $str .= sprintf("\nLv.: %d / Scale: %s / Race: %s / Element: %s %d", $mob['LV'], $mob['mobscale'], $mob['mobrace'], $mob['mobele']['ele'], $mob['mobele']['eleLv']);

        if (empty($this->content['map'])) {
            $str .= "\n**Not spawn normally**";
        } else {
            $str .= "\n**Spawn maps:**";
            foreach ($this->content['map'] as $i => &$map) {
                $str .= sprintf("\n> %dx @%s (%s)", $map['count'], $map['name'], $this->spawnDelay($map['spawn1'], $map['spawn2']));
            }
        }

        return $this->parsed_content;
    }

    private function spawnDelay($delay1, $delay2)
    {
        $instant = true;
        $arr1 = [];
        $arr2 = [];
        foreach ($delay1 as $key => $val) {
            if ($val) {
                $instant = false;
                $arr1[] = $val;
                $arr1[] = $key;
            }
        }
        foreach ($delay2 as $key => $val) {
            if ($val) {
                $instant = false;
                $arr2[] = $val;
                $arr2[] = $key;
            }
        }

        return $instant ? "Instant" : implode(" ", $arr1).' ~ '.implode(" ", $arr2);
    }
}
