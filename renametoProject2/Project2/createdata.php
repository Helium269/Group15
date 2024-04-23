<?php
// Database configuration
$servername = "localhost"; 
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "flight_booking"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample airline codes
$airlineCodes = ['AA', 'DL', 'UA', 'WN', 'B6', 'AS', 'NK', 'F9', 'G4', 'HA'];

// Airport codes from your $airports array
$airportCodes = array_keys([
    'ABQ' => 'Albuquerque International Sunport (ABQ)',
    'ALB' => 'Albany International Airport (ALB)',
    'AMA' => 'Rick Husband Amarillo International Airport (AMA)',
    'ANC' => 'Ted Stevens Anchorage International Airport (ANC)',
    'ATL' => 'Hartsfield-Jackson Atlanta International Airport (ATL)',
    'AUS' => 'Austin-Bergstrom International Airport (AUS)',
    'AVL' => 'Asheville Regional Airport (AVL)',
    'BDL' => 'Bradley International Airport (BDL)',
    'BIL' => 'Billings Logan International Airport (BIL)',
    'BNA' => 'Nashville International Airport (BNA)',
    'BOI' => 'Boise Airport (BOI)',
    'BOS' => 'Logan International Airport (BOS)',
    'BUF' => 'Buffalo Niagara International Airport (BUF)',
    'BTV' => 'Burlington International Airport (BTV)',
    'BWI' => 'Baltimore/Washington International Thurgood Marshall Airport (BWI)',
    'CLE' => 'Cleveland Hopkins International Airport (CLE)',
    'CLT' => 'Charlotte Douglas International Airport (CLT)',
    'CMH' => 'John Glenn Columbus International Airport (CMH)',
    'CRP' => 'Corpus Christi International Airport (CRP)',
    'CRW' => 'Yeager Airport (CRW)',
    'CVG' => 'Cincinnati/Northern Kentucky International Airport (CVG)',
    'DAL' => 'Dallas Love Field (DAL)',
    'DAY' => 'Dayton International Airport (DAY)',
    'DCA' => 'Ronald Reagan Washington National Airport (DCA)',
    'DEN' => 'Denver International Airport (DEN)',
    'DFW' => 'Dallas/Fort Worth International Airport (DFW)',
    'DSM' => 'Des Moines International Airport (DSM)',
    'DTW' => 'Detroit Metropolitan Airport (DTW)',
    'ECP' => 'Northwest Florida Beaches International Airport (ECP)',
    'ELP' => 'El Paso International Airport (ELP)',
    'EWR' => 'Newark Liberty International Airport (EWR)',
    'FAI' => 'Fairbanks International Airport (FAI)',
    'FAR' => 'Hector International Airport (FAR)',
    'FAT' => 'Fresno Yosemite International Airport (FAT)',
    'FLL' => 'Fort Lauderdale-Hollywood International Airport (FLL)',
    'FWA' => 'Fort Wayne International Airport (FWA)',
    'GEG' => 'Spokane International Airport (GEG)',
    'GPT' => 'Gulfport-Biloxi International Airport (GPT)',
    'GRR' => 'Gerald R. Ford International Airport (GRR)',
    'GSO' => 'Piedmont Triad International Airport (GSO)',
    'GSP' => 'Greenville-Spartanburg International Airport (GSP)',
    'HNL' => 'Daniel K. Inouye International Airport (HNL)',
    'HOU' => 'William P. Hobby Airport (HOU)',
    'HSV' => 'Huntsville International Airport (HSV)',
    'IAH' => 'George Bush Intercontinental Airport (IAH)',
    'ICT' => 'Wichita Dwight D. Eisenhower National Airport (ICT)',
    'ILM' => 'Wilmington International Airport (ILM)',
    'IND' => 'Indianapolis International Airport (IND)',
    'JAC' => 'Jackson Hole Airport (JAC)',
    'JAN' => 'Jackson-Medgar Wiley Evers International Airport (JAN)',
    'JAX' => 'Jacksonville International Airport (JAX)',
    'JFK' => 'John F. Kennedy International Airport (JFK)',
    'JNU' => 'Juneau International Airport (JNU)',
    'KOA' => 'Kona International Airport (KOA)',
    'LAS' => 'McCarran International Airport (LAS)',
    'LAX' => 'Los Angeles International Airport (LAX)',
    'LEX' => 'Blue Grass Airport (LEX)',
    'LGA' => 'LaGuardia Airport (LGA)',
    'LIH' => 'Lihue Airport (LIH)',
    'LBB' => 'Lubbock Preston Smith International Airport (LBB)',
    'LGB' => 'Long Beach Airport (LGB)',
    'MCI' => 'Kansas City International Airport (MCI)',
    'MCO' => 'Orlando International Airport (MCO)',
    'MDW' => 'Chicago Midway International Airport (MDW)',
    'MEM' => 'Memphis International Airport (MEM)',
    'MFE' => 'McAllen Miller International Airport (MFE)',
    'MHT' => 'Manchester-Boston Regional Airport (MHT)',
    'MKE' => 'General Mitchell International Airport (MKE)',
    'MSP' => 'Minneapolis-Saint Paul International Airport (MSP)',
    'MSY' => 'Louis Armstrong New Orleans International Airport (MSY)',
    'MYR' => 'Myrtle Beach International Airport (MYR)',
    'OAK' => 'Oakland International Airport (OAK)',
    'OGG' => 'Kahului Airport (OGG)',
    'OKC' => 'Will Rogers World Airport (OKC)',
    'OMA' => 'Eppley Airfield (OMA)',
    'ONT' => 'Ontario International Airport (ONT)',
    'ORD' => 'O\'Hare International Airport (ORD)',
    'ORF' => 'Norfolk International Airport (ORF)',
    'PBI' => 'Palm Beach International Airport (PBI)',
    'PDX' => 'Portland International Airport (PDX)',
    'PHL' => 'Philadelphia International Airport (PHL)',
    'PHX' => 'Phoenix Sky Harbor International Airport (PHX)',
    'PIT' => 'Pittsburgh International Airport (PIT)',
    'PSC' => 'Tri-Cities Airport (PSC)',
    'PSP' => 'Palm Springs International Airport (PSP)',
    'PWM' => 'Portland International Jetport (PWM)',
    'RDM' => 'Redmond Municipal Airport (RDM)',
    'RDU' => 'Raleigh-Durham International Airport (RDU)',
    'RIC' => 'Richmond International Airport (RIC)',
    'RNO' => 'Reno-Tahoe International Airport (RNO)',
    'ROC' => 'Greater Rochester International Airport (ROC)',
    'RSW' => 'Southwest Florida International Airport (RSW)',
    'SAN' => 'San Diego International Airport (SAN)',
    'SAT' => 'San Antonio International Airport (SAT)',
    'SAV' => 'Savannah/Hilton Head International Airport (SAV)',
    'SBA' => 'Santa Barbara Airport (SBA)',
    'SBN' => 'South Bend International Airport (SBN)',
    'SBP' => 'San Luis Obispo County Regional Airport (SBP)',
    'SEA' => 'Seattle-Tacoma International Airport (SEA)',
    'SFO' => 'San Francisco International Airport (SFO)',
    'SGF' => 'Springfield-Branson National Airport (SGF)',
    'SJC' => 'Norman Y. Mineta San Jose International Airport (SJC)',
    'SJT' => 'San Angelo Regional Airport (SJT)',
    'SLC' => 'Salt Lake City International Airport (SLC)',
    'SMF' => 'Sacramento International Airport (SMF)',
    'SNA' => 'John Wayne Airport (SNA)',
    'SPI' => 'Abraham Lincoln Capital Airport (SPI)',
    'SRQ' => 'Sarasota-Bradenton International Airport (SRQ)',
    'STL' => 'St. Louis Lambert International Airport (STL)',
    'SYR' => 'Syracuse Hancock International Airport (SYR)',
    'TLH' => 'Tallahassee International Airport (TLH)',
    'TOL' => 'Toledo Express Airport (TOL)',
    'TPA' => 'Tampa International Airport (TPA)',
    'TUL' => 'Tulsa International Airport (TUL)',
    'TUS' => 'Tucson International Airport (TUS)',
    'TYS' => 'McGhee Tyson Airport (TYS)',
    'VPS' => 'Destin-Fort Walton Beach Airport (VPS)',
    'XNA' => 'Northwest Arkansas National Airport (XNA)',
    'YAK' => 'Yakutat Airport (YAK)',
    'YUM' => 'Yuma International Airport (YUM)'
]);

