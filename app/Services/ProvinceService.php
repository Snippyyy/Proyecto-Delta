<?php

namespace App\Services;

class ProvinceService
{
    /**
     * Devuelve una lista de provincias.
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            "Álava/Araba", "Albacete", "Alicante", "Almería", "Asturias",
            "Ávila", "Badajoz", "Baleares", "Barcelona", "Burgos",
            "Cáceres", "Cádiz", "Cantabria", "Castellón", "Ceuta",
            "Ciudad Real", "Córdoba", "Cuenca", "Gerona/Girona", "Granada",
            "Guadalajara", "Guipúzcoa/Gipuzkoa", "Huelva", "Huesca", "Jaén",
            "La Coruña/A Coruña", "La Rioja", "Las Palmas", "León", "Lérida/Lleida",
            "Lugo", "Madrid", "Málaga", "Melilla", "Murcia",
            "Navarra", "Orense/Ourense", "Palencia", "Pontevedra", "Salamanca",
            "Segovia", "Sevilla", "Soria", "Tarragona", "Tenerife",
            "Teruel", "Toledo", "Valencia", "Valladolid", "Vizcaya/Bizkaia",
            "Zamora", "Zaragoza"
        ];
    }
}
