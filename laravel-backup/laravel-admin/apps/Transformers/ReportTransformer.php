<?php

namespace App\Transformers;

use App\Report;
use League\Fractal\TransformerAbstract;

/**
 * Class ReportTransformer
 * @package App\Transformers
 */
class ReportTransformer extends TransformerAbstract
{
    /**
     * @param Report $report
     * @return array
     */
    public function transform(Report $report)
    {
        return [
            'carId' => $report->car_id,
            'inappropriate' => (boolean)$report->inappropriate,
            'misleading' => (boolean)$report->misleading,
            'spam' => (boolean)$report->spam,
            'other' => (boolean)$report->other,
            'reason' => isset($report->reason) ? $report->reason : null,
        ];
    }
}
