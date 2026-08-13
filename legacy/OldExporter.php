<?php

namespace Probe\Legacy;

/**
 * Superseded by Probe\InvoiceExporter. Kept until the last caller is migrated.
 */
class OldExporter
{
    public function totals(array $invoices): string
    {
        $sum = 0.0;

        foreach ($invoices as $invoice) {
            $sum += $invoice['total'];
        }

        return number_format($sum, 2, '.', '');
    }
}