// Prepare SQL statement for inserting flights
$sql = "INSERT INTO flights (flight_number, origin, destination, departure_date, return_date, available_seats, price) VALUES ";
$values = [];

// Generate 10,000 flight records
for ($i = 0; $i < 10000; $i++) {
    $flightNumber = $airlineCodes[array_rand($airlineCodes)] . rand(100, 999); // Random flight number
    $origin = $airportCodes[array_rand($airportCodes)]; // Random origin airport code
    $destination = $airportCodes[array_rand($airportCodes)]; // Random destination airport code
    $departureDate = date('Y-m-d', strtotime('2024-04-01 +' . rand(0, 273) . ' days')); // Random departure date between April and December 2024
    $returnDate = date('Y-m-d', strtotime($departureDate . ' +' . rand(1, 10) . ' days')); // Return date is 1-10 days after departure
    $availableSeats = rand(50, 300); // Random number of available seats
    $price = rand(10000, 30000) / 100; // Random price between $100 and $300

    // Prepare values for the SQL statement
    $values[] = "('$flightNumber', '$origin', '$destination', '$departureDate', '$returnDate', $availableSeats, $price)";

    // Insert records in batches of 100 to improve performance
    if ($i > 0 && $i % 100 == 0) {
        $conn->query($sql . implode(', ', $values));
        $values = []; // Reset values array for the next batch
    }
}

// Insert remaining records (if any)
if (!empty($values)) {
    $conn->query($sql . implode(', ', $values));
}

echo "Flight data inserted successfully.";

// Close connection
$conn->close();
?>
