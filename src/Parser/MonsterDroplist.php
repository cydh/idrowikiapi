<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class MonsterDroplist extends DataTemplate
{
    public function __construct()
    {
        $this->type = "monster/droplist";
        $this->key_entry = "monster";
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $mob = &$this->content['monster'];
        $str .= sprintf("**Monster**: %s / %s / ID:%d", $mob['Name'], $mob['Sprite_Name'], $mob['ID']);
        $str .= sprintf("\nLv.: %d / Scale: %s / Race: %s / Element: %s %d", $mob['LV'], $mob['mobscale'], $mob['mobrace'], $mob['mobele']['ele'], $mob['mobele']['eleLv']);

        if (!empty($this->content['drop'])) {
            $str .= "\n**Normal items:**";
            foreach ($this->content['drop'] as $i => &$item) {
                $typestr = $item['typestr']['type'];

                if ($item['typestr']['subtype']) {
                    $typestr .= ", ".$item['typestr']['subtype'];
                }

                if ($item['typestr']['loc']) {
                    $typestr .= ", ".$item['typestr']['loc'];
                }

                $str .= sprintf("\n>%s%% %s (%d/%s)", number_format($item['rate'] / 100, 2, ',', '.'), $item['DisplayName'], $item['id'], $typestr);
            }
        } else {
            $str .= "\n**Doesn't drop item**";
        }

        if (!empty($this->content['mvp'])) {
            $str .= "\n**MVP Rewards:**";
            foreach ($this->content['mvp'] as $i => &$item) {
                $typestr = $item['typestr']['type'];

                if ($item['typestr']['subtype']) {
                    $typestr .= ", ".$item['typestr']['subtype'];
                }

                if ($item['typestr']['loc']) {
                    $typestr .= ", ".$item['typestr']['loc'];
                }

                $str .= sprintf("\n>%s%% %s (%d/%s)", number_format($item['rate'] / 100, 2, ',', '.'), $item['DisplayName'], $item['id'], $typestr);
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
