<?php
const DISTRICTS_JSON_URL = 'https://data.cesko.digital/obce/1/obce.json';
const CACHED_JSON_FILE_PATH = './cache/districts.json';

function vdx(mixed $variable)
{
    header('Content-type: application/json');
    var_dump($variable);
    die;
}

function getDistrictOptions(): string
{
    $municipalitiesList = getMunicipalitiesList();
    $districts = [];

    foreach ($municipalitiesList->municipalities as $municipality) {
        $district = $municipality->adresaUradu->kraj;
        if(!empty($district)) {
            $districts[$district] = '<option>'.$district.'</option>';
        }
    }

    return implode('', $districts);
}

function getMunicipalitiesList(): stdClass
{
    if (isJsonFileCached()) {
        $jsonDistrictsFile = file_get_contents(CACHED_JSON_FILE_PATH);
    }
    if (empty($jsonDistrictsFile)) {
        $jsonDistrictsFile = file_get_contents(DISTRICTS_JSON_URL);
        cacheObtainedJsonFile($jsonDistrictsFile);
    }

    return json_decode($jsonDistrictsFile);
}

function cacheObtainedJsonFile(string $jsonDistrictsFile): void
{
    file_put_contents(CACHED_JSON_FILE_PATH, $jsonDistrictsFile);
}

function isJsonFileCached(): bool
{
    return file_exists(CACHED_JSON_FILE_PATH);
}

function getCitiesInTheDistrict(string $districtSelect): array
{
    $municipalitiesList = getMunicipalitiesList();
    $selectedMunicipalities = [];

    foreach ($municipalitiesList->municipalities as $municipality) {
        if($municipality->adresaUradu->kraj != $districtSelect) {
            continue;
        }
        $selectedMunicipalities[] = $municipality->nazev.' - '.$municipality->datovaSchrankaID;
    }

    return $selectedMunicipalities;
}

