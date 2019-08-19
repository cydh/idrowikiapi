<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class ItemDroplist extends DataTemplate
{
    public function __construct()
    {
        $this->type = "item/droplist";
        $this->key_entry = "item";
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $str .= sprintf("**Item**: '%s'/'%s' (%d)", $this->content['item']['DisplayName'], $this->content['item']['AegisName'], $this->content['item']['id']);
        $str .= sprintf("\n**Type**: %s", $this->content['typestr']['type']);

        if (!empty($this->content['typestr']['subtype'])) {
            $str .= ", ".$this->content['typestr']['subtype'];
        }

        if (!empty($this->content['typestr']['loc'])) {
            $str .= ", ".$this->content['typestr']['loc'];
        }

        if (empty($this->content['moblist'])) {
            $str .= "\nTidak dijatuhkan oleh monster.";
        } else {
            $str .= "\nDrop dari monster:";
            foreach ($this->content['moblist'] as $i => &$mob) {
                $str .= sprintf("\n%d. %s (%d / Lv. %d / %s / %s)", $i+1, $mob['Name'], $mob['ID'], $mob['LV'], $mob['Sprite_Name'], $mob['mobscale']);
            }
        }
        return $this->parsed_content;
    }

    private function removeColorTag($str, $replace_with = '')
    {
        return preg_replace('/\^\d{6}/', $replace_with, $str);
    }
}
