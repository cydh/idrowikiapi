<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Parser\DataTemplate;

class MonsterInfo extends DataTemplate
{
    public function __construct()
    {
        $this->type = "monster/info";
        $this->key_entry = "monster";
    }

    public function parse()
    {
        $str = &$this->parsed_content;
        $mob = &$this->content['monster'];
        $str .= sprintf("**Monster**: %s / %s / ID:%d", $mob['Name'], $mob['Sprite_Name'], $mob['ID']);
        $str .= sprintf("\nLv.: %d / Scale: %s / Race: %s / Element: %s %d", $mob['LV'], $mob['mobscale'], $mob['mobrace'], $mob['mobele']['ele'], $mob['mobele']['eleLv']);
        $str .= sprintf("\nHP: %s / EXP: %s / JEXP: %s", number_format($mob['HP'], 0, ',', '.'), number_format($mob['EXP'], 0, ',', '.'), number_format($mob['JEXP'], 0, ',', '.'));
        if (!empty($mob['MEXP'])) {
            $str .= sprintf("\n**MVP** EXP: %s", number_format($mob['MEXP'], 0, ',', '.'));
        }
        $stats = &$mob['stats'];
        $str .= sprintf("\nParameter: %d / %d / %d / %d / %d / %d", $stats['str'], $stats['agi'], $stats['vit'], $stats['int'], $stats['dex'], $stats['luk']);
        $str .= sprintf("\nATK: %s ~ %s / MATK: %s ~ %s / DEF: %s / MDEF: %s", number_format($stats['atk1'], 0, ',', '.'), number_format($stats['atk2'], 0, ',', '.'), number_format($stats['matk1'], 0, ',', '.'), number_format($stats['matk2'], 0, ',', '.'), number_format($stats['def'], 0, ',', '.'), number_format($stats['mdef'], 0, ',', '.'));

        $attr = &$mob['attr_fix'];
        $str .= "\n**Element Properties**";
        $str .= sprintf("\nNeutral: %d%% / Water: %d%% / Earth: %d%% / Fire: %d%% / Wind: %d%%", $attr['neutral'], $attr['water'], $attr['earth'], $attr['fire'], $attr['wind']);
        $str .= sprintf("\nPoison: %d%% / Holy: %d%% / Shadow: %d%% / Ghost: %d%% / Undead: %d%%", $attr['poison'], $attr['holy'], $attr['shadow'], $attr['ghost'], $attr['undead']);

        return $this->parsed_content;
    }
}
