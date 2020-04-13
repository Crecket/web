<?php

/*
 * This file is part of SeAT
 *
 * Copyright (C) 2015 to 2020 Leon Jacobs
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace Seat\Web\Http\DataTables\Corporation\Intel;

use Seat\Eveapi\Models\Assets\CorporationAsset;
use Seat\Web\Http\DataTables\Common\IColumn;
use Seat\Web\Http\DataTables\Common\Intel\AbstractAssetDataTable;
use Seat\Web\Http\DataTables\Corporation\Columns\AssetStationColumn;

/**
 * Class AssetDataTable.
 *
 * @package Seat\Web\Http\DataTables\Corporation\Intel
 */
class AssetDataTable extends AbstractAssetDataTable
{
    const IGNORED_FLAGS = [
        // generic fitting flags
        'Cargo',
        'DroneBay',
        'HiSlot0', 'HiSlot1', 'HiSlot2', 'HiSlot3', 'HiSlot4', 'HiSlot5', 'HiSlot6', 'HiSlot7',
        'MedSlot0', 'MedSlot1', 'MedSlot2', 'MedSlot3', 'MedSlot4', 'MedSlot5', 'MedSlot6', 'MedSlot7',
        'LoSlot0', 'LoSlot1', 'LoSlot2', 'LoSlot3', 'LoSlot4', 'LoSlot5', 'LoSlot6', 'LoSlot7',
        'RigSlot0', 'RigSlot1', 'RigSlot2', 'RigSlot3', 'RigSlot4', 'RigSlot5', 'RigSlot6', 'RigSlot7',
        // tech 3 fitting flags
        'SubSystemSlot0', 'SubSystemSlot1', 'SubSystemSlot2', 'SubSystemSlot3', 'SubSystemSlot4', 'SubSystemSlot5', 'SubSystemSlot6', 'SubSystemSlot7',
        // capitals fitting flags
        'FighterBay', 'FleetHangar', 'SpecializedFuelBay', 'ShipHangar',
        // structure fitting flags
        'FighterTube0', 'FighterTube1', 'FighterTube2', 'FighterTube3', 'FighterTube4', 'FighterTube5', 'FighterTube6', 'FighterTube7',
        'ServiceSlot0', 'ServiceSlot1', 'ServiceSlot2', 'ServiceSlot3', 'ServiceSlot4', 'ServiceSlot5', 'ServiceSlot6', 'ServiceSlot7',
        'StructureFuel',
        // office elements
        'OfficeFolder', 'Impounded',
    ];

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        return CorporationAsset::with('type', 'type.group', 'station', 'container', 'container.station', 'container.container')
            ->whereNotIn('location_flag', self::IGNORED_FLAGS); // fitted items will be rendered using fitting modal
    }

    /**
     * @return \Seat\Web\Http\DataTables\Common\IColumn
     */
    protected function getStationColumn(): IColumn
    {
        return new AssetStationColumn();
    }
}
