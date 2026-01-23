<?php

namespace EgorSergeychik\YouScore\Resources;

use Illuminate\Http\Client\Response;

class RegistrationDataResource extends AbstractResource
{
    /**
     * Allows to obtain data from the United State Register of Legal Entities, Individual Entrepreneurs and Public Organizations of Ukraine (USR).
     * Data of legal entities or branches can be obtained under the USREOU code, FOP - under the RNOKPP (TIN) code, or passport, in case of refusal of the FOP from RNOCPP.
     *
     * @param string|int $contractorCode Company’s USREOU code, or FOP’s Taxpayer Identification Number, or a passport in format АА123456 or 123456789, if the FOP refused RNOKPP
     * @param bool $showCurrentData Optional parameter. If true, returns archived data (without updating information on the registry). This parameter can be used as an option for quick data filling, or for filling data when registries are not working.
     * @return Response
     */
    public function getUnitedStateRegisterData(string|int $contractorCode, bool $showCurrentData = false): Response
    {
        return $this->get("/v1/usr/{$contractorCode}", [
            'show_current_data' => $showCurrentData ? 'true' : 'false',
        ]);
    }


    /**
     * Allows you to get data on the history of changes: the name of the legal entity, contact information, managers,
     * the main activity, the list of founders (participants) of the legal entity, the size of the authorized capital.
     *
     * @param string|int $contractorCode Company’s USREOU code
     * @return Response
     */
    public function getChangesHistory(string|int $contractorCode): Response
    {
        return $this->get("/v1/history/{$contractorCode}");
    }

    /**
     * Allows you to obtain information about the owners of significant blocks of shares of issuers of securities
     * from the National Commission for Securities and the Stock Market. The data of legal entities can be obtained by the USREOU code
     *
     * @param string|int $contractorCode Company’s USREOU code
     * @param bool $addHistory Add history data
     * @return Response
     */
    public function getSignificantShareholders(string|int $contractorCode, bool $addHistory = false): Response
    {
        return $this->get("/v1/shareholders/{$contractorCode}", [
            'add_history' => $addHistory ? 'true' : 'false',
        ]);
    }

    /**
     * Allows to receive the result of providing administrative services,
     * in particular to receive founding documents of the counterparty (Charter).
     *
     * @param string|int $code Unique access code contained in document descriptions (issued after January 1, 2016)
     * @return Response
     */
    public function getFoundingDocuments(string|int $code): Response
    {
        return $this->get("/v1/usrAdministrativeServicesResults/{$code}");
    }


    /**
     * Allows to receive information about the ownership structure of a counterparty by the USREOU code.
     *
     * @param string|int|null $code Company’s USREOU code
     * @return Response
     */
    public function getOwnershipStructure(string|int|null $code = null): Response
    {
        return $this->get("/v1/usrDocuments/usrOwnershipStructureFile", [
            'code' => $code,
        ]);
    }

    /**
     * Allows to receive the founding documents of a counterparty (Charter) by the USREOU code.
     *
     * @param string|int|null $code Company’s USREOU code
     * @return Response
     */
    public function getCharter(string|int|null $code = null): Response
    {
        return $this->get("/v1/usrDocuments/usrStatutFile", [
            'code' => $code,
        ]);
    }
}
