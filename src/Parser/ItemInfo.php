<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class ItemInfo extends DataTemplate
{
    public function __construct()
    {
        $this->type = "item/info";
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

        if (!empty($this->content['Description'])) {
            foreach ($this->content['Description'] as $line) {
                $str .= "\n> ".$this->removeColorTag($line, "**");
            }
        }

        $str .= sprintf("\n**Buy Price**: %s / Discount %s", number_format($this->content['price']['buy'], 0, ',', '.'), number_format($this->content['price']['discount'], 0, ',', '.'));
        $str .= sprintf("\n**Sell Price**: %s / Discount %s", number_format($this->content['price']['sell'], 0, ',', '.'), number_format($this->content['price']['overcharge'], 0, ',', '.'));

        if (!empty($this->content['moblist'])) {
            $mob = &$this->content['moblist'][0];
            $str .= sprintf("\n**Drop:** (most) %s/%s (ID: %d) Lv. %d. Total: %d mobs", $mob['Name'], $mob['Sprite_Name'], $mob['ID'], $mob['LV'], count($this->content['moblist']));
        }

        return $this->parsed_content;
    }

    private function removeColorTag($str, $replace_with = '')
    {
        return preg_replace('/\^\d{6}/', $replace_with, $str);
    }
}
