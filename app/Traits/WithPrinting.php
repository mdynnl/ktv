<?php

namespace App\Traits;

trait WithPrinting
{
    public function printToPDF($view, $data, $date, $name, $orientation = 'L')
    {
        $printOutTime = now()->format('Y_m_d_Hi');
        $pdf = \PDF::loadView($view, compact('data', 'date'), [], [
            'orientation' => $orientation,
            'use_kwt' => true
        ]);

        $name = "{$printOutTime}_$name.pdf";
        $pdf->save(storage_path("app/$name"));

        return route('pdf', $name);
    }
}
