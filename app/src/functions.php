<?php

$basePath = __DIR__ . '/../';

// Data
require_once $basePath . 'src/Models/Company.php';

$companies = require $basePath . 'resources/data/companies.php';

echo showFilteredCompanies($companies, $argv[1]);

//Ophalen bedrijven adhv een zoekterm
function showFilteredCompanies(array $companies, string $term) : string{
    //Filter
    $companiesAsModels = convertCompaniesToModels($companies);
    $results = searchCompanies($term, $companiesAsModels);
    return exportToCsv($results, $term);
}

function convertCompaniesToModels(array $companies) : array{
    $companiesAsModels = [];
    foreach($companies as $company){
        $companiesAsModels[] = new Company($company['name'],$company['address'],$company['zip'],$company['city'],$company['activity'],$company['vat']);
    }
    return $companiesAsModels;
}

function searchCompanies(?string $term = '', array $companies) : array{
    $foundCompanies = [];
    foreach ($companies as $company){
        if(preg_match("/{$term}/i", $company->getName())){
            $foundCompanies[] = $company;
        }
    }
    return $foundCompanies;
}

//printen in tekst
function printCompaniesArray(array $companies) : string {
    $totalString = '';
    foreach($companies as $company){
        $totalString .= $company . PHP_EOL;
    }
    return $totalString;
}
//Haal een lijst van bedrijven op en exporteer ze in een csv file
function exportToCsv(array $companies, $term) : string{
    $filename = $term . date('ymd') . '.csv';
    $file = new SplFileObject(__DIR__ . '/../storage/' . $filename, 'w');
    if(count($companies) != 0){
        foreach ($companies as $fields) {
            $file->fputcsv((array) $fields);
        }
        return 'export succesvol';
    } else {
        return 'Geen bedrijven om te exporteren.';
    }
}
