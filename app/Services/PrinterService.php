<?php

namespace App\Services;

class PrinterService
{
    public static function getActivePrinterName(): string
    {
        $detected = self::detectThermalPrinter();
        if ($detected) {
            return $detected;
        }

        $env = env('PRINTER_NAME');
        if ($env) {
            return $env;
        }

        return 'POS-58';
    }

    private static function detectThermalPrinter(): ?string
    {
        $output = shell_exec('powershell -command "Get-Printer | Select-Object -ExpandProperty Name" 2>NUL');
        if (!$output) {
            return null;
        }

        $lines = array_filter(array_map('trim', explode("\n", $output)));
        $keywords = ['POS', '58', '80', 'Thermal', 'Printer', 'EPSON'];

        foreach ($lines as $line) {
            foreach ($keywords as $kw) {
                if (stripos($line, $kw) !== false) {
                    return $line;
                }
            }
        }

        return null;
    }
}
