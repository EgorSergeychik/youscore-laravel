<?php

namespace EgorSergeychik\YouScore\Resources;

class RegistrationDataResource extends AbstractResource
{
    /**
     * Allows to obtain data from the United State Register of Legal Entities, Individual Entrepreneurs and Public Organizations of Ukraine (USR).
     * Data of legal entities or branches can be obtained under the USREOU code, FOP - under the RNOKPP (TIN) code, or passport, in case of refusal of the FOP from RNOCPP.
     *
     * @param string|int $contractorCode Company’s USREOU code, or FOP’s Taxpayer Identification Number, or a passport in format АА123456 or 123456789, if the FOP refused RNOKPP
     * @param bool $showCurrentData Optional parameter. If true, returns archived data (without updating information on the registry). This parameter can be used as an option for quick data filling, or for filling data when registries are not working.
     * @return array
     */
    public function getUnitedStateRegisterData(string|int $contractorCode, bool $showCurrentData = false): array
    {
        return $this->get("/v1/usr/{$contractorCode}", [
            'show_current_data' => $showCurrentData ? 'true' : 'false',
        ]);
    }
}
