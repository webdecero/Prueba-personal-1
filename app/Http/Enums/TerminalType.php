<?php
namespace App\Http\Enums;


enum TerminalType: string
{
    case Kiosk = 'kiosk';
    case Registry = 'registry';
    case Torniquet = 'torniquet';
}
