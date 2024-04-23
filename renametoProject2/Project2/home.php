<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

// Define an array of major American airports (replace with your actual airport data)
$airports = [
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
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Homepage</title>
    <link rel="stylesheet" href="home.css">
    <script>
        // Function to show or hide return date field based on trip type selection
        function toggleReturnDateField() {
            const tripType = document.querySelector('input[name="trip_type"]:checked').value;
            const returnDateGroup = document.getElementById('return-date-group');

            if (tripType === 'two-way') {
                returnDateGroup.style.display = 'block';
            } else {
                returnDateGroup.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>AeroOptimize</h1>
        <!-- Navigation menu if needed -->
    </header>
    <section class="search">
        <div class="container">
            <form action="search.php" method="POST">
                <div class="form-group">
                    <label>Trip Type:</label><br>
                    <input type="radio" id="one-way" name="trip_type" value="one-way" checked onclick="toggleReturnDateField()">
                    <label for="one-way">One Way</label><br>
                    <input type="radio" id="two-way" name="trip_type" value="two-way" onclick="toggleReturnDateField()">
                    <label for="two-way">Two Way</label>
                </div>
                <div class="form-group">
                    <label for="origin">Origin:</label>
                    <select name="origin" id="origin" required>
                        <option value="">Select Origin Airport</option>
                        <?php
                            // Loop through airports array to populate options
                            foreach ($airports as $code => $name) {
                                echo "<option value='{$code}'>{$name}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <select name="destination" id="destination" required>
                        <option value="">Select Destination Airport</option>
                        <?php
                            // Loop through airports array to populate options
                            foreach ($airports as $code => $name) {
                                echo "<option value='{$code}'>{$name}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="depart-date">Departure Date:</label>
                    <input type="date" id="depart-date" name="depart_date" required>
                </div>
                <div class="form-group" id="return-date-group" style="display:none;">
                    <label for="return-date">Return Date:</label>
                    <input type="date" id="return-date" name="return_date">
                </div>
                <div class="form-group">
                    <label for="passengers">Passengers:</label>
                    <input type="number" id="passengers" name="passengers" min="1" max="10" required>
                </div>
                <button type="submit">Search</button>
            </form>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Flight Booking. All rights reserved.</p>
    </footer>

    <script>
        // Call toggleReturnDateField initially to set the initial display of return date field
        toggleReturnDateField();
    </script>
</body>
</html>
