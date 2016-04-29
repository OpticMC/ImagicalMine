<?php
/**
 * src/pocketmine/item/Tool.php
 *
 * @package default
 */


/*
 *
 *  _                       _           _ __  __ _
 * (_)                     (_)         | |  \/  (_)
 *  _ _ __ ___   __ _  __ _ _  ___ __ _| | \  / |_ _ __   ___
 * | | '_ ` _ \ / _` |/ _` | |/ __/ _` | | |\/| | | '_ \ / _ \
 * | | | | | | | (_| | (_| | | (_| (_| | | |  | | | | | |  __/
 * |_|_| |_| |_|\__,_|\__, |_|\___\__,_|_|_|  |_|_|_| |_|\___|
 *                     __/ |
 *                    |___/
 *
 * This program is a third party build by ImagicalMine.
 *
 * PocketMine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ImagicalMine Team
 * @link http://forums.imagicalcorp.ml/
 *
 *
*/


namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\item\enchantment\Enchantment;

abstract class Tool extends Item
{
    const TIER_WOODEN = 1;
    const TIER_GOLD = 2;
    const TIER_STONE = 3;
    const TIER_IRON = 4;
    const TIER_DIAMOND = 5;

    const TYPE_NONE = 0;
    const TYPE_SWORD = 1;
    const TYPE_SHOVEL = 2;
    const TYPE_PICKAXE = 3;
    const TYPE_AXE = 4;
    const TYPE_SHEARS = 5;

    /**
     *
     * @param unknown $id
     * @param unknown $meta  (optional)
     * @param unknown $count (optional)
     * @param unknown $name  (optional)
     */
    public function __construct($id, $meta = 0, $count = 1, $name = "Unknown")
    {
        parent::__construct($id, $meta, $count, $name);
    }


    /**
     *
     * @return unknown
     */
    public function getMaxStackSize()
    {
        return 1;
    }


    /**
     * TODO: Move this to each item
     *
     *
     * @param Entity|Block $object
     * @return bool
     */
    public function useOn($object)
    {
        if ($this->isUnbreakable()) {
            return false;
        }

        $break = true;

        if (($ench = $this->getEnchantment(Enchantment::TYPE_MINING_DURABILITY)) != null) {
            $rnd = mt_rand(1, 100);
            if ($rnd <= 100 / ($ench->getLevel() + 1)) {
                $break = false;
            }
        }

        if ($object instanceof Block) {
            if (!$break) {
                return false;
            }
            if (
                $object->getToolType() === Tool::TYPE_PICKAXE and $this->isPickaxe() or
                $object->getToolType() === Tool::TYPE_SHOVEL and $this->isShovel() or
                $object->getToolType() === Tool::TYPE_AXE and $this->isAxe() or
                $object->getToolType() === Tool::TYPE_SWORD and $this->isSword() or
                $object->getToolType() === Tool::TYPE_SHEARS and $this->isShears()
            ) {
                $this->meta++;
            } elseif (!$this->isShears() and $object->getBreakTime($this) > 0) {
                $this->meta += 2;
            }
        } elseif ($this->isHoe()) {
            if (!$break) {
                return false;
            }
            if (($object instanceof Block) and ($object->getId() === self::GRASS or $object->getId() === self::DIRT)) {
                $this->meta++;
            }
        } elseif (($object instanceof Entity)) {
            $return = true;

            if (!$this->isSword()) {
                if ($break) {
                    $this->meta += 2;
                    $return = false;
                }
            } else {
                if ($break) {
                    $this->meta++;
                    $return = false;
                }

                if (!$this->hasEnchantments()) {
                    return $return;
                }

                //TODO: move attacking from player class here
                //$fire = $this->getEnchantment(Enchantment::TYPE_WEAPON_FIRE_ASPECT);

                //$object->setOnFire($fire->getLevel() * 4);
            }
        }

        return true;
    }


    /**
     *
     * @return unknown
     */
    public function isUnbreakable()
    {
        $tag = $this->getNamedTagEntry("Unbreakable");
        return $tag !== null and $tag->getValue() > 0;
    }


    /**
     *
     * @return unknown
     */
    public function isPickaxe()
    {
        return false;
    }


    /**
     *
     * @return unknown
     */
    public function isAxe()
    {
        return false;
    }


    /**
     *
     * @return unknown
     */
    public function isSword()
    {
        return false;
    }


    /**
     *
     * @return unknown
     */
    public function isShovel()
    {
        return false;
    }


    /**
     *
     * @return unknown
     */
    public function isHoe()
    {
        return false;
    }


    /**
     *
     * @return unknown
     */
    public function isShears()
    {
        return $this->id === self::SHEARS;
    }


    /**
     *
     * @return unknown
     */
    public function isTool()
    {
        return $this->id === self::FLINT_STEEL or $this->id === self::SHEARS or $this->id === self::BOW or $this->isPickaxe() !== false or $this->isAxe() !== false or $this->isShovel() !== false or $this->isSword() !== false;
    }



    /**
     *
     * @param unknown $target
     * @return unknown
     */
    public function getDamageStep($target)
    {
        return 1;
    }
}
