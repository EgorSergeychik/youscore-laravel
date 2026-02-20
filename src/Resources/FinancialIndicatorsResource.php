<?php

namespace EgorSergeychik\YouScore\Resources;

use Illuminate\Http\Client\Response;

class FinancialIndicatorsResource extends AbstractResource
{
    /**
     * Allows to get a list of years for which there is information about the company's financial indicators.
     * To obtain financial data, you need to use the endpoint "Financial indicators for a specific year",
     * specifying a particular year as a parameter.
     *
     * @param string|int $contractorCode Company’s USREOU code
     * @return Response
     */
    public function getFinancialIndicatorsYears(string|int $contractorCode): Response
    {
        return $this->get("/v1/financialIndicators/$contractorCode");
    }

    /**
     * Allows quick access to annual information on a company’s financial status, performance results, and cash flow.
     * Each indicator in the response includes both “max” and “min” values, which have remained unchanged since 2020, and either value may be used.
     * Additionally, you can get quarterly financial data, details on the “Chief Accountant or another person authorised to sign reports”
     * with contact information, the date and time of report submission, the director’s name, the primary NACE code,
     * the KATOTTH code (territorial code indicating location), and the total number of employees
     *
     * @param string|int $contractorCode
     * @param string|int $year
     * @param string|int|null $month
     * @return Response
     */
    public function getFinancialIndicators(string|int $contractorCode, string|int $year, string|int|null $month = null): Response
    {
        return $this->get("/v1/financialIndicators/$contractorCode/years/$year", array_filter([
            'month' => $month,
        ]));
    }
}
