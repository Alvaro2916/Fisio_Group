<?php
function is_valid_tipo(string $tipo): bool
{
    switch ($tipo) {
        case 'vacuna':
            return true;
            break;
        case 'virus':
            return true;
            break;
        case 'animal':
            return true;
            break;
        case 'planta':
            return true;
            break;
        case 'elemental':
            return true;
            break;
    }

    return false;
}

function HayNulos(array $camposNoNulos, array $arrayDatos): array
{
    $nulos = [];
    foreach ($camposNoNulos as $index => $campo) {
        if (!isset($arrayDatos[$campo]) || empty($arrayDatos[$campo]) || $arrayDatos[$campo] == null) {
            $nulos[] = $campo;
        }
    }
    return $nulos;
}

function existeValor(array $array, string $campo, mixed $valor): bool
{
    return in_array($array[$campo], $valor);
}

function DibujarErrores($errores, $campo)
{
    $cadena = "";
    if (isset($errores[$campo])) {
        $last = end($errores);
        foreach ($errores[$campo] as $indice => $msgError) {
            $salto = ($errores[$campo] == $last) ? "" : "<br>";
            $cadena .= "{$msgError}.{$salto}";
        }
    }
    return $cadena;
}

function is_valid_email($str)
{
    return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
}
