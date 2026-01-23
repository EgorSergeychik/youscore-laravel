<?php

namespace EgorSergeychik\YouScore\Resources;

use Illuminate\Http\Client\Response;

class ExpressAnalysisResource extends AbstractResource
{
    /**
     * Express Analysis is an analytical scoring indicator that sums up the results of the company Express Analysis
     * and instantly indicates the recommended level of attention to pay for further research of the company.
     * Checks the company for the presence of a non-financial risk, in particular for fictitiousness and negative reputation.
     * Risk indicators are formed based on the recommendations of the Central Bank of Ukrain and best international practices.
     *
     * @param string|int $contractorCode Company’s USREOU code or FOP’s Taxpayer Identification Number
     * @param bool $showCurrentData Optional parameter, if True, then returns archived data (without updating the registry information). This parameter can be used as an option to quickly fill in data, or to fill in data when registries are not working.
     * @param bool $showPrompt Optional parameter, if the value is True, then the value in field “prompt” is factor description. If there is no showPrompt parameter or value is False, then value is “null”
     * @return Response
     */
    public function getExpressAnalysis(string|int $contractorCode, bool $showCurrentData = false, bool $showPrompt = false): Response
    {
        return $this->get("/v1/expressAnalysis/{$contractorCode}", [
            'showCurrentData' => $showCurrentData ? true : 'false',
            'showPrompt' => $showPrompt ? 'true' : 'false',
        ]);
    }

    /**
     * Express Analysis: Financial Monitoring is a tool designed to support compliance with financial monitoring regulations in Ukraine.
     * Under the law, banks, non-banking financial institutions, and other entities subject to primary financial monitoring
     * are obliged to identify, assess, and continuously monitor risks related to the laundering of criminal proceeds, the financing of terrorism, and/or the funding of weapons of mass destruction.
     * Risk assessment must also extend to individuals and entities associated with the client, including directors, shareholders, beneficial owners, and counterparties.
     * Determining that a client presents a high level of risk may lead to serious consequences, including the suspension of financial transactions,
     * freezing of assets, termination of business relationships, or referral of information regarding potential offences to law enforcement or other relevant authorities.
     * For this reason, it is crucial for any business to detect potential risks in advance and exercise appropriate due diligence when working with counterparties.
     * To identify such risks, our endpoint provides approximately 500 caution factors. These factors are not risks in themselves, but help draw attention to signs that may indicate them.
     * The caution factors available through the Express Analysis: Financial Monitoring endpoint serve as a decision-support tool, enabling entities engaged in financial monitoring to operate responsibly and in full compliance with current legislation.
     *
     * @param string|int $contractorCode Company’s USREOU code or FOP’s Taxpayer Identification Number
     * @param bool $showCurrentData Optional parameter, if True, then returns archived data (without updating the registry information). This parameter can be used as an option to quickly fill in data, or to fill in data when registries are not working.
     * @param bool $showPrompt Optional parameter, if the value is True, then the value in field “prompt” is factor description. If there is no showPrompt parameter or value is False, then value is “null”
     * @return Response
     */
    public function getFinancialMonitoring(string|int $contractorCode, bool $showCurrentData = false, bool $showPrompt = false): Response
    {
        return $this->get("/v1/expressAnalysis/finmon/{$contractorCode}", [
            'showCurrentData' => $showCurrentData ? true : 'false',
            'showPrompt' => $showPrompt ? 'true' : 'false',
        ]);
    }

    /**
     * Express Analysis Aggressors - checks a company and alerts about the presence of any connections with russia - an aggressor state and countries that support it.
     * This helps identify potential reputational and other consequences when working with such companies, as well as take necessary measures to prevent them in a timely manner.
     * Some of the EA factors are available only to identified users, please verify your identity to access them.
     *
     * @param string|int $contractorCode Company’s USREOU code or FOP’s Taxpayer Identification Number
     * @param bool $showCurrentData Optional parameter, if True, then returns archived data (without updating the registry information). This parameter can be used as an option to quickly fill in data, or to fill in data when registries are not working.
     * @param bool $showPrompt Optional parameter, if the value is True, then the value in field “prompt” is factor description. If there is no showPrompt parameter or value is False, then value is “null”
     * @return Response
     */
    public function getAggressors(string|int $contractorCode, bool $showCurrentData = false, bool $showPrompt = false): Response
    {
        return $this->get("/v1/expressAnalysis/aggressors/{$contractorCode}", [
            'showCurrentData' => $showCurrentData ? true : 'false',
            'showPrompt' => $showPrompt ? 'true' : 'false',
        ]);
    }
}
