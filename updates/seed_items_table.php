<?php namespace IIS\Inventory\Updates;

use IIS\Inventory\Models\Item;
use Seeder;

class SeedItemsTable extends Seeder
{
    public function run()
    {
        $item = Item::create([
            'category'          => 'jets',
            'serial'            => '204',
            'year'              => '2008',
            'make'              => 'Gulfstream',
            'model'             => 'G200',
            'registration'      => 'N982MM',
            'description'       => '1- Jet Speed Aviation Inc. is pleased to offer Gulfstream G200, Serial Number 204 to the marketplace for immediate sale.',
            'log'               => '- Total Airframe Hours Since New: 5627 - Total Airframe Landings Since New: 3473',
            'engine'            => '- ESP Gold Engine Program, Pratt and Whitney 306A - #1 TSN 6313 CSN 3928 PCE-CC0337 - #2 TSN 5627 CSN 3473 PCE-CC0428 - Honeywell GTCP36 150 APU: 3520 Hours on MSP ',
            'avionics'          => '- Collins Pro Line 4 EFIS Avionics Suite - WAAS Enhanced Navigation and ADS B Upgrade 2016 - Dual Collins ADC-850 Air Data Computers - Dual Collins AHC-3000 Attitude Heading Reference System - Collins FCC-4005 Auto Pilot - Dual Collins FMC-6100 Flight Management Computers with Dual GPS 4000 - Dual Collins RTU-4220 Radio Tuning Units - Dual Collins VHF-4000E Comm Computers - Collins NAV-4500 (VOR/ILS) Computer - Collins NAV-4000 (VOR/ILS/ADF) Computer - Dual Collins DME-4000 - Dual Collins TDR-94D Mode “S” Transponders with Flight ID - Collins TCAS 4000 Traffic Alert Collision Avoidance System with Change 7 - Collins TRW-850 Weather Radar - Collins ALT-4000 Radio Altimeter - Dual Honeywell KHF-950 HF Radio with Jetcal SELCAL - Honeywell Mark V EGPWS ',
            'features'          => '- WAAS Enhanced Navigation / ADS-B Upgrade 2016 - Aircell ATG 5000 High Speed Internet - Aircell Axxess II SATCOM System - RVSM - Honeywell SSCVR 120 Minute - Artex C406 MHz ELT - Honeywell AFIS - Airshow 400 Inflight Information System - CD & DVD System with Aft Mounted Monitor and Single Seat Monitors',
            'interior'          => '- 2014 Passenger Seats Recovered, Interior Completed December 2008 by Gulfstream Dallas. Fireblocked 9 Passenger Executive Interior Features 4 Executive Club Chairs with Pull out Tables. The Left Aft Cabin Features a 3 Place Divan Opposite a 2 Place Executive Club. Forward Galley and Aft Lav - Entertainment Features Airshow 400 Flight Information System, Multi Region DVD, AFT Monitor and ATG 5000 WIFI ',
            'exterior'          => '- New Paint, June 2014 by Aerosmith Aviation, Overall Matterhorn White. New Custom Accent Stripes September 2016 by Rose Aircraft in Ming Blue and Titanium Silver Metallic.',
            'maintenance'       => 'Gulfstream G-CMP Maintenance Tracking Program',
            'inspections'       => '- 1A Due 5826 Hours 1C Due 07/2017 - 2A Due 5831 Hours 2C Due 06/2018 - 3A Due 5852 Hours 3C Due 09/2017 - 4A Due 5855 Hours 4C Due 06/2020 - 5A Due Hours 6C Due 09/2020 - 6A Due 5828 Hours 8C Due 06/2024 - 8A Due 7855 Hours 12C Due 06/2020 ',
            'comments'          => 'SPECIFICATIONS SUBJECT TO VERIFICATION UPON INSPECTION. AIRCRAFT SUBJECT TO PRIOR SALE OR WITHDRAWAL FROM MARKET.',
            'price'             => 5795000.00,
            'is_published'       => '1',

        ]);

        $item = Item::create([
            'category'          => 'jets',
            'serial'            => '203',
            'year'              => '2007',
            'make'              => 'Gulfstream',
            'model'             => 'G200',
            'registration'      => 'N983MM',
            'description'       => '2- Jet Speed Aviation Inc. is pleased to offer Gulfstream G200, Serial Number 204 to the marketplace for immediate sale.',
            'log'               => '- Total Airframe Hours Since New: 5627 - Total Airframe Landings Since New: 3473',
            'engine'            => '- ESP Gold Engine Program, Pratt and Whitney 306A - #1 TSN 6313 CSN 3928 PCE-CC0337 - #2 TSN 5627 CSN 3473 PCE-CC0428 - Honeywell GTCP36 150 APU: 3520 Hours on MSP ',
            'avionics'          => '- Collins Pro Line 4 EFIS Avionics Suite - WAAS Enhanced Navigation and ADS B Upgrade 2016 - Dual Collins ADC-850 Air Data Computers - Dual Collins AHC-3000 Attitude Heading Reference System - Collins FCC-4005 Auto Pilot - Dual Collins FMC-6100 Flight Management Computers with Dual GPS 4000 - Dual Collins RTU-4220 Radio Tuning Units - Dual Collins VHF-4000E Comm Computers - Collins NAV-4500 (VOR/ILS) Computer - Collins NAV-4000 (VOR/ILS/ADF) Computer - Dual Collins DME-4000 - Dual Collins TDR-94D Mode “S” Transponders with Flight ID - Collins TCAS 4000 Traffic Alert Collision Avoidance System with Change 7 - Collins TRW-850 Weather Radar - Collins ALT-4000 Radio Altimeter - Dual Honeywell KHF-950 HF Radio with Jetcal SELCAL - Honeywell Mark V EGPWS ',
            'features'          => '- WAAS Enhanced Navigation / ADS-B Upgrade 2016 - Aircell ATG 5000 High Speed Internet - Aircell Axxess II SATCOM System - RVSM - Honeywell SSCVR 120 Minute - Artex C406 MHz ELT - Honeywell AFIS - Airshow 400 Inflight Information System - CD & DVD System with Aft Mounted Monitor and Single Seat Monitors',
            'interior'          => '- 2014 Passenger Seats Recovered, Interior Completed December 2008 by Gulfstream Dallas. Fireblocked 9 Passenger Executive Interior Features 4 Executive Club Chairs with Pull out Tables. The Left Aft Cabin Features a 3 Place Divan Opposite a 2 Place Executive Club. Forward Galley and Aft Lav - Entertainment Features Airshow 400 Flight Information System, Multi Region DVD, AFT Monitor and ATG 5000 WIFI ',
            'exterior'          => '- New Paint, June 2014 by Aerosmith Aviation, Overall Matterhorn White. New Custom Accent Stripes September 2016 by Rose Aircraft in Ming Blue and Titanium Silver Metallic.',
            'maintenance'       => 'Gulfstream G-CMP Maintenance Tracking Program',
            'inspections'       => '- 1A Due 5826 Hours 1C Due 07/2017 - 2A Due 5831 Hours 2C Due 06/2018 - 3A Due 5852 Hours 3C Due 09/2017 - 4A Due 5855 Hours 4C Due 06/2020 - 5A Due Hours 6C Due 09/2020 - 6A Due 5828 Hours 8C Due 06/2024 - 8A Due 7855 Hours 12C Due 06/2020 ',
            'comments'          => 'SPECIFICATIONS SUBJECT TO VERIFICATION UPON INSPECTION. AIRCRAFT SUBJECT TO PRIOR SALE OR WITHDRAWAL FROM MARKET.',
            'price'             => 4795000.00,
            'is_published'       => '1',

        ]);
    }
}